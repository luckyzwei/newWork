<?php

/**
 * 营销策略模型
 * @package   ZMshop
 * @author     xuhuan@hnzhimo.com
 * @copyright  2017 河南知默网络科技有限公司
 * @link       http://www.hnzhimo.com
 * @since      Version 1.0.0
 */
class MarketingModel extends CI_Model {

    public $table = "sale_marketing";
    public function getMarketingList($limit = 20, $page = 0) {
        $count = $this->db->select('*')->from($this->table)->count_all_results();
        $query = $this->db->order_by('marketing_id desc')
                ->limit($limit, ($page - 1) * $limit)
                ->get($this->table);
        return array('count' => $count, 'datas' => $query->result_array());
    }

    public function addMarketing($data) {
//		var_dump($data);
        $data['createtime'] = time();
        $data['starttime'] = strtotime($data['starttime']);
        $data['endtime'] = strtotime($data['endtime']);
        $data['marketing_category'] = implode("|", $data['marketing_category']);
        $data['marketing_product'] = implode("|", $data['marketing_product']);
		$data['give_product'] = implode("|", $data['give_product']);
        return $this->db->insert($this->table,$data);
    }

    public function editMarketingBy($data, $where) {
        $data['starttime'] = strtotime($data['starttime']);
        $data['endtime'] = strtotime($data['endtime']);
        $data['marketing_category'] = implode("|", $data['marketing_category']);
        $data['marketing_product'] = implode("|", $data['marketing_product']);
		$data['give_product'] = implode("|", $data['give_product']);
        return $this->db->update($this->table,$data,$where);
    }

    public function deleteMarketing($where) {
        return $this->db->delete($this->table, $where);
    }

    public function getMarketingById($marketing_id) {
        $query = $this->db->get_where($this->table, array('marketing_id' => $marketing_id));
        return $query->row_array();
    }


}
