<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 阿里云短信发送类
 *
 * @author 战地音乐 qidazhong@hnzhimo.com
 */
class CI_Aliyunsms {

    //短信API产品名（短信产品名固定，无需修改）LTAI9kFsZ6FOkcUp	Cx0cekrdJEYZBhIypZbJT3lbXDeyyx
    private $product = "Dysmsapi";
    //短信API产品域名（接口地址固定，无需修改）
    private $domain = "http://dysmsapi.aliyuncs.com/?";
    //暂时不支持多Region（目前仅支持cn-hangzhou请勿修改）
    private $region = "cn-hangzhou";
    public $accessKeyId ;
    public $accessKeySecret ;
    public $signname ;

    /**
     * 
     * @param type $accessId 阿里云的sms id
     * @param type $accessSecret 阿里云的密钥
     * @param type $singname 短信模板签名
     */
    public function __construct($config) {
       if($config['accessId']==""||$config['accessSecret']==""||$config['singname']==""){
           exit("初始化阿里云短信类失败，请检查各项参数");
       }
       $this->accessKeyId=$config['accessId'];
       $this->accessKeySecret=$config['accessSecret'];
       $this->signname=$config['singname'];
    }
    /**
     * 
     * @param type $phonenumber
     * @param type $msg array("code"=>1024,"product"=>"test")
     * @param type $templateid SMS_78775049=验证码
     */
    public function sendSMS($phonenumber, $msg = array(), $templateid = "SMS_78775049") {
        if (is_array($phonenumber)) {
            $phones = implode(",", $phonenumber);
        } else {
            $phones = $phonenumber;
        }
        $content = json_encode($msg);
        $data = array(
            "PhoneNumbers" => $phones,
            "SignName" => $this->signname,
            "TemplateCode" => $templateid,
            "TemplateParam" => $content,
        );
        $data['AccessKeyId'] = $this->accessKeyId;
        $data['Timestamp'] = gmdate("Y-m-d") . "T" . gmdate("H:i:s") . "Z";
        $data['SignatureMethod'] = "HMAC-SHA1";
        $data['SignatureVersion'] = "1.0";
        $data['Action'] = "SendSms";
        $data['Version'] = "2017-05-25";
        $data['Format'] = "json";
        $data['RegionId'] = $this->region;
        $data['SignatureNonce'] = md5(time());
        $Signature = $this->sign($data);
        //signature这个不能经过http_build_query进行urlencode
        $dataString = http_build_query($data) . "&Signature=" . $Signature;

//        $request = $this->domain . $dataString;
        $result = $this->sendcurl($dataString);
        return json_decode($result,true);
    }

    /**
     * 签名算法，该函数仅实现了短信发送的签名
     * @param type $data
     * @return type
     */
    public function sign($data) {
        ksort($data);
        $paramstr = array();
        foreach ($data as $k => $p) {
            $paramstr[] = $this->special_urlencode($k) . "=" . $this->special_urlencode($p);
        }
        $paramString = implode("&", $paramstr);
        $paramString = $this->special_urlencode($paramString);
        $paramString = "GET&%2F&" . $paramString;
        //开始签名
        $sign = $this->special_urlencode(base64_encode(hash_hmac('sha1', $paramString, $this->accessKeySecret . "&", true)));
        return $sign;
    }

    public function special_urlencode($str) {
        $search = array("+", "~", "*");
        $replace = array("%20", "%7E", "%2A");
        return str_replace($search, $replace, urlencode($str));
    }

    /**
     * 
     * @return curl 采用get方式
     */
    public function sendcurl($dataString) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->domain . $dataString);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
