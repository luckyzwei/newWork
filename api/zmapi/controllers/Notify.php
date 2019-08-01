<?php

/**
 * 异步通知函数
 * 主要接受支付回调信息
 * 
 * @package	ZMshop
 * @author	qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class notify extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("userModel");
        $this->load->model("paylogModel");
        $this->load->model("userAccountLogModel");
    }

    /**
     * 微信小程序支付回调
     */
    public function wechat_fun() {
        $xml = file_get_contents("php://input");
        $fp = fopen("result.txt", "a+");
        fwrite($fp, $xml . "\r\n");
        fclose($fp);

        $obj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $result_array = json_decode(json_encode($obj), true);
        if ($result_array["result_code"] == "SUCCESS") {
//获取支付配置参数
            $partnerkey = $this->systemsetting->get("wxpay_key");
            $this->load->library("wechat_pay", array()); //加载支付类库
            $sign = $result_array['sign'];
            unset($result_array['sign']);

            $method = explode("|", $result_array['attach'])[0];

            $my_sign = $this->wechat_pay->getPaySign($result_array, $partnerkey);
            if ($sign == $my_sign) {//签名验证通过
                if ($this->{'callback_do_' . $method}($result_array)) {
                    echo "success";
                }
            }
        }
    }

    /**
     * 用户扫码支付回调
     * @param type $result_array
     */
    private function callback_do_qrrecharge($result_array) {
        $this->load->model("rechargeOrderModel");
        $recharge_order = $this->rechargeOrderModel->getRcOrderBySn($result_array['out_trade_no']);
        if (!empty($recharge_order) && $recharge_order['money'] <= $result_array['total_fee'] && $recharge_order['status'] == 0) {
            //更新订单状态
            $this->rechargeOrderModel->updateRcOrder(array("status" => 1, "trade_no" => $result_array['transaction_id']), $result_array['out_trade_no']);
            //写支付日志
            $log = array(
                "order_id" => "QRRC_" . $recharge_order['rc_order_id'],
                "order_sn" => $recharge_order['rc_order_sn'],
                "pay_money" => $recharge_order['money'],
                "trade_no" => $result_array['transaction_id'],
                "pay_status" => 1,
                "payment_id" => 2,
                "remark" => "扫码支付"
            );
            $this->paylogModel->addPayLog($log);
            if (!empty($recharge_order['remarks'])) {
                $this->userModel->setUserMoney($recharge_order['user_id'], -(float) $recharge_order['remarks']);
                //写账户变更日志
                $data = array(
                    "user_id" => $recharge_order['user_id'],
                    "change_money" => $recharge_order['money'],
                    "change_cause" => "扫码支付余额扣除" . $recharge_order['remarks'] . "微信支付订单号：" . $recharge_order['rc_order_id'],
                    "createtime" => time()
                );
                $this->userAccountLogModel->addAccountLog($data);
            }
        }
    }

    /**
     * 用户充值回调
     * @param type $result_array
     */
    private function callback_do_recharge($result_array) {
        $this->load->model("rechargeOrderModel");
        $recharge_order = $this->rechargeOrderModel->getRcOrderBySn($result_array['out_trade_no']);
        if (!empty($recharge_order) && $recharge_order['money'] <= $result_array['total_fee'] && $recharge_order['status'] == 0) {
            //更新订单状态
            $this->rechargeOrderModel->updateRcOrder(array("status" => 1, "trade_no" => $result_array['transaction_id']), $result_array['out_trade_no']);
            //写支付日志
            $log = array(
                "order_id" => "RC_" . $recharge_order['rc_order_id'],
                "order_sn" => $recharge_order['rc_order_sn'],
                "pay_money" => $recharge_order['money'],
                "trade_no" => $result_array['transaction_id'],
                "pay_status" => 1,
                "payment_id" => 2,
                "remark" => "充值"
            );
            $this->paylogModel->addPayLog($log);
            //增加用户余额
            if ($this->userModel->setUserMoney($recharge_order['user_id'], $recharge_order['money'])) {
                //写账户变更日志
                $data = array(
                    "user_id" => $recharge_order['user_id'],
                    "change_money" => $recharge_order['money'],
                    "change_cause" => "充值订单：" . $recharge_order['rc_order_id'],
                    "createtime" => time()
                );
                $this->userAccountLogModel->addAccountLog($data);
                //查询可满足的充值策略
                $this->load->model("RechargeStrategy");
                $rechargestrategy = $this->RechargeStrategyModel->getRecharges($recharge_order['money']);
                if ($rechargestrategy['give_type'] == 'give_amount') {//give_amount:赠送金额，give_intergal:赠送积分，give_product:赠送商品，give_coupon:赠送优惠卷
                    if ($rechargestrategy['give_amount'] < 1) {
                        $strategy_money = bcmul($rechargestrategy['give_amount'], $recharge_order['money'], 2);
                    } else {
                        $strategy_money = $rechargestrategy['give_amount'];
                    }
                    if ($this->userModel->setUserMoney($recharge_order['user_id'], $strategy_money)) {
                        //写账户变更日志
                        $data = array(
                            "user_id" => $recharge_order['user_id'],
                            "change_money" => $strategy_money,
                            "change_cause" => "充值订单" . $recharge_order['rc_order_id'] . "满足" . $rechargestrategy['strategy_name'] . "赠送" . $strategy_money,
                            "createtime" => time()
                        );
                        $this->userAccountLogModel->addAccountLog($data);
                    }
                } elseif ($rechargestrategy['give_type'] == 'give_product') {
                    
                }
            }
        }
    }

    /**
     * 处理报名订单
     * @param type $result_array
     */
    private function callback_do_activity($result_array) {
        $this->load->model('ActivityModel');
        $activity_id = explode('_', $result_array['out_trade_no']);
        $activityorder = $this->ActivityModel->get_activity_order($activity_id['1']);
        if ($activityorder['price'] * 100 == $result_array['total_fee'] && $activityorder['status'] == 0) {
            //更新订单状态
            $this->ActivityModel->edit_activity($activity_id['1'], array('status' => 1, 'pay_order_sn' => $result_array['out_trade_no'], 'paytag' => $result_array['transaction_id']));
            $pay_log_data = array(
                "pay_money" => $activityorder['price'],
                "order_id" => 'AC_' . $activity_id['1'],
                "order_sn" => $result_array['out_trade_no'],
                "trade_no" => $result_array['transaction_id'],
                "payment_id" => 2,
                "pay_status" => 1,
                "remark" => '在线活动报名'
            );
            $this->paylogModel->addPayLog($pay_log_data);
            return true;
        }
        return false;
    }

    /**
     * 处理订单
     * @param type $result_array 微信支付结果
     */
    private function callback_do_order($result_array) {

        $this->load->model("orderModel");
        $attach = explode("|", $result_array['attach']);

        $order_info = $this->orderModel->getOrderInfo(array("order_sn" => $result_array['out_trade_no']));
        if ($order_info['order_amount'] * 100 == $result_array['total_fee'] && $order_info['status'] == 0) {

            $use_balance = $attach[1];
            $data = array(
                "trade_no" => $result_array['transaction_id'],
                "status" => 1,
                "paytime" => time(),
                "pay_money" => $result_array['total_fee'] / 100,
                "payment_name" => "小程序支付",
            );
            if ($use_balance > 0) {
                $this->operation_user_balance($order_info['user_id'], $use_balance, $order_info['order_id']);
                $data['use_balance'] = $use_balance; //写入订单使用余额

                $pay_log_data = array(
                    "order_id" => $order_info['order_id'],
                    "order_sn" => $order_info['order_sn'],
                    "pay_money" => $use_balance,
                    "trade_no" => "0",
                    "payment_id" => -1,
                    "pay_status" => 1
                );
                $this->paylogModel->addPayLog($pay_log_data);
            }
            //更新订单状态
            $this->orderModel->updateOrder($order_info['order_id'], $data);
            $this->operation_order_marketings($order_info);

            if ($order_info['order_type'] == 'G') {
                $this->operation_order_group($order_info);
            }
            $pay_log_data = array(
                "order_id" => $order_info['order_id'],
                "order_sn" => $order_info['order_sn'],
                "pay_money" => $order_info["order_amount"] - $use_balance,
                "trade_no" => $result_array['transaction_id'],
                "payment_id" => 2,
                "pay_status" => 1
            );
            $this->paylogModel->addPayLog($pay_log_data);
            $this->load->model("staticsModel");
            $this->staticsModel->update(array("payfee", $order_info["order_amount"]));
            $this->staticsModel->update(array("pays", 1));
            //订单日志
            $order_log = array(
                'createtime' => time(),
                'operator_id' => $order_info['user_id'],
                'order_id' => $order_info['order_id'],
                'content' => '用户' . $order_info['user_id'] . '支付订单'
            );
            $this->db->insert('order_log', $order_log);
            return true;
        }
        return false;
    }

    /**
     * 全部余额支付回调
     */
    public function balance_callback() {
        $order_id = $this->input->post("order_id");
        $user_id = $this->session->user_id;

        $this->load->model("orderModel");
        $user_account = $this->userModel->getUserAccount($user_id);
        $order_info = $this->orderModel->getOrderInfo(array("order_id" => $order_id));
        if ($user_account['totalmoney'] >= $order_info['order_amount'] && $order_info['status'] == 0) {
            //更新订单状态
            $data = array(
                "use_balance" => $order_info['order_amount'],
                "status" => 1,
                "paytime" => time(),
                "pay_money" => $order_info['order_amount'],
                "payment_name" => "余额支付"
            );
            $this->orderModel->updateOrder($order_info['order_id'], $data);

            //订单日志
            $order_log = array(
                'createtime' => time(),
                'operator_id' => $order_info['user_id'],
                'order_id' => $order_info['order_id'],
                'content' => '用户' . $order_info['user_id'] . '支付订单'
            );
            $this->db->insert('order_log', $order_log);


            //操作用户余额
            $this->operation_user_balance($user_id, $order_info['order_amount'], $order_id);
            //操作订单策略
            $this->operation_order_marketings($order_info);
            if ($order_info['order_type'] == 'G') {
                $this->operation_order_group($order_info);
            }
            $result = array("result" => "支付成功", "error_code" => 0);
        } else {
            $result = array("result" => "支付失败:余额不足或者订单已支付", "error_code" => 1);
        }
        $this->output->set_content_type("application/json")->set_output(json_encode($result));
    }

    /**
     * 处理订单优惠活动中的赠送积分和优惠券
     * @param type $order_info
     */
    private function operation_order_marketings($order_info) {
        $this->load->model("productModel");
        $marketings = $this->orderModel->getOrderMarketings($order_info['order_id']);
        foreach ($marketings as $marketing) {
            if ($marketing['marketing_kind'] == "achieve_coupon") {//赠送优惠券
                $coupons = array_filter(explode("|", $marketing['content']));
                foreach ($coupons as $coupon_id) {
                    $this->couponModel->setUserCoupon($coupon_id, $order_info['user_id']);
                }
            }
            if ($marketing['marketing_kind'] == "achieve_reward") {//赠送积分
                $intergal = $marketing['content'];
                $this->userModel->setUseIntergal($order_info['user_id'], $intergal);
                //写入积分变更日志
                $data = array(
                    "user_id" => $order_info['user_id'],
                    "change_intergal" => $intergal,
                    "change_cause" => "订单" . $order_info['order_sn'],
                    "createtime" => time()
                );
                $this->userAccountLogModel->addIntergalLog($data);
            }
        }
        //操作商品赠送积分
        $intergal = 0;
        $products = $this->orderModel->getMasterOrderProduct($order_info['order_id']);

        foreach ($products as $product) {
            $intergal += $product['give_intergal'];
        }
        if ($intergal > 0) {
            $this->userModel->setUseIntergal($order_info['user_id'], $intergal);
            //写入积分变更日志
            $data = array(
                "user_id" => $order_info['user_id'],
                "change_intergal" => $intergal,
                "change_cause" => "商品赠送积分",
                "createtime" => time()
            );
            $this->userAccountLogModel->addIntergalLog($data);
        }
    }

    /**
     * 更新团状态
     */
    private function operation_order_group($order_info) {
        $this->load->model('GroupOrderModel');
        $this->load->model('GroupProductModel');
        $groupbuy = $this->GroupOrderModel->getGroupbuyByorder_id($order_info['order_id']);
        if (!empty($groupbuy)) {
            //这里已经不用验证商品过期和团是否已满
            //更新自己的团状态
            $this->GroupOrderModel->upGroupbuy(array('order_id' => $order_info['order_id']), array('status' => 1));
            //获取团内成员数量
            $groupbuys = $this->GroupOrderModel->getGroupLits(array('groupbuy_sn' => $groupbuy['groupbuy_sn'], 'status' => array(1)));
            $groupbuy = array_shift($groupbuys);
            //获取活动详情
            $groupproduct = $this->GroupProductModel->getGroupProduct($groupbuy['group_product_id']);
            //这里是否成团
            if ($groupbuy['group_in_number'] >= $groupproduct['group_user_num']) {
                //更新所有在团人
                $this->GroupOrderModel->upGroupbuy(array('groupbuy_sn' => $groupbuy['groupbuy_sn'], 'status' => 1), array('status' => 2));
            }
        }
    }

    /**
     * 结算操作用户余额账户
     */
    private function operation_user_balance($user_id, $money, $order_id) {
        //减少用户余额
        $user_account = $this->userModel->getUserAccount($user_id);
        $use_settlement_money = 0;
        $use_user_money = 0;
        if ($money <= $user_account['user_money']) {//小于消费账户 
            $this->userModel->setUserMoney($user_id, -$money);
            $use_user_money = $money;
        } else {
            if ($user_account['user_money'] > 0) {
                $this->userModel->setUserMoney($user_id, -$user_account['user_money']);
                $use_user_money = $user_account['user_money'];
                $remaining = $money - $user_account['user_money'];
                //扣除结算账户
                $this->userModel->setUserSettlementMoney($user_id, -$remaining);
                $use_settlement_money = $remaining;
            } else {
                //直接扣除结算账户
                $this->userModel->setUserSettlementMoney($user_id, -$money);
                $use_settlement_money = $money;
            }
        }

        //写日志
        if ($use_user_money > 0) {
            $data = array(
                "user_id" => $user_id,
                "change_money" => -$use_user_money,
                "change_cause" => "消费账户订单消费：" . $order_id,
                "createtime" => time()
            );
            $this->userAccountLogModel->addAccountLog($data);
        }
        if ($use_settlement_money > 0) {
            $data = array(
                "user_id" => $user_id,
                "change_money" => -$use_settlement_money,
                "change_cause" => "结算账户订单消费：" . $order_id,
                "createtime" => time()
            );
            $this->userAccountLogModel->addAccountLog($data);
        }
    }

}
