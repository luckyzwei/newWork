<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 代理分组管理
 * @package	ZMshop
 * @author	liuchenwei@hnzhimo.com
 * @copyright	2017 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class AgentGroup extends CI_Controller {

    //设置控制权限
    static function getModuleInfo() {
        return array(
            "moduleName" => "分销商等级管理",
            "controller" => "AgentGroup",
            "author" => "liuchenwei@hnzhimo.com",
            "operation" => array(
                "index" => "分销商等级列表",
                "addAgentGroup" => "添加分销商等级",
                "updateAgentGroup" => "修改分销商等级",
                "deleteAgentGroup" => "删除分销商等级",
            )
        );
    }

    public function __construct() {
        parent::__construct();
        $this->load->model("AgentGroupModel");
        $this->load->model("RoleModel");
    }

    //加载代理分组列表
    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $this->load->helper('url');
        $this->load->library("pagination");
        $data = array();
        $where = array();
        $filter_group_name = $this->input->post('filter_group_name');
        $where['filter_group_name'] = $filter_group_name;
        $data['filter_group_name'] = $where['filter_group_name'];
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 10;
        $categorydata = $this->AgentGroupModel->getAgentGroupList($where, $page, $limit);
        $config['base_url'] = site_url('AgentGroup/index'); //当前分页地址
        $config['total_rows'] = $categorydata['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $this->pagination->initialize($config);
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $categorydata['result'];
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('agentgroup', $data);
    }

    //添加代理分组
    public function addAgentGroup() {
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $data['rolelists'] = $this->RoleModel->getRoles();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $data['result'] = "fail";
        if ($this->input->method() == "post") {
            $this->form_validation->set_rules("agent_group_name", "分销商等级名称不能为空,并且不能大于12个汉字", "required|max_length[12]");
            $this->form_validation->set_rules("commission_rate[]", "佣金返现比例", "required");
            if ($this->form_validation->run() == True) {
                $data = array(
                    "agent_group_name" => $this->input->post("agent_group_name"),
                    "commission_rate" => serialize($this->input->post("commission_rate")),
                    "need_reward"=>trim($this->input->post("need_reward"))?trim($this->input->post("need_reward")):"0",
                    "need_member"=>trim($this->input->post("need_member"))?trim($this->input->post("need_member")):"0",
                    "condation"=>$this->input->post("condation")
                );

                $this->AgentGroupModel->addAgentGroup($data);
                $this->session->success = "添加分销商等级成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("AgentGroup/index"));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        $this->load->view("agentgroup_add", $data);
    }

    //修改代理分组
    public function updateAgentGroup() {
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        if ($this->input->method() == "post") {
            $this->form_validation->set_rules("agent_group_name", "分销商等级名称不能为空,并且不能大于12个汉字", "max_length[12]|required");
            $this->form_validation->set_rules("commission_rate[]", "佣金返现比例不能为空", "required");
            if ($this->form_validation->run() == True) {
                $updateData = array(
                    "agent_group_name" => $this->input->post("agent_group_name"),
                    "commission_rate" => serialize($this->input->post("commission_rate")),
                    "need_reward"=>trim($this->input->post("need_reward"))?trim($this->input->post("need_reward")):"0",
                    "need_member"=>trim($this->input->post("need_member"))?trim($this->input->post("need_member")):"0",
                    "condation"=>$this->input->post("condation")
                );
                $this->AgentGroupModel->update($this->input->post("agent_group_id"), $updateData);
                $this->session->success = "修改分销商等级成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("AgentGroup/index"));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $data['agentgroup'] = $this->input->post();
            }
        } else {
            $data['agentgroup'] = $this->AgentGroupModel->sel($this->uri->segment(3));
            $data['agentgroup']['commission_rate'] = unserialize($data['agentgroup']['commission_rate']);
        }
        $this->load->view('agentgroup_edit', $data);
    }

    //删除代理分组
    public function deleteAgentGroup() {
        $xuan = $this->input->post('selected');
        if (!empty($xuan) && is_array($xuan)) {
            $where = implode(',', $this->input->post('selected'));
            if ($this->AgentGroupModel->delete('agent_group_id in (' . $where . ')')) {
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
        redirect(site_url('AgentGroup/index'));
    }

    /**
     * 设置为默认分组
     * @param type $group_id
     */
    public function setDefault($group_id) {
        $result = array("error_code" => 1);
        if ($this->AgentGroupModel->setDefault($group_id)) {
            $result = array("error_code" => 0);
        }
        $this->output->set_content_type("json/application")->set_output(json_encode($result));
    }

}
