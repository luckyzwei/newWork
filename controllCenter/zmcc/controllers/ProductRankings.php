<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 商品销售排行榜
 * @package	ZMshop
 * @author	liuchenwei@hnzhimo.com
 * @copyright	2017 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class ProductRankings extends CI_Controller {

    //设置控制权限
    static function getModuleInfo() {
        return array(
            "moduleName" => "商品销售排行",
            "controller" => "ProductRankings",
            "author" => "liuchenwei@hnzhimo.com",
            "operation" => array(
                "index" => "商品销售排行列表",
            )
        );
    }

    public function __construct() {
        parent::__construct();
        $this->load->model("ProductRankingsModel");
    }

    //加载商品销售排行列表页
    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $this->load->helper('url');
        $this->load->library("pagination");
        $where['product_name'] = $this->input->post('product_name');
        $where['user_id'] = $this->input->post('user_id');
        $data['product_name'] = $where['product_name'];
        $data['user_id'] = $where['user_id'];
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 10;
        $categorydata = $this->ProductRankingsModel->getList($where, $page, $limit);
        $config['base_url'] = site_url('ProductRankings/index'); //当前分页地址
        $config['total_rows'] = $categorydata['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $this->pagination->initialize($config);
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $categorydata['result'];
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('productrankings', $data);
    }

}
