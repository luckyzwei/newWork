<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KillProduct
 *
 * @author wangxiangshuai
 */
class KillProduct extends CI_Controller {

//put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('KillProductModel');
        $this->load->helper('string');
        $this->load->model("orderModel");
    }

    public function get_killproducts() {
        $page = $this->input->post('page') ? $this->input->post('page') : 1;
        $limit = $this->input->post('limit') ? $this->input->post('limit') : 10;

        $killproductList = $this->KillProductModel->getKillProducts($page, $limit);

        foreach ($killproductList as &$product) {
            $product['thumb'] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $product['thumb']);
        }

        $this->output->set_content_type("application/json")->set_output(json_encode(array('data' => $killproductList, 'error_code' => 0)));
    }

    public function get_killproduct() {
        $kill_product_id = $this->input->post("kill_product_id");
        $user_id = $this->session->user_id;
        $killproduct = $this->KillProductModel->getKillProduct($kill_product_id);
        if (!empty($killproduct)) {
            $killproduct['thumb'] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $killproduct['thumb']);
            $images = unserialize($killproduct['images']);
            if (!empty($images)) {
                $killproduct['images'] = array();
                foreach ($images as $value) {
                    $killproduct['images'][] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $value);
                }
            }
            if (empty($killproduct['kill_product_endtime'])) {
                $killproduct['kill_product_endtime'] = 260000;
            } else {
                $killproduct['kill_product_endtime'] -= time();
            }
            $killorders = $this->KillProductModel->checkKillOrder($user_id, $killproduct['product_id']);
            $killproduct['order_id'] = $killorders ? $killorders : 0;
        }

        $this->output->set_content_type("application/json")->set_output(json_encode(array('data' => $killproduct, 'error_code' => 0)));
    }

    /**
     * 检查开团数据
     */
    public function check_kill($return = false) {
        $error_code = 0;
        $data = array();
        $this->load->model('addressModel');
        $kill_product_id = $this->input->post("kill_product_id");
        $address_id = $this->input->post('address_id');
        $user_id = $this->session->user_id;

        $data['killproduct'] = $this->KillProductModel->getKillProduct($kill_product_id);


        if (empty($data['killproduct'])) {
            $data = "活动已结束";
            $error_code = 1;
        } else {
            if (!empty($data['killproduct']['kill_product_endtime'])) {
                if ($data['killproduct']['kill_product_endtime'] < time()) {
                    $data = "活动已结束";
                    $error_code = 1;
                }
            }
        }
        if (empty($error_code) && $data['killproduct']['kill_product_store'] < 1) {
            $error_code = 1;
            $data = '库存不足';
        }
        if (empty($error_code)) {
            $data['products'][] = array(
                'thumb' => reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $data['killproduct']['thumb']),
                'product_name' => $data['killproduct']['product_name'],
                'product_price' => $data['killproduct']['market_price'],
                'product_id' => $data['killproduct']['product_id'],
                'product_number' => 1,
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
                    $product_weight = $data['killproduct']['product_weight'] / 1000;
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
            $total_price = $data['killproduct']['market_price'];
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

    public function create_kill_order() {
        $user_id = $this->session->user_id;
        $kill_product_id = $this->input->post("kill_product_id");
        $data = $this->check_kill(true);
        $error_code = 0;
        if (!is_array($data)) {
            $error_code = 1;
        } elseif (empty($data['addressinfo'])) {
            $error_code = 2;
            $data = '地址不存在';
        }
        //检查是否在该活动有订单
        $killorders = $this->KillProductModel->checkKillOrder($user_id, $kill_product_id);
        if ($killorders) {
            $error_code = 3;
            $data = '存在未支付活动';
        }

        if (empty($error_code) && !empty($data['products'])) {
            $orderdata = array(
                "order_amount" => $data['total_amount'],
                "user_id" => $user_id,
                "product_amount" => $data['product_price'],
                "address" => $data['addressinfo']['province_name'] . ' ' . $data['addressinfo']['city_name'] . ' ' . $data['addressinfo']['district_name'] . ' ' . $data['addressinfo']['address'],
                "coupon_id" => '',
                "save_money" => 0,
                "order_type" => "K",
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
            $orderdata['groupbuy_data'] = array();
            $order_id = $this->orderModel->addOrder($orderdata);
            //增加统计表中的订单金额-
            /* $this->load->model("staticsModel");
              $this->staticsModel->update(array("totalfee", $data['total_amount'])); */

            $data = array("order_id" => $order_id, "amount" => $data['total_amount']);
        }
        $json = array("error_code" => $error_code, "data" => $data);
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    public function get_killorder() {
        $order_id = $this->input->post('order_id');
        $product = $this->orderModel->getOrderProduct($order_id);
        $data['product'] = array_shift($product);
        $data['killproduct'] = $this->KillProductModel->getKillProductByproduct_id($data['product']['product_id']);
        $data['orderinfo'] = $this->orderModel->getOrderInfo(array('order_id' => $order_id));
        $data['orderinfo']['already_reduced_price'] = round($data['killproduct']['market_price'] - $data['orderinfo']['order_amount'], 2);
        $data['orderinfo']['surplus_reduced_price'] = round($data['orderinfo']['order_amount'] - $data['killproduct']['kill_product_min_price'], 2);
        $endtime = $data['orderinfo']['createtime'] + $data['killproduct']['kill_price_time'] * 3600;
        if ($endtime > $data['killproduct']['kill_product_endtime'] && $data['killproduct']['kill_product_endtime'] > 0) {
            $endtime = $data['killproduct']['kill_product_endtime'];
        }
        $data['orderinfo']['percent'] = intval($data['orderinfo']['already_reduced_price'] / ($data['killproduct']['market_price'] - $data['killproduct']['kill_product_min_price']) * 100);
        $endtime = $endtime - time();
        if ($endtime > 0) {
            $day = intval($endtime / 86400);
            $h = intval($endtime % 86400 / 3600);
            $m = intval($endtime % 3600 / 60);
            $s = $endtime % 60;
            $data['orderinfo']['endtime'] = ($day > 0 ? ($day . '天') : '') . ($h > 0 ? ($h . '时') : '') . ($m > 0 ? ($m . '分') : '') . ($s > 0 ? ($s . '秒') : '');
        } else {
            $data['orderinfo']['endtime'] = 0;
        }
        $data['killlog'] = $this->KillProductModel->getKillOrderLog($order_id);
        $json = array("error_code" => 0, "data" => $data);
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    public function kill_price() {
        $order_id = $this->input->post('order_id');
        $user_id = $this->session->user_id;
        $result_product = $this->orderModel->getOrderProduct($order_id);
        $product = array_shift($result_product);
        $killproduct = $this->KillProductModel->getKillProductByproduct_id($product['product_id']);
        $killlog = $this->KillProductModel->checkKillLog($user_id, $killproduct['kill_product_id']);
        $orderinfo = $this->orderModel->getOrderInfo(array('order_id' => $order_id));
        if ($killlog || $orderinfo['status'] > 0) {
            //已经砍过
            $result_kill = $this->KillProductModel->getKillOrderLog($order_id, $user_id);
            $data = array_shift($result_kill);
            $data['msg'] = $killlog ? "已在参与本次活动砍价" : "订单已支付";
        } else {
            //未砍过
            $reduced_price = 0;
            if ($orderinfo['order_amount'] > $killproduct['kill_product_min_price']) {
                $diff = $orderinfo['order_amount'] - $killproduct['kill_product_min_price']; //剩余可以砍的金钱
                if ($killproduct['kill_price_type'] == 1) {
                    //固定金额
                    $reduced_price = $killproduct['kill_fixed_price'] > $diff ? $diff : $killproduct['kill_fixed_price'];
                } else {
                    //随机金额
                    $killlog = $this->KillProductModel->getKillOrderLog($order_id);
                    $num = $killproduct['kill_price_number'] - count($killlog); //剩余所需人数
                    if ($num > 1) {
                        //这里随机金额
                        $average_price = intval($diff / $num * 100); //平均每个人 
                        $coefficient = rand(100, 290); //随机一个倍率 1-2.9倍
                        $reduced_price = round($average_price * $coefficient / 10000, 2); //计算出一个不会过大数值
                        if ($reduced_price > $diff) {
                            //防止2人的时候算出了 2倍以上
                            $reduced_price = $reduced_price - $diff;
                        }
                    } elseif ($num == 1) {
                        //这里最后一次全部砍完
                        $reduced_price = $diff;
                    }
                    //else 这里一般不会出现 最后一次需要全部砍完
                }
                //这里计算完需要砍的价格 $reduced_price
                $data = array(
                    'reduced_price' => $reduced_price,
                    'original_price' => $orderinfo['order_amount'],
                    'order_id' => $order_id,
                    'user_id' => $user_id,
                    'kill_product_id' => $killproduct['kill_product_id'],
                    'msg' => ''
                );
                $this->KillProductModel->kill_Price($data);
            }
        }
        $json = array("error_code" => 0, "data" => $data);
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    public function get_killorders() {
        $user_id = $this->session->user_id;
        $limit = $this->input->post('limit');
        $page = $this->input->post('page');
        $page = empty($page) ? 1 : $page;
        $limit = empty($limit) ? 10 : $limit;
        $killlist = $this->KillProductModel->getKillLits(array('user_id' => $user_id), $page, $limit);
        foreach ($killlist as &$order) {
            $order['killprice'] = round($order['product_amount'] - $order['order_amount'], 2);
            $order['surplusprice'] = round($order['product_amount'] - $order['order_amount'] - $order['kill_product_min_price'], 2);
            $endtime = $order['createtime'] + $order['kill_price_time'] * 3600;
            if ($endtime > $order['kill_product_endtime'] && $order['kill_product_endtime'] > 0) {
                $endtime = $order['kill_product_endtime'];
            }
            $endtime = $endtime - time();
            if ($endtime > 0) {
                $day = intval($endtime / 86400);
                $h = intval($endtime % 86400 / 3600);
                $m = intval($endtime % 3600 / 60);
                $s = $endtime % 60;
                $order['endtime'] = ($day > 0 ? ($day . '天') : '') . ($h > 0 ? ($h . '时') : '') . ($m > 0 ? ($m . '分') : '') . ($s > 0 ? ($s . '秒') : '');
            } else {
                $order['endtime'] = 0;
            }
        }
        $this->output->set_content_type("application/json")->set_output(json_encode(array('data' => $killlist, 'error_code' => 0)));
    }

}
