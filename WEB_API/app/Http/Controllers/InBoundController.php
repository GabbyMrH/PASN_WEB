<?php

namespace App\Http\Controllers;

use App\Imports\EdBookingDetailImprot;
use App\Models\EdBooking;
use App\Models\EdBookingDetail;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class InBoundController extends Controller
{
    public $edbooking;
    public function __construct(EdBooking $edBooking)
    {
        $this->edbooking = $edBooking;
    }

    /**
     * @param Request $request
     * @return 入库订单列表
     */
    public function queryList(Request $request,EdBooking $edBooking)
    {
        $req_data = $request->all();
        if(!$req_data){
            return response()->json(StatusController::paramError($req_data));
        }
        //过滤参数
        $results = $edBooking->queryList(array_filter($req_data));
        return response()->json(StatusController::success($results));
    }
    public function detailImport(Request $request)
    {
        Excel::import(new EdBookingDetailImprot,$request->file('ed_booking_detail'));
    }

    /**
     * @param Request $request
     * @return 入库货物详情单列表
     */
    public function queryDetailList(Request $request,EdBooking $edBooking)
    {
        // 自定义验证器验证参数
        $validator = Validator::make($request->all(),[
            'ref_no'=>'required',
        ],[
            'ref_no.required'=>'ref_no必填',
        ]);
        if($validator->fails()){
            return response()->json(StatusController::paramError($request->all(),$validator->errors()->first()));
        }
        //将传递参数对象交由模型处理
        $results = $edBooking->queryDetailList($request->all());
        return response()->json(StatusController::success($results));
    }

    /**
     * @param Request $request
     * @return 添加入库订单
     */
    public function queryAdd(Request $request,EdBooking $edBooking)
    {
        $validator = Validator::make($request->all(), [
            'ref_no'=>'required',
            'customer_id'=>'required',
            'booking_date'=>'required',
            'warehouse_code'=>'required',
            'booking_detail'=>'required|array'
        ],[
            'ref_no.required'=>'ref_no必填',
            'customer_id.required'=>'customer_id必填',
            'booking_date.required'=>'booking_date必填',
            'warehouse_code.required'=>'warehouse_code必填',
            'booking_detail.required'=>'booking_detail必填'
        ]);

        if($validator->fails()){
            return response()->json(StatusController::paramError($request->all(),$validator->errors()->first()));
        }
        $result = $edBooking->queryAdd($request->all());
        if($result){
            return response()->json(StatusController::success($request->all()));
        }
        return response()->json(StatusController::fails($result));
    }

    /**
     * @param $requestData 输入参数
     * @return 返回编辑后成功条目
     */
    public function queryEdit(Request $request)
    {

    }


}
