<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 广告
 * 
 * @package	ZMshop
 * @author	liuchenwei@hnzhimo.com
 * @copyright (c) 2018, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 * */
class Advert extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("AdvertModel");
    }

    //获取广告
    public function get_advert() {
        $ad_id = $this->input->post("ad_id");
        $this->load->helper("string");
        if (empty($ad_id)) {
            $error_code = 2;
        } else {
            $ad = $this->AdvertModel->getAdvert($ad_id);
            $error_code = 0;
            $adverts = array();
            if (!empty($ad))
                foreach ($ad as $adv) {
                    $adv['ad_source'] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $adv['ad_source']);
                    $adverts[] = $adv;
                }
        }
        $data = array("error_code" => $error_code, "data" => $adverts);
        $this->output->set_content_type("json/application")->set_output(json_encode($data));
    }

    //获取广告位
    public function ad_position() {
        $ad_position = $this->AdvertModel->ad_position();
        if (empty($ad_position)) {
            $error_code = 1;
        } else {
            $error_code = 0;
        }
        $data = array("error_code" => $error_code, "data" => $ad);
        $this->output->set_content_type("json/application")->set_output(json_encode($data));
    }

}
