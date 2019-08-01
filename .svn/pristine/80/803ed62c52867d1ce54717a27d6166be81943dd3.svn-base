<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 系统参数配置模型
 * @author qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 */
class SettingModel extends CI_Model {

    public function getSetting($key) {
        $query = $this->db->get_where("setting", array("setting_key" => $key));
        return $query->row_array();
    }

    public function getSettingById($setting_id) {
        $query = $this->db->get_where("setting", array("setting_id" => $setting_id));
        return $query->row_array();
    }

    /**
     * 批量更新保存系统设置的值
     * @param type $data array=array(array("setting_key"=>key,"setting_value"=>value)……)
     * 
     */
    public function setSetting($data) {
        return $this->db->update_batch("setting", $data, "setting_key");
    }

    /**
     * 添加系统配置项
     */
    public function addSetting($data) {
        return $this->db->insert("setting", $data);
    }

    public function deleteSetting($where) {
        return $this->db->delete("setting", $where);
    }

    public function editSetting($data, $where) {
        return $this->db->update("setting", $data, $where);
    }

    /*
     * 获取系统配置参数
     * @params $where分组名称或者关键字
     */

    public function getSettings($where, $offset = 0, $limit = 20) {
        if ($where) {
            $this->db->or_group_start();
            $this->db->where("setting_group", $where);
            $this->db->or_like("setting_key", $where);
            $this->db->or_like("setting_name", $where);
            $this->db->group_end();
        }
        $count_db = clone($this->db);
        $count_db->from("setting");
        $rownum = $count_db->count_all_results();

        $query = $this->db
                ->order_by("sort_order asc,setting_id desc")
                ->limit($limit, $offset)
                ->get("setting");
        $result = array("count" => $rownum, "result" => $query->result_array());
        return $result;
    }

    /**
     * 获取可以自定义的配置项
     * @param type $where
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function getSettingsOnShow($where, $offset = 0, $limit = 20) {
        if ($where) {
            $this->db->or_group_start();
            $this->db->where("setting_group", $where);
            $this->db->or_like("setting_key", $where);
            $this->db->or_like("setting_name", $where);
            $this->db->group_end();
        }
        $this->db->where("is_show=1");
        $count_db = clone($this->db);
        $count_db->from("setting");
        $rownum = $count_db->count_all_results();

        $query = $this->db
                ->order_by("sort_order asc,setting_id desc")
                ->limit($limit, $offset)
                ->get("setting");
        $result = array("count" => $rownum, "result" => $query->result_array());
        return $result;
    }

    public function getSettingGroups() {
        $query = $this->db
                ->group_by("setting_group")
                ->get("setting");
        return $query->result_array();
    }

    /**
     * 根据分组名称获取配置项
     * @param type $setting_group
     */
    public function getSettingOptionByGroup($setting_group) {
        $query = $this->db->order_by("sort_order","asc")->get_where("setting", array("setting_group" => $setting_group));
        return $query->result_array();
    }

    /**
     * 判断条件下的设置是否存在
     * @param array $where
     * @return bool
     */
    public function isExist($where) {
        $query = $this->db->get_where("setting", $where);
        $row = $query->row_array();
        return empty($row) ? FALSE : TRUE;
    }

}
