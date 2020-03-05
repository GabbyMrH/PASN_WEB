<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * user info
     * 用户信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @response {
     *   "data": {
     *   "id": 2,
     *   "name": "admin",
     *   "username": "123456",
     *   "created_at": "2019-12-19 15:08:23.910",
     *  "updated_at": "2019-12-19 15:08:23.910",
     *  "roles": "admin",
     *  "avatar": "http://pasn.api.com/assets/avatar/avatar.jpg",
     *  "ed_customer_customer_id": "system"
     *  },
     *  "code": 2001,
     *  "msg": "操作成功"
     *  }
     */
    public function info(Request $request)
    {
        return response()->json(StatusController::success(Auth::user()));
    }
}
