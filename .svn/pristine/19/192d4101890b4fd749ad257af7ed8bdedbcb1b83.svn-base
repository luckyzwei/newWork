<?php

/**
  * 用户分组管理模型
  * @package	ZMshop
  * @author	xuhuan@hnzhimo.com
  * @copyright	2017 河南知默科技有限公司
  * @link	http://www.hnzhimo.com
  * @since	Version 1.0.0
 */

class UserGroupModel extends CI_Model {
    public $table = "user_group";
    
    public function getUserGroupList($limit=20,$offset=1) {
        $this->db->select("*")->from($this->table);                  
        $count_db= clone($this->db);
        $rownum=$count_db->count_all_results();
        
        $query=$this->db->order_by('user_group_id desc')
                    ->limit($limit,($offset-1)*$limit)
                    ->get();
        $result=array("count"=>$rownum,"result"=>$query->result_array());
        return $result;
    }

    public function addUserGroup($data) {
        return $this->db->insert($this->table, $data);
    }

    public function editUserGroup($data,$where) {
        return $this->db->update($this->table, $data, $where);
    }

    public function deleteUserGroup($where) {
        return $this->db->delete($this->table, $where);
    }

    public function getUserGroupInfo($user_group_id) {
        $query = $this->db->get_where($this->table,array('user_group_id'=>$user_group_id));
        return $query->row_array();
    }


    public function isExist($where){
        $query= $this->db->get_where($this->table,$where);
        $row=$query->row_array();
        return empty($row)?FALSE:TRUE;
    }
    /*
     * 设置默认分组
     */
    public function setDefault($group_id){
        //取消默认分组，然后把此id设为默认
        //开启事务
        $res = false;
        $this->db->trans_start();
        $res1 = $this->db
            ->where('is_default','1')
            ->update('user_group',['is_default'=>'0']);
        $res2 = $this->db
            ->where('user_group_id',$group_id)
            ->update('user_group',['is_default'=>'1']);
        $this->db->trans_complete();
        if($res1 && $res2){
            return array('status'=>'1','info'=>'成功');
        }else{
            return array('status'=>'0','info'=>'失败');
        }

    }

}