<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 商品数据模型
 */
class SupplierModel extends CI_Model {

    public function getSupplierProdutcts($supplier_id = 0, $page = 1, $limit = 20, $keywords = "", $orderby = 'sort', $order = 'DESC') {
        if ($supplier_id) {
            $this->db->where("p.supplier_id", $supplier_id);
        } else {
            $this->db->where("p.supplier_id>", $supplier_id);
        }

        if ($keywords) {
            $this->db->like("p.product_name", $keywords, "both");
        }

        $this->db->select('p.thumb,p.product_id,p.product_name,p.store_number,p.status,p.explain,'
                        . 'p.price,pd.sale_number,pd.incart_number,pd.click_number,pd.like_number')
                ->from('product p')
                ->where('p.status != -1 ')
                ->group_by("p.product_id");

        $this->db->join('product_dynamics pd', 'pd.product_id = p.product_id', 'left')
                ->join('product_category pc', 'pc.product_id = p.product_id', 'left')
                ->order_by("p." . $orderby, $order)
                ->order_by('p.sort', 'DESC');

        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();

        $query = $this->db->limit($limit, ($page - 1) * $limit)->get();
        $products = $query->result_array();
        $result = array("total" => $rownum, "list" => $products);
        return $result;
    }

    /**
     * 获取供货商列表 考虑实际情况数据可能不多
     * 直接一次获取
     */
    public function get_suppliers() {
        $query = $this->db->select('*')
                ->from('supplier')
                ->where('status=1')
                ->get();
        return $query->result_array();
    }

    /**
     * 申请成为供货商
     */
    public function applicationSupplier($data) {
        return $this->db->insert("supplier", $data);
    }

    /*
     * 获取供货商基本信息
     * zu   2018/8/17
     * 需要的数据    supplier_id
     */

    public function getSupplierInfo($supplier_id) {
        $res = $this->db->select('*')
                ->from('supplier')
                ->where('supplier_id', $supplier_id)
                ->get()
                ->row_array();
        return $res;
    }

    /**
     * 根据用户id获取供货商信息
     * @param type $user_id
     */
    public function getSupplierByUid($user_id) {
        $res = $this->db->select('*')
                ->from('supplier')
                ->where('user_id', $user_id)
                ->get()
                ->row_array();
        return $res;
    }

    /**
     * 更新供货商信息
     * @param type $supplier_id
     */
    public function updateSupplier($supplier_id, $data) {
        return $this->db->where("supplier_id", $supplier_id)->update("supplier", $data);
    }

    /**
     * 供货商结算
     * @param type $supplier_id
     * @param type $cycle 结算周期
     * @return type
     */
    public function supplierSettlement($supplier_id, $cycle) {
        $supplier = $this->getSupplierInfo($supplier_id);
        $ed_time = strtotime('-' . $cycle . ' day');
        $money=0;
        $query = $this->db
                        ->where('supplier_id', $supplier_id)
                        ->where('status > 0')
                        ->where('shippingtime < ' . $ed_time)
                        ->where('supplier_statements=0')
                        ->select('*')->get("order");
        
        $orders = $query->result_array();
        if (!empty($orders)) {
            foreach ($orders as $order) {
                //获取订单商品
                $product_query = $this->db->select("order_product.product_number,order_product.product_price,product.in_price")
                        ->join("product", "product.product_id=order_product.product_id", "left")
                        ->where("order_product.order_id=" . $order['order_id'])
                        ->get("order_product");
                $product = $product_query->result_array();
                //更新订单状态
                $this->db->where("order_id", $order['order_id'])->update("order", array("supplier_statements" => 1));
                $settlement_money = 0;
                foreach ($product as $k => $v) {
                    $settlement_money += $v['in_price'] * $v['product_number'];
                }
                //写入结算日志
                $settle_log = array(
                    "user_id" => $supplier['user_id'],
                    "order_id" => $order['order_id'],
                    "settlement_type" => 0,
                    "remark" => "供货商货款",
                    "settlement_money" => $settlement_money
                );
                $this->db->insert("settlement_log", $settle_log);
                $money += ($settlement_money);
            }
        }
        if (!empty($money)) {//增加用户可提现金额
            $this->db->where("user_id", $supplier['user_id'])->set("settlement_money", "settlement_money+".$money, false)->update("user");
            //写账户变更更日志
            $log_data = array(
                "user_id" => $supplier['user_id'],
                "change_money" => $money,
                "change_cause" => "货款结算",
                "createtime" => time()
            );
            $this->db->insert("user_account_log", $log_data);
        }
        return true;
    }

}
