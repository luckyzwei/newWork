<?php

/**
 * Description of CashAppModel
 *
 * @author Administrator
 */
class CashAppModel extends CI_Model {

    /**
     * 分页获取提现申请列表:搜索条件：用户id，状态
     * zu   	2018/8/30
     */
    public function getApplications($page, $limit, $where) {
        $this->db->select('ca.*,uai.authen_info_id,uai.real_name,uw.wx_headimg,u.nickname')
                ->from('cash_application ca')
                ->join('user_authen_info uai', 'uai.user_id=ca.user_id', 'left')
                ->join('user_wechat uw', 'uw.user_id=ca.user_id', 'left')
                ->join('user u', 'u.user_id=ca.user_id', 'left')
                ->like($where);
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $list = $this->db->limit($limit, ($page - 1) * $limit)
                ->get()
                ->result_array();
        return array('count' => $rownum, 'list' => $list);
    }

    public function getApplicationById($application_id) {
        $query = $this->db->select("cash_application.*,user_wechat.wx_fun_openid")
                ->join("user_wechat", "cash_application.user_id=user_wechat.user_id", "left")
                ->where(array("apl_id" => $application_id))
                ->get("cash_application");
        return $query->row_array();
    }

    /**
     * 更新申请状态
     */
    public function updateApplication($apl_id, $status) {
        return $this->db->where("apl_id", $apl_id)->set("status", $status)->update("cash_application");
    }

    /**
     * 添加提现记录返回插入的ID
     * @param type $data
     * @return type
     */
    public function addApplocation($data){
        $this->db->insert('cash_application', $data);
        return $this->db->insert_id();
    }
}
