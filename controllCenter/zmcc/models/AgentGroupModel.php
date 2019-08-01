<?php

/**
 * 代理分组管理模型
 * @package    ZMshop
 * @author liuchenwei@hnzhimo.com
 * @copyright  2017 河南知默网络科技有限公司
 * @link   http://www.hnzhimo.com
 * @since  Version 1.0.0
 */
class AgentGroupModel extends CI_Model {

    //获取代理分组列表
    public function getAgentGroupList($where = array(), $page = 1, $limit = 20) {
        $this->db->select('*')->from('agent_group');
        if ($where) {
            $this->db->like("agent_group_name", $where['filter_group_name']);
        }
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $query = $this->db
                ->limit($limit, ($page - 1) * $limit)
                ->get();
        return array("count" => $rownum, "result" => $query->result_array());
    }

    //添加代理分组
    public function addAgentGroup($data) {
        return $this->db->insert('agent_group', $data);
    }

    //修改代理分组
    public function update($agent_group_id, $data) {
        return $this->db->update('agent_group', $data, array("agent_group_id"=>$agent_group_id));
    }

    //根据指定查询数据
    public function sel($agent_group_id) {
        $query = $this->db->get_where("agent_group", array("agent_group_id" => $agent_group_id));
        return $query->row_array();
    }

    //删除代理分组
    public function delete($where) {
        return $this->db->delete('agent_group', $where);
    }


}
