<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 供货商管理
 * @package	ZMshop
 * @author	liuchenwei@hnzhimo.com
 * @copyright	2017 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class Supplier extends CI_Controller {

    //设置控制权限
    static function getModuleInfo() {
        return array(
            "moduleName" => "供货商管理",
            "controller" => "Supplier",
            "author" => "liuchenwei@hnzhimo.com",
            "operation" => array(
                "index" => "供货商列表页面",
                "addSupplier" => "添加供货商",
                "editSupplier" => "修改供货商信息",
                "deleteSupplier" => "删除供货商",
            )
        );
    }

    public function __construct() {
        parent::__construct();
        $this->load->model("SupplierModel");
        $this->load->model("RoleModel");
    }

    //加载供货商列表页
    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $this->load->helper('url');
        $this->load->library("pagination");
        $data = array();
        $where = array();
        $where['filter_supplier_name'] = $this->input->post('filter_supplier_name');
        $data['filter_supplier_name'] = $where['filter_supplier_name'];
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 10;
        $categorydata = $this->SupplierModel->getList($where, $page, $limit);
        $config['base_url'] = site_url('Supplier/index'); //当前分页地址
        $config['total_rows'] = $categorydata['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $this->pagination->initialize($config);
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $categorydata['result'];
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('supplier', $data);
    }

    //添加供货商
    public function addSupplier() {
        $data['rolelists'] = $this->RoleModel->getRoles();
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $data['result'] = "fail";
        if ($this->input->method() == "post") {
            $this->form_validation->set_rules("name", "联系人名称不能大于8个长度且", "max_length[8]|required");
            $this->form_validation->set_rules("nickname", "选择用户为供货商且", "required");
            $this->form_validation->set_rules("moblie", "请输入有效的手机号", "required|max_length[11]");
             $this->form_validation->set_rules("province_id", "供货商地址省份", "required");
            $this->form_validation->set_rules("city_id", "供货商地址市级", "required");
            $this->form_validation->set_rules("district_id", "供货商地址地区", "required");
            $this->form_validation->set_rules("settlement_rate", "结算时间", "trim|required");
            $this->form_validation->set_rules("address", "供货商地址长度不能超过60个字且", "required|max_length[120]");
            if ($this->form_validation->run() == True) {
                $data = array(
                    "supplier_id" => $this->input->post("supplier_id"),
                    "name" => $this->input->post("name"),
                    "user_id" => $this->input->post("user_id"),
                    "status" => $this->input->post("status")?1:0,
                    "contact" => $this->input->post("contact"),
                    "moblie" => $this->input->post("moblie"),
                    "province_id" => $this->input->post("province_id"),
                    "province_name" => $this->SupplierModel->getProvinceName($this->input->post("province_id")),
                    "city_id" => $this->input->post("city_id"),
                    "city_name" => $this->SupplierModel->getCityName($this->input->post("city_id")),
                    "district_id" => $this->input->post("district_id"),
                    "district_name" => $this->SupplierModel->getDistriceName($this->input->post("district_id")),
                    "address" => $this->input->post("address"),
                    "settlement_rate" => $this->input->post("settlement_rate"),
                    "updatetime" => time(),
                );
                $this->SupplierModel->addSupplier($data);
                $this->session->success = "添加供货商成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Supplier/index"));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $this->load->view('supplier_add', $data);
            }
        } else {
            $this->load->view("supplier_add", $data);
        }
    }

    //编辑供货商
    public function editSupplier($supplier_id = 0) {
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $data['rolelists'] = $this->RoleModel->getRoles();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        if ($this->input->method() == "post") {
            $supplier_id = $this->input->post('supplier_id');
            $this->form_validation->set_rules("name", "联系人名称不能大于8个长度且", "max_length[8]|required");
            $this->form_validation->set_rules("nickname", "选择用户为供货商且", "required");
            $this->form_validation->set_rules("moblie", "请输入有效的手机号", "required|max_length[11]");
             $this->form_validation->set_rules("province_id", "供货商地址省份", "required");
            $this->form_validation->set_rules("city_id", "供货商地址市级", "required");
            $this->form_validation->set_rules("district_id", "供货商地址地区", "required");
            $this->form_validation->set_rules("settlement_rate", "结算时间", "trim|required");
            $this->form_validation->set_rules("address", "供货商地址长度不能超过60个字且", "required|max_length[120]");
            if ($this->form_validation->run() == True) {
                $data = array(
                    "name" => $this->input->post("name"),
//                    "user_id" => $this->input->post("user_id"),
                    "contact" => $this->input->post("contact"),
                    "status" => $this->input->post("status"),
                    "moblie" => $this->input->post("moblie"),
                    "province_id" => $this->input->post("province_id"),
                    "province_name" => $this->SupplierModel->getProvinceName($this->input->post("province_id")),
                    "city_id" => $this->input->post("city_id"),
                    "city_name" => $this->SupplierModel->getCityName($this->input->post("city_id")),
                    "district_id" => $this->input->post("district_id"),
                    "district_name" => $this->SupplierModel->getDistriceName($this->input->post("district_id")),
                    "address" => $this->input->post("address"),
                    "settlement_rate" => $this->input->post("settlement_rate"),
                    "updatetime" => time(),
                );
                

                $this->SupplierModel->updateSupplier($data, array("supplier_id" => $supplier_id));
                $this->session->success = "修改供货商信息成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Supplier/index"));
            } else {
               $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        $page = $this->input->get("page");
        $data['action'] = site_url("Supplier/editSupplier/" . $supplier_id);
        $data['supplier'] = $this->SupplierModel->sel($supplier_id);
        $data['supplierInfo'] = $data['supplier']['supplier'];
        $data['nick'] = $data['supplier']['nick'];
        $data['supplierInfo']['images'] = explode(",",$data['supplierInfo']['images']);
        $this->load->view('supplier_edit', $data);
    }

    //删除供货商
    public function deleteSupplier() {
        $xuan = $this->input->post('selected');
        if (!empty($xuan) && is_array($xuan)) {
            $where = implode(',', $this->input->post('selected'));
            if ($this->SupplierModel->deleteSupplier('supplier_id in (' . $where . ')')) {
                $this->session->success = "删除成功!";
                $this->session->mark_as_flash("success");
            } else {
                $this->session->error = "删除失败!";
                $this->session->mark_as_flash("error");
            }
        }else{
            $this->session->error = "请求有误!";
            $this->session->mark_as_flash("error");
        }
        redirect(site_url('Supplier/index'));
    }
    /*
     * 供货商订单列表
     * 祖    2018/8/8
     */
    public function supplierOrder(){
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $supplier_id = $this->input->get('supplier_id');
        $where = [];
        $where['bg_time'] = $this->input->post('bg_time');
        $where['ed_time'] = $this->input->post('ed_time');
        $where['order_sn'] = $this->input->post('order_sn');
        $where['filter_status'] = $this->input->post('filter_status');
        //下面查数据，做分页
        $this->load->library("pagination");
        $this->load->model('OrderModel');
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 20;

        $order_data = $this->OrderModel->getOrderBySupplierId($page, $limit, $where,$supplier_id);
        $config['total_rows'] = $order_data['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $config['cur_page'] = $page;
        $config['base_url'] = site_url('Supplier/supplierOrder');
        $this->pagination->initialize($config);
        $data['bg_time'] = $this->input->post('bg_time');
        $data['ed_time'] = $this->input->post('ed_time');
        $data['order_sn'] = $this->input->post('order_sn');
        $data['filter_status'] = $this->input->post('filter_status');
        $data['list'] = $order_data['result'];
        $data['totle'] = $this->OrderModel->getTotleModelBySupplierId($supplier_id,$where);
        $data['page'] = $page;
        $data['supplier_id'] = $supplier_id;
        $data['linklist'] = $this->pagination->create_links();
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        //-1售后中0未支付1已支付2已发货3部分发货4部分退货5已收货
        $data['statusname'] = [
            '-1'=>'售后中',
            '0'=>'未支付',
            '1'=>'已支付',
            '2'=>'已发货',
            '3'=>'部分发货',
            '4'=>'部分退货',
            '5'=>'已收货',
            '6'=>'已完成',
        ];
        //订单类型：G团购O一般T秒杀
        $data['ordertypename'] = [
            'G'=>'团购',
            'O'=>'一般',
            'T'=>'秒杀'
        ];
//        dump($data);exit;
        $this->load->view('supplier_order',$data);
    }

}
