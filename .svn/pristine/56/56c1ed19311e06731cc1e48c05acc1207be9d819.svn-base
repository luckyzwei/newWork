<?php
Class ArticleModel extends CI_Model {
    public $table="zm_article";
    public function getArticleList($page=0,$limit=10,$file = array()) {
        
        $this->db->select('a.article_id,a.images,a.article_name,a.article_category_id,a.content,a.author')
                ->from('article a');
        if(!empty($file['name'])){
            $this->db->like(array('article_name'=>$file['name']));
        }
        if(!empty($file['article_author'])){
            $this->db->where(array('author'=>$file['article_author']));
        }
        $count_db = clone($this->db);
        $total = $count_db->count_all_results();
        $query = $this->db
                ->select('ac.category_name')
                ->limit($limit,($page-1)*$limit)
                ->join('article_category ac','ac.article_category_id = a.article_category_id','left')
                ->order_by('article_id','DESC')
                ->get();
         return array("count" => $total, "result" => $query->result_array());
    }
    
    //向数据库插入新数据
    public function addArticle($data) {    
        return $this->db->insert("zm_article",$data);
    }
    
   // 删除
    public function deleteArticle($where) {
       return $this->db->delete("zm_article",$where);
    }
    
    //修改
    public function editArticle($data,$where) {
        $this->db->update($this->table,$data,$where);
    }
    
    public function get_art_info($where) {
        $this->db->select('a.article_id,a.images,a.article_name,a.article_category_id,a.content,a.author')
                ->from('article a');
        $count_db = clone($this->db);
        $query = $this->db
                ->select('ac.category_name')
                ->join('article_category ac','ac.article_category_id = a.article_category_id','left')
                ->where($where)
                ->get($this->table);
        $return = $query->row_array();
        return $return;
    }
}

?>