<?php

/**
 * 广告位和广告管理模型
 *
 * @author Administrator
 */
class AdvertModel extends CI_Model {

    /**
     * 添加广告位
     */
    public function addPosition($data) {
        return $this->db->insert("ad_position",$data);
    }

    public function editPosition($data, $where) {
        return $this->db->update("ad_position",$data,$where);
    }

    public function deletePosition($where) {
        return $this->db->delete('ad_position',$where);
    }
    public function getPositionList($where=array(), $limit=20, $offset=0) {
        $this->db->select("*")->from("ad_position");
                // ->where($where);
        if(!empty($where['ad_position_name'])){
            $this->db->like("ad_position_name",$where['ad_position_name'],"left");
            unset($where['ad_position_name']);
        }
        if($where){
             $this->db->or_like(array('ad_position_name' => $where['ad_position_name']));
        }
        
        $result_query=  clone ($this->db);
        $count=$this->db->count_all_results();
        $query=$result_query->limit($limit,$offset)->order_by("ad_position_id","desc")->get();
        $results=$query->result_array();
        //获取当前广告位的广告数量
        if(!empty($results)){
            foreach($results as &$result){
                $this->db->select("*")->from("ad")->where(array("position_id"=>$result['ad_position_id']));
                $result['adcount']=$this->db->count_all_results();
            }
        }
        $data=array("count"=>$count,"data"=>$results);
        return $data;
    }
    
    public function getPositon($where){
        $query=$this->db->get_where("ad_position",$where);
        return $query->row_array();
    }

    /**
     * 添加广告
     * @param type $data
     */
    public function addAdvert($data) {
         return $this->db->insert("ad",$data);
    }

    public function editAdvert($data, $where) {
        return $this->db->update("ad",$data,$where);
    }

    public function deleteAdvert($where) {
        return $this->db->delete('ad', $where);
    }

    public function getAdvertList($where=array(), $limit=20, $offset=0) {
       $this->db->select("*,ad_position.ad_position_name")->from("ad")
                ->where($where)
                ->join("ad_position", "ad.position_id=ad_position.ad_position_id", "left");
        $result_query = clone ($this->db);
        $count = $this->db->count_all_results();
        $query = $result_query->limit($limit, $offset)->order_by("ad.ad_id", "desc")->get();
        $results = $query->result_array();
        $data = array("count" => $count, "data" => $results);
        return $data;
    }
    
    public function getAdvert($where){
       $query =  $this->db->select("*,ad_position.ad_position_name")
                        ->join("ad_position","ad.position_id=ad_position.ad_position_id","left")
                        ->where($where)
                        ->from("ad")
                        ->get();
        return $query->row_array();
    }

    //自动加载广告位
    public function autoUposition($position_id){
        $data = array();
        $this->db->select('*')
                ->from('ad_position');
        if (!empty($position_id))
            $this->db->or_like(array('ad_position_id' => $position_id, 'ad_position_name' => $position_id));
        $data = $this->db->limit(10)
                ->get()->result_array();
        return $data;
    }

}
