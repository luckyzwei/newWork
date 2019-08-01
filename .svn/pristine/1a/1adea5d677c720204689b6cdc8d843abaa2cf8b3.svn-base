<?php

/**
 * 优惠策略数据模型
 */
class MarketingModel extends CI_Model {

    /**
     * 获取商品的优惠政策
     * @param type $product_id
     * @return type
     */
    public function getMarketingsForProduct($product_id) {
        $result = array();
        $query = $this->db->select("*")
                ->where("marketing_type='P' and '" . time() . "' between starttime and endtime")
                ->get("sale_marketing");
        $marketings = $query->result_array();

        foreach ($marketings as $row) {
            //如果有例外分类
            $categorys = array_unique(array_filter(explode("|", $row['marketing_category'])));
            $products = array_unique(array_filter(explode("|", $row['marketing_product'])));
            $products = !empty($products) ? $products : array();
            if (!empty($categorys)) {
                $productidcate = $this->productIncategory($categorys);

                //如果例外分类，又不在允许商品
                if ($row['category_applyorno'] == 0 && in_array($product_id, $productidcate)) {
                    if ($row['product_applyorno'] == 1 && !in_array($product_id, $products)) {
                        continue;
                    }
                }
                //如果商品在允许分类，但是也在例外商品
                if ($row['category_applyorno'] == 1 && !in_array($product_id, $productidcate)) {
                    if ($row['product_applyorno'] == 0 && in_array($product_id, $products)) {
                        continue;
                    }
                }
            } else {
                if ($row['product_applyorno'] == 1 && !in_array($product_id, $products)) {
                    continue;
                }
                if ($row['product_applyorno'] == 0 && in_array($product_id, $products)) {
                    continue;
                }
            }

            $result[] = $row;
        }

        return $result;
    }

    /**
     * 获取购物车中商品结算可以享受的订单优惠政策
     * @param type $cart_products
     * @return type
     */
    public function getMarketingsForCheckout($cart_products, $coupon_id = 0) {
        $result = array();

        //过滤掉所有的限时折扣和团购商品
        foreach ($cart_products as $key => &$cps) {
            if ($cps['product_type'] != "O") {
                unset($cart_products[$key]);
            }
        }

        if (!empty($cart_products)) {

            //能够享受的订单策略
            $ordermarketings = $this->getCanuseOrderMarketings($cart_products, $coupon_id);

            //能够享受的商品策略
            $productmarketings = $this->getCanuseProductMarketings($cart_products);

            $result = array_merge($ordermarketings, $productmarketings);
        }

        return $result;
    }

    /**
     * 获取结算商品能够享受的优惠策略
     * @param type $cart_products
     * @return type
     */
    public function getCanuseProductMarketings($cart_products) {
        $result = array();

        foreach ($cart_products as $product) {
            $res = $this->getMarketingsForProduct($product['product_id']);

            foreach ($res as $re) {
                if ($product['product_number'] >= $re['marketing_trigger_number']) {
                    $result[] = $re;
                }
            }
        }
        //同组策略留一个最大的
        $nogroup = array();
        $temp = array();
        $hasgroup = array();

        foreach ($result as $res) {
            if ($res['marketing_group'] != "") {
                $temp[$res['marketing_group']][] = $res;
            } else {
                $nogroup[] = $res;
            }
        }
        foreach ($temp as $t) {
            $trigger_number = array();
            foreach ($t as $k => $st) {
                $trigger_number[$k] = $st['marketing_trigger_number'];
            }
            array_multisort($trigger_number, SORT_DESC, $t);
            $hasgroup[] = $t[0];
        }


        return array_merge($hasgroup, $nogroup);
    }

    /**
     * 获取结算订单能够享受的优惠策略
     * @param type $cart_products
     * @return type
     */
    public function getCanuseOrderMarketings($cart_products, $coupon_id = 0) {

        $products = $cart_products;
        $result = array();
        $query = $this->db->select("*")
                ->where("marketing_type='O' and '" . time() . "' between starttime and endtime")
                ->get("sale_marketing");

        $marketings = $query->result_array();

        foreach ($marketings as $row) {

            $categorys = array_unique(array_filter(explode("|", $row['marketing_category'])));
            $productidcate = array();
            if (!empty($categorys)) {
                $productidcate = $this->productIncategory($categorys);
            }

            $marketing_products = array_unique(array_filter(explode("|", $row['marketing_product'])));
            $tempProducts = $products;

            foreach ($tempProducts as $k => $cproduct) {
                if ($cproduct['product_type'] != 'O') {
                    unset($tempProducts[$k]);
                }
                if (!empty($categorys)) {//策略分类已定义
                    if ($row['category_applyorno'] == 0 && in_array($cproduct['product_id'], $productidcate)) {//商品在例外分类中
                        if ($row['product_applyorno'] == 1 && !in_array($cproduct['product_id'], $marketing_products)) {//不在适用商品中
                            unset($tempProducts[$k]);
                        }
                        if ($row['product_applyorno'] == 0 && in_array($cproduct['product_id'], $marketing_products)) {//在例外商品
                            unset($tempProducts[$k]);
                        }
                    }
                    if ($row['category_applyorno'] == 1 && !in_array($cproduct['product_id'], $productidcate)) {//商品不在适用分类
                        if ($row['product_applyorno'] == 1 && !in_array($cproduct['product_id'], $marketing_products)) {//不在适用商品中
                            unset($tempProducts[$k]);
                        }

                        if ($row['product_applyorno'] == 0 && in_array($cproduct['product_id'], $marketing_products)) {//在例外商品
                            unset($tempProducts[$k]);
                        }
                    }
                }
                if (!empty($marketing_products)) { //策略分类未定义
                    if ($row['product_applyorno'] == 1 && !in_array($cproduct['product_id'], $marketing_products)) {
                        unset($tempProducts[$k]);
                    }
                    if ($row['product_applyorno'] == 0 && in_array($cproduct['product_id'], $marketing_products)) {

                        unset($tempProducts[$k]);
                    }

                    $productMarketing = $this->getMarketingsForProduct($cproduct['product_id']);
                    if (!empty($productMarketing)) {//所有商品优惠策略不并行订单策略
                        unset($tempProducts[$k]);
                    }
                }
                //重新计算商品价格
                $total = 0;
                foreach ($tempProducts as $tp) {
                    $total += $tp['product_price'] * $tp['product_number'];
                }
            }

            if ($total >= $row['marketing_trigger_price']) {
                $result[] = $row;
            }
        }

        //同组策略只留一个最大的
        $nogroup = array();
        $temp = array();
        $hasgroup = array();
        foreach ($result as $res) {
            if ($res['marketing_group'] != "") {
                $temp[$res['marketing_group']][] = $res;
            } else {
                $nogroup[] = $res;
            }
        }


        foreach ($temp as $t) {
            $triggerprice = array();
            foreach ($t as $k => $st) {
                $triggerprice[$k] = $st['marketing_trigger_price'];
            }
            array_multisort($triggerprice, SORT_DESC, $t);
            $hasgroup[] = $t[0];
        }
        $resultgroup = array_merge($hasgroup, $nogroup);
        //var_dump($resultgroup);
        return $resultgroup;
    }

    /**
     * 购物车商品订单优惠活动提醒
     * @param type $cart_products
     * @return type
     */
    public function getMarketingsForcart($cart_products, $coupon_id = 0) {
        if (empty($cart_products)) {
            return array();
        }


        $result = array();
        $query = $this->db->select("*")
                ->where("marketing_type='O' and '" . time() . "' between starttime and endtime")
                ->get("sale_marketing");
        $marketings = $query->result_array();

        foreach ($marketings as $row) {
            $tempProducts = $cart_products;
            $categorys = array_unique(array_filter(explode("|", $row['marketing_category'])));
            $productidcate = array();
            if (!empty($categorys)) {
                $productidcate = $this->productIncategory($categorys);
            }
            $marketing_products = array_unique(array_filter(explode("|", $row['marketing_product'])));
            foreach ($tempProducts as $k => $cproduct) {
                if ($cproduct['product_type'] != 'O') {
                    unset($tempProducts[$k]);
                }
                if (!empty($categorys)) {//策略分类已定义
                    if ($row['category_applyorno'] == 0 && in_array($cproduct['product_id'], $productidcate)) {//商品在例外分类中
                        if ($row['product_applyorno'] == 1 && !in_array($cproduct['product_id'], $marketing_products)) {//不在适用商品中
                            unset($tempProducts[$k]);
                        }
                        if ($row['product_applyorno'] == 0 && in_array($cproduct['product_id'], $marketing_products)) {//在例外商品
                            unset($tempProducts[$k]);
                        }
                    }
                    if ($row['category_applyorno'] == 1 && !in_array($cproduct['product_id'], $productidcate)) {//商品不在适用分类
                        if ($row['product_applyorno'] == 1 && !in_array($cproduct['product_id'], $marketing_products)) {//不在适用商品中
                            unset($tempProducts[$k]);
                        }

                        if ($row['product_applyorno'] == 0 && in_array($cproduct['product_id'], $marketing_products)) {//在例外商品
                            unset($tempProducts[$k]);
                        }
                    }
                }

                if (!empty($marketing_products)) {
                    if ($row['product_applyorno'] == 0 && in_array($cproduct['product_id'], $marketing_products)) {
                        unset($tempProducts[$k]);
                    }
                    if ($row['product_applyorno'] == 1 && !in_array($cproduct['product_id'], $marketing_products)) {
                        unset($tempProducts[$k]);
                    }
                }
                $productMarketing = $this->getMarketingsForProduct($cproduct['product_id']);
                if (!empty($productMarketing)) {//所有商品优惠策略不并行订单策略
                    unset($tempProducts[$k]);
                }
            }
            //重新计算商品价格
            $total = 0;
            foreach ($tempProducts as $tp) {
                $total += $tp['product_price'] * $tp['product_number'];
            }
            $row['total'] = $total;

            $result[] = $row;
        }

        //同组策略只留一个最接近的
        $nogroup = array();
        $temp = array();
        $hasgroup = array();
        foreach ($result as $res) {
            if ($res['marketing_group'] != "") {
                $temp[$res['marketing_group']][] = $res;
            } else {
                $nogroup[] = $res;
            }
        }

        foreach ($temp as &$t) {
            $triggerprice = array();
            foreach ($t as $k => $st) {
                $triggerprice[$k] = $st['marketing_trigger_price'];
            }
            array_multisort($triggerprice, SORT_DESC, $t);
        }

        $result = array();

        foreach ($temp as $key => $marktemp) {
            $i = 0;
            $index = 0;
            foreach ($marktemp as $mp) {
                if ($mp['marketing_trigger_price'] <= $mp['total']) {
                    $index = $i;
                    break;
                }
                $i++;
            }
            $result[] = $temp[$key][$index];
        }
        $result = array_merge($result, $nogroup);
        foreach ($result as &$s) {
            $diff = $s['marketing_trigger_price'] - $s['total'];
            if ($diff > 0) {
                $s['cartDesc'] = "还差 ￥" . $diff . "元 就可以享受" . $s['marketing_name'];
                $s['status'] = false;
            } else {
                $s['cartDesc'] = "已享受" . $s['marketing_name'];
                $s['status'] = true;
            }
        }

        return $result;
    }

    /**
     * 获取所有优惠政策
     */
    public function getMarketingOrder() {
        $query = $this->db->select("*")
                ->where("marketing_type='O' and '" . time() . "' between starttime and endtime")
                ->get("sale_marketing");
        return $query->result_array();
    }

    /**
     * 分类下的所有商品id
     * @param type $categorys
     * @return type
     */
    private function productIncategory($categorys) {
        $ids = array();
        $query = $this->db->select("*")
                ->where_in("category_id", $categorys)
                ->get("product_category");

        foreach ($query->result_array() as $row) {
            $ids[] = $row['product_id'];
        }
        return $ids;
    }

    /**
     * 获取订单所用的优惠策略
     */
    public function getOrderMarketings($order_id) {
        $marketing_query = $this->db->select("order_marketing.*,sale_marketing.marketing_name")
                ->join("sale_marketing", "sale_marketing.marketing_id=order_marketing.marketing_id", "left")
                ->where("order_marketing.order_id", $order_id)
                ->get("order_marketing");
        $marketings = $marketing_query->result_array();
        return $marketings;
    }

    /**
     * 获取所有策略列表
     */
    public function checkMarketing($product_id) {
        //获取商品的分类数据
        $product_market = array();
        $goods_cates = $this->getProductCates($product_id);
        $marketing = $this->db->select('*')
                ->from('sale_marketing')
                ->where(time() . " between starttime and endtime")
                ->order_by('marketing_id desc')
                ->get()
                ->result_array();
        $product_market['is_market'] = 0;
        foreach ($marketing as $key => $value) {
            $cate_sale = 0;
            $market_cates = explode('|', $value['marketing_category']);
            $market_products = explode('|', $value['marketing_product']);
            foreach ($goods_cates as $k => $v) {
                if (in_array($v['category_id'], $market_cates) && $value['category_applyorno'] == 1) {
                    $cate_sale = 1;
                }
            }
            if ($cate_sale == 1) {
                $product_market['is_market'] = 1;
                $product_market['market_info'][] = $value;
            } elseif (in_array($product_id, $market_products) && $value['product_applyorno'] == 1) {
                $product_market['is_market'] = 1;
                $product_market['market_info'][] = $value;
            }
        }
        return $product_market;
    }

    public function getProductCates($product_id) {
        $this->db->select('*')
                ->where('product_id=' . $product_id)
                ->from('product_category');

        $query = $this->db->get();

        return $query->result_array();
    }

}
