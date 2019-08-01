<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 系统参数类，主要实现系统参数的快捷读取
 * @author qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 */
class Systemsetting {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model("SettingModel");
    }

    /**
     * 根据setting_key获取setting_value
     * @param type $key
     * @return type
     */
    public function get($key) {
        $data = $this->CI->SettingModel->getSetting($key);
        return $data['setting_value'];
    }

    /**
     * 根据setting_key 设置setting_value
     * @param type $key
     * @param type $value
     * @return boolean
     */
    public function set($key, $value) {
        $updatedata = array(
            array("setting_key" => $key, "setting_value" => $value)
        );
        if ($this->CI->SettingModel->setSettings($updatedata)) {
            return $value;
        }
        return False;
    }

    /**
     *  获取设置分组所有参数
     * @param 设置分组名称
     * @return array("setting_key"=>setting_value)的键值对
     */
    public function getSettingsByGroup($setting_group) {
        $data = $this->CI->SettingModel->getSettingOptionByGroup($setting_group);
        $result = array();
        foreach ($data as $setting) {
            $result[$setting['setting_key']] = $setting['setting_value'];
        }
        return $result;
    }

    /**
     * 获取页面的title
     * @param array $moduleInfo 
     */
    public function getTitle($moduleInfo) {
        $method = $this->CI->uri->segment(2) ? $this->CI->uri->segment(2) : "index";
        if (empty($moduleInfo)) {
            $title = "";
        } else {
            $title = element($method, $moduleInfo['operation']);
            
            if(!$title){
                $title=$moduleInfo['moduleName'];
            }
        }
        return $title."|".$this->get("site_name");
    }

}
