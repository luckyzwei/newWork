<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 管理员管理控制器
 * @package	ZMshop
 * @author	    qidazhong@hnzhimo.com
 * @copyright	2017 河南知默网络科技有限公司
 * @link	    http://www.hnzhimo.com
 * @since	    Version 1.0.0
 */
class Welcome extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model("agentModel");
        $this->load->model("orderModel");
        $this->load->model("productModel");
        $this->load->model("userModel");
        $this->load->model("userCollectModel");
        $this->load->model("userLikeModel");
        $this->load->model("commentModel");
        $this->load->model("supplierModel");
    }

    /**
     * 管理后台统计信息
     */
    public function index() {
       
        
//        //获取小程序的统计数据
//       $config = array(
//            'appid' => $this->zmsetting->get("wechat_fun_id"),
//            'appsecret' => $this->zmsetting->get("wechat_fun_secret")
//        );
//        $this->load->library('Wechat_applet_api',$config);
//        $token = $this->wechat_applet_api->checkAuth();
//        
//       $data =array(
//            "begin_date"=>date('Ymd',mktime(0, 0, 0, date("m"), date("d")-1,   date("Y"))),
//            "end_date"=>date('Ymd',mktime(0, 0, 0, date("m"), date("d")-1,   date("Y"))),
//           "yes_visit"=>0
//        );
//        $res = $this->wechat_applet_api->getDailySummary($token, $data);
//       if(!empty($res['list'])) {
//           $data['yes_visit']=$res['list'][0]['visit_total'];
//       }
        //代理商数据 供货商数据
        $agent_info=$this->agentModel->getList();
        $supplier_info=$this->supplierModel->getList();
        $data['agent_num']=$agent_info['count'];
        $data['supplier_num']=$supplier_info['count'];
        //订单总金额统计
        $endtime=time();
        $data['allordermoney']=$this->orderModel->statisticsOrderAmount(0,$endtime);
        //当月订单统计
        $starttime=strtotime(date("Y-m-01"));
        $data['monthordermoney']=$this->orderModel->statisticsOrderAmount($starttime,$endtime);
        //今日订单金额
        $starttime=strtotime(date("Y-m-d"));
        $data['todayordermoney']=$this->orderModel->statisticsOrderAmount($starttime,$endtime);
        
        //总会员数量
        $user_info=$this->userModel->getList();
        $data['user_num']=$user_info['count'];
        //今日新增数量
        $todayuserinfo=$this->userModel->getList(array("createtime"=>$starttime));
        $data['today_user_number']=$todayuserinfo['count'];
        
        //最新评论
        $comments=$this->commentModel->getList(array(),1,10);
        $data['comments']=$comments['result'];
        //最新订单
        $orders=$this->orderModel->getOrderList(1,10);
        foreach ($orders['result'] as  $value) {
            $value['status_name']=$this->statusname[$value['status']];
            $data['orders'][]=$value;
        }
        
        //收藏商品数量和top10
        $collect=$this->userCollectModel->getCollectProduct();

        $data['collects']=$collect;
        //喜欢的数量和top10
        $like=$this->userLikeModel->getLikeProduct();
        $data['likes']=$like;
         $data['title']=$this->zmsetting->getTitle($this->getModuleInfo());
         //统计图表使用的数据
         $start_time=date("Y-m-d",strtotime("-30 days"));
         $end_time=date("Y-m-d");
         $this->load->model("staticsModel");
         $statics_result=$this->staticsModel->get_statics($start_time,$end_time);
         $sresult=array();
         foreach($statics_result as $statics){
             $sresult['timestr'][]=$statics['datatime'];
             $sresult['visited'][]=$statics['visited'];
             $sresult['orders'][]=$statics['orders'];
             $sresult['newuser'][]=$statics['newuser'];
             $sresult['totalfee'][]=$statics['totalfee'];
             $sresult['payfee'][]=$statics['payfee'];
             $sresult['pays'][]=$statics['pays'];
             $sresult['visiter'][]=$statics['visiter'];
         }
         $data['statics']=json_encode($sresult,JSON_NUMERIC_CHECK);
         
         
        $this->load->view('index',$data);
    }
    private $statusname = array(
        '-1' => "删除",
        '0' => "未支付",
        '1' => "已支付",
        '2' => "已发货",
        '3' => "部分发货",
        '4' => "部分退货",
        '5' => "已收货",
        '6' => '已完成',
        '7' => '售后中',
        '8'=>"已退款"
    );
    
           /**
     * 没有操作权限
     */
    public function no_power(){
        $data['title'] = "系统提示信息";
        $this->session->error = "权限错误，请联系管理员分配权限";
        $this->session->mark_as_flash("error");
        $this->load->view("no_power",$data);
    }
    static function getModuleInfo(){
        return array(
            "moduleName" => "控制面板",
            "controller" => "Welcome",
            "author" => "qidazhong@hnzhimo.com",
            "icon" => "",
            "operation" => array(
                "index" => "仪表盘",
            )
        );
    
    }

}