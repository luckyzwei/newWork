<?php

/**
 * 商品类型
 *
 * @author qidazhong@hnzhimo.com
 */
class CommodityTypModel extends CI_Model {

    public function getCommodityTyps($where = "") {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get("commodity_typ");
        return $query->result_array();
    }

    public function searchCdytyp($keywords) {
        $this->db->like("cdytyp_name", $keywords);
        $query = $this->db->get("commodity_typ");
        return $query->result_array();
    }

    public function addCommodityTyp($data) {
        return $this->db->insert("commodity_typ", $data);
    }

    public function updateCommodityTyp($data, $where) {
        return $this->db->where($where)->update("commodity_typ", $data);
    }

    public function getCommodityTypById($id) {
        $query = $this->db->get_where("commodity_typ", array("cdytyp_id" => $id));
        return $query->row_array();
    }

    public function getCommodityTyp($where) {
        $query = $this->db->get_where("commodity_typ", $where);
        return $query->result_array();
    }

    /**
     * 根据id删除商品类型
     * @param type $ids array or string
     */
    public function deleteCommodityTyp($ids) {
        if (is_array($ids)) {
            $this->db->where_in("cdytyp_id", $ids);
        } else {
            $this->db->where("cdytyp_id", $ids);
        }
        return $this->db->delete("commodity_typ");
    }

}
