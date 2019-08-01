<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GroupProduct
 *
 * @author wangxiangshuai
 */
class GroupProduct extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model("GroupProductModel");
        $this->load->model('GroupOrderModel');
        $this->load->helper("string");
    }

    /**
     * 获取拼团商品
     */
    public function get_groupproducts() {
        $page = $this->input->post('page') ? $this->input->post('page') : 1;
        $limit = $this->input->post('limit') ? $this->input->post('limit') : 10;

        $groupproductList = $this->GroupProductModel->getGroupProducts($page, $limit);

        foreach ($groupproductList as &$product) {
            $product['thumb'] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $product['thumb']);
        }

        $this->output->set_content_type("application/json")->set_output(json_encode(array('data' => $groupproductList, 'error_code' => 0)));
    }

    public function get_groupproduct() {
        $group_product_id = $this->input->post("group_product_id");
        $groupproduct = $this->GroupProductModel->getGroupProduct($group_product_id);
        if (!empty($groupproduct)) {
            $groupproduct['thumb'] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $groupproduct['thumb']);
            $images = unserialize($groupproduct['images']);
            if (!empty($images)) {
                $groupproduct['images'] = array();
                foreach ($images as $value) {
                    $groupproduct['images'][] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $value);
                }
            }
            if (empty($groupproduct['endtime'])) {
                $groupproduct['endtime'] = 260000;
            } else {
                $groupproduct['endtime'] -= time();
            }
        }
        $groupbuy_sn = $this->input->post('groupbuy_sn');
        //这里检查团详情
        $groupproduct['again_act'] = 0; // 按钮文字  0 开团   1 参团  2重新开团
        if (!empty($groupbuy_sn)) {
            $groupproduct['groupbuy'] = $this->GroupOrderModel->getGroupbuyBysn($groupbuy_sn);
            $groupproduct['again_act'] = count($groupproduct['groupbuy']) >= $groupproduct['group_user_num'] ? 2 : 1;
        }
        $groupproduct['group_list'] = array();
        if ($groupproduct['show_group_list'] > 0) {
            $groupproduct['group_list'] = $this->GroupOrderModel->getGroupLits(array('group_product_id' => $group_product_id, 'status' => array(1), 'endtime' => time()), 1, 99);
        }
        $this->output->set_content_type("application/json")->set_output(json_encode(array('data' => $groupproduct, 'error_code' => 0)));
    }

    /**
     * 获取自己的团订单
     */
    public function get_groupbuys() {
        $user_id = $this->session->user_id;
        $limit = $this->input->post('limit');
        $page = $this->input->post('page');
        $page = empty($page) ? 1 : $page;
        $limit = empty($limit) ? 10 : $limit;
        $grouplist = $this->GroupOrderModel->getGroupLits(array('user_id' => $user_id), $page, $limit);
        foreach ($grouplist as &$groupproduct) {
            if (!empty($groupproduct)) {
                $groupproduct['thumb'] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $groupproduct['thumb']);
                $groupproduct['groupbuy'] = $this->GroupOrderModel->getGroupbuyBysn($groupproduct['groupbuy_sn']);
            }
            if ($groupproduct['status'] == "2" && count($groupproduct['groupbuy']) < (int)$groupproduct['group_user_num']) {
                $num =(int)$groupproduct['group_user_num']-count($groupproduct['groupbuy']);
                $num_query=$this->random($num);
                $headimg=array();
                foreach ($num_query as $value){
                    $headimg['wx_headimg']=reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") ."/headimg_".$value.".jpg");
                    array_push($groupproduct['groupbuy'],$headimg);
                }
            }
        }
        $this->output->set_content_type("application/json")->set_output(json_encode(array('data' => $grouplist, 'error_code' => 0)));
    }

    public function random($num) {
        $tmp = array();
        while (count($tmp) < $num) {
            $tmp[] = mt_rand(1, 22);
            $tmp = array_unique($tmp);
        }
        return $tmp;
    }

    /**
     * 获取自己的团订单
     */
    public function get_groupbuy() {

        $groupbuy_id = $this->input->post('groupbuy_id');
        $groupbuy = $this->GroupOrderModel->getGroupbuy($groupbuy_id);
        $this->output->set_content_type("application/json")->set_output(json_encode(array('data' => $groupbuy, 'error_code' => 0)));
    }

    /**
     * 检查开团数据
     */
    public function check_group($return = false) {
        $error_code = 0;
        $data = array();
        $this->load->model('addressModel');
        $group_product_id = $this->input->post("group_product_id");
        $groupbuy_sn = $this->input->post('groupbuy_sn');
        $address_id = $this->input->post('address_id');
        $user_id = $this->session->user_id;
        $product_number = $this->input->post('product_number');

        $data['groupproduct'] = $this->GroupProductModel->getGroupProduct($group_product_id);


        //检查限制购买数量
        $number = $this->GroupOrderModel->getGroupProductNum($user_id, $group_product_id, $data['groupproduct']['product_id']);
        if (empty($error_code) && $return && $number >= $data['groupproduct']['group_user_num_every']) {
            $data = "您已购买" . $number . '已达到限购' . $data['groupproduct']['group_user_num_every'] . '件';
            $error_code = 1;
        } elseif (!empty($groupbuy_sn)) {
            //这里检查团详情
            $data['groupbuy'] = $this->GroupOrderModel->getGroupbuyBysn($groupbuy_sn);

            if (count($data['groupbuy']) >= $data['groupproduct']['group_user_num'] && $return) {
                $data = "该团已满";
                $error_code = 1;
            } elseif ($data['groupbuy'][0]['endtime'] < time() && $return) {
                $data = "该团已结束";
                $error_code = 1;
            } else if ($return) {
                foreach ($data['groupbuy'] as $value) {
                    if ($value['user_id'] == $user_id) {
                        if ($value['status'] == 0) {
                            $data = "已在该团中有订单";
                            $error_code = 3;
                        } else {
                            $data = "已在该团中";
                            $error_code = 1;
                        }
                    }
                }
            }
        }


        if (empty($error_code) && $return && empty($data['groupproduct'])) {
            $data = "活动已结束";
            $error_code = 1;
        }
        if (empty($error_code) && $return && $data['groupproduct']['group_product_store'] < 1) {
            $error_code = 1;
            $data = '库存不足';
        }
        if (empty($error_code)) {
            $data['products'][] = array(
                'thumb' => reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $data['groupproduct']['thumb']),
                'product_name' => $data['groupproduct']['product_name'],
                'product_price' => $data['groupproduct']['group_product_price'],
                'product_number' => $product_number,
                'product_id' => $data['groupproduct']['product_id'],
                'supplier_id' => 0
            );
            $shipping_fee = 0;
            $data['addressinfo'] = $address = $this->addressModel->getAddressInfo($user_id, $address_id);
            $config = $this->systemsetting->get("shipping_fee_template");
            if (!$config) {//不启用运费模板
                $shipping_fee = $this->systemsetting->get("shipping_fee");
            }
            if ($config) {
                //根据区域id获取当前区域的运费配置
                $logistic_config = $this->addressModel->getLogisticsList($address['district_id']);
                if (empty($logistic_config)) {//没有配置区域运费使用系统默认统一运费
                    $shipping_fee = $this->systemsetting->get("shipping_fee");
                } else {
                    $lconfig = $logistic_config[0];
                    $product_weight = $data['groupproduct']['product_weight'] * $product_number / 1000;
                    $overstep_weight = $product_weight - $lconfig['logistics_weight'];
                    if ($overstep_weight <= 0) {
                        $shipping_fee = $lconfig['logistics_fee'];
                    } else {
                        $shipping_fee = $lconfig['logistics_fee'] + ceil($overstep_weight) * $lconfig['logistics_add_fee'];
                    }
                }
            } else {
                $shipping_fee = $this->systemsetting->get("shipping_fee");
            }
            $data['coupon'] = array();
            $data['check_marketings'] = '';
            $total_price = $data['groupproduct']['group_product_price'] * $product_number;
            $data['product_price'] = round($total_price, 2);
            $data['cuca'] = 0;
            $data['shipping_fee'] = round($shipping_fee, 2);
            $data['coupon_discount'] = 0;
            $data['total_amount'] = $data['total_price'] = round($total_price + $shipping_fee, 2); //订单总计金额
        }
        if ($return) {
            return $data;
        }
        $json = array("error_code" => $error_code, 'data' => $data);
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    public function create_group_order() {
        $user_id = $this->session->user_id;
        $groupbuy_sn = $this->input->post('groupbuy_sn');
        $group_product_id = $this->input->post("group_product_id");
        $data = $this->check_group(true);
        $error_code = 0;
        if (!is_array($data)) {
            $error_code = 1;
        } elseif (empty($data['addressinfo'])) {
            $error_code = 2;
            $data = '地址不存在';
        }

        if (empty($error_code) && !empty($data['products'])) {
            $orderdata = array(
                "order_amount" => $data['total_amount'],
                "user_id" => $user_id,
                "product_amount" => $data['product_price'],
                "address" => $data['addressinfo']['province_name'] . ' ' . $data['addressinfo']['city_name'] . ' ' . $data['addressinfo']['district_name'] . ' ' . $data['addressinfo']['address'],
                "coupon_id" => '',
                "save_money" => 0,
                "order_type" => "G",
                "createtime" => time(),
                "fullname" => $data['addressinfo']['name'],
                "telephone" => $data['addressinfo']['telephone'],
                "payment_id" => "2",
                "payment_name" => "微信小程序支付",
                "postage" => $data['shipping_fee'],
                "from_id" => $this->session->user_info['parent_user_id'],
                'remark' => $this->input->post("remark")
            );

            $orderdata['order_marketings'] = array();

            $orderdata['products'] = $data['products'];

            $orderdata['coupon'] = $data['coupon'];
            $this->load->model("orderModel");

            if (!empty($data['groupbuy'])) {
                //参加别人的团
                $orderdata['groupbuy_data'] = array(
                    'groupbuy_sn' => $groupbuy_sn,
                    "user_id" => $user_id,
                    'group_product_id' => $group_product_id,
                    "createtime" => time(),
                    'endtime' => array_shift($data['groupbuy'])['endtime'],
                );
            } else {
                //自己开团
                $orderdata['groupbuy_data'] = array(
                    'groupbuy_sn' => $this->GroupOrderModel->getOrderSn(),
                    "user_id" => $user_id,
                    'group_product_id' => $group_product_id,
                    "createtime" => time(),
                    'endtime' => time() + $data['groupproduct']['group_time'] * 3600,
                );
            }

            $this->input->post('groupbuy_sn');
            $order_id = $this->orderModel->addOrder($orderdata);
            //增加统计表中的订单金额-
            $this->load->model("staticsModel");
            $this->staticsModel->update(array("totalfee", $data['total_amount']));

            $data = array("order_id" => $order_id, "amount" => $data['total_amount']);
        }
        $json = array("error_code" => $error_code, "data" => $data);
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

}
