<?php

/**
 * Api管理控制器
 * @author qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 */
class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("apiModel");
    }

    /**
     * api接口配置列表
     */
    public function index() {
        $data = array();
        $keyword = $this->input->post('keyword');
        $where['keyword'] = $keyword;
        $data['keyword'] = $where['keyword'];
        $apiData = $this->apiModel->getApiList($where);
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $data['api_list'] = $apiData;
        $this->load->view("api_list", $data);
    }

    /**
     * 添加api配置
     */
    public function apiAdd() {
        $this->load->library("form_validation");
        $data['result'] = "";
        if ($this->input->method() == "post") {
            $post_data = elements(array("name", "appid", "key", "status"), $this->input->post(), 0);
            $post_data['createtime'] = time();
            $post_data['updatetime'] = time();
            //验证数据
            $valiRules = array(
                array(
                    'field' => 'name',
                    'label' => 'API名称',
                    'rules' => 'required|min_length[2]|max_length[12]|callback_check[name]',
                    "errors" => "请正确填写API名称:名称必填并且不能重复"
                ),
                array(
                    'field' => 'appid',
                    'label' => 'AppId',
                    'rules' => 'required|min_length[8]|max_length[32]|callback_check[appid]',
                    "errors" => "请正确填写APIID:最小8位字符最大32位字符"
                ),
                array(
                    'field' => 'key',
                    'label' => 'API密钥',
                    'rules' => 'required|min_length[32]|max_length[32]',
                    "errors" => array(
                        'required' => 'API密钥不能为空',
                        'min_length' => '密钥长度最短为32位',
                        'max_length' => '密钥长度不超过32位'
                    )
                ),
            );
            $this->form_validation->set_rules($valiRules);
            if ($this->form_validation->run() && $this->apiModel->addApi($post_data)) {
                $this->session->success = "添加API成功";
                $this->session->mark_as_flash("success");
                redirect(site_url('Api/index'));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view("api_add", $data);
    }

    /**
     * 修改api配置
     * 
     */
    public function apiUpdate($api_id) {
        $this->load->library("form_validation");
        $data['result'] = "";
        if ($this->input->method() == "post") {
            $post_data = elements(array("name", "appid", "key", "status"), $this->input->post(), 0);
            $post_data['updatetime'] = time();
            //验证数据
            $valiRules = array(
                array(
                    'field' => 'name',
                    'label' => 'Api名称',
                    'rules' => 'required|min_length[2]|max_length[12]|callback_check[name]',
                    "errors" => "请正确填写API名称:名称必填并且不能重复"
                ),
                array(
                    'field' => 'appid',
                    'label' => 'AppId',
                    'rules' => 'required|min_length[8]|max_length[32]|callback_check[appid]',
                    "errors" => "请正确填写APIID:最小8位字符最大32位字符"
                ),
                array(
                    'field' => 'key',
                    'label' => 'API密钥',
                    'rules' => 'required|min_length[32]|max_length[32]',
                    "errors" => "请正确填写API密钥:名称必填并且不能重复，密钥长度必须是32个字母或者数字"
                ),
            );
            $this->form_validation->set_rules($valiRules);
            if ($this->form_validation->run() &&
                    $this->apiModel->updateApi($post_data, array("api_id" => $this->input->post("api_id")))) {
                $this->session->success = "修改API成功";
                $this->session->mark_as_flash("success");
                redirect(site_url('Api/index'));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                redirect(site_url('Api/apiUpdate/' . $this->input->post("api_id")));
            }
        }

        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $api_info = $this->apiModel->getApiById($api_id);
        $data['api'] = $api_info;
        $this->load->view("api_edit", $data);
    }

    public function check($value, $index) {
        $lable="Api名称";
        if($index=="appid"){
            $lable="AppID";
        }
        
        if($this->apiModel->getApi(array($index => $value, "api_id!=" => $this->uri->segment(3)))){
             $this->form_validation->set_message('check', $lable.'不能重复');
             return false;
        }
        
        return true;
    }

    /**
     * 删除api配置
     */
    public function apiDelete() {
        $selected = $this->input->post('setting_id');
        if (!empty($selected) && is_array($this->input->post('setting_id'))) {
            $where = implode(',', $this->input->post('setting_id'));
            if ($this->apiModel->deleteApi('api_id in (' . $where . ')')) {
                $this->session->success = '删除成功';
                $this->session->mark_as_flash("success");
            } else {
                $this->session->error = '删除失败';
                $this->session->mark_as_flash("error");
            }
            redirect(site_url('Api/index'));
        }
    }

    static function getModuleInfo() {
        return array(
            "moduleName" => "Api配置",
            "controller" => "Api",
            "author" => "zhandi1949",
            "icon" => "",
            "operation" => array(
                "index" => "Api列表",
                "apiAdd" => "添加Api",
                "apiUpdate" => "修改Api",
                "apiDelete" => "删除Api"
            )
        );
    }

}
