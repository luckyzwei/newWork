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

    //根据指定查询数据
    public function sel($agent_group_id) {
        $query = $this->db->get_where("agent_group", array("agent_group_id" => $agent_group_id));
        return $query->row_array();
    }
    
    public function getAgentGroups(){
        $query = $this->db->get("agent_group");
        return $query->result_array();
    }
    
    public function getAgentGroup($where){
        $query = $this->db->get_where("agent_group",$where);
        return $query->result_array();
    }

}
