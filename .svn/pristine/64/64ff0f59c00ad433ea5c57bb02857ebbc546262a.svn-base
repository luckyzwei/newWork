<?php
/**
 * api接口模型
 * @package	Zmapi
 * @author	qidazhong@hnzhimo.com
 * @copyright	2017 河南知默科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
class ProductSpecialModel extends CI_Model {

    /**
     * 获取商品规格和属性
     * @param type $product_id
     * @return type
     */
    public function getAttrAndSpecial($product_id) {
        $query = $this->db->get_where("product_special", array("product_id" => $product_id));
        $special = $query->row_array();
        $result = array();
        if (!empty($special)) {
            if (!empty($special['attributes'])) {
                $result['attributes'] = @unserialize($special['attributes']);
            }
            if (!empty($special['special_struct'])) {
                $result['special_struct'] = @unserialize($special['special_struct']);
                $result['specifications'] = @unserialize($special['specifications']);
                foreach ($result['specifications'] as $key => &$sp) {
                    if ($sp['hidenChk'] == "1") {
                        $temp = explode("_", $sp['goods_code']);
                        $result["hidden"][] = $temp[1]; //需要隐藏的规格选项
                    }
                    //获取规格名字
                    $indexArray = explode("-", str_replace("goods_", "", $sp['goods_code']));
                    $structArray = @unserialize($result['special_struct']);
                    foreach ($indexArray as $key => $index) {
                        $sp['special_name'] = $structArray[$key]["special_name"] . ":" . $structArray[$key]['specification'][$index];
                    }
                    if ($sp['hidenChk'] == "0" && empty($result['default'])) {
                        $result['default'] = $indexArray; //默认规格索引
                    }
                }
            }
        }
        return $result;
    }

    /**
     * 获取商品指定规格的详细信息，如果没有货品编号则返回一个默认的
     * @return type
     */
    public function getSpecial($product_id, $goods_code = 0) {
        $specifications = $this->getAttrAndSpecial($product_id);
        $result = array();
        if (!empty($specifications['special_struct'])) {
            $special = unserialize($specifications['specifications']);
            if ($goods_code) {
                foreach ($special as $sp) {
                    if ($sp['goods_code'] == $goods_code) {
                        $result = $sp;
                        break;
                    }
                }
            } else {
                if (empty($result)) {
                    foreach ($special as $sp) {
                        if ($sp['hidenChk'] == "0") {
                            $result = $sp;
                            break;
                        }
                    }
                }
            }
            //根据规格索引串获取名字
            $goods_code = $result['goods_code'];
            $indexArray = explode("-", str_replace("goods_", "", $goods_code));
            $structArray = @unserialize($specifications['special_struct']);
            foreach ($indexArray as $key => $index) {
                $special_name[] = $structArray[$key]["special_name"] . ":" . $structArray[$key]['specification'][$index];
            }
            $result['special_name'] = implode("+", $special_name);
        }
        return $result;
    }

}
