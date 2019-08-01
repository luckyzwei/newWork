<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 文章管理
 * 文章分类管理 
 * @package	ZMshop
 * @author	知默科技-liujiaqi@hnzhimo.com
 * @copyright	2017 河南知默科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
Class Blog extends CI_Controller {

    /**
     * 类必须实现函数用于权限控制设置
     * 
     * @return  array
     */
    public static function getModuleInfo() {
        return array(
            "moduleName" => "博客管理",
            "controller" => "BlogController",
            "author" => "知默科技-liujiaqi@hnzhimo.com",
            //"hidden"=>true,
            "operation" => array(
                "index" => "博客列表",
                "addblog" => "博客添加",
                "deleteblog" => "博客删除",
                "editblog" => "博客修改",
            )
        );
    }

    //2018.7.9修改
    public function __construct() {
        parent::__construct();
        $this->load->model("BlogModel");
        $this->load->model("RoleModel");
    }

    //显示列表页
    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->library('form_validation');
        $data = array();
        $selectdate['name'] = $this->input->get_post("name");
        $selectdate['status'] = $this->input->get_post("status");
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 10;
        $blogdata = $this->BlogModel->getBlogList($page, $limit, $selectdate);
        $config['base_url'] = site_url('Blog/index'); //当前分页地址
        $config['total_rows'] = $blogdata['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $this->pagination->initialize($config);
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $blogdata['result'];
        $list = $data['list'];
        $this->load->view("blog", $data);
    }

    //执行添加
    public function addBlog() {
        $data['rolelists'] = $this->RoleModel->getRoles();
        $this->load->library('form_validation');
        if ($this->input->method() == "post") {
            $data = $this->valiRules();
            if ($data['rules_run'] == True) {
                unset($data['rules_run']);
                $this->BlogModel->addBlog($data);
                $this->session->success = "新增博客成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Blog/index"));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view("blog_add", $data);
    }

    //删除博客
    public function deleteBlog() {
        $where = implode(',', $this->input->post('selected'));
        $query = $this->BlogModel->deleteBlog('blog_id in (' . $where . ')');
        if ($query) {
            $this->session->success = "删除成功!";
            $this->session->mark_as_flash("success");
        } else {
            $this->session->error = "删除失败!";
            $this->session->mark_as_flash("error");
        }
        redirect(site_url('Blog/index'));
    }

    //编辑
    public function editBlog($blog_id = "") {
        $this->load->helper(array("form", "url"));
        $this->load->library("form_validation");
        if (empty($blog_id))
            $blog_id = $this->input->post("blog_id");
        $date = $this->BlogModel->get_art_info($blog_id);
        if ($this->input->method() == "post") {

            $data = $this->valiRules();
            if ($data['rules_run'] == True) {
                unset($data['rules_run']);

                $enable_products = $this->input->post('enable_product');
                //处理关联商品
                if (empty($enable_products)) {
                    //删除所有的
                    $this->BlogModel->deleteBlog_relate($blog_id);
                } else {
                    $product_ids = array_column($date['shop'], 'product_id');
                    $delete = array_diff($product_ids, $enable_products);
                    if (!empty($delete))
                        $this->BlogModel->deleteBlog_relate($blog_id, $delete);
                    $add = array_diff($enable_products, $product_ids);
                    if (!empty($add)) {
                        $adddate = array();
                        foreach ($add as $value) {
                            $adddate[] = array(
                                'blog_id' => $blog_id,
                                'product_id' => $value
                            );
                        }
                        $this->BlogModel->addBlog_relate($adddate);
                    }
                }
                $this->BlogModel->editBlog($data, array("blog_id" => $blog_id));
                $this->session->success = "编辑博客成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Blog/index"));
            } else {
                $data['blog'] = $this->input->post();
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $data['blog'] = $date;
        $this->load->view("blog_edit", $data);
    }

    //验证填写色数据
    public function valiRules() {
        $filerdata = array("blog_name", "blog_category_id", "content", "status", "hits", "keywords", "image", "sort_order");
        $data = elements($filerdata, $this->input->post(), "0");
        //验证数据
        $valiRules = array(
            array(
                'field' => 'blog_name',
                'label' => '博客名称',
                'rules' => 'required',
                'errors' => '不能为空'
            ),
            array(
                'field' => 'blog_category_id',
                'label' => '博客分类',
                'rules' => 'required',
                'errors' => '不能为空'
            ),
            array(
                'field' => 'content',
                'label' => '内容',
                'rules' => 'required',
                'errors' => '不能为空'
            ),
            array(
                'field' => 'status',
                'label' => '博客状态',
                'rules' => 'required',
                'errors' => '不能为空'
            ),
            array(
                'field' => 'keywords',
                'label' => '关键字',
                'rules' => 'required',
                'errors' => '不能为空'
            ),
        );
        //验证数据
        $this->form_validation->set_rules($valiRules);
        $data['rules_run'] = $this->form_validation->run();
        return $data;
    }

}
?>

