<?php

/**
 * 用户心意模型
 * @author qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 */
class UserLikeModel extends CI_Model{
    
    /**
     * 获取收藏商品总数和列表
     */
    public function getLikeProduct($limit=10){
        $this->db->select("count(1) as like_num,product.product_name,product.images,product.price")->from("user_like")
                ->join("product ","user_like.product_id=product.product_id","left")
                ->where("product.status!=-1")
                ->group_by("user_like.product_id");
        $result_db=clone($this->db);
        $count=$this->db->count_all_results();
        $result_db->limit($limit,0)
                ->order_by("like_num desc");
        $query=$result_db->get();
        $datas=$query->result_array();
        return array("count"=>$count,"datas"=>$datas);
                
    }
}
