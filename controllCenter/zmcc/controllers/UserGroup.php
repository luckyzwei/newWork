<?php
/**
  * 用户分组管理控制器
  * @package    ZMshop
  * @author     xuhuan@hnzhimo.com
  * @copyright  2017 河南知默网络科技有限公司
  * @link       http://www.hnzhimo.com
  * @since      Version 1.0.0
 */
class UserGroup extends CI_Controller{    
    static function getModuleInfo(){
	return array(
            "moduleName"=>"分组管理",
            "controller"=>"UserGroup",
            "author"=>"xuhuan@hnzhimo.com",
            "icon" => "",
            "operation"=>array(
                    "index"=>"分组列表",
                    "insertGroup"=>"添加分组",
                    "editGroup"=>"修改分组",
                    "deleteGroup"=>"删除分组"
                    )
        );
    }
    public function __construct() {
        parent::__construct();
        $this->load->model("UserGroupModel");
    }

    public function index() {
        $offset = $this->input->get('per_page');
        $offset = $offset ? $offset : 1;
        $this->load->helper('url');
        $this->load->library("pagination");
        $data = array();
        $limit = $this->input->get_post("limit") > 0 ? $this->input->get_post("limit") : 20; //每页显示条数
        $offset=intval($this->uri->segment(3)) ? intval($this->uri->segment(3)):1;
        $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());   
        $usergroups = $this->UserGroupModel->getUserGroupList($limit,$offset);
        $config['total_rows'] = $usergroups['count'];//共有多少条数据
        $config['base_url'] = site_url('UserGroup/index');//当前分页地址
        $config['per_page'] = $limit;   
        $config['cur_page'] = $offset;
        $this->pagination->initialize($config);
        $data['links'] =$this->pagination->create_links();//可以分的页数
        $data['usergroups'] = $usergroups['result'];  
        $this->load->view('usergroup',$data);

    }
    
    public function insertGroup() {
        $this->load->helper(array("form", "url"));
        $this->load->library('form_validation');
        if ($this->input->method() == "post") {
            $insertgroup = array("user_group_name","user_group_discount","integral","auto_upgrade");
            $data = elements($insertgroup, $this->input->post(),"0");
            //验证数据
            $valiRules = array(
                array(
                    'field' => 'user_group_name',
                    'label' => '分组名称必填',
                    'rules' => 'trim|required|callback_groupNameCheck',
                    "errors" => "请正确填写分组名称:分组名称必填并且不能重复"
                )
            );
            
            $this->form_validation->set_rules($valiRules);
            $this->form_validation->set_rules('integral', '升级所需积分必填', 'required|max_length[10]', array('max_length' => '等级升级积分最长为10位数'));
            $this->form_validation->set_rules('auto_upgrade', '是否自动升级必填', 'required');
            if ($this->form_validation->run() == True && $this->UserGroupModel->addUserGroup($data)) {
                $this->session->success = "新增分组成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("UserGroup/index"));
            }else{
                 $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
                 $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $this->load->view("usergroup_add", $data);
            }
        }else{
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $this->load->view("usergroup_add", $data);
        }
        
      

    }
    public function editGroup($user_group_id) {
        $this->load->helper(array("form", "url"));
        $this->load->library('form_validation');
        if ($this->input->method() == "post") {
            $editgroup = array("user_group_name","user_group_discount");
            $editgroups = elements($editgroup, $this->input->post());
            //验证数据
            $valiRules = array(
                array(
                    'field' => 'user_group_name',
                    'label' => '分组名称必填',
                    'rules' => 'trim|required|callback_groupNameCheck',
                    "errors" => "请正确填写分组名称:分组名称必填并且不能重复"
                )
            );
            $this->form_validation->set_rules($valiRules);
            $user_group_id=$this->input->post('user_group_id');
            if ($this->form_validation->run() == True && $this->UserGroupModel->editUserGroup($editgroups,array("user_group_id"=>$user_group_id))) {
                $this->session->success = "分组修改成功";
                $this->session->mark_as_flash("success");
                redirect(site_url("UserGroup/index"));

            }else{
                $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
                $data['userGroup_info']=$this->input->post();
                $this->session->error = $this->form_validation->error_string();
                $this->session->mark_as_flash("error");
                $this->load->view("usergroup_edit", $data);
            }
        }else{
            $data['title'] = $this->zmsetting->getTitle($this->getModuleInfo());
            $userGroup_info = $this->UserGroupModel->getUserGroupInfo($user_group_id);
            $data['userGroup_info']=$userGroup_info;
            $this->load->view("usergroup_edit", $data);
        }      

    }
     public function groupNameCheck($user_group_name) {
        $checkData=array("user_group_name" => $user_group_name);
        if(strtolower($this->uri->segment(2))=="editgroup"){
            $checkData['user_group_id!=']=$this->uri->segment(3);
        }  
          
        if($this->UserGroupModel->isExist($checkData)){
               $this->form_validation->set_message('groupNameCheck', '分组名称不能重复');
               return false;
        }
        return true;
    }

    public function deleteGroup(){
        $select=$this->input->post('selected');
        if(!empty($select)&&is_array($select)){       
            foreach ($select as $user_group_id) {
               $result=$this->UserGroupModel->deleteUserGroup(array('user_group_id'=>$user_group_id)); 
               if ($result) {
                $this->session->success = "删除分组成功!";
               $this->session->mark_as_flash("success");
               }else{
                $this->session->error = "删除分组失败!";
                $this->session->mark_as_flash("error");
               }           
            }   
        }   
         redirect(site_url("UserGroup/index"));
    }
    /*
     * 设置默认分组
     */
    public function setDefault(){
        $group_id = $this->input->post('group_id');
        $data = $this->UserGroupModel->setDefault($group_id);
        $this->output->set_output(json_encode($data));
    }
}
    
