<?php

namespace App\Models;

use App\Enums\CustomerType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EdBooking extends Model
{
    /**
     * 预约入库
     */
    protected $table = 'ed_booking';
    protected $primaryKey = 'booking_id';
    public $incrementing = false;
    // 定义数据库自动写入时间字段
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    // 过滤字段
    protected $fillable = [];
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
     * @param $requestData 请求参数
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
            ->orderBy('create_date', 'DESC')
            ->paginate($requestData['page_limit']);
    }
    // 封装查询booking的时候没有筛选时间的方法
    private function queryListWithoutTime($requestData)
    {
        // 需要过滤page和page_limit查询条件
        $filterCondition = Arr::except($requestData, ['page', 'page_limit']);
        // 同上queryListHasTime()方法一样
        if(self::$customer_id != CustomerType::admin ){
            $filterCondition['customer_id'] = Auth::user()->ed_customer_customer_id;
        }
        return self::where($filterCondition)->orderBy('create_date', 'DESC')->paginate($requestData['page_limit']);
    }

    /**
     * @param $requestData
     * @return 返回ed_booking关联的ed_booking_detail表相关数据
     */
    public function queryDetailList($requestData)
    {
        //强烈提示：以后数据库主外键设计需要严格遵照国际化标准，如表A主键为'id'，AB表相互关联则表B外键为'a_id'的形式
        //若AB表相关联出现相同字段，会出现join查询报bug等错误

        //指定返回数据--不指定会报错，这是因为主从表有相同字段导致会报错(数据库设计问题)
        $result_condition = [
            'ed_booking_detail.*',
            'ed_booking.customer_id', 'ed_booking.booking_no', 'ed_booking.warehouse_code', 'ed_booking.order_qty',
            'ed_booking.booking_date', 'ed_booking.booking_status'
        ];

        $filter_condition = Arr::except($requestData, ['page', 'page_limit']);
        return $this->where($filter_condition)
            ->join('ed_booking_detail', 'ed_booking.booking_id', '=', 'ed_booking_detail.booking_id')
            ->select($result_condition)
            ->orderBy('ed_booking_detail.create_date', 'DESC')
            ->paginate($requestData['page_limit']);
    }

    public function queryAdd($requestData)
    {
        try {
            DB::beginTransaction(); // 开启事务
            //先写入主库booking库再写入从库detail库
            $this->customer_id = $requestData['customer_id'];
            $this->warehouse_code = $requestData['warehouse_code'];

        } catch (\Exception $exception) {

        }
    }
}
