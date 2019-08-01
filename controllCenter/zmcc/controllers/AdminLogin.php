<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 管理员登陆和退出
 * @package	ZMshop
 * @author	    qidazhong@hnzhimo.com
 * @copyright	2017 河南知默网络科技有限公司
 * @link	    http://www.hnzhimo.com
 * @since	    Version 1.0.0
 */
class AdminLogin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("AdminModel");
        $this->load->model("RoleModel");
    }

    /**
     * 管理员登录
     */
    public function login() {
        $this->load->library("form_validation");
        $this->load->helper('url');
        if ($this->input->method() == 'post') {
            $this->form_validation->set_rules('name', '账号不能为空', 'required');
            $this->form_validation->set_rules('password', '密码不能为空', 'required');
            if ($this->form_validation->run()) {
                $this->session->error = $this->checkUser();
            } else {//数据验证不通过
                $this->session->error = $this->form_validation->error_string();
            }
            if (!empty($this->session->error)) {
                $this->session->mark_as_flash('error');
                redirect(site_url('AdminLogin/login'));
            } else {
                redirect(site_url('Welcome/index'));
            }
        } else {
            $data['title'] = $this->zmsetting->get("site_name")."管理后台";
            $data['site_name'] = $this->zmsetting->get("site_name");
            $this->load->view('login', $data);
        }
    }

    /**
     * 检测用户的账号密码
     */
    private function checkUser() {
        $where = array("admin.name" => $this->input->post("name"), "admin.password" => md5($this->input->post("password")));
        $adminInfo = $this->AdminModel->getAdminInfo($where);
        $error = "";
        if (empty($adminInfo)) {
            $error = "登录失败，账号或密码错误！";
            $this->session->failtimes += 1;
            $this->session->ftime = time();
            if ($this->session->failtimes >= 15) {
                $error = "您登录错误次数超过十五次，已锁定，请联系管理员！";
            }
        } else {//检查状态和是否过期
            if ($adminInfo['status'] != 1 || time() > $adminInfo['expiretime']) {
                $error = "您的账号已锁定或已经过期，请联系管理员！";
            } else {//登陆成功
                $data['failtimes'] = 0;
                $where = array("name" => $this->input->post("name"));
                $this->AdminModel->editAdmin($data, $where);
                $this->session->adminInfo = $adminInfo;
                //删除记录session
                $this->session->unset_userdata("failtimes");
            }
        }
        return $error;
    }

    /**
     * 管理员退出
     */
    public function logout() {
        $delsession = array("adminInfo", "leftMenu");
        $this->session->unset_userdata($delsession);
        redirect(site_url("AdminLogin/login"));
    }

    /**
     * 管理员修改自己的信息
     */
    public function editPrivateInfo() {
        if (!$this->session->adminInfo['admin_id']) {
            $header = "权限错误";
            $message = "您尚未登陆或者信息错误";
            $data = array(
                "heading" => $header,
                "message" => $message
            );
            $this->load->view("errors/html/error_general", $data);
        } else {
            $this->editAdminInfo($this->session->adminInfo['admin_id']);
        }
    }

    private function editAdminInfo($admin_id) {
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data['rolelists'] = $this->RoleModel->getRoles();
        $inputdata=array();
        if ($this->input->method() == 'post') {
            $this->form_validation->set_rules('password', '您的密码', 'min_length[6]', array('min_length' => '密码最少为6位'));
            $this->form_validation->set_rules('nickname', '您的昵称', 'required|callback_adminNicknameCheck');
            if ($this->form_validation->run()) {
                $admindata = array(
                    'nickname' => $this->input->post('nickname'),
                    'avatar' => $this->input->post("avatar"),
                    'updatetime' => time(),
                );
                $password = $this->input->post('password');
                if (!empty($password)) {
                    $admindata['password'] = md5($password);
                }
                $this->AdminModel->editAdmin($admindata, array('admin_id' => $admin_id));
                $this->session->success = "信息修改成功!";
                $this->session->mark_as_flash("success");
                redirect(site_url('AdminLogin/editPrivateInfo'));
            } else {
                $inputdata['admin'] = $this->input->post();
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        $data['admin'] = $this->AdminModel->getAdminById($admin_id);
        if(!empty($inputdata)){
            $data['admin']['nickname']=$inputdata['admin']['nickname'];
            $data['admin']['avatar']=$inputdata['admin']['avatar'];
        }
        $this->load->view('admin_edit_private', $data);
    }

    public function adminNicknameCheck($nickname) {
        $checkData['nickname'] = $nickname;

        $checkData['admin_id!='] = $this->session->adminInfo['admin_id'];

        if ($this->AdminModel->isExist($checkData)) {
            $this->form_validation->set_message('adminNicknameCheck', '您的昵称已经被占用请修改');
            return false;
        }
        return true;
    }

    static function getModuleInfo() {
        return array();
    }

}
