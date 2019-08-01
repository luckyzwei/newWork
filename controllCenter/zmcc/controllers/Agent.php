<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 分销商申请管理
 * @package	ZMshop
 * @author	liuchenwei@hnzhimo.com
 * @copyright	2017 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class Agent extends CI_Controller {

    //设置控制权限
    static function getModuleInfo() {
        return array(
            "moduleName" => "分销商管理",
            "controller" => "Agent",
            "author" => "qidazhong@hnzhimo.com",
            "operation" => array(
                "index" => "分销商",
                "Agent" => "审核分销商申请",
                "deleteAgent" => "删除分销商",
            )
        );
    }

    public function __construct() {
        parent::__construct();
        $this->load->model("AgentModel");
        $this->load->model("userModel");
        $this->load->model("storeModel");
    }

    //加载代理申请列表页
    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $this->load->helper('url');
        $this->load->library("pagination");
        $data = array();
        $where = array();
        $where['filter_agent'] = $this->input->post('filter_agent');
        $data['filter_agent'] = $where['filter_agent'];
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 10;
        $categorydata = $this->AgentModel->getList($where, $page, $limit);
        $config['base_url'] = site_url('Agent/index'); //当前分页地址
        $config['total_rows'] = $categorydata['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $this->pagination->initialize($config);
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $categorydata['result'];
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('agent', $data);
    }

    //代理申请审核
    public function agent($agent_id = "") {
        
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        if ($this->input->method() == "post") {
           
            $this->form_validation->set_rules("agent_status", "审核状态", "required");

            if ($this->form_validation->run() == True) {
                $data = array(

                    "agent_group_id" => $this->input->post("agent_group_id"),
                    "agent_status" => $this->input->post("agent_status"),
                    "remark" => $this->input->post("remark"),
                    "checktime" => time(),
                );
                $this->AgentModel->updateAgent($data, array("agent_id" => $this->input->post('agent_id')));
                $this->session->success = "审核分销商成功!";
                $this->session->mark_as_flash("success");
                redirect(site_url('Agent/index'));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        
        $data['agent_group'] = $this->AgentModel->getAgentGroup();
        $data['agent'] = $this->AgentModel->getAgentById($agent_id);
        $data['user_ext_info']=$this->userModel->getMemberInfo($data['agent']['user_id']);
        $this->load->view('agent_edit', $data);
    }

    /**
     * 删除代理商：同时删除店铺信息
     */
    public function deleteAgent() {
        $ids = $this->input->post('selected');
        if (!empty($ids) && is_array($ids)) {
            //删除店铺信息
            foreach($ids as $agent_id){
                $agent_info=$this->AgentModel->getAgentById($agent_id);
                $user_id=$agent_info['user_id'];
                $this->storeModel->deleteStore($user_id);
            }
            //删除分销商
            if ($this->AgentModel->deleteAgent($ids)) {
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
        redirect(site_url('Agent/index'));
    }

}
