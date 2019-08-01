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
        <link rel="stylesheet" href="plugins/summernote/summernote.css">
        <link href="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="dist/css/ZMShop.min.css">
        <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
        <link rel="stylesheet" href="dist/js/select2/select2.min.css">
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
                        订单管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class=""><a href="<?php echo $action; ?>"> 订单管理</a></li>
                        <li class="active">订单详情</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">订单详情</h3>
                            <div class="box-tools pull-right">
                            </div>
                        </div>
                        <section class="box-body">
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-3 invoice-col">
                                    <b> 购货人</b>
                                    <address>
                                        <strong><?php echo $orderinfo['master_info']['wx_nickname'] . "(" . $orderinfo['master_info']['user_name'] . ")" ?></strong><br>
                                        订单状态：<?php echo $orderinfo['statusname'] ?><br>
                                        物流单号：<?php echo $orderinfo['shipping_code'] ?><br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 invoice-col">
                                    <b>收货人</b>
                                    <address>
                                        <strong><?php echo $orderinfo['master_info']['fullname'] ?></strong><br>
                                        <?php echo $orderinfo['master_info']['address'] ?><br>
                                        <?php echo $orderinfo['master_info']['telephone'] ?>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 invoice-col">
                                    <b>订单编号 <?php echo $orderinfo['order_sn'] ?></b><br>
                                    <b>下单时间:</b><?php echo $orderinfo['createtime'] ?><br>
                                    <b>支付金额:</b> ￥<?php echo $orderinfo['master_info']['pay_money'] ?><br>
                                    <b>支付方式:</b> <?php echo $orderinfo['master_info']['payment_name'] ?>
                                </div>

                                <!-- /.col -->
                                <div class="col-sm-3 invoice-col">
                                    <b>订单总计 <?php echo $orderinfo['master_info']['order_amount'] ?></b><br>
                                    <b>商品货值:</b><?php echo $orderinfo['master_info']['product_amount'] ?><br>
                                    <b>订单运费:</b> ￥<?php echo $orderinfo['master_info']['postage'] ?><br>
                                    <b>优惠金额:</b> <?php echo $orderinfo['master_info']['save_money'] ?>
                                </div>

                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                                <section class="box-body"  style="border: 1px solid #e1e1e1;margin-bottom: 5px">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">订单商品</h3>
                                        <div class="box-tools">
                                            <?php if ($orderinfo['shipping_code']):echo $orderinfo['shipping_code'] ?>
                                            <?php elseif ($orderinfo['status'] == 1): ?>
                                            <form id="deliverysub<?php echo $orderinfo['order_id'] ?>" method="post" action="<?php echo site_url('order/subDelivery') ?>">
                                                    <div class="input-group input-group-sm" style="width: 350px;">
                                                        <input type="text" name="shipping_code" class="form-control pull-right input-sm" placeholder="快递单号">
                                                        <input type="hidden" name="order_id" value="<?php echo $orderinfo['order_id'] ?>">
                                                        <input type="hidden" name="type" value="<?php echo $orderinfo['order_id'] ?>">
                                                        <div class="input-group-btn">
                                                            <button type="submit" class="btn btn-xs btn-success" id="partDelivery<?php echo $orderinfo['order_id'] ?>" data="<?php echo $orderinfo['order_id'] ?>"><i class="fa fa-send"> 发货</i></button>
                                                        </div>
                                                        <div class="input-group-btn">
                                                            <a href="<?php echo site_url('order/printSubOrder') ?>?order_id=<?php echo $orderinfo['order_id'] ?>" target="_blank">
                                                                <button type="button" class="btn btn-info"><i class="fa fa-print"> 打印发货单</i></button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>商品ID</th>
                                                        <th>商品名称</th>
                                                        <th>商品规格</th>
                                                        <th>购买价格</th>
                                                        <th>购买数量</th>
                                                        <th>价格小计</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($orderinfo['products'] as $product): ?>
                                                        <tr>
                                                            <td><?php echo $product['product_id'] ?></td>
                                                            <td><?php echo $product['product_name'] ?></td>
                                                            <td><?php echo $product['product_special_name'] ?></td>
                                                            <td>￥<?php echo $product['product_price'] ?></td>
                                                            <td><?php echo $product['product_number'] ?></td>
                                                            <td>￥<?php echo $product['product_price'] * $product['product_number'] ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </section>

                        </section>
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
        <script src="dist/js/common.js"></script>
        <script src="dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>

    </body>

</html>