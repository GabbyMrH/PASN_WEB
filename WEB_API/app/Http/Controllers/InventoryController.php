<?php

namespace App\Http\Controllers;

use App\Models\EdInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * @param Request $request
     * @param EdInventory $edInventory
     * @return \Illuminate\Http\JsonResponse
     */
   public function list(Request $request,EdInventory $edInventory)
   {
       $req_data = $request->all();
       if(!$req_data){
           return response()->json(StatusController::paramError($req_data));
       }
       //过滤传递参数
       $results = $edInventory->dataList(array_filter($req_data));
       return response()->json(StatusController::success($results));

   }

   public function test()
   {
       return response()->json(Auth::user()->ed_customer_customer_id);
   }
}
