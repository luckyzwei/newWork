<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 砍价订单
 *
 * @package    ZMshop
 * @author    wangxiangshuai@hnzhimo.com
 * @copyright (c) 2019, 河南知默网络科技有限公司
 * @link    http://www.hnzhimo.com
 * @since    Version 1.0.0
 */
class KillOrder extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //当前控制器会使用到的加载
        $this->load->helper('url');
        $this->load->model("KillOrderModel");
        $this->load->library("pagination");
        $this->load->library('form_validation');
    }

    private $statusname = array(
        '-1' => "售后中",
        '0' => "未支付",
        '1' => "已支付",
        '2' => "已发货",
        '3' => "部分发货",
        '4' => "部分退货",
        '5' => "已收货",
        '6' => "已完成",
        '7' => '售后中',
    );

    public static function getModuleInfo() {
        return array(
            "moduleName" => "砍价订单管理",
            "controller" => "KillOrder",
            "author" => "wangxiangshuai@hnzhimo.com",
            "operation" => array(
                "index" => "砍价列表",
            )
        );
    }

    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        //需要返回给view的数据
        $data = array();
        $selectdata = array();

        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 20;
        $orderdata = $this->KillOrderModel->getKillOrderList($page, $limit, $selectdata);
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
        $this->load->view('killorder', $data);
    }

}
