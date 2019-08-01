<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 用户喜欢控制器
 *
 * @author qidazhong@hnzhimo.com
 */
class UserLike extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("userLikeModel");
    }
    /**
     * 获取用户喜欢的商品
     */
    public function get_user_likes(){
        $userid=$this->session->user_id;
        $likesData=$this->userLikeModel->getLikeProductListByUserID($userid);
        $error_code=0;
        $result=array("error_code"=>$error_code,"data"=>$likesData);
        $this->output->set_content_type("application/json")->set_output(json_encode($result));
    }
    
    public function add_user_like(){
        $error_code=1;
        $userid=$this->session->user_id;
        $product_id=$this->input->post("product_id");
        $data=array("user_id"=>$userid,"product_id"=>$product_id,"createtime"=> time());
        if($this->userLikeModel->addLike($data)){
            $error_code=0;
        }
        $result=array("error_code"=>$error_code);
        $this->output->set_content_type("application/json")->set_output(json_encode($result));
    }
    /**
     * 获取商品喜欢的用户
     */
    public function get_product_like_users(){
        $product_id=$this->input->post("product_id");
        $data=$this->userLikeModel->getLikeUserByProductId($product_id);
        $result=array("error_code"=>0,"data"=>$data);
        $this->output->set_content_type("application/json")->set_output(json_encode($result));
    }
}
