<?php

/**
 * 充值策略控制器
 * @package   ZZZZshop
 * @author     wangxiangshuai@hnzhimo.com
 * @copyright  2018 河南知默网络科技有限公司
 * @link       http://www.zzzzshop.com
 * @since      Version 1.0.0
 */
class RechargeStrategy extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("RechargeStrategyModel");
        $this->load->model("ProductModel");
        $this->load->model("CouponModel");
        $this->load->library("pagination");
        $this->load->helper('url');
        $this->load->library("form_validation");
    }

    public function index() {
        $data = array();
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 20;
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $rechargelist = $this->RechargeStrategyModel->getRechargeList($limit, $page);

        $data['rechargelist'] = $rechargelist['datas'];
        $config['base_url'] = site_url('Recharge/index'); //当前分页地址
        $config['total_rows'] = $rechargelist['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $config['cur_page'] = $page;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('recharge_strategy', $data);
    }

    /**
     * 添加营销策略
     */
    public function addRechargeStrategy($strategy_id = 0) {
        $insertFiled = array("strategy_id", "strategy_name", "min_amount", "give_type", "give_intergal", "give_amount", "give_product", 'give_coupon', 'level', 'starttime', 'endtime');
        $data = elements($insertFiled, $this->input->post());
        if ($this->input->method() == 'post') {
            $this->setRules();
            if ($this->form_validation->run() == True) {
                if (empty($data['strategy_id'])) {
                    unset($data['strategy_id']);
                    $res = $this->RechargeStrategyModel->addRecharge($data);
                } else {
                    $res = $this->RechargeStrategyModel->editRecharge($data, array('strategy_id' => $data['strategy_id']));
                }
                if ($res) {
                    $this->session->set_flashdata("success", "编辑充值策略成功!");
                    redirect(site_url("RechargeStrategy/index"));
                }
            } else {
                $this->session->set_flashdata("error", $this->form_validation->error_string());
                $data = array_merge($data, $this->input->post());
            }
        } else {
            if (!empty($strategy_id)) {
                $data = $this->RechargeStrategyModel->getRechargeById($strategy_id);
                $data['give_product'] = unserialize($data['give_product']);
            }
        }
        $categorydata = $this->CouponModel->getList();
        $data['couponLists'] = $categorydata['result']; //获取所有的优惠券
        //获取已选择商品
        if (!empty($data['give_product'])) {
            $data['give_products'] = $this->ProductModel->getProducts('product_id in (' . implode(',', $data['give_product']) . ')'); //获取所有的商品
        }
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('recharge_strategy_edit', $data);
    }

    /**
     * 删除充值策略
     */
    public function deleteRechargeStrategy() {
        $select = $this->input->post('selected');
        if (is_array($select) && !empty($select)) {
            $result = $this->RechargeStrategyModel->deleteRechargeStrategy('strategy_id in(' . implode(',', $select) . ')');
            if ($result) {
                $this->session->set_flashdata("success", "删除成功!");
            } else {
                $this->session->set_flashdata("error", "删除失败!");
            }
        }
        redirect(site_url("RechargeStrategy/index"));
    }

    //验证有效期开始时间和结束时间   time结束时间，starttime开始时间
    public function startimeCheck($time, $starttime = '0') {
        $time = strtotime($time);
        $starttime = strtotime($starttime);
        if (!empty($time) && ($time < time())) {
            $this->form_validation->set_message('startimeCheck', "策略结束时间不能小于当前时间");
            return false;
        }

        if (!empty($time) && ($time < $starttime)) {
            $this->form_validation->set_message('startimeCheck', "策略结束时间不能小于开始时间");
            return false;
        }
    }

    private function setRules() {
        $this->form_validation->set_rules('strategy_name', '策略名称', 'required|max_length[128]|min_length[3]', array('required' => '策略名称必填', 'min_length' => '策略名称最少为3位', "max_length" => "策略名称最大为128位"));
        $this->form_validation->set_rules('starttime', '开始时间', 'required', array('required' => '开始时间必填'));
        $this->form_validation->set_rules('endtime', '结束时间', 'callback_startimeCheck[' . $this->input->post('starttime') . ']');
    }

    public static function getModuleInfo() {
        return array(
            "moduleName" => "充值策略管理",
            "controller" => "Recharge",
            "author" => "wangxiangshuai@hnzhimo.com",
            "operation" => array(
                "index" => "充值策略",
                "insertMarketeting" => "添加策略",
                "editMarketeting" => "修改策略",
                "deleteMarketeting" => "删除策略"
            )
        );
    }

}
