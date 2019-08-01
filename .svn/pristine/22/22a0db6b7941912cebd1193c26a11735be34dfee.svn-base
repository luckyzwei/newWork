<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 权限拦截器：主要实现权限的控制拦截和记录操作日志
 *
 * @author qidazhong@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 */
class Interceptor {

    private $CI;

    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->helper("url");
        $this->requestInterceptor();
    }

    /**
     * 系统请求拦截器用于写日志和权限验证
     */
    private function requestInterceptor() {
        $controller = $this->CI->uri->segment(1) ? $this->CI->uri->segment(1) : "Welcome";
        $method = $this->CI->uri->segment(2) ? $this->CI->uri->segment(2) : "index";
        require_once APPPATH . 'controllers/' . ucfirst($controller) . ".php";
        $moduleInfo = $controller::getModuleInfo();
        if (empty($moduleInfo)) {
            return true;
        }
        $this->CI->session->leftMenu = $this->getLeftMenu();
        if ($this->checkPower($moduleInfo)) {
            $this->systemLog($controller, $method, $moduleInfo['moduleName'], 1);
        } else {
            $this->systemLog($controller, $method, $moduleInfo['moduleName'], 0);
            if (!empty($this->CI->session->adminInfo['admin_id'])) {
                if ($this->CI->input->is_ajax_request()) {
                    //返回json的错误信息
                    echo json_encode(array("result" => 0, "msg" => "no power"));
                } else {
                    redirect(site_url("welcome/no_power"));
                }
            } else {
                redirect(site_url("AdminLogin/login"));
            }
        }
    }

    /**
     * 检验操作权限
     * @param  $moduleInfo 模块定义的信息
     * @return bool
     */
    private function checkPower($moduleInfo) {
        $controller = $this->CI->uri->segment(1);
        $method = $this->CI->uri->segment(2) ? $this->CI->uri->segment(2) : "index";
        $adminPower = $this->getRolePower();
        if (is_string($adminPower) && $adminPower == "ALL_POWER") {
            return true;
        }
        //判断该方法是否需要权限控制
        $indexKeys = array();
        if (!empty($moduleInfo['operation'])) {
            $indexKeys = array_keys($moduleInfo['operation']);
        }
        //如果方法不需要控制权限
        if (in_array("-" . $method, $indexKeys)) {
            return true;
        }

        //如果方法不在模块控制列表中，登陆后即可访问,一般会出现在ajax请求中
        if (!in_array("-" . $method, $indexKeys) && !in_array($method, $indexKeys) && !empty($this->CI->session->adminInfo['admin_id'])) {
            return true;
        } else {
//判断用户是否具有该操作权限
            $requestString = $controller . "/" . $method;
            if (in_array($requestString, $adminPower)) {
                return true;
            } 
        }
        return false;
    }

    /**
     * 获取后台操作菜单
     * @return 数据保存在session['sysMenu']
     */
    private function getLeftMenu() {
        $menus = $this->CI->config->item('systemMenu');
        $adminPower = $this->getRolePower();
        if (!empty($adminPower) && $adminPower !== "ALL_POWER") {
            foreach ($menus as $mkey => $menu) {
                if (!empty($menu['items'])) {
                    foreach ($menu['items'] as $key => $item) {

                        if (!empty($item['controller'])) {

                            $method = "index"; //默认为index方法

                            if (!empty($item['method'])) {
                                $method = $item['method'];
                            }
                            $uri = $item['controller'] . "/" . $method;

                            if (!in_array($uri, $adminPower)) {
                                unset($menus[$mkey]['items'][$key]);
                            }
                        } else {
                            unset($menus[$mkey]['items'][$key]);
                        }
                    }
                    //如果没有item权限直接剔除分组权限
                    if (empty($menus[$mkey]['items'])) {
                        unset($menus[$mkey]);
                    }
                } else {
                    if (!empty($menu['controller'])) {
                        $method = "index";
                        if (!empty($menu['method'])) {
                            $method = $menu['method'];
                        }
                        $uri = $menu['controller'] . "/" . $method;
                        if (!in_array($uri, $adminPower)) {
                            unset($menus[$mkey]);
                        }
                    }
                }
            }
        } //die;
        return $menus;
    }

    /**
     * 获取角色的操作权限
     * @return array 角色操作权限数组或者超级管理员时返回字符串ALL_POWER
     */
    private function getRolePower() {
        // var_dump($this->CI->session->adminInfo['role_id']);die;
        $powerArray = array();
        //系统创建者拥有所有权限
        if ($this->CI->session->adminInfo['name'] == "root") {
            return "ALL_POWER";
        }
        $this->CI->load->model("RoleModel");
        if ($this->CI->session->adminInfo['role_id']) {
            $roleInfo = $this->CI->RoleModel->getRoleById($this->CI->session->adminInfo['role_id']);
            $powerArray = explode(",", $roleInfo['role_power']);
        }
        return $powerArray;
    }

    /**
     * 记录系统操作日志
     * @param string $controller 控制器名称
     * @param string $method 访问的方法名
     * @param string $module_name 模块名称
     * @param int $type 1正常日志，0越权访问
     * @return boole 系统日志保存是否成功
     */
    private function systemLog($controller, $method, $module_name, $type = 1) {

        $opData = array_merge($this->CI->input->post(), $this->CI->input->get());
        if (empty($opData)) {
            return;
        }
        $log_content = serialize($opData);
        $logdata = array(
            "controller" => $controller,
            "method" => $method,
            "module_name" => $module_name,
            "admin_id" => $this->CI->session->adminInfo['admin_id'],
            "log_type" => $type,
            "log_content" => $log_content,
            "createtime" => time(),
        );
        $this->CI->load->model("SystemLogModel");
        if ($this->CI->SystemLogModel->writeLog($logdata)) {
            return true;
        }
        return false;
    }

}
