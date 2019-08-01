<?php

/**
 * 结算函数
 * 
 * @package	ZMshop
 * @author	wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class Checkout extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("ProductModel");
        $this->load->model('CartModel');
        $this->load->model("marketingModel");
        $this->load->model("orderModel");
        $this->load->model("CouponModel");
        $this->load->helper("string");
        $this->load->model("addressModel");
        $this->load->model("UserModel");
        $this->load->model("userAccountLogModel");
    }

    /**
     *  购物车结算
     */
    public function checkout_order($createData = 0) {
        $user_id = $this->session->user_id;
        $cartProducts = $this->CartModel->getCartList($user_id, true);
        $coupon_id = $this->input->post("coupon_id") ? $this->input->post("coupon_id") : 0;
        $use_integral = $this->input->post("use_integral") ? $this->input->post("use_integral") : 0;
        $total_price = 0;
        $cuca_money = 0; //能够使用优惠券的金额
        $is_exchange = 0; //可以参与积分抵扣的产品金额
        $can_use_integral = 0; //
        $result = array('products' => array());
        foreach ($cartProducts as &$product) {
            $product['thumb'] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $product['thumb']);

            $timelimit = $this->ProductModel->getTimelimitInfo($product['product_id']); //是否是限时折扣商品
            if ($timelimit) {
                $product['is_timelimit'] = 1;
                $product['product_price'] = $timelimit['timelimit_price'];
            } else {
                //获取购物车商品优惠策略

                $product['product_marketing'] = $this->marketingModel->getMarketingsForProduct($product['product_id']);
            }
            $product['sum_price'] = $product['product_number'] * $product['product_price'];
            $result['products'][] = $product;
            $total_price += $product['sum_price'];
            if ($product['product_type'] == "O") {
                $cuca_money += $product['sum_price'];
            }
            //获取购物车可参与积分抵扣的商品金额
            if ($product['intergral_deduce'] == 1) {
                $is_exchange += $product['sum_price'];
            }
        }
        //查询可用积分抵扣的商品金额

        $integral = $this->UserModel->getUserById($user_id)["user_intergal"]?$this->UserModel->getUserById($user_id)["user_intergal"]:0;
        $intergral_exchange = $this->systemsetting->get("intergral_exchange");
        $exchange_to_integral = $is_exchange * $intergral_exchange;
        if ($exchange_to_integral > $integral) {
            $can_use_integral = $integral;
            $is_exchange = $integral / 100;
        } else {
            $can_use_integral = $exchange_to_integral;
            $is_exchange = $is_exchange / 100;
        }


        $result['coupon'] = array(); //结算使用的优惠券
        $coupon_discount = 0;
        if ($coupon_id && !$timelimit) {//获取使用的优惠券
            $coupon = $this->CouponModel->getCoupon($coupon_id, $user_id);

            if ($coupon['coupon_type'] == 1) {//减钱券
                $coupon_discount = $coupon['coupon_denomination'];
            }
            if ($coupon['coupon_type'] == 2) {//打折券
                $coupon_discount = $total_price * $coupon['coupon_denomination'] / 100;
            }
            if ($coupon['coupon_type'] == 0) {//减邮费
                $coupon_discount_freeshipping = $total_price * $coupon['coupon_denomination'] / 100;
            }
            if ($coupon['coupon_type'] == -1) {//直接免邮费
                $coupon_discount_freeshipping = "Yes";
            }
            $result['coupon'] = $coupon;
        }

        //计算结算订单可以获取的优惠
        $marketings = $this->getCartGifts($cartProducts, $coupon_id);
        $result['check_marketings'] = $marketings;
        $result['products'] = array_merge($result['products'], $marketings['products']); //把赠品合并到结算商品列表
        //系统运费
        $shipping_fee = $this->get_order_shipping_fee();

        if ($shipping_fee && $marketings['freeshipping'] > 0) {
            $shipping_fee = $shipping_fee - $marketings['freeshipping'];
            //优惠券操作邮费
            if (isset($coupon_discount_freeshipping)) {
                if ($coupon_discount_freeshipping == "Yes") {
                    $shipping_fee = 0;
                } else {
                    $shipping_fee = $shipping_fee - $coupon_discount_freeshipping;
                }
            }
        }
        $result['can_use_integral'] = $can_use_integral;
        $result['is_exchange'] = $is_exchange;
        $result['product_price'] = $total_price;
        $result['cuca'] = $cuca_money - $marketings['discount'];
        $result['shipping_fee'] = empty($shipping_fee) ? 0 : $shipping_fee;
        $result['coupon_discount'] = $coupon_discount;
        $result['total_price'] = $total_price + $shipping_fee; //订单总计金额
        if ($use_integral) {
            $result['total_amount'] = $total_price - $marketings['discount'] + $shipping_fee - $coupon_discount - $is_exchange; //应支付金额
        } else {
            $result['total_amount'] = $total_price - $marketings['discount'] + $shipping_fee - $coupon_discount; //应支付金额
        }


        if ($marketings['discount']) {
            $result['total_price_text'] = "￥" . $total_price . "-￥" . $marketings['discount'] . "=￥" . ($total_price - $marketings['discount']);
        } else {
            $result['total_price_text'] = $total_price;
        }
        if ($createData == 1) {//创建订单调用，至此返回数据
            return $result;
        }
        $error_code = 0;
        $json = array("error_code" => $error_code, "data" => $result);
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    /**
     * 计算订单的运费
     * @param type $address_id 地址id，如果地址id未定义则使用用户的默认地址，两者都不存在返回系统的全局默认运费
     */
    public function get_order_shipping_fee($address_id = 0) {
        $shipping_fee = 0;
        if (!empty($address_id)) {
            $address_id = $this->input->post("address_id");
        }
        $user_id = $this->session->user_id;
        $address = $this->addressModel->getAddressInfo($user_id, $address_id);
        $config = $this->systemsetting->get("shipping_fee_template");
        if (empty($address)) {//没有地址信息
            return 0;
        }
        if (!$config) {//不启用运费模板
            return $shipping_fee = $this->systemsetting->get("shipping_fee");
        }
        if ($config) {
            //根据区域id获取当前区域的运费配置
            $logistic_config = $this->addressModel->getLogisticsList($address['district_id']);
            if (empty($logistic_config)) {//没有配置区域运费使用系统默认统一运费
                $shipping_fee = $this->systemsetting->get("shipping_fee");
            } else {
                $lconfig = $logistic_config[0];
                $product_weight = $this->cartProductsWeight();
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

        return $shipping_fee;
    }

    /**
     * 购物车商品总重量
     * @return float 商品重量Kg
     */
    private function cartProductsWeight() {
        $cartProducts = $this->CartModel->getCartList($this->session->user_id);
        $total_weight = 0;
        foreach ($cartProducts as $product) {
            $total_weight += $product['product_weight'];
        }
        return $total_weight / 1000;
    }

    /**
     * 创建订单
     */
    public function create_order() {
        //获取购物车信息，优惠活动等
        $user_id = $this->session->user_id;

        $address_id = $this->input->post("address_id");
        $this->load->model("AddressModel");
        $userAddress = $this->AddressModel->getAddressInfo($user_id, $address_id);
        $address = $userAddress['province_name'] . ' ' . $userAddress['city_name'] . ' ' . $userAddress['district_name'] . ' ' . $userAddress['address'];
        $error_code = 1;
        $order_id = 0;
        $data = $this->checkout_order(1);

        if (!empty($data['products'])) {
            $orderdata = array(
                "order_amount" => $data['total_amount'],
                "user_id" => $user_id,
                "product_amount" => $data['product_price'],
                "address" => $address,
                "coupon_id" => $data['coupon'] ? $data['coupon']['coupon_id'] : '',
                "save_money" => $data['coupon_discount'] + $data['check_marketings']['discount'],
                "order_type" => "O",
                "exchange_price" => $data['is_exchange'],
                "exchange_integral" => $data['can_use_integral'],
                "createtime" => time(),
                "fullname" => $userAddress['name'],
                "telephone" => $userAddress['telephone'],
                "payment_id" => "2",
                "payment_name" => "微信小程序支付",
                "postage" => $data['shipping_fee'],
                "from_id" => $this->session->user_info['parent_user_id'],
                'remark' => $this->input->post("remark")
            );

            $orderdata['order_marketings'] = $data['check_marketings']['marketings'];

            $orderdata['products'] = $data['products'];

            $orderdata['coupon'] = $data['coupon'];
            if (!empty($orderdata['coupon'])) {
                $orderdata['coupon']['save_money'] = $data['coupon_discount'];
            }

            $orderdata['groupbuy_data'] = '';
            $error_code = 1;
            $order_id = $this->orderModel->addOrder($orderdata);
            //生成订单更新积分
            if ($data['is_exchange'] && $data['can_use_integral']) {
                $intergal = $data['can_use_integral'];
                $remark = "订单生成抵扣".$data['can_use_integral']."积分";
                $change_type = 4;
                $user_account = $this->UserModel->setUseIntergal($user_id, $intergal,"-");
                if ($user_account) {
                    $this->userAccountLogModel->addIntergalLog(array("user_id" => $user_id, "change_intergal" => $intergal, "change_cause" => $remark, "createtime" => time(), "change_type" => $change_type));
                    return true;
                } 
            }
            //增加统计表中的订单金额
            $this->load->model("staticsModel");
            $this->staticsModel->update(array("totalfee", $data['total_amount']));
            if ($order_id) {
                $error_code = 0;
                //删除购物车商品
                $this->CartModel->clearCart($user_id);
            }
        }
        $json = array("error_code" => $error_code, "data" => array("order_id" => $order_id, "amount" => $data['total_amount']));
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    /**
     * 订单支付详情：生成微信支付参数（如果余额不足）
     * 如果余额充足用户点击支付，前端携带参数回调余额支付notify/balance_callback.html
     * @todo 安全验证
     */
    public function order_pay() {
        $order_id = $this->input->post("order_id");
        $order_info = $this->orderModel->getOrderInfo(array("order_id" => $order_id));
        //生成支付信息
        $payParam = array();
        $this->load->model("paymentModel");
        $wxpayInfo = $this->paymentModel->getPayInfo(2);
        if (empty($wxpayInfo)) {
            $error_code = 4; //支付已经关闭
        } else {
            //计算可用余额
            $amount = $order_info['order_amount'];
            $this->load->model("userModel");
            $user_account = $this->userModel->getUserAccount($order_info['user_id']);
            if ($user_account['totalmoney'] > 0) {
                $amount -= $user_account['totalmoney'];
            }
            if ($amount <= 0) {
                $amount = 0;
                $use_balance = $order_info['order_amount']; //订单使用的余额
            } else {
                $use_balance = $user_account['totalmoney'];
            }
            $order_info['use_balance'] = $use_balance;

            if ($amount > 0) {//余额不足，支付剩余部分
                //获取支付配置参数
                $wxpayconfig = $this->systemsetting->getSettingsByGroup($wxpayInfo['setting_flag']);
                $payconfigs = array(
                    "partnerkey" => $wxpayconfig['wxpay_key'],
                    "appid" => $wxpayconfig['wxpay_appid'],
                    "mch_id" => $wxpayconfig['mch_id'],
                    "ssl_key" => $wxpayconfig['wx_apiclient_key'],
                    "ssl_cer" => $wxpayconfig['wx_apiclient_cert'],
                );

                $this->load->library("wechat_pay", $payconfigs); //加载支付类库
                $data = array(
                    "body" => "支付订单",
                    "attach" => "order|" . $use_balance,
                    "out_trade_no" => $order_info['order_sn'],
                    "total_fee" => $amount * 100,
                    "trade_type" => "JSAPI",
                    "openid" => $this->session->user_info['wx_fun_openid'],
                    "notify_url" => site_url('', "https") . "/notify/wechat_fun.html"
                );
                $payParam = $this->wechat_pay->createMchPay($data);
                $error_code = 0;
            } else {
                $payParam = array("notify_url" => "notify/balance_callback.html");
                $error_code = 0;
            }
            $order_info['result_amount'] = sprintf("%01.2f", $amount);
        }
        $result = array("error_code" => $error_code, 'data' => array("orderInfo" => $order_info, "payParams" => $payParam));
        $this->output->set_content_type("application/json")->set_output(json_encode($result));
    }

    /**
     * 获取结算当前购物车可享受的所有优惠策略
     */
    private function getCartGifts($cartProducts, $coupon_id) {

        $marketings = $this->marketingModel->getMarketingsForCheckout($cartProducts, $coupon_id);
        $result = array(
            "products" => array(),
            "coupons" => array(),
            "rewards" => 0,
            "discount" => 0,
            "freeshipping" => -1
        );
        $result['marketings'] = $marketings;

        foreach ($marketings as $marketing) {
            if ($marketing['marketing_kind'] == "achieve_discount") {
                $result['discount'] += $marketing['marketing_discount'];
            }
            if ($marketing['marketing_kind'] == "achieve_give") {
                $give_productsid = array_unique(array_filter(explode("|", $marketing['give_product'])));
                foreach ($give_productsid as $product_id) {
                    $give_product = $this->ProductModel->getProductInfo($product_id);
                    $give_product['thumb'] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $give_product['thumb']);
                    $give_product['product_name'] = "【赠品】" . $give_product['product_name'];
                    $give_product['product_number'] = 1;
                    $give_product['is_gift'] = 1;
                    $result['products'][] = $give_product;
                }
            }
            if ($marketing['marketing_kind'] == "achieve_coupon") {//满赠优惠券
                $result['coupons'][] = $this->CouponModel->getCoupon($marketing['marketing_coupon']);
            }
            if ($marketing['marketing_kind'] == "achieve_reward") {
                $result['rewards'] += $marketing['marketing_reward'];
            }
            if ($marketing['marketing_kind'] == "achieve_freeshipping" && $result['freeshipping'] != 0) {
                if ($marketing['marketing_shipping'] == 0) {
                    $result['freeshipping'] = 0;
                } else {
                    $result['freeshipping'] += $marketing['marketing_shipping'];
                }
            }
        }
        return $result;
    }

    /**
     * 获取用户结算可用的优惠券
     */
    public function get_valid_coupons() {
        $user_id = $this->session->user_id;
        $totalprice = $this->input->post("total_price");
        $coupons = $this->CouponModel->getCanuseCoupons($user_id, $totalprice);
        $error_code = 0;
        $json = array("error_code" => $error_code, "data" => $coupons);
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

}
