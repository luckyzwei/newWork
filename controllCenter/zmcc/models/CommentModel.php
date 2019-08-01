<?php

/**
 * 商品评论模型
 * @package    ZMshop
 * @author liuchenwei@hnzhimo.com
 * @copyright  2017 河南知默网络科技有限公司
 * @link   http://www.hnzhimo.com
 * @since  Version 1.0.0
 */
class CommentModel extends CI_Model {

    //获取商品评价列表
    public function getList($where = array(), $page = 1, $limit = 20) {

        $this->db->select('*')->from('product_comment');
        if ($where) {
            $this->db->or_like(array('product_content' => $where['product_content']));
        }
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $query = $this->db->select("product_comment.*,product.product_name,user.user_name,user.nickname,user_wechat.wx_headimg")
                ->join("product", "product_comment.product_id=product.product_id", "left")
                ->join("user", "product_comment.user_id=user.user_id", "left")
                ->join('user_wechat', 'user_wechat.user_id=user.user_id', 'left')
                ->limit($limit, ($page - 1) * $limit)
                ->order_by("comment_id desc")
                ->get();
        return array("count" => $rownum, "result" => $query->result_array());
    }

    //修改商品评价
    public function update($data, $where) {
        return $this->db->update('product_comment',$data, $where );
    }

    //根据指定查询数据
    public function sel($comment_id) {
        $query = $this->db->get_where("product_comment", array("comment_id" => $comment_id));
        return $query->row_array();
    }

    //删除商品评价
    public function delete($where) {
        return $this->db->delete('product_comment', $where);
    }

}
