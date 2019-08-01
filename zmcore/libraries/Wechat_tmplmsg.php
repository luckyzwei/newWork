<?php

defined('BASEPATH') OR exit('No direct script access allowed');


require_once(BASEPATH . 'libraries/lib/Wechat_common.php');

/**
 * Description of Wechat_qrcode
 * 小程序模板消息相关
 * @author wangxiangayx
 */
class CI_Wechat_tmplmsg extends CI_Wechat_common {

    public function __construct($options) {
        parent::__construct($options);
    }

    public function sendmessage($access_token, $data) {
        //发送模板消息
        $post_url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token;
        $output =  $this->http_post($post_url, json_encode($data));
        $res = json_decode($output,true);
        return $res['errmsg'] ;
    }

}
