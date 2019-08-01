<?php

/**
 * 在线活动管理模型
 * @package	ZMshop
 * @author             wangxiangshuai@hnzhimo.com
 * @copyright	2017 河南知默网络科技有限公司
 * @link		http://www.hnzhimo.com
 * @since		Version 1.0.0
 */
class ActivityModel extends CI_Model {

    public function getActivityList($limit = 10, $page = 1) {
        $this->db->select("*")->from("activity");
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $query = $this->db->order_by('activity_id','DESC')->limit($limit, ($page - 1) * $limit)->get();
        return array("count" => $rownum, "result" => $query->result_array());
    }

    public function editActivity($data, $activity_id) {
        return $this->db->update("activity", $data, array('activity_id' => $activity_id));
    }

    public function deleteActivity($where) {
        return $this->db->delete("activity", $where);
    }

    public function addActivity($data) {
        return $this->db->insert("activity", $data);
    }

    public function getActivityById($activity_id) {
        $query = $this->db->get_where("activity", array('activity_id' => $activity_id));
        return $query->row_array();
    }
    public function autoActivityList($activity_title){
        $data = array();
        $this->db->select('*')
                ->from('activity');
        if (!empty($activity_title))
            $this->db->or_like(array('activity_id' => $activity_title, 'activity_title' => $activity_title));
        $query = $this->db
                ->order_by('activity_id', 'DESC')
                ->limit(10)
                ->get();
        foreach ($query->result_array() AS $arr) {
            $data[] = $arr;
        }
        return $data;
    }

}
