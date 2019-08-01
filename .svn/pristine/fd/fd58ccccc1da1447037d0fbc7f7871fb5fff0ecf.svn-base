<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 分类列表页
 * 
 * @package	ZMshop
 * @author	wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class Category extends CI_Controller {

    /**
     * 根据上级id获取商品分类信息
     */
    public function get_categories() {
        $this->load->model("CategoryModel");
        $parent_id = $this->input->post("parent_id") ? $this->input->post("parent_id") : 0;
        $categorylist = $this->get_categorie($parent_id);
        $json = array("error_code" => 0, "data" => $categorylist);
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    private function get_categorie($parent_id) {
        $this->load->model("CategoryModel");
        $categorylist = $this->CategoryModel->getCategoryList($parent_id);
        foreach ($categorylist as &$v) {
            $v['image'] = $this->systemsetting->get("img_url") .$this->systemsetting->get("file_upload_dir"). $v['image'];
            $v['categorylist'] = $this->get_categorie($v['category_id']);
            if($v['categorylist']){
               $v['ishaveChild'] =true;
            }else{
               $v['ishaveChild'] =false; 
            }
           
        }
        return $categorylist;
    }

}
