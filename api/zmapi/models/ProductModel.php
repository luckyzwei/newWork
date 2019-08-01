<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 商品数据模型
 */
class ProductModel extends CI_Model {

    public function getProductInfo($product_id) {
        $query = $this->db->select('*,price as product_price')
                ->from('product')
                ->where('product_id = ' . $product_id . " and status!=-1")
                ->get();
        return $query->row_array();
    }

    /**
     * 
     * @param type $page
     * @param type $limit
     * @param type $category
     * @param type $keywords
     * @param type $orderby
     * @param type $order
     * @param type $supplier_id
     * @param type $diytype 衣生贰专用值 借用原 积分比例字段 ratio_intergal 
     * @return type
     */
    public function getProductList($page = 1, $limit = 20, $category = 0, $keywords = "", $orderby = 'sort', $order = 'DESC', $supplier_id = 0, $diytype = '') {

        if ($category) {//查出所有子分类和孙子分类@todo目前系统支持三级分类
            $suncArray = array();
            $sub_catgory = $this->db->get_where("category", array("parent_id" => $category))->result_array();
            foreach ($sub_catgory as $sa) {
                $suncArray[] = $sa['category_id'];
            }
            $grandsonArry = array();
            if (!empty($suncArray)) {
                $grandson_category = $this->db->where_in("parent_id", $suncArray)->get("category")->result_array();
                foreach ($grandson_category as $gca) {
                    $grandsonArry[] = $gca['category'];
                }
            }
            $categorys[] = $category;
            $category = array_merge($categorys, $suncArray, $grandsonArry);
            $this->db->where_in("pc.category_id", $category);
        }

        if ($keywords) {
            $this->db->like("p.product_name", $keywords, "both");
        }
        if ($supplier_id) {
            $this->db->where("p.supplier_id", $supplier_id);
        }
        if ($diytype) {
            $this->db->where("p.ratio_intergal", $diytype);
        }
        $this->db->select('p.thumb,p.product_id,p.product_name,p.store_number,p.status,p.explain,p.price,p.market_price,pd.sale_number,pd.incart_number,pd.click_number,pd.like_number')
                ->from('product p')
                ->where('p.status != -1 and p.status!=2')
                ->group_by("p.product_id");

        $this->db->join('product_dynamics pd', 'pd.product_id = p.product_id', 'left')
                ->join('product_category pc', 'pc.product_id = p.product_id', 'left')
                ->order_by("p." . $orderby, $order)
                ->order_by('p.sort', 'DESC');

        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();

        $query = $this->db->limit($limit, ($page - 1) * $limit)->get();
        $products = $query->result_array();
//        var_dump($this->db->last_query());exit;
        $result = array("total" => $rownum, "list" => $products);
        return $result;
    }

    //商品数组快捷查询
    public function getPList($where, $file = '*') {
        $query = $this->db->select($file)
                ->from('product')
                ->where($where)
                ->get();
        return $query->result_array();
    }

    public function getRecommends($num = 0) {
        $this->db->select("product_id,product_name,price,explain,short_name,thumb")
                ->where("recommend=1 and status!=-1");
        if ($num) {
            $this->db->limit($num, 0);
        }
        $query = $this->db->get("product");
        return $query->result_array();
    }

    public function getAgentCommission($user_id, $product_id) {
        $query = $this->db->select("agent_group.*,agent.*,agent_group.commission_rate as commission_rate")
                ->join("agent_group", "agent_group.agent_group_id=agent.agent_group_id", "left")
                ->where(array("user_id" => $user_id))
                ->get("agent");

        $agent = $query->row_array();
        $rate = 0;
        if (!empty($agent)) {
            $product = $this->getProductInfo($product_id);
            if (!empty($product['agent_commission'])) {
                $product_agent_commission = @unserialize($product['agent_commission']);
                foreach ($product_agent_commission as $pc) {
                    if ($pc['agent_group_id'] == $agent['agent_group_id']) {
                        $rate = $pc['agent_commission'][0];
                    }
                }
            }

            if ($rate == 0) {
                $commission_rate = unserialize($agent['commission_rate']);
                $rate = $commission_rate[0];
            }
            if ($rate >= 1) {
                $commission = $rate;
            } else {
                $commission = $product['product_price'] * $rate;
            }
        } else {
            $commission = false;
        }
        return $commission;
    }

    /**
     * 获取登陆用户的商品价格和商品的实际价格
     */
    public function getUserDiscountPrice($user_id, $product_id, $special_id = 0) {

        $special_price = 0;
        //规格
        $default_special = $this->getSpecial($product_id, $special_id);
        if (!empty($default_special) && is_array($default_special)) {
            $special_price = $default_special['goods_plus_price'];
        }

        $product = $this->getProductInfo($product_id);
        if ($special_price > 0) {//如果有规格价格按照规格价格
            $product_price = $product['product_price'] + $special_price;
        } else {
            $product_price = $product['product_price'];
        }
        $goods_source_price = $product_price;
        $query = $this->db->select("user_group.*")
                ->join("user_group", "user_group.user_group_id=user.user_group_id")
                ->where("user.user_id", $user_id)
                ->get("user");
        $user_group = $query->row_array();

        $discount = "";
        if (!empty($user_group)) {
            //商品分组设置
            if (!empty($product['user_group_discount'])) {
                $p_discount = @unserialize($product['user_group_discount']);
                foreach ($p_discount as $pdis) {
                    if ($pdis['user_group_id'] == $user_group['user_group_id']) {
                        $discount = $pdis['discount'];
                    }
                }
            }
            if ($discount === "") {//用户分组设置
                $discount = $user_group['user_group_discount'];
            }
        }

        if ($discount !== "") {
            if ($discount >= 1) {
                $product_price -= $discount;
            } elseif ($discount > 0) {
                $product_price = $product_price * $discount;
            }
        }

        $return = array("product_price" => $goods_source_price, "user_price" => $product_price);
        return $return;
    }

    /**
     * 获取商品规格和属性
     * @param type $product_id
     * @return type
     */
    public function getAttrAndSpecial($product_id) {
        $query = $this->db->get_where("product_special", array("product_id" => $product_id));
        $special = $query->row_array();
        $result = array();
        if (!empty($special)) {
            if (!empty($special['attributes'])) {
                $result['attributes'] = @unserialize($special['attributes']);
            }
            if (!empty($special['special_struct'])) {
                $result['special_struct'] = @json_decode($special['special_struct'], true);
                $result['specifications'] = @unserialize($special['specifications']);
                foreach ($result['specifications'] as $key => &$sp) {
                    if ($sp['hidenChk'] == "1") {
                        $temp = explode("_", $sp['goods_code']);
                        $result["hidden"][] = $temp[1]; //需要隐藏的规格选项
                    }
                    //获取规格名字
                    $indexArray = explode("-", str_replace("goods_", "", $sp['goods_code']));
                    $structArray = $result['special_struct'];
                    $special_name = array();
                    foreach ($indexArray as $key => $index) {
                        $special_name[] = $structArray[$key]["special_name"] . ":" . $structArray[$key]['specification'][$index];
                    }
                    $sp['goods_special_name'] = implode("+", $special_name);
                    if ($sp['hidenChk'] == "0" && empty($result['default'])) {
                        $result['default'] = $indexArray; //默认规格索引
                    }
                }
            }
        }
        return $result;
    }

    public function getSpecial($product_id, $goods_code = 0) {
        $specifications = $this->getAttrAndSpecial($product_id);
        $result = array();
        if (!empty($specifications['special_struct'])) {
            $special = $specifications['specifications'];
            if ($goods_code) {
                foreach ($special as $sp) {
                    if ($sp['goods_code'] == "goods_" . $goods_code) {
                        $result = $sp;
                        break;
                    }
                }
            } else {
                if (empty($result)) {
                    foreach ($special as $sp) {
                        if ($sp['hidenChk'] == "0") {
                            $result = $sp;
                            break;
                        }
                    }
                }
            }
        }
        return $result;
    }

    /**
     * 获取猜你喜欢商品
     * zu   2018/8/17
     */
    public function getUserLikeProducts($user_id, $limit, $orderby, $order) {
        $res = $this->db->select('p.thumb,p.product_id,p.product_name,p.store_number,p.status,p.explain,p.price,pd.sale_number,pd.incart_number,pd.click_number,pd.like_number')
                ->from('order o')
                ->join('order_product op', 'op.order_id=o.order_id')
                ->join('product_link pl', 'pl.product_id=op.product_id')
                ->join('product p', 'p.product_id=pl.link_product_id')
                ->join('product_dynamics pd', 'pd.product_id = p.product_id', 'left')
                ->where('o.user_id', $user_id)
                ->group_by('p.product_id')
                ->order_by("p." . $orderby, $order)
                ->limit($limit)
                ->get()
                ->result_array();
        return $res;
    }

    /**
     * 获取商品的关联商品
     * zu   2018/8/17
     * 需要的数据，product_id,
     */
    public function getLinkProducts($product_id, $limit = 10) {
        $query = $this->db->select('p.thumb,p.product_id,p.product_name,p.store_number,p.status,p.explain,p.price')
                ->from('product_link pl')
                ->join('product p', 'p.product_id = pl.link_product_id', 'left')
                ->where('p.status != -1 ')
                ->where_in('pl.product_id', $product_id)
                ->limit($limit)
                ->get();
        return $query->result_array();
    }

    /**
     * 获取标签商品
     * zu   2018/8/17
     * 需要的数据有，tagid，
     */
    public function getProductInfoByTagId($product_tag_id, $limit, $page, $orderby, $order) {
        return $this->db->select('p.thumb,p.product_id,p.product_name,p.store_number,p.status,p.explain,p.price,pd.sale_number,pd.incart_number,pd.click_number,pd.like_number')
                        ->from('product p')
                        ->join('product_tag pt', 'pt.product_id=p.product_id')
                        ->join('product_dynamics pd', 'pd.product_id = p.product_id', 'left')
                        ->where('p.status != -1 ')
                        ->where('pt.tag_id', $product_tag_id)
                        ->group_by("p.product_id")
                        ->order_by("p." . $orderby, $order)
                        ->limit($limit, ($page - 1) * $limit)
                        ->get()
                        ->result_array();
    }

    /*
     * 获取用户收藏商品
     * zu   2018/8/20
     * 需要的数据    user_id
     */

    public function getCollectProduct($user_id, $limit = 10, $page = 1) {
        $query = $this->db->select('p.thumb,p.product_id,p.product_name,p.store_number,p.status,p.explain,p.price')
                ->from('user_collect c')
                ->join('product p', 'c.product_id=p.product_id', 'left')
                ->where('c.user_id', $user_id)
                ->where('p.status != -1 ')
                ->limit($limit, ($page - 1) * $limit)
                ->get();
        return $query->result_array();
    }

    /*
     * 收藏、取消收藏商品
     * zu   2018/8/20
     * 需要的数据    user_id product_id type(add/del);
     */

    public function collectProduct($user_id, $product_id, $type = '') {
        if ($type == 'add') {
            //查询是否已收藏
            $collect = $this->db
                    ->from('user_collect')
                    ->where(array('product_id' => $product_id, 'user_id' => $user_id))
                    ->get()
                    ->row_array();
            if (empty($collect)) {
                $data = [
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'createtime' => time()
                ];
                $res = $this->db->insert('user_collect', $data);
                $this->db->set('collect_number', 'collect_number+1', FALSE)->where('product_id = ' . $product_id)->update('product');
            }
            $res = 'exist';
        } elseif ($type == 'del') {
            $res = $this->db->where(array('product_id' => $product_id, 'user_id' => $user_id))
                    ->delete('user_collect');
            $this->db->set('collect_number', 'collect_number-1', FALSE)->where('product_id = ' . $product_id)->update('product');
        } else {
            //如果type为其他或者无，返回用户对此商品的收藏状态
            $res = $this->db->from('user_collect')
                    ->where(array('product_id' => $product_id, 'user_id' => $user_id))
                    ->get()
                    ->row_array();
        }
        return $res;
    }

    /**
     * 计算商品分销可以获取的佣金
     * @param type $product_id
     * @param type $user_id
     */
    public function calculateProductReward($product_id, $user_id) {

        $user_reward = 0;
        //当前用户的代理分组
        $query = $this->db->select("agent_group.*,agent.user_id")
                ->where("agent.user_id", $user_id)
                ->join("agent_group", "agent_group.agent_group_id=agent.agent_group_id", "left")
                ->get("agent");
        $userAgent = $query->row_array();
        if (!empty($userAgent)) {
            $productAgentSet = array();
            $query = $this->db->select("*")->where("product_id", $product_id)->get("product");
            $product = $query->row_array();
            if (!empty($product['agent_commission'])) {
                $productAgentSet = unserialize($product['agent_commission']);
                foreach ($productAgentSet as $pas) {
                    if ($pas['agent_group_id'] == $userAgent['agent_group_id']) {
                        $proAset = $pas;
                    }
                }
            }
            //商品的分销佣金设置
            if (!empty($proAset)) {
                if ($proAset['agent_commission'][0] > 1) {
                    $user_reward = $proAset['agent_commission'][0];
                } elseif ($proAset['agent_commission'][0] >= 0 && $proAset['agent_commission'][0] < 1) {
                    $user_reward = $proAset['agent_commission'][0] * $product['price'];
                }
            } else {
                $user_agent = unserialize($userAgent['commission_rate']);
                if ($user_agent[0] > 1) {
                    $user_reward = $user_agent[0];
                } elseif ($user_agent[0] >= 0 && $user_agent[0] < 1) {
                    $user_reward = $user_agent[0] * $product['price'];
                }
            }
            //如果是店铺销售加上产品差价
            $store_product_query = $this->db->select("*")->where("product_id", $product_id)->where("user_id", $user_id)->get("store_product");
            $store_product = $store_product_query->row_array();
            if (!empty($store_product)) {
                $user_reward = $user_reward + ($store_product['store_product_price'] - $product['price']);
            }
        }
        return $user_reward;
    }

    function getTimelimitProducts($page = 1, $limit = 20, $category = 0, $keywords = "", $orderby = 'sort', $order = 'DESC', $supplier_id = 0, $diytype = '') {
        if ($category) {//查出所有子分类和孙子分类@todo目前系统支持三级分类
            $suncArray = array();
            $sub_catgory = $this->db->get_where("category", array("parent_id" => $category))->result_array();
            foreach ($sub_catgory as $sa) {
                $suncArray[] = $sa['category_id'];
            }
            $grandsonArry = array();
            if (!empty($suncArray)) {
                $grandson_category = $this->db->where_in("parent_id", $suncArray)->get("category")->result_array();
                foreach ($grandson_category as $gca) {
                    $grandsonArry[] = $gca['category'];
                }
            }
            $categorys[] = $category;
            $category = array_merge($categorys, $suncArray, $grandsonArry);
            $this->db->where_in("pc.category_id", $category);
        }

        $this->db->select('p.thumb,p.product_id,p.product_name,p.store_number,p.status,p.explain,p.price,p.market_price,pd.sale_number,pd.incart_number,pd.click_number,pd.like_number, tp.timelimit_price, tp.starttime, tp.endtime, tp.timelimit_product_name, tp.timelimit_description')
                ->from('timelimit_product tp')
                ->join('product p', 'tp.product_id = p.product_id', 'left')
                ->where('p.status != -1 and p.status!=2 and tp.starttime<' . time() . ' and tp.endtime>' . time())
                ->group_by("tp.product_id");

        $this->db->join('product_dynamics pd', 'pd.product_id = tp.product_id', 'left')
                ->join('product_category pc', 'pc.product_id = tp.product_id', 'left')
                ->order_by("p." . $orderby, $order)
                ->order_by('p.sort', 'DESC');

        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();

        $query = $this->db->limit($limit, ($page - 1) * $limit)->get();
        $products = $query->result_array();
//        echo $this->db->last_query();exit;
        $result = array("total" => $rownum, "list" => $products);
        return $result;
    }

    function getTimelimitInfo($product_id) {
        $time = time();
        $result = $this->db->select('*')
                ->from('timelimit_product')
                ->where(array('product_id' => $product_id))
                ->where('starttime<' . $time . ' and endtime >' . $time)
                ->get()
                ->row_array();
        return $result;
    }

    function addProductData($product_id, $type = 1) {
        switch ($type) {
            case 1:
                $field = "click_number";
                $up = "click_number+1";

                break;
            case 2:
                $field = "sale_number";
                $up = "sale_number+1";

                break;
            case 3:
                $field = "incart_number";
                $up = "incart_number+1";

                break;
            default:
                break;
        }
        if ($this->db->set($field, $up, FALSE)->where('product_id = ' . $product_id)->update('product_dynamics')) {
            return true;
        } else {
            return flase;
        }
    }

    public function getRecommendsPL($page = 1, $limit = 20, $filter) {
//          var_dump($filter);
        if (key_exists("category_id", $filter)) {//查出所有子分类和孙子分类@todo目前系统支持三级分类
            $suncArray = array();
            $sub_catgory = $this->db->get_where("category", array("parent_id" => $filter["category_id"]))->result_array();
            foreach ($sub_catgory as $sa) {
                $suncArray[] = $sa['category_id'];
            }
            $grandsonArry = array();
            if (!empty($suncArray)) {
                $grandson_category = $this->db->where_in("parent_id", $suncArray)->get("category")->result_array();
                foreach ($grandson_category as $gca) {
                    $grandsonArry[] = $gca['category'];
                }
            }
            $categorys[] = $filter["category_id"];
            $category = array_merge($categorys, $suncArray, $grandsonArry);
            $this->db->where_in("pc.category_id", $category);
        }
        if (key_exists("recommend", $filter)) {
            $this->db->where("p.recommend", $filter["recommend"]);
        }

        if (key_exists("keywords", $filter)) {
            $this->db->like("p.product_name", $filter["keywords"], "both");
        }
        if (key_exists("supplier_id", $filter)) {
            $this->db->where("p.supplier_id", $filter["supplier_id"]);
        }
        if (key_exists("diytype", $filter)) {
            $this->db->where("p.ratio_intergal", $filter["diytype"]);
        }
        $this->db->select('p.thumb,p.product_id,p.product_name,p.store_number,p.status,p.explain,p.price,p.market_price,pd.sale_number,pd.incart_number,pd.click_number,pd.like_number')
                ->from('product p')
                ->where('p.status != -1 and p.status!=2')
                ->group_by("p.product_id");

        $this->db->join('product_dynamics pd', 'pd.product_id = p.product_id', 'left')
                ->join('product_category pc', 'pc.product_id = p.product_id', 'left')
                ->order_by("p." . $filter["orderby"], $filter["order"])
                ->order_by('p.sort', 'DESC');

        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();

        $query = $this->db->limit($limit, ($page - 1) * $limit)->get();
        $products = $query->result_array();
//        var_dump($this->db->last_query());
        $result = array("total" => $rownum, "list" => $products);
        return $result;
    }

    function getReduceProducts($page = 1, $limit = 20, $category = 0, $keywords = "", $orderby = 'sort', $order = 'DESC', $supplier_id = 0, $diytype = '') {


        $marcket_list = $this->db->select('*')
                ->from('sale_marketing')
                ->where(time() . " between starttime and endtime")
                ->where("marketing_type", "O")
                ->order_by('marketing_id desc')
                ->get()
                ->result_array();
        $market_cates = array();
        $market_products = array();
        foreach ($marcket_list as $key => $value) {

            if ($value['marketing_category'] && $value['category_applyorno'] == 1) {
                $cates = explode('|', $value['marketing_category']);
                $market_cates = array_merge($market_cates, $cates);
            }
            if ($value['marketing_product'] && $value['product_applyorno'] == 1) {
                $products = explode('|', $value['marketing_product']);
                $market_products = array_merge($market_products, $products);
            }
        }
        if ($market_cates) {
            $this->db->where_in("pc.category_id", $market_cates);
        }
        if ($market_products) {
            $this->db->or_where_in("p.product_id", $market_products);
        }

        $this->db->select('p.thumb,p.product_id,p.product_name,p.store_number,p.status,p.explain,p.price,p.market_price,pd.sale_number,pd.incart_number,pd.click_number,pd.like_number')
                ->from('product p')
                ->where('p.status != -1 and p.status!=2')
                ->group_by("p.product_id");

        $this->db->join('product_dynamics pd', 'pd.product_id = p.product_id', 'left')
                ->join('product_category pc', 'pc.product_id = p.product_id', 'left')
                ->order_by("p." . $orderby, $order)
                ->order_by('p.sort', 'DESC');

        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();

        $query = $this->db->limit($limit, ($page - 1) * $limit)->get();
        $products = $query->result_array();
//        var_dump($this->db->last_query());exit;
        $result = array("total" => $rownum, "list" => $products);
        return $result;
    }

}
