<?php

namespace App\Models;

use App\Enums\CustomerType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EdBooking extends Model
{
    protected $table = 'ed_booking';
    protected $primaryKey = 'booking_id';
    public $incrementing = false;
    protected $guarded = [''];
    // 定义数据库自动写入时间字段
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    // 过滤字段
    protected $fillable = ['ref_no','booking_no','customer_id'];
    // 主键ID的“类型”。
    protected $keyType = 'string';
    public static $customer_id; //用户角色类型

    /**
     * 获取用户相关权限
     */
    public function __construct()
    {
        self::$customer_id = Auth::user()->ed_customer_customer_id;
        if (!self::$customer_id) {
            false;
        }
    }

    /**
     * @return 一对多关联detail表
     */
    public function details()
    {
        return $this->hasMany('App\Models\EdBookingDetail', 'booking_id', 'booking_id');
    }

    /**
     * @param $requestData 控制器传递参数
     * @return 返回ed_booking相关数据
     */
    public function queryList($requestData)
    {
        if (Arr::has($requestData, ['start_time', 'end_time'])){
            return $this->queryListWithinTime($requestData);
        }
        return $this->queryListWithoutTime($requestData);
    }

    // 封装查询booking的时候有筛选时间的方法
    private function queryListWithinTime($requestData)
    {
        // 需要过滤page和page_limit查询条件
        $filterCondition = Arr::except($requestData, ['page', 'page_limit', 'start_time', 'end_time']);
        //如果登录用户不是admin则将附加判断用户类型，同理若是则无需变动返回所有数据
        if(self::$customer_id != CustomerType::admin ){
            $filterCondition['customer_id'] = Auth::user()->ed_customer_customer_id;
        }
        return self::where($filterCondition)
            ->whereBetween('create_date', [$requestData['start_time'], $requestData['end_time']])
            ->distinct()
            ->orderBy('create_date', 'DESC')
            ->paginate($requestData['page_limit']);
    }
    // 封装查询booking的时候没有筛选时间的方法
    private function queryListWithoutTime($requestData)
    {
        // 需要过滤page和page_limit查询条件
        $filterCondition = Arr::except($requestData, ['page', 'page_limit']);
        // 同上queryListWithinTime()方法一样
        if(self::$customer_id != CustomerType::admin ){
            $filterCondition['customer_id'] = Auth::user()->ed_customer_customer_id;
        }
        return self::where($filterCondition)->distinct()->orderBy('create_date', 'DESC')->paginate($requestData['page_limit']);
    }

    /**
     * @param $requestData 控制器传递参数
     * @return 返回ed_booking关联的ed_booking_detail表相关数据
     */
    public function queryDetailList($requestData)
    {
        //强烈提示：以后数据库主外键设计需要严格遵照国际化标准，如表A主键为'id'，AB表相互关联则表B外键为'a_id'的形式
        //若AB表相关联出现相同字段，会出现join查询报bug等错误

        $filter_condition = Arr::except($requestData, ['page', 'page_limit']);
        // 这里采用关联查询,传入闭包函数并传入关联的join实例和外部参数，在join实例内进行条件筛选再将筛选后的数据排序、筛选、去重、分页输出
//        return  $this->join('ed_booking_detail',function ($join) use ($requestData){
//                $join->on('ed_booking.booking_id','=','ed_booking_detail.booking_id')
//                    ->where(['ed_booking_detail.ref_no'=>$requestData['ref_no']]);
//                })->orderBy('booking_date','DESC')
//                    ->select('ed_booking_detail.*','booking_date','order_qty')
//                    ->distinct()
//                    ->paginate($requestData['page_limit']);
//        return $this->join('ed_booking_detail','ed_booking_detail.booking_id','=','ed_booking.booking_id')
////                    ->where(['ed_booking_detail.booking_id'=>$requestData['booking_id']])
//                    ->orderBy('booking_date','DESC')
//                    ->select('ed_booking_detail.*','booking_date','order_qty')
//                    ->distinct()
//                    ->paginate($requestData['page_limit']);
        if(isset($requestData['booking_id'])){
            // return EdBooking::find($requestData['booking_id'])->details()->distinct()->paginate();
            return EdBooking::with('details')->whereBookingId($requestData['booking_id'])->first();
        }
        return null;

    }

    /**
     * 添加入库单
     * @param $requestData
     * @return bool|string
     */
    public function queryAdd($requestData)
    {
        try {
            DB::beginTransaction(); // 开启事务
            //先写入主库booking库再写入从库detail库--注意主库的order_qty是对detail表的qty_case数目统计，而detail表的qty_case是每件货物的数量
            $filterData = Arr::except($requestData,['booking_detail','booking_detail_total']);
            $filterData['booking_id'] = Str::uuid();
            $bookingInsert = $this->insert($filterData);

            // 根据生成的uui号批量新增数据到从表(booking_detail)
            // 由于此处调用lumen的关联新增无效，所以采用了普通写法
            $detailArr = [];
            foreach ($requestData['booking_detail'] as $value){  // 前端传递数据体内数据居然是嵌套json，所以不得不循环取出解码再回传到新数组
                // 首先解码
                $detailArr[] = json_decode($value,true);
            }
            foreach ($detailArr as $value){
                EdBookingDetail::insert([
                    'booking_id'=>$filterData['booking_id'],
                    'ref_no'=>$value['ref_no'],
                    'po_no'=>$value['po_no'],
                    'country'=>$value['country'],
                    'qty_case'=>$value['qty_case'],
                    'case_length'=>$value['case_length'],
                    'case_width'=>$value['case_width'],
                    'case_height'=>$value['case_height'],
                    'case_weight'=>$value['case_weight']
                ]);
            }
            // 将数量/箱数同步到booking主表
            // 取出从表qty_case总数
            $orderQty = EdBookingDetail::where('booking_id',$filterData['booking_id'])->sum('qty_case');
            // 将总数更新到主表
            self::where('booking_id',$filterData['booking_id'])->update(['order_qty'=>$orderQty]);

            DB::commit();  //提交事务
        } catch (\Exception $exception) {
            DB::rollBack(); //回滚事务
            Log::error($exception->getMessage());
            return false;
        }
        return true;
    }

    /**
     * 编辑入库详情单
     * @param $query
     * @return bool
     */
//    public function queryEdit($query)
//    {
//        $filterData = Arr::except($query,['inboundid']);
//        $decodeData = json_decode($filterData['booking_detail'][0],true);
//        try {
//            EdBookingDetail::where('inboundid',$query['inboundid'])->update($decodeData);
//        } catch (\Exception $e) {
//            Log::error($e->getMessage());
//            return false;
//        }
//        return true;
//    }

    /**
     * 删除入库详情单
     * @param $query
     * @return bool|string
     */
    public function queryDelete($query)
    {
        try {
            // 先删除从表
            EdBookingDetail::where('booking_id',$query['booking_id'])->delete();
            // 删除主表
            $this->where('booking_id',$query['booking_id'])->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
        return true;
    }
}
