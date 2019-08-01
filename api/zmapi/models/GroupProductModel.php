<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GroupProductModel
 *
 * @author wangxiangshuai
 */
class GroupProductModel extends CI_Model {

    //put your code here
    public function getGroupProducts($page = 1, $limit = 10, $where = '') {
        $this->db->select('gp.*,p.description,p.thumb,p.product_name,p.market_price')
                ->from('group_product gp')
                ->join('product p', 'p.product_id=gp.product_id', 'left');
        if (!empty($where)) {
            $this->db->where($where);
        }
        //这里筛选掉已结束的
        $this->db->where('(gp.endtime > ' . time() . ' or gp.endtime = 0)');
        $query = $this->db->order_by('starttime', 'asc')
                ->limit($limit, ($page - 1) * $limit)
                ->get();
        return $query->result_array();
    }

    public function getGroupProduct($group_product_id) {
        $query = $this->db->select('gp.*,p.description,p.thumb,p.product_name,p.price,p.weight as product_weight,p.market_price,p.images')
                ->from('group_product gp')
                ->where('(gp.endtime < ' . time() . ' or gp.endtime = 0)')
                ->join('product p', 'p.product_id=gp.product_id', 'left')
                ->where('gp.group_product_id = ' . $group_product_id)
                ->get();
        return $query->row_array();
    }

}
