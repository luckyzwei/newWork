<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 管理员管理控制器
 * @package	ZMshop
 * @author	    qidazhong@hnzhimo.com
 * @copyright	2017 河南知默网络科技有限公司
 * @link	    http://www.hnzhimo.com
 * @since	    Version 1.0.0
 */
class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("AdminModel");
        $this->load->model("RoleModel");
    }

    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $this->load->library("pagination");
        $data = array();
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 10;
        $adminlists = $this->AdminModel->getAdminLists($limit, $page);
        $config['base_url'] = site_url('Admin/index'); //当前分页地址
        $config['total_rows'] = $adminlists['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $config['cur_page'] = $page;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['adminlists'] = $adminlists['datas'];
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('admin', $data);
    }

    /**
     * 添加管理员
     */
    public function addAdmin() {
        $this->load->helper('url');
        $this->load->library("form_validation");
        if ($this->input->method() == 'post') {
            $this->form_validation->set_rules('name', '管理员名称', 'required|callback_adminNameCheck');
            $this->form_validation->set_rules('password', '管理员密码', 'required|alpha_numeric|min_length[6]', array('alpha_numeric' => '密码只能是子母或者数字组成，不能含有别的符号', 'min_length' => '密码最少为6位'));
            $this->form_validation->set_rules('nickname', '管理员昵称', 'required|callback_adminNicknameCheck');
            $this->form_validation->set_rules('role_id', '管理员角色', 'required');
            $this->form_validation->set_rules('status', '管理员状态', 'required');
            $this->form_validation->set_rules('expiretime', '管理员过期时间', 'required');
            if ($this->form_validation->run()) {
                $admindata = array(
                    'name' => $this->input->post('name'),
                    'password' => md5($this->input->post('password')),
                    'nickname' => $this->input->post('nickname'),
                    'avatar' => $this->input->post("avatar"),
                    'role_id' => $this->input->post('role_id'),
                    'status' => $this->input->post('status'),
                    'createtime' => time(),
                    'expiretime' => strtotime($this->input->post('expiretime'))
                );
                $this->AdminModel->addAdmin($admindata);
                $this->session->success = "管理员添加成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Admin/addAdmin"));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        $data['rolelists'] = $this->RoleModel->getRoles();
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('admin_add', $data);
    }

    /**
     * 编辑管理员信息
     * @param type $admin_id
     */
    public function editAdmin($admin_id=0) {
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data['rolelists'] = $this->RoleModel->getRoles();
        // var_dump($this->input->post());die;
        if ($this->input->method() == 'post') {
            $admin_id = $this->input->post('admin_id');
            $this->form_validation->set_rules('name', '管理员名称', 'required|callback_adminNameCheck');
            $this->form_validation->set_rules('password', '管理员密码', 'min_length[6]', array('min_length' => '密码最少为6位'));
            $this->form_validation->set_rules('nickname', '管理员昵称', 'required|callback_adminNicknameCheck');
            $this->form_validation->set_rules('role_id', '管理员角色', 'required');
            $this->form_validation->set_rules('status', '管理员状态必填', 'required');
            $this->form_validation->set_rules('expiretime', '管理员过期时间', 'required');
            if ($this->form_validation->run()) {
                $admindata = array(
                    'name' => $this->input->post('name'),
                    'nickname' => $this->input->post('nickname'),
                    'avatar' => $this->input->post("avatar"),
                    'role_id' => $this->input->post('role_id'),
                    'status' => $this->input->post('status'),
                    'updatetime' => time(),
                    'expiretime' => strtotime($this->input->post('expiretime'))
                );
                $password = $this->input->post('password');
                if (!empty($password)) {
                    $admindata['password'] = md5($password);
                }
                
                $this->AdminModel->editAdmin($admindata, array('admin_id' => $admin_id));
                $this->session->success = "管理员修改成功";
                $this->session->mark_as_flash("success");
                
            } else {
                $data['admin'] = $this->input->post();
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
            redirect(site_url("Admin/editAdmin/".$admin_id));
        }
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        if (empty($data['admin'])) {
            $data['admin'] = $this->AdminModel->getAdminById($admin_id);
        }
        $this->load->view('admin_edit', $data);
    }

    /**
     * 删除管理员
     */
    public function deleteAdmin() {
        $select = $this->input->post('selected');
        if (!empty($select) && is_array($select)) {
            $adminids = implode(",", $select);
            $where = " admin_id in(" . $adminids . ")";
            $result = $this->AdminModel->deleteAdmin($where);
            if ($result) {
                $this->session->success = "管理员删除成功";
                $this->session->mark_as_flash("success");
            } else {
                $this->session->error = "管理员删除成功";
                $this->session->mark_as_flash("error");
            }
        }
        redirect(site_url('Admin/index'));
    }

    public function adminNameCheck($name) {
        $checkData = array("name" => $name);
        if (strtolower($this->uri->segment(2)) == "editadmin") {
           $checkData['admin_id!='] = $this->uri->segment(3);
        }
        if ($this->AdminModel->isExist($checkData)) {
            $this->form_validation->set_message('adminNameCheck', '管理员名称不能重复');
            return false;
        }
        return true;
    }

    public function adminNicknameCheck($nickname) {
        $checkData = array("nickname" => $nickname);
        if (strtolower($this->uri->segment(2)) == "editadmin") {
            $checkData['admin_id!='] = $this->uri->segment(3);
        }
        if ($this->AdminModel->isExist($checkData)) {
            $this->form_validation->set_message('adminNicknameCheck', '管理员昵称不成重复');
            return false;
        }
        return true;
    }

    static function getModuleInfo() {
        return array(
            "moduleName" => "管理员管理",
            "controller" => "Admin",
            "author" => "qidazhong@hnzhimo.com",
            "icon" => "",
            "operation" => array(
                "index" => "管理员列表",
                "editAdmin" => "修改管理员",
                "deleteAdmin" => "删除管理员",
                "addAdmin" => "添加管理员",
                "adminLogin" => "管理员登录",
                "adminLogout" => "管理员退出",
                "-autoAdminList" => "管理员自动加载"
            )
        );
    }

}
