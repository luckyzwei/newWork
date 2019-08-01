<?php
/**
 * Description of AreaModel
 *
 * @author Administrator
 */
class AreaModel extends CI_Model{
    
    public function getProvince($where=array()){
        $query=$this->db->get_where("province",$where);
        return $query->result_array();
    }
    
    public function getCity($pid){
        $query=$this->db->get_where("city",array("province_id"=>$pid));
        return $query->result_array();
    }
    
    public function getDistrict($cid){
        $query=$this->db->get_where("district",array("city_id"=>$cid));
        return $query->result_array();
    }
    
    public function getAreaTree($pid=0){
        $where=array();
        if($pid!=0){
            $where['province_id']=$pid;
        }
        $provinces=$this->getProvince($where);
        foreach($provinces as &$province){
            $province['city']=$this->getCity($province['province_id']);
            foreach ($province['city'] as &$city){
                $city['district']=$this->getDistrict($city['city_id']);
            }
        }
        return $provinces;
    }
}
