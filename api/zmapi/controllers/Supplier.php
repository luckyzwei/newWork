<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 供货商
 * 
 * @author wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @since	Version 1.0.0
 */
class Supplier extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('SupplierModel');
        $this->load->helper("string");
    }

    /**
     * 获取供货商列表
     */
    public function get_suppliers() {
        $res = $this->SupplierModel->get_suppliers();
        $data = array();
        foreach ($res as $value) {
            $names = explode('-', $value['name']);
            if (count($names) > 1) {
                $data[] = array(
                    'name' => $names[0] . "   " . $names[1],
                    'supplier_id' => $value['supplier_id'],
                    'images' => explode(",", $value['images'])
                );
            } else {
                $data[] = array(
                    'name' => $value['name'],
                    'supplier_id' => $value['supplier_id'],
                    'images' => explode(",", $value['images'])
                );
            }
        }
        $this->output->set_content_type("json/application")->set_output(json_encode(array('data' => $data)));
    }

    /*
     * 获取供货商基本信息
     */

    public function get_supplier_info() {
        $user_id = $this->session->user_id;
        $supplier = $this->SupplierModel->getSupplierByUid($user_id);
        if ($supplier) {
            $supplier['images'] = explode(",", $supplier['images']);
            $json['error_code'] = 0;
            $json['data'] = $supplier;
        } else {
            $json['error_code'] = 1;
        }
        $this->output->set_content_type("json/application")->set_output(json_encode($json));
    }

    /**
     * 获取供货商结算记录
     */
    public function get_settlement_order() {
        $supplier_id = $this->session->user_info['supplier_id'];
        $page = $this->input->post('page') ? $this->input->post('page') : 1;
        $limit = $this->input->post('limit') ? $this->input->post('limit') : 10;
        $status = $this->input->post('status');
        if (empty($status)) {
            $where = 'order.supplier_statements=0';
        } else {
            $where = 'order.supplier_statements>0';
        }
        $this->load->model('OrderModel');
        $list = $this->OrderModel->getSupplierOrder($supplier_id, $limit, $page, $where);
        foreach ($list as $key => $value) {
            $list[$key]['price_total'] = 0;
            foreach ($value['product'] as $k => $v) {
                $price_total = $v['in_price'] * $v['product_number'];
                $list[$key]['product'][$k]['price_total'] = $price_total;
                $list[$key]['price_total'] += $price_total;
            }
        }
        $json = array('data' => $list, 'error_code' => 0);
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    /**
     * 申请成为供货商
     */
    public function applicationSupplier() {
        $user_id = $this->session->user_id;
        $datas = elements(
                array("name", "contact", "moblie", "province_id", "province_name", "city_id", "city_name", "district_id", "district_name", "address", "images"), $this->input->post()
        );
        $datas['createtime'] = time();
        $datas['user_id'] = $user_id;
        $datas['status'] = 0;
        $error_code = 1;
        $msg = "提交错误";
        //查询是否存在申请
        $supplier = $this->SupplierModel->getSupplierByUid($user_id);
        if (empty($supplier)) {
            if ($this->SupplierModel->applicationSupplier($datas)) {
                $error_code = 0;
                $msg = "请等待平台审核";
            }
        } else {
            if ($this->SupplierModel->updateSupplier($supplier['supplier_id'], $datas)) {
                $error_code = 0;
                $msg = "修改成功";
            }
        }
        $result = array("error_code" => $error_code, "data" => $msg);
        $this->output->set_content_type("json/application")->set_output(json_encode($result));
    }

    public function uploadSupplierImg() {
        //删除设计师其他图片@todo
        $config['upload_path'] = 'uploads/suppliers';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 3000;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('supplierImg')) {
            $error_code = 1;
            $error = array('error' => $this->upload->display_errors());
            $result = array("error_code" => $error_code, "msg" => $error);
        } else {
            $error_code = 0;
            $img_path = "uploads/suppliers/" . $this->upload->data("file_name");
            $result = array("error_code" => $error_code, "data" => $img_path);
        }
        $this->output->set_content_type("json/application")->set_output(json_encode($result));
    }

}
