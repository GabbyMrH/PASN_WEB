<?php

namespace App\Http\Controllers;

use App\Models\EdInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * inventory list
     * 库存余额列表
     * @param Request $request  请求参数
     * @param EdInventory $edInventory 库存余额表模型
     * @queryParam page 页码
     * @queryParam page_limit 每页显示条数
     * @return 库存余额列表
     * @response {
        "data": {
        "current_page": 1,
        "data": [
        {
        "PKID": "937ED92C-1D0C-4B07-AE20-0EFDBA251662",
        "warehouse_code": "PH",
        "customer_id": "ZB",
        "sku_no": "FBA15K0DBJYCU000020",
        "lot_no": "2D618FF5-462B-225A-AC12-F031A83A1E7A",
        "po_no": "FBA15K0DBJYC",
        "ref_no": "ZBSZ19120320",
        "location_code": "STD",
        "drap_id": "",
        "qty": "1",
        "QtyAllocated": "0",
        "QtyPicked": "0",
        "QtyPickInProcess": "0",
        "QtyShipped": "0",
        "create_by": "system",
        "create_date": "2019-12-17 15:58:51.437",
        "update_by": "system",
        "update_date": "2019-12-17 15:58:51.437"
        }
        ],
        "first_page_url": "http://pasn.api.com/v1/inventory?page=1",
        "from": 1,
        "last_page": 71529,
        "last_page_url": "http://pasn.api.com/v1/inventory?page=71529",
        "next_page_url": "http://pasn.api.com/v1/inventory?page=2",
        "path": "http://pasn.api.com/v1/inventory",
        "per_page": "1",
        "prev_page_url": null,
        "to": 1,
        "total": 71529
        },
        "code": 2001,
        "msg": "操作成功"
        }
     */
   public function list(Request $request,EdInventory $edInventory)
   {
       // 设置默认参数
       $requestData = $request->all();
       $requestData['page'] = isset($requestData['page']) ? $requestData['page'] : 1;
       $requestData['page_limit'] = isset($requestData['page_limit']) ? $requestData['page_limit'] : 20;
       //过滤传递参数
       $results = $edInventory->queryList(array_filter($requestData));
       return response()->json(StatusController::success($results));

   }

}
