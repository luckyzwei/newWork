<?php

/**
 * 支付方式模型
 */
class PaymentModel extends CI_Model {

    public function getPaymentList() {
        $query = $this->db
                ->order_by("payment_id", "desc")
                ->get("payment");
        return $query->result_array();
    }

    public function addPayment($data) {
        return $this->db->insert("payment", $data);
    }

    public function editPayment($data, $where) {
        return $this->db->update("payment", $data, $where);
    }

    public function deletePayment($where) {
        foreach ($where as $w => $v) {
            if (is_array($v)) {
                $where = $w . " in (" . implode(",", $v) . ")";
            }
        }
        return $this->db->delete("payment", $where);
    }

    public function getPayment($where) {
        $query = $this->db->get_where("payment", $where);
        return $query->row_array();
    }

    /**
     * 更新支付方式配置信息
     * @param type $data
     * @param type $where
     */
    public function setPayment($data) {
        $query = $this->db->get_where("payment", array("payment_id" => $data['payment_id']));
        $baseinfo = $query->row_array();
        $setting_flag = $baseinfo['setting_flag'];
        //查询配置项中所有的配置项
        $query = $this->db->get_where("setting", array("setting_group" => $setting_flag));
        $settings = $query->result_array();
        foreach ($settings as $setting) {
            if (isset($data[$setting['key']])) {
                $this->db->update("setting", array("key" => $setting['key']), array("value" => $data[$setting['key']]));
            }
        }
        return true;
    }

    /**
     * 获取配置方式的详细信息
     * @param type $configGroup 配置项的分组信息
     * @param type $payment_id
     * @return type
     */
    public function getPayInfo($payment_id) {
        $query = $this->db->from('payment')
                ->where('payment_id = ' . $payment_id . " and payment_status=1")
                ->get();
        return $query->row_array();
    }

}
