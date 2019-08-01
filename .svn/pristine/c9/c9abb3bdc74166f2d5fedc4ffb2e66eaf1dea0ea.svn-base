<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActivityModel
 *
 * @author wangxiangayx
 */
class ActivityModel extends CI_Model {

    /**
     * 获取活动列表
     * @param type $limit
     * @param string $type all 全部  old 已结束  now正在进行   future未开始
     */
    public function getActivityList($page = 1, $limit = 5, $type = 'now') {
        switch ($type) {
            case 'old':$where = ' end_time< "' . time() . '" and end_time>0';
                break;
            case 'now':$where = '( end_time> "' . time() . '" and ( start_time< "' . time() . '" and start_time>0  ) )or (end_time=0 and ( start_time< "' . time() . '" and start_time>0  ))';
                break;
            case 'future':$where = ' start_time>"' . time() . '"';
            default:$where = array();
                break;
        }
        $query = $this->db->select('*')
                ->from('activity')
                ->where($where)
                ->limit($limit, ($page - 1) * $limit)
                ->get();
        return $query->result_array();
    }

    /**
     * 查询在线活动信息
     * @param type $activity_id
     * @param type $user_id 传值查询信息
     */
    public function get_activity($activity_id, $user_id = 0) {
        $this->db->select("activity.*")
                ->from('activity');
        if ($user_id) {
            $this->db->select("activity_order.activity_order_id,activity_order.name,activity_order.telephone,activity_order.paytag,activity_order.pay_order_sn,activity_order.status,activity_order.remarks")
                    ->join('activity_order', 'activity.activity_id=activity_order.activity_id and activity_order.user_id = ' . $user_id, 'left');
        }
        $query = $this->db->where('activity.activity_id=' . $activity_id)
                ->get();
//        echo $this->db->last_query();
        $activity = $query->row_array();
        //查询已支付的报名人数
        $activity['in_number'] = $this->db->from('activity_order')->where('activity_id='.$activity_id.' and status >0 ')->count_all_results();
        return $activity;
    }
    /**
     * 获取报名信息
     * @param type $avtivity_order_id
     */
    public function get_activity_order($avtivity_order_id){
        $query = $this->db->select('activity_order.*,activity.price')
                ->from('activity_order')
                ->join('activity', 'activity.activity_id=activity_order.activity_id', 'left')
                ->where('activity_order.activity_order_id = '.$avtivity_order_id)
                ->get();
        return $query->row_array();
    }
    /**
     * 活动报名
     * @param type $data
     */
    public function add_activity($data) {
        $this->db->insert('activity_order', $data);
        return $this->db->insert_id();
    }
    /**
     * 更改报名信息
     * @param type $activity_order_id
     * @param type $data
     * @return type
     */
    public function edit_activity($activity_order_id, $data) {
        $res = $this->db->update('activity_order', $data, array("activity_order_id" => $activity_order_id));
        if ($res)
            return $activity_order_id;
        return;
    }
}
