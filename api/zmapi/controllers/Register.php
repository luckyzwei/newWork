<?php

/**
 * 注册控制器
 * 
 * @package	ZMshop
 * @author	wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class Register extends CI_Controller {

    /**
     * 手机号注册账号
     * 手机号找回密码
     */
    public function phone_register() {
        $json = array();
        $phone = $this->input->post("phone");
        $code = $this->input->post("code");
        $password = $this->input->post("password");
        if (empty($phone)) {
            $json['result'] = 0;
            $json['msg'] = "手机号不能为空";
        }
        if (empty($code)) {
            $json['result'] = 0;
            $json['msg'] = "验证码不能为空";
        }
        if (empty($password)) {
            $json['result'] = 0;
            $json['msg'] = "密码不能为空";
        }
        if (empty($json)) {
            //效验验证码
            $this->load->model("SmsModel");
            $result = $this->SmsModel->checkCode(array("mobile" => $phone, "code" => $code,'lasttime >'=>time()-300));
            if (empty($result)) {
                $json['result'] = 0;
                $json['msg'] = "验证码错误或已过期";
            } else {
                $this->SmsModel->setSmsLog($phone, 0, 0);
                $this->load->model("UserModel");
                $user_id = $this->UserModel->checkUser("user_name = " . $phone);
                if (empty($user_id)) {
                    //注册
                    $data = array(
                        "user_name" => $phone,
                        "nickname" => substr_replace($phone,'****',3,4),
                        "password" => md5($password),
                        "level_id" => $this->user->getlevel_id(),
                        "user_group_id" => $this->user->getuser_group_id(),
                        "createtime" => time()
                    );
                    $user_id = $this->UserModel->addUser($data);
                    $this->session->user_id = $user_id;
                } else {
                    //修改或者短信登陆
                    $data = array(
                        "password" => md5($password),
                    );
                    $this->UserModel->updateUser($data, $user_id);
                    $this->session->user_id = $user_id;
                }
                $json['result'] = 1;
                $json['msg'] = "成功-跳转个人页";
            }
        }
        $this->output->set_output(json_encode($json));
    }

    /**
     * 发送验证码
     */
    public function send_sms() {
        $json = array();
        $phone = $this->input->post("phone");
        if (empty($phone)) {
            $json['result'] = 0;
            $json['msg'] = "手机号不能为空";
        }
        //验证是否已注册
        if (empty($json)) {
            $this->load->model("UserModel");
            $user_id = $this->UserModel->checkUser("user_name = " . $phone);
            if (!empty($user_id)) {
                $json['result'] = 0;
                $json['msg'] = "手机号已注册";
            }
        }
        //验证发送限制
        if (empty($json)) {
            $this->load->model("SmsModel");
            //检测session是否有值  按顺序执行不会出错哦
            if (!$this->session->has_userdata('lasttime')) {
                $smsinfo = $this->SmsModel->getSmslog($phone);
                if (empty($smsinfo)) {
                    $smsinfo = $this->SmsModel->addSmslog($phone);
                    $this->session->lasttime = time() - 6 * 60;
                    $this->session->count = 0;
                } else {
                    $this->session->lasttime = $smsinfo['lasttime'];
                    $this->session->count = $smsinfo['count'];
                }
            }
            $intervaltime = time() - $this->session->lasttime;
            //如果错误是昨天的那么就重置登陆错误次数
            if ($intervaltime > 24 * 60 * 60) {
                $this->SmsModel->setSmsLog($phone, 1);
                $this->session->count = 0;
                //防止下一步检测上一次冷却
                $this->session->lasttime = time() - 6 * 60;
                $intervaltime = 601;
            }
            //验证距离上次的发送时间 有效期10分钟
            if ($intervaltime < 5 * 60) {
                $json['result'] = 0;
                $json['msg'] = "等待" . $intervaltime . "秒后再试";
            }
            //验证次数
            if ($this->session->count >= 5) {
                $json['result'] = 0;
                $json['msg'] = '当天发送短信超过限制次数';
            }
            //密码账号以验证
            if (empty($json)) {
                $code = rand(1000, 9999);
                //$this->load->library("Systemsetting");
                $smsconfig = array(
                    "accessId" => "LTAIOS8jAvEceoxa", //$this->systemsetting->get();
                    "accessSecret" => "TWzgdXDFUA8FztMJ79Uq2OD4VGD48b", //$this->systemsetting->get();
                    "singname" => "知默商城"//$this->systemsetting->get();
                );
                $this->load->library("Aliyunsms", $smsconfig);
                $templateid = "SMS_126745015";
                $msg = array("code" => $code);
                //$result = $this->aliyunsms->sendSMS($phone, $msg, $templateid);
                if (1) {//$result['Message'] == 'OK' && $result['Code'] == 'OK') {
                    $this->SmsModel->setSmsLog($phone, 0, $code);
                    $json['result'] = 0;
                    $json['msg'] = "短信发送成功";
                } else {
                    $json['result'] = 0;
                    $json['msg'] = "出错:" . $result['Message'];
                }
            }
        }
        if (empty($json)) {
            $json['result'] = 0;
            $json['msg'] = "发送短信出错";
        }
        $this->output->set_output(json_encode($json));
    }

}
