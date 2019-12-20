<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {

    }

    //登录验证
    public function store(Request $request)
    {
        $data_check = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($data_check->fails()) {
            return response()->json(StatusController::paramError());
        }
        //验证数据表数据
        $token = Auth::guard('api')->attempt([
            'username' => $request->username,
            'password' => $request->password
        ]);
        if (!$token) {
            return response()->json(StatusController::dataError());
        }

        //返回jwt信息
        return $this->userToken($token)->setStatusCode(201);

    }

    //生成jwt token
    public function userToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'code'=>2001
        ]);
    }

    /* 刷新token */
    public function update()
    {
        $token = Auth::guard('api')->refresh();
        return $this->userToken($token);
    }
    /* 删除token */
    public function destroy()
    {
        Auth::guard('api')->logout();
        return response(null, 204);
    }
}
