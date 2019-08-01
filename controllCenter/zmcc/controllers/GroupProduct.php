<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 商品团购管管理
 * 
 * @package	ZMshop
 * @author	liuchenwei@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class GroupProduct extends CI_Controller {

    //设置控制权限
    static function getModuleInfo() {
        return array(
            "moduleName" => "团购商品管理",
            "controller" => "GroupProduct",
            "author" => "liuchenwei@hnzhimo.com",
            "operation" => array(
                "index" => "商品团购列表",
                "addGroupProduct" => "添加商品团购",
                "editGroupProduct" => "编辑商品团购",
                "deleteGroupProduct" => "删除商品团购",
            )
        );
    }

    public function __construct() {
        parent::__construct();
        $this->load->model("GroupProductModel");
        $this->load->model("RoleModel");
    }

    //加载商品团购列表
    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $this->load->helper('url');
        $this->load->library("pagination");
        $data = array();
        $where = array();
        $filter_agent = $this->input->post('filter_agent');
        $where['filter_agent'] = $filter_agent;
        $data['filter_agent'] = $where['filter_agent'];
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 10;
        $categorydata = $this->GroupProductModel->getList($where, $page, $limit);
        $config['base_url'] = site_url('GroupProduct/index'); //当前分页地址
        $config['total_rows'] = $categorydata['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $this->pagination->initialize($config);
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $categorydata['result'];
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('groupproduct', $data);
    }

    //添加商品拼团
    public function addGroupProduct() {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        if ($this->input->method() == "post") {
            $data = $this->valiRules();
            if ($data['rules_run'] == True) {
                unset($data['rules_run']);
                $data['starttime'] = empty($data['starttime']) ? '' : strtotime($data['starttime']);
                $data['endtime'] = empty($data['endtime']) ? '' : strtotime($data['endtime']);
                $res = $this->GroupProductModel->addGroupProduct($data);
                if (!empty($res)) {
                    $this->session->success = "添加团购商品成功";
                    $this->session->mark_as_flash("success");
                    redirect(site_url("GroupProduct/index"));
                } else {
                    $this->session->error = $res;
                    $this->session->mark_as_flash("error");
                    $data['action'] = site_url("GroupProduct/addGrouProduct");
                    $this->load->view("groupproduct_add", $data);
                }
            } else {
                $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $this->load->view('groupproduct_add', $data);
            }
        } else {
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $this->load->view("groupproduct_add", $data);
        }
    }

    //编辑商品团购
    public function editGroupProduct($group_product_id) {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $data['rolelists'] = $this->RoleModel->getRoles();
        if ($this->input->method() == "post") {
            $group_product_id = $this->input->post('group_product_id');
            $data = $this->valiRules();
            if ($data['rules_run'] == True) {
                unset($data['rules_run']);
                $data['starttime'] = empty($data['starttime']) ? '' : strtotime($data['starttime']);
                $data['endtime'] = empty($data['endtime']) ? '' : strtotime($data['endtime']);
                $res = $this->GroupProductModel->editGroupProduct($data, array('group_product_id' => $group_product_id));
                if (!empty($res)) {
                    $this->session->success = "修改商品团购成功";
                    $this->session->mark_as_flash("success");
                    redirect(site_url("GroupProduct/index"));
                } else {
                    $this->session->error = $res;
                    $this->session->mark_as_flash("error");
                    $this->load->view("groupproduct_edit", $data);
                }
            } else {
                $group = $this->GroupProductModel->sel($group_product_id);
                $data['groupproduct'] = $group['count'];
                $data['name'] = $group['result'];
                $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $this->load->view('groupproduct_edit', $data);
            }
        } else {
            $group = $this->GroupProductModel->sel($group_product_id);
            $data['groupproduct'] = $group['count'];
            $data['name'] = $group['result'];
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $this->load->view("groupproduct_edit", $data);
        }
    }

    //删除商品团购信息
    public function deleteGroupProduct() {
        $return = $this->input->post('selected');
        if (!empty($return) && is_array($return)) {
            $where = implode(',', $this->input->post('selected'));
            if ($this->GroupProductModel->deleteGroupProduct('group_product_id in (' . $where . ')')) {
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
        redirect(site_url('GroupProduct/index'));
    }

    //验证日期时间
    public function startimeCheck($time, $dirh = '0') {
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
        }
    }

    //验证填写色数据
    public function valiRules() {
        $filerdata = array("product_id", "group_product_store", "group_user_num_every", "group_product_name", "group_description", "group_product_price", "group_user_num", "starttime", "endtime", "group_time", "show_group_list", "auto_group", "notice_group");
        $data = elements($filerdata, $this->input->post(), "0");
        //验证数据
        $valiRules = array(
            array(
                'field' => 'group_product_name',
                'label' => '团购名称',
                'rules' => 'required',
                "errors" => array(
                    'required' => "团购名称不能为空"
                )
            ),
            array(
                'field' => 'group_product_price',
                'label' => '团购价格',
                'rules' => 'required',
                "errors" => array(
                    'required' => "团购价格不能为空"
                )
            ),
            array(
                'field' => 'group_user_num',
                'label' => '团购人数',
                'rules' => 'required',
                "errors" => array(
                    'required' => "团购人数不能为空"
                )
            ),
            array(
                'field' => 'group_time',
                'label' => '成团时间',
                'rules' => 'required',
                "errors" => array(
                    'required' => "成团时间不能为空"
                )
            ),
            array(
                'field' => 'endtime',
                'label' => '结束时间',
                'rules' => 'callback_startimeCheck[' . $this->input->post('starttime') . ']',
                "errors" => "请正确填写设置项名称:时间设置错误"
            ),
        );
        //验证数据
        $this->form_validation->set_rules($valiRules);
        $data['updatetime'] = time();
        $data['rules_run'] = $this->form_validation->run();
        return $data;
    }

    /**
     * 自动查询商品团购名称
     */
    public function autoGroupProduct() {
        $group_product_id = $this->input->get_post('group_product_id');
        if (!empty($group_product_id)) {
            $group_product_id = $this->input->get_post('group_product_id');
        } else {
            $group_product_id = '';
        }
        $group = $this->GroupProductModel->getGroup($group_product_id);
        $this->output->set_output(json_encode($group));
    }

}
