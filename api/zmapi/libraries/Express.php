<?php

/**
 * 物流查询 
 * 适用与阿里云市场 杭州网尚科技 全国快递查询接口
 *  wang修 2018年3月15日
 * @author liuchenwei@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @since	Version 1.0.0
 */
class Express {
    
    private $appcode;
    
    public function __construct($config) {
        if(empty($config)){
            exit("appcode参数未设置");
        }
        $this->appcode=$config['code'];
    }

    public function getExpress($expressid) {
        $host = "http://jisukdcx.market.alicloudapi.com";
        $path = "/express/query";
        $method = "GET";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $this->appcode);
        $querys = "number=" . $expressid . "&type=auto";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $express_json =  curl_exec($curl);
        return json_decode($express_json, true);
    }
    
    public function kdniao($expressid,$shipperCode) {
//        $url='http://sandboxapi.kdniao.com:8080/kdniaosandbox/gateway/exterfaceInvoke.json';
        $url='http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx';
        $requestData= "{'OrderCode':'','ShipperCode':'".$shipperCode."','LogisticCode':'".$expressid."'}";
	$appKey='dd78aa81-9a55-4fda-9576-71b63d987508';
	$datas = array(
        'EBusinessID' => '1547268',
        'RequestType' => '1002',
        'RequestData' => urlencode($requestData) ,
        'DataType' => '2',
    );
    $datas['DataSign'] = urlencode(base64_encode(md5($requestData.$appKey)));
        $temps = array();	
    foreach ($datas as $key => $value) {
        $temps[] = sprintf('%s=%s', $key, $value);		
    }	
    $post_data = implode('&', $temps);
    $url_info = parse_url($url);
	if(empty($url_info['port']))
	{
		$url_info['port']=80;	
	}
    $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
    $httpheader.= "Host:" . $url_info['host'] . "\r\n";
    $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
    $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
    $httpheader.= "Connection:close\r\n\r\n";
    $httpheader.= $post_data;
    $fd = fsockopen($url_info['host'], $url_info['port']);
    fwrite($fd, $httpheader);
    $gets = "";
	$headerFlag = true;
	while (!feof($fd)) {
		if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
			break;
		}
	}
    while (!feof($fd)) {
		$gets.= fread($fd, 128);
    }
    fclose($fd);  
    return json_decode($gets,true);
    }

}