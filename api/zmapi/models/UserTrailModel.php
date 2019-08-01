<?php

/**
 * 用户轨迹模型
 */
class UserTrailModel extends CI_Model {

    public function addUserTrail($data) {
        $data['createtime'] = time();
        return $this->db->insert('user_trail', $data);
    }

    public function getUserTrail($where,$limit=6,$page=1) {
        $query = $this->db->select("ut.createtime,p.thumb,p.product_id,p.product_name,p.store_number,p.status,p.explain,p.price")
                ->from('user_trail ut')
                ->join('product p','p.product_id=ut.product_id')
                ->where($where)
                ->order_by('createtime','DESC')
                ->limit($limit, ($page - 1) * $limit)
                ->group_by('product_id')
                ->get();
        return $query->result_array();
    }
    public function delUserTrail($user_id,$where){
        return $this->db->where($where)->where('user_id',$user_id)->delete("user_trail");
    }
}
