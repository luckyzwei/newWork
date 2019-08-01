<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 广告管理控制器
 * @author qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 */
class Advert extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("advertModel");
        $this->load->model("RoleModel");
    }

    /**
     * 广告位列表
     * @param type $page
     */
    public function getPositionList() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $where = array();
        $data = array();
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $limit = 20;
        $offset = ($page - 1) * 20;
        $ad_position_name = $this->input->post('ad_position_name');
        $where['ad_position_name'] = $ad_position_name;
        $data['ad_position_name'] = $ad_position_name;
        $datas = $this->advertModel->getPositionList($where, $limit, $offset);
        $config['base_url'] = site_url('advert/getPositionList'); //当前分页地址
        $config['total_rows'] = $datas['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $config['cur_page'] = $page;
        $data['list'] = $datas['data'];
        $this->load->library("pagination");
        $this->pagination->initialize($config);
        $data['page_link'] = $this->pagination->create_links();
        $data['pagenum'] = $page;
        $this->load->view("ad_position_list", $data);
    }

    /**
     * 添加广告位
     */
    public function addPosition() {
        $this->load->helper(array('form', 'url'));
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $data['rolelists'] = $this->RoleModel->getRoles();
        $result = "";
        $this->load->library("form_validation");
        $this->form_validation->set_rules($this->getPositionRules());
        if ($this->input->method() == "post") {
            $insert_data = elements(array("ad_position_name", "ad_position_type", "remark"), $this->input->post());
            if ($this->form_validation->run() && $this->advertModel->addPosition($insert_data)) {
                $this->session->success = "添加广告位成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("Advert/getPositionList"));
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        $this->load->view("ad_position_add", $data);
    }

    //暂定
    public function editPosition($adpid) {
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $this->load->library("form_validation");
        $result = "";
        $this->form_validation->set_rules($this->getPositionRules());
        if ($this->input->method() == "post") {
            $update_data = elements(array(), $this->input->post());
            if ($this->form_validation->run() &&
                    $this->advertModel->editPosition($update_data, array("ad_position_id", $this->input->post("ad_position_id")))) {
                header("location:" . site_url('Advert/getPositionList?success=修改广告位成功'));
            }
            $result = "fail";
        }
        $data['result'] = $result;
        $adPosition = $this->advertModel->getPositon($adpid);
        $data['position'] = $adPosition;
        $this->load->view("ad_position_edit", $data);
    }

    public function deletePosition() {
        $selected = $this->input->post('position_id');
        if (!empty($selected) && is_array($this->input->post('position_id'))) {
            $where = implode(',', $this->input->post('position_id'));
            if ($this->advertModel->deletePosition('ad_position_id in (' . $where . ')')) {
                $this->session->success = "删除成功!";
                $this->session->mark_as_flash("success");
            } else {
                $this->session->error = "删除失败!";
                $this->session->mark_as_flash("error");
            }
        } else {

            $this->session->error = "请求有误!";
            $this->session->mark_as_flash("error");
        }
        redirect(site_url('Advert/getPositionList'));
    }

    private function getPositionRules() {
        return array(
            array(
                'field' => 'ad_position_name',
                'label' => '广告位名称',
                'rules' => 'required|min_length[2]|max_length[20]',
                "errors" => array(
                    'required' => '广告位名称必须',
                    'min_length' => '广告位名称最短需要2个汉字',
                    'max_length' => '广告位名称最长为20个汉字',
                )
            ),
            array(
                'field' => 'ad_position_type',
                'label' => '广告位类型',
                'rules' => 'required',
                "errors" => array(
                    'required' => '广告位类型',
                )
            ),
        );
    }

    public function getPositionJson($pname = "") {
        $where = array();
        if (!empty($pname)) {
            $where['ad_position_name'] = urldecode($pname);
        }
        $result = $this->advertModel->getPositionList($where);
        $datas = $result['data'];
        $this->output->set_content_type("json/application")->set_output(json_encode($datas));
    }

    /**
     * 广告列表
     * @param type $page
     */
    public function getAdvertList($ad_position_id = 0) {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $data = array();
        $where = array();
        if (!empty($error)) {
            $data['error'] = $error;
        }
        $success = $this->input->get('success');
        if (!empty($success)) {
            $data['success'] = $success;
        }
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $position_id = $this->input->get_post("position_id");
        if (!empty($ad_position_id)) {
            $position_id = $ad_position_id;
        }
        if (!empty($position_id)) {
            $where = "ad_position.ad_position_id=" . $position_id;
        }
        $limit = 20;
        $offset = ($page - 1) * 20;
        $datas = $this->advertModel->getAdvertList($where, $limit, $offset);
        $config['base_url'] = site_url('advert/getAdvertList'); //当前分页地址
        $config['total_rows'] = $datas['count'];
        $config['per_page'] = $limit;    //每页显示的条数
        $config['cur_page'] = $page;
        $data['list'] = $datas['data'];
        $this->load->library("pagination");
        $this->pagination->initialize($config);
        $data['page_link'] = $this->pagination->create_links();
        $data['type_name'] = [
            '1' => '文字',
            '2' => '图片',
            '3' => '视频'
        ];
        $data['pagenum'] = $page;
        $this->load->view("ad_list", $data);
    }

    /**
     * 添加广告
     */
    public function addAdvert($result = "") {
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $data['rolelists'] = $this->RoleModel->getRoles();
        $this->load->library("form_validation");
        $data['result'] = "fail";
        if ($this->input->method() == "post") {
            $this->form_validation->set_rules($this->getAdvertRules());
            $insert_data = elements(array("ad_name", "ad_type", "position_id", "ad_url_type", "ad_url_param","ad_url", "ad_status", 'sort')
                    , $this->input->post());

            if ($this->form_validation->run()) {
                if ($insert_data['ad_type'] == '1') {
                    $insert_data['ad_source'] = $this->input->post('content');
                } elseif ($insert_data['ad_type'] == '2') {
                    $insert_data['ad_source'] = $this->input->post('image');
                } elseif ($insert_data['ad_type'] == '3') {
                    $insert_data['ad_source'] = $this->input->post('video_url');
                }
                $adurl_head = "/pages/" . $this->input->post('ad_url_type') . "/" . $this->input->post('ad_url_type');
                switch ($this->input->post('ad_url_type')) {
                    case "productList":
                        $insert_data['ad_url'] = $adurl_head . "?category_id=" . $this->input->post('ad_url_param');
                        break;
                    case "goodsdetail":
                        $insert_data['ad_url'] = $adurl_head . "?product_id=" . $this->input->post('ad_url_param');
                        break;
                    default:
                        $insert_data['ad_url'] = $adurl_head;
                        break;
                }
                if ($this->advertModel->addAdvert($insert_data)) {
                    $this->session->success = "广告添加修改成功";
                    $this->session->mark_as_flash("success");
                    redirect(site_url("Advert/getAdvertList"));
                }
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        $this->load->view("ad_add", $data);
    }

    /**
     * 上传文件资源
     */
    public function uploadSource() {
        $config['upload_path'] = './upload/image/advert/';
        $config['file_name'] = "ad_" . time() . mt_rand(1000, 9999);
        $config['allowed_types'] = 'gif|jpg|png|avi';
//        $config['max_size'] = 100 * 1024;
        $config['max_size'] = '0';
        $this->load->library('upload', $config);
        $error = array();
        if (!$this->upload->do_upload('source')) {
            $error = $this->upload->display_errors();
        } else {
            $data = $this->upload->data();
        }
        if (!empty($error)) {
            $this->form_validation->set_message("checkSource", $error);
            return false;
        }
        return $data;
    }

    /**
     * 广告数据验证规则
     * @return array
     */
    private function getAdvertRules() {
        $rules = array(
            array(
                'field' => 'ad_name',
                'label' => '广告位名称',
                'rules' => 'required|min_length[2]|max_length[20]',
                "errors" => array(
                    'required' => '广告名称必须',
                    'min_length' => '广告名称最短需要2个汉字',
                    'max_length' => '广告名称最长为20个汉字',
                )
            ),
            array(
                'field' => 'position_id',
                'label' => '广告位',
                'rules' => 'required',
                "errors" => array(
                    'required' => '请选择广告位',
                )
            ),
//            array(
//                'field' => 'source',
//                'label' => '广告资源',
//                'rules' => 'callback_checkSource',
//                "errors" => array(
//                    'required' => '广告资源必须上传',
//                )
//            ),
            array(
                'field' => 'ad_type',
                'label' => '广告类型',
                'rules' => 'required',
                "errors" => array(
                    'required' => '广告类型必填',
                )
            ),
        );
        return $rules;
    }

    public function checkSource($f) {
        $ad_id = $this->input->post("ad_id");
        $ad_type = $this->input->post("ad_type");
        $check = true;
        if ($this->input->post("ad_id")) {
            //查询是否有广告资源
            $ad = $this->advertModel->getAdvert(array("ad_id" => $ad_id));
            if (empty($ad['ad_source']) && $ad_type == 2 && empty($f)) {
                $check = FALSE;
            }
        } else {
            if ($ad_type == 2 && empty($f)) {
                $check = FALSE;
            }
        }
        $this->form_validation->set_message('checkSource', '请上传广告资源');
        return $check;
    }

    /**
     * 修改广告信息
     * @param type $ad_id
     * @param string $result
     */
    public function editAdvert($ad_id, $result = "") {
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
        $data['rolelists'] = $this->RoleModel->getRoles();
        $this->load->library("form_validation");
        if ($this->input->method() == "post") {
            $this->form_validation->set_rules($this->getAdvertRules());
            $insert_data = elements(array("ad_name", "ad_type", "position_id","ad_url_type", "ad_url_param","ad_url","ad_status", "sort")
                    , $this->input->post());
            if ($this->form_validation->run()) {
                if ($insert_data['ad_type'] == '1') {
                    $insert_data['ad_source'] = $this->input->post('content');
                } elseif ($insert_data['ad_type'] == '2') {
                    $insert_data['ad_source'] = $this->input->post('image');
                } elseif ($insert_data['ad_type'] == '3') {
                    $insert_data['ad_source'] = $this->input->post('video_url');
                }
                 $adurl_head = "/pages/" . $this->input->post('ad_url_type') . "/" . $this->input->post('ad_url_type');
                switch ($this->input->post('ad_url_type')) {
                    case "productList":
                        $insert_data['ad_url'] = $adurl_head . "?category_id=" . $this->input->post('ad_url_param');
                        break;
                    case "goodsdetail":
                        $insert_data['ad_url'] = $adurl_head . "?product_id=" . $this->input->post('ad_url_param');
                        break;
                    default:
                        $insert_data['ad_url'] = $adurl_head;
                        break;
                }
                if ($this->advertModel->editAdvert($insert_data, array('ad_id' => $ad_id))) {
                    $this->session->success = "编辑广告成功";
                    $this->session->mark_as_flash("success");
                    redirect(site_url("Advert/getAdvertList"));
                }
            } else {
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
            }
        }
        $ad_data = $this->advertModel->getAdvert(array("ad_id" => $ad_id));
        $data['ad'] = $ad_data;
        $this->load->view("ad_edit", $data);
    }

    /**
     * 删除广告
     * @param type $page
     */
    public function deleteAdvert() {
        $selected = $this->input->post('selected');
        if (!empty($selected) && is_array($this->input->post('selected'))) {
            $where = implode(',', $this->input->post('selected'));
            if ($this->advertModel->deleteAdvert('ad_id in (' . $where . ')')) {
                $this->session->success = "删除成功!";
                $this->session->mark_as_flash("success");
            } else {
                $this->session->error = "删除失败!";
                $this->session->mark_as_flash("error");
            }
            redirect(site_url('Advert/getAdvertList'));
        }
    }

    /*
      自动获取广告位
     */

    public function autoPosition() {
        $position = $this->input->get_post('position') ? $this->input->get_post('position') : '';
        $res = $this->advertModel->autoUposition($position);
        $this->output->set_output(json_encode($res));
    }

    static function getModuleInfo() {
        return array(
            "moduleName" => "广告管理",
            "controller" => "Advert",
            "author" => "zhandi1949",
            "icon" => "",
            "operation" => array(
                "getPositionList" => "广告位管理",
                "getAdvertList" => "广告管理",
                "addPosition" => "添加广告位",
                "editPosition" => "编辑广告位",
                "deletePosition" => "删除广告位",
                "addAdvert" => "添加广告",
                "editAdvert" => "编辑广告",
                "deleteAdvert" => "删除广告",
            )
        );
    }

}
