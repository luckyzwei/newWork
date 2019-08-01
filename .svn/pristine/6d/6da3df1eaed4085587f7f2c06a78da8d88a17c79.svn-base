<?php

defined('BASEPATH') OR exit('No direct script accesss allowed ');

/**
 * 在线活动报名控制器
 * @package	ZMshop
 * @author	    wangxiangshuai@hnzhimo.com
 * @copyright	2017 河南知默网络科技有限公司
 * @link	    http://www.hnzhimo.com
 * @since	    Version 1.0.0
 */
class ActivityOrder extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("ActivityOrderModel");
    }

    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $this->load->model("ActivityModel");
        $this->load->library("pagination");
        $data = array();
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 10;
        $where = array();
        $activity_id = $this->input->get_post("activity_id");
        $status = $this->input->get_post("status");
        if (!empty($activity_id)){
            $where['ao.activity_id'] = $activity_id;
        }
        if (!empty($status)){
            $where['ao.status'] = $status;
        }
        $activitylist = $this->ActivityOrderModel->getActivityOrderList($limit, $page, $where);
        $config['url'] = site_url("ActivityOrder/index");
        $config['total_rows'] = $activitylist['count'];
        $config['perpage'] = $limit;
        $config['curpage'] = $page;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['acticvityorderlist'] = $activitylist['result'];

        $activity = $this->ActivityModel->getActivityById($this->input->get_post("activity_id"));
        //返回筛选条件
        $data['activity_title'] = $activity['activity_title'];
        $data['activity_id'] = $this->input->get_post("activity_id");
        $data['status'] = $this->input->get_post("status");

        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->view('activityorder', $data);
    }

    /**
     * 在线签到
     */
    public function recommend() {
        $data = elements(array("activity_order_id", "status"), $this->input->post());
        if ($this->ActivityOrderModel->recommend($data)) {
            $result = array("error_code" => 0);
        } else {
            $result = array("error_code" => 1);
        }
        $this->output->set_output(json_encode($result));
    }

    /**
     * 删除在线活动
     */
    public function deleteActivityOrder() {
        $select = $this->input->post('selected');
        if (!empty($select) && is_array($select)) {
            $activity_ids = implode(',', $select);
            $where = " activity_order_id in ( " . $activity_ids . ")";
            $result = $this->ActivityOrderModel->deleteActivityOrder($where);
            if ($result) {
                $this->session->set_flashdata('success', '活动已删除');
            } else {
                $this->session->set_flashdata('error', '删除失败，重试');
            }
        }
        redirect('Activity/index');
    }

    static function getModuleInfo() {
        return array(
            "moduleName" => "在线报名",
            "controller" => "ActivityOrder",
            "author" => "wangxiangshuai@hnzhimo.com",
            "icon" => "",
            "operation" => array(
                "index" => "报名列表",
                "recommend" => "异步签到",
                "deleteActivityOrder" => "删除报名信息",
            )
        );
    }

}
