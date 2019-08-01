<?php

class TagModel extends CI_Model {

    public function getTagList($page = 1, $limit = 20,$file_name='') {
        $this->db->select('*')->from('tag');
        if(!empty($file_name)){
             $this->db->or_like(array('product_tag_id' => $file_name, 'tag_name' => $file_name));
        }
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $query = $this->db
                ->limit($limit,($page-1)*$limit)
                ->order_by('product_tag_id', 'DESC')
                ->get();
        return array("count" => $rownum, "result" => $query->result_array());
    }

    public function autoTagList($tag_id) {
        $this->db->select('*')
                ->from('tag');
        if (!empty($tag_id))
            $this->db->or_like(array('product_tag_id' => $tag_id, 'name' => $tag_id));
        $query = $this->db->limit(10)
                ->get();
        return $query->result_array();
    }

    public function getTagById($product_tag_id) {
        $query = $this->db->get_where("tag", array("product_tag_id" => $product_tag_id));
        return $query->row_array();
    }

    public function addTag($data) {
        return $this->db->insert("tag", $data);
    }

    public function editTag($data, $where) {
        return $this->db->update("tag", $data, $where);
    }

    public function deleteTag($where) {
        return $this->db->delete("tag", $where);
    }

    /**
     * 判断条件下的设置是否存在
     * @param array $where
     * @return bool
     */
    public function isExist($where) {
        $query = $this->db->get_where("tag", $where);
        $row = $query->row_array();
        return empty($row) ? FALSE : TRUE;
    }

}
