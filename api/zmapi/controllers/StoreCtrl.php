<?php

/**
 * 店铺管理控制台
 *
 * @author qidazhong@hnzhimo.com
 */
class StoreCtrl extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("storeModel");
        $this->load->model("storeOrderModel");
        $this->load->model("userModel");
        $this->load->model("agentModel");
    }

    /**
     * 获取推广者订单
     */
    public function get_store_orders() {
        $user_id = $this->session->user_id;
        $number = $this->input->post("number");
        $page = $this->input->post("page") ? $this->input->post("page") : 1;
        $start_index = $number * ($page - 1);
        $settlement_status = $this->input->post("status");
        switch ($settlement_status) {
            case 1:
                $settlement_status = "order.settlement_status=0";
                break;
            case 2:
                $settlement_status = "order.settlement_status=1";
                break;
            default:
                $settlement_status = '';
                break;
        }
        $storeOrders = $this->storeOrderModel->getStoreOrders($user_id, $number, $start_index, $settlement_status);

        $countInfo['total'] = $this->storeOrderModel->countStroeOrders($user_id, -1, 0);
        //销售情况统计
        $countInfo['day'] = $this->storeOrderModel->countStroeOrders($user_id, 0, 0);
        $result = array("error_code" => 0, "data" => $storeOrders, "countInfo" => $countInfo);
        $this->output->set_content_type("application/json")->set_output(json_encode($result));
    }

    /**
     * 获取推广者统计信息
     */
    public function get_store_count() {
        $user_id = $this->session->user_id;

        $agent = $this->agentModel->getAgentByUserId($user_id);
        //下级分销
        $nextagent=$this->getNextAgentLevel();
        
        $total = $this->storeOrderModel->countStroeOrders($user_id, -1);
        //销售情况统计
        $day_count_data = $this->storeOrderModel->countStroeOrders($user_id, 0);
        $week_count_data = $this->storeOrderModel->countStroeOrders($user_id, 7);
        $month_count_data = $this->storeOrderModel->countStroeOrders($user_id, 30);
        //分销情况统计
        $agent_count_data = $this->storeOrderModel->countStroeOrders($user_id, -1, 1);
        $agent_day_count_data = $this->storeOrderModel->countStroeOrders($user_id, 0, 1);

        //用户朋友统计
        $userFriendsDay = $this->userModel->getUserFriendsCount($user_id, 0); //当天
        $userFriends = $this->userModel->getUserFriendsCount($user_id, -1); //全部
        
        //用户邀请的分销统计
        $userMppDay=$this->userModel->getUserMppCount($user_id,0);
        $userMpps=$this->userModel->getUserMppCount($user_id,-1);

        $data = array(
            "day" => $day_count_data,
            "week" => $week_count_data,
            "month" => $month_count_data,
            "total" => $total,
            "sale_total" => $agent_count_data,
            "sale_day" => $agent_day_count_data,
            "day_add_friend" => $userFriendsDay,
            "user_friends" => $userFriends,
            "day_add_mpps" => $userMppDay,
            "user_mpps" => $userMpps,
            "agent"=>$agent,
            "nextagent"=>$nextagent
        );

        $result = array("error_code" => 0, "data" => $data);
        $this->output->set_content_type("application/json")->set_output(json_encode($result));
    }
    /**
     * 获取下个分销等级
     * @return type
     */
    private function getNextAgentLevel(){
        $this->load->model("agentGroupModel");
        $agentGroups = $this->agentGroupModel->getAgentGroups();
            foreach ($agentGroups as $group) {
                $commission_rate = unserialize($group['commission_rate']);
                $temp["x".$group['agent_group_id']] = $commission_rate;
                $sortindex[] = $commission_rate[0];
            }
            array_multisort($sortindex, SORT_ASC, $temp);
            $index = 0;
            $nextlevelid = 0;
            foreach ($temp as $key => $t) {
                if ($key == "x".$this->session->user_info['agent_group_id']) {
                    $nextlevelid = key($temp);
                    break;
                }
                $index++;
            }
            $nextgroup=array();
            if ($nextlevelid&&$nextlevelid!="x1") {
                $nextlevelid= str_replace("x", "", $nextlevelid);
                $nextgroup = $this->agentGroupModel->sel($nextlevelid);
                $tipsa="";
                if($nextgroup['need_reward']){
                    $tipsa="累计佣金达到".$nextgroup['need_reward']."元";
                }
                $tipsb="";
                if($nextgroup['need_member']){
                    $tipsb="推广用户达到".$nextgroup['need_member']."人";
                }
                if($nextgroup['condation']){
                    $md="并且";
                }else{
                    $md="或者";
                }
                if($tipsa!=""&&$tipsb!=""){
                    $tips=$tipsa.$md.$tipsb;
                }else{
                    $tips=$tipsa.$tipsb;
                }
                $nextgroup['tips']=$tips."可以成为".$nextgroup['agent_group_name'];
            }
            return $nextgroup;
    }

    /**
     * 获取用户收益记录
     */
    public function get_rewards() {
        $user_id = $this->session->user_id;
        $page = $this->input->post("page") ? $this->input->post("page") : 1;
        $type = $this->input->post("type");
        $list = $this->userModel->getUserReward($user_id, $page, $type);

        if (!empty($list)) {
            foreach ($list as &$value) {
                $value['time'] = date('Y-m-d', $value['createtime']);
            }
        }

        $countInfo['total'] = $this->storeOrderModel->countStroeOrders($user_id, -1, $type);
        $result = array("error_code" => 0, "data" => $list, 'countInfo' => $countInfo);
        $this->output->set_content_type("application/json")->set_output(json_encode($result));
    }
    
    /*
     * 获取用户邀请的客户或者mpp
     */

    public function get_user_team() {
        $team=$this->input->post("team");
        if($team=="mpp"){
            $teamtype=1;
        }else{
            $teamtype=2;
        }
        $user_id = $this->session->user_info['user_id'];
        $limit = $this->input->post('limit') ? $this->input->post('limit') : 20;
        $page = $this->input->post('page') ? $this->input->post('page') : 1;
        $res = $this->agentModel->getAgentTeam($user_id, $limit, $page,$teamtype);
        $data = array();
        if (!empty($res))
            foreach ($res as $value) {
                $value['time'] = date('Y-m-d', $value['createtime']);
                $data[] = $value;
            }
        $this->output->set_content_type("json/application")->set_output(json_encode(array("error_code" => 0, "data" => $data)));
    }
    /*
     * 获取用户邀请的mpp
     */
    public function get_user_mpp() {
        $user_id = $this->session->user_info['user_id'];
        $limit = $this->input->post('limit') ? $this->input->post('limit') : 20;
        $page = $this->input->post('page') ? $this->input->post('page') : 1;
        $res = $this->agentModel->getAgentTeam($user_id, $limit, $page);
        $data = array();
        if (!empty($res))
            foreach ($res as $value) {
                $value['time'] = date('Y-m-d', $value['createtime']);
                $data[] = $value;
            }
        $this->output->set_content_type("json/application")->set_output(json_encode(array("error_code" => 0, "data" => $data)));
    }

}
