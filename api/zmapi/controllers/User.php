<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 用户接口类
 * 
 * @package	ZMshop
 * @author	qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("userModel");
        $this->load->model("couponModel");
        $this->load->model("agentModel");
        $this->load->model("agentGroupModel");
        $this->load->model("userAccountLogModel");
    }

    /**
     * 用户登陆
     */
    public function user_login() {
        $login_type = $this->input->post("login_type");
        if (!in_array($login_type, array("wechatmp", "wechatfun", "phone", "account"))) {
            $result = array("error_code" => 1);
        } else {
            $funame = $login_type . "_login";
            $result = $this->$funame();
        }
        $this->output->set_content_type("json/application")->set_output(json_encode($result));
    }

    /**
     * 微信小程序登陆
     */
    private function wechatfun_login() {
        $post_code = $this->input->post("code");
        $parent_user_id = $this->input->post("parent_user_id");
//        var_dump($parent_user_id);die;
        //判断邀请者id是否位代理商或者代理商状态
        $agent = $this->agentModel->getAgentByUserId($parent_user_id);
        if (empty($agent) || $agent['agent_status'] != 1) {
            $parent_user_id = 0;
        }

        if (empty($post_code)) {
            $data['error_code'] = 1;
            return $data;
        }
        $error_code = 0;
        $userbase = $this->get_wx_fun_openid($post_code);
        $result = array();
        if (!empty($userbase['openid'])) {
            $userinfo = $this->userModel->get_wechat_user_info($userbase['openid']);
            
            if (empty($userinfo)) {
                $userbase['parent_user_id'] = $parent_user_id;
                $userinfo = $this->wx_register_user($userbase);
            }
            $this->session->user_id = $userinfo['user_id'];
            $this->session->user_info = $userinfo;
            //小程序会话key session_key
            $this->session->wx_session_key = $userbase['session_key'];
            //检查积分是否可以升级,是否今日已签到
            $user_data = $this->userModel->getUserById($userinfo['user_id']);
            $intergal_log = $logs = $this->userAccountLogModel->getIntergal(array("user_id" => $userinfo['user_id'], "change_type" => 1, "createtime" => time()));
            $userinfo["level_up"] = $this->userModel->check_group($userinfo['user_id'], $user_data['user_intergal']);

            if ($intergal_log) {
                $userinfo["is_sign"] = 1;
            } else {
                $userinfo["is_sign"] = 0;
            }
            //获取当前等级所占积分百分比
            $groups = $this->userModel->getUserGroups();
            foreach ($groups as $key => $value) {
                if ($value["user_group_id"] == $user_data["user_group_id"]) {
                    $last_group = $value;
                }
            }
            if (isset($last_group)) {
                $userinfo["percent"] = $last_group["integral"] / $groups[0]["integral"];
            }
            $result = $userinfo;
        } else {
            $error_code = 1;
        }
        $data = array("error_code" => $error_code, "data" => $result);
        return $data;
    }

    /**
     * 解密微信数据
     * @param type $data
     * @param type $iv
     */
    public function wx_data_descrypt($endata, $iv) {
        $wxappid = $this->systemsetting->get("wechat_fun_id");
        $session_key = $this->session->wx_session_key;
        $params = array("appid" => $wxappid, "sessionKey" => $session_key);
        $this->load->library("wechat_crypt", $params);
        $de_data = $this->wechat_crypt->decryptData($endata, $iv);
        $error_code = 1;
        $result_obj = json_decode($de_data);
        if (is_object($result_obj)) {
            $error_code = 0;
        }
//        $result = array("error_code" => $error_code, "data" => $result_obj);
//        $this->output->set_content_type("json/application")->set_output(json_encode($result));
        return $result_obj;
    }

    /**
     * 更新用户信息
     */
    public function update_user_info() {
        $postdata = elements(array("avatarUrl", "gender", "nickName", "country", "province", "city"), $this->input->post());
        $data = array(
            "wx_nickname" => $postdata['nickName'],
            "wx_headimg" => $postdata['avatarUrl'],
            "wx_gender" => $postdata['gender'],
            "wx_country" => $postdata['country'],
            "wx_province" => $postdata['province'],
            "wx_city" => $postdata['city'],);
        $this->userModel->update_wechat_user($data, $this->session->user_id);
        //更新用户名
        $this->userModel->updateUser(array('nickname' => $postdata['nickName']), $this->session->user_id);

        $resultUserdata = $this->userModel->getUserById($this->session->user_id);
        $this->session->user_info = $resultUserdata;

        $result = array("error_code" => 0, "data" => $resultUserdata);
        $this->output->set_content_type("json/application")->set_output(json_encode($result));
    }

    public function bind_phone() {
        $postdata = elements(array("endata", "iv"), $this->input->post());
        $data = $this->wx_data_descrypt($postdata['endata'], $postdata['iv']);
        $this->userModel->updateUser(array('user_phone' => $data->phoneNumber), $this->session->user_id);
        $resultUserdata = $this->userModel->getUserById($this->session->user_id);
        $this->session->user_info = $resultUserdata;

        $result = array("error_code" => 0, "data" => $resultUserdata);
        $this->output->set_content_type("json/application")->set_output(json_encode($result));
    }

    /**
     * 根据code获取用户的openid
     * @param type $code
     * @return array
     */
    private function get_wx_fun_openid($code) {
        //通过code换取openid
        $wxappid = $this->systemsetting->get("wechat_fun_id");
        $wxsecret = $this->systemsetting->get("wechat_fun_secret");
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" .
                $wxappid . "&secret=" . $wxsecret .
                "&js_code=" . $code .
                "&grant_type=authorization_code";

        $wxresult = file_get_contents($url);
        $result = json_decode($wxresult, true);
        return $result;
    }

    /**
     * 用户openid和union_id注册一个小程序/或者公众号匿名用户
     * @param type $wxbaseinfo 包含openid，和union_id的数组，
     * $openidtype:可选值wx_fun_openid和wx_public_openid
     */
    private function wx_register_user($wxbaseinfo, $openidtype = "wx_fun_openid") {
        $time = time();
        $anonymous = "小程序用户";
        $password = md5($time);
        $group = $this->userModel->getDefaultUserGroup();
        $add_info = array(
            "parent_user_id" => $wxbaseinfo['parent_user_id'] ? $wxbaseinfo['parent_user_id'] : 0,
            "user_name" => $anonymous,
            "password" => $password,
            "createtime" => $time,
            "updatetime" => $time,
            "level_id" => 1,
            'user_group_id' => $group['user_group_id'],
            "last_logintime" => $time,
        );
        $user_id = $this->userModel->addUser($add_info);

        if ($user_id) {
            $wxuserinfo = array(
                "user_id" => $user_id,
                $openidtype => $wxbaseinfo['openid'],
                "wx_union_id" => empty($wxbaseinfo['unionid']) ? "" : $wxbaseinfo['unionid'],
                "createtime" => time()
            );
            $this->userModel->add_wechat_user($wxuserinfo);
        }
        $userinfo = array(
            "user_id" => $user_id,
            "parent_user_id" => $wxbaseinfo['parent_user_id'],
            "user_open_id" => $wxbaseinfo['openid'],
            "wx_union_id" => empty($wxbaseinfo['unionid']) ? "" : $wxbaseinfo['unionid']
        );
        return $userinfo;
    }



    /**
     * 用户中心数据:同时执行用户受益结算，计算推广者等级
     */
    public function user_center_data() {
        $user_id = $this->session->user_id;
        $user_account = $this->userModel->getUserAccount($user_id);
        $user_group = $this->userModel->getUserGroupByUid($user_id);
        $coupon_totalnum = $this->couponModel->getUserCoupons($user_id, 0)['totalnum'];
        //结算用户收益
        $agent = $this->agentModel->getAgentByUserId($user_id);
        if (!empty($agent) && $agent['agent_status'] == 1) {
            $cycle = $this->systemsetting->get("settlement_cycle");
            $this->userModel->settlementReward($user_id, $cycle);
            //推广者等级计算
            $this->mpp_auto_level();
        }
        //结算供货商收益
        $supplier_id = $this->session->user_info['supplier_id'];
        if (!empty($supplier_id)) {
            $this->load->model('SupplierModel');
            $this->SupplierModel->supplierSettlement($supplier_id, $cycle);
        }
        $data = array("user_account" => $user_account, "user_group" => $user_group, "coupon_num" => $coupon_totalnum);
        $json = array("error_code" => 0, "data" => $data);
        $this->output->set_content_type("json/application")->set_output(json_encode($json));
    }

    /**
     * 推广者自动升级：根据一级返利的高低来进行自动升级
     */
    private function mpp_auto_level() {
        $user_id = $this->session->user_id;

        if ($this->systemsetting->get("agent_auto_level")) {
            $agentGroups = $this->agentGroupModel->getAgentGroups();
            foreach ($agentGroups as $group) {

                $commission_rate = unserialize($group['commission_rate']);
                $temp["x".$group['agent_group_id']] = $commission_rate;
                $sortindex[] = $commission_rate[0];
            }
            array_multisort($sortindex, SORT_ASC, $temp);
            $index = 0;
            $nextlevelid = "";
            foreach ($temp as $key => $t) {
                if ($key == "x".$this->session->user_info['agent_group_id']) {
                    $nextlevelid = key($temp);
                    break;
                }
                $index++;
            }

            if ($nextlevelid!==""&&$nextlevelid!="x1") {
                $nextlevelid= str_replace("x", "", $nextlevelid);
                $nextgroup = $this->agentGroupModel->sel($nextlevelid);

                $need_reward = "noset";
                if ($nextgroup['need_reward']) {//用户佣金
                    $this->load->model("storeOrderModel");
                    $userReward = $this->storeOrderModel->countStroeOrders($user_id, -1)['reward'];
                    if ($userReward >= $nextgroup['need_reward']) {
                        $need_reward = true;
                    } else {
                        $need_reward = false;
                    }
                }

                $need_member = "noset";
                if ($nextgroup['need_member']) {//邀请会员数量
                    $member = $this->userModel->getUserFriendsCount($user_id, -1);
                    if ($member >= $nextgroup['need_member']) {
                        $need_member = true;
                    } else {
                        $need_member = false;
                    }
                }

                //判断条件为并且的时候，两者必须设置一个并且有一个为真；条件或者时：两者必须设置一个并且有一个为真

                $allow_next_level = false;
                if ( "noset"===$need_member) {
                    $allow_next_level = (  "noset"===$need_reward || !$need_reward) ? false : true;
                } elseif ("noset"===$need_reward) {
                    $allow_next_level = ("noset"===$need_member || !$need_member) ? false : true;
                } else {
                    if ($nextgroup['condation']) {
                        $allow_next_level = $need_member && $need_reward;
                    } else {
                        $allow_next_level = $need_member || $need_reward;
                    }
                }

                if ($allow_next_level) {
                    $this->agentModel->updateAgent(array("agent_group_id"=> $nextgroup['agent_group_id']),$this->session->user_info['agent_id']);
                }
            }
        }
    }

    /**
     * 保存用户的扩展信息
     * array(array(key=>array(name=>name,value=>value)))
     */
    public function save_user_extends() {
        $user_id = $this->session->user_id;
        $extends = $this->input->post("userExtends");
        $extendstr = serialize($extends);
        $this->userModel->updateUser(array("extends" => $extendstr), $user_id);

        $json = array("error_code" => 0, "data" => $extends);
        $this->output->set_content_type("json/application")->set_output(json_encode($json));
    }

    /**
     * 获取用户的扩展信息
     */
    public function get_user_extends() {
        $user_id = $this->session->user_id;
        $extends = $this->userModel->getUserExtends($user_id);
        $json = array("error_code" => 0, "data" => $extends);
        $this->output->set_content_type("json/application")->set_output(json_encode($json));
    }

    /**
     * 账户变更日志
     */
    public function get_account_log() {
        $this->load->model("userAccountLogModel");
        $user_id = $this->session->user_id;
        $user_account = $this->userModel->getUserAccount($user_id);
        $cash_money_limit = $this->systemsetting->get("cash_money_limit");
        $logs = $this->userAccountLogModel->getAccountLog($user_id);
        $json = array("error_code" => 0, "data" => array("account" => $user_account, "logs" => $logs, "cash_money_limit" => $cash_money_limit));
        $this->output->set_content_type("json/application")->set_output(json_encode($json));
    }
    /**
     * 获取用户提现申请记录
     */
    public function get_user_cash_list(){
         $this->load->model("cashAppModel");
        $user_id = $this->session->user_id;
        $logs = $this->cashAppModel->getApplicationById($user_id);
        $json = array("error_code" => 0, "data" => $logs);
        $this->output->set_content_type("json/application")->set_output(json_encode($json));
    }

    /**
     * 积分变更日志
     */
    public function get_intergal_log() {
        $this->load->model("userAccountLogModel");
        $user_id = $this->session->user_id;
        $user_account = $this->userModel->getUserAccount($user_id);
        $logs = $this->userAccountLogModel->getIntergalLog($user_id);
        $json = array("error_code" => 0, "data" => array("account" => $user_account, "logList" => $logs));
        $this->output->set_content_type("json/application")->set_output(json_encode($json));
    }

    /**
     * 积分变更
     */
    public function up_intergal() {
        $intergal = $this->input->post('change_intergal');
        $remark = $this->input->post('remark');
        $change_type = $this->input->post('change_type');
        $user_id = $this->session->user_id;
        $user_account = $this->userModel->setUseIntergal($user_id, $intergal);
        $logs = $this->userAccountLogModel->addIntergalLog(array("user_id" => $user_id, "change_intergal" => $intergal, "change_cause" => $remark, "createtime" => time(), "change_type" => $change_type));
        $json = array("error_code" => 0, "data" => array("account" => $user_account, "logList" => $logs));
        $this->output->set_content_type("json/application")->set_output(json_encode($json));
    }

    public function get_user_data() {
        $user_id = $this->session->user_id;
        $user_data = $this->userModel->getUserById($user_id);
        $intergal_log = $logs = $this->userAccountLogModel->getIntergal(array("user_id" => $user_id, "change_type" => 1, "createtime" => time()));
        $user_data["level_up"] = $this->userModel->auto_upgrade($user_id, $user_data['user_intergal']);
        if ($intergal_log) {
            $user_data["is_sign"] = 1;
        } else {
            $user_data["is_sign"] = 0;
        }
        $this->output->set_content_type("json/application")->set_output(json_encode(array("error_code" => 0, "data" => $user_data)));
    }

    /**
     * 获取用户的轨迹
     */
    public function get_user_trail() {
        $this->load->model("UserTrailModel");
        $this->load->model("ProductModel");
        $this->load->helper("string");
        $user_id = $this->session->user_info['user_id'];
        $limit = $this->input->post('limit');
        $limit = $limit ? $limit : 20;

        $page = $this->input->post('page');
        $page = $page ? $page : 1;
        $products = $this->UserTrailModel->getUserTrail(' ut.user_id = ' . $user_id, $limit, $page);
        if (!empty($products)) {
            foreach ($products as &$product) {
                $product['user_price'] = $this->ProductModel->getUserDiscountPrice($user_id, $product['product_id']);
                $product['thumb'] = reduce_double_slashes($this->systemsetting->get("img_url") . $this->systemsetting->get("file_upload_dir") . $product['thumb']);
                $json['data'][] = $product;
            }
            $json['error_code'] = 0;
        } else {
            $json['error_code'] = 1;
        }
        $this->output->set_content_type("application/json")->set_output(json_encode($json));
    }

    /**
     * 删除足迹
     */
    public function del_user_trail() {
        $this->load->model("UserTrailModel");
        $product_id = $this->input->post('product_id');
        $user_id = $this->session->user_info['user_id'];
        $error_code = 0;
        if (!empty($product_id)) {
            $error_code = $this->UserTrailModel->delUserTrail($user_id, array("product_id" => $product_id));
        }
        $this->output->set_content_type("application/json")->set_output(json_encode(array("error_code" => $error_code)));
    }

    /**
     * 保存会员信息
     */
    public function show_member_info() {
        $user_id = $this->session->user_info['user_id'];
        $error_code = 0;
        $member_info = $this->userModel->getMemberInfo($user_id);
        if (!$member_info) {
            $error_code = 1;
        }
        $this->output->set_content_type("application/json")->set_output(json_encode(array("error_code" => $error_code, "data" => $member_info)));
    }

    /**
     * 升级会员
     */
    public function up_grade() {
        $user_id = $this->session->user_info['user_id'];
        $error_code = 0;
        $new_group_id = $this->input->post('group_id');
        $group_info = $this->userModel->getUserGroupById($new_group_id);
        $res = $this->userModel->updateUser(array("user_group_id" => $new_group_id), $user_id);
        if ($res) {
            $this->userModel->setUseIntergal($user_id, $group_info["integral"], "-");
        } else {
            $error_code = 1;
        }
        $this->output->set_content_type("application/json")->set_output(json_encode(array("error_code" => $error_code)));
    }

}