<?php

class CategoryModel extends CI_Model {

    public function getCategoryList($page = 0, $limit = 20, $file_name = '') {
        $this->db->select('*')->from('category');
        if (!empty($file_name)) {
            $this->db->or_like(array('category_id' => $file_name, 'name' => $file_name));
        }
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $query = $this->db
                ->limit($limit, ($page - 1) * $limit)
                ->get();
        return array("count" => $rownum, "result" => $query->result_array());
    }

    /**
     * 适应前台插件的树形结构
     */
    public function getCategoryToJson($parent_id = 0) {
        $data = array();
        $query = $this->db->select('*')
                ->from('category')
                ->where('parent_id=' . $parent_id)
                ->order_by('sort', 'DESC')
                ->get();
        $newdata = '[';
        foreach ($query->result_array() as $value) {
            $newdata .= '{'
                    . 'name:"' . $value['name'] . '",'
                    . 'id:"' . $value['category_id'] . '",'
                    . 'images:"' . (empty($value['image']) ? '/upload/image/no_image.png' : '/upload/image/'.$value['image']) . '",'
                    . 'edit:"' . site_url("Category/editCategory/" . $value['category_id']) . '",';
            $return = $this->getCategoryToJson($value['category_id']);
            if (!empty($return)) {
                $newdata .= 'children:' . $this->getCategoryToJson($value['category_id']);
            }
            $newdata .= '},';
        }
        $newdata .= ']';
        return $newdata;
    }

    public function autoCategoryList($search_name, $add = 0) {
        $data = array();
        if (!empty($add)) {
            $data[0]['name'] = '---顶级分类---';
            $data[0]['category_id'] = '0';
            $data[0]['parent_id'] = '0';
        }
        $this->db->select('*')->from('category')->order_by('sort', 'DESC');
        if (!empty($search_name)) {
            $this->db->or_like(array('category_id' => $search_name, 'name' => $search_name));
        }
        $query=$this->db->get();
        return $query->result_array();
    }

    public function getCategoryById($category_id) {
        $sql = "SELECT c1.*,(select c2.name from " . $this->db->dbprefix('category') . " c2 where c2.category_id=c1.parent_id) as parent_name  from " . $this->db->dbprefix('category') . " c1 where c1.category_id in (" . $category_id . ')';
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function getCategoryByParentid($category_id) {
        $query = $this->db->select('*')
                ->from('category')
                ->where_in("parent_id", $category_id)
                ->get();
        return $query->row_array();
    }

        //批量查询商品分类
    public function getCategorys($where){
        return $this->db->from("category")->where_in("category_id",$where)->get()->result_array();
    }

    public function addCategory($data) {
        return $this->db->insert("category", $data);
    }

    public function editCategory($data, $where) {
        return $this->db->update("category", $data, $where);
    }

    public function deleteCategory($where) {
        return $this->db->delete("category", $where);
    }

    /**
     * 判断条件下的设置是否存在
     * @param array $where
     * @return bool
     */
    public function isExist($where) {
        $query = $this->db->get_where("category", $where);
        $row = $query->row_array();
        return empty($row) ? FALSE : TRUE;
    }

}
