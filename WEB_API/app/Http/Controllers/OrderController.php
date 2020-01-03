<?php

namespace App\Http\Controllers;

use App\Models\EdInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    /**
     * list列表
     * @param page_limit(required)
     * */
    public function list(Request $request,EdInventory $edInventory)
    {
        $req_data = $request->all();
        if(!Arr::has($req_data,'page_limit')){
            return response()->json(StatusController::paramError());
        }
        //交由模型处理数据
        $results = $edInventory->dataList($req_data);
        return response()->json(StatusController::success($results));

    }
}
