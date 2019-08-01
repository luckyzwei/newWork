<?php

/**
 * 数据导出模型
 * @package	ZMshop
 * @author		祁大众@hnzhimo.com
 * @copyright	2017 河南知默网络科技有限公司
 * @link		http://www.hnzhimo.com
 * @since		Version 1.0.0
 */
class ExportModel extends CI_Model {

    /**
     * 订单数据
     * @param type $page
     * @param type $limit
     * @param type $filter 过滤条件
     * @return type
     */
    public function getOrderDataList($filter = array()) {
        $this->db->select('o.order_id,o.order_sn')
                ->from('order o')
                ->join('user_wechat', 'user_wechat.user_id=o.user_id', 'left')
                ->join('user u', 'u.user_id=o.user_id', 'left')
                ->where('o.status!=-1 and o.master_order_id=0');


        if (!empty($filter['filter_status'])) {
            $this->db->where("o.status", $filter['filter_status']);
        }

        if (!empty($filter['user_id'])) {
            $this->db->where("o.user_id", $filter['user_id']);
        }

        if (!empty($filter['start_time'])) {
            $start_time = strtotime($filter['start_time']);
            $end_time = $filter['end_time'];
            if (empty($end_time)) {
                $end_time = time();
            } else {
                $end_time = strtotime($end_time);
            }
            $this->db->where("o.createtime between " . $start_time . " and " . $end_time);
        }

        if (!empty($filter['user_name']) && empty($filter['user_id'])) {
            $this->db->group_start();
            $this->db->or_like("o.fullname", $filter['user_name']);
            $this->db->or_like("user_wechat.wx_nickname", $filter['user_name']);
            $this->db->or_like("u.user_name", $filter['user_name']);
            $this->db->group_end();
        }

        $query = $this->db
                ->order_by('o.order_id', 'DESC')
                ->get();
        $result = $query->result_array();

        $orderdata = array();
        foreach ($result as &$res) {
            $orderdata[] = $this->getOrderInfo($res['order_id'], $res['order_sn']);
        }

        return $orderdata;
    }

    /**
     * 根据订单id获取订单信息
     * @param type $ids array
     * @return type
     */
    public function getOrderDataListByids($ids) {
        $query = $this->db->select('o.order_id,o.order_sn')
                ->from('order o')
                ->join('user u', 'u.user_id=o.user_id', 'left')
                ->where('o.status!=-1 and o.master_order_id=0')

                ->where_in("o.order_id", $ids)->order_by('o.order_id', 'DESC')
                ->get();
        $result = $query->result_array();
        $orderdata = array();
        foreach ($result as &$res) {
            $orderdata[] = $this->getOrderInfo($res['order_id'], $res['order_sn']);
        }

        return $orderdata;
    }

    /**
     * 查询出库单的订单列表
     * @param type $ids
     * @return type
     */
    public function getCKOrderDataListByids($ids) {
        $query = $this->db->select('o.order_id,o.order_sn')
                ->from('order o')
                ->join('user u', 'u.user_id=o.user_id', 'left')
                ->where('o.status!=-1 and o.master_order_id=0')
                ->where_in("o.order_id", $ids)->order_by('o.order_id', 'DESC')
                ->get();
        $result = $query->result_array();
        $orderdata = array();
        foreach ($result as &$res) {
            $orderdata[] = $this->getOrderInfo($res['order_id'], $res['order_sn']);
        }

        return $orderdata;
    }

    /**
     * 获取订单详情
     * @param type $order_id
     * @return type
     */
    private function getOrderInfo($order_id, $order_sn = "") {
        $data = array();
        //订单信息
        $orderinfo = $this->db->select('o.*,u.nickname,u.user_name,u.email,c.coupon_name,uw.wx_nickname,uw.wx_headimg')
                ->from('order o')
                ->join('user u', 'u.user_id=o.user_id', 'left')//会员信息
                ->join('user_wechat uw', 'uw.user_id=o.user_id', 'left')//会员信息
                ->join('coupon c', 'c.coupon_id=o.coupon_id', 'left')//红包信息
                ->where('o.order_id=' . $order_id)
                ->get();
        $data['orderinfo'] = $orderinfo->row_array();
        $data['orderinfo']['master_order_sn'] = $order_sn;

        $mproduct_query = $this->db->select('op.*,product.product_sn')
                ->from('order_product op')
                ->join("product", "product.product_id=op.product_id", "left")
                ->where('op.master_order_id=' . $data['orderinfo']['order_id'])
                ->get();
        //查询主订单所有商品
        $data['orderinfo']['products'] = $mproduct_query->result_array();

        $suborders = $this->getSubOrder($order_id);
        foreach ($suborders as &$sorder) {
            $orderproduct = $this->db->select('op.*,product.product_sn')
                    ->from('order_product op')
                    ->join("product", "product.product_id=op.product_id", "left")
                    ->where('op.order_id=' . $sorder['order_id'])
                    ->get();
            $sorder['products'] = $orderproduct->result_array();
            //查询子订单供货商
            $sup_query = $this->db->select("*")->where("supplier_id", $sorder['supplier_id'])->get("supplier");
            $supplier = $sup_query->row_array();
            $sorder['supplier'] = $supplier;
        }

        $data['suborders'] = $suborders;

        $marketing_query = $this->db->select("order_marketing.*,sale_marketing.marketing_name")
                ->join("sale_marketing", "sale_marketing.marketing_id=order_marketing.marketing_id", "left")
                ->where("order_marketing.order_id", $order_id)
                ->get("order_marketing");
        $marketings = $marketing_query->result_array();

        $data['marketings'] = $marketings;


        return $data;
    }

    /**
     * 获取子订单信息
     * @param type $master_order_id
     * @return type
     */
    public function getSubOrder($master_order_id) {
        $res = $this->db
                ->select('o.*,s.name,s.supplier_id,u.user_name,u.nickname')
                ->from('order o')
                ->join('supplier s', 's.supplier_id=o.supplier_id', 'left')
                ->join('user u', 'u.user_id=o.user_id', 'left')
                ->where('o.status!=-1')
                ->where(['o.master_order_id' => $master_order_id])
                ->get()
                ->result_array();
        return $res;
    }

    /*
     * ---------------------------商品---------------------------------------
     */

    public function getProductDatas($filter = array()) {
        $this->db->select('p.updatetime,p.product_id as product_p_pid,p.new,p.hot,p.td_product_code,p.product_upc,'
                        . 'p.product_name,p.store_number,p.short_name,p.weight,p.gross_weight,p.return_point,'
                        . 'p.status,p.createtime,p.images,p.price,p.recommend,p.product_sn')
                ->from('product p')
                ->join("product_declare_extension", "product_declare_extension.product_id=p.product_id", "left");

        if (!empty($filter['filter_name'])) {
            $this->db->like(array('product_name' => $filter['filter_name']));
        }
        
//        if (!empty($filter['cate_id'])) {
//            $this->db->where(array('product_category.category_id' => $filter['cate_id']));
//        }

//        if (!empty($filter['filter_status'])) {
//            $this->db->where(array('status' => $filter['filter_status']));
//        }
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $query = $this->db
                ->order_by("field(p.status,'1','2'),p.product_id desc")
                ->get();

        return array("count" => $rownum, "result" => $query->result_array());
    }

    public function updateOrderStatus($order_id, $status) {
        $this->db->where("order_id", $order_id)->update("order", array("status" => $status));
        //更新所有子订单状态
        $this->db->where("master_order_id", $order_id)->update("order", array("status" => $status));
    }

}
