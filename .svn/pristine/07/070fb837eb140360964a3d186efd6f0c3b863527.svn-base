<?php

/**
 * 博客接口
 * 
 * @package	ZMshop
 * @author	liuchenwei@hnzhimo.com
 * @copyright (c) 2018, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class Blog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("BolgModel");
    }

    //获取博客分类
    public function get_blog_category(){
        $data = array();
        $blog_category = $this->BolgModel->blog_category();
        if(empty($blog_category)){
            $error_code = 1;
        }else{
            $error_code = 0;
        }  
        $data = array("error_code" => $error_code, "data" => $blog_category);
        $this->output->set_content_type("application/json")->set_output(json_encode($data));
    } 

    //获取博客分下博客
    public function get_blog(){
        $blog_category_id = $this->input->post('blog_category_id');
        $user_id = $this->session->user_id;
        $page = $this->input->post('page');
        $limit = $this->input->post('limit');
        $page = empty($page) ? 1 : $page;
        $limit = empty($limit) ? 10 : $limit;
        $blog = $this->BolgModel->blog($blog_category_id,$user_id,$page,$limit);
        if(empty($blog)){
            $error_code = 1;
        }else{
            $error_code = 0;
        }
        $data = array("error_code" => $error_code, "data" => $blog);
        $this->output->set_content_type("application/json")->set_output(json_encode($data));

    }

    //获取博客内容详情
    public function blog_info(){
        $blog_id = $this->input->get_post('blog_id');
        $blog = $this->BolgModel->blog_info($blog_id);
        if(empty($blog)){
            $error_code = 1;
        }else{
            $error_code = 0;
        }
        $data = array("error_code" => $error_code, "data" => $blog);
        $this->output->set_content_type("application/json")->set_output(json_encode($data));
    }

}
