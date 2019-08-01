<?php

/**
 * 在线活动报名模型
 * @package	ZMshop
 * @author             wangxiangshuai@hnzhimo.com
 * @copyright	2017 河南知默网络科技有限公司
 * @link		http://www.hnzhimo.com
 * @since		Version 1.0.0
 */
class ActivityOrderModel extends CI_Model {

    public function getActivityOrderList($limit = 10, $page = 1, $where = array()) {
        $this->db->select("ao.*,a.activity_title")->from("activity_order ao")
            ->join('activity a','a.activity_id=ao.activity_id','left')
            ->where($where);
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $query = $this->db->limit($limit, ($page - 1) * $limit)->get();
        return array("count" => $rownum, "result" => $query->result_array());
    }

    public function recommend($data) {
        return $this->db->where("activity_order_id=" . $data['activity_order_id'])->update("activity_order", $data);
    }

    public function deleteActivityOrder($where) {
        return $this->db->delete("activity_order", $where);
    }
}
