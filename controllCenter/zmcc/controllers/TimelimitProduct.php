<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 秒杀活动商品管管理
 *
 * @package    ZMshop
 * @author    liuchenwei@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link    http://www.hnzhimo.com
 * @since    Version 1.0.0
 */
class TimelimitProduct extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("TimelimitProductModel");
        $this->load->model("RoleModel");
    }

    /**
     * 类必须实现函数用于权限控制设置
     *
     * @return  array
     */
    public static function getModuleInfo()
    {
        return array(
            "moduleName" => "限时秒杀管理",
            "controller" => "TimelimitProduct",
            "author" => "liuchenwei@hnzhimo.com",
            "operation" => array(
                "index" => "限时秒杀列表页",
                "editTimelimitProduct" => "编辑限时秒杀",
                "addTimelimitProduct" => "新增限时秒杀",
                "deleteTimelimitProduct" => "删除限时秒杀",
            ),
        );
    }

    //显示首页列表
    public function index()
    {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $this->load->helper('url');
        $this->load->library("pagination");
        $data = array();
        $where = array();
        $where['filter_agent'] = $this->input->post('filter_agent');
        $data['filter_agent'] = $where['filter_agent'];
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 10;
        $categorydata = $this->TimelimitProductModel->getTimelimitProductList($where, $page, $limit);
        $config['base_url'] = site_url('TimelimitProduct/index'); //当前分页地址
        $config['total_rows'] = $categorydata['count'];
        $config['per_page'] = $limit; //每页显示的条数
        $this->pagination->initialize($config);
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $categorydata['result'];
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('timelimitproduct', $data);
    }

    public function addTimelimitProduct()
    {
        $data['rolelists'] = $this->RoleModel->getRoles();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        if ($this->input->method() == "post") {
            $data = $this->valiRules();
            if ($data['rules_run'] == true) {
                $data['createtime'] = time();
                $data['starttime'] = strtotime($data['starttime']);
                $data['endtime'] = strtotime($data['endtime']);
                unset($data['rules_run']);
                if ($this->TimelimitProductModel->addTimelimetProduct($data)) {
                    $this->session->success = "添加限时秒杀成功";
                    $this->session->mark_as_flash("success");
                    redirect(site_url("TimelimitProduct/index"));
                }
            } else {
                $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $this->load->view('timelimitproduct_add', $data);
            }
        } else {
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $this->load->view("timelimitproduct_add", $data);
        }
    }

    public function editTimelimitProduct($timelimit_product_id = "")
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $data['rolelists'] = $this->RoleModel->getRoles();
        if ($this->input->method() == "post") {
            $timelimit_product_id = $this->input->post('timelimit_product_id');
            $data = $this->valiRules();
            if ($data['rules_run'] == true) {
                $data['starttime'] = strtotime($data['starttime']);
                $data['endtime'] = strtotime($data['endtime']);
                unset($data['rules_run']);
                if ($this->TimelimitProductModel->editTimelimetProduct($data, array('timelimit_product_id' => $timelimit_product_id))) {
                    $this->session->success = "修改限时秒杀成功";
                    $this->session->mark_as_flash("success");
                    redirect(site_url("TimelimitProduct/index"));
                }
            } else {
                $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $data['timelimit'] = $this->input->post();
                $data['timelimit']['starttime'] = strtotime($this->input->post("starttime"));
                $data['timelimit']['endtime'] = strtotime($this->input->post("endtime"));
                $this->load->view('timelimitproduct_edit', $data);
            }
        } else {
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $data['timelimit'] = $this->TimelimitProductModel->sel($timelimit_product_id);
            $this->load->view("timelimitproduct_edit", $data);
        }
    }

    public function deleteTimelimitProduct()
    {
        $return = $this->input->post('selected');
        if (!empty($return) && is_array($return)) {
            $where = implode(',', $this->input->post('selected'));
            if ($this->TimelimitProductModel->deleteTimelimetProduct('timelimit_product_id in (' . $where . ')')) {
                $this->session->success = "删除成功!";
                $this->session->mark_as_flash("success");
            } else {
                $this->session->success = "删除失败!";
                $this->session->mark_as_flash("success");
            }
        } else {
            $this->session->success = "删除有误!";
            $this->session->mark_as_flash("success");
        }
        redirect(site_url("TimelimitProduct/index"));
    }

    public function startimeCheck($time, $dirh = '0')
    {
        $time = strtotime($time);
        if (empty($dirh)) {
            if (!empty($time) && ($time < time())) {
                $this->form_validation->set_message('startimeCheck', "结束时间不能小于当前时间");
                return false;
            }
        } else {
            if (!empty($time) && $time < strtotime($dirh)) {
                $this->form_validation->set_message('startimeCheck', "结束时间不能小于开始时间");
                return false;
            }
            if (empty($time)) {
                $this->form_validation->set_message('startimeCheck', "结束时间不能为空");
                return false;
            }
        }
    }

    public function valiRules()
    {
        $filerdata = array("product_id", "timelimit_product_name", "timelimit_description", "timelimit_price", "timelimit_num", "starttime", "endtime", "sort_order");
        $data = elements($filerdata, $this->input->post(), "0");
        //验证数据
        $valiRules = array(
            array(
                'field' => 'timelimit_product_name',
                'label' => '限时秒杀名称',
                'rules' => 'required',
                "errors" => array(
                    'required' => "限时秒杀不能为空",
                ),
            ),
            array(
                'field' => 'timelimit_description',
                'label' => '商品详情',
                'rules' => 'required',
                "errors" => array(
                    'required' => "商品详情不能为空",
                ),
            ),
            array(
                'field' => 'timelimit_price',
                'label' => '限时秒杀价格',
                'rules' => 'required',
                "errors" => array(
                    'required' => "限时秒杀不能为空",
                ),
            ),
            array(
                'field' => 'timelimit_num',
                'label' => '活动库存数量',
                'rules' => 'required',
                "errors" => array(
                    'required' => "活动库存数量不能为空",
                ),
            ),
            array(
                'field' => 'endtime',
                'label' => '结束时间',
                'rules' => 'callback_startimeCheck[' . $this->input->post('starttime') . ']',

            ),
            array(
                'field' => 'starttime',
                'label' => '开始时间',
                'rules' => 'required',
                "errors" => array(
                    'required' => "开始时间不能为空",
                ),
            ),

        );
        //验证数据
        $this->form_validation->set_rules($valiRules);
        $data['rules_run'] = $this->form_validation->run();
        return $data;
    }

    /**
     * 自动查询分类名称
     */
    public function autoProduct()
    {
        
        $product_id = $this->input->get_post('product_id');
        if (empty($product_id)) {
            $product_id = '';
        }
        $this->load->model('ProductModel');
        $product_data = $this->ProductModel->getProductById($product_id);
        
        $this->output->set_output(json_encode($product_data['product']));
    }

}
