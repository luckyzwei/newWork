<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 导出系统数据
 *
 * @package    ZMshop
 * @author    qidazhong@hnzhimo.com
 * @copyright (c) 2016-2020, 河南知默网络科技有限公司
 * @link    http://www.hnzhimo.com
 * @since    Version 1.0.0
 */
class Export extends CI_Controller {

    private $statusname = array(
        '-1' => "删除",
        '0' => "未支付",
        '1' => "已支付",
        '2' => "已发货",
        '3' => "部分发货",
        '4' => "部分退货",
        '5' => "已收货",
        '6' => '已完成',
        '7' => '售后中',
    );

    public function __construct() {
        parent::__construct();
        $this->load->model("exportModel");
        $this->load->model("userModel");
        $this->load->helper("putcsv");
        ini_set("display_errors", 1);
    }

    /**
     * 导出订单
     */
    public function export_order() {
        require_once '../zmcore/libraries/phpexcel/PHPExcel.php';
        require_once '../zmcore/libraries/phpexcel/PHPExcel/IOFactory.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getProperties()->setCreator("上海小伴")
                ->setTitle("上海小伴订单");
        $objPHPExcel->getActiveSheet()->setTitle("订单数据");

        $titles = array(
            "订单编号",
            "购买者",
            "订单状态",
            "付款时间",
            "支付金额",
            "商品编码",
            "商品名称",
            "商品规格",
            "收货人姓名",
            "手机号码",
            "收货城市",
            "收货地址",
            "客户留言"
        );
        $this->write_data(1, $titles, $objPHPExcel);

        //获取订单和报关数据
        $ids = $this->input->post("ids");
        $idsarray = json_decode($ids);
//        var_dump($idsarray);die;
        $orders = $this->exportModel->getOrderDataListByids($idsarray, 0);
        $temparray = array();
        foreach ($orders as $order) {
            $master_order = $order['orderinfo'];
            $products = $master_order['products'];
            $orderStartIndex = 0;
            foreach ($products as $product) {
                //不考虑行政区
                $address = $master_order['address'];
//                preg_match('/(.*?(省|自治区|北京市|天津市|重庆市|上海市))/', $address, $matches);
//                var_dump($matches);
//                if (count($matches) > 1) {
//                    $province = $matches[count($matches) - 2];
//                    $address = substr($address, strlen($province));
//                }
//                preg_match('/(.*?(市|自治州|地区|区划|县))/', $address, $matches);
//                
//                if (count($matches) > 1) {
//                    $city = $matches[count($matches) - 2];
//                    $address = substr($address, strlen($city));
//                }
                $address_array=explode(" ",$address);
                $city=$address_array['1'];
                $address_info=$address_array['0'].$address_array['1'].$address_array['2'].$address_array['3'];
                $rowdata = array(
                    $master_order['nickname'] ? $master_order['nickname'] : $master_order['user_name'],
                    $this->statusname[$master_order['status']],
                    date("y/m/d H:i:s", $master_order['paytime']),
                    $master_order['pay_money'],
                    $product['product_sn'],
                    $product['product_name'],
                    $product['product_special_name'],
                    $master_order['fullname'],
                    $master_order['telephone'],
                    $city,
                    $address_info,
                    $master_order['remark']
                );
                if (!$orderStartIndex) {
                    array_unshift($rowdata, $master_order['order_sn']);
                } else {
                    array_unshift($rowdata, "");
                }
                $orderStartIndex++;
                $temparray[] = $rowdata;
            }
        }

        //写入excle
        $rowindex = 2;
        foreach ($temparray as $order) {
            $this->write_data($rowindex, $order, $objPHPExcel);
            $rowindex++;
        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        $filename = time() . ".xls";
        //设置header
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="' . $filename . '"');
        header("Content-Transfer-Encoding: binary");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        $objWriter->save('php://output'); //输出
        die();
    }

    private function write_data($row, $data, $objPHPExcel) {
        $ascIndex = 65;
        foreach ($data as $d) {
            if ($ascIndex > 90) {
                $index = "A" . chr($ascIndex - 26) . $row;
            } else {
                $index = chr($ascIndex) . $row;
            }
            $objPHPExcel->getActiveSheet()->setCellValueExplicit($index, $d, PHPExcel_Cell_DataType::TYPE_STRING);
            $ascIndex++;
        }
    }

    /**
     * 导出商品
     */
    public function export_product() {
        $filter = $this->input->get();
        $products = $this->exportModel->getProductDatas($filter);

        $title = array(
            "商品ID（该列不可更改）",
            "商品编号",
            "UPC编号",
            "通达序号",
            "商品名称",
            "商品短名",
            "商品简介",
            "代购价格",
            "海淘价格",
            "渠道价格",
            "市场价格",
            "规格型号",
            "销售单位",
            "品牌",
            "申报单位",
            "原产国",
            "产销国",
            "HS编码",
            "总局商品备案号",
            "税率",
            "条码",
            "商品库存",
            "商品重量",
            "商品毛重",
            "参与返点1表示参与，0不参与"
        );
        $list = array();

        if ($products['count'] > 0) {
            foreach ($products['result'] as $product) {

                $list[] = array(
                    $product['product_p_pid'],
                    "'" . $product['product_sn'],
                    "'" . $product['product_upc'],
                    "'" . $product['td_product_code'],
                    $product['product_name'],
                    $product['short_name'],
                    $product['explain'],
                    $product['price'],
                    $product['china_price'],
                    $product['channel_price'],
                    $product['market_price'],
                    $product['GOODS_SPECIFICATION'],
                    $product['unit'],
                    $product['PROD_BRD_CN'],
                    $product['DECLARE_MEASURE_UNIT'],
                    $product['country'],
                    $product['PRODUCTION_MARKETING_COUNTRY'],
                    $product['HS_CODE'],
                    $product['PRODUCT_RECORD_NO'],
                    $product['tariff'],
                    "'" . $product['barCode'],
                    $product['store_number'],
                    $product['weight'],
                    $product['gross_weight'],
                    $product['return_point'],
                );
            }
        }
        $filename = date("Y-m-d") . "_PRODUCT.csv";
        exportTosCsv($filename, $title, $list);
    }

    /**
     * 导出用户信息
     */
    public function export_user() {
        
    }

    public static function getModuleInfo() {
        return array(
            "moduleName" => "导出系统数据",
            "controller" => "Export",
            "author" => "qidazhong@hnzhimo.com",
            "operation" => array(
                "export_order" => "导出订单",
            //"export_product" => "导出商品",
            //"export_user" => "导出用户",
            ),
        );
    }

}
