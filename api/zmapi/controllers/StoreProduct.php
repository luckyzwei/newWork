<?php

/**
 * 店铺商品接口
 * 
 * @package	ZMshop
 * @author	qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class StoreProduct extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("storeModel");
        $this->load->model("storeProductModel");
        $this->load->model("productModel");
        $this->load->model("userModel");
        $this->load->helper('string');
    }

    /**
     * 店铺推荐（认领）商品
     */
    public function set_store_product() {
        $product_id = $this->input->post("product_id");
        $product = $this->productModel->getProductInfo($product_id);

        $store_product = $this->storeProductModel->getStoreProductById($product_id, $this->session->user_info['store_id']);
        $error_code = 1;
        if (!empty($store_product)) {
            $error_code = 2; //已经认领
        } elseif (!empty($product) && $this->session->user_info['store_id']) {
            $storeProduct = array(
                "store_id" => $this->session->user_info['store_id'],
                "product_id" => $product_id,
                "store_product_breif" => $product['explain'],
                "store_product_price" => $product['price']
            );
            $this->storeProductModel->addStoreProduct($storeProduct);
            $error_code = 0;
        }
        $result = json_encode(array("error_code" => $error_code));
        $this->output->set_content_type("json/application")->set_output($result);
    }

    /**
     * 获取店铺推荐商品
     */
    public function get_store_products() {
        $store_id = $this->input->post("store_id");
        $user_id = $this->session->user_id;
        $store_products = array();
        if (!empty($store_id)) {
            $error_code = 0;
            $store_products = $this->storeProductModel->getStoreProducts($store_id);
        } else {
            $error_code = 1;
        }
        foreach ($store_products as &$sp) {
            $sp['thumb'] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $sp['thumb']);
        }

        if (!empty($this->session->user_info['store_id'])) {//店铺模式获取推广佣金
            foreach ($store_products as &$sp) {
                //分销佣金
                $agent_commission = $this->productModel->getAgentCommission($user_id, $sp['product_id']);
                if ($agent_commission !== false) {
                    $sp['agent_commission'] = $agent_commission + ($sp['product_price'] - $sp['store_product_price']);
                }
            }
        }

        $result = json_encode(array("error_code" => $error_code, "products" => $store_products));
        $this->output->set_content_type("json/application")->set_output($result);
    }

    /**
     * 根据店铺id和商品id获取店铺商品
     */
    public function get_store_product() {
        $product_id = $this->input->post("product_id");
        $store_id = $this->input->post("store_id");
        $store_product = $this->storeProductModel->getStoreProduct($store_id, $product_id);
        $error_code = 0;
        if (empty($store_product)) {
            $error_code = 1;
        } else {
            $store_product['thumb'] = $this->systemsetting->get("img_url") . $store_product['thumb'];
        }
        $result = json_encode(array("error_code" => $error_code, "product" => $store_product));
        $this->output->set_content_type("json/application")->set_output($result);
    }

    /**
     * 编辑店铺商品
     */
    public function edit_store_product() {
        $product_id = $this->input->post("product_id");
        $store_product = $this->storeProductModel->getStoreProduct($this->session->user_info['store_id'], $product_id);

        if (empty($store_product) || $store_product['store_id'] != $this->session->user_info['store_id']) {
            $error_code = 2; //参数错误
        } else {
            $data = elements(array("store_product_breif", "store_product_price"), $this->input->post());
            $error_code = 1;
            if ($this->storeProductModel->updateStoreProduct($data, array("store_product_id" => $store_product['store_product_id']))) {
                $error_code = 0;
                $store_product = $this->storeProductModel->getStoreProduct($this->session->user_info['store_id'], $product_id);
            }
        }
        $result = json_encode(array("error_code" => $error_code, "products" => $store_product));
        $this->output->set_content_type("json/application")->set_output($result);
    }

    /**
     * 删除店铺推荐商品
     */
    public function delete_store_product() {
        $product_id = $this->input->post("product_id");
        $product = $this->storeProductModel->getStoreProduct($this->session->user_info['store_id'], $product_id);

        if (empty($product) || $product['store_id'] != $this->session->user_info['store_id']) {
            $error_code = 2; //参数错误
        } else {
            if ($this->storeProductModel->deleteStoreProduct(array("store_product_id" => $product['store_product_id']))) {
                $error_code = 0;
            }
        }
        $result = json_encode(array("error_code" => $error_code));
        $this->output->set_content_type("json/application")->set_output($result);
    }

    /**
     * 推广中心：创建分享图片
     */
    public function sale_center_poster() {
        $error_code = 1;
        $user_id = $this->session->user_id;
        $posttype = $this->input->post("posttype");
        $store_share_path = "./share/product/" . $user_id;
        if (!is_dir($store_share_path)) {
            mkdir($store_share_path);
        }
        $target_img = $store_share_path . "/" . $posttype . "_poster.jpg";
        $scene = $posttype . "_" . $user_id;
        if ($posttype == "friend") {
            $template = "./share/product/friend.jpg";
            $page = "pages/index/index";
            $qr_size = 200;
            $qr_x = 355;
            $qr_y = 600;

            $font_x = 350;
            $font_y = 800;
        } else {
            $template = "./share/product/mpp.jpg";
            $page = "pages/personal/userinfo/userinfo";
            $qr_size = 260;
            $qr_x = 307;
            $qr_y = 745;

            $font_x = 307;
            $font_y = 1010;
        }
        copy($template, $target_img);

        $qcord = $this->create_app_qrcode($scene, $user_id, $page); // @todo 该功能需要小程序上线后使用
        //创建一个缩略图
        $this->create_thumb($qcord, $qcord, $qr_size);
        if (is_file($qcord)) {
            $src = imagecreatefrompng($qcord);
            $des = imagecreatefromjpeg($target_img);
            imagecopy($des, $src, $qr_x, $qr_y, 0, 0, $qr_size, $qr_size);
            imagejpeg($des, $target_img);

            //@todo 生成图片的模板管理
            $config = array(
                "target_img" => $target_img,
                "content" => array(
                    array(
                        "type" => "text",
                        "text" => "长按识别小程序码",
                        "break" => false, //是否换行
                        "break_len" => 16, //每行的字符数
                        "font-size" => 18,
                        "font-color" => "BA9578",
                        "hor" => $font_x,
                        "vrt" => $font_y,
                        "line-height" => 45
                    ),
            ));

            $error_code = 0;

            $imgpath = $this->systemsetting->get("api_url") . $this->share_img_action($config);
        }

        $result = json_encode(array("error_code" => $error_code, "data" => $imgpath));
        $this->output->set_content_type("json/application")->set_output($result);
    }

    public function product_share_image() {
        $product_id = $this->input->post("product_id");
        $user_id = $this->session->user_id;
        $product = $this->storeProductModel->getStoreProduct($user_id, $product_id);

        if (empty($product)) {
            $error_code = 2;
            $imgpath = array();
        } else {
            $store_share_path = "./share/product/" . $user_id;
            if (!is_dir($store_share_path)) {
                mkdir($store_share_path);
            }
            if (empty($product['store_product_id'])) {
                $product['store_product_breif'] = $product['explain'];
                $product['store_product_price'] = $product['product_price'];
            }

            $product_thumb = $product['thumb'];
            $ext = strtolower(strrchr($product_thumb, '.'));
            $target_img = $store_share_path . "/" . $product_id . "_product.png";
            $template = "./share/product/produt_bg.png";
            //商品图片路径
            $product_thumb = "../controllCenter" . $this->systemsetting->get("file_upload_dir") . $product_thumb;

            $create_product_thumb = "./share/temp/" . time() . $ext;
            $this->create_thumb($product_thumb, $create_product_thumb, 300);
            copy($template, $target_img);
            $des = imagecreatefrompng($target_img);
            if ($ext == ".jpeg" || $ext == '.jpg') {
                $src = imagecreatefromjpeg($create_product_thumb);
            } else {
                $src = imagecreatefrompng($create_product_thumb);
            }
            imagecopy($des, $src, 10, 10, 0, 0, 300, 300);
            $src = imagecreatefrompng("./share/product/price_bg.png");
            imagecopy($des, $src, 230, 270, 0, 0, 103, 34);
            //-------------创建一个商品的小程序码------------
            $scene = $product_id . "_" . $user_id;
            $page = "pages/goodsdetail/goodsdetail";
            $qcord = $this->create_app_qrcode($scene, $user_id, $page); // @todo 该功能需要小程序上线后使用
            //创建一个缩略图
            $this->create_thumb($qcord, $qcord, 120);

            if (is_file($qcord)) {
                $src = imagecreatefrompng($qcord);
                imagecopy($des, $src, 100, 350, 0, 0, 120, 120);
                imagepng($des, $target_img);
                //@todo 生成图片的模板管理
                $config = array(
                    "target_img" => $target_img,
                    "content" => array(
                        array(
                            "type" => "text",
                            "text" => $product['product_name'],
                            "break" => true, //是否换行
                            "font-size" => 10,
                            "font-color" => "BA9578",
                            "break_len" => 28, //每行的字符数
                            "hor" => 8,
                            "vrt" => 290,
                            "line-height" => 15
                        ),
                        array(
                            "type" => "text",
                            "text" => "￥" . $product['store_product_price'],
                            "break" => false, //是否换行
                            "break_len" => 16, //每行的字符数
                            "font-size" => 10,
                            "font-color" => "ffffff",
                            "hor" => 225,
                            "vrt" => 263,
                            "line-height" => 32
                        ),
                        array(
                            "type" => "text",
                            "text" => "长按识别小程序码",
                            "break" => false, //是否换行
                            "break_len" => 16, //每行的字符数
                            "font-size" => 9,
                            "font-color" => "BA9578",
                            "hor" => 80,
                            "vrt" => 460,
                            "line-height" => 10
                        ),
                ));
                $error_code = 0;

                $imgpath = $this->systemsetting->get("api_url") . $this->share_img_action($config);
            }
        }
        $result = json_encode(array("error_code" => $error_code, "data" => $imgpath));
        $this->output->set_content_type("json/application")->set_output($result);
    }

    private function share_img_action($config) {

        if (is_file($config['target_img'])) {
            //  return $config['target_img'];
        }
        foreach ($config['content'] as $content) {
            if ($content['type'] == "text") {
                $this->add_text($content, $config['target_img']);
            } else {
                $this->add_img($content, $config['target_img']);
            }
        }
        return $config['target_img'];
    }

    /**
     * 创建小程序码
     */
    private function create_app_qrcode($scene, $store_uid, $page, $width = 500) {
        $user_app_qrcode = "./share/product/" . $store_uid . "qrcode.png";
        if (!is_file($user_app_qrcode) || 1) {
            $this->load->helper("wechatapp");
            $appid = $this->systemsetting->get("wechat_fun_id");
            $appsecret = $this->systemsetting->get("wechat_fun_secret");
            $token = get_access_token($appid, $appsecret);
            $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token={$token}";
            $postdata = array(
                "scene" => $scene,
                "page" => $page,
                "width" => $width,
                "is_hyaline" => true
            );
            $result = curl_post($url, $postdata, "json");
            $qrimg = imagecreatefromstring($result);
            if ($qrimg) {
                imagepng($qrimg, $user_app_qrcode);
            }
        }
        return $user_app_qrcode;
    }

    /**
     * 在图片上添加文本
     * @param type $content
     * @param type $source_path
     */
    private function add_text($content, $source_path) {
        $this->load->library('image_lib');
        $this->load->helper('text');
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_path;
        $config['wm_font_path'] = './fonts/msyh.ttc';
        $config['wm_font_size'] = $content['font-size'];
        $config['wm_font_color'] = $content['font-color'];
        $config['wm_vrt_alignment'] = 'top';
        $config['wm_hor_alignment'] = 'left';
        $config['wm_padding'] = '20';
        $config['wm_hor_offset'] = $content['hor'];
        $config['wm_type'] = 'text';

        $all_text = $content['text'];
        if ($content['break']) {
            $text_array = chi_to_array($all_text, $content['break_len']);
            $line = 0;
            foreach ($text_array as $text) {
                $line++;
                $config['wm_text'] = $text;
                $config['wm_vrt_offset'] = $content['vrt'] + $content['line-height'] * $line;
                ;

                $this->image_lib->initialize($config);
                $this->image_lib->watermark();
                echo $this->image_lib->display_errors();
            }
            $this->image_lib->clear();
        } else {
            $config['wm_text'] = $all_text;
            $config['wm_type'] = 'text';
            $config['wm_vrt_offset'] = $content['vrt'];
            $this->image_lib->initialize($config);
            $this->image_lib->watermark();
            $this->image_lib->display_errors();
            $this->image_lib->clear();
        }
    }

    /**
     * 添加图片到分享图片上
     * @param type $content
     * @param type $source_img
     */
    private function add_img($content, $source_img) {

        if (!is_file($content['from_img'])) {
            return false;
        }
        $from_img = $this->create_thumb($content['from_img'], "./share/temp/" . time() . basename($content['from_img']), $content['width']);
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_img;
        $config['wm_type'] = 'overlay';

        $config['wm_overlay_path'] = $from_img;
        $config['wm_vrt_alignment'] = 'top';
        $config['wm_hor_alignment'] = 'left';
        $config['wm_padding'] = '20';
        $config['wm_opacity'] = $content['opacity'];
        $config['wm_hor_offset'] = $content['hor'];
        $config['wm_vrt_offset'] = $content['vrt'];

        $this->load->library('image_lib');
        $this->image_lib->initialize($config);
        $this->image_lib->watermark();
        //删除临时文件
        unlink($from_img);
        echo $this->image_lib->display_errors();
        $this->image_lib->clear();
    }

    /**
     * 创建一个缩略图
     * @param type $source_img
     * @param type $save_path
     * @param type $width
     * @param type $height
     * @return type
     */
    private function create_thumb($source_img, $save_path, $width = 800, $height = 1900) {

        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_img;
        $config['new_image'] = $save_path;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['thumb_marker'] = "";
        $config['quality'] = '70';
        $config['width'] = $width;
        $config['height'] = $height;

        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $error = $this->image_lib->display_errors();
        $this->image_lib->clear();
        if (empty($error)) {
            return $save_path;
        }
        echo "create_thumb:" . $error . "====";
    }

}
