<?php
/**
 *api接口模型
 * @package	Zmapi
 * @author	qidazhong@hnzhimo.com
 * @copyright	2017 河南知默科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class ApiModel extends CI_Model{
    
   public function checkApi($where){
       $query= $this->db->get_where("api",$where);
       return $query->row_array();
   }

}
