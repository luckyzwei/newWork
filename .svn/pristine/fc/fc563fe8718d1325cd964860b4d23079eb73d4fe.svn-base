<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * @author wangxiangayx
 */
class Image extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function copy_image() {
        $image_url = $this->input->get_post('image_url');
        $img = @file_get_contents($image_url);
        if ($img) {
            $url_array = parse_url($image_url);
            $path = $url_array["path"];
            //处理URL
            $path_array = array_filter(explode("/", $path));
            $image_name = array_pop($path_array);

            //处理根目录
            $root_dir = "./uploads";
            $folder = array_shift($path_array);
            if ($folder != "upload") {
                $root_dir .= "/" . $folder;
                if (!is_dir($root_dir)){
                    mkdir($root_dir);
                    chmod($root_dir, 0777);
                }
            }

            //循环创建目录
            while (!empty($path_array)) {
                $folder = array_shift($path_array);
                $root_dir .= "/" . $folder;
                if (!is_dir($root_dir)){
                    mkdir($root_dir);
                    chmod($root_dir, 0777);
                }
            }

            //保存文件
            $root_dir .= "/" . $image_name;
            file_put_contents($root_dir, $img);
            $image_url = $this->systemsetting->get("api_url").substr($root_dir, 1);
        }
        $error_code =1;
        if(is_file($image_url)){
            $error_code=0;
        }
        $this->output->set_content_type("json/application")->set_output(json_encode(array('error_code' => 0,'image_url'=>$image_url)));
    }

}
