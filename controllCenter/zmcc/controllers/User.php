<?php

/**
 * 用户管理控制器
 * @package	ZMshop
 * @author	xuhuan@hnzhimo.com
 * @copyright	2017 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class User extends CI_Controller {

    static function getModuleInfo() {
        return array(
            "moduleName" => "用户管理",
            "controller" => "User",
            "author" => "qidazhong@hnzhimo.com",
            "icon" => "",
            "operation" => array(
                "index" => "用户列表",
                "userDetail" => "用户详情",
                "editUser" => "修改用户",
                "deleteUser" => "删除用户",
                "editUserBalance" => "余额管理",
                "editUserIntergal" => "积分管理",
                "editUserReward" => "佣金详情",
                "editRewardStatus" => "修改佣金"
            )
        );
    }

    public function __construct() {
        parent::__construct();
        $this->load->model("UserModel");
        $this->load->model("UserGroupModel");
        $this->load->model("UserLevelModel");
        $this->load->model("RoleModel");
    }

    public function index() {
        $this->load->library('pagination');
        $this->load->helper('url');
        $data = array();
        $where = array();
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $user_name = $this->input->post("filter_user_name");
        if (!empty($user_name)) {
            $where['user_name'] = $user_name;
        } else {
            $where['user_name'] = '';
        }
        $email = $this->input->post('filter_email');
        if (!empty($email)) {
            $where['email'] = $email;
        } else {
            $where['email'] = '';
        }
        $nickname = $this->input->post('filter_nickname');
        if (!empty($nickname)) {
            $where['nickname'] = $nickname;
        } else {
            $where['nickname'] = '';
        }
        $identity = $this->input->post('filter_identity');
        if (!empty($identity)) {
            $where['identity'] = $identity;
        } else {
            $where['identity'] = '';
        }
        $level_id = $this->input->post('filter_level_id');
        if (!empty($level_id)) {
            $where['level_id'] = $level_id;
        } else {
            $where['level_id'] = '';
        }
        $user_group_id = $this->input->post('filter_user_group_id');
        if (!empty($user_group_id)) {
            $where['user_group_id'] = $user_group_id;
        } else {
            $where['user_group_id'] = '';
        }
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 20; //每页显示条数
//        $offset=intval($this->uri->segment(3)) ? intval($this->uri->segment(3)):1;
        $offset = $this->input->get('per_page');
        $offset = $offset ? $offset : 1;

        $userlist = $this->UserModel->getList($where, $limit, $offset);
        $data['userlist'] = $userlist['datas'];
        $config['total_rows'] = $userlist['count']; //共有多少条数据
        $config['base_url'] = site_url('User/index'); //当前分页地址
        $config['per_page'] = $limit;
        $config['cur_page'] = $offset;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links(); //可以分的页数
        $data['page'] = $offset;
        $data['user_name'] = $user_name;
        $data['email'] = $email;
        $data['nickname'] = $nickname;
        $data['identity'] = $identity;
        $data['level_id'] = $level_id;
        $data['user_group'] = $user_group_id;

        $usergroups = $this->UserGroupModel->getUserGroupList();
        $data['usergroups'] = $usergroups['result'];

        $userlevels = $this->UserLevelModel->getUserLevelList();
        $data['userlevels'] = $userlevels['data'];
        $this->load->view('user', $data);
    }

    /**
     * 用户详情
     * @param type $user_id
     */
    public function userDetail($user_id) {

        $userinfo = $this->UserModel->getUserById($user_id, 1);
        //获取用户最近10个订单
        $this->load->model("OrderModel");
        $orders = $this->OrderModel->getUserOrdres($user_id);
        $userinfo['orders'] = $orders;
        $userinfo['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view("user_detail", $userinfo);
    }

    /**
     * 编辑用户信息
     * @param type $user_id
     */
    public function editUser($user_id) {
        $this->load->helper("url");
        $this->load->library('form_validation');
        $user_info = $this->UserModel->getUserById($user_id);
        if ($this->input->method() == "post") {
            $this->form_validation->set_rules('identity', '会员身份', 'required');
            $this->form_validation->set_rules('level_id', '会员等级', 'required');
            $this->form_validation->set_rules('user_group_id', '会员分组', 'required');
            if ($this->form_validation->run() == True) {
                $userdata = array(
                    'nickname' => $this->input->post('nickname'),
                    'email' => $this->input->post('email'),
                    'identity' => $this->input->post('identity'),
                    'level_id' => $this->input->post('level_id'),
                    'user_group_id' => $this->input->post('user_group_id'),
                    'updatetime' => time()
                );
                $password = $this->input->post('password');
                if (!empty($password)) {
                    $userdata['password'] = md5($password);
                }
                $user_id = $this->input->post("user_id");
                $result = $this->UserModel->editUser($userdata, array("user_id" => $user_id));
                if ($result) {
                    $this->session->success = "修改会员信息成功";
                    $this->session->mark_as_flash("success");
                    redirect(site_url("User/index"));
                } else {
                    $this->session->error = "修改会员信息失败";
                    $this->session->mark_as_flash("error");
                    redirect(site_url("User/index"));
                }
            } else {
                $user_info = $this->input->post();
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $data['userinfo'] = $user_info;
        $usergroups = $this->UserGroupModel->getUserGroupList();
        $data['usergroups'] = $usergroups['result'];
        $userlevels = $this->UserLevelModel->getUserLevelList();
        $data['userlevels'] = $userlevels['data'];
        $this->load->view("user_edit", $data);
    }

    public function deleteUser() {
        $select = $this->input->post('selected');
        if (is_array($select) && !empty($select)) {
            foreach ($select as $user_id) {
                $result = $this->UserModel->deleteUser(array('user_id' => $user_id));
                if ($result) {
                    $this->session->success = "删除成功!";
                    $this->session->mark_as_flash("success");
                } else {
                    $this->session->error = "删除失败!";
                    $this->session->mark_as_flash("error");
                }
            }
        }
        redirect(site_url("User/index"));
    }

    //账户余额变更
    public function editUserBalance($user_id) {
        $this->load->library('pagination');
        $this->load->helper(array("form", "url"));
        $this->load->library('form_validation');
        $data['result'] = "fail";
        if ($this->input->method() == "post") {
            $this->form_validation->set_rules('change_cause', '变更原因', 'trim');
            $this->form_validation->set_rules('change_money', '变更余额必填', 'required', array('required' => '变更余额必填'));
            if ($this->form_validation->run() == True) {
                $accountdata = array(
                    'user_id' => $this->input->post('user_id'),
                    'change_money' => $this->input->post('change_money'),
                    'change_cause' => $this->input->post('change_cause'),
                    'createtime' => time()
                );
                $res = $this->UserModel->editUserTransaction($accountdata);
                if ($res) {
                    $this->session->success = "资金变动成功";
                    $this->session->mark_as_flash("success");
                    redirect(site_url('User/index'));
                }
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $data['user_id'] = $user_id;
        $config['per_page'] = 20; //每页显示条数
        $offset = $this->input->get('per_page') ? $this->input->get('per_page') : 1;
        $accountinfos = $this->UserModel->getUserAccount($user_id, $config['per_page'], $offset);
        $data['accountinfos'] = $accountinfos['datas'];
        $config['total_rows'] = $accountinfos['count']; //共有多少条数据
        $config['base_url'] = site_url('User/editUserBalance/' . $user_id); //当前分页地址
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links(); //可以分的页数
        $data['count'] = $accountinfos['count'];
        //变更后的余额
        $data['change_money'] = $accountinfos['totalmoney'];
        $this->load->view('useraccount', $data);
    }

    //积分变更
    public function editUserIntergal($user_id) {
        $this->load->library('pagination');
        $this->load->helper("url");
        $this->load->library('form_validation');
        $data['result'] = "fail";
        if ($this->input->method() == "post") {
            $this->form_validation->set_rules('change_cause', '变更原因', 'trim');
            $this->form_validation->set_rules('change_intergal', '变更积分必填', 'required', array('required' => '变更积分必填'));
            if ($this->form_validation->run() == True) {
                $intergaldata = array(
                    'user_id' => $this->input->post('user_id'),
                    'change_intergal' => $this->input->post('change_intergal'),
                    'change_cause' => $this->input->post('change_cause'),
                    'createtime' => time()
                );
                $this->UserModel->editUserIntergal($intergaldata);
                $this->session->success = "积分变动成功";
                $this->session->mark_as_flash("success");
            }
            else{
                 $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());

        $data['user_id'] = $user_id;
        $config['per_page'] = 20; //每页显示条数
 
        $page = $this->input->get('per_page') ? $this->input->get('per_page') : '1';
        $intergalinfos = $this->UserModel->getUserIntergal($user_id, $config['per_page'], $page);
        $data['intergalinfos'] = $intergalinfos['datas'];
        $config['total_rows'] = $intergalinfos['count']; //共有多少条数据
        $config['base_url'] = site_url('User/editUserIntergal/' . $user_id); //当前分页地址
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links(); //可以分的页数
        $data['count'] = $intergalinfos['count'];
        $data['change_intergal'] = $intergalinfos['totalintergal'];
        $this->load->view('userintergal', $data);
    }

    /**
     * 用户佣金统计
     */
    public function getUserReward() {
        $this->load->library('pagination');
        $this->load->helper("url");
        $this->load->library('form_validation');
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $user_id = $this->uri->segment(3);
        $data['user_id'] = $user_id;
        $config['per_page'] = 20; //每页显示条数
        $page = $this->input->get("page")? $this->input->get("page"): 1;
        $rewardinfos = $this->UserModel->getUserReward($user_id, $config['per_page'], $page);
        $config['total_rows'] = $rewardinfos['count']; //共有多少条数据
        $config['base_url'] = site_url('User/editUserReward'); //当前分页地址
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links(); //可以分的页数
        $data['count'] = $rewardinfos['count'];

        $data['rewardinfos'] = $rewardinfos['datas'];
 
        $this->load->view('userreward', $data);
    }


    public function userNameCheck($user_name) {
        $checkData = array("user_name" => $user_name);
        if (strtolower($this->uri->segment(2)) == "edituser") {
            $checkData['user_id!='] = $this->uri->segment(3);
        }
        if ($this->UserModel->isExist($checkData)) {
            $this->form_validation->set_message('userNameCheck', '用户名不能重复');
            return false;
        }
        return true;
    }

    public function nicknameCheck($nickname) {
        $checkData = array("nickname" => $nickname);
        if (strtolower($this->uri->segment(2)) == "edituser") {
            $checkData['user_id!='] = $this->uri->segment(3);
        }
        if ($this->UserModel->isExist($checkData)) {
            $this->form_validation->set_message('nicknameCheck', '昵称不能重复');
            return false;
        }
        return true;
    }

    public function emailCheck($email) {
        $checkData = array("email" => $email);
        if (strtolower($this->uri->segment(2)) == "edituser") {
            $checkData['user_id!='] = $this->uri->segment(3);
        }
        if ($this->UserModel->isExist($checkData)) {
            $this->form_validation->set_message('emailCheck', '邮箱不能重复');
            return false;
        }
        return true;
    }

    public function autoUser() {
        $json = array();
        $filter_data = array();
        $user_name = $this->input->get_post('filter_user_name');
        if (!empty($user_name)) {
            $filter_data['user_name'] = $user_name;
        }
        $email = $this->input->get_post('filter_email');
        if (!empty($email)) {
            $filter_data['email'] = $email;
        }
        $user_id = $this->input->get_post('user_id');
        if (!empty($user_id)) {
            $filter_data['user_id'] = $user_id;
        }
        $nickname = $this->input->get_post('filter_nickname');
        if (!empty($nickname)) {
            $filter_data['nickname'] = $nickname;
        }

        $results = $this->UserModel->autoUserLists($filter_data);
        foreach ($results['datas'] as $result) {
            $json[] = array(
                'user_id' => $result['user_id'],
                'user_name' => $result['user_name'],
                'nickname' => $result['nickname'],
                'level_id' => $result['level_id'],
                'user_group_id' => $result['user_group_id'],
                'identity' => $result['identity'], //身份
                'email' => $result['email']
            );
        }

        $this->output->set_output(json_encode($json));
    }

}
