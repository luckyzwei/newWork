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
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        Api管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class="active">Api管理</li>
                    </ol>
                </section>
                <section class="content">
                    <!--公用提示-->
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary select-messages">
                        <div class="box-header with-border">
                            <form action="<?php echo site_url('Api/index') ?>" method="post">
                            <h3 class="box-title">Api列表</h3>
                            <div class="has-feedback">
                                <input type="text" class="form-control input-md" placeholder="搜索Api" name="keyword" value="<?php echo $keyword?>" id="keyword">
                                <span class="glyphicon glyphicon-search form-control-feedback" id="searchSetting"></span>
                            </div>
                            <button stype="submit" class="btn btn-success" style="position: absolute;">搜索</button>
                            </form>
                            <div class="box-tools">
                                <div class="has-feedback">
                                    <a href="<?php echo site_url('Api/apiAdd') ?>">
                                        <button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button>
                                    </a>
                                    <button type="button" class="btn btn-default btn-sm" id='delete'><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive select-messages">
                                <form action="<?php echo site_url('Api/apiDelete') ?>" method="post"  id="form-Api">
                                <table class="table table-hover table-striped" style="text-align:center;">
                                    <thead>
                                    <td style="width: 1%"><input type="checkbox" class="btn btn-default btn-sm checkbox-toggle"></td>
                                    <td class="user-nickname">Api名称</td>
                                    <td class="user-nickname">Api Id(Appid)</td>
                                    <td class="user-nickname">密钥(Appsecret)</td>
                                    <td class="user-ip">状态</td>
                                    <td class="user-opreate">更新时间</td>
                                    <td class="user-opreate">操作</td>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($api_list as $api) { ?>
                                            <tr>
                                                <td><input type="checkbox" name="setting_id[]" value="<?php echo $api['api_id'] ?>"></td>
                                                <td class="user-name"><?php echo $api['name'] ?></td>
                                                <td class="user-ip"><?php echo $api['appid'] ?></td>
                                                <td class="user-ip"><?php echo $api['key'] ?></td>
                                                <td class="user-name"><?php echo $api['status']?"启用":"未启用" ?></td>
                                                <td class="user-nickname"><?php echo date("Y-m-d H:i:s",$api['updatetime']) ?></td>
                                                <td class="user-opreate">
                                                    <a class="btn btn-primary btn-xs" href="<?php echo site_url(array("api","apiUpdate",$api['api_id']))?>">编辑</a>
                                                    <span></span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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
        <script src="dist/js/bootbox.js"></script>
        <script src="./dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
           $("#searchSetting").click(function(){
               var keyword=$("#keyword").val();
               location.href="/index.php/setting/settinglist/keyword/"+keyword
           });



            $("#delete").click(function () {
                var str = "";
                var selecteds = "";
                $("input[name='setting_id[]']:checkbox").each(function () {
                    if (true == $(this).is(':checked')) {
                        str += $(this).val() + ",";
                    }
                });
                if (str.substr(str.length - 1) == ',') {
                    selecteds = str.substr(0, str.length - 1);
                }
                if (selecteds == "") {
                    bootbox.alert({
                        message: "请您选择要删除的API",
                        backdrop: true
                    });
                } else {
                    bootbox.confirm({
                        title: "删除优惠劵",
                        message: "您确定要删除API的iD为:" + selecteds + '?',
                        buttons: {
                            cancel: {
                                label: '<i class="fa fa-times"></i> 取消'
                            },
                            confirm: {
                                label: '<i class="fa fa-check"></i> 确认',
                            }
                        },
                        callback: function (result) {
                            console.log('result=' + result);
                            if (result) {//确认
                                $('#form-Api').submit();
                            }
                        }
                    });
                }
            })
        </script>
        <!--./文件管理器-->
    </body>

</html>