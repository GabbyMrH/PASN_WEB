<?php

namespace App\Http\Controllers;

use App\Models\EdInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    /**
     * @param $remote_server 远程服务url
     * @param $post_string  回显的数据格式
     * @return 返回封装的curl方法
     */
    private function request_by_curl($remote_server, $post_string) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // 线下关闭SSL验证
         curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false);
         curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * @param $secret  密钥必传
     * @return 包含时间戳和签名的数组
     */
    private function signComputed($secret)
    {
        $timestamp = (int)(microtime(true)*1000);  //毫秒取整
        $secretData = $secret;
        $combSecret = $timestamp."\n".$secretData;
        $encodeData = base64_encode(hash_hmac('sha256',$combSecret,$secretData,true));
        $sign = utf8_encode(urlencode($encodeData));
        $data = [
            'timestamp'=>$timestamp,
            'sign'=>$sign
        ];
        return $data;
    }

    /**
     * dingTalk message
     * 钉钉推送消息接口
     * @queryParam message required 信息内容
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @response {
     *   "data": "编写api文档测试-V2",
     *   "code": 2001,
     *   "msg": "ok"
     *   }
     */
    public function testDingTalkMessage(Request $request)
    {
        if(!$request->message){
            return response()->json(StatusController::paramError($request->message,'消息不能为空'));
        }
        $access_token = '830ffcc7cfebf521b55d1eccc2d23241cd0cd01bd0e763a82a3f0188d87f1c74';
        $sign_data = $this->signComputed('SEC0e070cded6e19c4133bcfc7437918d0e6a617305ecd8971fb3371b2637e2a5c7');
        $webhook = "https://oapi.dingtalk.com/robot/send?access_token=".$access_token."&timestamp=".$sign_data['timestamp']."&sign=".$sign_data['sign'];
        $messageData = $request->message;
        $data = array ('msgtype' => 'text','text' => array ('content' => $messageData));
        $dataString = json_encode($data);

        $result = $this->request_by_curl($webhook, $dataString);
        // 解码数据取其值
        $decodeData = json_decode($result,true);
        return response()->json(StatusController::success($messageData,$decodeData['errmsg']));
    }

    /**
     * password encryption
     * 密码加密接口
     * @param Request $request
     * @queryParam secret required 要加密的参数
     * @return \Illuminate\Http\JsonResponse
     * @response {
     *   "data": "$2y$10$bjYB5CM75JOBmxPAi4KqxuSplXzkKF.m3gxIMugmWXOz7toB3K5fO",
     *  "code": 2001,
     *   "msg": "操作成功"
     *   }
     */
    public function psdComputed(Request $request)
    {
        if(!$request->secret){
            return response()->json(StatusController::paramError($request->secret,'密码参数不能为空'));
        }
        // $secret = Crypt::encrypt($request->secret);
        $secret = Hash::make($request->secret);
        return response()->json(StatusController::success($secret));
    }

}
