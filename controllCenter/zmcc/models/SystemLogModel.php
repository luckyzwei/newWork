<?php

/**
 * 权限拦截器：主要实现权限的控制拦截和记录操作日志
 *
 * @author qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 */
class SystemLogModel extends CI_Model{
    
    /**
     * 写系统日志
     * @param type $data
     */
    public function writeLog($data){
        return $this->db->insert("systemlog",$data);
    }
    /**
     * 获取日志列表
     * @param array $params 查询参数
     * @param int $start 开始行号
     * @param int $end 结束行行
     * @return array
     */
    public function getLogs($params,$start,$end){
        $query=$this->db->select("*")
                ->from("systemlog")
                ->limit($start,$end)
                ->order("log_id desc")->get();

       return $query->result_array();
    }
}
