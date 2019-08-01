<?php

class RechargeOrderModel extends CI_Model {

    /**
     * 添加充值订单
     * @param type $data
     */
    public function addRcOrder($data) {
        return $this->db->insert("recharge_order",$data);
    }

    /**
     * 获取充值订单
     * @param type $sn
     */
    public function getRcOrderBySn($sn) {
        $query=$this->db->get_where("recharge_order",array("rc_order_sn"=>$sn));
        return $query->row_array();
    }

    /**
     * 更新充值订单
     * @param type $data
     * @param type $sn
     */
    public function updateRcOrder($data, $sn) {
        return $this->db->where("rc_order_sn",$sn)->update("recharge_order",$data);
    }

}
