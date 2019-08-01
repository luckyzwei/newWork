<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 图片文件显示处理控制器
 * 
 * @package ZMshop
 * @author  wangxiangshuai@hnzhimo.com
 * @copyright (c) 2017, 河南知默网络科技有限公司
 * @link    http://www.hnzhimo.com
 * @since   Version 1.0.0
 */
class FileManager extends CI_Controller {

    /**
     * 类必须实现函数用于权限控制设置
     * 
     * @return  array
     */
    public static function getModuleInfo() {
        return array(
            "moduleName" => "图片管理器",
            "controller" => "FileManager",
            "author" => "wangxiangshuai@hnzhimo.com",
            "operation" => array(
                "-index" => "查询列表",
                "upload" => "上传图片",
                "folder" => "创建新的文件夹",
                "delete" => "删除文件或目录"
            )
        );
    }

    public function index() {
        $page = $this->input->get('per_page');
        $page = $page ? $page : 1;
        $server = $this->zmsetting->get("img_url") . $this->zmsetting->get("file_upload_dir");
        $dirimage = "." . $this->zmsetting->get("file_upload_dir");

//如果服务器没有新目录的话需要创建
        if (!is_dir($dirimage)) {
            mkdir($dirimage);
        }

        $cache_path = '/../cache/';
        $cache_dir = './upload/cache/'; //$dirimage . $cache_path;
        if (!is_dir($cache_dir)) {
            mkdir($cache_dir);
        }

//检查需要查看的目录所在的本地地址 并将操作目录写入cookeie
        $directoryget = $this->input->get('directory');
        if (!empty($directoryget)) {
            $directory = str_replace('//', '/', rtrim($dirimage . '/' . str_replace('*', '', $directoryget), '/'));
            $cache_dir = str_replace('//', '/', rtrim($cache_dir . str_replace('*', '', $directoryget), '/'));
            setcookie('imagemanager_last_open_folder', $directoryget, time() + 60 * 60 * 24 * 30 * 24, '/', $this->input->server['HTTP_HOST']);
        } else {
            $directory = $dirimage;
        }
//当在本目录搜索时 需要连接 此名称
        $filter_nameget = $this->input->get('filter_name');
        if (!empty($filter_nameget)) {
            $filter_name = str_replace('//', '/', rtrim(str_replace('*', '', $filter_nameget), '/'));
        } else {
            $filter_name = null;
        }

        $directories = array();
        $files = array();

        $data['images'] = array();

        if ($dirimage) {
// 获取文件夹
            $directories = glob($directory . '/' . $filter_name . '*', GLOB_ONLYDIR);
            if (!$directories) {
                $directories = array();
            }
// 获取图片
            $files = glob($directory . "/" . $filter_name . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
            if (!$files) {
                $files = array();
            }
        }
// 组装数组
        foreach ($directories as $key => $dir) {
            if ($dir == "cache") {
                unset($directories[$key]);
            }
        }
        $images = array_merge($directories, $files);
//获取总条数用于分页
        $image_total = count($images);
// 分页的拆分数据
        $images = array_splice($images, ($page - 1) * 16, 16);

        foreach ($images as $image) {
            $name = str_split(basename($image), 14);
            if (is_dir($image)) {
                $url = '';
                $target = $this->input->get('target');
                if (!empty($target)) {
                    $url .= '&target=' . $target;
                }
                $thumb = $this->input->get('thumb');
                if (!empty($thumb)) {
                    $url .= '&thumb=' . $this->input->get('thumb');
                }
                $data['images'][] = array(
                    'thumb' => '',
                    'name' => implode('', $name),
                    'type' => 'directory',
                    'path' => mb_substr($image, mb_strlen($dirimage), mb_strlen($image)),
                    'href' => site_url("FileManager/index?directory=" . urlencode(mb_substr($image, mb_strlen($dirimage))) . $url)
                );
            } elseif (is_file($image)) {
                $cache_img = $this->zmsetting->get("thumb_width") . "_" . $this->zmsetting->get("thumb_height") . "_" . implode('', $name);
                $thumb_image = $cache_dir . '/' . $cache_img;
                if (!file_exists($thumb_image)) {
                    $config['source_image'] = $image;
                    $config['create_thumb'] = TRUE;
                    $config['thumb_marker'] = '';
                    $config['width'] = $this->zmsetting->get("thumb_width");
                    $config['height'] = $this->zmsetting->get("thumb_height");
                    $config['new_image'] = $thumb_image;
                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    $this->image_lib->clear();
                }

                $data['images'][] = array(
                    'thumb' => $this->zmsetting->get("img_url") . $cache_dir . '/' . $this->zmsetting->get("thumb_width") . "_" . $this->zmsetting->get("thumb_height") . "_" . implode('', $name), //生成缩略图带Url                                                路径
                    'name' => implode('', $name),
                    'type' => 'image',
                    'path' => mb_substr($image, mb_strlen($dirimage), mb_strlen($image)),
                    'href' => $server . mb_substr($image, mb_strlen($dirimage), mb_strlen($image))
                );
            }
        }

        $directory = $this->input->get('directory');
        if (!empty($directory)) {
            $data['directory'] = urlencode($directory);
        } else {
            $data['directory'] = '';
        }
        $filter_name = $this->input->get('filter_name');
        if (!empty($filter_name)) {
            $data['filter_name'] = $filter_name;
        } else {
            $data['filter_name'] = '';
        }

// Return the target ID for the file manager to set the value
        $target = $this->input->get('target');
        if (!empty($target)) {
            $data['target'] = $target;
        } else {
            $data['target'] = '';
        }

// Return the thumbnail for the file manager to show a thumbnail
        $thumb = $this->input->get('thumb');
        if (!empty($thumb)) {
            $data['thumb'] = $thumb;
        } else {
            $data['thumb'] = '';
        }

// Parent
        $url = '';

        $directory = $this->input->get('directory');
        if (!empty($directory)) {
            $pos = strrpos($directory, '/');

            if ($pos) {
                $url .= '&directory=' . urlencode(substr($directory, 0, $pos));
            }
        }

        $target = $this->input->get('target');
        if (!empty($target)) {
            $url .= '&target=' . $target;
        }

        $thumb = $this->input->get('thumb');
        if (!empty($thumb)) {
            $url .= '&thumb=' . $thumb;
        }

        $data['parent'] = site_url("FileManager/index?" . $url); //$this->url->link('common/filemanager', 'token=' . $this->session->data['token'] . $url, true);
// Refresh
        $url = '';

        $directory = $this->input->get('directory');
        if (!empty($directory)) {
            $url .= '&directory=' . urlencode($directory);
        }

        $target = $this->input->get('target');
        if (!empty($target)) {
            $url .= '&target=' . $target;
        }

        $thumb = $this->input->get('thumb');
        if (!empty($thumb)) {
            $url .= '&thumb=' . $thumb;
        }

        $data['refresh'] = site_url("FileManager/index?" . $url); //$this->url->link('common/filemanager', 'token=' . $this->session->data['token'] . $url, true);

        $url = '';

        $directory = $this->input->get('directory');
        if (!empty($directory)) {
            $url .= '&directory=' . urlencode(html_entity_decode($directory, ENT_QUOTES, 'UTF-8'));
        }

        $filter_name = $this->input->get('filter_name');
        if (!empty($filter_name)) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($filter_name, ENT_QUOTES, 'UTF-8'));
        }

        $target = $this->input->get('target');
        if (!empty($target)) {
            $url .= '&target=' . $target;
        }

        $thumb = $this->input->get('thumb');
        if (!empty($thumb)) {
            $url .= '&thumb=' . $thumb;
        }

        $this->load->library("pagination");
        $config['base_url'] = site_url('FileManager/index'); //当前分页地址
        $config['total_rows'] = $image_total;
        $config['per_page'] = 16;    //每页显示的条数
        $this->pagination->initialize($config);

        $data['linklist'] = $this->pagination->create_links();
        $this->output->set_output($this->load->view('public_filemanager', $data)->output->final_output);
    }

    public function upload() {
        $json = array();
// 预先定义好 访问地址 和 本地路径
        $server = $this->zmsetting->get("img_url");
        $dirimage = "." . $this->zmsetting->get("file_upload_dir");
        $cache_dir = './upload/cache/';
// Make sure we have the correct directory
        $directory = $this->input->get('directory');
        if (!empty($directory)) {
            $directory = str_replace('//', '/', rtrim($dirimage . '/' . $directory, '/'));
            $cache_dir = str_replace('//', '/', rtrim($cache_dir . str_replace('*', '', $directory), '/'));
        } else {
            $directory = $dirimage;
        }
// Check its a directory
        if (!is_dir($dirimage)) {
            $json['error'] = '包含要上传文件的目录不存在！';
        }

        if (!$json) {
// Check if multiple files are uploaded or just one
            $files = array();
            if (!empty($_FILES['file']['name']) && is_array($_FILES['file']['name'])) {
                foreach (array_keys($_FILES['file']['name']) as $key) {
                    $files[] = array(
                        'name' => $_FILES['file']['name'][$key],
                        'type' => $_FILES['file']['type'][$key],
                        'tmp_name' => $_FILES['file']['tmp_name'][$key],
                        'error' => $_FILES['file']['error'][$key],
                        'size' => $_FILES['file']['size'][$key]
                    );
                }
            }
            foreach ($files as $file) {
                if (is_file($file['tmp_name'])) {
// Sanitize the filename
                    $filename = basename(html_entity_decode($file['name'], ENT_QUOTES, 'UTF-8'));

// Validate the filename length
                    if ((mb_strlen($filename) < 3) || (mb_strlen($filename) > 255)) {
                        $json['error'] = "警告: 文件夹名称必须介于3到255字符之间！";
                    }

// Allowed file mime types
                    $allowed = array(
                        'image/jpeg',
                        'image/pjpeg',
                        'image/png',
                        'image/x-png',
                        'image/gif'
                    );
                    if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $filename)) {
                        $json['error'] = '名称不能含有中文和特殊字符串！';
                    }

                    if (!in_array($file['type'], $allowed)) {
                        $json['error'] = '无效文件类型！';
                    }

// Return any upload error
                    if ($file['error'] != UPLOAD_ERR_OK) {
                        $json['error'] = '文件上传错误，错误码：' . $file['error'];
                    }

                    if (intval($file['size']) > 4096000) {
                        $json['error'] = '警告: 不正确的文件大小！图片文件大小不能大于 4M , 图片宽与高均不能大于7000px';
                    }

                    if (!!empty($json['error'])) {
                        list($width_orig, $height_orig, $image_type) = getimagesize($file['tmp_name']);

                        if ((intval($width_orig) > 7000) || (intval($height_orig) > 7000)) {
                            $json['error'] = '警告: 不正确的文件大小！图片文件大小不能大于 4M , 图片宽与高均不能大于7000px';
                        }
                    }
                } else {
                    $json['error'] = '警告: 未知原因，无法上传文件！';
                }
                if (file_exists($directory . '/' . $filename)) {
                    $filename = rand(100, 999) . "_" . $filename;
                }
                if (!$json) {
                    move_uploaded_file($file['tmp_name'], $directory . '/' . $filename);

                    $cache_img = $this->zmsetting->get("thumb_width") . "_" . $this->zmsetting->get("thumb_height") . "_" . $filename;
                    $thumb_image = $cache_dir . '/' . $cache_img;
                    if (is_file($thumb_image))
                        unlink($thumb_image);
                    $config['source_image'] = $directory . '/' . $filename;
                    $config['create_thumb'] = TRUE;
                    $config['thumb_marker'] = '';
                    $config['width'] = $this->zmsetting->get("thumb_width");
                    $config['height'] = $this->zmsetting->get("thumb_height");
                    $config['new_image'] = $thumb_image;
                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    $this->image_lib->clear();
                }
            }
        }

        if (!$json) {
            $json['success'] = '成功: 文件已经上传！';
        }

        $this->output->set_output(json_encode($json));
    }

    public function folder() {

        $json = array();
        $server = $this->zmsetting->get("img_url");

        $dirimage = "." . $this->zmsetting->get("file_upload_dir");
        $cache_dir_root = "./upload/cache";
//检查需要查看的目录所在的本地地址 并将操作目录写入cookeie
        $directory = $this->input->get('directory');
        if (!empty($directory)) {
            $cache_dir = str_replace('//', '/', rtrim($cache_dir_root . '/' . $directory, '/'));
            $directory = str_replace('//', '/', rtrim($dirimage . '/' . $directory, '/'));
        } else {
            $directory = $dirimage;
            $cache_dir = $cache_dir_root;
        }
        if (empty($json['error'])) {
// Sanitize the folder name
            $folder = basename(html_entity_decode($this->input->post('folder'), ENT_QUOTES, 'UTF-8'));
// Validate the filename length
            if ((mb_strlen($folder) < 3) || (mb_strlen($folder) > 128)) {
                $json['error'] = "警告: 文件夹名称必须介于3到255字符之间！";
            }
// Check if directory already exists or not
            if (is_dir($directory . '/' . $folder)) {
                $json['error'] = "警告: 已经存在同名文件夹或文件！";
            }
            if (!preg_match("/^[A-Za-z0-9]+$/", $folder)) {
                $json['error'] = '名称不能含有中文和特殊字符串！';
            }
        }

        if (!!empty($json['error'])) {
            mkdir($directory . '/' . $folder, 0777);
            chmod($directory . '/' . $folder, 0777);
//创建缓存目录
            mkdir($cache_dir . '/' . $folder, 0777);
            chmod($cache_dir . '/' . $folder, 0777);

            @touch($directory . '/' . $folder . '/' . 'index.html');

            $json['success'] = "成功: 目录已经创建！";
        }
        $this->output->set_output(json_encode($json));
    }

    public function delete() {
        $json = array();
        $server = $this->zmsetting->get("img_url");
        $dirimage = "." . $this->zmsetting->get("file_upload_dir");
        $path = $this->input->post('path');
        if (!empty($path)) {
            $paths = $path;
        } else {
            $paths = array();
        }
// Loop through each path to run validations
        foreach ($paths as $path) {
// Check path exsists
            if ($path == $dirimage || substr(str_replace('\\', '/', realpath($dirimage . $path)), 0, strlen(realpath($dirimage))) != str_replace('\\', '/', realpath($dirimage))) {
                $json['error'] = '警告: 不能删除此目录！';
                break;
            }
        }

        if (!$json) {
// Loop through each path
            foreach ($paths as $path) {
                $path = str_replace('//', '/', rtrim($dirimage . $path, '/'));
// If path is just a file delete it
                if (is_file($path)) {
                    unlink($path);
// If path is a directory beging deleting each file and sub folder
                } elseif (is_dir($path)) {
                    $files = array();

// Make path into an array
                    $path = array($path . '*');

// While the path array is still populated keep looping through
                    while (count($path) != 0) {
                        $next = array_shift($path);

                        foreach (glob($next) as $file) {
// If directory add to path array
                            if (is_dir($file)) {
                                $path[] = $file . '/*';
                            }

// Add the file to the files to be deleted array
                            $files[] = $file;
                        }
                    }

// Reverse sort the file array
                    rsort($files);

                    foreach ($files as $file) {
// If file just delete
                        if (is_file($file)) {
                            unlink($file);

// If directory use the remove directory function
                        } elseif (is_dir($file)) {
                            rmdir($file);
                        }
                    }
                }
            }

            $json['success'] = '成功: 文件或目录已经被删除！';
        }

        $this->output->set_output(json_encode($json));
    }

}
