<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 获取系统初始化的各种信息
 * 
 * @package	ZMshop
 * @author	qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class Base extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("ApiModel");
    }

    /**
     * 客户端通过api的name和key获取访问api权限
     * @param  $appid,$appsecret必须
     * @return json 错误信息或者token数据的json
     */
    public function get_access_token() {
        $this->load->library("session");
        $error_code = 0;
        $appid = $this->input->post("appid");
        $appsecret = $this->input->post("appsecret");
        
        $data = array();
        $where = array("appid" => $appid, "key" => $appsecret);
        $api = $this->ApiModel->checkApi($where);
        if (empty($api)) {
            $error_code = 1;
        } elseif (!$api['status']) {
            $error_code = 2;
        } else {
            $access_token = $this->create_access_token();
            $data['access_token'] = $access_token;
            $this->session->appid = $appid;
        }
        if ($error_code) {//发生错误消除所有session
            $this->session->sess_destroy();
        }
        $result = array("error_code" => $error_code, "data" => $data);
        $this->output->set_content_type("application/json")->set_output(json_encode($result));
    }

    /**
     * 生成一个token
     * @return type
     */
    private function create_access_token() {
        $this->load->library('encryption');
        $access_token = $this->encryption->encrypt(session_id());
        return urlencode($access_token);
    }

    /**
     * 创建系统加密key
     */
    public function create_key() {
        echo $key = bin2hex($this->encryption->create_key(16));
        $this->session->sess_destroy();
    }

    /**
     * 获取单个配置项
     */
    public function get_config() {
        $key = $this->input->post("key");
        if (empty($key)) {
            $error_code = 2;
        } else {
            $value = $this->systemsetting->get($key);
            $data = array();
            if (!empty($value)) {
                $error_code = 0;
                $data[$key] = $value;
            } else {
                $error_code = 1;
            }
        }
        $result = array("error_code" => $error_code, "data" => $data);
        $this->output->set_content_type("application/json")->set_output(json_encode($result));
    }

    /**
     * 获取多个配置信息
     * post的key参数需要是一个数组
     */
    public function get_configs() {
        $keys = $this->input->post("keys");
        $cofings = $this->systemsetting->getByKeys($keys);
        $data = array();
        if (!empty($cofings)) {
            $error_code = 0;
            foreach ($cofings as $cofing) {
                $data[$cofing['setting_key']] = $cofing['setting_value'];
            }
        } else {
            $error_code = 1;
        }
        $result = array("error_code" => $error_code, "data" => $data);
        $this->output->set_content_type("application/json")->set_output(json_encode($result));
    }

    /**
     * 获取可用的支付方式列表
     * 参数：client_type 支持终端1手机网页，2微信公众号，3微信小程序，4pc端
     */
    public function get_payments() {
        $client_types = $this->input->post("client_type");
        $payments = array();
        if (empty($client_types)) {
            $error_code = 1;
        } else {
            $this->load->model("PaymentModel");
            $payments = $this->PaymentModel->getPayList($client_types);
            if (empty($payments)) {
                $error_code = 2;
            } else {
                $error_code = 0;
            }
        }
        $data = $payments;
        $result = array("error_code" => $error_code, "data" => $data);
        $this->output->set_content_type("application/json")->set_output(json_encode($result));
    }

    /**
     * 根据支付方式id后去支付方式信息
     */
    public function get_payment() {
        //获取支付方式的基本信息
        $payment_id = $this->input->post("payment_id");
        $error_code = 0;
        $payment = array();
        if ($payment_id) {
            $this->load->model("PaymentModel");
            $payment = $this->PaymentModel->getPayInfo($payment_id);
            if ($payment) {
                //获取支付方式的配置信息
                $configs = $this->systemsetting->getSettingsByGroup($payment["setting_flag"]);
                $payment['configs'] = $configs;
            } else {
                $error_code = 2;
            }
        } else {
            $error_code = 1;
        }
        $result = array("error_code" => $error_code, "data" => $payment);
        $this->output->set_content_type("application/json")->set_output(json_encode($result));
    }

    /**
     * 获取可用的配送方式列表
     */
    public function get_logistics() {
        
    }

    /**
     * 根据id获取配送方式详情
     */
    public function get_logistics_by_id() {
        
    }

}
