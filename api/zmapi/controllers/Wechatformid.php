<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * @author wangxiangayx
 */
class Wechatformid extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("FormIdModel");
    }

    public function addformid() {
        $formid = $this->input->get_post('formid');
        $user_id = $this->session->user_info['user_id'];
        $source_field = $this->input->get_post('source_field');
        //sub_cart 一次消息 sub_pay 3次消息
        if (in_array($source_field, array('sub_cart','sub_pay')) && $formid != "the formId is a mock one") {
            $data = array();
            $data['formid'] = $formid;
            $data['user_id'] = $user_id;
            $data['source_field'] = $source_field;
            $data['expiration_time'] = time() + 604800; //过期时间
            if ($data['source_field'] == "sub_pay") {
                $data['formid'] = substr($data['formid'], 10);
            }
            $this->FormIdModel->addFormId($data);
        }
        $this->output->set_content_type("json/application")->set_output(json_encode(array('error_code'=>0)));
    }

}
