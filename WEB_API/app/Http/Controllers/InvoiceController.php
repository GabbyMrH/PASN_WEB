<?php

namespace App\Http\Controllers;

use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    // 发票列表
    public function index(Request $request)
    {
        $requestData = $request->all();
        $requestData['page'] = isset($requestData['page']) ? $requestData['page'] : 1;
        $requestData['page_limit'] = isset($requestData['page_limit']) ? $requestData['page_limit'] : 20;
        //过滤参数
        $results = $this->invoiceService->queryList(array_filter($requestData));
        return response()->json(StatusController::success($results));
    }

    // 修改状态
    public function queryChangeStatus(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'invoice_id'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(StatusController::paramError($request->all(), $validator->errors()->first()));
        }
        $results = $this->invoiceService->changeStatus(array_filter($request->all()));
        return $results ? response()->json(StatusController::success($request->all())) : response()->json(StatusController::fails($results));

    }

}
