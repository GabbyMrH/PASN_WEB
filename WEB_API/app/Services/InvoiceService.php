<?php
namespace App\Services;

use App\Enums\CustomerType;
use App\Models\EdInvoice;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InvoiceService extends Service
{
    // 列表数据
    public function queryList($queries)
    {
        if(Arr::has($queries,['start_time', 'end_time'])){
            return $this->listWithinTime($queries);
        }
        return $this->listWithoutTime($queries);
        // return EdInvoice::whereHas('charges')->where('invoice_status','!=','DRAFT')->get();
        return EdInvoice::whereHas('charges')->where('invoice_status','!=','DRAFT')->get();
    }
    private function listWithinTime($queries)
    {
        $filterCondition = Arr::except($queries,['page','page_limit','start_time', 'end_time']);
        //如果登录用户不是admin则将附加判断用户类型，同理若是则无需变动返回所有数据
//        if(self::$customer_id != CustomerType::admin ){
//            $filterCondition['customer_id'] = Auth::user()->ed_customer_customer_id;
//        }
        // return EdInvoice::whereHas('charges')->where('invoice_status','!=','DRAFT')->get();
        return EdInvoice::whereHas('charges')
                ->where($filterCondition)
                ->where('invoice_status','!=','DRAFT')
                ->whereBetween('create_date', [$queries['start_time'], $queries['end_time']])
                ->latest('create_date')
                ->paginate($queries['page_limit']);
    }
    private function listWithoutTime($queries)
    {
        $filterCondition = Arr::except($queries,['page','page_limit']);
        //如果登录用户不是admin则将附加判断用户类型，同理若是则无需变动返回所有数据
//        if(self::$customer_id != CustomerType::admin ){
//            $filterCondition['customer_id'] = Auth::user()->ed_customer_customer_id;
//        }
        // return EdInvoice::whereHas('charges')->where('invoice_status','!=','DRAFT')->get();
        return EdInvoice::whereHas('charges')
            ->where($filterCondition)
            ->where('invoice_status','!=','DRAFT')
            ->latest('create_date')
            ->paginate($queries['page_limit']);
    }

    // 改变发票状态
    public function changeStatus($queries)
    {
        try {
            $invoices = EdInvoice::find($queries['invoice_id']);
            $invoices->invoice_status = 'VERIFIED';
            $invoices->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
        return true;
    }
}
