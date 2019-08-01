<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 优惠劵管理
 * @package    ZMshop
 * @author    liuchenwei@hnzhimo.com
 * @copyright    2017 河南知默网络科技有限公司
 * @link    http://www.hnzhimo.com
 * @since    Version 1.0.0
 */
class Coupon extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("CouponModel");
        $this->load->model("userGroupModel");
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    //加载优惠劵列表页
    public function index()
    {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $this->load->helper('url');
        $this->load->library("pagination");
        $data = array();
        $where = array();
        $where['filter_agent'] = $this->input->post('filter_agent');
        $data['filter_agent'] = $where['filter_agent'];
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 10;
        $categorydata = $this->CouponModel->getList($where, $page, $limit);
        $config['base_url'] = base_url('Coupon/index'); //当前分页地址
        $config['total_rows'] = $categorydata['count'];
        $config['per_page'] = $limit; //每页显示的条数
        $this->pagination->initialize($config);
        $data['linklist'] = $this->pagination->create_links();
        $data['list'] = $categorydata['result'];
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('coupon', $data);
    }

    //添加优惠劵
    public function addCoupon()
    {

        $data = array();
        if ($this->input->method() == "post") {
            $data = $this->valiRules();
            if ($data['rules_run'] == true) {
                unset($data['rules_run']);
                if (!empty($data['image'])) {
                    $data['image'] = $this->zmsetting->get("file_upload_dir") . $data['image'];
                }
                $data['start_time'] = strtotime($data['start_time']);
                $data['end_time'] = strtotime($data['end_time']);
                $data['receive_num'] = $this->input->post("receive_num");
                $data['createtime'] = time();
                $this->CouponModel->addCoupon($data);
                $this->session->success = "添加优惠劵成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Coupon/index"));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $data = array_merge($data, $this->input->post());
            }
        }
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view("coupon_add", $data);
    }

    //编辑优惠劵
    public function editCoupon()
    {
        $coupon_id = $this->input->get_post('coupon_id');
        $coupon = $this->CouponModel->sel($coupon_id);
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());

        if ($this->input->method() == "post") {
            $data = $this->valiRules();
            if ($data['rules_run'] == true) {
                unset($data['rules_run']);
                if ($data['image'] != $coupon['count']['image']) {
                    $data['image'] = $this->zmsetting->get("file_upload_dir") . $data['image'];
                }
                $data['start_time'] = strtotime($data['start_time']);
                $data['end_time'] = strtotime($data['end_time']);
                $data['receive_num'] = $this->input->post("receive_num");
                $data['updatetime'] = time();
                $this->CouponModel->editCoupon($data, array('coupon_id' => $coupon_id));
                $this->session->success = "修改优惠劵成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Coupon/index"));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $data = array_merge($data, $this->input->post());
            }
        }
        $data['xqing'] = $coupon['count'];
        $data['name'] = $coupon['result'];
        $data['disable_product'] = $coupon['disable_product'];
        $this->load->view("coupon_edit", $data);
    }

    //验证优惠券有效期开始时间和结束时间
    public function startimeCheck($time, $dirh = '0')
    {
        $time = strtotime($time);
        if (empty($dirh)) {
            if (!empty($time) && ($time < time())) {
                $this->form_validation->set_message('startimeCheck', "结束时间不能小于当前时间");
                return false;
            }
        } else {
            if (!empty($time) && $time < strtotime($dirh)) {
                $this->form_validation->set_message('startimeCheck', "结束时间不能小于开始时间");
                return false;
            }
        }
    }

    //验证填写色数据
    public function valiRules()
    {
        $filerdata = array("coupon_name", "coupon_type", "coupon_denomination", "limit_order_amount", "enable_product", "disable_product", "receive_num", "use_num", "updatetime", "start_time", "end_time", "createtime", "image", "receive");
        $data = elements($filerdata, $this->input->post());
        //验证数据
        $valiRules = array(
            array(
                'field' => 'coupon_name',
                'label' => '优惠劵名称',
                'rules' => 'required|max_length[24]',
                "errors" => array(
                    'required' => "优惠劵名称不能为空,并且不能超过8个汉字",
                ),
            ),
            array(
                'field' => 'coupon_denomination',
                'label' => '优惠劵面值',
                'rules' => 'required',
                "errors" => array(
                    'required' => "优惠劵面值不能为空",
                ),
            ),
            array(
                'field' => 'limit_order_amount',
                'label' => '使用条件',
                'rules' => 'required',
                "errors" => array(
                    'required' => "使用条件不能为空",
                ),
            ),
            array(
                'field' => 'end_time',
                'label' => '结束时间',
                'rules' => 'callback_startimeCheck[' . $this->input->post('start_time') . ']',
                "errors" => "请正确填写设置项名称:名称不能重复",
            ),
        );

        //验证数据
        $this->form_validation->set_rules($valiRules);
        $data['rules_run'] = $this->form_validation->run();
        //优惠券图片
        $data['image'] = $this->input->post("image");
        return $data;
    }

    //删除优惠劵
    public function deleteCoupon()
    {
        $return = $this->input->post('selected');
        if (!empty($return) && is_array($return)) {
            $where = implode(',', $this->input->post('selected'));
            $arr = $this->CouponModel->deleteCoupon('coupon_id in (' . $where . ')');
            if ($arr == false) {
                $this->session->success = "删除成功!";
                $this->session->mark_as_flash("success");
            } else {
                $this->session->error = "删除失败,用户账户中还有未使用的优惠券!";
                $this->session->mark_as_flash("error");
            }
        } else {
            $this->session->error = "请求有误!";
            $this->session->mark_as_flash("error");
        }
        redirect(site_url('Coupon/index'));
    }

    //发放优惠劵
    public function sendCoupon()
    {
        $coupon_id = $this->input->get_post('coupon_id');
        $data = array();
        if ($this->input->method() == "post") {
            $data = array(
                "user_group_id" => $this->input->post("user_group_id"),
                "user_id" => $this->input->post("user_id"),
                "coupon_num" => $this->input->post("coupon_num"),
                "coupon_id" => $this->input->post('coupon_id'),
            );
            $res = $this->CouponModel->sendCoupon($data);
            if ($res) {
                $this->session->success = "发送优惠劵成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Coupon/index"));
            } else {
                $this->session->error = "当前发送用户组下没有用户或没有选择单个用户";
                $this->session->mark_as_flash("error");
            }
        }
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $u = $this->CouponModel->sel($coupon_id);
        $data['coupon'] = $u['count'];
        $userGroups = $this->userGroupModel->getUserGroupList(100);
        $data['userGroups'] = $userGroups['result'];
        $this->load->view("coupon_send", $data);
    }

    //自动加载用户
    public function autoUser()
    {
        $user_id = $this->input->get_post('user_id');
        if (!empty($user_id)) {
            $user_id = $this->input->get_post('user_id');
        } else {
            $user_id = '';
        }
        $categorydata = $this->CouponModel->autoUser($user_id);
        $this->output->set_output(json_encode($categorydata));
    }

    //设置控制权限
    public static function getModuleInfo()
    {
        return array(
            "moduleName" => "优惠劵管理",
            "controller" => "Coupon",
            "author" => "liuchenwei@hnzhimo.com",
            "operation" => array(
                "index" => "优惠劵列表",
                "addCoupon" => "添加优惠劵",
                "editCoupon" => "编辑优惠劵",
                "deleteCoupon" => "删除优惠劵",
                "sendCoupon" => "发送优惠劵",
            ),
        );
    }

}
