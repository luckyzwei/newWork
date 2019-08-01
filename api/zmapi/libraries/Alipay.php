<?php

/**
 * 支付宝支付接口
 *  
 * 主要方法
 *      手机wap支付 wapPay()
 * 预留
 *      手机网站查询接口 Query()
 *      手机网站退款接口Refund()
 *      手机网站关闭接口Close()
 *      手机网站退款查询接口refundQuery()
 *      手机网站账单下载接口downloadurlQuery()
 * @author wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @since	Version 1.0.0
 */
class Alipay {

    // 应用id
    private $appid;
    //支付宝网关地址
    private $gateway_url = "https://openapi.alipay.com/gateway.do";
    //支付宝公钥
    private $alipay_public_key;
    //商户私钥
    private $private_key;
    // 订单描述，可以对交易或商品进行一个详细地描述，比如填写"购买商品2件共15.00元"
    private $body;
    // 订单标题，粗略描述用户的支付目的。
    private $subject;
    // 商户订单号.
    private $outTradeNo;
    // (推荐使用，相对时间) 支付超时时间，5m 5分钟
    private $timeExpress;
    // 订单总金额，整形，此处单位为元，精确到小数点后2位，不能超过1亿元
    private $totalAmount;
    // 如果该字段为空，则默认为与支付宝签约的商户的PID，也就是appid对应的PID
    private $sellerId;
    // 产品标示码，固定值：QUICK_WAP_PAY
    private $productCode = "QUICK_WAP_PAY";
    private $bizContentarr = array();
    private $bizContent = NULL;

    //开始设置 wap支付特有字段
    public function setBody($body) {
        $this->body = $body;
        $this->bizContentarr['body'] = $body;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
        $this->bizContentarr['subject'] = $subject;
    }

    public function setOutTradeNo($outTradeNo) {
        $this->outTradeNo = $outTradeNo;
        $this->bizContentarr['out_trade_no'] = $outTradeNo;
    }

    public function setTotalAmount($totalAmount) {
        $this->totalAmount = $totalAmount;
        $this->bizContentarr['total_amount'] = $totalAmount;
    }

    public function setTimeExpress($timeExpress) {
        $this->timeExpress = $timeExpress;
        $this->bizContentarr['timeout_express'] = $timeExpress;
    }

    //wap支付特有字段 结束
    //支付宝接口公共字段
    public function setAppid($appid) {
        $this->appid = $appid;
    }

    public function setAlipay_public_key($alipay_public_key) {
        $this->alipay_public_key = $alipay_public_key;
    }

    public function setPrivate_key($private_key) {
        $this->private_key = $private_key;
    }

    public function setSellerId($sellerId) {
        $this->sellerId = $sellerId;
        $this->bizContentarr['seller_id'] = $sellerId;
    }

    /**
     * 手机网站支付函数
     * @param $return_url 同步跳转地址，公网可访问
     * @param $notify_url 异步通知地址，公网可以访问
     * @return $response 支付宝返回的信息
     */
    public function wapPay() {
        $this->bizContentarr['productCode'] = "QUICK_WAP_PAY";
        $this->bizContent = json_encode($this->bizContentarr, JSON_UNESCAPED_UNICODE);
        $apiParas["biz_content"] = $this->bizContent;
        //组装系统参数
        $sysParams = array();
        $sysParams["app_id"] = $this->appid;
        $sysParams["version"] = "1.0";
        $sysParams["format"] = "json";
        $sysParams["sign_type"] = "RSA";
        $sysParams["method"] = "alipay.trade.wap.pay";
        $sysParams["timestamp"] = date("Y-m-d H:i:s");
        $sysParams["alipay_sdk"] = "alipay-sdk-php-20161101";
        $sysParams["terminal_type"] = '';
        $sysParams["terminal_info"] = '';
        $sysParams["prod_code"] = ''; //DEMO中字段为prod_code
        $sysParams["notify_url"] = ''; //后台通知地址
        $sysParams["return_url"] = ''; //前台返回地址
        $sysParams["charset"] = "UTF-8";
        $totalParams = array_merge($apiParas, $sysParams);
        //待签名字符串
        $preSignStr = $this->getSignContent($totalParams);
        //签名
        $totalParams["sign"] = $this->generateSign($totalParams);
        //拼接GET请求串
        $requestUrl = $this->gateway_url . "?" . $preSignStr . "&sign=" . urlencode($totalParams["sign"]);
        return $requestUrl;
    }

    /**
     * 验证签名
     * @param type $params
     * @return string
     */
    public function check($params) {
        return $this->verify($this->getSignContent($params), $params['sign']);
    }

    protected function getSignContent($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset($k, $v);
        return $stringToBeSigned;
    }

    /**
     * 校验$value是否非空
     *  if not set ,return true;
     *    if is null , return true;
     * */
    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;
        return false;
    }

    public function generateSign($params) {
        return $this->sign($this->getSignContent($params));
    }

    protected function sign($data) {
        $priKey = $this->private_key;
        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
                wordwrap($priKey, 64, "\n", true) .
                "\n-----END RSA PRIVATE KEY-----";
        openssl_sign($data, $sign, $res);
        $sign = base64_encode($sign);
        return $sign;
    }

    function verify($data, $sign) {
        $pubKey = $this->alipay_public_key;
        $res = "-----BEGIN PUBLIC KEY-----\n" .
                wordwrap($pubKey, 64, "\n", true) .
                "\n-----END PUBLIC KEY-----";
        $result = (bool) openssl_verify($data, base64_decode($sign), $res);

        return $result;
    }

}
