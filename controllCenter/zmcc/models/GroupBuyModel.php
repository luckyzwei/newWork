<?php

class GroupBuyModel extends CI_Model {

    public function getGroupBuyList($page = 0, $limit = 20, $selectdata = '') {
        $this->db->select('ug.* ,count(ug.user_id) as num')->from('user_groupbuy ug')->group_by('ug.groupbuy_sn');
        if (!empty($selectdata['user_id'])) {
            $this->db->where('ug.user_id',$selectdata['user_id']);
        }
        if (!empty($selectdata['groupbuy_sn'])) {
            $this->db->where('ug.groupbuy_sn',$selectdata['groupbuy_sn']);
        }
        if (!empty($selectdata['group_product_id'])) {
            $this->db->where('ug.group_product_id',$selectdata['group_product_id']);
        }
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $query = $this->db
                ->select('gp.group_product_name,gp.group_user_num,u.nickname,gp.auto_group')
                ->join('user u', 'u.user_id=ug.user_id', 'left')
                ->join('group_product gp', 'gp.group_product_id=ug.group_product_id', 'left')
                ->order_by('ug.createtime', 'DESC')
                ->limit($limit, ($page - 1) * $limit)
                ->get();
                return array("count" => $rownum, "result" => $query->result_array());
    }

    public function getGroupBuyinfo($groupbuy_sn) {
        $query = $this->db->select('ug.*,o.order_id,o.order_sn,o.order_amount,o.status,gp.group_product_name,u.nickname')
                ->from('user_groupbuy ug')
                ->join('user u', 'u.user_id=ug.user_id', 'left')
                ->join('group_product gp', 'gp.group_product_id=ug.group_product_id', 'left')
                ->join('order o', 'ug.order_id=o.order_id','left')
                ->where('ug.groupbuy_sn='."'".$groupbuy_sn."'")
                ->order_by('ug.createtime', 'DESC')
                ->get();
        return $query->result_array();
    }
    public function delectGroupOrder($where) {
        return FALSE;
    }
    
    
    public function editGroupBuyStatus($where,$data) {
        return $this->db->where($where)->update('user_groupbuy',$data);
    }

}