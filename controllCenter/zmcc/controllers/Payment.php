<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 支付方式管理
 * @author    qidazhong@hnzhimo.com
 * @copyright    2017 河南知默网络科技有限公司
 * @link    http://www.hnzhimo.com
 * @since    Version 1.0.0
 * */
class Payment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("paymentModel");
        $this->load->model("settingModel");
        $this->load->model("RoleModel");
    }

    /**
     * 支付方式列表
     */
    public function paymentList() {
        $data = array();
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $payments = $this->paymentModel->getPaymentList();
        $data['payments'] = $payments;
        $this->load->view("payment_list", $data);
    }

    /**
     * 添加支付方式
     */
    public function paymentAdd() {
        $this->load->library('form_validation');
        $data['rolelists'] = $this->RoleModel->getRoles();
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $data['result'] = "";
        if ($this->input->method() == "post") {
            $rules = array(
                array(
                    'field' => 'payment_name',
                    'label' => '支付方式名称',
                    'rules' => 'required|min_length[2]|max_length[6]',
                    "errors" => array(
                        "required" => "支付方式名称或者长度不合格",
                        "min_length" => "支付方式名称太短",
                        "max_length" => "支付方式名称太长",
                    ),
                ),
                array(
                    'field' => 'payment_code',
                    'label' => '支付方式代号',
                    'rules' => 'required|min_length[4]|max_length[32]|callback_checkCode',
                    "errors" => array(
                        "required" => "支付方式代号或者长度不合格,或者代号重复",
                        "min_length" => "支付方式代号太短",
                        "max_length" => "支付方式代号太长",
                    ),
                ),
                array(
                    'field' => 'support_client[]',
                    'label' => '支持终端',
                    'rules' => 'required',
                    "errors" => array("required" => "支持终端必填"),
                ),
                array(
                    'field' => 'setting_flag',
                    'label' => '支付方式配置key',
                    'rules' => 'required',
                    "errors" => array("required" => "支付方式配置key必填"),
                ),
            );
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == true) {
                $post_data = elements(array("payment_name", "payment_code", "support_client", "setting_flag"), $this->input->post());
                $post_data['support_client'] = "," . implode(",", $post_data['support_client']) . ",";
                if ($this->paymentModel->addPayment($post_data)) {
                    $this->session->success = "新增支付方式成功";
                    $this->session->mark_as_flash("success");
                    redirect(site_url("Payment/paymentList"));
                }
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        $this->load->view("payment_add", $data);
    }

    /**
     * 编辑支付方式
     * @param type $payment_id
     */
    public function paymentEdit($payment_id) {
        $this->load->library('form_validation');
        $data['rolelists'] = $this->RoleModel->getRoles();
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $data['result'] = "";
        if ($this->input->method() == "post") {
            $rules = array(
                array(
                    'field' => 'payment_name',
                    'label' => '支付方式名称',
                    'rules' => 'required|min_length[2]|max_length[6]',
                    "errors" => array(
                        "required" => "支付方式名称或者长度不合格",
                        "min_length" => "支付方式名称太短",
                        "max_length" => "支付方式名称太长",
                    ),
                ),
                array(
                    'field' => 'payment_code',
                    'label' => '支付方式代号',
                    'rules' => 'required|min_length[4]|max_length[32]|callback_checkCode[' . $this->input->post("payment_id") . "]",
                    "errors" => array(
                        "required" => "支付方式代号或者长度不合格,或者代号重复",
                        "min_length" => "支付方式代号太短",
                        "max_length" => "支付方式代号太长",
                    ),
                ),
                array(
                    'field' => 'support_client[]',
                    'label' => '支持终端',
                    'rules' => 'required',
                    "errors" => array("required" => "支持终端必填"),
                ),
                array(
                    'field' => 'setting_flag',
                    'label' => '配置项标识',
                    'rules' => 'required',
                    "errors" => array("required" => "配置项标识必填"),
                ),
            );
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == true) {
                $post_data = elements(array("payment_name", "payment_code", "support_client", "setting_flag"), $this->input->post());
                $post_data['support_client'] = "," . implode(",", $post_data['support_client']) . ",";
                $this->paymentModel->editPayment($post_data, array("payment_id" => $this->input->post("payment_id")));
                $this->session->success = "编辑支付方式成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Payment/paymentList"));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        $payment_info = $this->paymentModel->getPayment(array("payment_id" => $payment_id));
        if (empty($payment_info)) {
            $this->session->error = "信息有误请重试";
            $this->session->mark_as_flash("error");
        }
        if (!empty($payment_info['support_client'])) {
            $payment_info['support_client'] = explode(",", $payment_info['support_client']);
        } else {
            $payment_info['support_client'] = array();
        }
        $data['payment'] = $payment_info;
        $this->load->view("payment_edit", $data);
    }

    /**
     * 删除支付方式
     * @param int $payment_id 支付方式id
     */
    public function paymentDelete() {
        $msg = "删除失败";
        $result = 0;
        $ids = $this->input->post("ids");
        $idsarray = explode(",", $ids);
        if ($this->paymentModel->deletePayment(array("payment_id " => $idsarray))) {
            $this->session->success = "删除成功!";
            $this->session->mark_as_flash("success");
        }
        redirect(site_url('payment/paymentlist'));
    }

    /**
     * 配置支付方式
     * @param type $payment_id
     */
    public function paymentSet($payment_id) {
        $this->load->library('form_validation');
        $data['result'] = "";
        if ($this->input->method() == "post") {
            //保存配置信息
            $this->savePaymentSet($payment_id);
            //更新状态
            $payment_status = $this->input->post("payment_status") ? 1 : 0;
            $this->paymentModel->editPayment(array("payment_status" => $payment_status), array("payment_id" => $payment_id));
            $data['result'] = "success";
        }

        $payment = $this->getPaymentInfo($payment_id);
        $data['payment'] = $payment['payment_info'];
        $data['settingOptions'] = $payment['setting_options'];
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());

        $this->load->view("payment_set", $data);
    }

    /**
     * 保存支付方式配置
     */
    private function savePaymentSet($payment_id) {
        //获取支付方式配置项
        $payment = $this->getPaymentInfo($payment_id);
        $setting_options = $payment['setting_options'];
        $savedata = array();
        foreach ($setting_options as $option) {

            if ($option['setting_type'] == "file") {
                //上传文件
                $configs['upload_path'] = './upload/others/';
                $configs['allowed_types'] = array("txt", "pem");
                $configs['file_name'] = time() . mt_rand(100000, 999999);
                $this->load->library('upload', $configs);
                $this->upload->initialize($configs);
                $uploadResult = $this->upload->do_upload($option['setting_key']);
                $filedata = $this->upload->data();

                if ($uploadResult) {
                    $temp['setting_key'] = $option['setting_key'];
                    $temp['setting_value'] = $filedata['full_path'];
                }
            } elseif ($option['setting_type'] == "checkbox") {
                $temp['setting_key'] = $option['setting_key'];
                $temp['setting_value'] = implode(",", $this->input->post($option['setting_key']));
            } else {
                $temp['setting_key'] = $option['setting_key'];
                $temp['setting_value'] = $this->input->post($option['setting_key']);
            }
            $savedata[] = $temp;
        }
        if ($this->settingModel->setSetting($savedata)) {
            return true;
        }
        return false;
    }

    /**
     * 获取支付方式的基本信息和配置项
     * @param type $payment_id
     * @return type
     */
    private function getPaymentInfo($payment_id) {
        $payment_info = $this->paymentModel->getPayment(array("payment_id" => $payment_id));
        //获取所有配置项的信息
        $settingOptions = $this->settingModel->getSettingOptionByGroup($payment_info['setting_flag']);
        if (empty($payment_info)) {
            $this->session->error = "信息有误请重试";
            $this->session->mark_as_flash("error");
        }
        if (!empty($payment_info['support_client'])) {
            $payment_info['support_client'] = explode(",", $payment_info['support_client']);
        } else {
            $payment_info['support_client'] = array();
        }

        //整理配置项的值
        foreach ($settingOptions as &$option) {
            if (in_array($option['setting_type'], array("checkbox", "select", "radio"))) {
                if ($option['setting_type'] == "checkbox") {
                    $option['setting_value'] = explode(",", $option['setting_value']);
                }
                $option['setting_content'] = explode("\n", $option['setting_content']);
            }
        }

        return array("payment_info" => $payment_info, "setting_options" => $settingOptions);
    }

    /**
     * 检查支付代号是否重复的回调
     * @param type $code
     * @param type $id
     */
    public function checkCode($code, $id = 0) {
        $where = array("payment_code" => $code, "payment_id!=" => $id);
        $result = $this->paymentModel->getPayment($where);
        return empty($result) ? true : false;
    }

    public static function getModuleInfo() {
        return array(
            "moduleName" => "支付方式管理",
            "controller" => "Payment",
            "author" => "qidazhong@hnzhimo.com",
            "operation" => array(
                "paymentList" => "支付方式管理",
                "paymentAdd" => "添加支付方式",
                "paymentEdit" => "修改支付方式",
                "paymentDelete" => "删除支付方式",
                "paymentSet" => "配置支付方式",
            ),
        );
    }

}
