<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 收货地址
 *
 * @package    ZMshop
 * @author    liuchenwei@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link    http://www.hnzhimo.com
 * @since    Version 1.0.0
 * */
class Address extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("AddressModel");
    }

    /**
     * 获取用户收货地址列表
     */
    public function get_address() {
        $json = array();
        $user_id = $this->session->user_id;
        $data = $this->AddressModel->getAddressList($user_id);
        $json['error_code'] = 0;
        $json['data'] = $data;
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    /**
     * 设置默认收货地址
     */
    public function set_default() {
        $json = array();
        $user_id = $this->session->user_id;
        $address_id = $this->input->post("address_id");
        if (empty($address_id)) {
            $json['result'] = 1;
            $json['error_code']=1;
        }
        if (empty($json) && $this->AddressModel->setDefault($address_id, $user_id)) {
            $json['result'] = 0;
            $json['error_code']=0;
        }
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    /**
     * 获取收货地址详情
     * address_id=0情况下返回默认地址
     */
    public function get_address_info() {
        $json = array();
        $user_id = $this->session->user_id;
        $address_id = $this->input->post('address_id');

        $json['error_code'] = 1;
        $data = $this->AddressModel->getAddressInfo($user_id, $address_id);
        if (!empty($data)) {
            $json['error_code'] = 0;
            $json['data'] = $data;
        }
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    /**
     * 添加收货地址
     */
    public function add_address() {
        if ($this->input->post("address_id")) {
            $this->edit_address();
        } else {
            $json = array();
            $user_id = $this->session->user_id;

            $arr['user_id'] = $user_id;
            $arr['telephone'] = $this->input->post('telephone');
            $arr['name'] = $this->input->post('fullname');
            $arr['address'] = $this->input->post('address');
            $arr['district_name'] = $this->input->post('district_name');
            $arr['district_id'] = $this->input->post('district_id');
            $arr['city_name'] = $this->input->post('city_name');
            $arr['city_id'] = $this->input->post('city_id');
            $arr['province_name'] = $this->input->post('province_name');
            $arr['province_id'] = $this->input->post('province_id');
            $arr['is_default'] = $this->input->post('is_default') ? $this->input->post('is_default') : 0;
            $arr['createtime'] = time();
            $insert_id = $this->AddressModel->addAddress($arr);
            //设置当前地址为默认
            $this->AddressModel->setDefault($insert_id, $user_id);
            $json['error_code'] = 1;

            $this->output->set_content_type("application/json")->set_output(json_encode($json));
        }
    }

    /**
     * 删除收货地址
     */
    public function delete_address() {
        $address_id = $this->input->post('address');
        $this->AddressModel->deleteAddress($address_id);
        $json['error_code'] = 0;
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    /*
     * 修改收货地址
     */

    public function edit_address() {
        $json = array();

        $ar = $this->input->post('address_id');
        $arr = array();
        $arr['telephone'] = $this->input->post('telephone');
        $arr['name'] = $this->input->post('fullname');
        $arr['address'] = $this->input->post('address');
        $arr['district_name'] = $this->input->post('district_name');
        $arr['district_id'] = $this->input->post('district_id');
        $arr['city_name'] = $this->input->post('city_name');
        $arr['city_id'] = $this->input->post('city_id');
        $arr['province_name'] = $this->input->post('province_name');
        $arr['province_id'] = $this->input->post('province_id');

        $arr['createtime'] = time();
        $res = $this->AddressModel->editAddres($arr, array('address_id' => $ar));

        $json['error_code'] = 0;
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

}
