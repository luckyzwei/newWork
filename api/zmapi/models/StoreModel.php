<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 店铺信息模型
 *
 */
class StoreModel extends CI_Model{
   
    public function getStoreByUser($userid){
        
        $query=$this->db->select("user_wechat.*,store.*")
                ->join("user_wechat","user_wechat.user_id=store.store_uid","left")
                ->where("store_uid",$userid)
                ->get("store");
        
        return $query->row_array();
    }
    
    public function getStoreById($user_id){
        $query=$this->db->get_where("store",array("store_uid"=>$user_id));
        return $query->row_array();
    }
    
    /**
     * 添加店铺信息
     * @param type $data
     * @return type
     */
    public function addStore($data){
         $this->db->insert("store",$data);
         return $this->db->insert_id();
    }
    public function editStore($data,$where){
        return $this->db->where($where)->update("store",$data);
    }
    
}
