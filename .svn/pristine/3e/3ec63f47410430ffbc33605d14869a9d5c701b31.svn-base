<?php

/**
 * Description of LogisticsModel
 */
class LogisticsModel extends CI_Model {

    public function addLogistics($data) {
        return $this->db->insert("logistics", $data);
    }

    public function editLogistics($data, $where) {
        return $this->db->update("logistics", $data, $where);
    }

    public function deleteLogistics($where) {
        foreach ($where as $w=>$v){
            if(is_array($v)){
                $where=$w." in (".implode(",", $v).")";
            }
        }
        return $this->db->delete("logistics", $where);
    }

    public function getLogistics($where) {
        $query = $this->db->get_where("logistics", $where);
        return $query->row_array();
    }

    public function getList($where = array()) {
        $query = $this->db->order_by("logistics_id", "desc")->get_where("logistics", $where);
        return $query->result_array();
    }

}
