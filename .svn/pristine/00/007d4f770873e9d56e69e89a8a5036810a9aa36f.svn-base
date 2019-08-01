<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 商品评论管理
 * @package	ZMshop
 * @author	liuchenwei@hnzhimo.com
 * @copyright	2017 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 * */
class Comment extends CI_Controller {

    //设置控制权限
    static function getModuleInfo() {
        return array(
            "moduleName" => "商品评论管理",
            "controller" => "Comment",
            "author" => "liuchenwei@hnzhimo.com",
            "operation" => array(
                "index" => "商品评论列表",
                "editComment" => "编辑评价",
                "deleteComment" => "删除评价",
            )
        );
    }

    public function __construct() {
        parent::__construct();
        $this->load->model("CommentModel");
        $this->load->model("RoleModel");
    }

    //加载商品评论列表页
    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $this->load->helper('url');
        $this->load->library("pagination");
        $data = array();
        $where = array();
        $where['product_content'] = $this->input->post('product_content');
        $where['user_id'] = $this->input->post('user_id');
        $data['filter_agent'] = $where['product_content'];
        $data['user_id'] = $where['user_id'];
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 10;
        $categorydata = $this->CommentModel->getList($where, $page, $limit);
        $config['base_url'] = site_url('Comment/index'); //当前分页地址
        $config['total_rows'] = $categorydata['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $this->pagination->initialize($config);
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $categorydata['result'];
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('comment', $data);
    }

    //商品评价修改
    public function editComment($comment_id) {
        $data['rolelists'] = $this->RoleModel->getRoles();
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        if ($this->input->method() == "post") {
            $this->form_validation->set_rules("product_content", "评价内容不能大于120个汉字并且", "max_length[120]|required");
            if ($this->form_validation->run() == True) {
                $data = array(
                    "product_content" => $this->input->post("product_content"),
                    "product_score" => $this->input->post("product_score"),
                    "status" => $this->input->post("status"),
                );
                $this->CommentModel->update($data, array("comment_id" => $this->input->post("comment_id")));
                $this->session->success = "商品评价修改成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Comment/index"));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $data['comment'] = $this->input->post();
                $this->load->view('comment_edit', $data);
            }
        } else {
            $data['comment'] = $this->CommentModel->sel($comment_id);
            $this->load->view('comment_edit', $data);
        }
    }

    //商品评价删除
    public function deleteComment() {
        $selected = $this->input->post('selected');
        if (!empty($selected) && is_array($this->input->post('selected'))) {
            $where = implode(',', $this->input->post('selected'));
            if ($this->CommentModel->delete('comment_id in (' . $where . ')')) {
                $this->session->success = "删除成功!";
               $this->session->mark_as_flash("success");
            } else {
                $this->session->error = "删除失败!";
                $this->session->mark_as_flash("error");
            }
        }else{
            $this->session->error = "请求有误!";
            $this->session->mark_as_flash("error");
        }
        redirect(site_url('Comment/index'));
    }

}
