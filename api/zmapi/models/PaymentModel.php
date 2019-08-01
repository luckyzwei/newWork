<?php

/**
 * 支付数据模型
 */
class PaymentModel extends CI_Model {

    /**
     * 根据用户浏览器类型
     * @param type $type 浏览器参数
     * @return type 支付设置数组
     */
    public function getPayList($type) {
        $query = $this->db->select('*')
                ->from('payment')
                ->where('support_client  like "%,' . $type.',%" and payment_status=1')
                ->get();
        return $query->result_array();
    }

    /**
     * 获取配置方式的详细信息
     * @param type $configGroup 配置项的分组信息
     * @param type $payment_id
     * @return type
     */
    public function getPayInfo($payment_id) {
        $query = $this->db->from('payment')
                ->where('payment_id = ' . $payment_id." and payment_status=1")
                ->get();
        return $query->row_array();

    }

}
