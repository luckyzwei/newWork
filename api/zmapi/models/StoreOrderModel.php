<?php

/**
 * 店铺订单和统计模型
 *
 * @author Administrator
 */
class StoreOrderModel extends CI_Model {

    /**
     * 统计时间段内店铺订单已经付款订单
     * @param $user_id,$time_quantum时间段，单位为天,-1的时候表示全部时间
     * @param $reward_type 0 表示销售佣金，1表示平台奖励（二级佣金）
     */
    public function countStroeOrders($user_id, $time_quantum, $reward_type = 0) {
        $start_time = strtotime(date("Y-m-d 00:00:00", time() - $time_quantum * 24 * 3600));
        if ($time_quantum == -1) {
            $start_time = 0; //全部时间
        }
        $this->db
                    ->select("count(1) as totalnum,sum(zm_user_reward.order_reward) as reward,sum(zm_order.order_amount) as totalmoney")
                    ->join("user_reward", "user_reward.order_id=order.order_id","left")
                    ->where("order.paytime>" . $start_time . " and order.status in (1,2,5)");
        
        if ($reward_type == 0) {
            $this->db->where("order.from_id=" . $user_id . " and user_reward.reward_type=" . $reward_type." and user_reward.user_id=".$user_id);
        } else {
            $this->db->where("user_reward.reward_type=" . $reward_type." and user_reward.user_id=".$user_id);
        }
        $query=$this->db->get("order");
        $result = $query->row_array();

        //查询时间段内的已结算收入
        $settlment_query=$this->db->select("sum(order_reward) as settlment_money")
                ->where("reward_type",$reward_type)
                ->where("user_id",$user_id)
                ->where("reward_status",1)
                ->where("selement_time>".$start_time)
                ->get("user_reward");
        $result['settlement_money']=$settlment_query->row_array()['settlment_money'];

        foreach ($result as &$res) {
            if (empty($res)) {
                $res = 0;
            }
        }
        return $result;
    }

    /**
     * 
     * @param type $from_id 推广者id
     * @param type $number 获取数量
     * @param type $start_index 开始位置
     * @param type $status 订单状态
     */
 public function getStoreOrders($from_id, $number, $start_index, $settlement_status = '') {
        $this->db->select("order.*,from_unixtime(zm_order.createtime,'%Y-%m-%d')as createtime ,user_wechat.wx_nickname,user_wechat.wx_headimg,user.nickname")
                ->join("user", "user.user_id=order.user_id")
                ->join("user_wechat", "user_wechat.user_id=order.user_id","left")
                ->where("order.status>0")
                ->where("order.master_order_id=0")
                ->where("order.from_id", $from_id)
                ->order_by("order.order_id desc")
                ->from("order");
        if (!empty($settlement_status)) {
            $this->db->where($settlement_status);
        }

        $count_query = clone($this->db);
        $total = $count_query->count_all_results();
        $query = $this->db->limit($number, $start_index)->get();

        $result = $query->result_array();
        $data = array("total" => $total, "data" => $result);
        return $data;
    }

}
