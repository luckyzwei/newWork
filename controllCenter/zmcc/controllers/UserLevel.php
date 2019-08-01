<?php

/**
 * 用户等级管理控制器
 * @package   ZMshop
 * @author     xuhuan@hnzhimo.com
 * @copyright  2017 河南知默网络科技有限公司
 * @link       http://www.hnzhimo.com
 * @since      Version 1.0.0
 */
class UserLevel extends CI_Controller {

    static function getModuleInfo() {
        return array(
            "moduleName" => "等级管理",
            "controller" => "UserLevel",
            "author" => "xuhuan@hnzhimo.com",
            "operation" => array(
                "index" => "等级列表",
                "insertLevel" => "添加等级",
                "editLevel" => "修改等级",
                "deleteLevel" => "删除等级"
            )
        );
    }

    public function __construct() {
        parent::__construct();
        $this->load->model("UserLevelModel");
    }

    public function index() {
        $this->load->helper('url');
        $this->load->library('pagination');



        $data = array();

        $where = array();
        $level_name = $this->input->post('filter_level_name');
        if (!empty($level_name)) {
            $where['level_name'] = $level_name;
        } else {
            $where['level_name'] = '';
        }
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 20;
        $offset = $this->input->get('per_page');
        $offset = $offset ? $offset : 1;
        $levellist = $this->UserLevelModel->getUserLevelList($where, $limit, $offset);
        $config['total_rows'] = $levellist['count']; //共有多少条数据
        $config['base_url'] = site_url('UserLevel/index'); //当前分页地址
        $config['per_page'] = $limit;    //每页显示的条数
        $config['cur_page'] = $offset;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links(); //可以分的页数
        $data['count'] = $levellist['count']; //显示共有多少条数据
        $data['levellist'] = $levellist['data'];
        $this->load->view('userlevel', $data);
    }

    public function insertUserLevel() {
        $this->load->helper("url");
        $this->load->library('form_validation');
        if ($this->input->method() == "post") {
            $this->form_validation->set_rules('level_name', '会员等级名称必填', 'trim|required');
            $this->form_validation->set_rules('integral', '升级所需积分必填', 'required|max_length[10]', array('max_length' => '等级升级积分最长为10位数'));
            $this->form_validation->set_rules('auto_upgrade', '是否自动升级必填', 'required');
            $this->form_validation->set_rules('level_sort', '会员等级排序最大5位长度', 'max_length[5]');
            if ($this->form_validation->run() == True) {
                $leveldata = array(
                    'level_name' => $this->input->post('level_name'),
                    'integral' => $this->input->post('integral'),
                    'auto_upgrade' => $this->input->post('auto_upgrade'),
                    'level_sort' => $this->input->post('level_sort'),
                    'level_image' => $this->input->post('level_image')
                );
                $this->UserLevelModel->addUserLevel($leveldata);
                $this->session->success = "新增等级成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("UserLevel/index"));
            } else {
                $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $this->load->view('userlevel_add', $data);
            }
        } else {
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $this->load->view("userlevel_add", $data);
        }
    }

    public function editUserLevel($level_id) {
        $this->load->helper("url");
        $this->load->library('form_validation');
        if ($this->input->method() == "post") {
            $level_id = $this->input->post('level_id');
            $this->form_validation->set_rules('level_name', '会员等级名称必填', 'trim|required');
            $this->form_validation->set_rules('integral', '升级所需积分必填', 'required|max_length[10]', array('max_length' => '等级升级积分最长为10位数'));
            $this->form_validation->set_rules('auto_upgrade', '是否自动升级必填', 'required');
            $this->form_validation->set_rules('level_sort', '会员等级排序最大5位长度', 'max_length[5]');
            if ($this->form_validation->run() == True) {
                $leveldata = array(
                    'level_name' => $this->input->post('level_name'),
                    'integral' => $this->input->post('integral'),
                    'auto_upgrade' => $this->input->post('auto_upgrade'),
                    'level_sort' => $this->input->post('level_sort'),
                    'level_image' => $this->input->post('level_image')
                );

                $this->UserLevelModel->editUserLevel($leveldata, array('level_id' => $level_id));
                $this->session->success = "修改等级信息成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("UserLevel/index"));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
                $data['level'] = $this->input->post();
                $this->load->view('userlevel_edit', $data);
            }
        } else {
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $data['level'] = $this->UserLevelModel->getUserLevelById($level_id);
            $this->load->view('userlevel_edit', $data);
        }
    }

    public function deleteUserLevel() {
        $select = $this->input->post('selected');
        if (!empty($select) && is_array($select)) {
            foreach ($select as $level_id) {
                $result = $this->UserLevelModel->deleteUserLevel(array('level_id' => $level_id));
                if ($result) {
                    $this->session->success = "删除成功!";
                    $this->session->mark_as_flash("success");
                } else {
                    $this->session->error = "删除失败!";
                    $this->session->mark_as_flash("error");
                }
            }
        }
        redirect(site_url("UserLevel/index"));
    }

    //加载autocompleteload

    public function autocomplete() {
        $json = array();
        $filter_data = array();
        $level_name = $this->input->get_post('filter_level_name');
        if (!empty($level_name)) {
            $filter_data['level_name'] = $level_name;
        }

        $results = $this->UserLevelModel->autoUserLevels($filter_data);
        foreach ($results['data'] as $result) {

            $json[] = array(
                'level_id' => $result['level_id'],
                'level_name' => $result['level_name']
            );
        }

        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

}
