<?php

/**
 * 用户管理模型
 * @package    ZMshop
 * @author liuchenwei@hnzhimo.com
 * @copyright  2017 河南知默网络科技有限公司
 * @link   http://www.hnzhimo.com
 * @since  Version 1.0.0
 * */
class ProductRankingsModel extends CI_Model {

    //加载商品排行列表
    public function getList($where = array(), $page = 1, $limit = 20) {

        $this->db->select('product_name,product_special_name,sum(product_price) as product_price,sum(product_number) as product_number')
                ->from('order_product');
        if ($where) {
            $this->db->like("product_name", $where['product_name']);
        }
        $query = $this->db
                ->group_by('product_id')
                ->order_by("product_number desc")
                ->limit($limit, ($page - 1) * $limit)
                ->get();
        $result = $query->result_array();
        return array("count" => count($result), "result" => $result);
    }

}
