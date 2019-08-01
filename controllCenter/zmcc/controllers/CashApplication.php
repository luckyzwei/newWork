<?php

/**
 * 用户提现申请
 * @package	ZMshop
 * @author	qidazhong@hnzhimo.com
 * @copyright	2017 河南知默科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class CashApplication extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model("CashAppModel");
        $this->load->model("userModel");
    }

    /**
     * 提现申请列表
     * zu    2018/8/30
     */
    public function index() {
        $page = $this->input->get('per_page') ? $this->input->get('per_page') : 1;
        $limit = $this->input->get_post('limit') ? $this->input->get_post('limit') : 20;
        $where = [];
        $user_id = $this->input->post('user_id');
        if (!empty($user_id)) {
            $where['ca.user_id'] = $user_id;
        }
        $status = $this->input->post('status');
        if ($status !== '' && $status !== NULL) {
            $where['status'] = $status;
        }

        $page_data = $this->CashAppModel->getApplications($page, $limit, $where);
        $this->load->library("pagination");
        $config['base_url'] = site_url('CashApplication/index'); //当前分页地址
        $config['total_rows'] = $page_data['count'];
        $config['per_page'] = $limit; //每页显示的条数
        $config['cur_page'] = $page;
        $this->pagination->initialize($config);
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $page_data['list'];
        $data['status_name'] = [
            '0' => '未发放',
            '1' => '已发放'
        ];
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('cash_application', $data);
    }

    /**
     * 用户收益发放:小程序版
     */
    public function issueCash() {
        //获取支付配置参数

        $this->load->model("paymentModel");
        $wxpayInfo = $this->paymentModel->getPayInfo(2);
        $wxpayconfig = $this->zmsetting->getSettingsByGroup($wxpayInfo['setting_flag']);
        $payconfigs = array(
            "partnerkey" => $wxpayconfig['wxpay_key'],
            "appid" => $wxpayconfig['wxpay_appid'],
            "mch_id" => $wxpayconfig['mch_id'],
            "ssl_key" => $wxpayconfig['wx_apiclient_key'],
            "ssl_cer" => $wxpayconfig['wx_apiclient_cert'],
        );

        $this->load->library("wechat_pay", $payconfigs); //加载支付类库
        $cashapp_id = $this->input->get("cashapp_id");
        $cashinfo = $this->CashAppModel->getApplicationById($cashapp_id);
        if ($cashinfo['status'] == 0 && $cashinfo['wx_fun_openid'] != "") {
            $trade_no = time() . mt_rand(1000, 9999);
            $result = $this->wechat_pay->transfers($cashinfo['wx_fun_openid'], $cashinfo['cash_amount'] * 100, $trade_no, "提现到账");
            //var_dump($this->wechat_pay);
            if ($result['result_code'] == "SUCCESS") {
                //减少用户可提现账户余额
                $this->userModel->setUserSettlementMoney($user_id, -$cashinfo['cash_amount']);
                //写账户变更日志
                $data = array(
                    "user_id" => $cashinfo['user_id'],
                    "change_money" => "-" . $cashinfo['cash_amount'],
                    "change_cause" => "提现",
                    "createtime" => time()
                );
                $this->userModel->addAccountLog($data);
                $this->CashAppModel->updateApplication($cashapp_id, 1);
                $this->session->success = "发放成功!";
                $this->session->mark_as_flash("success");
            } else {
                $this->session->error = "发放失败:(微信支付)".$this->wechat_pay->errMsg;
                $this->session->mark_as_flash("error");
            }
        } else {
            $this->session->error = "发放失败:未知错误";
            $this->session->mark_as_flash("error");
        }
        redirect(site_url('cashApplication/index'));
    }

    /**
     * 类必须实现函数用于权限控制设置
     *
     * @return  array
     */
    public static function getModuleInfo() {
        return array(
            "moduleName" => "提现申请管理",
            "controller" => "CashApplication",
            "author" => "@hnzhimo.com",
            "operation" => array(
                "index" => "申请列表",
                "issueCash" => "发放提现申请"
            ),
        );
    }

}
