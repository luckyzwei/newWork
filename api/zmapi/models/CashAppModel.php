<?php

/**
 * Description of CashAppModel
 *
 * @author Administrator
 */
class CashAppModel extends CI_Model {


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
