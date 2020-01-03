<?php

namespace App\Http\Controllers;

use App\Models\EdInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class InventoryController extends Controller
{
    /**
    * list列表
    * @param page_limit(required)
    * */
   public function list(Request $request,EdInventory $edInventory)
   {
       $req_data = $request->all();
       if(!$req_data){
           return response()->json(StatusController::paramError($req_data));
       }
       //过滤传递参数并交由模型处理数据
       $results = $edInventory->dataList(array_filter($req_data));
       return response()->json(StatusController::success($results));

   }
}
