<?php

/**
 * 商品类型管理
 * @author qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 */
class CommodityTyp extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("commodityTypModel");
    }

    public function index() {
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $cdytyps = $this->commodityTypModel->getCommodityTyps();
        $data['cmdytps'] = $cdytyps;

        $this->load->view("commodityTyp", $data);
    }

    /**
     * 添加商品类型
     */
    public function commodityTypAdd() {

        if ($this->input->method() == "post") {
            $inputdata = elements(array("cdytyp_name", "attribute_name", "specification_name",
                "specification_options", "remark", "cdytyp_id"), $this->input->post());

            $cleardata = $this->clear_data($inputdata);
            $checkResult = $this->check_data($cleardata);

            if ($checkResult === true) {
                $formatdata = $this->format_data($cleardata);
                if ($this->commodityTypModel->addCommodityTyp($formatdata)) {
                    $this->session->success = "类型添加成功";
                    $this->session->mark_as_flash("success");
                    $result = array("error" => 0, "msg" => "类型添加成功");
                }
            } else {
                $result = array("error" => 1, "msg" => $checkResult);
            }
            $this->output->set_content_type("json/application")->set_output(json_encode($result));
        } else {
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $this->load->view("commodityTyp_add", $data);
        }
    }

    public function commodityTypEdit() {

        if ($this->input->method() == "post") {
            $inputdata = elements(array("cdytyp_name", "attribute_name", "specification_name",
                "specification_options", "remark", "cdytyp_id"), $this->input->post());

            $cleardata = $this->clear_data($inputdata);
            $checkResult = $this->check_data($cleardata);

            if ($checkResult === true) {
                $formatdata = $this->format_data($cleardata);
                $where = array("cdytyp_id" => $inputdata['cdytyp_id']);
                if ($this->commodityTypModel->updateCommodityTyp($formatdata, $where)) {
                    $this->session->success = "类型修改成功";
                    $this->session->mark_as_flash("success");
                    $result = array("error" => 0, "msg" => "类型修改成功");
                }
            } else {
                $result = array("error" => 1, "msg" => $checkResult);
            }
            $this->output->set_content_type("json/application")->set_output(json_encode($result));
        } else {
            $cdytyp_id = $this->input->get("cdytyp_id");
            $cdytyp = $this->commodityTypModel->getCommodityTypById($cdytyp_id);
            //反序列化并逆向属性和规格数组
            if (!empty($cdytyp['attribute'])) {
                $cdytyp['attribute'] = array_reverse(unserialize($cdytyp['attribute']));
            } else {
                $cdytyp['attribute'] = array();
            }
            if (!empty($cdytyp['specification'])) {
                $cdytyp['specification'] = array_reverse(unserialize($cdytyp['specification']));
            } else {
                $cdytyp['specification'] = array();
            }

            $data['cdytyp'] = $cdytyp;
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $this->load->view("commodityTyp_edit", $data);
        }
    }

    public function commodityTypDelete() {
        $selected = $this->input->post('selected');
        if (!empty($selected) && is_array($this->input->post('selected'))) {

            if ($this->commodityTypModel->deleteCommodityTyp($this->input->post('selected'))) {
                $this->session->success = "删除成功!";
                $this->session->mark_as_flash("success");
            } else {
                $this->session->error = "删除失败!";
                $this->session->mark_as_flash("error");
            }
        }
        redirect(site_url('commodityTyp/index'));
    }
    

    /**
     * 格式化数据
     */
    public function format_data($data) {
        if (is_array($data['specification_name']) && is_array($data['specification_options'])) {
            foreach ($data['specification_name'] as $key => $specification) {
                $special['special_name'] = $specification;
                $special['specification'] = $data['specification_options'][$key];
                $temparray[] = $special;
            }
        }
        if (!empty($temparray)) {
            $fdata['specification'] = serialize(array_reverse($temparray)); //把数组倒置
        } else {
            $fdata['specification'] = "";
        }
        if (!empty($data['attribute_name'])) {
            $fdata['attribute'] = serialize(array_reverse($data['attribute_name'])); //把数组倒置
        } else {
            $fdata['attribute'] = "";
        }
        $fdata['cdytyp_name'] = $data['cdytyp_name'];
        $fdata['remark'] = $data['remark'];
        return $fdata;
    }

    /**
     * 清洗数据:去掉空的字符串或者或者数组字符元素
     * @param array $inputdata
     * @return type
     */
    private function clear_data($inputdata) {
        $inputdata['cdytyp_name'] = trim($inputdata['cdytyp_name']);
        $inputdata['remark'] = trim($inputdata['remark']);
        if (!empty($inputdata['attribute_name'])) {
            foreach ($inputdata['attribute_name'] as &$attr_name) {
                $attr_name = trim($attr_name);
            }
        }

        if (!empty($inputdata['specification_name'])) {
            foreach ($inputdata['specification_name'] as &$specifiaction_name) {
                $specifiaction_name = trim($specifiaction_name);
            }
        }

        if (!empty($inputdata['specification_options'])) {
            foreach ($inputdata['specification_options'] as &$options) {
                $temp = explode("\r\n", $options);
                foreach ($temp as $key => &$t) {
                    $t = trim($t);
                    if ($t == "") {
                        unset($temp[$key]);
                    }
                }
                $options = $temp;
            }
        }

        return $inputdata;
    }

    /**
     * 检查数据
     * @param type $inputdata
     * @return boolean|string
     */
    private function check_data($inputdata) {
        $error = "";
        if (mb_strlen($inputdata['cdytyp_name']) > 8 || mb_strlen($inputdata['cdytyp_name']) < 2) {
            $error .= "<p>商品名称最长8个汉字，最少2个汉字</p>";
        }
        if (!empty($inputdata['cdytyp_name'])) {
            $where = array("cdytyp_name" => $inputdata['cdytyp_name']);
            if ($inputdata['cdytyp_id']) {
                $where['cdytyp_id!='] = $inputdata['cdytyp_id'];
            }
            $nameHas = $this->commodityTypModel->getCommodityTyp($where);
            if (!empty($nameHas)) {
                $error .= "<p>类型名字已经存在请更改</p>";
            }
        }
        if (!empty($inputdata['attribute_name'])) {
            foreach ($inputdata['attribute_name'] as $attr_name) {
                if ($attr_name == "") {
                    $error .= "<p>请把属性数据填写完整</p>";
                    break;
                }
            }
        }
        if (empty($inputdata['attribute_name']) && empty($inputdata['specification_options'])) {
            $error .= "<p>类型的属性和规格必须填写一项</p>";
        }

        if (!empty($inputdata['specification_name'])) {
            foreach ($inputdata['specification_name'] as $special_name) {
                if ($special_name == "") {
                    $error .= "<p>请把规格数据填写完整</p>";
                    break;
                }
            }
        }

        if (!empty($inputdata['specification_options'])) {
            foreach ($inputdata['specification_options'] as $special_options) {
                $special_options = str_replace("\r\n", "", $special_options);
                if ($special_options == "") {
                    $error .= "<p>请把规格数据填写完整</p>";
                    break;
                }
            }
        }

        if (empty($error)) {
            return true;
        }
        return $error;
    }

    static function getModuleInfo() {
        return array(
            "moduleName" => "商品类型管理",
            "controller" => "CommodityTyp",
            "author" => "qidazhong@hnzhimo.com",
            "icon" => "",
            "operation" => array(
                "index" => "商品类型列表",
                "commodityTypAdd" => "添加商品类型",
                "commodityTypEdit" => "修改商品类型",
                "commodityTypDelete" => "删除商品类型"
            )
        );
    }

}
