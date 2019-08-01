<?php

/**
 * 用户管理模型
 * @package  ZMshop
 * @author xuhuan@hnzhimo.com
 * @copyright  2017 河南知默网络科技有限公司
 * @link http://www.hnzhimo.com
 * @since  Version 1.0.0
 */
class UserModel extends CI_Model {

    public $table = "user";
    public $account = "user_account_log";
    public $intergal = "user_intergal_log";
    public $reward = "user_reward";
    public $order = "order";
    public $province = "province";

    public function getList($where = array(), $limit = 20, $offset = 1) {
        $this->db->select('user.*,user_level.*,user_group.*')
                ->join("user_level", "user.level_id=user_level.level_id", "left")
                ->join("user_group", "user.user_group_id=user_group.user_group_id", "left");
        if (!empty($where['user_name'])) {
            $this->db->like('user_name', $where['user_name'], 'both');
        }
        if (!empty($where['nickname'])) {
            $this->db->like('nickname', $where['nickname'], 'both');
        }
        if (!empty($where['email'])) {
            $this->db->like('email', $where['email'], 'both');
        }
        if (!empty($where['level_id'])) {
            $this->db->where('user.level_id', $where['level_id']);
        }
        if (!empty($where['user_group_id'])) {
            $this->db->where('user.user_group_id', $where['user_group_id']);
        }
        if (!empty($where['identity'])) {
            $this->db->where('user.identity', $where['identity']);
        }
        if (!empty($where['createtime'])) {
            $this->db->where('user.createtime>', $where['createtime']);
        }
        $count_db = clone($this->db);
        $count = $count_db->count_all_results($this->table);
        $query = $this->db->order_by("user_id desc")
                ->limit($limit, ($offset - 1) * $limit)
                ->get_where($this->table);
        return array('count' => $count, 'datas' => $query->result_array());
    }

    public function editUser($data, $where) {
        return $this->db->update($this->table, $data, $where);
    }

    //用户金额变更
    public function editUserMoney($user_money, $where) {
        return $this->db->set('user_money', 'user_money' + $user_money, 'FALSE')
                        ->where($where)
                        ->update($this->table);
    }

    //用户金额变更
    public function editIntergal($user_intergal, $where) {
        return $this->db->set('user_intergal', 'user_intergal' + $user_intergal, 'FALSE')
                        ->where($where)
                        ->update($this->table);
    }

    public function deleteUser($where) {
        $this->db->delete("user_wechat",$where);
        $this->db->delete("order",$where);
        $this->db->delete("agent",$where);
        $this->db->delete("user_reward",$where);
        return $this->db->delete($this->table, $where);
    }

    /**
     * 获取用户信息
     * @param type $user_id
     * @return type
     */
    public function getUserById($user_id) {

        $query = $this->db->select("user.*,user_level.level_name,user_group.user_group_name,user_wechat.wx_fun_openid,user_wechat.wx_headimg,user_wechat.wx_nickname")
                ->join("user_level", "user.level_id=user_level.level_id", "left")
                ->join("user_group", "user.user_group_id=user_group.user_group_id", "left")
                ->join("user_wechat", "user.user_id=user_wechat.user_id")
                ->where("user.user_id", $user_id)
                ->get("user");

        return $query->row_array();
    }

    public function isExist($where) {
        $query = $this->db->get_where($this->table, $where);
        $row = $query->row_array();
        return empty($row) ? FALSE : TRUE;
    }

    //账户余额变更
    public function editUserTransaction($data) {
        //开启事务
        $this->db->trans_start();
        $res1 = $this->db
                ->where('user_id', $data['user_id'])
                ->set('user_money', 'user_money+' . $data['change_money'], FALSE)
                ->update('user');
        $res2 = $this->db->insert($this->account, $data);
        $this->db->trans_complete();

        if ($res1 && $res2) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getUserAccount($user_id, $limit = 10, $page = 1) {
        $query = $this->db->select("user_phone,user_money,settlement_money,user_intergal,(user_money+settlement_money) as totalmoney")
                ->where("user_id", $user_id)
                ->get("user");
        $data = $query->row_array();

        $count = $this->db->where("user_id", $user_id)->count_all_results("user_account_log");
        $logquery = $this->db->where("user_id", $user_id)
                ->order_by('createtime desc')
                ->limit($limit, ($page - 1) * $limit)
                ->get('user_account_log');
        return array('totalmoney' => $data['totalmoney'], 'count' => $count, 'datas' => $logquery->result_array());
    }

    //积分变更
    public function editUserIntergal($data) {

        $this->db->trans_start();
        $res1 = $this->db
                ->where('user_id', $data['user_id'])
                ->set('user_intergal', 'user_intergal+' . $data['change_intergal'], FALSE)
                ->update('user');
        $res2 = $this->db->insert($this->intergal, $data);
        $this->db->trans_complete();

        if ($res1 && $res2) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 用户积分统计
     * @param type $user_id
     * @param type $limit
     * @param type $page
     * @return type
     */
    public function getUserIntergal($user_id, $limit = 10, $page = 1) {
        $query = $this->db->select("user_phone,user_money,settlement_money,user_intergal,(user_money+settlement_money) as totalmoney")
                ->where("user_id", $user_id)
                ->get("user");
        $data = $query->row_array();

        $this->db->where("user_id", $user_id);
        $countdb = clone($this->db);

        $count = $countdb->count_all_results($this->intergal);
        $query = $this->db->order_by('intergal_log_id desc')
                ->limit($limit, ($page - 1) * $limit)
                ->get($this->intergal);
        $datas = $query->result_array();
        return array('totalintergal' => $data['user_intergal'], 'count' => $count, 'datas' => $datas);
    }

    /**
     * 用户分成信息
     * @param type $user_id
     * @param type $limit
     * @param type $page
     * @return type
     */
    public function getUserReward($user_id, $limit = 20, $page = 1) {
        $this->db->where("user_id", $user_id)
                ->order_by('reward_id desc');
        $colonDb = clone($this->db);
        $count = $colonDb->count_all_results($this->reward);
        $query = $this->db->limit($limit, ($page - 1) * $limit)->get($this->reward);
        $result = $query->result_array();

        return array('count' => $count, 'datas' => $result);
    }

    public function getUserOrder($where) {
        $query = $this->db->select("order.order_id,order.status,order.order_amount,user_reward.*")
                ->join("user_reward", 'user_reward.order_id=order.order_id', 'left')
                ->where('order.order_id in(' . $where . ')')
                ->get($this->order);

        return $query->result_array();
    }

    public function getByRewardStatus($reward_id) {
        $query = $this->db->get_where($this->reward, array("reward_id" => $reward_id));
        return $query->row_array();
    }

    public function editRewardStatus($data, $where) {
        return $this->db->update($this->reward, $data, $where);
    }

    //自动加载
    public function autoUserLists($where) {
        if (!empty($where)) {
            $this->db->or_like($where);
        }
        $query = $this->db->limit(10)
                ->order_by('user_id', 'DESC')
                ->get($this->table);
        return array('datas' => $query->result_array());
    }

    /**
     * 设置用户结算佣金
     * @param type $user_id
     * @param type $money
     * @return type
     */
    public function setUserSettlementMoney($user_id, $money) {
        return $this->db->where("user_id", $user_id)
                        ->set("settlement_money+=", $money, false)
                        ->update("user");
    }

    public function addAccountLog($data) {
        return $this->db->insert("user_account_log", $data);
    }

    public function getMemberInfo($user_id) {
        $query = $this->db->select('*')
                ->where('user_id', $user_id)
                ->get("user_info");
        return $query->row_array();
    }

}