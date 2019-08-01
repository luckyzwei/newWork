<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 商品管管理
 * 
 * @package	ZMshop
 * @author	wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class ProductRecycle extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //当前控制器会使用到的加载
        $this->load->helper('url');
        $this->load->model("ProductModel");
        $this->load->library("pagination");
        $this->load->library('form_validation');
        $this->load->model("RoleModel");
        $this->load->helper('string');
    }

    /**
     * 类必须实现函数用于权限控制设置
     * 
     * @return  array
     */
    public static function getModuleInfo() {
        return array(
            "moduleName" => "商品回收站",
            "controller" => "ProductRecycle",
            "author" => "xushaocun@hnzhimo.com",
            "operation" => array(
                "index" => "商品列表页",
                "recoveryProduct" => "还原商品",
                "deleteProduct"=>"彻底删除商品"
            )
        );
    }

    /*
     * 自动查询已删除商品名称
     * 祖    2018/8/14
     */

    public function autoDelProduct() {
        $product_id = $this->input->get_post('product_id');
        if (!empty($product_id)) {
            $product_id = $this->input->get_post('product_id');
        } else {
            $product_id = '';
        }
        $categorydata = $this->ProductModel->autoDelProductList($product_id);
        $this->output->set_output(json_encode($categorydata));
    }

    /*
     * 商品回收站
     * 祖    2018/8/14
     */

    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $where['product_name'] = $this->input->post('product_name');
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 20;
        $productdata = $this->ProductModel->getProductRecycle($page, $limit, $where);
        $config['base_url'] = site_url('ProductRecycle/index'); //当前分页地址
        $config['total_rows'] = $productdata['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $config['cur_page'] = $page;
        $this->pagination->initialize($config);
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $productdata['result'];
        $data['page'] = $page;
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('product_recycle', $data);
    }

    /*
     * 还原商品
     * 祖    2018/8/14
     */

    public function recoveryProduct() {
        $product_id = $this->input->post('product_id');
        $res = $this->ProductModel->recoveryProduct($product_id);
        if ($res) {
            $data['error_code'] = '0';
        } else {
            $data['error_code'] = '1';
        }
        $this->output->set_output(json_encode($data));
    }
    /**
     * 彻底删除
     */
    public function deleteProduct() {
        $product_id = $this->input->post('product_id');
        $res = $this->ProductModel->deleteProduct($product_id);
        if ($res) {
            $data['error_code'] = '0';
        } else {
            $data['error_code'] = '1';
        }
        $this->output->set_output(json_encode($data));
    }

}
