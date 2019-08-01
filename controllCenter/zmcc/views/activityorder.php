<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?></title>
        <base href = "<?php echo base_url(); ?>zmcc/views/"/>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="plugins/ionicons-2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="dist/css/ZMShop.min.css">
        <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
        <link rel="stylesheet" href="dist/css/skins/all-skins.min.css">

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
                <?php include 'public_header.php'; ?>
            </header>
            <aside class="main-sidebar">
                <?php include 'public_left.php'; ?>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        报名列表管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 控制面板</a>
                        </li>
                        <li href="<?php echo site_url('Activity') ?>">活动管理</li>
                        <li class="active">报名列表</li>
                    </ol>
                </section>
                <section class="content">   
                    <!--公用提示-->
                    <?php include 'public_middletips.php'; ?>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">报名列表</h3>

                            <div class="box-tools">
                                <div class="has-feedback">
                                    <button type="button" class="btn btn-danger" id="delete"><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>   
                        <div class="mailbox-controls">
                            <div class="row" style="margin: 0;">
                                <form action="<?php echo site_url('ActivityOrder/index') ?>" method="post">
                                    <div class="form-group col-md-3">
                                        <label>活动名称</label>
                                        <input type="text" class="form-control" name="activity_title"  value="<?php echo $activity_title ?>" placeholder="活动名称"/>
                                        <input type="hidden" name="activity_id" value="<?php echo $activity_id ?>" >
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>参与状态</label>
                                        <select name="status" class="form-control select2" >
                                            <option <?php
                                            if ($status == 0) {
                                                echo 'selected="selected"';
                                            }
                                            ?> value="0">*</option>
                                            <option <?php
                                            if ($status == 1) {
                                                echo 'selected="selected"';
                                            }
                                            ?> value="1">已支付</option>
                                            <option <?php
                                            if ($status == 2) {
                                                echo 'selected="selected"';
                                            }
                                            ?> value="2">已签到</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 pull-right">
                                        <label>提交筛选</label>
                                        <input type="submit" class="btn btn-block btn-primary btn-sm"  value="筛选" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <form method="post" action="<?php echo site_url('ActivityOrder/deleteActivityOrder'); ?>" id="deleteforms">  
                            <div class="box-body no-padding">
                                <div class="table-responsive select-messages">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                        <td><input type="checkbox" class="checkbox-toggle"></td>
                                        <td>报名编号</td>
                                        <td>活动标题</td>
                                        <td>报名人</td>
                                        <td>电话</td>
                                        <td>报名时间</td>
                                        <td>状态</td>
                                        <td>操作</td>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($acticvityorderlist as $activity): ?> 
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="selected[]" value="<?php echo $activity['activity_order_id']; ?>">
                                                    </td>
                                                    <td><?php echo $activity['activity_order_id']; ?></td>
                                                    <td><?php echo $activity['activity_title']; ?></td>
                                                    <td><?php echo $activity['name']; ?></td>
                                                    <td><?php echo $activity['telephone']; ?></td> 
                                                    <td><?php echo date('Y-m-d H:i', $activity['add_time']); ?></td>
                                                    <td class="status"><?php
                                                        if ($activity['status'] == 0) {
                                                            echo "未支付";
                                                        } elseif ($activity['status'] == 1) {
                                                            echo "已支付";
                                                        } elseif ($activity['status'] == 2) {
                                                            echo "已签到";
                                                        }
                                                        ?></td>
                                                    <td>
                                                        <?php if ($activity['status'] > 0) { ?> <a  href="javascript:void(0)"  class="btn btn-primary btn-xs" name="recommend" 
                                                                data="<?php echo $activity['activity_order_id'] ?>" recommend="<?php echo $activity['status'] == 2 ? 1 : 2; ?>">
                                                                    <?php echo $activity['status'] == 2 ? "取消签到" : "签到" ?>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="box-footer no-padding">
                        <div class="pull-right">
                            <nav aria-label="Page navigation">
                                <?php echo $links; ?>
                            </nav>
                        </div>
                    </div>           
                </section>
            </div>
            <footer class="main-footer">
                <?php include 'public_footer.php'; ?>
            </footer>
            <aside class="control-sidebar control-sidebar-dark">
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs"></ul>
                <div class="tab-content">
                    <div class="tab-pane" id="control-sidebar-home-tab"></div>
                </div>
            </aside>
            <div class="control-sidebar-bg"></div>
        </div>
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="plugins/iCheck/icheck.min.js"></script>
        <script src="dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/common.js"></script>
        <script src="dist/js/bootbox.js"></script>
        <script>
            $("[name='recommend']").click(function () {
                var that = this;
                $.post('<?php echo site_url("ActivityOrder/recommend") ?>', {"activity_order_id": $(that).attr("data"), "status": $(that).attr("recommend")}, function (res) {
                    if (!res.error_code) {
                        if ($(that).attr("recommend") == "1") {
                            $(that).text("签到");
                            $(that).attr("recommend", "2");
                            $(that).parent().prev().text('已支付')
                        } else {
                            $(that).text("取消签到");
                            $(that).attr("recommend", "1");
                            $(that).parent().prev().text('已签到')
                        }
                    }
                }, 'json'
                        )
            })
            $("#delete").click(function () {
                var str = "";
                var selecteds = "";
                $("input[name='selected[]']:checkbox").each(function () {
                    if (true == $(this).is(':checked')) {
                        str += $(this).val() + ",";
                    }
                });
                if (str.substr(str.length - 1) == ',') {
                    selecteds = str.substr(0, str.length - 1);
                }

                if (selecteds == "") {
                    bootbox.alert({
                        message: "请您选择要删除活动",
                        backdrop: true
                    });
                } else {
                    bootbox.confirm({
                        title: "删除活动",
                        message: "您确定要删除编号为:【" + selecteds + '】的活动？',
                        buttons: {
                            cancel: {
                                label: '<i class="fa fa-times"></i> 取消'
                            },
                            confirm: {
                                label: '<i class="fa fa-check"></i> 确认',
                            }
                        },
                        callback: function (result) {
                            if (result) {
                                $('#deleteforms').submit();
                            }
                        }
                    });
                }
            })
             $('input[name=\'activity_title\']').autocomplete({
                    'source': function (request, response) {
                        $.ajax({
                            url: '<?php echo site_url('Activity/autoActivity'); ?>' + '?activity_title=' + encodeURIComponent(request),
                            dataType: 'json',
                            success: function (json) {
                                response($.map(json, function (item) {
                                    return {
                                        label: item['activity_title'],
                                        value: item['activity_id']
                                    }
                                }));
                            },
                        });
                    },
                    'select': function (item) {
                        $('input[name=\'activity_title\']').val(item['label']);
                        $('input[name=\'activity_id\']').val(item['value']);
                    }
                });
        </script>


        <!--筛选-->
    </body>

</html>