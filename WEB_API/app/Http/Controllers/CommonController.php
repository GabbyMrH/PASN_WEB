<?php

namespace App\Http\Controllers;

use App\Models\EdBooking;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    /**
     * warehouse list
     * 仓库列表
     * @return \Illuminate\Http\JsonResponse
     * @response {
     *  "data": [
     *   {
     *  "warehouse_code": "PH"
     *  },
     *  {
     *  "warehouse_code": "1999"
     *  },
     *  {
     *  "warehouse_code": "KJJSZC"
     *  },
     *  {
     *  "warehouse_code": "222"
     *  }
     *  ],
     *  "code": 2001,
     *  "msg": "操作成功"
     *   }
     */
    public function warehouseList()
    {
        $query = EdBooking::whereNotNull('warehouse_code')->select('warehouse_code')->distinct()->get();
        return response()->json(StatusController::success($query));
    }
}
