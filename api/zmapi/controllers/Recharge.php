<?php

/**
 * 用户充值
 *
 * @author qidazhong@hnzhimo.com
 */
class Recharge extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("rechargeOrderModel");
    }

    /**
     * 用户充值
     */
    public function recharge() {
        $user_id = $this->session->user_id;
        $recharge = floatval($this->input->post("money"));

        $rcorder_sn = "RC" . time() . mt_rand(1000, 9999);
        $rcorderdata = array(
            "rc_order_sn" => $rcorder_sn,
            "money" => $recharge,
            "status" => 0,
            "user_id" => $user_id,
        );
        $this->load->model("paymentModel");
        $wxpayInfo = $this->paymentModel->getPayInfo(2);
        $this->rechargeOrderModel->addRcOrder($rcorderdata);
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
        $paydata = array(
            "body" => "用户充值",
            "attach" => "recharge",
            "out_trade_no" => $rcorder_sn,
            "total_fee" => $recharge * 100,
            "trade_type" => "JSAPI",
            "openid" => $this->session->user_info['wx_fun_openid'],
            "notify_url" => site_url('', "https") . "/notify/wechat_fun.html"
        );
        $payParam = $this->wechat_pay->createMchPay($paydata);
        $data = array(
            "data" => $payParam,
            "error_code" => 0
        );

        $this->output->set_content_type("json/application")->set_output(json_encode($data));
    }

    /**
     * 用户到店扫码支付 
     * 可使用余额抵扣
     * 特殊需求 error_code = 0 微信支付参数  1余额支付成功 2失败
     */
    public function qrrecharge() {
        $user_id = $this->session->user_id;
        $recharge = floatval($this->input->post("money"));

        $this->load->model("userModel");
        $user_account = $this->userModel->getUserAccount($user_id);
        $data=array("error_code" => 2);
        if ($recharge <= $user_account['user_money']) {//小于消费账户 
            //直接扣除余额支付成功
            if ($this->userModel->setUserMoney($user_id, -$recharge)) {
                $data = array(
                    "data" => array("use_user_money" => $recharge, "remaining" => 0),
                    "error_code" => 1
                );
            }
        } else {
            if ($user_account['user_money'] > 0) {
                $use_user_money = $user_account['user_money']; //扣除的余额
                $remaining = bcsub($recharge, $user_account['user_money'], 2); //微信支付的钱
            } else {
                //使用微信支付
                $remaining = $recharge;
            }

            $rcorder_sn = "QRRC" . time() . mt_rand(1000, 9999);
            $rcorderdata = array(
                "rc_order_sn" => $rcorder_sn,
                "money" => $remaining,
                "status" => 0,
                "user_id" => $user_id,
                "remarks" => $use_user_money
            );
            $this->load->model("paymentModel");
            $wxpayInfo = $this->paymentModel->getPayInfo(2);
            $this->rechargeOrderModel->addRcOrder($rcorderdata);
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
            $paydata = array(
                "body" => "用户扫码支付",
                "attach" => "qrrecharge",
                "out_trade_no" => $rcorder_sn,
                "total_fee" => $remaining * 100,
                "trade_type" => "JSAPI",
                "openid" => $this->session->user_info['wx_fun_openid'],
                "notify_url" => site_url('', "https") . "/notify/wechat_fun.html"
            );
            $payParam = $this->wechat_pay->createMchPay($paydata);
            $data = array(
                "paymoneyinfo" => array("use_user_money" => $use_user_money, "remaining" => $remaining),
                "data" => $payParam,
                "error_code" => 0
            );
        }
        $this->output->set_content_type("json/application")->set_output(json_encode($data));
    }
    /**
     * 用户提现申请
     */
    public function get_cash() {

        $data = '提现失败';
        $error_code = 1;
        $user_id = $this->session->user_id;
        $cash_amount = $this->input->post("cash_amount");

        $this->load->model('userModel');
        $this->load->model('CashAppModel');
        $account = $this->userModel->getUserAccount($user_id);

        if ($account['settlement_money'] > 0 && $cash_amount > 0) {
            if ($cash_amount > $account['settlement_money']) {
                $cash_amount = $account['settlement_money'];
            }
            $auto = $this->systemsetting->get('cash_auto_send');
            $data = array(
                'user_id' => $user_id,
                'cash_amount' => $cash_amount,
                'createtime' => time(),
                'status' => $auto
            );
            $cashapp_id = $this->CashAppModel->addApplocation($data);
            if (empty($cashapp_id))
                $data = '提交失败，联系客服';
            if (!empty($auto) && !empty($cashapp_id)) {
                $cashapp_id = $this->issueCash($cashapp_id);
            }
            if (!empty($cashapp_id)) {
                //减少用户可提现账户余额
                $this->userModel->setUserSettlementMoney($user_id, -$cash_amount);
                $data = '申请已提交，等待发放';
                $error_code = 0;
            }
        } else {
            $data = '可提现金额不足请重新填写';
        }



        $this->output->set_content_type("json/application")->set_output(json_encode(array('error_code' => $error_code, 'data' => $data)));
    }

    /**
     * 用户收益发放:小程序版
     */
    protected function issueCash($cashapp_id) {
        //获取支付配置参数
        $this->load->model("paymentModel");
        $user_id = $this->session->user_id;
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
        $cashinfo = $this->CashAppModel->getApplicationById($cashapp_id);
        if ($cashinfo['status'] == 0 && $cashinfo['wx_fun_openid'] != "") {
            $trade_no = time() . mt_rand(1000, 9999);
            $result = $this->wechat_pay->transfers($cashinfo['wx_fun_openid'], $cashinfo['cash_amount'] * 100, $trade_no, "提现到账");
            if ($result['result_code'] == "SUCCESS") {
                //写账户变更日志
                $data = array(
                    "user_id" => $cashinfo['user_id'],
                    "change_money" => "-" . $cashinfo['cash_amount'],
                    "change_cause" => "提现",
                    "createtime" => time()
                );
                $this->userModel->addAccountLog($data);
                $this->CashAppModel->updateApplication($cashapp_id, 1);
                return TRUE;
            }
        }
        return FALSE;
    }

}
