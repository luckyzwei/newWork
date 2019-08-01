<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 店铺管理
 * @package	ZMshop
 * @author	liuchenwei@hnzhimo.com
 * @copyright	2018 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class Store extends CI_Controller {

    //设置控制权限
    static function getModuleInfo() {
        return array(
            "moduleName" => "店铺管理",
            "controller" => "Store",
            "author" => "liuchenwei@hnzhimo.com",
            //"hidden"=>true,
            "operation" => array(
                "index" => "店铺列表",
                "edit" => "编辑店铺",
                "storeOrderList" => "店铺订单列表",
                "storeOrderInfo" => "店铺订单详情",
                "storeProduct" => "店铺推荐商品列表",
            )
        );
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
    private $ordertypename = array(
        'G' => "团购",
        'O' => "普通",
        'T' => "限时"
    );

    public function __construct() {
        parent::__construct();
        $this->load->model("StoreModel");
    }

    //记载店铺列表
    public function index(){
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $this->load->helper('url');
        $this->load->library("pagination");
        $data = array();
        $where = array();
        $where['store_name'] = $this->input->post('store_name');
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 20;
        $storedata = $this->StoreModel->getList($where, $page, $limit);
        $config['base_url'] = site_url('Store/index'); //当前分页地址
        $config['total_rows'] = $storedata['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $this->pagination->initialize($config);
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $storedata['result'];
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('store', $data);

    }


    //操作管理店铺
    public function edit($store_id){
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $data['result'] = "fail";
        if ($this->input->method() == "post") {
            $this->form_validation->set_rules("store_note", "备注信息不能超过120个汉字", "max_length[120]");
            if ($this->form_validation->run() == True) {
                $data = array(
                    "store_status" => $this->input->post("store_status"),
                    "store_note" => $this->input->post("store_note"),
                );
                $this->StoreModel->update($data, array("store_id" => $this->input->post("store_id")));
                $this->session->success = "店铺操作成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Store/index"));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $data['store'] = $this->input->post();
                $this->load->view('store_edit', $data);
            }
        } else {
            $data['store'] = $this->StoreModel->sel($store_id);
            $this->load->view('store_edit', $data);
        }
    }

    /**
     * 店铺订单列表
     * @param type $store_id
     */
    public function storeOrderList($store_id){
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $this->load->library("pagination");
        $data = array();
        $selectdata = array();
        if (empty($store_id)) {
            $store_id = $this->uri->segment(3);
        }
        $store_uid=$this->StoreModel->getUserIdByStoreId($store_id);
        
        $selectdata['createtime'] = $this->input->post("createtime");
        $selectdata['stoptime'] = $this->input->post("stoptime");
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 10;
        $orderdata = $this->StoreModel->storeOrderList($page, $limit, $selectdata,$store_id);
        $config['base_url'] = site_url('Store/storeOrderList/'.$store_id); //当前分页地址
        $config['total_rows'] = $orderdata['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $config['cur_page'] = $page;
        $this->pagination->initialize($config);
        $data['statusname'] = $this->statusname;
        $data['ordertypename'] = $this->ordertypename;
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $orderdata['result'];
        $data['page'] = $page;
        $data['store_id'] = $store_id;
        $data['createtime'] = $this->input->post("createtime");
        $data['stoptime'] = $this->input->post("stoptime");
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('store_order_list', $data);

    }

    /*
     * 店铺商品管理
     */
    public function storeProduct(){
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $store_id = $this->input->get_post('store_id');
        //引入商品模型
        $this->load->model('ProductModel');
        //获取where条件
        $where = [];
        $where['product_sn'] = $this->input->post('product_sn');
        $where['product_name'] = $this->input->post('product_name');
        $where['status'] = $this->input->post('status');
        //引入分页
        $this->load->library("pagination");
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 20;
        $prodata = $this->ProductModel->getProByStoId($page, $limit, $where,$store_id);
        $config['total_rows'] = $prodata['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $config['cur_page'] = $page;
        $config['base_url'] = base_url('Store/storeProduct');
        $this->pagination->initialize($config);
        $data['list'] = $prodata['result'];
        $data['page'] = $page;
        //状态数组
        //妈耶，真好用，不用一个一个判断了
        $data['status'] = array(
            '1'=>'正常',
            '2'=>'下架'
        );
        $data['linklist'] = $this->pagination->create_links();
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $data['store_id'] = $store_id;
        // var_dump($data['productInfo']);exit;
        $this->load->view('store_product',$data);
    }
    /**
     * 子店铺列表
     */
    public function subStore(){
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $store_id = $this->input->get("store_id");
        //引入分页
        $where = [];
        $where['store_name'] = $this->input->post('store_name');
        $this->load->library("pagination");
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 2;
        //分页是抄来的，不要在意变量名
        $prodata = $this->StoreModel->getSubStore($page, $limit, $where,$store_id);
        $config['total_rows'] = $prodata['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $config['cur_page'] = $page;
        $config['base_url'] = base_url('Store/storeSon');
        $this->pagination->initialize($config);
        $data['list'] = $prodata['result'];
        $data['page'] = $page;
        $data['linklist'] = $this->pagination->create_links();
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $data['store_id'] = $store_id;
        $this->load->view('store_son',$data);
    }

}
