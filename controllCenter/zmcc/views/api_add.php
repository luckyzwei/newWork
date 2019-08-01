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
                        Api管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/"><i class="fa fa-dashboard"></i> 控制面板</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('api/index')?>">Api管理</a>
                        </li>
                        <li class="active">新增Api</li>
                    </ol>
                </section>
                <section class="content">
                 <!--公用提示-->
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary select-messages">
                                <div class="box-header with-border">
                                    <h3 class="box-title">新增Api</h3>
                                </div>
                                <form role="form" name="api_form" id="settingoption" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="api_name">Api名称 </label>
                                                <input type="text" class="form-control" id="api_name" name="name" placeholder="Api名称" value="<?php if(validation_errors()!="") echo set_value('name')?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="api_key">Api ID(Appid)</label>
                                                <input type="text" class="form-control" id="api_key"  name="appid" placeholder="Api ID"  value="<?php if(validation_errors()!="") echo set_value('appid')?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="api_key">Api密钥（Appsecret）</label>
                                                <input type="text" class="form-control" id="api_key"  name="key" placeholder="Api密钥"  value="<?php if(validation_errors()!="") echo set_value('key')?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="api_group">是否启用</label>
                                                <input type="checkbox" class="form-control" id="api_group" name="status" 
                                                       placeholder="关键字只能是英文字母和下划线组成" value="<?php if(set_value('status')) echo "checked"?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('Api/index');?>'">返回</button>
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
            $("#api_type").change(function () {
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