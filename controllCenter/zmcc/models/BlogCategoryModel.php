<?php
Class BlogCategoryModel extends CI_Model {

    public $table = "zm_blog_category";

    /**
     * 适应前台插件的树形结构
     */
    public function getCategoryToJson($parent_id = 0) {
        $data = array();
        $query = $this->db->select('*')
                ->from('blog_category')
                ->where('parent_id=' . $parent_id)
                ->get();
       
        $newdata = '[';
        foreach ($query->result_array() as $value) {
            if($value['published'] == 1){$value['published'] = "公开";}else{$value['published'] = "不公开";}
            $newdata .= '{'
                    . 'name:"' . $value['category_name'] . '",'
                    . 'id:"' . $value['blog_category_id'] . '",'
                    . 'image:"' . base_url() . 'upload/image/' . (empty($value['image']) ? 'no_image.jpg' : $value['image']) . '",'
                    . 'published:"' . $value['published'] . '",'
                    . 'store_id:"' . $value['store_id'] . '",'
                    . 'keywords:"' . $value['keywords'] . '",'
                    . 'sort_order:"' . $value['sort_order'] . '",'
                    . 'status:"' . $value['status'] . '",'
                    . 'edit:"' . site_url("BlogCategory/editBlogCategory/" . $value['blog_category_id']) . '",';
            $return =$this->getCategoryToJson($value['blog_category_id']);
            if (!empty($return)){
             $newdata .= 'children:' . $this->getCategoryToJson($value['blog_category_id']);
            }
            $newdata .= '},';
        }
        $newdata .= ']';
        return $newdata;
    }
    
    public function getBlogCategoryInfo($blog_category_id) {
        $query = $this->db->get_where($this->table,array('blog_category_id'=>$blog_category_id));       
        return $query->row_array();
    }
   
    //添加分类
    public function addBlogCategory($data) {
        $this->db->insert("zm_blog_category",$data);
        $sql = $this->db->last_query();
        return $sql;
    }
    
    // 删除分类
    public function deleteBlogCategory($where) {
       return $this->db->delete("zm_blog_category",$where);
    }
    
    //编辑
    public function editBlogCategory($data,$where) {
        return $this->db->update($this->table,$data,$where);
    }
    
    public function get_art_info($where) {
        $query = $this->db->select("blog_category.*")
                ->where($where)
                ->get($this->table);
        return  $query->row_array();
    }
    
    public function categoryList() {
        $query = $this->db->get("blog_category");
        return $query->result_array();
    }
    
    public function autoCategoryList($parent_id, $add = 0) {
        $data = array();
        if (!empty($add)) {
            $data[0]['category_name'] = '---顶级分类---';
            $data[0]['blog_category_id'] = '0';
            $data[0]['parent_id'] = '0';
        }
        $this->db->select('*')
                ->from('blog_category');
        if (!empty($parent_id))
            $this->db->or_like(array('blog_category_id' => $parent_id, 'category_name' => $parent_id));
        $query = $this->db->limit(5)
                ->order_by('sort_order', 'DESC')
                ->get();
        foreach ($query->result_array() AS $arr) {
            $data[] = $arr;
        }
        return $data;
    }
}
    
?>
