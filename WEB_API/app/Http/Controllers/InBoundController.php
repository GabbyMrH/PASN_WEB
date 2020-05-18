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
     * booking list
     * 入库订单列表
     * @param Request $request
     * @param EdBooking $edBooking
     * @queryParam ref_no String 客户参考号
     * @queryParam booking_no String 入库预约号
     * @queryParam start_time+end_time Date 开始日期和结束日期
     * @queryParam page String 页码
     * @queryParam pge_limit String 每页显示条数
     * @return \Illuminate\Http\JsonResponse
     * @response {
     * "data": {
     * "current_page": 1,
     * "data": [
     * {
     * "booking_id": "58f5ec3a-ac1c-407e-88d4-57bcb8b8de25",
     * "order_id": "EC4249AA-D552-4231-9D1F-7D7C156D2000",
     * "customer_id": "system",
     * "booking_no": "1234",
     * "warehouse_code": "KJJSZC",
     * "booking_date": "2020-03-04 22:52:54.000",
     * "ref_no": "1234",
     * "truck_no": null,
     * "bill_no": null,
     * "order_qty": "12",
     * "order_gw": "0.0",
     * "order_cbm": "0.0",
     * "receipt_qty": "0",
     * "receipt_gw": "0.0",
     * "receipt_cbm": "0.0",
     * "create_by": " ",
     * "booking_status": "NEW",
     * "create_date": "2020-03-04 22:53:11.673",
     * "update_by": " ",
     * "update_date": "2020-03-04 22:53:12.290"
     * }
     * ],
     * "first_page_url": "http://pasn.api.com/v1/inbound?page=1",
     * "from": 1,
     * "last_page": 1348,
     * "last_page_url": "http://pasn.api.com/v1/inbound?page=1348",
     * "next_page_url": "http://pasn.api.com/v1/inbound?page=2",
     * "path": "http://pasn.api.com/v1/inbound",
     * "per_page": "1",
     * "prev_page_url": null,
     * "to": 1,
     * "total": 1348
     * },
     * "code": 2001,
     * "msg": "操作成功"
     * }
     */
    public function queryList(Request $request, EdBooking $edBooking)
    {
        // 设置默认值,若未设置page和page_limit则返回默认值
        $requestData = $request->all();
        $requestData['page'] = isset($requestData['page']) ? $requestData['page'] : 1;
        $requestData['page_limit'] = isset($requestData['page_limit']) ? $requestData['page_limit'] : 20;
        //过滤参数
        $results = $edBooking->queryList(array_filter($requestData));
        return response()->json(StatusController::success($results));
    }

    public function detailImport(Request $request)
    {
        Excel::import(new EdBookingDetailImprot, $request->file('ed_booking_detail'));
    }

    /**
     * booking detail list
     * 入库货物详情单列表
     * @param Request $request
     * @param EdBooking $edBooking
     * @queryParam ref_no required 客户参考号
     * @return \Illuminate\Http\JsonResponse
     * @response {
     * "data": {
     * "current_page": 1,
     * "data": [
     * {
     * "inboundid": "F6FAF1B5-5E11-4586-AF2C-92C19D43A848",
     * "booking_id": "58f5ec3a-ac1c-407e-88d4-57bcb8b8de25",
     * "line_num": null,
     * "ref_no": "1234",
     * "po_no": "312",
     * "country": "123",
     * "sku_code": null,
     * "sku_cname": null,
     * "sku_ename": null,
     * "sku_hscode": null,
     * "qty_case": "12",
     * "qty_pices": "0",
     * "sku_uom": null,
     * "sku_pack": null,
     * "case_length": "13.0",
     * "case_width": "313.0",
     * "case_height": "3132.0",
     * "case_weight": "313.0",
     * "case_upc": null,
     * "case_upc1": null,
     * "case_upc2": null,
     * "pick_line": null,
     * "qc_rate": "0.0",
     * "qc_mark": null,
     * "fba_warehouse": null,
     * "lot_attrib1": null,
     * "lot_attrib2": null,
     * "lot_attrib3": null,
     * "lot_attrib4": null,
     * "lot_attrib5": null,
     * "remarks": null,
     * "create_by": " ",
     * "create_date": "2020-03-04 22:53:11.793",
     * "update_by": " ",
     * "update_date": "2020-03-04 22:53:11.793",
     * "booking_date": "2020-03-04 22:52:54.000",
     * "order_qty": "12"
     * }
     * ],
     * "first_page_url": "http://pasn.api.com/v1/inbound/detail?page=1",
     * "from": 1,
     * "last_page": 1,
     * "last_page_url": "http://pasn.api.com/v1/inbound/detail?page=1",
     * "next_page_url": null,
     * "path": "http://pasn.api.com/v1/inbound/detail",
     * "per_page": "1",
     * "prev_page_url": null,
     * "to": 1,
     * "total": 1
     * },
     * "code": 2001,
     * "msg": "操作成功"
     * }
     */
    public function queryDetailList(Request $request, EdBooking $edBooking)
    {
        $requestData = $request->all();
        $requestData['page'] = isset($requestData['page']) ? $requestData['page'] : 1;
        $requestData['page_limit'] = isset($requestData['page_limit']) ? $requestData['page_limit'] : 20;
        //将传递参数对象交由模型处理
        $results = $edBooking->queryDetailList($requestData);
        return response()->json(StatusController::success($results));
    }

    /**
     * add booking order
     * 新增预约入库单
     * @param Request $request
     * @param EdBooking $edBooking
     * @queryParam ref_no required 客户参考号
     * @queryParam customer_id required 客户编码
     * @queryParam booking_date required 创建日期
     * @queryParam warehouse_code required 仓库编码
     * @queryParam booking_detail required 货物信息(array)
     * @return \Illuminate\Http\JsonResponse
     * @response {
     * "ref_no": "567",
     * "booking_date": "2020-03-05 14:25:45",
     * "warehouse_code": "PH",
     * "customer_id": "system",
     * "booking_detail": [
     * {"ref_no":567,"po_no":"111","qty_case":"20","country":"dsad","case_length":11,"case_width":"22","case_height":33,"case_weight":44},
     * {"ref_no":567,"po_no":"222","qty_case":"30","country":"fsa","case_length":22,"case_width":"33","case_height":44,"case_weight":55},
     * {"ref_no":567,"po_no":"333","qty_case":"20","country":"fdsf","case_length":33,"case_width":"44","case_height":55,"case_weight":66}
     * ],
     * "code": "2001",
     * "msg": "操作成功"
     * }
     */
    public function queryAdd(Request $request, EdBooking $edBooking)
    {
        $validator = Validator::make($request->all(), [
            'ref_no' => 'required',
            'customer_id' => 'required',
            'booking_date' => 'required',
            'warehouse_code' => 'required',
            'booking_detail' => 'required'
        ], [
            'ref_no.required' => 'ref_no必填',
            'customer_id.required' => 'customer_id必填',
            'booking_date.required' => 'booking_date必填',
            'warehouse_code.required' => 'warehouse_code必填',
            'booking_detail.required' => 'booking_detail必填'
        ]);

        if ($validator->fails()) {
            return response()->json(StatusController::paramError($request->all(), $validator->errors()->first()));
        }
        $result = $edBooking->queryAdd($request->all());
        if ($result) {
            return response()->json(StatusController::success($request->all()));
        }
        return response()->json(StatusController::fails($result));
    }

    /**
     * Request edit inbound order
     * 编辑入库单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
//    public function queryEdit(Request $request, EdBooking $edBooking)
//    {
//        $validator = Validator::make($request->all(),[
//            'inboundid'=>'required'
//        ]);
//        if ($validator->fails()) {
//            return response()->json(StatusController::paramError($request->all(), $validator->errors()->first()));
//        }
//        // 注意：需要判断传递过来的状态，为new则可编辑，为RECEIPTING则不能编辑
//        $result = $edBooking->queryEdit(array_filter($request->all()));
//        return $result ? response()->json(StatusController::success($result)) :
//            response()->json(StatusController::fails($result));
//    }

    /**
     * Request delete inbound order
     * 删除入库单
     * @param Request $request
     * @param EdBooking $edBooking
     * @return \Illuminate\Http\JsonResponse
     */
    public function queryDelete(Request $request, EdBooking $edBooking)
    {
        $validator = Validator::make($request->all(),[
            'booking_id'=>'required|exists:ed_booking'
        ]);
        if ($validator->fails()) {
            return response()->json(StatusController::paramError($request->all(), $validator->errors()->first()));
        }
        $result = $edBooking->queryDelete(array_filter($request->all()));
        return $result ? response()->json(StatusController::success($request->all())) :
            response()->json(StatusController::fails($result));
    }

    /**
     * Request edit inbound detail order
     * 编辑inbound detail订单
     * @param Request $request
     * @param EdBookingDetail $edBookingDetail
     * @return \Illuminate\Http\JsonResponse
     */
    public function queryDetailEdit(Request $request, EdBookingDetail $edBookingDetail)
    {
        $validator = Validator::make($request->all(),[
            'inboundid'=>'required|exists:ed_booking_detail'
        ]);
        if ($validator->fails()) {
            return response()->json(StatusController::paramError($request->all(), $validator->errors()->first()));
        }
        $result = $edBookingDetail->queryEdit(array_filter($request->all()));
        return $result ? response()->json(StatusController::success($request->all())) :
            response()->json(StatusController::fails($result));
    }

    /**
     * Request delete inbound detail order
     * 删除inbound detail订单
     * @param Request $request
     * @param EdBookingDetail $edBookingDetail
     * @return \Illuminate\Http\JsonResponse
     */
    public function queryDetailDelete(Request $request, EdBookingDetail $edBookingDetail)
    {
        $validator = Validator::make($request->all(),[
            'inboundid'=>'required|exists:ed_booking_detail'
        ]);
        if ($validator->fails()) {
            return response()->json(StatusController::paramError($request->all(), $validator->errors()->first()));
        }
        $result = $edBookingDetail->queryDelete(array_filter($request->all()));
        return $result ? response()->json(StatusController::success($request->all())) :
            response()->json(StatusController::fails($result));
    }

}
