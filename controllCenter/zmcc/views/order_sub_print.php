<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>打印发货单</title>
        <base href = '<?php echo base_url() . "zmcc/views/" ?>'/>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="plugins/ionicons-2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="dist/css/ZMShop.min.css">
        <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="wrapper">
            <!-- Main content -->
            <section class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <i class="fa fa-globe"></i> 订单编号 <?php echo $order_sn ?>
                            <small class="pull-right">Date:<?php echo date("d/m/Y")?></small>
                        </h2>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <!-- /.col -->
                    <div class="col-sm-12">
                        <b>收货人</b>
                        <address>
                            <strong><?php echo $master_info['fullname'] ?>(<?php echo $master_info['telephone'] ?>)</strong>
                            <?php echo $master_info['address'] ?>
                        </address>
                    </div>
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="50%">商品名称</th>
                                    <th  width="20%">规格</th>
                                    <th>价格</th>
                                    <th>数量</th>
                                    <th>小计</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?php echo $product['product_name'] ?></td>
                                        <td><?php echo $product['product_special_name'] ?></td>
                                        <td>￥<?php echo $product['product_price'] ?></td>
                                        <td><?php echo $product['product_number'] ?></td>
                                        <td>￥<?php echo $product['product_price'] * $product['product_number'] ?></td>

                                    </tr>
                                <?php endforeach; ?>
                                    
<!--                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>支付金额:</b></td>
                                        <td> ￥<?php echo $pay_money ?></td>
                                    </tr>-->
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <!-- info row -->
                <div class="row invoice-info">
                    <!-- /.col -->
                    <div class="col-sm-12">
                        <b>发货人</b>
                        <address>
                            <strong><?php echo $send_user ?>(<?php echo $send_phone ?>)</strong>
                            <?php echo $send_address ?>
                        </address>
                    </div>
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- ./wrapper -->
    </body>
</html>