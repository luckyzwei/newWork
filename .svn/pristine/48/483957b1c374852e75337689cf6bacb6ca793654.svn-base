<?php

/**
 * 首页控制器主要显示首页
 * 
 * @author wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @since	Version 1.0.0
 */
class Index extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("AdvertModel");
        $this->load->model("CategoryModel");
        $this->load->model("couponModel");
        $this->load->model("ProductModel");
        $this->load->model("MarketingModel");
        $this->load->helper('string');
    }

    //分类显示
    public function get_home() {
        $cateLevel = $this->input->post("cateLevel");
        $imageKey = $this->input->post("imageKey");
        $advertKey = $this->input->post("advertKey");
        $data = array();
        $user_id = $this->session->user_id;
        //所有分类
        if ($cateLevel == 1) {
            $parent_id = 0;
        }
        $data["categoryList"] = $this->HandleImage($this->CategoryModel->getCategoryList($parent_id, 8), "image");


        //轮播图
        $data["imageList"] = $this->HandleImage($this->AdvertModel->getAdvert($imageKey), "ad_source");

        //获取所有的广告位
        $data["advertList"] = $this->HandleImage($this->AdvertModel->getAdvert($advertKey), "ad_source");
        foreach ($data["advertList"] as $key => $value) {
            if ($value['ad_url_type'] == 'productList' && $value['ad_url_param']) {
                $filter = array(
                    "category_id" => $value['ad_url_param'],
                    "store_id" => $this->input->post("store_id"),
                    "orderby" => '',
                    "order" => "DESC"
                );
                $data["advertList"][$key]['recommendList'] = $this->getRecommends(1, 10, $filter);
//                var_dump($data["advertList"][$key]['recommendList']);
                
            }
        }
        $data["couponList"] = $this->couponModel->getUsercanRevice($user_id);
        $this->output->set_content_type("json/application")->set_output(json_encode(array('data' => $data, 'error_code' => 0)));
    }

    /**
     * 获取首页商品列表信息
     */
    public function getRecommends($page = 1, $limit = 10, $filter) {

        $filter["user_id"] = $this->session->user_info['user_id'];
        $supplier_id = in_array("supplier_id", $filter) ? $filter["supplier_id"] : '';
        if (!empty($this->session->user_info['store_id'])) {//如果是店主登陆则强制为自己的店铺
            $filter["store_id"] = $this->session->user_info['store_id'];
        }

        if (!in_array($filter["orderby"], array("new", "hot", "sale", "price"))) {
            $filter["orderby"] = "sort";
        }

        if (!in_array($filter["order"], array("ASC", "DESC"))) {
            $filter["order"] = "DESC";
        }
        $json['error_code'] = 0;
        $filter["recommend"] = 1;
        $productList = $this->ProductModel->getRecommendsPL($page, $limit, $filter);

        //获取商品的默认规格和会员价格
        foreach ($productList['list'] as &$product) {
            $default_special = $this->ProductModel->getSpecial($product['product_id']);
            $product['default_special'] = $default_special;
            $user_price = $this->ProductModel->getUserDiscountPrice($filter["user_id"], $product['product_id']);
            //获取限时秒杀信息
            $product["timelimit"] = $this->ProductModel->getTimelimitInfo($product['product_id']);
            $product['user_price'] = $user_price;
            $product['thumb'] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $product['thumb']);
            //判断是否是满减商品

            $product['is_market'] = $this->MarketingModel->checkMarketing($product['product_id']);

            //如果是店铺模式
//            if (!empty($store_id)) {
//                $store_product = $this->storeProductModel->getStoreProductById($product['product_id'], $store_id);
//                if (!empty($store_product)) {
//                    $product['user_price']['user_price'] = $product['user_price']['user_price'] + ($store_product['store_product_price'] - $product['price']);
//                    $product['user_price']['product_price'] = $store_product['store_product_price'];
//                    $product["store_product"] = $store_product;
//                    $product['explain'] = $store_product['store_product_breif'];
//                } else {
//                    $product["store_product"] = null;
//                }
//            }
        }

        if (!empty($supplier_id)) {
            $this->load->model('SupplierModel');
            $supplier = $this->SupplierModel->getSupplierInfo($supplier_id);
            $names = explode('-', $supplier['name']);
            if (count($names) > 1) {
                $supplier['fastname'] = $names[0];
                $supplier['lastname'] = $names[1];
            }
            $supplier['images'] = explode(",", $supplier['images']);
            foreach ($supplier['images'] as $key => $value) {
                $supplier['images'][$key] = reduce_double_slashes($this->systemsetting->get("api_url") . $value);
            }
            $json['supplier'] = $supplier;
        }
        $json['data'] = $productList['list'];
        $json['total'] = $productList['total'];
//        $this->hooks->call_hook("add_product_footprint");
        return $json['data'];
    }

    /**
     * 处理广告图片
     */
    private function HandleImage($data, $field) {
        foreach ($data as $key => $v) {
            if (is_array($v)) {
                $data[$key][$field] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $v[$field]);
            } else {
                $data[$field] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $data[$field]);
                return $data;
            }
        }
        return $data;
    }

}
