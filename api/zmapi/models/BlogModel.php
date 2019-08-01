<?php

/**
 * 博客模型
 * @package    ZMshop
 * @author liuchenwei@hnzhimo.com
 * @copyright  2018 河南知默网络科技有限公司
 * @link   http://www.hnzhimo.com
 * @since  Version 1.0.0
 */

class BlogModel extends CI_Model
{

    //获取博客分类
    public function blog_category()
    {
        return $query = $this->db->select('*')->from('blog_category')->get()->result_array();
    }

    //获取博客分类下的博客
    public function blog($blog_category_id, $user_id, $page = 1, $limit = 10)
    {
        $this->db->select('b.blog_id,b.blog_name,b.blog_category_id,b.content,,b.user_id,b.status,b.hits,b.image,b.keywords,b.sort_order,b.updatetime')
            ->from('blog b')->where(array("b.status" => 0, "b.user_id" => $user_id));
        $count_db = clone ($this->db);
        $total = $count_db->count_all_results();
        $query = $this->db
            ->select('bc.category_name')
            ->limit($limit, ($page - 1) * $limit)
            ->join('blog_category bc', 'bc.blog_category_id = b.blog_category_id', 'left')
            ->order_by('updatetime', 'DESC')
            ->get();
        return $return = array("count" => $total, "result" => $query->result_array());
    }

    //获取博客内容详情
    public function blog_info($blog_id)
    {
        return $this->db->select('*')->from("blog")->where('blog_id =' . $blog_id)->get()->row_array();
    }
}
