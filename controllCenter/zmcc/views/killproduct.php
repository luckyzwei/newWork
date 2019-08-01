<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
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
        <link rel="stylesheet" href="plugins/select2/select2.min.css">
        <link rel="stylesheet" href="dist/css/skins/all-skins.min.css">
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
                        助力砍价管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class="active">助力砍价管理</li>
                    </ol>
                </section>
                <section class="content">  
                    <!--提示框 -->
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">助力砍价列表</h3>
                            <div class="box-tools">
                                <div class="has-feedback">
                                    <a href="<?php echo site_url('KillProduct/addKillProduct') ?>">
                                        <button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button>
                                    </a>
                                    <button type="button" class="btn btn-default btn-sm" id="delete"><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive select-messages">
                                <form action="<?php echo site_url('KillProduct/deleteKillProduct') ?>" method="post"  id="form-GroupProduct">
                                    <table class="table table-hover table-striped" style="text-align:center;">
                                        <thead>
                                        <td style="width: 1%"><input type="checkbox" class="btn btn-default btn-sm checkbox-toggle"></td>
                                        <td style="width: 5%">ID</td>
                                        <td style="width: 15%">助力名称</td>
                                        <td style="width: 10%">商品名称</td>
                                        <td style="width: 10%">购买上限</td>
                                        <td style="width: 15%">最低价</td>
                                        <td style="width: 10%">最低价人次</td>
                                        <td style="width: 10%">砍价方式</td>
                                        <td style="width: 10%">开始时间</td>
                                        <td style="width: 10%">结束时间</td>
                                        <td style="width: 10%">有效期</td>
                                        <td style="width: 5%">操作</td>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($killproductlist as $item): ?>                             
                                                <tr>
                                                    <td><input type="checkbox" name="selected[]" value="<?php echo $item['kill_product_id'] ?>"/></td>
                                                    <td><?php echo $item['kill_product_id'] ?></td>
                                                    <td><?php echo $item['kill_product_name'] ?></td>
                                                    <td><?php echo $item['product_name'] ?></td>
                                                    <td><?php echo $item['kill_product_store'] . ' 个' ?></td>
                                                    <td><?php echo $item['kill_product_min_price'] . ' 元' ?></td>
                                                    <td><?php echo $item['kill_price_number'] . ' 人' ?></td>
                                                    <td><?php  if($item['kill_price_type']==1){echo "固定金额";}else{echo "随机";}  ?></td>
                                                    <td><?php echo empty($item['kill_product_starttime']) ? "无限制" : ($item['kill_product_starttime'] > time() ? "未开始" : date('Y-m-d', $item['kill_product_starttime'])); ?></td>
                                                    <td><?php echo empty($item['kill_product_endtime']) ? "无限制" : ($item['kill_product_endtime'] < time() ? "已结束" : date('Y-m-d', $item['kill_product_endtime'])); ?></td>
                                                    <td><?php echo $item['kill_price_time'] . ' 小时' ?></td>
                                                    <td>    
                                                        <a href="<?php echo site_url('KillProduct/editKillProduct?kill_product_id=' . $item['kill_product_id']); ?>" class="btn btn-primary btn-xs">编辑</a>

                                                    </td>

                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <div class="box-footer no-padding">
                            <div class="mailbox-controls">
                                <div class="pull-right">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <?php echo $linklist; ?>
                                        </ul>
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
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="plugins/iCheck/icheck.min.js"></script>
        <script src="dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootbox.js"></script>
        <script src="dist/js/common.js"></script>
        <script type="text/javascript">

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
                        message: "请您选择要删除的砍价商品",
                        backdrop: true
                    });
                } else {
                    bootbox.confirm({
                        title: "删除砍价商品",
                        message: "您确定要删除砍价商品  iD为:" + selecteds + '?',
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
                                $('#form-GroupProduct').submit();
                            }
                        }
                    });
                }
            })

        </script>


        <!--筛选-->
    </body>

</html>