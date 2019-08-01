<?php

/**
 * 地址配送方式数据模型
 */
class AddressModel extends CI_Model {
/**
 * 
 * @param type $user_id
 * @param type $address_id 未定义情况下返回默认地址
 * @return type
 */
    public function getAddressInfo($user_id, $address_id = 0) {
        if (!empty($address_id)) {
            $this->db->where('address_id = ' . $address_id);
        }
        else{
            $this->db->where('is_default =1 ');
        }
        $query = $this->db->select('*')
                ->from('user_address')
                ->where('user_id = ' . $user_id)
                ->order_by('is_default', 'DESC')
                ->get();
        return $query->row_array();
    }

    //根据地区ID来获取物流配置信息
    public function getLogisticsList($district_id) {
        $query = $this->db->select('logistics_id,logistics_name,logistics_fee,logistics_weight,logistics_add_fee')
                ->from('logistics')
                ->where('status>0')
                ->like('support_area', '|' . $district_id . '|')
                ->order_by('logistics_fee', 'ASC')
                ->get();
        return $query->result_array();
    }

    //检查是否有配置配送方式
    public function checkLogistics() {
        $query = $this->db->select('count(*) as total')
                ->from('logistics')
                ->where('status>0')
                ->order_by('logistics_fee', 'ASC')
                ->get();
        return $query->row_array('total');
    }

    //执行添加收货地址
    public function addAddress($data) {
        $this->db->insert('user_address', $data);
        return $this->db->insert_id();
    }

    //获取收货地址列表
    public function getAddressList($user_id) {
        $query = $this->db->select('province_name,city_name,district_name,address,is_default,name,telephone,address_id')
                ->from('user_address')
                ->order_by("is_default", "DESC")
                ->where('user_id = ' . $user_id)
                ->get();
        return $query->result_array();
    }

    //删除收货地址
    public function deleteAddress($address_id){
        return $this->db->where("address_id",$address_id)->delete('user_address');
    }


    //执行编辑收货地址
    public function editAddres($arr,$where){
         return $this->db->update('user_address', $arr, $where);
    }

    //设置默认收货地址
    public function setDefault($address_id, $user_id) {
         $this->db->set('is_default', 0)
                ->where("user_id = '" . $user_id . "'")
                ->update('user_address');
        return $this->db->set('is_default', 1)
                ->where("user_id = '" . $user_id . "' and address_id = '" . $address_id . "'")
                ->update('user_address');
    }

}
