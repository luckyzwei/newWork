<?php

/**
 *
 * 该辅助函数主要是为了解决在显示图片缩略图时重复书写代码而编写
 * 基本思想还是借助了CI框架的图片处理函数
 * 
 * @package	ZMshop
 * @author	wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link	http://www.hnzhimo.com
 * @since	Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------

if (!function_exists('imagesHandle')) {

    /**
     * 处理函数
     * 受CI框架图片定义只会在同目录生成缩略图
     *
     * @param	string	文件路径
     * @param	int	生成缩略图的宽
     * @param	int	生成缩略图的高
     * @return	string 同文件夹的缩略图命名文件 
     */
    function imagesHandle($path, $width = 100, $height = 100) {
        $CI = & get_instance();
        $ext = strrchr($path, '.');
        $name = ($ext === FALSE) ? $path : substr($path, 0, -strlen($ext));
        $newname = $name . $width . "x" . $height . $ext;
        if (!file_exists($newname)) {
            $config = array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $CI->config->item("DIR_IMAGE") . 'image' . $path;
            $config['create_thumb'] = TRUE;
            $config['thumb_marker'] = $width . "x" . $height;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = $width;
            $config['height'] = $height;
            $CI->load->library('image_lib', $config);
            $CI->image_lib->resize();
        }
        return $newname;
    }

}
