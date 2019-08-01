<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 支付方式管理
 * @author	qidazhong@hnzhimo.com
 * @copyright	2017 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 * */

class Logistics extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("logisticsModel");
        $this->load->model("RoleModel");
    }

    /**
     * 配送方式列表
     */
    public function getList() {
        $data = array();
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $list = $this->logisticsModel->getList();
        $data['list'] = $list;
        $this->load->view("logistics_list", $data);
    }

    /**
     * 添加配送方式
     */
    public function addLogistics() {
        $this->load->library("form_validation");
        $data['rolelists'] = $this->RoleModel->getRoles();
        $data['result'] = "";
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $checked = array();
        if ($this->input->method() == "post") {
            $rules = $this->getRules();
            $this->form_validation->set_rules($rules);
            $insert_data = elements(array("logistics_name", "logistics_fee", "logistics_add_fee", "support_area", "logistics_weight", "status"), $this->input->post());
            if ($this->form_validation->run()) {
                if ($this->logisticsModel->addLogistics($insert_data)) {
                    $data['result'] = "success";
                    $this->session->success = "添加配送方式成功";
                    $this->session->mark_as_flash("success");
                    redirect(site_url("Logistics/getList"));
                } else {
                    $this->session->error = $this->form_validation->error_string();
                    $this->session->mark_as_flash("error");
                }
            }
            $checked = explode("|", $this->input->post("support_area"));
        }
        //获取所有区域信息
        $data['areas'] = $this->getAreasJson($checked);
        $this->load->view("logistics_add", $data);
    }

    /**
     * 编辑配送方式
     */
    public function editLogistics($logistics_id) {
        $data['result'] = "";
        $this->load->library("form_validation");
        $data['rolelists'] = $this->RoleModel->getRoles();
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        
        if ($this->input->method() == "post") {
            //检查数据
            $logistics_id = $this->input->post("logistics_id");
            $this->load->library("form_validation");
            $this->form_validation->set_rules($this->getRules());
            if ($this->form_validation->run()) {
                $update_data = elements(array("logistics_name", "logistics_fee", "logistics_add_fee", "support_area", "logistics_weight", "status"), $this->input->post());
                if ($this->logisticsModel->editLogistics($update_data, array("logistics_id" => $logistics_id))) {
                    $data['result'] = "success";
                    $this->session->success = "编辑配送方式成功";
                    $this->session->mark_as_flash("success");
                    redirect(site_url("Logistics/getList"));
                } else {
                    $this->session->error = $this->form_validation->error_string();
                    $this->session->mark_as_flash("error");
                }
            }
        }
        $logistics = $this->logisticsModel->getLogistics(array("logistics_id" => $logistics_id));
        $checked = explode("|", $logistics['support_area']);
        
        $data['areas']=$this->getAreasJson($checked);
        $data['logistics'] = $logistics;

        $this->load->view("logistics_edit", $data);
    }

    /**
     * 删除配送方式
     */
    public function deleteLogistics() {
        $ids = $this->input->post("ids");
        $idsarray = explode(",", $ids);
        if ($this->logisticsModel->deleteLogistics(array("logistics_id " => $idsarray))) {
            $this->session->success = "删除成功!";
            $this->session->mark_as_flash("success");
        }
        redirect(site_url('Logistics/getList'));
    }

    /**
     * 获取所有区域信息
     */
    private function getAreasJson($checked = array()) {
        $this->load->model("areaModel");
        $areaTree = $this->areaModel->getAreaTree();

        $tree = array();
        foreach ($areaTree as $node) {
            $array['text'] = $node['name'];
            $array['id'] = "p_" . $node['province_id'];
            $pstate=false;
            if (in_array($array['id'], $checked)) {
                $pstate=true;
            }
            $array['state'] = array("checked" => $pstate);
            $array["nodes"] = array();
            $temp_nodes = array();
            foreach ($node['city'] as $city) {
                $city_nodes = array("text" => $city['name'], "id" => "c_" . $city['city_id']);
                $cstate=false;
                if (in_array("c_" . $city['city_id'], $checked)) {
                    $cstate=true;
                }
                $city_nodes['state'] = array("checked" => $cstate);
                $district_nodes = array();
                foreach ($city['district'] as $district) {
                    $state = false;
                    if (in_array($district['district_id'], $checked)) {
                        $state = true;
                    }
                    $district_nodes[] = array("text" => $district['name'], "id" => $district['district_id'], "state" => array("checked" => $state));
                }
                $city_nodes['nodes'] = $district_nodes;
                $array["nodes"][] = $city_nodes;
            }
            $tree[] = $array;
        }
        $resultTree = array("text" => "选择配送支持区域", "id" => 0, "nodes" => $tree);
        return json_encode(array($resultTree));
    }

    /**
     * 数据验证
     * @return type
     */
    private function getRules() {
        $rules = array(
            array(
                'field' => 'logistics_name',
                'label' => '配送区域名称',
                'rules' => 'required|min_length[2]|max_length[12]',
                "errors" => array("required" => "必须填写名称")
            ),
            array(
                'field' => 'logistics_fee',
                'label' => '首重费用',
                'rules' => 'required|is_numeric',
                "errors" => array("required" => "必须填写首重费用")
            ),
            array(
                'field' => 'logistics_add_fee',
                'label' => '续重费用',
                'rules' => 'required|is_numeric',
                "errors" => array("required" => "必须填写续重费用")
            ),
            array(
                'field' => 'support_area[]',
                'label' => '支持区域',
                'rules' => 'required',
                "errors" => array("required" => "必须选择支持区域")
            ),
            array(
                'field' => 'logistics_weight',
                'label' => '首重',
                'rules' => 'required',
                "errors" => array("required" => "必须填写首重")
            ),
        );
        return $rules;
    }

    static function getModuleInfo() {
        return array(
            "moduleName" => "配送费用管理",
            "controller" => "Logistics",
            "author" => "qidazhong@hnzhimo.com",
            "operation" => array(
                "getList" => "配送费用管理",
                "addLogistics" => "添加配送区域费用",
                "editLogistics" => "修改配送区域",
                "deleteLogistics" => "删除配送区域",
            )
        );
    }

}
