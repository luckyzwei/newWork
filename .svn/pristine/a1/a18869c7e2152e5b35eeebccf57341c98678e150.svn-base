<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 用户喜欢商品
 *
 * @author qidazhong@hnzhimo.com
 */
class UserLikeModel extends CI_Model{
        
    public function getLikeProductListByUserID($userid){
        $query=$this->db->select("user_like.*,product.product_name,product.like_number")
                ->from("user_like")
                ->join("product","product.product_id=user_like.product_id","left")
                ->where("user_like.user_id=".$userid)
                ->get();
        return $query->result_array();
    }
    
    public function addLike($data){
        if($this->db->insert("user_like",$data)){
            $this->db->set("like_number","like_number+1",false)
                    ->where("product_id=".$data['product_id'])
                    ->update("product");
            return true;
        }
        return false;
    }
    
    public function getLikeUserByProductId($productId){
        $query=$this->db->select("user.user_name,user.nickname,user.user_id,user_wechat.wx_headimg,user_like")
                ->from("user_like")
                ->join("user","user.user_id=user_like.user_id")
                ->join("user_wechat","user.user_id=user_wechat.user_id")
                ->where("user_like.product_id=$productId")
                ->get();
        return $query->result_array();
    }
    
}
