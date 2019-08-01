<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 商品管管理
 * 
 * @package	ZMshop
 * @author	wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //当前控制器会使用到的加载
        $this->load->helper('url');
        $this->load->model("ProductModel");
        $this->load->library("pagination");
        $this->load->library('form_validation');
        $this->load->model("RoleModel");
        $this->load->helper('string');
    }

    //显示首页列表
    public function index() {
        $page = $this->input->get('per_page') ? $this->input->get('per_page') : 1;
        //需要返回给view的数据
        $data = array();
        $data['error'] = $this->input->get('error');
        $data['success'] = $this->input->get('success');
        $selectdata['filter_name'] = $this->input->get_post("filter_name");
        $selectdata['filter_price'] = $this->input->get_post("filter_price");
        $selectdata['filter_num'] = $this->input->get_post("filter_num");
        $selectdata['filter_status'] = $this->input->get_post("filter_status");
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 20;
        $productdata = $this->ProductModel->getProductList($page, $limit, $selectdata);
        $config['base_url'] = site_url('Product/index'); //当前分页地址
        $config['total_rows'] = $productdata['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $config['cur_page'] = $page;
        $this->pagination->initialize($config);
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $productdata['result'];
        $data['page'] = $page;
        $data['count'] = $productdata['count'];
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('product', $data);
    }

    /**
     * 添加商品
     */
    public function addProduct() {
        $postdata = array();
        if ($this->input->method() == 'post') {
            $postdata = $this->input->post();
            $rules = $this->valiRules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_rules('category_id','商品分类',array($this->cate()));
            if ($this->form_validation->run()) {
                //整理数据
                $productFiled = array(
                    "apply_intergal", "ratio_intergal",
                    "give_intergal", "sale", "hot",
                    "new", "sort", "product_sn",
                    "product_name", "short_name",
                    "description", "explain", "supplier_id",
                    "store_number", "check_store",
                    "status", "price","intergral_deduce",
                    "market_price",
                    "in_price",
                    "videos",
                    "product_images",
                    "weight");
                $productData = elements($productFiled, $this->input->post());
                $mkimages = $this->mkProductImages();
                $productData['product_sn'] = $this->mkProductSN($productData['product_sn']);
                $productData['thumb'] = reduce_double_slashes($mkimages['thumb']);
                $productData['images'] = $mkimages['images'];
                $productData['createtime'] = time();
                $productData['updatetime'] = time();
                unset($productData['product_images']);

                $productData['agent_commission'] = $this->mkAgents();
                $productData['user_group_discount'] = $this->mkUserDiscount();
                //商品扩展数据
                $productCategory = $this->mkCategroies();
                $productTags = $this->mkTags();
                $productLinks = $this->mkLinks();
                $productSpecial = $this->mkAttrAndSpecial();

                $ext_data = array(
                    "categories" => $productCategory,
                    "productTags" => $productTags,
                    "productLinks" => $productLinks,
                    "productSpecial" => $productSpecial
                );
                $this->ProductModel->addProduct($productData, $ext_data);
                $this->session->set_flashdata('success', '新增商品成功');
                redirect(site_url("product/index"));
            } else {
                $this->session->set_flashdata('error', $this->form_validation->error_string());
            }
        }
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        //获取会员分组和分销商分组
        $this->load->model('UserGroupModel');
        $this->load->model('AgentGroupModel');
        $usergrouplist = $this->UserGroupModel->getUserGroupList();
        $agentgrouplist = $this->AgentGroupModel->getAgentGroupList();
        $data['usergrouplist'] = $usergrouplist['result'];
        $data['agentgrouplist'] = $agentgrouplist['result'];
        //----获取商品模型-------
        $this->load->model("commodityTypModel");
        $data['commodityTyps'] = $this->commodityTypModel->getCommodityTyps();
        //----获取供货商---------
        $this->load->model("supplierModel");
        $data['suppliers'] = $this->supplierModel->getSuppliers();

        $data = array_merge($data, $postdata);
        if (!empty($data['specialimg'])) {
            foreach ($data['specialimg'] as $key => $img) {
                if (!empty($img)) {
                    $data['show_specialimg'][$key] = reduce_double_slashes($this->zmsetting->get("img_url") . $this->zmsetting->get("file_upload_dir") . $img);
                } else {
                    $data['show_specialimg'][$key] = reduce_double_slashes($this->zmsetting->get("img_url") . $this->zmsetting->get("file_upload_dir") . '/no_image.png');
                }
            }
        }
        if (!empty($data['product_images'])) {
            foreach ($data['product_images'] as $key => $img) {
                if (!empty($img))
                    $data['show_images'][$key] = reduce_double_slashes($this->zmsetting->get("img_url") . $this->zmsetting->get("file_upload_dir") . $img);
            }
        }
        $this->load->view("product_add", $data);
    }

    /**
     * 编辑商品
     */
    public function editProduct() {
        $postdata = array();
        $product_id = $this->input->get_post("product_id");
        if (empty($product_id)) {
            redirect(site_url("product/index"));
        }
        if ($this->input->method() == 'post') {
            $postdata = $this->input->post();
            $rules = $this->valiRules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_rules('category_id','商品分类',array($this->cate()));
            if ($this->form_validation->run()) {
                //整理数据
                $productFiled = array(
                    "product_id",
                    "apply_intergal", "ratio_intergal",
                    "give_intergal", "sale", "hot",
                    "new", "sort", "product_sn",
                    "product_name", "short_name",
                    "description", "explain", "supplier_id",
                    "store_number", "check_store",
                    "status", "price","intergral_deduce",
                    "market_price",
                    "in_price",
                    "videos",
                    "product_images",
                    "weight");
                $productData = elements($productFiled, $this->input->post());
                $mkimages = $this->mkProductImages();
                $productData['product_sn'] = $this->mkProductSN($productData['product_sn']);
                $productData['thumb'] = $mkimages['thumb'];
                $productData['images'] = $mkimages['images'];
                $productData['createtime'] = time();
                $productData['updatetime'] = time();
                unset($productData['product_images']);

                $productData['agent_commission'] = $this->mkAgents();
                $productData['user_group_discount'] = $this->mkUserDiscount();
                //商品扩展数据
                $productCategory = $this->mkCategroies();
                $productTags = $this->mkTags();
                $productLinks = $this->mkLinks();
                $productSpecial = $this->mkAttrAndSpecial();

                $ext_data = array(
                    "categories" => $productCategory,
                    "productTags" => $productTags,
                    "productLinks" => $productLinks,
                    "productSpecial" => $productSpecial
                );
                $this->ProductModel->editProduct($productData, $ext_data);
                $this->session->success = "编辑商品成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("product/index"));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        //获取会员分组和分销商分组
        $this->load->model('UserGroupModel');
        $this->load->model('AgentGroupModel');
        $usergrouplist = $this->UserGroupModel->getUserGroupList();
        $agentgrouplist = $this->AgentGroupModel->getAgentGroupList();
        $data['usergrouplist'] = $usergrouplist['result'];
        $data['agentgrouplist'] = $agentgrouplist['result'];
        //----获取商品模型-------
        $this->load->model("commodityTypModel");
        $data['commodityTyps'] = $this->commodityTypModel->getCommodityTyps();
        //----获取供货商---------
        $this->load->model("supplierModel");
        $data['suppliers'] = $this->supplierModel->getSuppliers();

        $product = $this->ProductModel->getProductById($product_id);
        $product_special = $this->getProductSpecial($product_id);
        if (!empty($product_special['specialimg'])) {
            foreach ($product_special['specialimg'] as $key => $img) {
                if (!empty($img)) {
                    $data['show_specialimg'][$key] = reduce_double_slashes($this->zmsetting->get("img_url") . $this->zmsetting->get("file_upload_dir") . $img);
                } else {
                    $data['show_specialimg'][$key] = reduce_double_slashes($this->zmsetting->get("img_url") . $this->zmsetting->get("file_upload_dir") . '/no_image.png');
                }
            }
        }
        $data['product_images'] = unserialize($product['images']);
        $data['show_images'] = array();
        if (!empty($data['product_images'])) {
            foreach ($data['product_images'] as $key => $img) {
                if (!empty($img))
                    $data['show_images'][$key] = reduce_double_slashes($this->zmsetting->get("img_url") . $this->zmsetting->get("file_upload_dir") . $img);
            }
        }
        
        $data['product_id'] = $product_id;

        $data['product_tag_id'] = $this->ProductModel->getProductTagsByProductId($product_id);
        $data['category_id'] = $this->ProductModel->getCategoriesByProductId($product_id);
        $data['link_product_id'] = $this->ProductModel->getLinksByProductId($product_id);

        $agent_group_comm = $this->getAgentCommission($product['agent_commission']);
        $data["agent_group"] = $agent_group_comm['agent_group'];
        $data["agent_commission"] = $agent_group_comm['agent_commission'];

        $user_group_dis = $this->getUserGroupDiscount($product['user_group_discount']);
        $data['user_group'] = $user_group_dis['user_group'];
        $data['user_group_discount'] = $user_group_dis['user_group_discount'];
        $data = array_merge($product, $data, $product_special);
        $this->load->view("product_edit", $data);
    }

    /**
     * 获取并格式化属性
     * @param type $product_id
     * @return type
     */
    private function getProductSpecial($product_id) {
        $specifications = $this->ProductModel->getSpecialByProductId($product_id);

        $attributes = $specifications['attributes'];
        $attriArray = unserialize($attributes);
        $attribute_name = array();
        $attribute_value = array();
        if (!empty($attriArray)) {
            foreach ($attriArray as $attr) {
                $attribute_name[] = $attr["name"];
                $attribute_value[] = $attr["value"];
            }
        }
        $special = unserialize($specifications['specifications']);
        $goods_code = array();
        $plus_price = array();
        $goods_store = array();
        $hidenChk = array();
        $specialimg = array();
        if (!empty($special)) {
            foreach ($special as $sp) {
                $goods_code[] = $sp['goods_code'];
                $plus_price[$sp['goods_code']] = $sp['goods_plus_price'];
                $goods_store[$sp['goods_code']] = $sp['goods_store'];
                $specialimg[$sp['goods_code']] = @$sp['specialimg'];
                $hidenChk[$sp['goods_code']] = $sp['hidenChk'];
            }
        }

        $data = array(
            "attribute_name" => $attribute_name,
            "attribute_value" => $attribute_value,
            "special_struct" => $specifications['special_struct'],
            "goods_code" => $goods_code,
            "plus_price" => $plus_price,
            "goods_store" => $goods_store,
            "specialimg"=>$specialimg,
            "hidenChk" => $hidenChk
        );
        return $data;
    }

    /**
     * 重新格式化分销配置
     * @param type $AC
     * @return type
     */
    private function getAgentCommission($AC) {
        $AC = @unserialize($AC);
        $agent_group = array();
        $agent_commission = array();
        if (!empty($AC)) {
            foreach ($AC as $agent) {
                $agent_group[] = $agent['agent_group_id'];
                $agent_commission = array_merge($agent_commission, $agent['agent_commission']);
            }
        }
        return array("agent_group" => $agent_group, "agent_commission" => $agent_commission);
    }

    /**
     * 重新格式化用户分组折扣
     */
    private function getUserGroupDiscount($ugc) {
        $usergroup = @unserialize($ugc);
        $user_group = array();
        $user_group_discount = array();
        if (!empty($usergroup)) {
            foreach ($usergroup as $ug) {
                $user_group[] = $ug['user_group_id'];
                $user_group_discount[] = $ug['discount'];
            }
        }
        return array("user_group" => $user_group, "user_group_discount" => $user_group_discount);
    }

    //首页快速上下架商品
    public function status() {
        $data = elements(array("product_id", "status"), $this->input->post());
        if ($this->ProductModel->status($data)) {
            $result = array("error_code" => 0);
        } else {
            $result = array("error_code" => 1);
        }
        $this->output->set_output(json_encode($result));
    }

    public function deleteProduct() {
        $return = $this->input->post('selected');
        if (!empty($return) && is_array($return)) {
            $where = implode(',', $this->input->post('selected'));
            if ($this->ProductModel->deleteProduct('product_id in (' . $where . ')')) {
                $this->session->success = "删除成功!";
                $this->session->mark_as_flash("success");
            } else {
                $this->session->error = "删除失败!";
                $this->session->mark_as_flash("error");
            }
        } else {
            $this->session->error = "请求有误!";
            $this->session->mark_as_flash("error");
        }
        redirect(site_url("Product/index"));
    }

    private function valiRules() {
        return $valiRules = array(
            array(
                'field' => 'product_name',
                'label' => '商品名称',
                'rules' => 'required|min_length[2]|max_length[40]',
                "errors" => array(
                    'required' => '商品名称为空',
                    'min_length' => "商品名称长度大于2小于40",
                    'max_length' => "商品名称长度大于2小于40"
                )
            ),
            array(
                'field' => 'store_number',
                'label' => '商品库存',
                'rules' => 'is_natural_no_zero',
                "errors" => array(
                    'is_natural_no_zero' => '商品库存必须为整数',
                )
            ),
            array(
                'field' => 'price',
                'label' => '商品售价',
                'rules' => 'required|numeric',
                "errors" => array(
                    'required' => '请填写商品价格',
                    'numeric' => '必须是一个正确的商品售价',
                )
            ),
            array(
                'field' => 'market_price',
                'label' => '商品市场价',
                'rules' => 'numeric',
                "errors" => array(
                    'numeric' => '必须是一个正确的商品市场价',
                )
            ),
            array(
                'field' => 'in_price',
                'label' => '商品进价',
                'rules' => 'numeric',
                "errors" => array(
                    'numeric' => "必须是一个正确的商品进价"
                )
            ),
            array(
                'field' => 'product_special[]special_price',
                'label' => '商品进价',
                'rules' => 'numeric',
                "errors" => array(
                    'numeric' => "必须是一个正确的价格"
                )
            ),
            array(
                'field' => 'product_special[]special_market_price',
                'label' => '商品进价',
                'rules' => 'numeric',
                "errors" => array(
                    'numeric' => "必须是一个正确的价格"
                )
            ),
        );
    }

    /**
     * 自动查询分类名称
     */
    public function autoCategory() {
        $search_name = $this->input->get_post('search_name');
        $add = $this->input->get_post('add');
        $this->load->model("categoryModel");
        $categorydata = $this->categoryModel->autoCategoryList($search_name, $add);
        $this->output->set_output(json_encode($categorydata));
    }

    /**
     * 获取指定商品类型的规格属性json
     */
    public function getAttrAndSpecial() {
        $cdytyp_id = $this->input->get("cdytyp_id");
        $data = array();
        if ($cdytyp_id) {
            $this->load->model("commodityTypModel");
            $cdytyp = $this->commodityTypModel->getCommodityTypById($cdytyp_id);
            if (!empty($cdytyp['attribute'])) {
                $data['attribute'] = unserialize($cdytyp['attribute']);
            } else {
                $data['attribute'] = array();
            }
            if (!empty($cdytyp['specification'])) {
                $data['specification'] = unserialize($cdytyp['specification']);
            } else {
                $data['specification'] = array();
            }
        }
        $this->output->set_content_type("json/application")->set_output(json_encode($data));
    }

    /**
     * 自动查询商品名称
     */
    public function autoProduct() {
        $parent_id = $this->input->get_post('product_id');
        if (empty($parent_id)) {
            $parent_id = '';
        }
        $categorydata = $this->ProductModel->autoProductList($parent_id);
       
        $this->output->set_output(json_encode($categorydata));
    }

    public function recommend() {
        $data = elements(array("product_id", "recommend"), $this->input->post());
        if ($this->ProductModel->recommend($data)) {
            $result = array("error_code" => 0);
        } else {
            $result = array("error_code" => 1);
        }
        $this->output->set_output(json_encode($result));
    }

    private function mkProductSN($sn = "") {
        if (empty($sn)) {
            $sn = "PSN" . date("YmdHis");
        }
        $product_id = $this->input->post("product_id");
        $hasSn = $this->ProductModel->getProductBySN($sn, $product_id);
        if (!empty($hasSn)) {//重新生成
            $sn = "PSN" . date("YmdHis");
            return $this->mkProductSN($sn);
        }
        return $sn;
    }

    /**
     * 处理商品图片数据
     * @return type
     */
    private function mkProductImages() {
        $images = $this->input->post("product_images");
        foreach ($images as $k => &$image) {
            if ($image == ""||$image == "/no_image.png") {
                unset($images[$k]);
            }
            $image = reduce_double_slashes($image);
        }
        $imagesArray = array("thumb" => "", "images" => "");
        if (!empty($images)) {
            $imagesArray['thumb'] = $images[0];
            $imagesArray['images'] = serialize($images);
        }
        return $imagesArray;
    }

    /**
     * 处理用户折扣数据
     */
    private function mkUserDiscount() {
        $user_group = $this->input->post("user_group");
        $user_group_discount = $this->input->post("user_group_discount");
        $discount = array();
        if (is_array($user_group)) {
            foreach ($user_group as $k => $user_group_id) {
                $discount[] = array(
                    "user_group_id" => $user_group_id,
                    "discount" => $user_group_discount[$k]
                );
            }
        }

        return serialize($discount);
    }

    //验证商品分类是否为空
    public function cate(){
        $value = $this->input->post('category_id');
        if(!empty($value)){
            return true;
        }else{
            return "required";
        }
    }

    /**
     * 处理代理分成数据
     */
    private function mkAgents() {
        $agent_group = $this->input->post("agent_group");
        $agent_commission = $this->input->post("agent_commission");
        $commissions = array();
        if (is_array($agent_group)) {
            foreach ($agent_group as $k => $agent) {
                $commissions[] = array(
                    "agent_group_id" => $agent,
                    "agent_commission" => array_slice($agent_commission, $k * 3, 3)
                );
            }
        }
        if (empty($commissions)) {
            return "";
        }
        return serialize($commissions);
    }

    /**
     * 处理商品标签数据
     */
    private function mkTags() {
        $product_tags = $this->input->post("product_tag_id");
        $tags_id = array();
        if (is_array($product_tags)) {
            foreach ($product_tags as $tag) {
                $tags_id[] = $tag['product_tag_id'];
            }
        }
        return $tags_id;
    }

    /**
     * 处理相关商品数据
     */
    private function mkLinks() {
        $link_products = $this->input->post("link_product_id");
        $link_id = array();
        if (is_array($link_products)) {
            foreach ($link_products as $link) {
                $link_id[] = $link['link_product_id'];
            }
        }
        return $link_id;
    }

    /**
     * 处理分类数据
     */
    private function mkCategroies() {
        $categoriesdata = $this->input->post('category_id');
        $categoires = array();
        if (is_array($categoriesdata)) {
            foreach ($categoriesdata as $cat) {
                $categoires[] = $cat['category_id'];
            }
        }
        return $categoires;
    }

    /**
     * 处理post 上来的规格和属性数据
     * @return 符合商品规格属性表中的数据结构
     */
    private function mkAttrAndSpecial() {
        $goods_codes = $this->input->post("goods_code");
        $attributes_name = $this->input->post("attribute_name");
        $attributes_vale = $this->input->post("attribute_value");
        $plus_prices = $this->input->post("plus_price");
        $goods_stores = $this->input->post("goods_store");
        $hidenChk = $this->input->post("hidenChk");
        $specialimg = $this->input->post("specialimg");
        $specialArray = array();
        $attris = array();
        //商品规格结构
        $special_struct = $this->input->post("special_struct");
        //商品规格
        if (!empty($goods_codes)) {
            foreach ($goods_codes as $goods_code) {
                $specialArray[] = array(
                    "goods_code" => $goods_code,
                    "goods_plus_price" => $plus_prices[$goods_code],
                    "goods_store" => $goods_stores[$goods_code],
                    "specialimg" => $specialimg[$goods_code],
                    "hidenChk" => !empty($hidenChk[$goods_code]) ? 1 : 0
                );
            }
        }

        $struct = json_decode($special_struct);
        if (empty($struct) && empty($attributes_name)) {
            return array(); //如果返回空数组
        }
        //商品属性
        if (!empty($attributes_name)) {
            foreach ($attributes_name as $key => $attrname) {
                $attris[] = array("name" => $attrname, "value" => $attributes_vale[$key]);
            }
        }
        $return = array(
            "special_struct" => $special_struct,
            "attributes" => serialize($attris),
            "specifications" => serialize($specialArray)
        );
        return $return;
    }

    /**
     * 类必须实现函数用于权限控制设置
     * 
     * @return  array
     */
    public static function getModuleInfo() {
        return array(
            "moduleName" => "商品管理",
            "controller" => "Product",
            "author" => "wangxiangshuai@hnzhimo.com",
            "operation" => array(
                "index" => "商品列表页",
                "addProduct" => "新增商品",
                "editProduct" => "编辑商品",
                "deleteProduct" => "删除商品",
                "-autoProduct" => "查询商品",
            )
        );
    }
}