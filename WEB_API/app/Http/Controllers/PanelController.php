<?php

namespace App\Http\Controllers;

use App\Models\EdInventory;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    //inventory 总量
    public function inventoryTotal(EdInventory $edInventory)
    {
        return response()->json(StatusController::success($edInventory->dataList()));
    }
}
