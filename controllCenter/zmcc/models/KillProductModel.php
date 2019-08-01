<?php

/**
 * 助力砍价模型
 * @package    ZMshop
 * @author liuchenwei@hnzhimo.com
 * @copyright  2017 河南知默网络科技有限公司
 * @link   http://www.hnzhimo.com
 * @since  Version 1.0.0
 */
class KillProductModel extends CI_Model {

    public function getKileProductList($where, $page = 0, $limit = 20) {
        $orderinfo = $this->db->select('k.*,p.product_name')
                ->from('kill_product k')
                ->join('product p', 'p.product_id=k.product_id', 'left')//商品名称
                ->where('k.kill_product_endtime>' . time())
                ->limit($limit, ($page - 1) * $limit)
                ->order_by('k.kill_product_endtime', 'DESC')
                ->get();
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        return array("count" => $rownum, "result" => $orderinfo->result_array());
    }

    public function addKillProduct($data) {
        return $this->db->insert('kill_product', $data);
    }

    public function getKillProductInfo($kill_product_id) {
        $orderinfo = $this->db->select('k.*,p.product_name')
                ->from('kill_product k')
                ->join('product p', 'p.product_id=k.product_id', 'left')//商品名称
                ->where('k.kill_product_id=' . $kill_product_id)
                ->get();
        return $orderinfo->row_array();
    }

    public function editKillProduct($kill_product_id, $data) {
        return $this->db->where(array('kill_product_id' => $kill_product_id))->update("kill_product", $data);
    }

    public function getEndTimeProduct($product_id, $starttime, $kill_product_id = "0") {
        $this->db->select('kill_product_id')
                ->from('kill_product')
                ->where('kill_product_endtime>' . $starttime)
                ->where('product_id', $product_id);
        if($kill_product_id) {
            $this->db->where('kill_product_id<>' . $kill_product_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function deleteKillProduct($where) {
        return $this->db->delete("kill_product", $where);
    }

}
