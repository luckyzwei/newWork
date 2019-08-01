<?php

/**
 * 广告位&广告模型
 * @package    ZMshop
 * @author liuchenwei@hnzhimo.com
 * @copyright  2018 河南知默网络科技有限公司
 * @link   http://www.hnzhimo.com
 * @since  Version 1.0.0
 */
class AdvertModel extends CI_Model {

    //获取广告数据
    public function getAdvert($position_id) {
        $query = $this->db->select('*')
                ->from('ad')
                ->where(array('position_id' => $position_id, 'ad_status' => 1))
                ->order_by('sort','DESC')
                ->get();
        return $query->result_array();
    }

    //获取广告位
    public function ad_position() {

        return $query = $this->db->select('*')->from('ad_position')->get()->result_array();
    }

}

?>