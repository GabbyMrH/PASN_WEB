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

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

$router->get('/', function () use ($router) {
    //return $router->app->version();
    $test = Crypt::encrypt('123456');
    $data = DB::table('ed_booking')->orderByDesc('create_date')->get();
    return response()->json($data);
});
//测试jwt
$router->get('login','AuthController@store');
