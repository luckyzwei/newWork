<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 店铺信息模型
 *
 */
class StoreProductModel extends CI_Model {

    public function addStoreProduct($data) {
        $this->db->insert("store_product", $data);
        return $this->db->insert_id();
    }

    public function updateStoreProduct($data, $where) {
        return $this->db->where($where)->update("store_product", $data);
    }

    public function deleteStoreProduct($where) {
        return $this->db->delete("store_product", $where);
    }

    public function getStoreProducts($user_id) {
        $this->db->select("store_product.*,product.like_number,product.collect_number,product.thumb,product.product_name,product.price as product_price,product.market_price")
                ->from("store_product")
                ->join("product", "store_product.product_id=product.product_id", "left");
        $query = $this->db->where("product.status=1 and store_product.user_id=" . $user_id)->order_by("store_product_id desc")->get();
        return $query->result_array();
    }

    /**
     * 根据商品id获取商品信息
     * @param type $product_id
     * @return type
     */
    public function getStoreProductById($product_id,$store_id) {
        $this->db->select("product.thumb,product.explain,product.product_name,product.price as product_price,product.market_price,store_product.*")
                ->from("product")
                ->join("store_product", "store_product.product_id=product.product_id and store_product.store_id=".$store_id, "right");
        $this->db->where('product.status=1 and product.product_id=' . $product_id);
        $query = $this->db->get();
//        echo $this->db->last_query();
        return $query->row_array();
    }

    public function getStoreProduct($user_id,$product_id) {
        $this->db->select("product.*,product.price as product_price,store_product.*")
                ->from("product")
                ->join("store_product", "store_product.product_id=product.product_id and store_product.user_id=".$user_id, "left");
        $this->db->where('product.status=1 and product.product_id=' . $product_id);
        $query = $this->db->get();
        return $query->row_array();
    }

}
