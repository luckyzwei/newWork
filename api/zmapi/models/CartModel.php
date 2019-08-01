<?php

/**
 * 购物车数据模型
 */
class CartModel extends CI_Model {

    public function addCart($data) {
        //查找当前商品是否存在
        $where = array(
            "user_id" => $data['user_id'],
            "product_id" => $data['product_id'],
            "product_special_id" => $data['product_special_id'],
            "product_type" => $data['product_type']
        );
        $cart_product = $this->db->select("*")->where($where)->get("cart");
        $result = $cart_product->row_array();
        if (!empty($result)) {//更新商品数量
            $this->db->set("product_number", "product_number+" . $data['product_number'], false)
                    ->where($where)
                    ->update("cart");
            return $result['cart_id'];
        } else {
            $this->db->insert('cart', $data);
            return $this->db->insert_id();
        }
        return false;
    }

    /**
      获取当前购物车商品，当第二个参数为真时仅获取参与结算的商品
     * */
    public function getCartList($user_id, $checkout = false) {
        $this->db->select('cart.*,product.thumb,product_special.attributes,product_special.special_struct,product_special.specifications,product.intergral_deduce')
                ->from('cart')
                ->join("product", "product.product_id=cart.product_id", "left")
                ->join("product_special", "product_special.product_id=cart.product_id", "left")
                ->where("cart.user_id", $user_id);
        if ($checkout) {
            $this->db->where("checkout", 1);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function editCart($data, $where) {
        return $this->db->update('cart', $data, $where);
    }

    public function checkked($cart_id, $value) {
        return $this->db->set("checked", $value, false)->where("cart_id", $cart_id)->update('cart');
    }

    /**
     * 更新购物车商品数量
     * @param type $cart_id
     * @param type $number
     * @return type
     */
    public function set_number($cart_id, $number) {
        $this->db->set("product_number", $number, false);
        $this->db->where("cart_id", $cart_id);
        return $this->db->update("cart");
    }

    /**
     * 删除购物车商品
     * @param type $cart_ids
     * @param type $user_id
     * @return type
     */
    public function delectCart($cart_ids, $user_id) {
        if (is_array($cart_ids)) {
            $where = 'user_id = ' . $user_id . ' AND (';
            foreach ($cart_ids as $value) {
                $where .= 'cart_id =' . $value . ' OR ';
            }
            $where = substr($where, 0, -3) . ')';
            return $this->db->delete('cart', $where);
        } else {
            return $this->db->delete('cart', array('user_id' => $user_id, 'cart_id' => $cart_ids));
        }
    }

    public function getCartProduct($cart_id, $user_id) {
        $query = $this->db->get_where("cart", array("user_id" => $user_id, "cart_id" => $cart_id));
        return $query->row_array();
    }

    /**
     * 清空购物车:仅清除已经结算的商品
     * @param type $user_id
     * @return type
     */
    public function clearCart($user_id) {
        return $this->db->where("user_id", $user_id)->where("checkout", 1)->delete("cart");
    }

    /**
      设置购物车结算状态
     * */
    public function setChkStatus($cart_id, $user_id, $chkstatus) {

        if ($cart_id !== "all") {
            $this->db->where("cart_id", $cart_id);
        }
        $this->db->where("user_id", $user_id);
        return $this->db->set("checkout", $chkstatus)->update("cart");
    }

}
