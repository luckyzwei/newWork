<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 订单管理
 *
 * @package    ZMshop
 * @author    wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link    http://www.hnzhimo.com
 * @since    Version 1.0.0
 */
class Order extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //当前控制器会使用到的加载
        $this->load->helper('url');
        $this->load->model("OrderModel");
        $this->load->library("pagination");
        $this->load->library('form_validation');
    }

    private $statusname = array(
        '-1' => "删除",
        '0' => "未支付",
        '1' => "已支付",
        '2' => "已发货",
        '3' => "部分发货",
        '4' => "部分退货",
        '5' => "已收货",
        '6' => '已完成',
        '7' => '售后中',
        '8' => "已退款"
    );
    private $ordertypename = array(
        'G' => "团购",
        'O' => "普通",
        'T' => "限时",
    );

    /**
     * 类必须实现函数用于权限控制设置
     *
     * @return  array
     */
    public static function getModuleInfo() {
        return array(
            "moduleName" => "订单管理",
            "controller" => "Order",
            "author" => "wangxiangshuai@hnzhimo.com",
            "operation" => array(
                "index" => "订单列表",
                "history" => "查询订单日志",
                "orderTracter" => "导入发货单",
                "deleteOrder" => "删除订单",
                "editOrderInfo" => "编辑订单详情",
                "editOrderStatus" => "修改订单状态",
                "editRefundsStatus" => "退还处理",
                "subOrderInfo" => "查看子订单"
            ),
        );
    }

    //显示首页列表
    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        //需要返回给view的数据
        $data = array();
        $selectdata = array();
        $user_id = $this->input->get_post("user_id");
        if (!empty($user_id)) {
            $selectdata['o.user_id'] = $user_id;
        }

        $order_sn = $this->input->get_post("order_sn");
        if (!empty($order_sn)) {
            $selectdata['o.order_sn'] = $order_sn;
        }

        $filter_status = $this->input->get_post("filter_status");
        if ($filter_status !== '' && $filter_status !== NULL) {
            $selectdata['o.status'] = $filter_status;
        }

        $start_time = $this->input->get_post("start_time");
        if (!empty($start_time)) {
            $selectdata['start_time'] = strtotime($start_time);
        }
        $end_time = $this->input->get_post("end_time");
        if (!empty($end_time)) {
            $selectdata['end_time'] = strtotime($end_time);
        }
        $product_keywods = $this->input->get_post("product_keywods");
        if (!empty($product_keywods)) {
            $selectdata['product_keywods'] = $product_keywods;
        }

        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 20;
        $orderdata = $this->OrderModel->getOrderList($page, $limit, $selectdata);
        $config['base_url'] = site_url('Order/index'); //当前分页地址
        $config['total_rows'] = $orderdata['count'];
        $config['per_page'] = $limit; //每页显示的条数
        $config['cur_page'] = $page;
        $this->pagination->initialize($config);
        $data['statusname'] = $this->statusname;
        $data['ordertypename'] = $this->ordertypename;
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $orderdata['result'];
        $data['page'] = $page;
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('order', $data);
    }

    /**
     * 只是为了区分退单的入口
     */
    public function refundsOrder() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        //需要返回给view的数据
        $data = array();
        $selectdata = array();
        $user_id = $this->input->get_post("user_id");
        if (!empty($user_id)) {
            $selectdata['o.user_id'] = $user_id;
        }

        $order_sn = $this->input->get_post("order_sn");
        if (!empty($order_sn)) {
            $selectdata['o.order_sn'] = $order_sn;
        }

        $selectdata['o.status'] = 7;


        $start_time = $this->input->get_post("start_time");
        if (!empty($start_time)) {
            $selectdata['start_time'] = strtotime($start_time);
        }
        $end_time = $this->input->get_post("end_time");
        if (!empty($end_time)) {
            $selectdata['end_time'] = strtotime($end_time);
        }
        $product_keywods = $this->input->get_post("product_keywods");
        if (!empty($product_keywods)) {
            $selectdata['product_keywods'] = $product_keywods;
        }

        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 20;
        $orderdata = $this->OrderModel->getOrderList($page, $limit, $selectdata);
        $config['base_url'] = site_url('Order/index'); //当前分页地址
        $config['total_rows'] = $orderdata['count'];
        $config['per_page'] = $limit; //每页显示的条数
        $config['cur_page'] = $page;
        $this->pagination->initialize($config);
        $data['statusname'] = $this->statusname;
        $data['ordertypename'] = $this->ordertypename;
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $orderdata['result'];
        $data['page'] = $page;
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('order_refund', $data);
    }

    /**
     * 在编辑页面使用了保存 显示详情页或编辑页
     */
    public function editOrderInfo($order_id, $type = 'info') {
        $data = $this->OrderModel->getOrderInfo($order_id);
        $data['action'] = site_url("Order/index");
        $data['orderinfo']['statusname'] = $this->statusname[$data['orderinfo']['status']];
        foreach ($data['suborders'] as $key => $value) {
            $data['suborders'][$key]['statusname'] = $this->statusname[$value['status']];
        }
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());

        $this->load->view('order_info', $data);
    }

    /**
     * 供货商显示
     */
    public function subOrderInfo($order_id) {
        $data['orderinfo'] = $this->OrderModel->getSubOrderInfo($order_id);
        $data['action'] = site_url("Supplier/supplierOrder");
        $data['orderinfo']['statusname'] = $this->statusname[$data['orderinfo']['status']];
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('orderson_info', $data);
    }

    /**
     * 打印主订单
     */
    public function printMasterOrder() {
        $order_id = $this->input->get("order_id");
        $data = $this->OrderModel->getOrderInfo($order_id);
        $data['statusname'] = $this->statusname[$data['orderinfo']['status']];

        $data['orderinfo']['send_user'] = $this->zmsetting->get("send_order_user");
        $data['orderinfo']['send_phone'] = $this->zmsetting->get("send_order_phone");
        $data['orderinfo']['send_address'] = $this->zmsetting->get("send_order_address");

        $this->load->view('order_print', $data);
    }

    /**
     * 打印子订单
     */
    public function printSubOrder() {
        $order_id = $this->input->get_post("order_id");
        $order_info = $this->OrderModel->getSubOrderInfo($order_id);

        if (empty($order_info['supplier'])) {
            $order_info['send_user'] = $this->zmsetting->get("send_order_user");
            $order_info['send_phone'] = $this->zmsetting->get("send_order_phone");
            $order_info['send_address'] = $this->zmsetting->get("send_order_address");
        } else {
            $order_info['send_user'] = $order_info['supplier']['name'];
            $order_info['send_phone'] = $order_info['supplier']['moblie'];
            $order_info['send_address'] = $order_info['supplier']['province_name'] . $order_info['supplier']['city_name'] . $order_info['supplier']['district_name'] . $order_info['supplier']['address'];
        }

        $order_info['statusname'] = $this->statusname[$order_info['status']];
        $this->load->view('order_sub_print', $order_info);
    }

    /**
     * 订单设置为已支付
     */
    public function payOrder() {
        
    }

    /**
     * 订单设置为未付款
     */
    public function nopayOrder() {
        
    }

    /**
     * 导入发货单号
     */
    public function orderTracter() {

        $upload_result = $this->upload_order_file();
        if (!empty($upload_result['error'])) {
            $this->session->error = "上传失败!";
            $this->session->mark_as_flash("error");
        } else {
            $filepath = $upload_result['upload_data']['full_path'];
            //读取数据
            $data_result = $this->read_xls_data($filepath);
            //删除文件
            @unlink($filepath);
            foreach ($data_result['data'] as $value) {
//                $requery = array(
//                    "status" => 2,
//                    "shipping_code" => $value['shipping_code']
//                );
                $order_info = $this->OrderModel->getOrderBySn($value['order_sn']);
                $this->OrderModel->editOrderStatus(
                        array(
                    "status" => 2,
                    'content' => '管理员' . $this->session->adminInfo['name'] . "，导入发货单号：" . $value['shipping_code'],
                    'operator_id' => $this->session->adminInfo['admin_id'],
                    "shipping_code" => $value['shipping_code'],
                    "shipping_type"=>$value['shipping_type']
                        ), $order_info['order_id']
                );
                $order_info['shipping_code'] = $value['shipping_code'];
                $this->sendmessage($order_info);
                $this->session->success = "导入成功，请前去发货!";
                $this->session->mark_as_flash("success");
            }
        }
        $data['error_code'] = 0;
        $this->output->set_output(json_encode($data));
    }

    /**
     * 上传订单数据
     */
    private function upload_order_file() {
        $config['upload_path'] = './upload/temp';
        $config['allowed_types'] = 'xls|xsl|xlsx';
        $config['max_size'] = 10000;
        $config['file_name'] = md5(time());

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('orderFile')) {
            $result = array('error' => $this->upload->display_errors());
        } else {
            $result = array('error' => $this->upload->display_errors(), 'upload_data' => $this->upload->data());
        }
        return $result;
    }

    /**
     * 订单操作历史记录
     * 不再使用分页
     */
    public function history() {
        $order_id = $this->input->get('order_id');
        $data['orderlog'] = $this->OrderModel->getOrderLog($order_id);
        $this->output->set_output($this->load->view('order_history', $data, true));
    }

    /**
     * 订单退款
     */
    public function orderRefund() {
        $order_id = $this->input->post('order_id');
        $orderinfo = $this->OrderModel->getOrderInfo($order_id)['orderinfo'];
        $set_refund_money = $this->input->post('refund_money');
        $refund_remark = $this->input->post('refund_remark');

        if ($orderinfo['status'] == 0) {
            $this->session->set_flashdata('error', '退款失败：订单未支付');
        } elseif ($orderinfo['refunds_status'] == 2) {
            $this->session->set_flashdata('error', '退款失败：订单已退款请勿重复操作');
        } else {
            $result = $this->doRefund($orderinfo, $set_refund_money);
            if ($result) {
                $updata['refunds_status'] = 2;
                $updata['status'] = 8;
                $updata['operator_id'] = $this->session->adminInfo['admin_id'];
                $updata['content'] = "管理员：" . $this->session->adminInfo['name'] . "备注:" . $refund_remark . ',更改订单状态：已退款';
                $this->OrderModel->editOrderStatus($updata, $orderinfo['order_id']);

                $this->session->set_flashdata('success', '退款成功：已退金额' . $set_refund_money);
            } else {
                $this->session->set_flashdata('error', '退款失败：其它原因');
            }
        }
        redirect(site_url("Order/editOrderInfo/" . $order_id));
    }

    /**
     * 
     * @param type $orderinfo
     * @param type $set_refund_money 退还金额
     */
    private function doRefund($orderinfo, $set_refund_money) {
        $pay_money = $orderinfo['pay_money'];
        $use_balance = $orderinfo['use_balance'];
        $user_id = $orderinfo['user_id'];

        $refund_money = $pay_money >= $set_refund_money ? $set_refund_money : $pay_money;
        $order_sn = $orderinfo['order_sn'];
        //从系统中获取退还方式：退还到余额还是原路退还
        $refund_path = $this->zmsetting->get("refund_path");
        if ($refund_path) {//原路退还：目前仅支持微信支付
            if ($use_balance > 0) {
                $result = $this->balance_refund($user_id, $use_balance);
            }
            if ($use_balance < $refund_money) {
                if ($orderinfo['payment_id'] == 2) {//微信支付
                    $data['out_trade_no'] = $order_sn;
                    $data['transaction_id'] = $orderinfo['trade_no'];
                    $data['out_refund_no'] = $order_sn;
                    $data['total_fee'] = ($orderinfo['pay_money'] - $use_balance) * 100;
                    $data['refund_fee'] = ($refund_money - $use_balance) * 100;
                    $result = $this->wechat_refund($data);
                }
            }
        } else {//全部退还到余额
            $result = $this->balance_refund($user_id, $refund_money);
        }

        return $result;
    }

    /**
     * 退款到余额
     */
    private function balance_refund($user_id, $money) {
        $this->load->model('UserModel');
        $accountdata = array(
            'user_id' => $user_id,
            'change_money' => $money,
            'change_cause' => '订单退款',
            'createtime' => time(),
        );
        return $this->UserModel->editUserTransaction($accountdata);
    }

    /**
     * 小程序退款
     */
    private function wechat_refund($refunddata) {
        //获取支付配置参数
        $wxpayconfig = $this->zmsetting->getSettingsByGroup("wechatpay");
        $payconfigs = array(
            "partnerkey" => $wxpayconfig['wxpay_key'],
            "appid" => $wxpayconfig['wxpay_appid'],
            "mch_id" => $wxpayconfig['mch_id'],
            "ssl_key" => $wxpayconfig['wx_apiclient_key'],
            "ssl_cer" => $wxpayconfig['wx_apiclient_cert'],
        );

        $this->load->library("wechat_pay", $payconfigs); //加载支付类库
        return $this->wechat_pay->refund($refunddata['out_trade_no'], $refunddata['transaction_id'], $refunddata['out_trade_no'], $refunddata['total_fee'], $refunddata['refund_fee']);
    }

    /**
     * 主订单发货
     */
    public function delivery() {
        $shipping_code = $this->input->post("shipping_code");
        $shipping_type = $this->input->post("shipping_type");
        $order_id = $this->input->post("order_id");
        $orderinfo = $this->OrderModel->getOrderInfo($order_id);
        $success = '';
        $error = '';
        if (empty($orderinfo['orderinfo']['shipping_code'])) {
            //主订单发货
            $data = array(
                'status' => 2,
                'content' => '管理员' . $this->session->adminInfo['name'] . "发货:" . $shipping_code,
                'shipping_code' => $shipping_code,
                'shipping_type'=>$shipping_type,
                'operator_id' => $this->session->adminInfo['admin_id'],
                'shippingtime' => time()
            );
            if ($this->OrderModel->editOrderStatus($data, $order_id)) {
                $orderinfo['orderinfo']['shipping_code'] = $shipping_code;
                //'短信提醒' . $this->sendsms($orderinfo['orderinfo']['telephone'], $orderinfo['orderinfo']['order_sn']) .
                $success = '小程序提醒' . $this->sendmessage($orderinfo['orderinfo']) . '主单';
            } else {
                $error = '主单';
            }
        }
        foreach ($orderinfo['suborders'] as $value) {
            if (empty($value['shipping_code'])) {
                //子订单发货
                $data = array(
                    'status' => 2,
                    'content' => '管理员' . $this->session->adminInfo['name'] . "发货:" . $shipping_code,
                    'shipping_code' => $shipping_code,
                    'operator_id' => $this->session->adminInfo['admin_id'],
                    'shippingtime' => time()
                );
                if ($this->OrderModel->editOrderStatus($data, $value['order_id'])) {
                    $success .= '子单' . $value['order_id'];
                } else {
                    $error .= '子单' . $value['order_id'];
                }
            }
        }
        if (!empty($success))
            $this->session->set_flashdata('success', $success . '发货操作成功');
        if (!empty($error))
            $this->session->set_flashdata('error', '发货操作失败');
        $this->editOrderInfo($order_id);
    }

    /**
     * 子订单发货
     */
    public function subDelivery() {
        $shipping_code = $this->input->post("shipping_code");
        $order_id = $this->input->post("order_id");
        $orderinfo = $this->OrderModel->getSubOrderInfo($order_id);

        if (empty($orderinfo['shipping_code'])) {
            //主订单发货
            $data = array(
                'status' => 2,
                'content' => '管理员' . $this->session->adminInfo['name'] . "发货:" . $shipping_code,
                'shipping_code' => $shipping_code,
                'operator_id' => $this->session->adminInfo['admin_id'],
                'shippingtime' => time()
            );
            if ($this->OrderModel->editOrderStatus($data, $order_id)) {

                $orderinfo['shipping_code'] = $shipping_code;
                $msg = '短信提醒' . $this->sendsms($orderinfo['telephone'], $orderinfo['order_sn']) . '程序提醒' . $this->sendmessage($orderinfo);
                $this->session->set_flashdata('success', '发货操作成功' . $msg);
            } else {
                $this->session->set_flashdata('error', '发货操作失败');
            }
        }
        $type = $this->input->post("type");
        if (!empty($type)) {
            $this->subOrderInfo($order_id);
        }
        $this->editOrderInfo($orderinfo['master_info']['order_id']);
    }

    public function deleteOrder() {
        $return = $this->input->post('selected');
        if (!empty($return) && is_array($return)) {
            $where = implode(',', $this->input->post('selected'));
            if ($this->OrderModel->delectOrder('order_id in (' . $where . ')')) {
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
        redirect(site_url('Order/index'));
    }

    public function sendmessage($orderinfo) {
        $config = array(
            'appid' => $this->zmsetting->get("wechat_fun_id"),
            'appsecret' => $this->zmsetting->get("wechat_fun_secret")
        );
        $this->load->model('FormIdModel');
        $this->load->model('UserModel');
        $userinfo = $this->UserModel->getUserById($orderinfo['user_id'], 1);
        $formidinfo = $this->FormIdModel->getFormId($orderinfo['user_id']);

        $this->load->library('wechat_tmplmsg', $config);

        $data['touser'] = $userinfo['wx_fun_openid'];
        $data['form_id'] = $formidinfo['formid'];
        $data['page'] = "pages/my/my";
        $data['template_id'] = 'z7w-J7wkpE5WoemAKjQJGPzTLFYfE7CuzOkch5BtJ8g';
        $data['data'] = array(
            'keyword1' => array('value' => $orderinfo['order_sn']),
            'keyword2' => array('value' => $orderinfo['fullname']),
            'keyword3' => array('value' => $orderinfo['shipping_code'])
        );
        $data['emphasis_keyword'] = 'keyword2';

        $token = $this->wechat_tmplmsg->checkAuth();
        $res = $this->wechat_tmplmsg->sendmessage($token, $data);
        if ($res == 'ok') {
            $msg = '成功';
        } else {
            $msg = '失败' . $res;
        }
        if ($formidinfo['source_field'] == 'sub_pay') {
            $updata['status'] = $formidinfo['status'] + 1;
        } else {
            $updata['status'] = 1;
        }
        $updata['temp_msginfo'] = '订单' . $orderinfo['order_sn'] . '发送' . $msg;
        $updata['sendtime'] = time();

        $this->FormIdModel->editformid($updata, array('id' => $formidinfo['id']));
        return $msg;
    }

    public function sendsms($phone, $order_sn) {
        //获取系统阿里云短信的配置信息
        $accessId = $this->zmsetting->get("alisms_accessid");
        $accessSecret = $this->zmsetting->get("alisms_accessecret");
        $singname = $this->zmsetting->get("alisms_singname");

        $config = array("accessId" => $accessId, "accessSecret" => $accessSecret, "singname" => $singname);
        $this->load->library("aliyunsms", $config);
        $content = array("ordersn" => $order_sn);
        $sendResult = $this->aliyunsms->sendSMS($phone, $content, "SMS_144795144");

        if ($sendResult['Code'] == "OK") {
            return '成功';
        }
        return '失败';
    }

    /**
     * 读取订单数据
     */
    private function read_xls_data($filepath) {

        require_once '../zmcore/libraries/phpexcel/PHPExcel/IOFactory.php';

        $extension = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));

        if ($extension == 'xlsx') {
            $reader = IOFactory::createReader('Excel2007');
        } elseif ($extension == 'xls') {
            $reader = IOFactory::createReader('Excel5');
        } elseif ($extension == 'csv') {
            $reader = IOFactory::createReader('CSV');
        }
        $excel = $reader->load($filepath, 'utf-8');

        $sheet = $excel->getSheet(0); // 读取第一個工作表
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数

        $data = array();
        for ($rowIndex = 1; $rowIndex <= $highestRow; $rowIndex++) {        //循环读取每个单元格的内容。注意行从1开始，列从A开始
            for ($colIndex = 'A'; $colIndex <= $highestColumm; $colIndex++) {
                $addr = $colIndex . $rowIndex;
                $cell = $sheet->getCell($addr)->getValue();
                if ($cell instanceof PHPExcel_RichText) { //富文本转换字符串
                    $cell = $cell->__toString();
                }
                $data[$rowIndex][$colIndex] = $cell;
            }
        }
        $tempdata = array();
        $count_product = array();
        $row = 0;

        foreach ($data as $k => $d) {
            if ($k == 1) {
                continue;
            }
            if ($d['A']) {
                $row++;
                $tempdata[$row] = array(
                    "order_sn" => $d['A'],
                    "shipping_code" => $d['B'],
                        "shipping_type"=>$d['C']
                );
            }
        }
        $result = array("rows" => $highestRow, "cols" => $highestColumm, "data" => $tempdata);
        return $result;
    }

}
