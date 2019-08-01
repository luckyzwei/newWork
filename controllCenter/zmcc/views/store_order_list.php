<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title ?></title>
        <base href = '<?php echo base_url() . "zmcc/views/" ?>'/>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="plugins/ionicons-2.0.1/css/ionicons.min.css">
        <link href="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
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
                <?php include 'public_header.php' ?>
            </header>
            <aside class="main-sidebar">
                <?php include 'public_left.php' ?>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                     店铺订单统计
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class="active">店铺列表</li>
                    </ol>
                </section>
                <section class="content">
                   <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">店铺订单统计</h3>

                        </div>
                        <div class="box-body no-padding">
                            <div class="mailbox-controls">
                                <div class="row" style="margin: 0;">
                                    <form action="<?php echo site_url('Store/storeOrderList/'.$store_id) ?>" method="post">
                                        <div class="input-group date" style="width: 200px;float:left;">
                                            <input type="text" name="createtime" value="<?php echo $createtime;?>" placeholder="开始日期" data-date-format="YYYY-MM-DD" class="form-control" />
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                        <div class="input-group date" style="width: 200px;float:left;">
                                            <input type="text" name="stoptime" value="<?php echo $stoptime;?>" placeholder="结束日期" data-date-format="YYYY-MM-DD" class="form-control" />
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                            </span>
                                            
                                        </div>
                                        <button stype="submit" class="btn btn-success">查询</button>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive select-messages">
                                <form action="<?php echo site_url('Store') ?>" method="post" id="form-product">
                                    <table class="table table-hover table-striped">
                                        <thead>

                                        <td>订单编号</td>
                                        <td >会员昵称</td>
                                        <td >支付金额</td>
                                        <td >订单状态</td>
                                        <td >下单时间</td>
                                        <td >订单类型</td>
                                        <td >操作</td>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                foreach ($list as $item){
                                                    ?>
                                                    <tr>
 
                                                        <td ><?php echo $item['order_sn']; ?></td>
                                                        <td ><?php echo $item['nickname']; ?></td>
                                                        <td >￥<?php echo $item['pay_money']; ?></td>
                                                        <td ><?php echo $statusname[$item['status']]; ?></td>
                                                        <td ><?php echo date("Y-m-d H:m", $item['createtime']); ?></td>
                                                        <td ><?php echo $ordertypename[$item['order_type']]; ?></td>
                                                        <td >
                                                            <a  href="<?php echo site_url('Order/editOrderInfo/' . $item['order_id']); ?>"  class="btn btn-primary btn-xs"><i class="fa fa-eye">订单详情</i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                              }
                                            ?>
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
        <script src="plugins/bootstrap-datetimepicker/moment.js"></script>
        <script src="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="dist/js/bootbox.js"></script>
        <script src="dist/js/common.js"></script>
        <script>

            $('.date').datetimepicker({
                                                pickTime: false
                                            });
        </script>
    </body>

</html>