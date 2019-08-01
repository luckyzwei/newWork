<?php

/**
 * 营销策略模型
 * @package   ZZZZshop
 * @author     wangxiangshuai@hnzhimo.com
 * @copyright  2017 河南知默网络科技有限公司
 * @link       http://www.zzzzshop.com
 * @since      Version 1.0.0
 */
class RechargeStrategyModel extends CI_Model {

    public function getRechargeList($limit = 20, $page = 1) {
        $count = $this->db->count_all_results("recharge_strategy");
        $query = $this->db->order_by('strategy_id desc')
                ->limit($limit, ($page - 1) * $limit)
                ->get("recharge_strategy");
        return array('count' => $count, 'datas' => $query->result_array());
    }

    public function addRecharge($data) {
        $data['createtime'] = time();
        $data['starttime'] = strtotime($data['starttime']);
        $data['endtime'] = strtotime($data['endtime']);
        $data['give_product'] = serialize($data['give_product']);

        return $this->db->insert('recharge_strategy',$data);
    }

    public function editRecharge($data, $where) {
        $data['starttime'] = strtotime($data['starttime']);
        $data['endtime'] = strtotime($data['endtime']);
        $data['give_product'] = serialize($data['give_product']);
        return $this->db->update("recharge_strategy",$data, $where);
    }

    public function deleteRechargeStrategy($where) {
        return $this->db->where($where)->delete("recharge_strategy");
    }

    public function getRechargeById($strategy_id) {
        $query = $this->db->get_where("recharge_strategy", array('strategy_id' => $strategy_id));
        return $query->row_array();
    }

}
