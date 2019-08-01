<?php

/**
 * 文章模型
 * @package    ZMshop
 * @author liuchenwei@hnzhimo.com
 * @copyright  2018 河南知默网络科技有限公司
 * @link   http://www.hnzhimo.com
 * @since  Version 1.0.0
 */
class ArticleModel extends CI_Model {

    //获取分类下的文章
    public function getArticles($article_category_id, $page = 1, $limit = 10) {
        $this->db->select('article_id,images,article_name,article_category_id,author')->from("article")->where(array('article_category_id' => $article_category_id));
        $count_db = clone($this->db);
        $total = $count_db->count_all_results();
        $query = $this->db
                ->limit($limit, ($page - 1) * $limit)
                ->get();
        return array("count" => $total, "result" => $query->result_array());
    }

    //获取文章分类
    public function getCategory() {
        return $query = $this->db->select('*')->from('article_category')->get()->result_array();
    }

    public function get_product_info($article_id) {
        $query = $this->db->select('*')
                ->from('article')
                ->where('article_id=' . $article_id)
                ->get();
        return $query->row_array();
    }

}
