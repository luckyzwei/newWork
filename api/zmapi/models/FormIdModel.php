<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormIdModel
 *
 * @author wangxiangayx
 */
class FormIdModel extends CI_Model{
    public function addFormId($data) {
       return $this->db->insert('wxfun_formid', $data);
    }
    public function getFormId($user_id){
        $query = $this->db->select('*')
                ->from('wxfun_formid')
                ->where('user_id',$user_id)
                ->where(" expiration_time>'" . time() . "'  AND ((source_field='sub_pay' AND status <3) or (source_field='sub_cart' AND status =0)) ")
                ->order_by('expiration_time','ASC')
                ->limit(1)
                ->get();
        return $query->row_array();
    }
    public function editFormId($data,$where) {
        return $this->db->update('wxfun_formid', $data, $where);
    }
}
