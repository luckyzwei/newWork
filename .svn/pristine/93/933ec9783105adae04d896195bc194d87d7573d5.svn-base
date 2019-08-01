<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 商品标签管理
 * 
 * @package	ZMshop
 * @author	wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class Tag extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //当前控制器会使用到的加载
        $this->load->helper('url');
        $this->load->model("TagModel");
        $this->load->library("pagination");
        $this->load->library('form_validation');
    }



    //显示首页列表
    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        //需要返回给view的数据
        $data = array();
        $data['error'] = $this->input->get('error');
        $data['success'] = $this->input->get('success');
        //一些参数
        $file_name = $this->input->get_post("file_name");
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 20;
        $tagdata = $this->TagModel->getTagList($page, $limit, $file_name);
        $this->load->library('pagination'); //框架分页类
        $config['base_url'] = site_url('Tag/index'); //当前分页地址
        $config['total_rows'] = $tagdata['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $config['cur_page'] = $page;
        $this->pagination->initialize($config);
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $tagdata['result'];
        $data['page'] = $page;
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('tag', $data);
    }

    public function addTag() {

        if ($this->input->method() == 'post') {
            //验证数据
            $data['tag_name'] = $this->input->post('tag_name');
            $this->form_validation->set_rules('tag_name', '分组名称', 'required|min_length[2]|max_length[24]|callback_tagNameCheck');
            if ($this->form_validation->run() == True && $this->TagModel->addTag(array('tag_name' => $this->input->post("tag_name")))) {
                 $this->session->success = "新增标签成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Tag/index"));
            } else {
                $data['parent_name'] = $this->input->post('parent_name');
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
                $data['action'] = site_url("Tag/addTag");
                $this->load->view("tag_edit", $data);
            }
        } else {
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $data['action'] = site_url("Tag/addTag");
            $this->load->view("tag_edit", $data);
        }
    }

    public function editTag($product_tag_id) {
        $data = $this->TagModel->getTagById($product_tag_id);
        $page = $this->input->get('page');
        if ($this->input->method() == 'post') {
            $product_tag_id = $this->input->post('product_tag_id');
            $insertFiled = array("tag_name");
            $data = elements($insertFiled, $this->input->post(), "");
            //验证数据
            $this->form_validation->set_rules('tag_name', '', 'required|min_length[2]|max_length[24]|callback_tagNameCheck');
            if ($this->form_validation->run() == True && $this->TagModel->editTag($data, array('product_tag_id' => $product_tag_id))) {
                $this->session->success = "编辑标签成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Tag/index"));
            } else {
                $data['page'] = $page;
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
                $data['action'] = site_url("Tag/editTag?product_tag_id=" . $product_tag_id . '&page=' . $page);
                $this->load->view("tag_edit", $data);
            }
        } else {
            $data['page'] = $page;
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $data['action'] = site_url("Tag/editTag?product_tag_id=" . $product_tag_id . '&page=' . $page);
            $this->load->view("tag_edit", $data);
        }
    }

    public function deleteTag() {
        $select = $this->input->post('selected');
        if (!empty($select) && is_array($select)) {
            $where = implode(',', $this->input->post('selected'));
            if ($this->TagModel->deleteTag('product_tag_id in (' . $where . ')')) {
                $this->session->success = "删除成功!";
               $this->session->mark_as_flash("success");
            } else {
                $this->session->success = "删除失败!";
               $this->session->mark_as_flash("success");
            }
        } else {
            $this->session->error = "请求有误!";
            $this->session->mark_as_flash("error");
        }
        redirect(site_url('Tag/index'));
    }

    /**
     * 自动查询标签名称
     */
    public function autoTag($type = '') {
        $file_tag = $this->input->get_post('file_tag');
        $Tagdata = $this->TagModel->autoTagList($file_tag, $type);
        $this->output->set_output(json_encode($Tagdata));
    }

    public function tagNameCheck($tag_name) {
        $checkData = array("tag_name" => $tag_name);
        if (strtolower($this->uri->segment(2)) == "edittag") {
            $checkData['product_tag_id!='] = $this->input->post_get('product_tag_id');
        }
        if ($this->TagModel->isExist($checkData)) {
            $this->form_validation->set_message('tagNameCheck', '标签名称不能重复');
            return false;
        }
        return true;
    }
    /**
     * 类必须实现函数用于权限控制设置
     * 
     * @return  array
     */
    public static function getModuleInfo() {
        return array(
            "moduleName" => "商品标签管理",
            "controller" => "Tag",
            "author" => "wangxiangshuai@hnzhimo.com",
            "operation" => array(
                "index" => "标签列表页",
                "addTag" => "新增标签",
                "editTag" => "编辑标签",
                "deleteTag" => "删除标签",
                "-autoTag" => "查询标签"
            )
        );
    }
}
