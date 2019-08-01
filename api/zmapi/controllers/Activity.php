<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Activity
 *
 * @author wangxiangayx
 */
class Activity extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model("ActivityModel");
        $this->load->helper("string");
    }

    /**
     * 获取活动详情
     */
    public function get_activity_info() {
        $activity_id = $this->input->get_post('activity_id');
        $user_id = $this->session->user_info['user_id'];
        $activity = $this->ActivityModel->get_activity($activity_id, $user_id);
        $error_code = 2;
        if ($activity) {
            $activity['thumb'] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $activity['thumb']);
            $error_code = 0;
        }
        $this->output->set_content_type("json/application")->set_output(json_encode(array('data' => $activity, 'error_code' => $error_code)));
    }

    /**
     * 获取活动列表
     * $type old结束 now进行 future未开始
     */
    public function get_activitys() {
        $type = $this->input->get_post('activity_type');
        $page = $this->input->get_post("page");
        $page = $page > 0 ? (int) $page : 1;
        $activitys = $this->ActivityModel->getActivityList($page, 10, $type);
        foreach ($activitys as $key => $value) {
            $activitys[$key]['thumb'] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $value['thumb']);
        }
        $this->output->set_content_type("json/application")->set_output(json_encode(array('data' => $activitys, 'error_code' => 0)));
    }

    /**
     * 报名活动信息
     */
    public function add_activity() {
        $activity_id = $this->input->get_post("activity_id");
        $user_id = $this->session->user_info['user_id'];
        $return = $this->checkActivity($activity_id, $user_id);
        $name = $this->input->get_post("name");
        $telephone = $this->input->get_post("telephone");
        if (!$name || !$telephone) {
            $return = array(
                "data" => "检查报名信息",
                "error_code" => 5
            );
        }
        if (empty($return['error_code'])) {
            $activity = array(
                "name" => $name,
                "telephone" => $telephone,
                "remarks" => $this->input->get_post("remarks"),
                "activity_id" => $activity_id,
                "add_time" => time(),
                "user_id" => $user_id,
            );
            if (empty($return['activity_order_id'])) {
                $activity_order_id = $this->ActivityModel->add_activity($activity);
            } else {
                $activity_order_id = $this->ActivityModel->edit_activity($return['activity_order_id'], $activity);
            }
            $this->load->model("paymentModel");
            $wxpayInfo = $this->paymentModel->getPayInfo(2);
            if (!empty($wxpayInfo) && !empty($activity_order_id)) {
                //生成支付参数
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
                    "body" => "在线报名费",
                    "attach" => "activity",
                    "out_trade_no" => 'Ac' . time() . '_' . $activity_order_id,
                    "total_fee" => $return['activityinfo']['price'] * 100,
                    "trade_type" => "JSAPI",
                    "openid" => $this->session->user_info['wx_fun_openid'],
                    "notify_url" => site_url('', "https") . "/notify/wechat_fun.html"
                );
                $payParam = $this->wechat_pay->createMchPay($data);
                $return = array(
                    "data" => $payParam,
                    "error_code" => 0,
                );
            }
        }
        $this->output->set_content_type("json/application")->set_output(json_encode($return));
    }

    /**
     * 报名扫码签到
     */
    public function qrcodesign() {
        $activity_id = $this->input->get_post("activity_id");
        $user_id = $this->session->user_info['user_id'];
        $activity = $this->ActivityModel->get_activity($activity_id, $user_id);
        $return = array(
                "data" => '签到失败',
                "error_code" =>1
            );
        if (!empty($activity['paytag']) && $activity['status'] == 1) {
            $updata = array(
                "status" => 2,
            );
            $this->load->model('paymentModel');
            $wxpayInfo = $this->paymentModel->getPayInfo(2);
            $wxpayconfig = $this->systemsetting->getSettingsByGroup($wxpayInfo['setting_flag']);
            $payconfigs = array(
                "partnerkey" => $wxpayconfig['wxpay_key'],
                "appid" => $wxpayconfig['wxpay_appid'],
                "mch_id" => $wxpayconfig['mch_id'],
                "ssl_key" => $wxpayconfig['wx_apiclient_key'],
                "ssl_cer" => $wxpayconfig['wx_apiclient_cert'],
            );
            $this->load->library("wechat_pay", $payconfigs); //加载支付类库
            $ref = $this->wechat_pay->refund($activity['pay_order_sn'], $activity['paytag'], 'YsrRF' . $activity['activity_order_id'], $activity['price']*100, $activity['price']*100);
            if ($ref) {
                $ref = $this->ActivityModel->edit_activity($activity['activity_order_id'], $updata);
            }
        }elseif(!empty($activity) &&$activity['status'] == 2){
            $return['data'] = '已签到';
        }
        if (!empty($ref)) {
            $return = array(
                "data" => '签到成功',
                "error_code" => 0
            );
        }
        $this->output->set_content_type("json/application")->set_output(json_encode($return));
    }

    /**
     * 检测活动信息
     * @param type $activity_id
     * @param type $user_id
     * @return int
     */
    protected function checkActivity($activity_id, $user_id = 0) {
        $error_code = 0;
        $data = "报名成功";
        $activity = $this->ActivityModel->get_activity($activity_id, $user_id);
        if (!empty($activity['start_time']) && $activity['start_time'] > time()) {
            $error_code = 2; //活动时间未到
            $data = "活动时间未到";
        }
        if (!empty($activity['end_time']) && $activity['end_time'] < time()) {
            $error_code = 3; //活动时间结束
            $data = "活动时间结束";
        }
        if (!empty($user_id) && $activity['status'] > 0) {
            $error_code = 4; //活动已报名
            $data = "活动已报名";
        }
        if (empty($activity['activity_order_id'])) {
            $activity['activity_order_id'] = 0;
        }
        return array("data" => $data, "error_code" => $error_code, "activity_order_id" => $activity['activity_order_id'], "activityinfo" => $activity);
    }

}
