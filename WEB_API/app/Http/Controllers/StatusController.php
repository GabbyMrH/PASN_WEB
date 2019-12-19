<?php

namespace App\Http\Controllers;

class StatusController extends Controller
{
    public static $data;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($data = null)
    {
        self::$data = $data;
    }

    //参数有误--用户传参
    public static function error()
    {
        return [
            'data' => self::$data,
            'status' => '1001',
            'msg' => '参数有误'
        ];
    }
    //操作成功
    public static function success()
    {
        return [
            'data' => self::$data,
            'status' => '2001',
            'msg' => '操作成功'
        ];
    }
    //禁止访问
    public static function deny()
    {
        return [
            'data' => self::$data,
            'status' => '4001',
            'msg' => '禁止访问'
        ];
    }
    //权限不足
    public static function noAuth()
    {
        return [
            'data' => self::$data,
            'status' => '4002',
            'msg' => '权限不足'
        ];
    }
    //操作失败
    public static function fails()
    {
        return [
            'data' => self::$data,
            'status' => '4003',
            'msg' => '操作失败'
        ];
    }
    //结果为空
    public static function void()
    {
        return [
            'data' => self::$data,
            'status' => '4004',
            'msg' => '结果为空'
        ];
    }
}
