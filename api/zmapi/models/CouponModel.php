<?php

class CouponModel extends CI_Model {

    /**
     * 根据id获取优惠券信息
     * @param type $coupon_id
     */
    public function getCoupon($coupon_id) {
        $query = $this->db->select("*")->get_where("coupon", array("coupon_id" => $coupon_id));
        return $query->row_array();
    }

    /**
     * 根据当前订单总金额获取能够使用的优惠券
     * @param type $totalPrice
     */
    public function getCanuseCoupons($user_id, $totalPrice) {
        $query = $this->db->select("user_coupon.*,coupon.*,FROM_UNIXTIME(zm_coupon.end_time, '%Y-%m-%d') as end_time")
                ->join("coupon", "coupon.coupon_id=user_coupon.coupon_id", "left")
                ->where("user_coupon.status=0 and user_coupon.user_id=" . $user_id . " and (coupon.start_time<" . time() . " and (zm_coupon.end_time>" . time() . " OR zm_coupon.end_time=''))")
                ->where("coupon.limit_order_amount<=" . $totalPrice)
                ->get("user_coupon");
        return $query->result_array();
    }

    /**
     * 获取用户的优惠券列表
     * @param type $user_id
     * @param type $status 状态，0，未使用1已经使用，2已过期，3全部
     */
    public function getUserCoupons($user_id, $status=3) {
        if ($status < 2) {
            $this->db->where("user_coupon.status", $status);
        }
        if($status==0){
             $this->db->where("coupon.end_time>".time());
        }
        if ($status == 2) {
            $this->db->where("coupon.end_time<" . time());
        }
        $query = $this->db->select("user_coupon.coupon_id,user_coupon.status,coupon.*,FROM_UNIXTIME(zm_coupon.end_time, '%Y-%m-%d') as show_end_time")
                ->join("coupon", "user_coupon.coupon_id=coupon.coupon_id", "left")
                ->where("user_coupon.user_id", $user_id)
                ->order_by("user_coupon_id desc")
                ->get("user_coupon");

        $row_num = $query->num_rows();
        $result = $query->result_array();
        
        return array("result" => $result, "totalnum" => $row_num);
    }

    /**
     * 获取用户可领取的优惠券
     */
    public function getUsercanRevice($user_id) {
        $userHsCou = $this->getUserCoupons($user_id, 3)['result'];
        $query = $this->db->select("*,FROM_UNIXTIME(end_time, '%Y-%m-%d') as end_time")
                ->where("receive=1 and receive_num>0 and " . time() . " between start_time and end_time")
                ->get("coupon");
        $allCoupon = $query->result_array();
        $hasarray=array();
        
        foreach($userHsCou as $hs){
            $hasarray[]=$hs['coupon_id'];
        }
        foreach($allCoupon as &$ac){
            if(in_array($ac['coupon_id'],$hasarray)){
                $ac['hasRec']=1;//已经领取
            }
            else{
                $ac['hasRec']=0;//未领取
            }
        }
        return $allCoupon;
    }

    /**
     * 保存用户的优惠券
     * @param type $coupon_id
     * @param type $user_id
     */
    public function setUserCoupon($coupon_id, $user_id) {
        $data = array("coupon_id" => $coupon_id, "status" => 0, "user_id" => $user_id);
        $this->db->insert("user_coupon", $data);
        //更新可领取数量
        return $this->db->where("coupon_id",$coupon_id)->set("receive_num","receive_num-1",FALSE) ->set("draw_num","draw_num+1",FALSE)->update("coupon");
    }
    /**
     * 获取订单使用的优惠券
     * @param type $order_id
     */
    public function getOrderCoupon($order_id){
        $coupon_query = $this->db->select("user_coupon.*,coupon.coupon_name")
                ->join("coupon","coupon.coupon_id=user_coupon.coupon_id","left")
                ->where("order_id", $order_id)
                ->get("user_coupon");
        return $coupon_query->row_array();
    }

}
