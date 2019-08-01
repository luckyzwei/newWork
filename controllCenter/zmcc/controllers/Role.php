<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 管理员角色控制器
 * @author qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 */
class Role extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("roleModel");
    }

    /**
     * 角色数据列表
     */
    public function index() {
        $data = array();

        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $roles = $this->roleModel->getRoles();
        $data['roles'] = $roles;
        $this->load->view("role_list", $data);
    }

    public function getModulesForRole($checked = array()) {
        $modules = $this->getModules();
        foreach ($modules as $module) {
            $array = array();
            if (!empty($module)) {
                if (!empty($module['method'])) {
                    $array['id'] = $module['controller'] . "/" . $module['method'];
                } else {
                    $array['id'] = $module['controller'];
                }
                $array['text'] = $module['moduleName'];

                $array['tags'] = count($module['operation']);
                if (in_array($array['id'], $checked)) {
                    $array['state'] = array("checked" => true);
                } else {
                    $array['state'] = array("checked" => false);
                }
                if (!empty($module['operation'])) {
                    foreach ($module['operation'] as $key => $value) {
                        $id = $module['controller'] . "/" . $key;
                        if (in_array($id, $checked)) {
                            $state = array("checked" => true);
                        } else {
                            $state = array("checked" => false);
                        }
                        $array['nodes'][] = array("text" => $value, "id" => $id, "state" => $state);
                    }
                }
                $treenodes[] = $array;
            }
        }
        return json_encode($treenodes);
    }

    /**
     * 添加角色
     */
    public function roleAdd() {
        $this->load->library("form_validation");
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $post_power = array();
        if ($this->input->method() == "post") {
            //验证数据
            $valirule = array(
                array(
                    'field' => 'role_power',
                    'label' => '操作权限',
                    'rules' => 'required',
                    "errors" => array("required" => "请为角色选择授权操作")
                ),
                array(
                    'field' => 'role_name',
                    'label' => '角色名称',
                    'rules' => 'required|min_length[2]|max_length[8]|callback_roleCheck',
                    "errors" => array(
                        "required" => "角色名称有误：重复或者是长度不符合要求",
                    )
                ),
            );
            $this->form_validation->set_rules($valirule);
            $insert_data = elements(array("role_name", "role_power"), $this->input->post());
            if ($this->form_validation->run() && $this->roleModel->addRole($insert_data)) {
                $this->session->success = "新增管理员角色成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("role/roleAdd"));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
            $post_power = explode(",", $this->input->post("role_power"));
        }

        $all_powers = $this->getModulesForRole($post_power);
        $data['powers'] = $all_powers;
        $this->load->view("role_add", $data);
    }

    /**
     * 编辑管理员角色
     * @param type $role_id
     */
    public function roleEdit($role_id) {
        $this->load->library("form_validation");
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $role = $this->roleModel->getRoleById($role_id);
        $data['role'] = $role;
        $data['result'] = "";
        $post_power = array();
        if (empty($role)) {
            echo "数据错误";
            exit;
        }
        if ($this->input->method() == "post") {
            $role_id = $this->input->post("role_id");
            //验证数据
            $valirule = array(
                array(
                    'field' => 'role_power',
                    'label' => '操作权限',
                    'rules' => 'required',
                    "errors" => array("required" => "请为角色选择授权操作")
                ),
                array(
                    'field' => 'role_name',
                    'label' => '角色名称',
                    'rules' => 'required|min_length[2]|max_length[8]|callback_roleCheck[' . $this->input->post("role_id") . ']',
                    "errors" => array(
                        "required" => "角色名称有误：重复或者是长度不符合要求",
                    )
                ),
            );
            $this->form_validation->set_rules($valirule);

            $up_data = elements(array("role_name", "role_power"), $this->input->post());
            if ($this->form_validation->run() && $this->roleModel->updateRole($up_data, array("role_id" => $this->input->post("role_id")))) {
                $this->session->success = "修改管理员角色成功";
                $this->session->mark_as_flash("success");
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
            $post_power = explode(",", $this->input->post("role_power"));
            redirect(site_url('Role/roleEdit/' . $role_id));
        }
        if (empty($post_power)) {
            $post_power = explode(",", $role['role_power']);
        }
        $all_powers = $this->getModulesForRole($post_power);

        $data['powers'] = $all_powers;
        $this->load->view("role_edit", $data);
    }

    public function roleDelete() {
        $selected = $this->input->post('role_id');
        if (!empty($selected) && is_array($this->input->post('role_id'))) {
            $where = implode(',', $this->input->post('role_id'));
            if ($this->roleModel->deleteRole('role_id in (' . $where . ')')) {
                $this->session->success = '删除成功';
                $this->session->mark_as_flash("success");
            } else {
                $this->session->error = '删除失败';
                $this->session->mark_as_flash("error");
            }
            redirect(site_url('Role/index'));
        }
    }

    private function getModules() {
        $this->load->helper('file');
        $controllers = get_filenames(APPPATH . 'controllers/');
        foreach ($controllers as $controller) {
            $path = pathinfo($controller);
            if (strtolower($path['extension']) != "html") {
                require_once APPPATH . 'controllers/' . $controller;
                $class_name = basename($controller, ".php");
                if (method_exists($class_name, "getModuleInfo")) {
                    $modules_info = $class_name::getModuleInfo();
                    if (!isset($modules_info['hidden']) || !$modules_info['hidden']) {
                        $moudles_info[] = $class_name::getModuleInfo();
                    }
                }
            }
        }
        return $moudles_info;
    }

    /**
     * 检验名称是否重复
     */
    public function roleCheck($role_name, $roleid = 0) {
        $hasrole = $this->roleModel->getRoles(array("role_name" => $role_name, "role_id!=" => $roleid));
        if (!empty($hasrole)) {
            return false;
        }
        return true;
    }

    static function getModuleInfo() {
        return array(
            "moduleName" => "角色管理",
            "controller" => "Role",
            "author" => "zhandi1949",
            "icon" => "",
            "operation" => array(
                "index" => "角色管理",
                "roleAdd" => "添加角色",
                "roleEdit" => "修改角色",
                "roleDelete" => "删除角色"
            )
        );
    }

}
