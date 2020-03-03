<?php

namespace App\Http\Controllers;

use App\Models\EdBooking;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    /**
     * @return warehouse_code
     */
    public function warehouseList()
    {
        $query = EdBooking::whereNotNull('warehouse_code')->select('warehouse_code')->distinct()->get();
        return response()->json(StatusController::success($query));
    }
}
