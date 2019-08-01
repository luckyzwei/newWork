<?php

/**
 * 分销模型
 * @package    ZMshop
 * @author qidazhong@hnzhimo.com
 * @copyright  2017 河南知默网络科技有限公司
 * @link   http://www.hnzhimo.com
 * @since  Version 1.0.0
 */
class AgentModel extends CI_Model {

    public function getAgentByUserId($user_id) {
        $query = $this->db->select("agent_group.*,agent.*")
                ->join("agent_group", "agent_group.agent_group_id=agent.agent_group_id", "left")
                ->where(array("user_id" => $user_id))
                ->get("agent");
        return $query->row_array();
    }

    /**
     * 添加分销商
     * @param type $data
     * @return type
     */
    public function addAgent($data) {
        return $this->db->insert("agent", $data);
    }

    /**
     * 获取分销商信息
     * @param type $agent_id
     * @return type
     */
    public function getAgentById($agent_id) {
        $query = $this->db->get_where("agent", array("agent_id" => $agent_id));
        return $query->row_array();
    }

    /**
     * 更新分销商信息
     * @param type $data
     * @param type $agent_id
     * @return type
     */
    public function updateAgent($data, $agent_id) {
        return $this->db->where("agent_id", $agent_id)->update("agent", $data);
    }

    /**
     * 
     * @param type $from_id 订单推广人id
     * @param type $number 获取数量
     * @param type $start_index 开始位置
     * @param type $status 订单状态
     */
    public function getAgentOrders($from_id, $number, $start_index, $settlement_status = '') {
        $this->db->select("order.*,user_wechat.wx_nickname,user_wechat.wx_headimg,user.nickname")
                ->join("user", "user.user_id=order.user_id")
                ->join("user_wechat", "user_wechat.user_id=order.user_id", "left")
                ->where("order.status>0")
                ->where("order.master_order_id=0")
                ->where("order.from_id", $from_id)
                ->order_by("order.order_id desc")
                ->from("order");
        if (!empty($settlement_status)) {
            $this->db->where($settlement_status);
        }

        $count_query = clone($this->db);
        $total = $count_query->count_all_results();
        $query = $this->db->limit($number, $start_index)->get();

        $result = $query->result_array();
        $data = array("total" => $total, "data" => $result);
        return $data;
    }

    /**
     * 获取用户团队信息
     * @param type $user_id
     * @param type $limit
     * @param type $page
     * @param type $team_type 团队类型：1推广者，2消费者
     * @param type $count 为真的时候统计用户的促成订单或者消费订单，金额
     * @return type
     */
    public function getAgentTeam($user_id, $limit, $page, $team_type, $count = true) {
        if ($team_type) {
            if ($team_type == 1) {
                $this->db->group_start();
                $this->db->where("agent.agent_id is not null");
                $this->db->where("agent.agent_status=1");
                $this->db->group_end();
 
            }
            if ($team_type == 2) {
                $this->db->group_start();
                $this->db->where("agent.agent_id is null");
                $this->db->or_where("agent.agent_status!=1");
                $this->db->group_end();
            }
        }

        $query = $this->db->select('user.*,user_wechat.wx_headimg,user_wechat.wx_nickname,agent.agent_id,agent.agent_status')
                ->from('user')
                ->join('user_wechat', 'user_wechat.user_id=user.user_id', 'left')
                ->join('agent', 'user.user_id=agent.user_id', 'left')
                ->where('user.parent_user_id', $user_id)
                ->order_by('user.user_id', 'DESC')
                ->limit($limit, ($page - 1) * $limit)
                ->get();


        $users = $query->result_array();
        if ($count && !empty($users)) {//统计用户消费和推广情况
            foreach ($users as &$user) {
                if ($user['agent_id'] && $user['agent_status']) {
                    $user['count'] = $this->getAgentSaleInfo($user['user_id']);
                } else {
                    $user['count'] = $this->getUserOrderInfo($user['user_id']);
                }
            }
        }

        return $users;
    }

    /**
     * 获取推广人的销售统计信息
     * @param type $user_id 推广者的userid
     */
    public function getAgentSaleInfo($user_id) {
        //查询所有from_id为当前用户的订单
        $query = $this->db->select("count(1) as order_number,sum(order_amount) as order_money")
                ->where("from_id", $user_id)
                ->where("status in (1,2,5) and master_order_id=0")
                ->get("order");
        return $query->row_array();
    }

    /**
     * 获取用的订单统计信息
     * @param type $user_id
     */
    public function getUserOrderInfo($user_id) {
        $query = $this->db->select("count(1) as order_number,sum(order_amount) as order_money")
                ->where("user_id", $user_id)
                ->where("status in (1,2,5) and master_order_id=0")
                ->get("order");
        return $query->row_array();
    }

}
