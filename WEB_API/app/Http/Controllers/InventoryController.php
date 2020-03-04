<?php

namespace App\Http\Controllers;

use App\Models\EdInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * @param Request $request  请求参数
     * @param EdInventory $edInventory 库存余额表模型
     * @return 库存余额列表
     */
   public function list(Request $request,EdInventory $edInventory)
   {
       $req_data = $request->all();
       if(!$req_data){
           return response()->json(StatusController::paramError($req_data));
       }
       //过滤传递参数
       $results = $edInventory->queryList(array_filter($req_data));
       return response()->json(StatusController::success($results));

   }

   public function test()
   {
       return response()->json(Auth::user()->ed_customer_customer_id);
   }
}
