<?php

class ProductModel extends CI_Model {

    /**
     * 获取商品列表
     * @param type $page
     * @param type $limit
     * @param type $file
     * @return type
     */
    public function getProductList($page = 0, $limit = 20, $filter = array()) {
        $this->db->select('p.updatetime,p.product_id,p.product_sn,'
                        . 'p.product_name,p.store_number,'
                        . 'p.status,p.createtime,p.images,p.price,p.recommend')
                ->from('product p')
                ->where('status != -1 ');
        if (!empty($filter['filter_name'])) {
            $this->db->group_start();
            $this->db->like("p.product_name", $filter['filter_name'], "both");
            $this->db->or_like("p.product_sn", $filter['filter_name'], "both");
            $this->db->or_like("p.product_id", $filter['filter_name'], "both");
            $this->db->or_where("round(p.price,2)", $filter['filter_name']);
            $this->db->group_end();
        }

        if (!empty($filter['filter_status'])) {
            $this->db->where(array('status' => $filter['filter_status']));
        }
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $query = $this->db
                ->select('pd.sale_number,pd.incart_number,pd.click_number,pd.like_number')
                ->limit($limit, ($page - 1) * $limit)
                ->join('product_dynamics pd', 'pd.product_id = p.product_id', 'left')
                ->order_by("field(p.status,'1','2'),p.sort desc,p.product_id desc")
                ->get();

        return array("count" => $rownum, "result" => $query->result_array());
    }

    /**
     * 添加商品数据
     * @param type $data 常规商品数据，$$extend_data扩展数据array("tag"=>array,…………)
     * @return string
     */
    public function addProduct($data, $extend_data) {
        $product_id = 0;
        if ($this->db->insert("product", $data)) {
            $product_id = $this->db->insert_id();
            $this->db->insert("product_dynamics", array("product_id" => $product_id));
            //添加商品规格
            if (!empty($extend_data['productSpecial'])) {
                $extend_data['productSpecial']['product_id'] = $product_id;
                $this->db->insert("product_special", $extend_data['productSpecial']);
            }
            //保存商品标签
            if (!empty($extend_data['productTags'])) {
                foreach ($extend_data['productTags'] as $tag) {
                    $data = array("tag_id" => $tag, "product_id" => $product_id);
                    $this->db->insert("product_tag", $data);
                }
            }
            //保存关联商品
            if (!empty($extend_data['productLinks'])) {
                foreach ($extend_data['productLinks'] as $link_id) {
                    $data = array("product_id" => $product_id, "link_product_id" => $link_id);
                    $this->db->insert("product_link", $data);
                }
            }
            //保存商品分类
            if (!empty($extend_data['categories'])) {
                foreach ($extend_data['categories'] as $cate_id) {
                    $data = array("product_id" => $product_id, "category_id" => $cate_id);
                    $this->db->insert("product_category", $data);
                }
            }
        }
        return $product_id;
    }

    /**
     * 通过商品编号查找商品,第二个参数定义返回一个不包含该id的数据
     * @param type $sn
     */
    public function getProductBySN($sn, $product_id = 0) {
        $query = $this->db->where(array("product_sn" => $sn, "product_id!=" => $product_id), false)->get("product");
        return $query->row_array();
    }

    /**
     * 根据商品id获取商品属性
     */
    public function getSpecialByProductId($product_id) {
        $query = $this->db->get_where("product_special", array("product_id" => $product_id));
        return $query->row_array();
    }

    public function getProductTagsByProductId($product_id) {
        $query = $this->db->select("t.tag_name,t.product_tag_id")
                ->join("tag t", "t.product_tag_id=tag_id", "left")
                ->where(array("product_id" => $product_id))
                ->get("product_tag pt");
        return $query->result_array();
    }

    public function getCategoriesByProductId($product_id) {
        $query = $this->db->select("category.name as category_name,product_category.*")
                ->join("category", "product_category.category_id=category.category_id")
                ->where("product_category.product_id", $product_id)
                ->get("product_category");
        return $query->result_array();
    }

    public function getLinksByProductId($product_id) {
        $query = $this->db->select("product.product_name,product_link.*")
                ->join("product", "product.product_id=product_link.link_product_id", "left")
                ->where(array("product_link.product_id" => $product_id))
                ->get("product_link");
        return $query->result_array();
    }

    /**
     * 获取商品详情
     * @param type $product_id
     * @return type
     */
    public function getProductById($product_id) {
        $query = $this->db->get_where("product", array("product_id" => $product_id));
        return $query->row_array();
    }

    public function editProduct($data, $extend_data) {
        $product_id = $data['product_id'];
        if ($this->db->update("product", $data, array('product_id' => $product_id))) {
            $this->db->set(array('store_product_price' => $data['price']))
                    ->where("product_id = " . $product_id)->update("store_product");
            //删除属性，标签，链接商品等信息
            $this->db->delete("product_tag", array("product_id" => $product_id));
            $this->db->delete("product_special", array("product_id" => $product_id));
            $this->db->delete("product_link", array("product_id" => $product_id));
            $this->db->delete("product_category", array("product_id" => $product_id));

            //添加商品规格
            if (!empty($extend_data['productSpecial'])) {
                $extend_data['productSpecial']['product_id'] = $product_id;
                $this->db->insert("product_special", $extend_data['productSpecial']);
            }
            //保存商品标签
            if (!empty($extend_data['productTags'])) {
                foreach ($extend_data['productTags'] as $tag) {
                    $data = array("tag_id" => $tag, "product_id" => $product_id);
                    $this->db->insert("product_tag", $data);
                }
            }
            //保存关联商品
            if (!empty($extend_data['productLinks'])) {
                foreach ($extend_data['productLinks'] as $link_id) {
                    $data = array("product_id" => $product_id, "link_product_id" => $link_id);
                    $this->db->insert("product_link", $data);
                }
            }
            //保存商品分类
            if (!empty($extend_data['categories'])) {
                foreach ($extend_data['categories'] as $cate_id) {
                    $data = array("product_id" => $product_id, "category_id" => $cate_id);
                    $this->db->insert("product_category", $data);
                }
            }
        }
        return true;
    }

    public function status($data) {
        return $this->db->where("product_id=" . $data['product_id'])->update("product", $data);
    }

    public function deleteProduct($where) {
        return $this->db->update("product", array('status' => '-1'), $where);
    }

    public function autoProductList($parent_id) {
        $data = array();
        $this->db->select('*')
                ->from('product');
        if (!empty($parent_id)) {
            $this->db->or_like(array('product_id' => $parent_id, 'product_name' => $parent_id));
        }
        $query = $this->db->limit(10)
                ->where('status != -1')
                ->order_by('sort', 'DESC')
                ->get();
        foreach ($query->result_array() AS $arr) {
            $data[] = $arr;
        }
        return $data;
    }

    /**
     * 判断条件下的设置是否存在
     * @param array $where
     * @return bool
     */
    public function isExist($where) {
        $query = $this->db->get_where("category", $where);
        $row = $query->row_array();
        return empty($row) ? FALSE : TRUE;
    }

    public function recommend($data) {
        return $this->db->where("product_id=" . $data['product_id'])->update("product", $data);
    }

    //批量查询商品
    public function getProducts($where) {
        return $this->db->select('product_id,product_name')->from("product")->where($where)->get()->result_array();
    }

    /*
      根据店铺id获取商品列表
      祖   2018/8/6
     */

    public function getProByStoId($page = 1, $limit = 20, $where = [], $store_id = 0) {
        //通过storeid 在关联表store_product表中查出peoduct_id,再通过product_id在product表中查出商品信息
        $this->db
                ->from('store as s')
                ->join('store_product as sp', 'sp.store_id=s.store_id')
                ->join('product as p', 'p.product_id=sp.product_id')
                ->select('p.*')
                ->where(array('s.store_id' => $store_id));
        //加入筛选条件
        if (!empty($where['product_sn'])) {
            $this->db->like('p.product_sn', $where['product_sn'], 'both');
        }
        if (!empty($where['product_name'])) {
            $this->db->like('p.product_name', $where['product_name'], 'both');
        }
        if (!empty($where['status'])) {
            $this->db->where('p.status=' . $where['status']);
        } else {
            $this->db->where('p.status != -1');
        }
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $res = $this->db
                ->order_by('p.product_id', 'DESC')
                ->limit($limit, ($page - 1) * $limit)
                ->get()
                ->result_array();
        return array("count" => $rownum, "result" => $res);
    }

    /*
     * 商品回收站
     * 祖    2018/8/14
     */

    public function getProductRecycle($page, $limit, $where) {
        $this->db->select('p.updatetime,p.product_id,p.product_name,p.store_number,p.status,p.createtime,p.images,p.price,p.recommend')->from('product p')->where('status = -1 ');
        if (!empty($where['product_name'])) {
            $this->db->like(array('product_name' => $where['product_name']));
        }
        $count_db = clone($this->db);
        $rownum = $count_db->count_all_results();
        $query = $this->db
                ->select('pd.sale_number,pd.incart_number,pd.click_number,pd.like_number')
                ->limit($limit, ($page - 1) * $limit)
                ->join('product_dynamics pd', 'pd.product_id = p.product_id', 'left')
                ->order_by('p.sort', 'DESC')
                ->get();
        return array("count" => $rownum, "result" => $query->result_array());
    }

    /*
     * 自动查询已删除商品名称
     * 祖    2018/8/14
     */

    public function autoDelProductList($product_id) {
        $data = array();
        $this->db->select('*')
                ->from('product');
        if (!empty($product_id))
            $this->db->or_like(array('product_id' => $product_id, 'product_name' => $product_id));
        $query = $this->db->limit(10)
                ->where('status', '-1')
                ->order_by('sort', 'DESC')
                ->get();
        foreach ($query->result_array() AS $arr) {
            $data[] = $arr;
        }
        return $data;
    }

    /*
     * 还原商品
     * 祖    2018/8/14
     */

    public function recoveryProduct($product_id) {
        return $this->db->where("product_id=" . $product_id)->update("product", array('status' => '2'));
    }

    public function delectProduct($product_id) {
        return $this->db->where("product_id", $product_id)->delete("product");
    }

}
