<?php

defined('BASEPATH') OR exit('No direct script access allowed');
if (!function_exists("get_access_token")) {

    function get_access_token($appid, $appsecret) {
        $token_file = "./cert/wechat_app_token";
        if (is_file($token_file)) {
            $token_txt = file_get_contents($token_file);
            $temp_array = json_decode($token_txt, true);
            if ($temp_array['expires_in'] > time()) {
                $token = $temp_array['access_token'];
            }
        }
        if (empty($token)) {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
            $token_txt = file_get_contents($url);
            $token_array = json_decode($token_txt, true);
            if (!isset($token_array['errcode'])) {
                $token_array['expires_in'] += time();
                $token_txt = json_encode($token_array);
                $fp = fopen("./cert/wechat_app_token", "w+");
                fwrite($fp, $token_txt);
                fclose($fp);
                $token = $token_array['access_token'];
            } else {
                return false;
            }
        }
        return $token;
    }

}
if (!function_exists("curl_post")) {

    function curl_post($url, $data, $type) {
        if ($type == 'json') {//json $_POST=json_decode(file_get_contents('php://input'), TRUE);
            $headers = array("Content-type: application/json;charset=UTF-8", "Accept: application/json", "Cache-Control: no-cache", "Pragma: no-cache");
            $data = json_encode($data);
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

}
