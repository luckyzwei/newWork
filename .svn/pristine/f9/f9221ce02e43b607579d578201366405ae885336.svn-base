<?php

/**
 * 充值策略模型
 * @package   ZZZZshop
 * @author     wangxiangshuai@hnzhimo.com
 * @copyright  2017 河南知默网络科技有限公司
 * @link       http://www.zzzzshop.com
 * @since      Version 1.0.0
 */
class RechargeStrategyModel extends CI_Model {

    /**
     * 获取该充值金额的策略
     * @param type $money
     * @param type $type 0 已经满足的策略最优策略   1 未满足 即将要满足
     */
    public function getRecharges($money,$type=0){
        $this->db->select('*')
                ->from("recharge_strategy");
        if(empty($type)){
            $this->db->where("min_amount<='".$money."'")
                    ->order_by("level" , 'DESC')
                    ->order_by('min_amount', 'DESC');
        }else{
            $this->db->where("min_amount>'".$money."'")
                    ->order_by('min_amount', 'ASE')
                    ->order_by("level" , 'DESC');
        }
        $query = $this->db->get();
        return $query->row_array();
    }
    /**
     * 
     * @param type $strategy_id 策略ID
     * @return type
     */
    public function getRechargeById($strategy_id) {
        $query = $this->db->get_where("recharge_strategy", array('strategy_id' => $strategy_id));
        return $query->row_array();
    }

}
