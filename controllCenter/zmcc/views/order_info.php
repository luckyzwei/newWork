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
                                <?php if ($orderinfo['status'] == 1): ?>
                                    <form id="delivery<?php echo $orderinfo['order_id'] ?>" method="post" action="<?php echo site_url('order/delivery') ?>">
                                        <div class="input-group input-group-sm" style="width:550px;">
                                            <input type="hidden" name="order_id" value="<?php echo $orderinfo['order_id'] ?>">
                                            <input type="text" id="shipping_code" name="shipping_type" class="form-control" placeholder="快递公司编码">
                                            <input type="text" id="shipping_code" name="shipping_code" class="form-control" placeholder="快递单号">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-xs btn-success" id="allDelivery<?php echo $orderinfo['order_id'] ?>"><i class="fa fa-send"> 订单发货</i></button>
                                                <button type="button" class="btn">
                                                    <a href="<?php echo site_url('order/printMasterOrder') ?>?order_id=<?php echo $orderinfo['order_id'] ?>" target="_blank">
                                                        <i class="fa fa-print"> 打印发货单</i>
                                                    </a>

                                                </button>

                                                <button type="button" class="btn btn-danger" 
                                                        id="orderRefund" data-toggle="modal" data-target="#reFundModal"
                                                        >订单退款</button>

                                            </div>
                                        </div>
                                    </form>
                                <?php else: ?>

                                    <div class="btn-group">
                                        <?php if ($orderinfo['status'] == 2 && 1 == 2): ?>
                                            <button type="button" class="btn btn-info">设置为未发货</button>
                                        <?php endif; ?>
                                        <?php if ($orderinfo['status'] > 1 && $orderinfo['status'] != 8): ?>
                                            <button type="button" class="btn btn-danger" 
                                                    id="orderRefund" data-toggle="modal" data-target="#reFundModal"
                                                    >订单退款</button>
                                                <?php endif; ?>
                                    </div>
                                <?php endif; ?>


                            </div>
                        </div>
                        <section class="box-body">
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-3 invoice-col">
                                    <b> 购货人</b>
                                    <address>
                                        <strong><?php echo $orderinfo['wx_nickname'] . "(" . $orderinfo['user_name'] . ")" ?></strong><br>
                                        订单状态：<?php echo $orderinfo['statusname'] ?> <br>

                                        物流单号：<?php echo $orderinfo['shipping_code'] ? $orderinfo['shipping_code'] : "未发货" ?><br>
                                    </address>
                                    <b>客户留言 ：<?php echo $orderinfo['remark'] ?></b><br>
                                </div>
                                
                                <!-- /.col -->
                                <div class="col-sm-3 invoice-col">
                                    <b>收货人</b>
                                    <address>
                                        <strong><?php echo $orderinfo['fullname'] ?></strong><br>
                                        <?php echo $orderinfo['address'] ?><br>
                                        <?php echo $orderinfo['telephone'] ?>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 invoice-col">
                                    <b>订单编号：<?php echo $orderinfo['order_sn'] ?></b><br>
                                    <b>下单时间：</b><?php echo date('Y-m-d H:i:s', $orderinfo['createtime']); ?><br>
                                    <b>支付金额：</b> ￥<?php echo $orderinfo['order_amount'] ?><br>
                                    <b>支付方式：</b> <?php echo $orderinfo['payment_name'] ?>
                                </div>

                                <!-- /.col -->
                                <div class="col-sm-3 invoice-col">
                                    <b>订单总计：<?php echo $orderinfo['order_amount'] ?></b><br>
                                    <b>商品货值：</b><?php echo $orderinfo['product_amount'] ?><br>
                                    <b>订单运费：</b> ￥<?php echo $orderinfo['postage'] ?><br>
                                    <b>优惠金额：</b> <?php echo $orderinfo['save_money'] ?>
                                </div>
                                 

                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <?php foreach ($suborders as $suborder): ?>
                                <section class="box-body"  style="border: 1px solid #e1e1e1;margin-bottom: 5px">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">订单商品</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>商品ID</th>
                                                        <th>商品名称</th>
                                                        <th>商品规格</th>
                                                        <th>供货商</th>
                                                        <th>购买价格</th>
                                                        <th>购买数量</th>
                                                        <th>价格小计</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($suborder['products'] as $product): ?>
                                                        <tr>
                                                            <td><?php echo $product['product_id'] ?></td>
                                                            <td><?php echo $product['product_name'] ?></td>
                                                            <td><?php echo $product['product_special_name'] ?></td>
                                                            <td><?php echo $suborder['supplier']['name'] ? $suborder['supplier']['name'] : "平台商品" ?></td>
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
                            <?php endforeach; ?>
                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-xs-5">
                                    <p class="lead">订单操作记录</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <?php foreach ($orderlog as $log): ?>
                                                    <tr>
                                                        <th style="width:50%"><?php echo $log['content'] ?></th>
                                                        <td><?php echo date("Y-m-d H:i:s", $log['createtime']) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>

                                            </tbody></table>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <?php if($orderinfo['order_type'] == 'K' && !empty($killorderlog)):?>
                                <div class="col-xs-6">
                                    <p class="lead">订单砍价日志</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                 <?php foreach ($killorderlog as $killlog): ?>
                                                    <tr>
                                                        <th><?php if(!empty($killlog['wx_headimg'])){?><img style="width:25px;height: 25px;" src="<?php echo $killlog['wx_headimg'];?>"><?php }?>&nbsp;<?php echo $killlog['nickname'] ? $killlog['nickname'] : "匿名"?></th>
                                                        <th style="width:20%">自:<?php echo $killlog['original_price'] ?>元</th>
                                                        <th style="width:20%">砍价:<?php echo $killlog['reduced_price'] ?>元</td>
                                                        <td style="width:50%"><?php echo date("Y-m-d H:i:s", $killlog['creatime']) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody></table>
                                    </div>
                                </div>
                                <?php else:?>
                                <div class="col-xs-4">
                                    <p class="lead">享受的优惠活动</p>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <?php if ($coupon): ?>
                                                    <tr>
                                                        <td>使用优惠券:<?php echo $coupon['coupon_name'] ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php foreach ($marketings as $marketing): ?>
                                                    <tr>
                                                        <td><?php echo $marketing['marketing_name'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>

                                            </tbody></table>
                                    </div>
                                </div>
                                <?php endif;?>
                                <!-- /.col -->

                            </div>
                        </section>
                    </div>

                </section>

                <!--退款-->
                <div class="modal" id="reFundModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                                <h4 class="modal-title" id="myModalLabel">
                                    请填写退款信息
                                </h4>
                            </div>
                            <form action="<?php echo site_url("order/orderRefund") ?>" method="post">
                                <div class="modal-body">

                                    <label>退款金额</label>
                                    <input type="number" class="form-control"  name="refund_money" value="<?php echo $orderinfo['pay_money'] ?>">
                                    <input type="hidden" name="order_id" value="<?php echo $orderinfo['order_id'] ?>">
                                    <br>
                                    <label>备注</label>
                                    <textarea type="text" class="form-control" name="refund_remark" rows="3"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                                    </button>
                                    <button type="submit" class="btn btn-danger">
                                        确认退款
                                    </button>
                                </div> 
                            </form>
                        </div>
                    </div>
                </div>

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