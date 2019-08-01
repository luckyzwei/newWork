<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Api权限拦截器：主要验证access_token 是否正确
 * @author qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 */
class Interceptor {

    private $CI;
    private $allow = array(
        "base/get_access_token", 
        "base/create_key",
        "notify/wechat_fun",
        );

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper("url");
        $this->requestInterceptor();
    }

    /**
     * 拦截器
     */
    private function requestInterceptor() {
        $controller = $this->CI->uri->segment(1);
        $method = $this->CI->uri->segment(2);
        $uri = strtolower($controller . "/" . $method);
        if (!in_array($uri, $this->allow)) {
            //解密session_id
            $session_id = $this->get_session_id();
            if (empty($session_id)) {
                echo json_encode(array("error_code" => 4000405));
                exit; //终止程序
            }
        }
    }

    /**
     * 解密token以获取session_id,解密失败或者session已过期返回空字符串
     * @return string
     */
    private function get_session_id() {
        $session_id = "";
        $token = $this->CI->input->get("access_token");
        if (!empty($token)) {
            $session_id = $this->decrypt_token($token);
            if (!empty($session_id)){
                session_id($session_id);
                $this->CI->load->library("session");
                if (empty($this->CI->session->appid)) {
                    $session_id = "";
                    $this->CI->session->sess_destroy();
                }
            }
        }
        return $session_id;
    }

    /**
     * access_token解密
     * @param type $token
     * @return type
     */
    private function decrypt_token($token) {
        $this->CI->load->library("encryption");
        return $this->CI->encryption->decrypt($token);
    }

}
