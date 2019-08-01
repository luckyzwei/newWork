<?php

/**
 * 供货商管理模型
 * @package    ZMshop
 * @author liuchenwei@hnzhimo.com
 * @copyright  2017 河南知默网络科技有限公司
 * @link   http://www.hnzhimo.com
 * @since  Version 1.0.0
 */
class SupplierModel extends CI_Model {

    //获取供货商列表
    public function getList($where = array(), $page = 1, $limit = 20) {
        $this->db->select('s.*,u.user_name')->from('supplier s')
                ->join('user u', 'u.user_id=s.user_id');
        if ($where) {
            $this->db->like("name", $where['filter_supplier_name']);
        }
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $query = $this->db
                ->limit($limit, ($page - 1) * $limit)
                ->order_by("supplier_id desc")
                ->get();
        return array("count" => $rownum, "result" => $query->result_array());
    }

    //添加供货商
    public function addSupplier($data) {

        return $this->db->insert('supplier', $data);
    }

    //修改供货商
    public function updateSupplier($data, $where) {

        return $this->db->update('supplier', $data, $where);
    }

    //删除供货商
    public function deleteSupplier($where) {
        return $this->db->delete("supplier", $where);
    }

    //根据指定查询数据
    public function sel($supplier_id) {
        $query = $this->db->get_where("supplier", array("supplier_id" => $supplier_id));
        $supplier = $query->row_array();
        
        $this->db->select('nickname')->from('user');
        $nick = $this->db->where('user_id', $supplier["user_id"])->get();
        return array("supplier" => $supplier, "nick" => $nick->row_array());
    }
    /**
     * 获取所有供货商
     */
    public function getSuppliers(){
        $query=$this->db->get("supplier");
        return $query->result_array();
    }
    //查询省名
    public function getProvinceName($province_id){
        return $this->db
                    ->get_where('province',array('province_id'=>$provice_id))
                    ->row_array()['name'];
    }
    //查询市名
    public function getCityName($city_id){
        return $this->db
                    ->get_where('city',array('city_id'=>$city_id))
                    ->row_array()['name'];
    }
    //查询区名
    public function getdistriceName($districe_id){
        return $this->db
                    ->get_where('district',array('district_id'=>$city_id))
                    ->row_array()['name'];
    }

}

?>