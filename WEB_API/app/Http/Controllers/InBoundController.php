<?php

namespace App\Http\Controllers;

use App\Imports\EdBookingDetailImprot;
use App\Models\EdBooking;
use App\Models\EdBookingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class InBoundController extends Controller
{
    public $edBooking;
    public function __construct(EdBooking $edBooking)
    {
        $this->edBooking = $edBooking;
    }
    /**
     * 列表
     */
    public function list(Request $request)
    {
        $req_data = $request->all();
        if(!$req_data){
            return response()->json(StatusController::paramError($req_data));
        }
        //过滤参数
        $results = $this->edBooking->dataList(array_filter($req_data));
        return response()->json(StatusController::success($results));
    }
    public function detailImport(Request $request)
    {
        Excel::import(new EdBookingDetailImprot,$request->file('ed_booking_detail'));
    }

    public function queryList(Request $request)
    {
        //若所传参数其中值为空，则回传null数据
        if(!$request->filled('customer_id') || !$request->filled('warehouse_code')){
            return response()->json(StatusController::success());
        }
        //将传递参数对象交由模型处理
        $results = $this->edBooking->queryList($request->all());
        return response()->json(StatusController::success($results));
    }
    public function queryAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'=>'required|exists:ed_customer',
            'warehouse_code'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(StatusController::paramError());
        }
    }

}