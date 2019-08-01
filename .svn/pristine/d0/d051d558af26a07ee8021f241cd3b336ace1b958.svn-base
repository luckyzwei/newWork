<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 商品评论信息
 *
 * @author wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @since    Version 1.0.0
 */
class ProductComment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper("string");
        $this->load->model('ProductCommentModel');
    }

    /**
     * 添加商品评论
     */
    public function add_product_comment() {
        $user_id = $this->session->user_info['user_id'];
        $order_id = $this->input->post('order_id');
        $product_ids = $this->input->post('product_id');
        $product_scores = $this->input->post('product_score');
        $detailReviewss = $this->input->post('detailReviews');
        foreach ($product_ids as $key => $value) {
            $data = array(
                'order_id' => $order_id,
                'product_id' => $value,
                'user_id' => $user_id,
                'product_content' => $detailReviewss[$key],
                'product_score' => $product_scores[$key],
                'createtime' => time(),
                'status' => 1
            );
            $this->ProductCommentModel->addProductComment($data);
        }
        $this->load->model('orderModel');
        $this->orderModel->upOrderinfo(array('order_id' => $order_id), array('status'=>6));
        $this->output->set_content_type("application/json")->set_output(json_encode(array("error_code" => 0)));
    }

    /*
     * 获取商品评论
     */

    public function get_product_comments() {
        $product_id = $this->input->post('product_id');
        $pagenum = $this->input->post("page") ? $this->input->post("page") : 1;
        $comment = $this->ProductCommentModel->getProductComments($product_id, $pagenum);
        foreach ($comment as $key => $value) {
            $comment[$key]['createtime'] = date('Y-m-d', $value['createtime']);
        }
        $json = array("error_code" => 0, "data" => $comment);
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

}
