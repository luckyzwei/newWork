<?php

/**
 * 商品团购模型
 * @package    ZMshop
 * @author liuchenwei@hnzhimo.com
 * @copyright  2017 河南知默网络科技有限公司
 * @link   http://www.hnzhimo.com
 * @since  Version 1.0.0
 */
class GroupProductModel extends CI_Model {

    //商品团购列表页
    public function getList($where = array(), $page = 1, $limit = 20) {

        $this->db->select('*')
                ->from('group_product');
        if ($where) {
            $this->db->or_like(array('group_product_name' => $where['filter_agent']));
        }
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $query = $this->db
                ->limit($limit, ($page - 1) * $limit)
                ->order_by(" updatetime DESC ")
                ->get();
        return array("count" => $rownum, "result" => $query->result_array());
    }

    //添加商品团购
    public function addGroupProduct($data) {
        return $this->db->insert('group_product', $data);
    }

    //编辑商品团购
    public function editGroupProduct($data, $where) {
        return $this->db->update('group_product', $data, $where);
    }

    //删除商品团购
    public function deleteGroupProduct($where) {
        return $this->db->delete("group_product", $where);
    }

    //根据自定义查询数据
    public function sel($where) {
        $query = $this->db->get_where("group_product", array("group_product_id" => $where));
        $hha = $query->row_array();
        $spn = $this->db->get_where("product", array("product_id" => $hha['product_id']));
        return array("count" => $hha, "result" => $spn->row_array());
    }

    //自动加载团购名称
    public function getGroup($group_product_id) {
        $data = array();
        $this->db->select('*')
                ->from('group_product');
        if (!empty($parent_id))
            $this->db->or_like(array('group_product_id' => $group_product_id, 'group_product_name' => $group_product_id));
        $query = $this->db->limit(10)
                ->order_by('group_product_id', 'DESC')
                ->get();
        foreach ($query->result_array() AS $arr) {
            $data[] = $arr;
        }
        return $data;
    }

}
