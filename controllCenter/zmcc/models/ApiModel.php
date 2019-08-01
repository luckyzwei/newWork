<?php
/**
 *api接口模型
 * @package	ZMshop
 * @author	qidazhong@hnzhimo.com
 * @copyright	2017 河南知默科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class ApiModel extends CI_Model{
    
    public function addApi($data){
        return $this->db->insert("api",$data);
    }
    public function updateApi($data,$where){
        return $this->db->update("api",$data,$where);
    }
    public function deleteApi($where){
        return $this->db->delete('api', $where);
    }
    public function getApiList($where = array()){
        if($where){
            $this->db->or_like(array('name' => $where['keyword']));
        }
        $query=$this->db->select("*")->order_by("api_id","desc")->get("api");
        return $query->result_array();
    }
    public function getApiById($api_id){
        $query=$this->db->get_where("api",array("api_id"=>$api_id));
        return $query->row_array();
    }
    public function getApi($where){
        $query=$this->db->get_where("api",$where);
        return $query->row_array();
    }
}
