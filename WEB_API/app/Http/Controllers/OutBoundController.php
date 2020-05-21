<?php

namespace App\Http\Controllers;

use App\Services\OutBoundService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OutBoundController extends Controller
{
    public $outBoundService;
    public function __construct(OutBoundService $outBoundService)
    {
        $this->outBoundService = $outBoundService;
    }

    // 出库列表
    public function index(Request $request)
    {
        $requestData = $request->all();
        $requestData['page'] = isset($requestData['page']) ? $requestData['page'] : 1;
        $requestData['page_limit'] = isset($requestData['page_limit']) ? $requestData['page_limit'] : 20;
        //过滤参数
        $results = $this->outBoundService->queryList(array_filter($requestData));
        return response()->json(StatusController::success($results));
    }

    // 出库从表详情列表
    public function detailList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'issue_id' => 'required'
        ], [
            'issue_id.required' => 'issue_id'
        ]);

        if ($validator->fails()) {
            return response()->json(StatusController::paramError($request->all(), $validator->errors()->first()));
        }
        $requestData = $request->all();
        $requestData['page'] = isset($requestData['page']) ? $requestData['page'] : 1;
        $requestData['page_limit'] = isset($requestData['page_limit']) ? $requestData['page_limit'] : 20;
        //过滤参数
        $results = $this->outBoundService->queryDetailList(array_filter($requestData));
        return response()->json(StatusController::success($results));
    }

    // 写入数据
    public function queryInsert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ref_no' => 'required',
            'customer_id' => 'required',
            'warehouse_code' => 'required',
            'details'=>'required'
        ], [
            'ref_no.required' => 'ref_no必填',
            'customer_id.required' => 'customer_id必填',
            'warehouse_code.required' => 'warehouse_code必填',
        ]);

        if ($validator->fails()) {
            return response()->json(StatusController::paramError($request->all(), $validator->errors()->first()));
        }
        $results = $this->outBoundService->queryInsert(array_filter($request->all()));
        return $results ? response()->json(StatusController::success($request->all())) : response()->json(StatusController::fails($results));
    }

    // 编辑数据
    public function queryEdit(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'outboundid'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(StatusController::paramError($request->all(), $validator->errors()->first()));
        }
        $results = $this->outBoundService->queryEdit(array_filter($request->all()));
        return $results ? response()->json(StatusController::success($request->all())) : response()->json(StatusController::fails($results));
    }

    // 删除order
    public function queryDelete(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'issue_id'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(StatusController::paramError($request->all(), $validator->errors()->first()));
        }
        $results = $this->outBoundService->queryDelete(array_filter($request->all()));
        return $results ? response()->json(StatusController::success($request->all())) : response()->json(StatusController::fails($results));
    }
    // 删除details
    public function queryDeleteDetail(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'outboundid'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(StatusController::paramError($request->all(), $validator->errors()->first()));
        }
        $results = $this->outBoundService->detailDelete(array_filter($request->all()));
        return $results ? response()->json(StatusController::success($request->all())) : response()->json(StatusController::fails($results));
    }
}
