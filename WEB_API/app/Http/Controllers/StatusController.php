<?php

namespace App\Http\Controllers;

class StatusController extends Controller
{
    //参数有误--用户传参
    public static function paramError($data = null, $msg = null)
    {
        return [
            'data' => $data,
            'code' => 1001,
            'msg' => is_null($msg) ? '参数有误' : $msg
        ];
    }
    //数据有误--用户传参
    public static function dataError($data = null, $msg = null)
    {
        return [
            'data' => $data,
            'code' => 1003,
            'msg' => is_null($msg) ? '数据有误' : $msg
        ];
    }
    //操作成功
    public static function success($data = null, $msg = null)
    {
        return [
            'data' => $data,
            'code' => 2001,
            'msg' => is_null($msg) ? '操作成功' : $msg
        ];
    }
    //禁止访问
    public static function deny($data = null, $msg = null)
    {
        return [
            'data' => $data,
            'code' => 4001,
            'msg' => is_null($msg) ? '禁止访问' : $msg
        ];
    }
    //权限不足
    public static function noAuth($data = null, $msg = null)
    {
        return [
            'data' => $data,
            'code' => 4002,
            'msg' => is_null($msg) ? '权限不足' : $msg
        ];
    }
    //操作失败
    public static function fails($data = null, $msg = null)
    {
        return [
            'data' => $data,
            'code' => 4003,
            'msg' => is_null($msg) ? '操作失败' : $msg
        ];
    }
    //结果为空
    public static function void($data = null, $msg = null)
    {
        return [
            'data' => $data,
            'code' => 4004,
            'msg' => is_null($msg) ? '结果为空' : $msg
        ];
    }
    //授权过期
    public static function expired($data = null, $msg = null)
    {
        return [
            'data' => $data,
            'code' => 4005,
            'msg' => is_null($msg) ? '授权过期' : $msg
        ];
    }
}
