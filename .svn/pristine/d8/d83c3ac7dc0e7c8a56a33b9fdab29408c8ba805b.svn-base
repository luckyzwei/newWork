<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
                        配置项管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class="active">配置项列表</li>
                    </ol>
                </section>
                <section class="content">
                    <!--公用提示-->
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <form action="<?php echo site_url('Setting/settingList') ?>" method="post">
                                <h3 class="box-title">配置项列表</h3>
                                <div class="has-feedback">
                                    <input type="text" class="form-control input-md" placeholder="搜索配置项" name="keyword" id="keyword">
                                    <span class="glyphicon glyphicon-search form-control-feedback" id="searchSetting"></span>
                                </div>
                                <button stype="submit" class="btn btn-success" style="position: absolute;">搜索</button>
                            </form>
                            <div class="box-tools">
                                <div class="has-feedback">
                                    <a href="<?php echo site_url('setting/addsetting') ?>">
                                        <button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button>
                                    </a>
                                    <button type="button" class="btn btn-default btn-sm" id='delete'><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive select-messages">
                                    <form action="<?php echo site_url('Setting/deleteSetting') ?>" method="post"  id="form-Setting">
                                        <table class="table table-hover table-striped" style="text-align:left;">
                                            <thead>

                                            <td style="width: 1%"><input type="checkbox" class="btn btn-default btn-sm checkbox-toggle"></td>
                                            <td class="user-name" style="width:200px">配置项名称</td>
                                            <td class="user-nickname"  style="width:200px">参数名</td>
                                            <td class="user-nickname"  style="width:150px">分组名称</td>
                                            <td class="user-ip" style="width:300px">当前参数值</td>
                                            <td class="user-opreate" style="width:120px">顺序</td>
                                            <td class="user-nickname">配置说明</td>
                                            <td class="user-opreate" style="width:120px">操作</td>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($settings as $setting) { ?>
                                                    <tr>
                                                        <td><input type="checkbox" name="setting_id[]" value="<?php echo $setting['setting_id'] ?>"></td>
                                                        <td class="user-name"><?php echo $setting['setting_name'] ?></td>
                                                        <td class="user-ip"><?php echo $setting['setting_key'] ?></td>
                                                        <td class="user-name"><?php echo $setting['setting_group'] ?></td>
                                                        <td class="user-nickname"><?php echo $setting['setting_value'] ?></td>
                                                        <td width="5%">
                                                            <input type="number" value="<?php echo $setting['sort_order'] ?>" class=" form-control small" data-id="<?php echo $setting['setting_id'] ?>" onblur="javascript:changeSort(this)">
                                                        </td>
                                                        <td class="user-ip"><?php echo $setting['description'] ?></td>
                                                        <td class="user-opreate">
                                                            <a class="btn btn-primary btn-xs" href="<?php echo site_url(array("setting", "editsetting", $setting['setting_id'])) ?>">编辑</a>
                                                            <span></span>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                            <div class="box-footer no-padding">
                                <div class="mailbox-controls">
                                    <div class="pull-right">
                                        <nav aria-label="Page navigation">
                                            <?php echo $linklist ?>
                                        </nav>
                                    </div>
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
                                                            function changeSort(obj) {
                                                                var sort = $(obj).val();
                                                                var setting_id = $(obj).attr("data-id");
                                                                $.post("<?php echo site_url('setting/editSort') ?>", {"sort_order": sort, "setting_id": setting_id},
                                                                        function (res) {}
                                                                ), "json"

                                                            }


                                                            $("#searchSetting").click(function () {
                                                                var keyword = $("#keyword").val();
                                                                location.href = "/index.php/setting/settinglist/keyword/" + keyword
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
                                                                        message: "请您选择要删除的配置项",
                                                                        backdrop: true
                                                                    });
                                                                } else {
                                                                    bootbox.confirm({
                                                                        title: "删除配置项",
                                                                        message: "您确定要删除配置项ID：" + selecteds + ' ?',
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
                                                                                $('#form-Setting').submit();
                                                                            }
                                                                        }
                                                                    });
                                                                }
                                                            })
        </script>
    </body>
</html>