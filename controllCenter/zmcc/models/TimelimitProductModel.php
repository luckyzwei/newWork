<?php

/**
 * 限时秒杀模型
 * @package    ZMshop
 * @author liuchenwei@hnzhimo.com
 * @copyright  2017 河南知默网络科技有限公司
 * @link   http://www.hnzhimo.com
 * @since  Version 1.0.0
 */
class TimelimitProductModel extends CI_Model {

    //限时秒杀列表
    public function getTimelimitProductList($where = array(), $page = 1, $limit = 20) {
        $this->db->select('*')->from('timelimit_product');
        if ($where) {
            $this->db->or_like(array('timelimit_product_name' => $where['filter_agent']));
        }
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $query = $this->db
                ->order_by("sort_order desc")
                ->limit($limit, ($page - 1) * $limit)
                ->get();
        return array("count" => $rownum, "result" => $query->result_array());
    }

    //添加限时秒杀
    public function addTimelimetProduct($data) {
        return $this->db->insert("timelimit_product", $data);
    }

    //修改限时秒杀
    public function editTimelimetProduct($data, $where) {
        return $this->db->where($where)->update("timelimit_product", $data);
    }

    //删除限时秒杀
    public function deleteTimelimetProduct($where) {
        return $this->db->delete("timelimit_product", $where);
    }

    //根据指定查询数据
    public function sel($timelimit_product_id) {
        $query = $this->db->get_where("timelimit_product", array("timelimit_product_id" => $timelimit_product_id));
        return $query->row_array();
    }

}
