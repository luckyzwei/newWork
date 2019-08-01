<?php

/**
 * 优惠卷管理
 * 
 * @package	ZMshop
 * @author	wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class Coupon extends CI_Controller {

    
    public function __construct() {
        parent::__construct();
        $this->load->model("couponModel");
    }
    /**
     * 获取可以领取的优惠券
     */
    public function get_recive_coupons() {
        $user_id = $this->session->user_id;
        $coupons = $this->couponModel->getUsercanRevice($user_id);
        $json = array("error_code" => 0, "data" => $coupons);
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    /**
     * 根据状态获取用户的优惠券
     */
    public function get_user_coupon() {
        $user_id = $this->session->user_id;
        $status = $this->input->post("status");
        $coupons = $this->couponModel->getUserCoupons($user_id, $status);
        $coupons_list=$coupons['result'];
        if($coupons_list && $status==2){
            foreach ($coupons_list as $key => $value) {
                $coupons_list[$key]['status']=2;
            }
        }
        $json = array("error_code" => 0, "data" => $coupons_list);
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    /**
     * 用户领取优惠券
     */
    public function user_recive_coupon() {
        $user_id = $this->session->user_id;
        $error_code = 0;
        if ($this->input->method() == "post") {
            $coupon_id = $this->input->post("coupon_id");
            if (!$this->couponModel->setUserCoupon($coupon_id,$user_id)) {
                $error_code = 1;
            }
        }
        $json = array("error_code" => 0, "data" => array("coupon_id" => $coupon_id));
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

}
