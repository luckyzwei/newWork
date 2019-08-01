<?php

Class BlogModel extends CI_Model {

    public $table = "zm_blog";
    
    public function getBlogList($page = 0, $limit = 10,$file = array()) {
        $this->db->select('b.blog_id,b.blog_name,b.blog_category_id,b.content,b.status,b.hits,b.image,b.keywords,b.sort_order,b.updatetime')
                ->from('blog b');
        if(!empty($file['name'])){
            $this->db->like(array('blog_name'=>$file['name']));
        }
        if(!empty($file['status'])){
            $this->db->where('b.status='.$file['status']);
        }
        $count_db = clone($this->db);
        $total = $count_db->count_all_results();
        $query = $this->db
                ->select('bc.category_name')
                ->limit($limit, ($page - 1) * $limit)
                ->join('blog_category bc','bc.blog_category_id = b.blog_category_id','left')
                ->order_by('blog_id','DESC')
                ->get();
        $return = array("count" => $total, "result" => $query->result_array());
        return $return;
    }
    
    //添加博客
    public function addBlog($data,$relate=array()) {
        $data['updatetime'] = $data['createtime']  = time();
        $this->db->insert("zm_blog",$data);
        $blog_id = $this->db->insert_id();
        foreach ($relate as $value) {
            $this->db->insert('blog_relate',array('blog_id'=>$blog_id,'product_id'=>$value));
        }
        return $blog_id;
    }
    
    //删除博客
    public function deleteBlog($where) {
        return $this->db->delete("zm_blog",$where);
    }
    //删除博客关联的商品
    public function deleteBlog_relate($blog_id,$blog_relate=''){
        if(!empty($blog_relate))
            $this->db->where_in('product_id ', $blog_relate);
        return $this->db->delete("blog_relate",array('blog_id'=>$blog_id));
    }
    //新增博客关联的商品
    public function addBlog_relate($blog_relate){
        return $this->db->insert_batch('blog_relate',$blog_relate);
    }

    //编辑博客
    public function editBlog($data, $where,$blog_relate='') {
        $data['updatetime']  = time();
        $this->db->update($this->table,$data,$where);
        return $this->db->affected_rows();
    }

    public function get_art_info($blog_id) {
        $query = $this->db->select('b.blog_id,b.blog_name,b.blog_category_id,b.content,b.status,b.hits,b.image,b.keywords,b.sort_order,b.updatetime')
                ->from('blog b')
                ->select('bc.category_name')
                ->join('blog_category bc','bc.blog_category_id = b.blog_category_id','left')
                ->where('b.blog_id = '.$blog_id)
                ->get($this->table);
        $shop = $this->db->select('br.relate_id,br.product_id,p.product_name')
                ->from('blog_relate br')
                ->join('product p','p.product_id = br.product_id','left')
                ->where('br.blog_id = '.$blog_id)
                ->get();
        return array("return" => $query->row_array(), "shop" => $shop->result_array());
    }

}

?>
