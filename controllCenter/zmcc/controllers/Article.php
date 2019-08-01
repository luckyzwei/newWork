<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 文章管理
 * 文章分类管理
 * @package ZMshop
 * @author  知默科技-liujiaqi@hnzhimo.com
 * @copyright   2017 河南知默科技有限公司
 * @link    http://www.hnzhimo.com
 * @since   Version 1.0.0
 */

class Article extends CI_Controller
{

    /**
     * 类必须实现函数用于权限控制设置
     *
     * @return  array
     */
    public static function getModuleInfo()
    {
        return array(
            "moduleName" => "文章管理",
            "controller" => "article",
            "author" => "知默科技-liujiaqi@hnzhimo.com",
            "operation" => array(
                "index" => "文章列表",
                "addArticle" => "文章添加",
                "deleteArticle" => "文章删除",
                "editArticle" => "文章修改",
            ),
        );
    }

    //2018.7.9日修改
    public function __construct()
    {
        parent::__construct();
        $this->load->model("ArticleModel");
        $this->load->model("RoleModel");
    }

    //显示列表页
    public function index()
    {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->library('form_validation');
        $data = array();
        $selectdate['name'] = trim($this->input->get_post("name"));
        $selectdate['article_author'] = trim($this->input->get_post("article_author"));
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 10;
        $articledata = $this->ArticleModel->getArticleList($page, $limit, $selectdate);
        $config['base_url'] = site_url('Article/index'); //当前分页地址
        $config['total_rows'] = $articledata['count'];
        $config['per_page'] = $limit; //每页显示的条数
        $this->pagination->initialize($config);
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $articledata['result'];
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('article', $data);
    }

    //添加
    public function addArticle()
    {
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $data['rolelists'] = $this->RoleModel->getRoles();
        $this->load->helper(array("form", "url"));
        $this->load->library('form_validation');
        if ($this->input->method() == "post") {
            $data = $this->valiRules();
            if ($data['rules_run'] == true) {
                unset($data['rules_run']);
                $res = $this->ArticleModel->addArticle($data);
                if (!empty($res)) {
                    $this->session->success = "添加文章成功";
                    $this->session->mark_as_flash("success");
                    redirect(site_url("Article/index"));
                }
            } else {
                $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $this->load->view('article_add', $data);
            }
        } else {
            $this->load->view("article_add", $data);
        }

    }

    //修改
    public function editArticle($article_id = "")
    {
        $this->load->helper(array("form", "url"));
        $this->load->library("form_validation");
        $data['rolelists'] = $this->RoleModel->getRoles();
        if ($this->input->method() == "post") {
            $article_id = $this->input->post("article_id");
            $data = $this->valiRules();
            if ($data['rules_run'] == true) {
                unset($data['rules_run']);
                $this->ArticleModel->editArticle($data, array("article_id" => $article_id));
                $this->session->success = "编辑文章成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Article/index"));
            } else {
                $data['article'] = $this->input->post();
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $this->load->view("article_edit", $data);
            }
        } else {
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $data['article'] = $this->ArticleModel->get_art_info(array("a.article_id" => $article_id));
            $this->load->view("article_edit", $data);
        }
    }

    //验证填写色数据
    public function valiRules()
    {
        $filerdata = array("images", "article_name", "article_category_id", "content", "author");
        $data = elements($filerdata, $this->input->post(), "0");
        //验证数据
        $valiRules = array(
            array(
                'field' => 'article_name',
                'label' => '名称',
                'rules' => 'required',
                'errors' => '不能为空',
            ),
            array(
                'field' => 'article_category_id',
                'label' => '分类名称',
                'rules' => 'required',
                'errors' => '不能为空',
            ),
            array(
                'field' => 'content',
                'label' => '内容',
                'rules' => 'required',
                'errors' => '不能重复',
            ),
            array(
                'field' => 'author',
                'label' => '文章作者',
                'rules' => 'required',
                'errors' => '不能为空',
            ),
        );
        //验证数据
        $this->form_validation->set_rules($valiRules);
        $data['rules_run'] = $this->form_validation->run();
        return $data;
    }

    //删除
    public function deleteArticle()
    {
        $article_id = $this->input->post("article_id");
        $where = implode(',', $this->input->post('selected'));
        $query = $this->ArticleModel->deleteArticle('article_id in (' . $where . ')');
        if ($query) {
            $this->session->success = "删除成功!";
            $this->session->mark_as_flash("success");
        } else {
            $this->session->error = "删除失败!";
            $this->session->mark_as_flash("error");
        }

        redirect(site_url('Article/index'));
    }
}
