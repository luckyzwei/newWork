<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 商品分类管理
 * 
 * @package	ZMshop
 * @author	wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class Category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('string');
        $this->load->model("CategoryModel");
        $this->load->library("pagination");
        $this->load->library('form_validation');
        $this->load->model("RoleModel");
    }

    //显示首页列表
    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        //需要返回给view的数据
        $data = array();
        $data['categorylist'] = $this->CategoryModel->getCategoryToJson();
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('category', $data);
    }

    public function addCategory() {
        $data['rolelists'] = $this->RoleModel->getRoles();
        if ($this->input->method() == 'post') {
            $insertFiled = array("parent_id", "name", "image", "sort", "isshow");
            $data = elements($insertFiled, $this->input->post());
            //验证数据
            $this->form_validation->set_rules('name', '分组名称', 'required|min_length[2]|max_length[24]');
            if ($this->form_validation->run() == True ) {
                $this->CategoryModel->addCategory($data);
                $this->session->success = "新增商品分类成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Category/index"));
            } else {
                $data['showimg'] = reduce_double_slashes($this->zmsetting->get("img_url") . $this->zmsetting->get("file_upload_dir") . $data['image']);
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }   
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $data['action'] = site_url("Category/addCategory");
            $this->load->view("category_edit", $data);
    }

    public function editCategory($category_id) {
        $data = $this->CategoryModel->getCategoryById($category_id);
        $data['rolelists'] = $this->RoleModel->getRoles();
        if (empty($category_id) || empty($data)) {
            header("location:" . site_url('Category/index?error=分类不存在或数据错误')); //重定向防止刷新重复
        }
        if ($this->input->method() == 'post') {
            $insertFiled = array("parent_id", "name", "image", "sort", "isshow");
            $datas = elements($insertFiled, $this->input->post());
            if ($datas['image'] != $data['image']) {
                $datas['image'] = $datas['image'];
            }
            //验证数据
            $this->form_validation->set_rules('name', '分组名称', 'required|min_length[2]|max_length[24]');
            if ($this->form_validation->run() == True && $this->CategoryModel->editCategory($datas, array('category_id' => $category_id))) {
                $this->session->success = "编辑商品分类成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Category/index"));
            } else {
                $data['parent_name'] = $this->input->post('parent_name');
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
            if (empty($data['parent_id'])) {
                $data['parent_name'] = '---顶级分类---';
            }
            $data['showimg'] = reduce_double_slashes($this->zmsetting->get("img_url") . $this->zmsetting->get("file_upload_dir") . $data['image']);
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $data['action'] = site_url("Category/editCategory/" . $category_id);
            $this->load->view("category_edit", $data);
    }

    public function deleteCategory() {
        $return = $this->input->post('category_id');
        $resdata['return'] = '0';
        $resdata['data'] = '请求数据错误！清除缓存刷新重试';
        if (!empty($return)) {
            $res = $this->CategoryModel->getCategoryByParentid($this->input->post('category_id'));
            if (empty($res)) {
                if ($this->CategoryModel->deleteCategory('category_id in (' . $this->input->post('category_id') . ')')) {
                    $resdata['return'] = '1';
                    $resdata['data'] = '删除成功';
                } else {
                    $resdata['data'] = 'SQL数据删除失败';
                }
            } else {
                $resdata['data'] = '该分类下面还有子分类无法删除';
            }
        }
        $this->output->set_output(json_encode($resdata));
    }

    /**
     * 自动查询分类名称
     */
    public function autoCategory() {
        $search_name = $this->input->get_post('search_name');
        $add = $this->input->get_post('add');

        $categorydata = $this->CategoryModel->autoCategoryList($search_name, $add);
        $this->output->set_output(json_encode($categorydata));
    }

    public function categoryNameCheck($name) {
        $checkData = array("name" => $name);
        if (strtolower($this->uri->segment(2)) == "editcategory") {
            $checkData['category_id!='] = $this->uri->segment(3);
        }
        if ($this->CategoryModel->isExist($checkData)) {
            $this->form_validation->set_message('categoryNameCheck', '分类名称不能重复');
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
            "moduleName" => "商品分类管理",
            "controller" => "Category",
            "author" => "wangxiangshuai@hnzhimo.com",
            "operation" => array(
                "index" => "分类列表页",
                "editCategory" => "编辑分类",
                "addCategory" => "新增分类",
                "deleteCategory" => "删除分类",
                "-autoCategory" => "查询分类"
            )
        );
    }

}
