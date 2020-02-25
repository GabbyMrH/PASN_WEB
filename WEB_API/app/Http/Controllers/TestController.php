<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
     * @return 回调状态
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
        $data_string = json_encode($data);

        $result = $this->request_by_curl($webhook, $data_string);
        return response()->json(StatusController::success($messageData,$result));
    }

}
