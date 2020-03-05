<?php

namespace App\Http\Controllers;

use App\Models\EdInventory;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    /**
     * inventory total
     * inventory 总量
     * @param EdInventory $edInventory
     * @return \Illuminate\Http\JsonResponse
     * @response {
     * "Tips":"返回分页后的入库列表，从中提取总数"
     * }
     */
    public function inventoryTotal(EdInventory $edInventory)
    {
        // 需传array数组
        $requestParams = [
            'page'=>1,
            'page_limit'=>10
        ];
        return response()->json(StatusController::success($edInventory->queryList($requestParams)));
    }
}
