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

$router->group(['prefix' => 'v1'], function ($router) {
    // API首页
    $router->get('index', 'ApiController@index');
    //获取token
    $router->post('user', 'AuthController@store');
    //刷新token
    $router->put('user/current','AuthController@update');
    //删除token
    $router->delete('user/current','AuthController@destroy');

    // 测试dinTalk
    $router->post('dingTest[/{message}]','TestController@testDingTalkMessage');
    // 密码加密
    $router->get('secret','TestController@psdComputed');


    //获取用户信息 路由组调用auth中间件,中间件会触发illuminate/auth/AuthManage.php下的guard,-
    //-该函数会调用getDefaultDriver函数,接下来会查询config目录下「 lumen默认的Auth.php内的defaults.guard 」-
    //-接下来，该guard的配置就在该文件内找到了，就是默认的api guard，当前的服务提供者为users模型

    $router->group(['middleware' => 'auth:api'], function ($router) {
        $router->get('user', 'UsersController@info');

        /* 面板管理 */
        // 库存余额-总量
        $router->get('inventoryTotal','PanelController@inventoryTotal');

        // 获取仓库
        $router->get('warehouse','CommonController@warehouseList');

        /* 订单管理 */

        // 预约入库
        // 列表
        $router->get('inbound','InBoundController@queryList');
        // $router->post('detailImport','InBoundController@detailImport');
        // $router->get('test','InBoundController@test');
        // 增加
        $router->post('inbound/add','InBoundController@queryAdd');
        // 编辑
//        $router->put('inbound/edit','InboundController@queryEdit');
        // 删除
        $router->delete('inbound/delete','InBoundController@queryDelete');
        // detail-列表
        $router->get('inbound/detail','InBoundController@queryDetailList');
        // detail-编辑
        $router->put('inbound/detail','InBoundController@queryDetailEdit');
        // detail-删除
        $router->delete('inbound/detail','InBoundController@queryDetailDelete');

        // 预约出库-列表
        $router->get('outbound','OutBoundController@index');
        $router->get('outbound/detail','OutBoundController@detailList');
        // 写入数据
        $router->post('outbound','OutBoundController@queryInsert');
        // 编辑数据
        $router->put('outbound/detail','OutBoundController@queryEdit');
        // 删除主数据
        $router->delete('outbound','OutBoundController@queryDelete');
        // 删除-detail
        $router->delete('outbound/detail','OutBoundController@queryDeleteDetail');

        // 库存余额
        $router->get('inventory','InventoryController@list');

        /**
         * 发票相关路由
         */
        // 列表
        $router->get('invoice','InvoiceController@index');
        // 更改状态
        $router->put('invoice','InvoiceController@queryChangeStatus');
    });
});
