<?php
namespace App\Services;

use App\Enums\CustomerType;
use App\Models\EdOutboundDetail;
use App\Models\EdOutboundOrder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OutBoundService extends Service
{
    public $edOutboundOrder;
    public static $customer_id; //用户角色类型

    public function __construct(EdOutboundOrder $edOutboundOrder)
    {
        $this->edOutboundOrder = $edOutboundOrder;
        self::$customer_id = Auth::user()->ed_customer_customer_id;
    }

    // 请求数据列表
    public function queryList($queries)
    {
        if(Arr::has($queries,['start_time', 'end_time'])){
            return $this->listWithinTime($queries);
        }
        return $this->listWithoutTime($queries);
    }
    private function listWithinTime($queries)
    {
        // 需要过滤page和page_limit查询条件
        $filterCondition = Arr::except($queries, ['page', 'page_limit', 'start_time', 'end_time']);
        //如果登录用户不是admin则将附加判断用户类型，同理若是则无需变动返回所有数据
        if(self::$customer_id != CustomerType::admin ){
            $filterCondition['customer_id'] = Auth::user()->ed_customer_customer_id;
        }
        return EdOutboundOrder::where($filterCondition)
            ->whereBetween('create_date', [$queries['start_time'], $queries['end_time']])
            ->distinct()
            ->latest('ed_outbound_order.create_date')
            ->paginate($queries['page_limit']);
    }
    private function listWithoutTime($queries)
    {
        // 需要过滤page和page_limit查询条件
        $filterCondition = Arr::except($queries, ['page', 'page_limit']);
        //如果登录用户不是admin则将附加判断用户类型，同理若是则无需变动返回所有数据
        if(self::$customer_id != CustomerType::admin ){
            $filterCondition['customer_id'] = Auth::user()->ed_customer_customer_id;
        }
        return EdOutboundOrder::where($filterCondition)->distinct()->latest('ed_outbound_order.issue_date')->paginate($queries['page_limit']);
    }

    // 从表详情页数据
    public function queryDetailList($queries)
    {
        return EdOutboundOrder::with('details')->whereIssueId($queries['issue_id'])->first();
    }

    // 请求新增
    public function queryInsert($queries)
    {
        try {
            DB::beginTransaction();
            $filterData = Arr::except($queries,['details','detail_total']);
            $filterData['issue_id'] = Str::uuid();
            $outBoundInsert = $this->edOutboundOrder->insert($filterData);
            // 解码detail数据
            $detailArr = [];
            foreach ($queries['details'] as $value){  // 前端传递数据体内数据居然是嵌套json，所以不得不循环取出解码再回传到新数组
                // 首先解码
                $detailArr[] = json_decode($value,true);
            }
            foreach ($detailArr as $value){
                EdOutboundDetail::insert([
                    'issue_id'=>$filterData['issue_id'],
                    'line_num'=>$value['line_num'],
                    'ref_no'=>$value['ref_no'],
                    'po_no'=>$value['po_no'],
                    'qty_case'=>$value['qty_case'],
                    'sku_ename'=>$value['sku_ename'],
                    'fba_warehouse'=>$value['fba_warehouse'],
                    'create_date'=>Carbon::now(),
                    'update_date'=>Carbon::now()
                ]);
            }
            // 取出从表qty_case总数
            $orderQty = EdOutboundDetail::where('issue_id',$filterData['issue_id'])->sum('qty_case');
            // 将总数更新到主表
            EdOutboundOrder::where('issue_id',$filterData['issue_id'])->update(['order_qty'=>$orderQty]);
            DB::commit();  //提交事务
        } catch (\Exception $e) {
            DB::rollBack(); //回滚事务
            Log::error($e->getMessage());
            return false;
        }
        return true;
    }

    // 请求编辑
    public function queryEdit($queries)
    {
        $filterData = Arr::except($queries,['outboundid']);
        $decodeData = json_decode($filterData['details'][0],true);
        try {
            EdOutboundDetail::where('outboundid',$queries['outboundid'])->update($decodeData);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
        return true;
    }

    // 删除 主数据
    public function queryDelete($queries)
    {
        try {
            // 先删除从表
            EdOutboundDetail::where('issue_id',$queries['issue_id'])->delete();
            // 删除主表
            EdOutboundOrder::where('issue_id',$queries['issue_id'])->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
        return true;
    }
    // 请求删除-details
    public function detailDelete($queries)
    {
        try {
            EdOutboundDetail::where([
                'outboundid'=>$queries['outboundid']
            ])->delete();
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
        return true;
    }
}
