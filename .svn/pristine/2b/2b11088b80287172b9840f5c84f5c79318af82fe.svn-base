<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 商品评论数据模型
 */
class ProductCommentModel extends CI_Model {

    public function getProductComments($product_id, $page = 1, $limit = 10) {
        $query = $this->db->select('product_comment.*,user_wechat.wx_nickname,user_wechat.wx_headimg')
                ->join('user_wechat', 'user_wechat.user_id=product_comment.user_id', 'left')
                ->from("product_comment")
                ->where('product_comment.product_id', $product_id)
                ->where('product_comment.status=1')
                ->limit($limit, ($page - 1) * $limit)
                ->order_by('product_comment.createtime', 'DESC')
                ->get();
        return $query->result_array();
    }

    /*
     * 添加商品评论
     * zu   2018/7/30
     * $comInfo   数组，用于添加到数据库中的基本信息；
     */

    public function addProductComment($comInfo) {
        $res = $this->db->insert('product_comment', $comInfo);
        return $res;
    }

}
