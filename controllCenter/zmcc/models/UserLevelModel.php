<?php

/**
  * 用户等级管理模型
  * @package	ZMshop
  * @author	xuhuan@hnzhimo.com
  * @copyright	河南知默网络科技有限公司
  * @link	http://www.hnzhimo.com
  * @since	Version 1.0.0
 */

class UserLevelModel extends CI_Model{
    public $table="user_level";

    public function getUserLevelList($where=array(),$limit=20,$offset=1){
      $this->db->select("*")->from($this->table);
        if (!empty($where)) {
            $this->db->like("level_name",$where['level_name']);
        }        
        $userdb = clone($this->db);
        $count=$userdb->count_all_results();
        $query=$this->db->order_by("level_sort desc")
                ->limit($limit,($offset-1)*$limit)
                ->get(); 
       return array('count'=>$count,'data' =>$query->result_array());
    }

    public function autoUserLevels($where){
        if ($where) {
          $this->db->or_like($where);
        }
        $query=$this->db
                    ->order_by('level_sort desc')
                    ->limit(15)
                    ->get($this->table); 
        return array('data'=>$query->result_array());
    }

    public function  addUserLevel($data){
          return $this->db->insert($this->table,$data);
    }
    public function editUserLevel($data,$where){
        return $this->db->update($this->table,$data,$where);
    }
    public function deleteUserLevel($where){
        return $this->db->delete($this->table,$where);
    }
  
    public function getUserLevelById($level_id){
        $query=$this->db->get_where($this->table,array("level_id"=>$level_id));
        return $query->row_array();
    }

    public function isExist($where){
        $query= $this->db->get_where($this->table,$where);
        $row=$query->row_array();
        return empty($row)?FALSE:TRUE;
    }
}