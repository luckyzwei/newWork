<?php

defined('BASEPATH') OR exit('No direct script access allowed');


require_once(BASEPATH . 'libraries/lib/Wechat_common.php');

/**
 * Description of Wechat_qrcode
 * 微信生成二维码相关
 * @author wangxiangayx
 */
class CI_Wechat_qrcode extends CI_Wechat_common {

    public function __construct($options) {
        parent::__construct($options);
    }

    public function getwxacodeunlimit($access_token, $scene, $page = '', $width = 1500) {
        $postdata = array(
            'scene' => (string) $scene,
            'page' => $page,
            'width' => $width
        );
        $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . $access_token;
        return $this->http_post($url, json_encode($postdata));
    }

}
