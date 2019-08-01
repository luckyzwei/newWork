<?php

Class ArticleCategoryModel extends CI_Model {

    public $table = "zm_article_category";

    /**
     * 适应前台插件的树形结构
     */
    public function getCategoryToJson($parent_id = 0) {
        $data = array();
        $query = $this->db->select('*')
                ->from('article_category')
                ->where('parent_id=' . $parent_id)
                ->get();
       
        $newdata = '[';
        foreach ($query->result_array() as $value) {
            $newdata .= '{'
                    . 'name:"' . $value['category_name'] . '",'
                    . 'sort_order:"' . $value['sort_order'] . '",'
                    . 'id:"' . $value['article_category_id'] . '",'
                    . 'edit:"' . site_url("ArticleCategory/editArticleCategory/" . $value['article_category_id']) . '",';
            $return =$this->getCategoryToJson($value['article_category_id']);
            if (!empty($return)){
             $newdata .= 'children:' . $this->getCategoryToJson($value['article_category_id']);
            }
            $newdata .= '},';
        }
        $newdata .= ']';
        return $newdata;
    }
    
    public function getCategoryList($page=0,$limit=5) {
        $this->db->select('*')
                ->from('article_category');
        $count_db = clone($this->db);
        $total = $count_db->count_all_results();
        $query = $this->db
                ->select('category_name')
                ->limit($limit, ($page - 1) * $limit)
                ->get();
        return array("count" => $total, "result" => $query->result_array());
    }
    
    public function getArticleCategoryInfo($article_category_id) {
        $query = $this->db->get_where($this->table,array('article_category_id'=>$article_category_id));       
        return $query->row_array();
    }
    
    //分类添加
    public function addArticleCategory($data) {
        $this->db->insert("zm_article_category",$data);
        $sql = $this->db->last_query();
        return $sql;
    }
    
    // 删除分类
    public function deleteArticleCategory($where) {
       return $this->db->delete("zm_article_category",$where);
    }
    
    //修改
    public function editArticleCategory($data,$where) {
        return $this->db->update($this->table,$data,$where);
    }
    
    public function get_art_info($where) {
        $query = $this->db->select("article_category.*")
                ->where($where)
                ->get($this->table);
        return  $query->row_array();
    }
    
    public function categoryList() {
        $query = $this->db->get("article_category");
        return $query->result_array();
    }
    
    public function autoCategoryList($parent_id, $add = 0) {
        $data = array();
        $this->db->select('*')
                ->from('article_category');
        if (!empty($parent_id))  
            $this->db->or_like(array('article_category_id' => $parent_id, 'category_name' => $parent_id));
        $query = $this->db
                ->order_by('sort_order', 'DESC')
                ->get();
        foreach ($query->result_array() AS $arr) {
            $data[] = $arr;
        }
        return $data;
    }
    

}

