<?php

/**
 * 购物车控制器
 * 
 * @package	ZMshop
 * @author	wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class Cart extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("CartModel");
        $this->load->model("ProductModel");
        $this->load->model("GroupProductModel");
        $this->load->model("marketingModel");
        $this->load->model("CouponModel");
        $this->load->helper("string");
    }

    /**
     * 添加商品到购物车
     */
    public function add_cart() {
        $error_code = 0;
        $user_id = $this->session->user_id;

        $product_number = $this->input->post('product_number');
        $product_type = $this->input->post('product_type');
        $activity_product_id = $this->input->post('activity_product_id');
        $product_special_id = $this->input->post('product_special_id');
        $product_id = $this->input->post('product_id');
        $prodcut_special = $this->ProductModel->getSpecial($product_id, $product_special_id);
        $product = $this->ProductModel->getProductInfo($product_id);

        if (!empty($product)) {

            //检查库存设置
            $product_number ? $product_number : 1;
            if (!empty($prodcut_special)) {
                $product_store = $prodcut_special['goods_store'];
            } else {
                $product_store = $product['store_number'];
            }

            if ($product['check_store'] == 1 && $product_number > $product_store) {
                $data = '库存不足';
                $error_code = 6;
            }
            if ($product['check_store'] == 0) {//检查系统库存配置
                $system_store_set = $this->systemsetting->get("check_store");
                if ($system_store_set && $product_number > $product_store) {
                    $error_code = 6;
                    $data = '库存不足';
                }
            }
            //验证活动 库存等 条件
            if (!empty($activity_product_id) && $product_type == 'G') {
                $activity_product = $this->GroupProductModel->getGroupProduct($activity_product_id);
                $activity_product['price'] = $activity_product['group_product_price'];
                if ($activity_product['group_product_store'] < 1) {
                    $error_code = 6;
                    $data = '库存不足';
                }
                if (empty($activity_product)) {
                    $error_code = 6;
                    $data = '活动商品不存在';
                }
            } elseif (!empty($activity_product_id) && $product_type == 'K') {
                
            }elseif (!empty($activity_product_id) && $product_type == 'T') {
                $activity_product = $this->ProductModel->getTimelimitInfo($product['product_id']); //是否是限时折扣商品
                $activity_product['price'] = $activity_product['timelimit_price'];
                if ($activity_product['timelimit_num'] < 1) {
                    $error_code = 6;
                    $data = '库存不足';
                }
            }

            if (empty($error_code)) {
                //更新价格
                if (!empty($activity_product)) {
                    $data['product_price'] = $activity_product['price'];
                } else {
                    $data['product_price'] = $this->ProductModel->getUserDiscountPrice($user_id, $product_id, $product_special_id)['user_price'];
                    if (!empty($product['store_product_id'])) {//店铺模式需要加上店铺之间的差价
                        $data['product_price'] = $data['product_price'] + ($product['store_product_price'] - $product['price']);
                    }
                }

                $data['product_id'] = $product_id;
                $data['supplier_id'] = $product['supplier_id'];
                $data['product_name'] = $product['product_name'];
                $data['product_special_name'] = @$prodcut_special['goods_special_name'];
                $data['product_special_id'] = $product_special_id;
                $data['product_weight'] = $product['weight'];
                $data['user_id'] = $user_id;
                $data['createtime'] = time();
                $data['product_number'] = $product_number;
                $data['product_type'] = empty($product_type) ? 'O' : $product_type; //O普通 T限时 G团购  K砍价
                $data['cart_id'] = $this->CartModel->addCart($data);
            }
        } else {
            $data = '商品下架';
            $error_code = 3;
        }

        $json = array("error_code" => $error_code, 'data' => $data);
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    /**
     * 检查购物车中是否有有商品
     */
    public function check_cart_num() {
        $user_id = $this->session->user_id;
        $cartProducts = $this->CartModel->getCartList($user_id);
        $error_code = 1;
        if (!empty($cartProducts)) {
            $error_code = 0;
        }
        $json = array("error_code" => $error_code, 'data' => count($cartProducts));
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    /**
     * 获取购物车商品
     */
    public function get_cart_products() {
        $user_id = $this->session->user_id;
        $cartProducts = $this->CartModel->getCartList($user_id);
        $total_price = 0;
        $result = array();
        if (!empty($cartProducts)) {
            $checkProducts = array();
            //@todo 更新购物车商品信息
            foreach ($cartProducts as &$product) {
                if (!empty($product['special_id'])) {
                    $special_array = unserialize($product['specifications']);
                    $product['thumb'] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $special_array[array_search("goods_" . $product['product_special_id'], array_column($special_array, 'goods_code'))]['specialimg']);
                } else {
                    $product['thumb'] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $product['thumb']);
                }
                $timelimit = $this->ProductModel->getTimelimitInfo($product['product_id']);
                if ($timelimit) {
                    $product['is_timelimit'] = 1;
                    $product['product_price'] = $timelimit['timelimit_price'];
                } else {
                    //获取购物车商品优惠策略
                    if (!$product['is_gift']) {
                        $product['product_marketing'] = $this->marketingModel->getMarketingsForProduct($product['product_id']);
                    }
                }
                $product['sum_price'] = $product['product_number'] * $product['product_price'];

                $result['products'][] = $product;
                if ($product['checkout']) {
                    $total_price += $product['sum_price']; //结算总计
                    $checkProducts[] = $product;
                }
            }
            //当前优惠策略活动提醒
            $result['order_marketing'] = $this->marketingModel->getMarketingsForcart($checkProducts);

            //计算打折后的价格和赠品
            $marketings = $this->marketingModel->getMarketingsForCheckout($checkProducts);


            $discount = 0;


            foreach ($marketings as $marketing) {
                if ($marketing['marketing_kind'] == "achieve_discount") {
                    $discount += $marketing['marketing_discount'];
                }
                if ($marketing['marketing_kind'] == "achieve_give") {
                    $give_productsid = array_unique(array_filter(explode("|", $marketing['give_product'])));
                    foreach ($give_productsid as $product_id) {//赠品加入到列表
                        $give_product = $this->ProductModel->getProductInfo($product_id);
                        $give_product['thumb'] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $give_product['thumb']);
                        if (!empty($give_product)) {
                            $give_product['product_name'] = "[赠品]" . $give_product['product_name'];
                            $give_product['is_gift'] = 1;
                        }
                        $result['products'][] = $give_product;
                    }
                }
            }
            $result['total_price'] = $total_price;
            $result['total_amount'] = $total_price - $discount;
            $result['discount'] = $discount;
            if ($discount) {
                $result['total_amount_text'] = "￥" . $total_price . "-￥" . $discount . "=￥" . ($total_price - $discount);
            } else {
                $result['total_price_text'] = $total_price;
                $result['total_amount_text'] = "￥" . $total_price;
            }
            $error_code = 0;
            $json = array("error_code" => $error_code, "data" => $result);
        } else {
            $error_code = 1; //购物车为空
            $json = array("error_code" => $error_code);
        }
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    /**
     * 编辑购物车商品数量
     */
    public function set_cart_product_num() {
        $user_id = $this->session->user_id;
        $cart_id = $this->input->post('cart_id');
        $product_number = $this->input->post("product_number");
        $error_code = 0;
        if ($product_number > 0) {
            //获取当前购物车商品的信息
            $cart_product = $this->CartModel->getCartProduct($cart_id, $user_id);
            $product = $this->ProductModel->getProductInfo($cart_product['product_id']);

            //检查库存设置
            $product_special = $this->ProductModel->getSpecial($cart_product['product_id']);
            if (!empty($product_special)) {
                $product_store = $product_special['goods_store'];
            } else {
                $product_store = $product['store_number'];
            }

            if ($product['check_store'] == 1 && $product_number > $product_store) {
                $error_code = 6;
            }
            if ($product['check_store'] == 0) {//检查系统库存配置
                $system_store_set = $this->systemsetting->get("check_store");
                if ($system_store_set && $product_number > $product_store) {
                    $error_code = 6;
                }
            }
            if (empty($error_code)) {
                $this->CartModel->set_number($cart_id, $product_number);
            }
        } else {
            $this->CartModel->delectCart($cart_id, $user_id);
        }

        $json = json_encode(array("error_code" => $error_code));
        $this->output->set_content_type("application/json")->set_output($json);
    }

    /**
      设置购物车商品的结算状态
     * */
    public function set_cart_check_status() {
        $user_id = $this->session->user_id;
        $cart_id = $this->input->post("cart_id"); //===all的时候表示全部结算
        $chk_status = $this->input->post("chk_status");
        $this->CartModel->setChkStatus($cart_id, $user_id, $chk_status);
    }

    /** 删除购物车商品
     * 
     */
    public function delect_cart() {
        $cart_ids = $this->input->post('cart_ids');
        $cart_ids = explode(',', $cart_ids);
        $user_id = $this->session->user_id;
        if (empty($cart_ids) || empty($user_id)) {
            $error_code = 1;
        } else {
            if ($this->CartModel->delectCart($cart_ids, $user_id)) {
                $error_code = 0;
            } else {
                $error_code = 4;
            }
        }
        $json = json_encode(array("error_code" => $error_code));
        $this->output->set_content_type("application/json")->set_output($json);
    }

    /** 删除购物车商品
     * 
     */
    public function selectCart() {
        $user_id = $this->session->user_id;
        $cart_id = $this->input->post('cart_id');
        $error_code = 0;
        if ($cart_id != 'all') {
            $data = "ABS(checked-1)";
            $this->CartModel->checkked($cart_id, $data);
        } else {
            $cart_product = $this->CartModel->getCartList($user_id);
            foreach ($cart_product as $value) {
                $data = 1;
                $this->CartModel->checkked($value["cart_id"], $data);
            }
        }
        $json = json_encode(array("error_code" => $error_code));
        $this->output->set_content_type("application/json")->set_output($json);
    }

}