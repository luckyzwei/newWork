<?php

/**
 * 系统参数配置模型
 * @author qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 */
class UserCollectModel extends CI_Model{
    
    /**
     * 获取收藏商品总数和列表
     */
    public function getCollectProduct($limit=10){
        $this->db->select("count(1) as collect_num,product.product_name,product.thumb,product.product_id,product.price")->from("user_collect")
                ->join("product ","user_collect.product_id=product.product_id","left")
                ->where("product.status!=-1")
                ->group_by("user_collect.product_id");
        $result_db=clone($this->db);
        $count=$this->db->count_all_results();
        $result_db->limit($limit,0)
                ->order_by("collect_num desc");
        $query=$result_db->get();
        $datas=$query->result_array();
        return array("count"=>$count,"datas"=>$datas);
                
    }
}
