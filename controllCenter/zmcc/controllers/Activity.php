<?php

defined('BASEPATH') or exit('No direct script accesss allowed ');

/**
 * 在线活动管理控制器
 * @package    ZMshop
 * @author        wangxiangshuai@hnzhimo.com
 * @copyright    2017 河南知默网络科技有限公司
 * @link        http://www.hnzhimo.com
 * @since        Version 1.0.0
 */
class Activity extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("ActivityModel");
    }

    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $this->load->library("pagination");
        $data = array();
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 10;
        $activitylist = $this->ActivityModel->getActivityList($limit, $page);
        $config['base_url'] = base_url("Activity/index");
        $config['total_rows'] = $activitylist['count'];
        $config['perpage'] = $limit;
        $config['curpage'] = $page;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['acticvitylist'] = $activitylist['result'];
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('activity', $data);
    }

    /**
     * 编辑在线报名活动信息
     * @param type $activity_id
     */
    public function editActivity($activity_id = 0) {
        $this->load->helper('url');
        $this->load->library("form_validation");
        if ($this->input->method() == 'post') {
            $activity_id = $this->input->post('activity_id');
            $this->form_validation->set_rules('activity_title', '活动名称', 'required');
            $this->form_validation->set_rules('end_time', '结束时间', 'callback_startimeCheck[' . $this->input->post('start_time') . ']');
            if ($this->form_validation->run()) {
                $activitydata = array(
                    'activity_title' => $this->input->post('activity_title'),
                    'start_time' => strtotime($this->input->post('start_time')),
                    'end_time' => strtotime($this->input->post('end_time')),
                    'description' => $this->input->post('description'),
                    'price' => $this->input->post('price'),
                    'number' => $this->input->post('number'),
                    'thumb' => $this->input->post('thumb'),
                );
                $this->ActivityModel->editActivity($activitydata, $activity_id);
                $this->session->set_flashdata('success', '活动修改成功');
                redirect(site_url("Activity"));
            } else {
                $data['activity'] = $this->input->post();
                $this->session->set_flashdata('error', $this->form_validation->error_string());
            }
            redirect(site_url("Activity/editActivity/" . $activity_id));
        }
        $data['headings'] = "编辑活动";
        $data['action'] = site_url("Activity/editActivity/" . $activity_id);
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        if (empty($data['activity'])) {
            $data['activity'] = $this->ActivityModel->getActivityById($activity_id);
        }

        $this->load->view('activity_form', $data);
    }

    //验证开始时间和结束时间
    public function startimeCheck($time, $dirh = '0') {
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
            if (empty($time)) {
                $this->form_validation->set_message('startimeCheck', "结束时间不能为空");
                return false;
            }
        }
    }

    /**
     * 删除在线活动
     */
    public function deleteActivity() {
        $select = $this->input->post('selected');
        if (!empty($select) && is_array($select)) {
            $activity_ids = implode(',', $select);
            $where = " activity_id in ( " . $activity_ids . ")";
            $result = $this->ActivityModel->deleteActivity($where);
            if ($result) {
                $this->session->set_flashdata('success', '活动已删除');
            } else {
                $this->session->set_flashdata('error', '删除失败，重试');
            }
        }
        redirect('Activity/index');
    }

    /**
     * 添加在线活动
     */
    public function addActivity() {
        $this->load->helper("url");
        $this->load->library("form_validation");
        if ($this->input->method() == 'post') {
            // dump($_POST);exit;
            $this->form_validation->set_rules("activity_title", "活动名称", "required");
            $this->form_validation->set_rules('end_time', '结束时间', 'callback_startimeCheck[' . $this->input->post('start_time') . ']');
            if ($this->form_validation->run()) {
                $activitydata = array(
                    'activity_title' => $this->input->post('activity_title'),
                    'start_time' => strtotime($this->input->post('start_time')),
                    'end_time' => strtotime($this->input->post('end_time')),
                    'description' => $this->input->post('description'),
                    'price' => $this->input->post('price'),
                    'add_time' => time(),
                    'number' => $this->input->post('number'),
                    'thumb' => $this->input->post('thumb'),
                );
                $this->ActivityModel->addActivity($activitydata);
                $this->session->set_flashdata('success', "已添加");
                redirect(site_url("Activity/index"));
            } else {
                $data['activity_add'] = $this->input->post();
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        } else {
            $data['activity'] = array();
        }
        $data['action'] = site_url("Activity/addActivity");
        $data['headings'] = "新增活动";
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('activity_form', $data);
    }

    /**
     * 以接口B的方式形成二维码，数量没有限制
     */
    public function getwxacodeunlimit() {
        $this->load->helper("string");
        $activity_id = $this->input->get_post('activity_id');

        $config = array(
            'appid' => 'wxd91ad30448ab54cc', //$this->zmsetting->get("wechat_fun_id"),
            'appsecret' => '3ab6dc1b701731b421d33e146d8ec46f', //$this->zmsetting->get("wechat_fun_secret")
        );
        $this->load->library('wechat_qrcode', $config);
        $token = $this->wechat_qrcode->checkAuth();
        $tempFile = $this->wechat_qrcode->getwxacodeunlimit($token, $activity_id, 'pages/activities/activities');
        $res = json_decode($tempFile, true);
        if (empty($res['errcode'])) {
            $file_name = $activity_id . ".jpeg"; //文件名称
            file_put_contents($file_name, $tempFile); //生成文件
            rename($file_name, $this->zmsetting->get("file_upload_dir").$file_name); //移动文件
        }
        Header("Location: " . reduce_double_slashes($this->zmsetting->get("img_url") . $this->zmsetting->get("file_upload_dir") . $file_name));
        
    }

    /**
     * 自动查询商品名称
     */
    public function autoActivity() {
        $activity_title = $this->input->get_post('activity_title');
        if (!empty($activity_title)) {
            $activity_title = $this->input->get_post('activity_title');
        } else {
            $activity_title = '';
        }
        $data = $this->ActivityModel->autoActivityList($activity_title);
        $this->output->set_output(json_encode($data));
    }

    public static function getModuleInfo() {
        return array(
            "moduleName" => "在线活动",
            "controller" => "Activity",
            "author" => "wangxiangshuai@hnzhimo.com",
            "icon" => "",
            "operation" => array(
                "index" => "活动列表",
                "editActivity" => "编辑活动",
                "deleteActivity" => "删除活动",
                "addActivity" => "新增活动",
            ),
        );
    }

}
