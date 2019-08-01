<?php

/**
 * 文章管理
 * 文章分类管理 
 * @package	ZMshop
 * @author	知默科技-liujiaqi@hnzhimo.com
 * @copyright	2017 河南知默科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
/*
 * 文章分类管理
 *  */

class ArticleCategory extends CI_Controller {
    

    /**
     * 类必须实现函数用于权限控制设置
     * 
     * @return  array
     */
    public static function getModuleInfo() {
        return array(
            "moduleName" => "文章分类管理",
            "controller" => "ArticleCategory",
            "author" => "知默科技-liujiaqi@hnzhimo.com",
            "operation" => array(
                "index" => "文章分类列表",
                "addArticleCategory" => "文章分类添加",
                "deleteArticleCategory" => "文章分类删除",
                "editArticleCategory" => "文章分类修改"
            )
        );
    }

    //2018.7.9修改
     public function __construct() {
        parent::__construct();
        $this->load->model("ArticleCategoryModel");
        $this->load->model("RoleModel");
    }

    //显示列表页
    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $data = array();
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->library('form_validation');
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 5;
        $articledata = $this->ArticleCategoryModel->getCategoryList($page, $limit);
        $config['base_url'] = site_url('ArticleCategory/index'); //当前分页地址
        $config['total_rows'] = $articledata['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $this->pagination->initialize($config);
        $data['categorylist'] = $this->ArticleCategoryModel->getCategoryToJson();
        $data['title'] = '文章分类管理';
        $this->load->view("articlecategory", $data);
    }

    //分类添加
    public function addArticleCategory() {
        $data['articlecategory'] = $this->ArticleCategoryModel->categoryList();
        $this->load->view("articlecategory_add",$data);
    }

    //执行添加
    public function doaddArticleCategory() {
        $data['rolelists'] = $this->RoleModel->getRoles();
        $this->load->helper(array("form", "url"));
        $this->load->library('form_validation');
        $data['result'] = "fail";
        if ($this->input->method() == "post") {
            $data = array("parent_id", "category_name", "sort_order");
            $dd = elements($data, $this->input->post(), "0");
            $val = array(
                array(
                    'field' => 'category_name',
                    'label' => '设置项名称',
                    'rules' => 'trim|required|is_unique[zm_article.article_name]',
                    'errors' => '请正确填写设置项名称：名称不能重复'
                ),
                array(
                    'field' => 'sort_order',
                    'label' => '设置项排序',
                    'rules' => 'required',
                    'errors' => '请正确填写设置项排序：排序不能重复'
                )
            );
            $this->form_validation->set_rules($val);
            if ($this->form_validation->run() == True && $this->ArticleCategoryModel->addArticleCategory($dd)) {
                $this->session->success = "添加分类成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("ArticleCategory/index"));
            }else{
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $this->load->view("articlecategory_add", $data);
        
        
    }

    //删除分类
    public function deleteArticleCategory() {
        $id = $this->input->post("article_category_id");
        $data['return']=0;
        if (!empty($id)) {
            $res = $this->ArticleCategoryModel->get_art_info(array("parent_id" => $id));
            if (!empty($res)) {
                $data['data']= "该分类下面有子类，不能删除";
            } else {
                if ($this->ArticleCategoryModel->deleteArticleCategory(array("article_category_id" => $id))) {
                    $data['return']=1;
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
    public function editArticleCategory($article_category_id) {
        $data['rolelists'] = $this->RoleModel->getRoles();
        $this->load->helper(array("form", "url"));
        $this->load->library("form_validation");
        $data['articlecategory'] = $this->ArticleCategoryModel->categoryList();
        $data['articlecategory_info'] = $this->ArticleCategoryModel->get_art_info(array("article_category_id" => $article_category_id));
        if ($this->input->method() == "post") {
            $val = array(
                array(
                    'field' => 'category_name',
                    'label' => '设置项分类名称',
                    'rules' => 'required',
                    'errors' => '请正确填写设置项分类名称：分类名称不能重复'
                ),
                array(
                    'field' => 'sort_order',
                    'label' => '设置项排序',
                    'rules' => 'required',
                    'errors' => '请正确填写设置项排序：排序不能重复'
                )
                
            );
            $this->form_validation->set_rules($val);
            if ($this->form_validation->run() == True) {
                $updatedata = array(
                    "category_name" => $this->input->post("category_name"),
                    "sort_order" => $this->input->post("sort_order"),
                );
                $this->ArticleCategoryModel->editArticleCategory($updatedata, array("article_category_id" => $article_category_id));
                $this->session->success = "修改分类成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("ArticleCategory/index")); 
            } else {
                $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
                $data['articlecategory_info']['category_name'] = $this->input->post('category_name');
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        } 
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $this->load->view("articlecategory_edit", $data);
    }
    
    /**
     * 自动查询分类名称
     */
    public function autoCategory($add = 0) {
        $this->load->model('ArticleCategoryModel');
        $parent_id = $this->input->get_post('parent_id');
        if (!empty($parent_id)) {
            $parent_id = $this->input->get_post('parent_id');
        } else {
            $parent_id = '';
        }
        $blogcategorydata = $this->ArticleCategoryModel->autoCategoryList($parent_id, $add);

        $this->output->set_output(json_encode($blogcategorydata));
    }

    public function categoryNameCheck($name) {
        $checkData = array("name" => $name);
        if (strtolower($this->uri->segment(2)) == "editcategory") {
            $checkData['article_category_id!='] = $this->uri->segment(3);
        }
        if ($this->CategoryModel->isExist($checkData)) {
            $this->form_validation->set_message('categoryNameCheck', '分类名称不能重复');
            return false;
        }
        return true;
    }

}
?>

