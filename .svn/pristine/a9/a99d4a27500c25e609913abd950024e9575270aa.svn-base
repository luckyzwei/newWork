<?php

/**
 * 文章接口
 * 
 * @package	ZMshop
 * @author	liuchenwei@hnzhimo.com
 * @copyright (c) 2018, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class Article extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("ArticleModel");
    }

    //获取文章分类
    public function article_category(){
        $data = array();
        $category = $this->ArticleModel->getCategory();
        if(empty($category)){
            $error_code = 1;
        }else{
            $error_code = 0;
        }
        $data = array("error_code" => $error_code, "data" => $category);
        $this->output->set_content_type("json/application")->set_output(json_encode($data));
    }

    //获取分类下的文章
    public function get_articles() {
        $article_category = $this->input->post('article_category_id');
        $page = $this->input->post('page');
        $limit = $this->input->post('limit');
        $limit = empty($limit) ? 10 : $limit;
        $article = $this->ArticleModel->getArticles($article_category,$page,$limit);
        if (!empty($article)) {
            $error_code = 0;
        }else{
             $error_code = 1;
        }
        $data = array("error_code" => $error_code, "data" => $article);
        $this->output->set_content_type("json/application")->set_output(json_encode($data));
    }
    
    public function get_article_info(){
        $article_id = $this->input->get_post('article_id');
        $json['data'] = $this->ArticleModel->get_product_info($article_id);
        $json['error_code'] = 0;
        $this->output->set_content_type("json/application")->set_output(json_encode($json));
    }

}
