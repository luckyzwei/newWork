<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GroupOrderModel
 *
 * @author wangxiangshuai
 */
class GroupOrderModel extends CI_Model {

    //put your code here
    public function getGroupLits($where = array(), $page = 1, $limit = 2) {
        $this->db->select('ug.*,uw.wx_nickname,uw.wx_headimg,count(ug.groupbuy_sn) as group_in_number')
                ->from('user_groupbuy ug')
                ->join('user_wechat uw', 'uw.user_id = ug.user_id');
        if (!empty($where['group_produt_id'])) {
            $this->db->where('ug.group_product_id', $where['group_produt_id']);
        }
        if (!empty($where['status'])) {
            $this->db->where_in('ug.status', $where['status']);
        }
        if (!empty($where['endtime'])) {
            $this->db->where('ug.endtime >' . $where['endtime']);
        }
        if (!empty($where['groupbuy_sn'])) {
            $this->db->where('ug.groupbuy_sn ="' . $where['groupbuy_sn'] . '"');
        } else {
            $this->db->group_by('ug.groupbuy_sn');
        }
        if (!empty($where['user_id'])) {
            $this->db->where('ug.user_id', $where['user_id'])
                    ->select('gp.group_product_price,gp.auto_group,gp.group_user_num')
                    ->join('group_product gp', 'gp.group_product_id=ug.group_product_id', 'left')
                    ->select('p.thumb,p.product_name,p.market_price')
                    ->join('product p', 'p.product_id=gp.product_id', 'left')
                    ->select('o.status as order_status,o.order_amount')
                    ->join('order o', 'o.order_id=ug.order_id', 'left')
                    ->order_by('ug.createtime', 'desc');
        } else {
            $this->db->order_by('ug.createtime', 'asc');
        }

        $query = $this->db
                ->limit($limit, ($page - 1) * $limit)
                ->get();
        return $query->result_array();
    }

    /**
     * 查询团列表
     * @param type $groupbuy_sn
     */
    public function getGroupbuyBysn($groupbuy_sn) {
        $this->db->select('ug.*,uw.wx_headimg,uw.wx_nickname')
                ->from('user_groupbuy ug')
                ->join('user_wechat uw', 'uw.user_id = ug.user_id');
        if (!empty($groupbuy_sn)) {
            $this->db->where('ug.groupbuy_sn', $groupbuy_sn);
        }
        $query = $this->db
                ->order_by('ug.createtime', 'asc')
                ->get();
        return $query->result_array();
    }

    /**
     * 创建订单号
     * @return string
     */
    public function getOrderSn() {
        $sn = "GN" . time() . mt_rand(1000, 9999);
        $has = $this->GroupOrderModel->getGroupbuyBysn($sn);
        if (!empty($has)) {
            $this->getOrderSn();
        }
        return $sn;
    }

    /**
     * 获取某个团的详情
     */
    public function getGroupbuyByorder_id($order_id) {
        $query = $this->db->select('*')
                ->from('user_groupbuy ')
                ->where('order_id', $order_id)
                ->get();
        return $query->row_array();
    }

    /**
     * 获取在该活动中购买的数量
     */
    public function getGroupProductNum($user_id, $group_product_id, $product_id) {
        $query = $this->db->select('sum(op.product_number) as number')
                ->from('user_groupbuy ug')
                ->join('order_product op', 'op.product_id=' . $product_id, 'left')
                ->join('order o', '(o.order_id=op.master_order_id )', 'left')
                ->where('ug.group_product_id', $group_product_id)
                ->where('o.order_type="G" and o.user_id="' . $user_id . '"')
                ->get();
        return $query->row_array()['number'];
    }

    public function upGroupbuy($where, $data) {
        return $this->db->update('user_groupbuy', $data, $where);
    }

}