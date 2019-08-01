<?php


/**
 * 管理员角色数据模型
 * @author qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 */
class RoleModel extends CI_Model{
    
    public function addRole($data){
        return $this->db->insert("role",$data);
    }
    public function updateRole($data,$where){
        return $this->db->update("role",$data,$where);
    }
    public function deleteRole($where){
        return $this->db->delete("role",$where);
    }
    public function getRoles($where=array()){
        $query=$this->db->get_where("role",$where);
        return $query->result_array();
    }
    public function getRoleById($id){
        $query=$this->db->get_where("role",array("role_id"=>$id));
        return $query->row_array();
    }
}
