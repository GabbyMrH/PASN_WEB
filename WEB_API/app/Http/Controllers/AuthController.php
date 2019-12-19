<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    protected $jwt;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $jwt)
    {
        //注入jwt
        $this->jwt = $jwt;
    }

    //登录验证
    public function store(Request $request)
    {
        $data_check = Validator::make($request->all(),[
            'customer_id'=>'required',
            'password'=>'required'
        ]);
        if($data_check->fails()){
            return response()->json(StatusController::error());
        }
        //DB::table('ed_customer')->where('customer_id','LT')->update(['password'=>Hash::make('123456')]);
        //密码加密为Hash:make,验证为Hash::check(值)
        //$test = Hash::check('123456', '$2y$10$MtgCl5oe9Kllec7lborxiuyE7U.chMfFQWUlP1G9KshfH5xAu0FF.');

    }

    //生成jwt token
    public function userToken($token)
    {
        return response()->json([
            'access_token'=>$token,
            'token_type'=>'Bearer',
            'expires_in'=>Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}
