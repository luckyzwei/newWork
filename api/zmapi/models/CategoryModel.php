<?php

/**
 * 商品分类数据模型
 */
class CategoryModel extends CI_Model {

    public function getCategoryList($parent_id = 'all', $limit = 'all', $where = '') {
        $this->db->select('*')
                ->from('category');
        
        if ($parent_id !== 'all')
            $this->db->where('parent_id = ' . $parent_id);
        if (!empty($where))
            $this->db->where($where);
        if ($limit !== 'all')
            $this->db->limit($limit);

        $query = $this->db->where('isshow=1')
                ->order_by('sort', 'DESC')
                ->get();
        
        return $query->result_array();
    }
    
  

}
