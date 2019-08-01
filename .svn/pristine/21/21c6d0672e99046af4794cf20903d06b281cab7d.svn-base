<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 区域信息
 * @package	ZMshop
 * @author	qidazhong@hnzhimo.com
 * @copyright	2017 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class Area extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model("areaModel");
    }
    /**
     * 省级区域
     */
    public function getProvinces(){
        $pid=$this->input->post("province_id");
        $provinces=$this->areaModel->getProvince();
        
        $option="";
        foreach($provinces as $province){
            $selected="";
            if($pid&&$province['province_id']==$pid){
                $selected="selected";
            }
            $option.="<option value='".$province['province_id']."' $selected>".$province['name']."</option>";
        }
        echo $option;
    }
    
    /**
     * 市级区域
     */
    public function getCitys(){
        $pid=$this->input->post("province_id");
        $cid=$this->input->post("city_id");
        $citys=$this->areaModel->getCity($pid);
        $option="";
        foreach($citys as $city){
                    $selected="";

            if($cid&&$city['city_id']==$cid){
                $selected="selected";
            }
            $option.="<option value='".$city['city_id']."' $selected>".$city['name']."</option>";
        }
        echo $option;
    }
    
    /**
     * 区域
     */
    public function getDistricts(){
        $cid=$this->input->post("city_id");
        $did=$this->input->post("district_id");
        $districts=$this->areaModel->getDistrict($cid);
        $option="";
        foreach($districts as $district){
                    $selected="";

            if($did&&$district['district_id']==$did){
                $selected="selected";
            }
            $option.="<option value='".$district['district_id']."' $selected>".$district['name']."</option>";
        }
        echo $option;
    }
    
    static function getModuleInfo(){}
}
