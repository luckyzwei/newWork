<?php
$str='a:9:{i:0;a:4:{s:10:"goods_code";s:9:"goods_0-2";s:16:"goods_plus_price";s:1:"0";s:11:"goods_store";s:1:"0";s:8:"hidenChk";i:0;}i:1;a:4:{s:10:"goods_code";s:9:"goods_0-1";s:16:"goods_plus_price";s:1:"0";s:11:"goods_store";s:2:"10";s:8:"hidenChk";i:1;}i:2;a:4:{s:10:"goods_code";s:9:"goods_0-0";s:16:"goods_plus_price";s:1:"0";s:11:"goods_store";s:1:"0";s:8:"hidenChk";i:0;}i:3;a:4:{s:10:"goods_code";s:9:"goods_1-2";s:16:"goods_plus_price";s:1:"0";s:11:"goods_store";s:1:"0";s:8:"hidenChk";i:1;}i:4;a:4:{s:10:"goods_code";s:9:"goods_1-1";s:16:"goods_plus_price";s:2:"10";s:11:"goods_store";s:1:"0";s:8:"hidenChk";i:0;}i:5;a:4:{s:10:"goods_code";s:9:"goods_1-0";s:16:"goods_plus_price";s:4:"1000";s:11:"goods_store";s:1:"0";s:8:"hidenChk";i:1;}i:6;a:4:{s:10:"goods_code";s:9:"goods_2-2";s:16:"goods_plus_price";s:1:"0";s:11:"goods_store";s:1:"0";s:8:"hidenChk";i:0;}i:7;a:4:{s:10:"goods_code";s:9:"goods_2-1";s:16:"goods_plus_price";s:1:"0";s:11:"goods_store";s:1:"0";s:8:"hidenChk";i:0;}i:8;a:4:{s:10:"goods_code";s:9:"goods_2-0";s:16:"goods_plus_price";s:1:"0";s:11:"goods_store";s:1:"0";s:8:"hidenChk";i:0;}}';

$strs='a:1:{i:0;a:2:{s:14:"agent_group_id";s:1:"1";s:16:"agent_commission";a:3:{i:0;s:1:"1";i:1;s:1:"3";i:2;s:1:"4";}}}^';
#$sttt='a:1:{i:0;a:2:{s:14:"agent_group_id";s:1:"1";s:16:"agent_commission";a:3:{i:0;s:1:"1";i:1;s:1:"3";i:2;s:1:"4";}}}';
$t='<?xml version="1.0" encoding="UTF-8"?><rows><row id="1"><CheckData>bc01fc4160f2b4473b22c20a318bb0ba</CheckData><StoCustomerID>90000</StoCustomerID><ecpCode>4101967307</ecpCode><orderNo>N5623401</orderNo><LogisticsNo>220901323280</LogisticsNo><Consignor>百川优品</Consignor><TelephoneNum>037161173068</TelephoneNum><ConsignorAdd>河南省郑州市经开区第九大街河南保税物流中心</ConsignorAdd><shipperCountryCiq></shipperCountryCiq><shipperCountryCus>142</shipperCountryCus><consignee>刘晨伟</consignee><consigneeTelephone>17630535010</consigneeTelephone><Province>河南省</Province><City>郑州市</City><Zone>金水区</Zone><consigneeAddress>金水东路</consigneeAddress><consigneeCountryCiq></consigneeCountryCiq><consigneeCountryCus>142</consigneeCountryCus><idType>1</idType><customerId>410521199605155010</customerId><stockFlag>2</stockFlag><voyageNo></voyageNo><totalLogisticsNo></totalLogisticsNo><weight>111111</weight><netWeight>9999.9</netWeight><packNo>1</packNo><CurrencyCus>142</CurrencyCus><CurrencyCiq>156</CurrencyCiq><ieType>I</ieType><freight></freight><insuredFee>0</insuredFee><shipCode>59</shipCode><codMoney></codMoney><interFaceType></interFaceType><modifyFlag>1</modifyFlag><appStatus>2</appStatus><note></note><goodsInfo></goodsInfo><goodsItem></goodsItem></row></rows>';
echo hash("md5",$t);
echo "\r\n";
echo md5($t);
echo "\r\n";
echo (md5($t,true));

echo "\r\n";
function md5s($key) {

return unpack("c*", md5($key,true));
}
var_dump(md5s($t));
