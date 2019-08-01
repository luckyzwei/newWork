<?php
/**
 * token和 session对应关系数据模型
 *
 * @author qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 */
class TokenModel extends CI_Model{
    
    public function getSessionByToken($token){
        $query=$this->db->get_where("token",array("token"=>$token));
        return $query->row_array();
    }
    
    public function setToken($data){
        return $this->db->insert("token",$data);
    }
    
    public function updateToken($data,$where){
        return $this->db->update("token",$data,$where);
    }
    
    public function deleteToken($where){
        return $this->db->delete("token",$where);
    }
}
