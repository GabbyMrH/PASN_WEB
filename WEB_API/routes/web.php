<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

// $router->get('/', function () use ($router) {
//     //return $router->app->version();
//     // $test = Crypt::encrypt('123456');
//     $data = DB::table('users')->where('id','2')->update(['created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
//     // return response()->json($data);
// });
$router->group(['prefix' => 'v1'], function ($router) {
    //获取token
    $router->post('user', 'AuthController@store');
    //刷新token
    $router->put('user/current','AuthController@update');
    //删除token
    $router->delete('user/current','AuthController@destroy');

    //获取用户信息 路由组调用auth中间件,中间件会触发illuminate/auth/AuthManage.php下的guard,-
    //-该函数会调用getDefaultDriver函数,接下来会查询config目录下「 lumen默认的Auth.php内的defaults.guard 」-
    //-接下来，该guard的配置就在该文件内找到了，就是默认的api guard，当前的服务提供者为users模型
    $router->group(['middleware' => 'auth:api'], function ($router) {
        $router->get('user', 'UsersController@info');
    });
});
