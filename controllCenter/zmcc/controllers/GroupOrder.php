<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 拼团管理，订单管理
 * 
 * @package	ZMshop
 * @author	wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class GroupOrder extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //当前控制器会使用到的加载
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->library('form_validation');
        $this->load->model("GroupBuyModel");
        $this->load->model("RoleModel");
    }

    private $statusname = array(
        '-1' => "售后中",
        '0' => "未支付",
        '1' => "已支付",
        '2' => "已发货",
        '3' => "部分发货",
        '4' => "部分退货",
        '5' => "已收货"
    );

    /**
     * 类必须实现函数用于权限控制设置
     * 
     * @return  array
     */
    public static function getModuleInfo() {
        return array(
            "moduleName" => "全订单管理",
            "controller" => "Order",
            "author" => "wangxiangshuai@hnzhimo.com",
            "operation" => array(
                "index" => "拼团列表",
                'GroupBuyList' => "团内列表",
            )
        );
    }

    //显示首页列表
    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        //需要返回给view的数据
        $data = array();
        $selectdata = array();
        $user_id = $this->input->get_post("user_id");
        if (!empty($user_id))
            $selectdata['user_id'] = $user_id;
        $groupbuy_sn = $this->input->get_post("groupbuy_sn");
        if (!empty($groupbuy_sn))
            $selectdata['groupbuy_sn'] = $groupbuy_sn;
        $group_product_id = $this->input->get_post("group_product_id");
        if (!empty($group_product_id))
            $selectdata['group_product_id'] = $group_product_id;
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 20;
        $orderdata = $this->GroupBuyModel->getGroupBuyList($page, $limit, $selectdata);
        $config['base_url'] = site_url('GroupOrder/index'); //当前分页地址
        $config['total_rows'] = $orderdata['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $config['cur_page'] = $page;
        $this->pagination->initialize($config);
        $data['statusname'] = $this->statusname;
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $orderdata['result'];
        $data['page'] = $page;
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('grouporder', $data);
    }

    public function GroupBuyList($groupbuy_sn) {
        $data['statusname'] = $this->statusname;
        $data['list'] = $this->GroupBuyModel->getGroupBuyinfo($groupbuy_sn);
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $data['action'] = site_url('GroupOrder/index');
        $data['statusname'] = $this->statusname;
        $this->load->view('grouporderlist', $data);
    }

    public function delectGroupOrder() {
        $return = $this->input->post('selected');
        if (!empty($return) && is_array($return)) {
            $where = implode(',', $this->input->post('selected'));
            if ($this->GroupBuyModel->delectGroupOrder('groupbuy_id in (' . $where . ')')) {
                $this->session->success = "删除成功!";
                $this->session->mark_as_flash("success");
            } else {
                $this->session->error = "删除失败!";
                $this->session->mark_as_flash("error");
            }
        } else {
            $this->session->error = "请求有误!";
            $this->session->mark_as_flash("error");
        }
        redirect(site_url('AgentGroup/index'));
    }

    public function editGroupBuyStatus() {
        $groupbuy_sn = $this->input->get_post('groupbuy_sn');
        $data = array(
            "status" => 2,
        );
        $where = 'groupbuy_sn=' . "'".$groupbuy_sn."'";
        if ($this->GroupBuyModel->editGroupBuyStatus($where, $data)) {
            $this->session->success = "团编号:".$groupbuy_sn."，已自动成团成功!";
            $this->session->mark_as_flash("success");
        }else{
            $this->session->error = "请求有误!";
            $this->session->mark_as_flash("error");
        }
        redirect(site_url('GroupOrder/index'));
    }

}
