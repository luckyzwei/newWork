<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 文章管理
 * 文章分类管理
 * @package    ZMshop
 * @author    知默科技-liujiaqi@hnzhimo.com
 * @copyright    2017 河南知默科技有限公司
 * @link    http://www.hnzhimo.com
 * @since    Version 1.0.0
 */
/*
 * 文章管理
 *  */

class BlogCategory extends CI_Controller
{

    /**
     * 类必须实现函数用于权限控制设置
     *
     * @return  array
     */
    public static function getModuleInfo()
    {
        return array(
            "moduleName" => "博客管理分类管理",
            "controller" => "BlogController",
            "author" => "知默科技-liujiaqi@hnzhimo.com",
            //"hidden"=>true,
            "operation" => array(
                "index" => "博客分类列表",
                "addBlogCategory" => "博客分类添加",
                "deleteBlogCategory" => "博客分类删除",
                "editBlogCategory" => "博客分类修改",
            ),
        );
    }

    //2018.7.9修改
    public function __construct()
    {
        parent::__construct();
        $this->load->model("BlogCategoryModel");
        $this->load->model("RoleModel");
    }

    //显示页面
    public function index()
    {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $data = array();
        $this->load->helper('url');
        $this->load->library("pagination");
        $data['categorylist'] = $this->BlogCategoryModel->getCategoryToJson();
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view("blogcategory", $data);
    }


    //博客分类添加
    public function addBlogCategory()
    {
        $this->load->helper(array("form", "url"));
        $this->load->library('form_validation');
        if ($this->input->method() == "post") {
            $data = array("parent_id", "category_name", "published", "store_id", "image", "keywords", "sort_order", "status");
            $dd = elements($data, $this->input->post(), "0");
            $val = array(
                array(
                    'field' => 'category_name',
                    'label' => '设置项名称',
                    'rules' => 'trim|required|is_unique[zm_article.article_name]',
                    'errors' => '请正确填写设置项名称：名称必填且不能重复',
                ),
            );
            $this->form_validation->set_rules($val);
            if ($this->form_validation->run() == true && $this->BlogCategoryModel->addBlogCategory($dd)) {
                $this->session->success = "添加分类成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("BlogCategory/index"));
            } else {
                $data['category_name'] = $this->input->post('category_name');
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
                $data['action'] = site_url("BlogCategory/addBlogCategory");
            }
        } else {
            $data['rolelists'] = $this->RoleModel->getRoles();
            $data['blogcategory'] = $this->BlogCategoryModel->categoryList();
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $this->load->view("blogcategory_add", $data);
        }
    }

    //删除分类
    public function deleteBlogCategory()
    {
        $id = $this->input->post("blog_category_id");
        $data['return'] = 0;
        if (!empty($id)) {
            $res = $this->BlogCategoryModel->get_art_info(array("parent_id" => $id));
            if (!empty($res)) {
                $data['data'] = "该分类下面有子类，不能删除";
            } else {
                if ($this->BlogCategoryModel->deleteBlogCategory(array("blog_category_id" => $id))) {
                    $data['return'] = 1;
                    $data['data'] = "删除成功";
                } else {
                    $data['data'] = "数据库删除失败";
                }
            }
        } else {
            $data['data'] = "请求数据有误";
        }
        $this->output->set_output(json_encode($data));
    }

    //编辑分类
    public function editBlogCategory($blog_category_id = "")
    {
        $this->load->helper(array("form", "url"));
        $this->load->library("form_validation");
        $data['blogcategory'] = $this->BlogCategoryModel->categoryList();
        $data['blogcategory_info'] = $this->BlogCategoryModel->getBlogCategoryInfo($blog_category_id);
        if ($this->input->method() == "post") {
            $this->form_validation->set_rules('category_name', '分类名称', 'trim|required');
            $this->form_validation->set_rules('published', '是否公开', 'trim|required');
            $this->form_validation->set_rules('store_id', '店铺ID', 'trim|required');
            if ($this->form_validation->run() == true) {
                $data['category_name'] = $this->input->post('category_name');
                $data['published'] = $this->input->post('published');
                $data['store_id'] = $this->input->post('store_id');
                $data['keywords'] = $this->input->post('keywords');
                $data['sort_order'] = $this->input->post('sort_order');
                $data['status'] = $this->input->post('status');
                $this->BlogCategoryModel->editBlogCategory($data, array('blog_category_id' => $blog_category_id));
                $this->session->success = "修改分类成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("BlogCategory/index"));
            } else {
                $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
                $data['blogcategory']['category_name'] = $this->input->post('category_name');
                $data['blogcategory']['published'] = $this->input->post('published');
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }

        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view("blogcategory_edit", $data);

    }

    /**
     * 自动查询分类名称
     */
    public function autoCategory($add = 0)
    {
        $parent_id = $this->input->get_post('parent_id');
        if (!empty($parent_id)) {
            $parent_id = $this->input->get_post('parent_id');
        } else {
            $parent_id = '';
        }
        $blogcategorydata = $this->BlogCategoryModel->autoCategoryList($parent_id, $add);
        unset($blogcategorydata[0]);
        $this->output->set_output(json_encode($blogcategorydata));
    }

    public function categoryNameCheck($name)
    {
        $checkData = array("name" => $name);
        if (strtolower($this->uri->segment(2)) == "editcategory") {
            $checkData['blog_category_id!='] = $this->uri->segment(3);
        }
        if ($this->CategoryModel->isExist($checkData)) {
            $this->form_validation->set_message('categoryNameCheck', '分类名称不能重复');
            return false;
        }
        return true;
    }
}
