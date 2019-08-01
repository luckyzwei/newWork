<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 数据统计钩子埋点
 *
 * @author qidazhong@hnzhimo.com
 */
class staticsHooks {

    private $CI;

    public function __construct() {
        $this->CI = &get_instance();
    }

    /**
     * 数据统计埋点方法：根据请求的控制器和方法来判断增加哪些统计数据量
     */
    public function statics() {
        $user_id = $this->CI->session->user_id;
        $this->CI->load->model("staticsModel");
        $request_class = strtolower($this->CI->uri->segment(1));
        $request_method = strtolower($this->CI->uri->segment(2) ? $this->CI->uri->segment(2) : "index");
        $request_str = $request_class . "/" . $request_method;
        //增加访问量：需要统计页面的默认方法
        $static_array=array(
                "index/get_home", 
                "category/get_categories", 
                'product/get_product_info', 
                'cart/get_cart_products', 
                'order/check_order_bystatus', 
                'order/get_orders', 
                'address/get_address', 
                'coupon/get_user_coupon', 
                'checkout/checkout_order', 
                'checkout/create_order', 
                "notify/wechat_fun"
        );
        //增加访问量
        if(in_array($request_str,$static_array)){
            $this->CI->staticsModel->update(array("visited", 1));
        }
        //添加用户访问商品的轨迹
        if($request_str=="product/get_product_info"){
            $this->user_visited_product();
        }
        //增加创建订单数量
        if($request_str=='checkout/create_order'){
             $this->CI->staticsModel->update(array("orders", 1));
        }
        
        
        if ($request_str == "user/user_login") {
            //根据注册时间判断是否是新用户：合理假设为注册时间在3秒内的用户为新用户
            $this->CI->load->model("userModel");
            $userinfo = $this->CI->userModel->getUserById($user_id);
            if (time() - $userinfo['createtime'] < 3) {
                $this->CI->staticsModel->update(array("newuser", 1));
            }
            if (time() - $userinfo['last_logintime'] > 120*60) {//120分钟后的访客为新访客
                $this->CI->staticsModel->update(array("visiter", 1));
            }
        }
    }

    /**
     * 用户访问的商品
     */
    private function user_visited_product() {
        $product_id = $this->CI->input->get_post("product_id");
        $this->CI->load->model("UserTrailModel");
        $data = array(
            "user_id" => $this->CI->session->user_id,
            "trail" => $this->CI->router->fetch_class() . "-" . $this->CI->router->fetch_method(),
            "brower" => "wechatapp",
            "content" => "",
            "product_id" => $product_id,
        );
        if (!empty($product_id) && $data['trail'] == "product-get_product_info")
            $this->CI->UserTrailModel->addUserTrail($data);
    }

}
