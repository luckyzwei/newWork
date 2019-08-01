<?php

/**
 * 系统参数配置模型
 * @author qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 */
class SettingModel extends CI_Model {

    public function getSetting($key) {
        $query = $this->db->get_where("setting", array("setting_key"=> $key));
        return $query->row_array();
    }
    
    public function getSettingById($setting_id){
        $query=$this->db->get_where("setting",array("setting_id"=>$setting_id));
        return $query->row_array();
    }
  
    /*
     * 获取系统配置参数
     * @params $where分组名称或者关键字
     */
    public function getSettings($keys=array()) {
        $query=$this->db->where_in("setting_key",$keys)->get("setting");
        return $query->result_array();
    }
    
    public function getSettingGroups(){
        $query=$this->db
                ->group_by("setting_group")
                ->get("setting");
        return $query->result_array();
    }
    /**
     * 根据分组名称获取配置项
     * @param type $setting_group
     */
    public function getSettingOptionByGroup($setting_group){
        $query=$this->db->get_where("setting",array("setting_group"=>$setting_group));
        return $query->result_array();
    }
    /**
     * 判断条件下的设置是否存在
     * @param array $where
     * @return bool
     */
    public function isExist($where){
        $query= $this->db->get_where("setting",$where);
        $row=$query->row_array();
        return empty($row)?FALSE:TRUE;
    }

}
