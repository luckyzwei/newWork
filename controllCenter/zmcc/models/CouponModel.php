<?php

/**
 * 优惠劵模型
 * @package    ZMshop
 * @author liuchenwei@hnzhimo.com
 * @copyright  2017 河南知默网络科技有限公司
 * @link   http://www.hnzhimo.com
 * @since  Version 1.0.0
 */
class CouponModel extends CI_Model
{

    //优惠劵列表
    public function getList($where = array(), $page = 1, $limit = 20)
    {
        $this->db->select('*')->from('coupon');
        if ($where) {
            $this->db->or_like(array('coupon_name' => $where['filter_agent']));
        }
        $count_db = clone ($this->db);
        $rownum = $count_db->count_all_results();
        $query = $this->db
            ->limit($limit, ($page - 1) * $limit)
            ->order_by("coupon_id desc")
            ->get();
        $coupon = $query->result_array();
        $cou = $this->db->select("count('user_coupon.status')as totals,coupon.coupon_id")
            ->where('user_coupon.status =1')
            ->from('user_coupon')
            ->group_by('coupon.coupon_id')
            ->join("coupon", "user_coupon.coupon_id = coupon.coupon_id", "left")
            ->get();
        $shu = $cou->result_array();
        foreach ($coupon as $key => $value) {
            $coupon[$key]['totals'] = array();
            foreach ($shu as $k => $v) {
                if ($value['coupon_id'] == $v['coupon_id']) {
                    $coupon[$key]['totals'] = $v['totals'];
                }
            }
        }
        return array("count" => $rownum, "result" => $coupon);
    }

    //添加优惠劵
    public function addCoupon($data)
    {
        if (empty($data['enable_product']) && empty($data['enable_product'])) {
            $data['enable_product'] = "";
            $data['disable_product'] = "";
            $this->db->insert('coupon', $data);
            return 1;
        } else {
            if (array_intersect($data['enable_product'], $data['disable_product']) != null) {
                return $res['error'] = "适用商品和不适用商品不能相同";
            } else {
                if (!empty($data['enable_product'])) {
                    $data['enable_product'] = '|' . implode(",", $data['enable_product']) . '|';
                } else {
                    $data['enable_product'] = "";
                }
                if (!empty($data['disable_product'])) {
                    $data['disable_product'] = '|' . implode(",", $data['disable_product']) . '|';
                } else {
                    $data['disable_product'] = "";
                }
                $this->db->insert('coupon', $data);
                return 1;
            }
        }
    }

    //编辑优惠劵
    public function editCoupon($data, $where)
    {
        if (empty($data['enable_product']) && empty($data['disable_product'])) {
            $data['enable_product'] = "";
            $data['disable_product'] = "";
            $this->db->update('coupon', $data, $where);
            return 1;
        } else {
            if (array_intersect($data['enable_product'], $data['disable_product']) != null) {
                return $res['error'] = "适用商品和不适用商品不能相同";
            } else {
                if (!empty($data['enable_product'])) {
                    $data['enable_product'] = '|' . implode(",", $data['enable_product']) . '|';
                } else {
                    $data['enable_product'] = "";
                }
                if (!empty($data['disable_product'])) {
                    $data['disable_product'] = '|' . implode(",", $data['disable_product']) . '|';
                } else {
                    $data['disable_product'] = "";
                }
                $this->db->update('coupon', $data, $where);
                return 1;
            }
        }
    }

    //删除优惠劵
    public function deleteCoupon($where)
    {
        $res = $this->db->from('user_coupon')->where($where)->where('status = 1')->get();
        $res = $res->result_array();
        if (!empty($res)) {
            return true;
        } else {
            $this->db->delete("coupon", $where);
            return false;
        }
    }

    //根据条件查询数据
    public function sel($where)
    {
        $query = $this->db->get_where("coupon", array("coupon_id" => $where));
        $coupon = $query->row_array();
        $enable_product = "";
        $disable_product = "";
        if (!empty($coupon['enable_product'])) {
            $coupon['enable_product'] = explode('|', $coupon['enable_product']);
            $coupon['enable_product'] = implode(',', $coupon['enable_product']);
            $coupon['enable_product'] = trim($coupon['enable_product'], ",");
            $enable_product = $this->db->from("product")->where('product_id in (' . $coupon['enable_product'] . ')')->get();
            $enable_product = $enable_product->result_array();
        }
        if (!empty($coupon['disable_product'])) {
            $coupon['disable_product'] = explode('|', $coupon['disable_product']);
            $coupon['disable_product'] = implode(',', $coupon['disable_product']);
            $coupon['disable_product'] = trim($coupon['disable_product'], ",");
            $disable_product = $this->db->from("product")->where('product_id in (' . $coupon['disable_product'] . ')')->get();
            $disable_product = $disable_product->result_array();
        }
        return array("count" => $coupon, "result" => $enable_product, "disable_product" => $disable_product);
    }

    /**
     * 发放优惠券
     * @param array $data
     * @return boolean
     */
    public function sendCoupon($data)
    {
        $groupuserid = array();
        if (!empty($data['user_group_id'])) {
            $this->db->select('user_id');
            $query = $this->db->where_in('user_group_id', array_filter($data['user_group_id']))->get("user");
            $user_id = $query->result_array();
            foreach ($user_id as $uid) {
                $groupuserid[] = $uid['user_id'];
            }
        }
        foreach ($data['user_id'] as $v) {
            $arr[] = $v['user_id'];
        }
        $userids = array_merge($groupuserid, $arr);
        $zong = count($userids) * intval($data['coupon_num']);
        $lishi = $this->db->get_where("coupon", array("coupon_id" => $data['coupon_id']));
        $coupon = $lishi->row_array();
        $yong = $coupon['use_num'];
        $xian['use_num'] = $zong + $yong;
        $this->db->update('coupon', $xian, array("coupon_id" => $data['coupon_id']));
        if (!empty($userids)) {
			foreach($userids as $uid){
				for($ci=0;$ci<$data['coupon_num'];$ci++){
					$batchinsert[] = array('user_id' => $uid, 'coupon_id' => $data['coupon_id']);
				}
			}
            $this->db->insert_batch('user_coupon', $batchinsert);
            return true;
        } else {
            return false;
        }

    }

    //查找用户
    public function autoUser($user_id)
    {
        $data = array();
        $this->db->select('*')
            ->from('user');
        if (!empty($user_id)) {
            $this->db->or_like(array('user_id' => $user_id, 'nickname' => $user_id));
        }

        $query = $this->db->limit(10)
            ->get();
        foreach ($query->result_array() as $arr) {
            $data[] = $arr;
        }
        return $data;
    }

}
