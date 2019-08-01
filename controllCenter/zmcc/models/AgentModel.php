<?php

/**
 * 代理管理模型
 * @package    ZMshop
 * @author qidazhong@hnzhimo.com
 * @copyright  2017 河南知默网络科技有限公司
 * @link   http://www.hnzhimo.com
 * @since  Version 1.0.0
 */
class AgentModel extends CI_Model {

    //获取代理申请列表页
    public function getList($where = array(), $page = 1, $limit = 20) {
        $this->db->select('*')->from('agent');
        if ($where) {
            $this->db->or_like(array('user_id' => $where['filter_agent'], 'agent_name' => $where['filter_agent']));
        }
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $query = $this->db
                ->limit($limit, ($page - 1) * $limit)
                ->order_by("agent_id desc")
                ->get();
        return array("count" => $rownum, "result" => $query->result_array());
    }

    /**
     * 更新分销商信息
     * @param type $data
     * @param type $where
     * @return type
     */
    public function updateAgent($data, $where) {
        return $this->db->update("agent", $data, $where);
    }

    //根据指定查询数据
    public function getAgentById($agent_id) {

        $query = $this->db->get_where("agent", array("agent_id" => $agent_id));
        return $query->row_array();
    }

    //查询代理分组表
    public function getAgentGroup() {
        $query = $this->db->get("agent_group");
        return $query->result_array();
    }

    /**
     * 删除代理商信息
     * @param type $agent_ids 代理商id数组
     * @return type
     */
    public function deleteAgent($agent_ids) {
        return $query = $this->db->where_in("agent_id",$agent_ids)->delete('agent');
    }

}
