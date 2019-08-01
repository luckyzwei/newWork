<?php 

/**
  * 管理员管理模型
  * @package	ZMshop
  * @author		xuhuan@hnzhimo.com
  * @copyright	2017 河南知默网络科技有限公司
  * @link		http://www.hnzhimo.com
  * @since		Version 1.0.0
 */

class AdminModel extends CI_Model{
	public $table="admin";

	public function getAdminLists($limit=20,$page=0){
		$this->db->select("admin.*,role.*") 
				 ->join('role','role.role_id=admin.role_id','left');
		
		$admindb=clone($this->db);
		$count=$admindb->count_all_results($this->table);
		$query=$this->db->order_by('admin_id desc')->where("status!=-1")
				 ->limit($limit,($page-1)*$limit)
				 ->get($this->table);
		return array('count'=>$count,'datas'=>$query->result_array());

	}

	public function addAdmin($data){
		return $this->db->insert($this->table,$data);
	}

	public function editAdmin($data,$where){
		return $this->db->update($this->table,$data,$where);
	}

	public function deleteAdmin($where){
		return $this->db->delete($this->table,$where);
	}

	public function getAdminById($admin_id){
		$query=$this->db->get_where($this->table,array('admin_id'=>$admin_id));
		return $query->row_array();
	}

	public function getAdminByName($name){
		$query=$this->db->get_where($this->table,array('name'=>$name));
		return $query->row_array();
	}

	public function isExist($where){
        $query= $this->db->get_where($this->table,$where);
        $row=$query->row_array();
        return empty($row)?FALSE:TRUE;
    }

    public function getAdminInfo($where=array()) {
        $query = $this->db->select("admin.*,role.role_name,role.role_id")
                ->join("role","role.role_id=admin.role_id","left")
                ->where($where)
                ->get_where($this->table);
        $adminInfo=$query->row_array();
        if(!empty($adminInfo['role_power'])){
            $adminInfo['role_power']=  unserialize($adminInfo['role_power']);
        }
        return $adminInfo;
    }


}