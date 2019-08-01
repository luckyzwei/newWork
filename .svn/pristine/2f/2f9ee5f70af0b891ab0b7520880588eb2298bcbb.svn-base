<?php

/**
 * 用户账户日志模型:包含积分变更
 */
class UserAccountLogModel extends CI_Model {
    /**
     * 添加账户变更日志
     * @param type $data
     * @return type
     */
    public function addAccountLog($data){
        return $this->db->insert("user_account_log",$data);
    }
    /**
     * 添加积分变更日志
     * @param type $data
     * @return type
     */
    public function addIntergalLog($data){
         return $this->db->insert("user_intergal_log",$data);
    }
    /**
     * 获取用户积分日志
     * @param type $user_id
     */
    public function  getIntergalLog($user_id){
        $query=$this->db->select("*,from_unixtime(createtime,'%Y-%m-%d') as createtime")
                ->where("user_id",$user_id)
                ->order_by("intergal_log_id desc")
                ->get("user_intergal_log");
        return $query->result_array();
    }
     public function  getIntergal($filter){
       $this->db->select("*")
                ->where("user_id",$filter['user_id']);
       if(key_exists("change_type", $filter)){
                 $this->db->where("change_type",$filter['change_type']);
       }
       if(key_exists("createtime", $filter)){
                 $this->db->where("from_unixtime(createtime,'%Y%m%d')", date("Ymd"));
       }
       
               $query= $this->db ->order_by("intergal_log_id desc")
                ->get("user_intergal_log");
        return $query->result_array();
    }
    /**
     * 获取用户账户日志
     * @param type $user_id
     */
    public function getAccountLog($user_id){
        $query=$this->db->select("*,FROM_UNIXTIME(createtime, '%Y-%m-%d') as createtime")
                ->where("user_id",$user_id)
                ->order_by("account_log_id desc")
                ->get("user_account_log");
        return $query->result_array();
    }
    

}
