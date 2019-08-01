<?php

class KillOrderModel extends CI_Model {

    /**
     * 砍价订单
     * @param type $page
     * @param type $limit
     * @param type $selectdata
     */
    public function getKillOrderList($page = 0, $limit = 20, $selectdata = '') {
        $this->db->select('o.order_id,o.order_sn,o.pay_money,o.user_id,o.status,o.order_type,o.createtime,o.order_amount')->from('order o')->where('o.status!=-1')->where("o.order_type='K'")->where('o.master_order_id', '0');
        if (!empty($selectdata['start_time'])) {
            $this->db->where("o.createtime > '" . $selectdata['start_time'] . "'");
            unset($selectdata['start_time']);
        }
        if (!empty($selectdata['end_time'])) {
            $this->db->where("o.createtime < '" . $selectdata['end_time'] . "'");
            unset($selectdata['end_time']);
        }
        if (!empty($selectdata['product_keywods'])) {
            $this->db->join('order_product', 'order_product.order_id = o.order_id ', 'left')
                    ->like(array('order_product.product_name' => $selectdata['product_keywods']));
            unset($selectdata['product_keywods']);
        }
        if (!empty($selectdata)) {
            $this->db->like($selectdata);
        }
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $query = $this->db
                ->select('u.nickname,u.user_name,u.user_phone,user_wechat.wx_headimg')
                ->join('user u', 'u.user_id=o.user_id', 'left')
                ->join('user_wechat', 'user_wechat.user_id=o.user_id', 'left')
                ->order_by('o.order_id', 'DESC')
                ->limit($limit, ($page - 1) * $limit)
                ->get();
        return array("count" => $rownum, "result" => $query->result_array());
    }

}
