<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title ?></title>
        <base href = '<?php echo base_url() . "zmcc/views/" ?>'/>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="plugins/ionicons-2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="./dist/css/ZMShop.min.css">
        <link rel="stylesheet" href="./plugins/iCheck/flat/blue.css">
        <link rel="stylesheet" href="./plugins/summernote/summernote.css">
        <link rel="stylesheet" href="./dist/css/skins/all-skins.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <?php include 'public_header.php' ?>
            </header>
            <aside class="main-sidebar">
                <?php include 'public_left.php' ?>
            </aside>

            <div class="content-wrapper" style="min-height: 848px;">
                <section class="content-header">
                    <h1>
                        配置项管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/"><i class="fa fa-dashboard"></i> 控制面板</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('setting/settinglist')?>">配置项管理</a>
                        </li>
                        <li class="active">修改配置项</li>
                    </ol>
                </section>
                <section class="content">
                     <!--公用提示-->
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary select-messages">
                                <div class="box-header with-border">
                                    <h3 class="box-title">修改配置项</h3>
                                </div>
                                <form role="form" name="settingoption_form" id="settingoption" action="" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="setting_name">配置项名称 </label>
                                                <input type="text" class="form-control" id="setting_name" name="setting_name" placeholder="配置项名称" value="<?php echo $setting['setting_name']?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="setting_key">配置项关键字</label>
                                                <input type="text" class="form-control" id="setting_key"  name="setting_key" placeholder="关键字只能是英文字母和下划线组成"  value="<?php echo  $setting['setting_key']?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="setting_group">群组名称</label>
                                                <input type="text" class="form-control" id="setting_group" name="setting_group" placeholder="关键字只能是英文字母和下划线组成" value="<?php echo $setting['setting_group']?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="setting_type">字段类型</label>
                                                <select name="setting_type" id="setting_type"  class="form-control">
                                                    <option value="text" <?php if($setting['setting_type']=='text') echo "selected"?>>单行文本</option>
                                                    <option value="textarea" <?php if($setting['setting_type']=='textarea') echo "selected"?>>多行文本</option>
                                                    <option value="file" <?php if($setting['setting_type']=='file') echo "selected"?>>文件域</option>
                                                    <option value="checkbox"  <?php if($setting['setting_type']=='checkbox') echo "selected"?>>复选框</option>
                                                    <option value="radio" <?php if($setting['setting_type']=='radio') echo "selected"?>>单选按钮</option>
                                                    <option value="select" <?php if($setting['setting_type']=='select') echo "selected"?>>下拉菜单</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" style='<?php if(!in_array($setting['setting_type'],array("checkbox","radio","select"))){?>display: none<?php }?>' id="content">
                                            <div class="col-md-8">
                                                <label for="setting_group">设定取值</label>
                                                <textarea name="setting_content"  class="form-control" cols="60" rows="5"><?php echo $setting['setting_content']?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group" id="value">
                                            <div class="col-md-8">
                                                <label for="setting_value">初始值</label>
                                                <input name="setting_value"  class="form-control" value='<?php echo $setting["setting_value"];?>'/>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="is_show">在系统配置中显示</label>
                                                <input type="checkbox" class="form-control"  id="is_show" name="is_show" value="1" <?php if($setting['is_show']) echo "checked"?>>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="sort_order">显示排序</label>
                                                <input type="text" class="form-control" id="sort_order" name="sort_order" value="<?php echo $setting['sort_order']?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="sort_order">配置说明</label>
                                                <input type="text" class="form-control" id="sort_order" name="description" value="<?php echo $setting['description']?>">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="box-footer">
                                        <input type="hidden" value="<?php echo $setting['setting_id']?>" name="setting_id">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                         <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('setting/settingList')?>'">返回</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                <?php include 'public_footer.php' ?>
            </footer>
            <aside class="control-sidebar control-sidebar-dark">
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs"></ul>
                <div class="tab-content">
                    <div class="tab-pane" id="control-sidebar-home-tab"></div>
                </div>
            </aside>
            <div class="control-sidebar-bg"></div>
        </div>
        <script src="./plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="./bootstrap/js/bootstrap.min.js"></script>
        <script src="./dist/js/app.min.js"></script>
        <script src="./plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="./plugins/iCheck/icheck.min.js"></script>
        <script src="./dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
        <script src="./dist/js/common.js"></script>
        <script src="./dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
            $("#setting_type").change(function () {
                if ($(this).val() == "checkbox" || $(this).val() == "radio"||$(this).val() == "select") {
                    $("#content").show();
                }
                else {
                    $("#content").hide();
                }
            });
           
        </script>
    </body>
</html>