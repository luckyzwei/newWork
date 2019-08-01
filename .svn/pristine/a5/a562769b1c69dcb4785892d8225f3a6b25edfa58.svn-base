<?php

/**
 * 2018年3月2日有User改名此类
 * 区分与lib层同名问题
 * 会员中心管理
 * 
 * @package	ZMshop
 * @author	wang
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class Personal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //当前控制器会使用到的类文件自动加载
        $this->load->model("UserModel");
        $this->load->model("OrderModel");
    }

    public function get_personal() {
        $json = array();
        $user_id = $this->user->getuser_id();
        if (empty($user_id)) {
            $json['result'] = 2;
            $json['msg'] = '未登录';
            $json['data']['redirectURL'] = urlencode('/personal.php');
        }
        //获取会员资料
        if (empty($json)) {
            $table = array(
                'from' => 'user u',
                'join' => array(
                    array(
                        'table' => 'user_level ul',
                        'condition' => 'ul.level_id=u.level_id',
                        'associated' => 'left'
                    ),
                    array(
                        'table' => 'user_group ug',
                        'condition' => 'ug.user_group_id=u.user_group_id',
                        'associated' => 'left'
                    ),
                )
            );
            $files = 'u.nickname,u.user_intergal,ul.level_name,ul.level_image,ug.user_group_name';
            $userinfo = $this->UserModel->getUserInfo('u.user_id=' . $user_id, $table, $files);
            $userinfo['rank'] = $this->UserModel->gerRank($user_id); //排名
        }
        //获取订单相关信息
        if (empty($json)) {
            $order = $countpay = $this->OrderModel->getOrderListCount($user_id, 'all', array(), 'pay_money'); //总成交额
            $order['newcount'] = $this->OrderModel->getOrderListCount($user_id,'all',array('fasttime'=>mktime(0, 0, 0, date('m'), date('d'), date('Y')),'lasttime'=>time())); //未支付
            $order['status0'] = $this->OrderModel->getOrderListCount($user_id, '0'); //未支付
            $order['status1'] = $this->OrderModel->getOrderListCount($user_id, '1'); //代发货
            $order['status2'] = $this->OrderModel->getOrderListCount($user_id, '2'); //待收货
            $order['status4'] = $this->OrderModel->getOrderListCount($user_id, '4'); //售后
        }
        //获取站内消息
        if (empty($json)) {
            
        }
        //获取广告
        if (empty($json)) {
            $addata = array(
                'image' => 'http://iph.href.lu/260x90',
                'name' => '分类页广告1',
                'title' => '热卖',
                'adurl' => 'http://m.zmshop.com'
            );
            $json['result'] = 1;
            $json['msg'] = 'ok';
            $json['data']['userinfo'] = $userinfo;
            $json['data']['orderinfo'] = $order;
            $json['data']['adinfo'] = $addata;
        }

        $this->output->set_output(json_encode($json));
    }

    //获取会员资料
    public function get_data() {
        $user_id = $this->user->getuser_id();
        $res = $this->UserModel->getzl($user_id);
        $json['result'] = 1;
        if (!empty($res)) {
            foreach ($res as $value) {
                $arr = array();
                $arr['nickname'] = $value['nickname'];
                $arr['email'] = $value['email'];
            }
            $json['data'] = $arr;
        } else {
            $json['result'] = 0;
            $json['msg'] = '抱歉,该用户不存在';
        }
        $this->output->set_output(json_encode($json));
    }

    //修改会员资料
    public function edit_data() {
        $this->load->library('form_validation');
        $user_id = $this->User->getuser_id();
        if ($this->input->method() == "post") {
            $this->form_validation->set_rules("nickname", "会员昵称不能为空,并且不能大于21个汉字", "max_length[64]|required");
            $this->form_validation->set_rules("email", "邮箱不能为空,并且邮箱格式填写正确", "valid_email|required");
            if ($this->form_validation->run() == true) {
                $data = array(
                    "nickname" => $this->input->post('nickname'),
                    "email" => $this->input->post('email'),
                    "updatatime" => time()
                );
                $res = $this->UserModel->editzl(array("user_id" => $user_id), $data);
                if (!empty($res)) {
                    $json['result'] = 1;
                    $json['msg'] = '恭喜你,修改资料成功';
                } else {
                    $json['result'] = 0;
                    $json['msg'] = '抱歉,用户不存在';
                }
            } else {
                $data['error'] = $this->form_validation->error_string();
                $data['user'] = $this->input->post();
                $this->output->set_output($data);
            }
        } else {
            $json['result'] = 0;
            $json['msg'] = '很抱歉 ,操作异常';
        }
        $this->output->set_output(json_encode($json));
    }

    //修改会员密码验证短信次数
    public function ycode() {
        $user_id = $this->User->getuser_id();
        $json['result'] = 1;
        if ($this->input->method() == "post") {
            $mobile = $this->input->post('mobile');
            $tel = $this->UserModel->tel($mobile, array('user_id' => $user_id));
            if ($tel === true) {
                $code = rand(1000000, 9000000);
                $this->send;  //调用短信服务给用户发送短信
                $data = array();
                $data['user_id'] = $user_id;
                $data['mobile'] = $mobile;
                $data['content'] = $code;
                $data['template_id'] = 1;
                $data['createtime'] = time();
                $this->UserModel->ccode($data);
            } elseif ($tel == falss) {
                $json['result'] = 0;
                $json['msg'] = '很抱歉,当天修改密码发送短信次数已超过3次,请明天再试';
            } elseif ($tel == null) {
                $json['result'] = 0;
                $json['msg'] = '很抱歉,填写的手机号与用户注册绑定的手机不一致';
            }
        }
        $this->output->set_output(json_encode($json));
    }

    //判断用户提交的验证码并执行修改密码
    public function edit_pass() {
        $user_id = $this->User->getuser_id();
        if ($this->input->method() == "post") {
            $code = $this->input->post('code');
            $mobile = $this->input->post('mobile');
            $res = $this->UserModel->editpass(array('content' => $code, 'mobile' => $mobile));
            if ($res == true) {
                $data = array(
                    "password" => md5($this->input->post('password'))
                );
                $jg = $this->UserModel->editmm($data, array("user_id" => $user_id));
                if (!empty($jg)) {
                    $json['result'] = 1;
                    $json['msg'] = '恭喜你,修改密码成功';
                } else {
                    $json['result'] = 0;
                    $json['msg'] = '抱歉,帐号不存在';
                }
            } else {
                $json['result'] = 0;
                $json['msg'] = '验证码有误,请重新输入';
            }
        }
        $this->output->set_output(json_encode($json));
    }

    //修改手机号
    public function ytel() {
        $user_id = $this->User->getuser_id();
        $json['result'] = 1;
        if ($this->input->method() == 'post') {
            $mobile = $this->input->post('mobile');
            $res = $this->UserModel->ytel(array("user_id" => $user_id));
            if ($res == true) {
                $code = rand(1000000, 9000000);
                $this->send;  //调用短信服务给用户发送短信
                $data = array();
                $data['user_id'] = $user_id;
                $data['mobile'] = $mobile;
                $data['content'] = $code;
                $data['template_id'] = 2;
                $data['createtime'] = time();
                $this->UserModel->ccode($data);
            } elseif ($res == false) {
                $json['result'] = 0;
                $json['msg'] = '当天修改手机号已经超过3次,请次日再试';
            }
        }
        $this->output->set_output(json_encode($json));
    }

    //执行修改手机号
    public function edit_tel() {
        $user_id = $this->User->getuser_id();
        if ($this->input->method === "post") {
            $mobile = $this->input->post('mobile');
            $code = $this->input->post('code');
            $res = $this->UserMode->edittel(array('content' => $code));
            if ($res == true) {
                $this->UserModel->editsj($mobile, array('user_id' => $user_id));
                $json['result'] = 1;
                $json['msg'] = '恭喜你,修改手机号成功';
            } else {
                $json['result'] = 0;
                $json['msg'] = '验证码有误,请重试';
            }
        }
        $this->output->set_output(json_encode($json));
    }

    //获取站内短信列表
    public function get_msg() {
        $user_id = $this->User->getuser_id();
        $res = $this->UserModel->getList();
        if (!empty($res)) {
            foreach ($res as $value) {
                $arr = array();
                $arr['msg_id'] = $value['msg_id'];
                $arr['send_user'] = $value['send_user'];
                $arr['content'] = $value['content'];
                $arr['createtime'] = $value['createtime'];
            }
            $json['data'] = $arr;
        } else {
            $json['result'] = 0;
            $json['msg'] = '暂无站内短信';
        }
        $this->output->set_output(json_encode($json));
    }

}
