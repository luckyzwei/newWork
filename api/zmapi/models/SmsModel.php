<?php

/**
 * 短信验证码模型
 */
class SmsModel extends CI_Model {

    /**
     * 获取订单发送日志
     * @param string $phone 手机号
     */
    public function getSmslog($phone) {
        $query = $this->db->select('*')
                ->from("sms_log")
                ->where("mobile = '" . $phone . "'")
                ->get();
        return $query->row_array();
    }

    /**
     * 验证用户短信验证码
     * @param type $where 检测条件
     */
    public function checkCode($where) {
        return $this->db->from("sms_log")
                        ->where($where)
                        ->count_all_results();
    }

    /**
     * 登陆结果执行函数
     * $res 0 执行登陆失败数据 1 执行登陆成功数据
     *          
     */
    public function setSmsLog($phone, $res = 0, $code = '') {
        if (empty($res)) {
            $this->db->set('count', 'count+1', FALSE)
                    ->set('historycount', 'historycount+1', FALSE)
                    ->set('code', $code)
                    ->set('lasttime', time())
                    ->where("mobile = '" . $phone . "'")
                    ->update('sms_log');
        } else {
            $this->db->set('count', '0')
                    ->set('lasttime', time())
                    ->where("mobile = '" . $phone . "'")
                    ->update('sms_log');
        }
    }

    /**
     * 增加短信发送记录
     * @param type $phone 手机号
     */
    public function addSmslog($phone) {
        $data['mobile'] = $phone;
        $data['lasttime'] = time();
        $this->db->insert('sms_log', $data);
        return  $this->db->insert_id();
    }

}
