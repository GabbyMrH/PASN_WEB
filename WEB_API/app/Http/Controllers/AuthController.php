<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    /**
     * user login check
     * 登录验证
     * @param Request $request
     * @queryParam username required 账号
     * @queryparam password required 密码
     * @return \Illuminate\Http\JsonResponse
     * @response {
     *   "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9wYXNuLmFwaS5jb21cL3YxXC91c2VyIiwiaWF0IjoxNTgzMzc5MjAwLCJleHAiOjE1ODMzODY0MDAsIm5iZiI6MTU4MzM3OTIwMCwianRpIjoiYVRPdU00aW1ZejVxUWFteCIsInN1YiI6MiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.vZjnZLIYRwu_USyHCFUCCVe1J14yUTdx1t4H2SGgUiY",
     *   "token_type": "Bearer",
     *   "expires_in": "120",
     *   "code": 2001
     *   }
     */
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

    /**
     * generate user token
     * 生成jwt token
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function userToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            // 'expires_in' => Auth::guard('api')->factory()->getTTL() * 10,
            'expires_in' => Auth::guard('api')->factory()->getTTL(), //过期时间以env文件内设置
            'code'=>2001
        ]);
    }

    /**
     * refresh user token
     * 刷新token
     * @return \Illuminate\Http\JsonResponse
     * @response {
     *   "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9wYXNuLmFwaS5jb21cL3YxXC91c2VyIiwiaWF0IjoxNTgzMzgwOTQ3LCJleHAiOjE1ODMzODgxNDcsIm5iZiI6MTU4MzM4MDk0NywianRpIjoiZVNCcWJ2SzNQZXFscHZuNyIsInN1YiI6MiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.APLXxUp5wWk8mpWpWLUrUA78mkiz3HPcBTqow_3gQgo",
     *   "token_type": "Bearer",
     *   "expires_in": "120",
     *   "code": 2001
     *   }
     */
    public function update()
    {
        $token = Auth::guard('api')->refresh();
        return $this->userToken($token);
    }

    /**
     * delete user token
     * 删除token
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @response {
     * null
     * }
     */
    public function destroy(Request $request)
    {
        Auth::guard('api')->logout();
        //$data = $request->header('Bearer-Token');
        //return response(null, 204);
        return response()->json(StatusController::success(null));
    }
}
