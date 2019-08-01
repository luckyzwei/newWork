<?php

/**
 * 数据统计模型
 * @package    ZMshop
 * @author qidazhong@hnzhimo.com
 * @copyright  2018 河南知默网络科技有限公司
 * @link   http://www.hnzhimo.com
 * @since  Version 1.0.0
 */
class StaticsModel extends CI_Model {

    /**
     * 更新统计数据
     * @param type $data
     * @return boolean
     */
    public function update($data) {
        $date=date("Y-m-d");
        $has=$this->db->select("*")->where("datatime",$date)->get("statics")->row_array();
        if(!empty($has)){
            $this->db->set($data[0],$data[0]."+".$data[1],FALSE)->where("datatime",$date)->update("statics");
        }else{
            $this->db->insert("statics",array($data[0]=>$data[1],"datatime"=>$date));
        }
        return true;
    }

    /**
     * 获取统计信息
     * @param type $start_time
     * @param type $end_time
     * @return type
     */
    public function get_statics($start_time,$end_time) {
        return $query = $this->db->select('*')->where("datatime between(".$start_time.",".$end_time.")")->from('statics')->get()->result_array();
    }

}

?>