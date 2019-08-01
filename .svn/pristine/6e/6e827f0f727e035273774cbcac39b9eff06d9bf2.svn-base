<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once(BASEPATH . 'libraries/lib/Wechat_common.php');

const APPLET_DATACUBE_URL = 'https://api.weixin.qq.com/datacube/';

/**
 * 小程序服务端API of Wechat_applet_api
 *
 * @author wangxiangshuai
 */
class CI_Wechat_applet_api extends CI_Wechat_common {

    public function __construct($options) {
        parent::__construct($options);
    }
    /**
     * 获取用户访问小程序数据概况
     * @param type $access_token
     * @param type $data
     * @return type
     */
    public function getDailySummary($access_token, $data){
        $post_url = APPLET_DATACUBE_URL . "getweanalysisappiddailysummarytrend?access_token=" . $access_token;
        $output = $this->http_post($post_url, json_encode($data));
        $res = json_decode($output, true);
        return $res;
    }
    /**
     * 访问页面。目前只提供按 page_visit_pv 排序的 top200。
     * @param type $access_token
     * @param type $data
     * @return type
     */
    public function getVisitPage($access_token, $data){
        $post_url = APPLET_DATACUBE_URL . "getweanalysisappidvisitpage?access_token=" . $access_token;
        $output = $this->http_post($post_url, json_encode($data));
        $res = json_decode($output, true);
        return $res;
    }
    /**
     * 获取用户小程序访问分布数据
     * @param type $access_token
     * @param type $data
     * @return type
     */
    public function getVisitDistribution($access_token, $data){
        $post_url = APPLET_DATACUBE_URL . "getweanalysisappidvisitpage?access_token=" . $access_token;
        $output = $this->http_post($post_url, json_encode($data));
        $res = json_decode($output, true);
        return $res;
        
    }
     /**
     * 获取小程序新增或活跃用户的画像分布数据。时间范围支持昨天、最近7天、最近30天。其中，新增用户数为时间范围内首次访问小程序的去重用户数，活跃用户数为时间范围内访问过小程序的去重用户数。
     * @param type $access_token
     * @param type $data
     * @return type
     */
    public function getUserPortrait($access_token, $data){
        $post_url = APPLET_DATACUBE_URL . "getweanalysisappiduserportrait?access_token=" . $access_token;
        $output = $this->http_post($post_url, json_encode($data));
        $res = json_decode($output, true);
        return $res;
        
    }
//获取 访问留存 历史

    /**
     * 获取用户访问小程序月留存
     * @param type $access_token
     * @param type $data
     * @return type
     */
    public function getMonthlyRetain($access_token, $data) {
        $post_url = APPLET_DATACUBE_URL . "getweanalysisappidmonthlyretaininfo?access_token=" . $access_token;
        $output = $this->http_post($post_url, json_encode($data));
        $res = json_decode($output, true);
        return $res;
    }

    /**
     * 获取用户访问小程序周留存
     * @param type $access_token
     * @param type $data
     * @return type
     */
    public function getWeeklyRetain($access_token, $data) {
        $post_url = APPLET_DATACUBE_URL . "getweanalysisappidweeklyretaininfo?access_token=" . $access_token;
        $output = $this->http_post($post_url, json_encode($data));
        $res = json_decode($output, true);
        return $res;
    }

    /**
     * 获取用户访问小程序日留存
     * @param type $access_token
     * @param type $data
     * @return type
     */
    public function getDailyRetain($access_token, $data) {
        $post_url = APPLET_DATACUBE_URL . "getweanalysisappiddailyretaininfo?access_token=" . $access_token;
        $output = $this->http_post($post_url, json_encode($data));
        $res = json_decode($output, true);
        return $res;
    }

//获取 访问趋势 当前

    /**
     * 获取用户访问小程序数据月趋势
     * @param type $access_token
     * @param type $data
     * @return type
     */
    public function getMonthlyVisitTrend($access_token, $data) {
        $post_url = APPLET_DATACUBE_URL . "getweanalysisappidmonthlyvisittrend?access_token=" . $access_token;
        $output = $this->http_post($post_url, json_encode($data));
        $res = json_decode($output, true);
        return $res;
    }

    /**
     * 获取用户访问小程序数据周趋势
     * @param type $access_token
     * @param type $data
     * @return type
     */
    public function getWeeklyVisitTrend($access_token, $data) {
        $post_url = APPLET_DATACUBE_URL . "getweanalysisappidweeklyvisittrend?access_token=" . $access_token;
        $output = $this->http_post($post_url, json_encode($data));
        $res = json_decode($output, true);
        return $res;
    }

    /**
     * 获取用户访问小程序日趋势
     * @param type $access_token
     * @param type $data
     * @return type
     */
    public function getDailyVisitTrend($access_token, $data) {
        $post_url = APPLET_DATACUBE_URL . "getweanalysisappiddailyvisittrend?access_token=" . $access_token;
        $output = $this->http_post($post_url, json_encode($data));
        $res = json_decode($output, true);
        return $res;
    }
   

}
