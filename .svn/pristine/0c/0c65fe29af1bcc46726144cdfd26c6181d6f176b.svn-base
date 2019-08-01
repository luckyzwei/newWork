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
                        店铺订单详情
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class="active">店铺订单详情</li>
                    </ol>
                </section>
                <section class="content">
                   <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">店铺订单详情</h3>
                        </div>
                    </div>
                    <div class="nav-tabs-custom">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <section class="invoice">
                                    <!-- title row -->
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h2 class="page-header">
                                                <i class="fa fa-globe"></i> 订单详情
                                                <small class="pull-right">日期:<?php echo date('Y-m-d H:m', $orderinfo['createtime']); ?></small>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="row invoice-info">
                                        <div class="col-sm-4 invoice-col">
                                            下单会员:
                                            <address>
                                                <strong><?php echo $orderinfo['email']; ?></strong><br>
                                                <b>账号：</b><?php echo $orderinfo['user_name']; ?><br>
                                                <b>昵称：</b><?php echo $orderinfo['nickname']; ?>
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            收件人:
                                            <address>
                                                <strong><?php echo $orderinfo['fullname']; ?></strong><br>
                                                <?php echo $orderinfo['province_name'] . $orderinfo['city_name'] . $orderinfo['district_name']; ?><br>
                                                <?php echo $orderinfo['address']; ?><br>
                                                Phone: <?php echo $orderinfo['telephone']; ?><br>
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            <b>订单编号：</b><?php echo $orderinfo['order_sn']; ?><br>
                                            <b>支付状态：</b><?php echo $orderinfo['statusname']; ?><br>
                                             <?php if($orderinfo['statusname'] != "未支付"){echo "<b>支付方式：</b>".$orderinfo['payment_name'];}?><br>
                                             <?php if($orderinfo['statusname'] != "未支付"){echo "<b>支付时间：</b>".date('Y-m-d H:m:s', $orderinfo['paytime']);} ?><br>
                                             <?php if($orderinfo['statusname'] != "未支付"){echo "<b>支付流水号：</b>".$orderinfo['trade_no']; } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 table-responsive">
                                            <p class="lead">商品</p>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>商品</th>
                                                        <th>规格</th>
                                                        <th>数量</th>
                                                        <th>单品价格</th>
                                                        <th>单品小计</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!empty($orderproduct)) {
                                                        foreach ($orderproduct as $key => $value) {
                                                            ?>
                                                            <tr>
                                                                <td><a href='<?php echo "/index.php/Product/editProduct?product_id=" . $value['product_id'];?>'><?php echo $value['product_name'] ?></a></td>
                                                                <td><?php echo $value['product_special_name'] ?></td>
                                                                <td><?php echo $value['product_number'] ?></td>
                                                                <td><?php echo $value['product_price'] ?></td>
                                                                <td><?php echo $value['product_price'] * $value['product_number'] ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>未查询到或数据有错</tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <p class="lead">订单总计</p>

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <th style="width:90px">商品总计:</th>
                                                        <td><?php echo $orderinfo['product_amount'];?> 件</td>
                                                    </tr>
                                                    <tr>
                                                        <th>邮费:</th>
                                                        <td><?php if($orderinfo['postage'] != 0 ){echo "￥".$orderinfo['postage'];}else{ echo "免邮费" ;} ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>订单总计:</th>
                                                        <td>￥<?php echo $orderinfo['order_amount']; ?></td>
                                                    </tr>
                                                    <?php if (!empty($orderinfo['coupon_name'])) { ?>
                                                        <tr>
                                                            <th>优惠券：</th>
                                                            <td><?php echo $orderinfo['coupon_name']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php if (!empty($orderinfo['marketing_name'])) { ?>
                                                        <tr>
                                                            <th>促销活动:</th>
                                                            <td><?php echo $orderinfo['marketing_name']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php if (!empty($orderinfo['save_money'])) { ?>
                                                        <tr>
                                                            <th>优惠金额:</th>
                                                            <td>￥<?php echo $orderinfo['save_money']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr>
                                                        <th>支付金额:</th>
                                                        <td>￥<?php echo $orderinfo['pay_money']; ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display:none" class="row no-print">
                                        <div class="col-xs-12">
                                            <a href="订单打印.html" target="_blank" class="btn btn-success"><i class="fa fa-print"></i> 打印订单</a>
                                        </div>
                                    </div>
                                </section>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-comment-o"></i> 订单历史记录</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab-history">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td class="text-left">添加日期</td>
                                                            <td class="text-left">备注</td>
                                                            <td class="text-left">操作人</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($orderlog as $value) { ?>
                                                            <tr>
                                                                <td class="text-left"><?php echo date('Y-m-d H:m', $value['createtime']) ?></td>
                                                                <td class="text-left"><?php echo $value['content'] ?></td>
                                                                <td class="text-left"><?php echo $value['operator_id'] ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <br>
                                        <fieldset id="rstatus" style="<?php if ($orderinfo['refunds_status'] != 1) echo 'display:none' ?>">
                                            <legend>处理退还</legend>
                                            <form class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="input-refunds-status">订单状态：</label>
                                                    <div class="col-sm-10">
                                                        <select name="refunds_status" id="input-refunds-status" class="form-control">
                                                            <option value="2">已处理</option>
                                                            <option value="3">驳回</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="input-refunds-notify">提示会员：</label>
                                                    <div class="col-sm-10">
                                                        <input type="checkbox" name="refunds_notify" value="1" id="input-notify">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="input-refunds-money">退款金额：</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" value="" id="refunds_mony" name='refunds_money' placeholder="退还给用户的金钱（退至余额）">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="input-refunds-notify">订单状态：</label>
                                                    <div class="col-sm-10">
                                                        <input type="radio" checked="checked" class="form-radio" name="delect_order" value="0" >无操作
                                                        <input type="radio" class="form-radio" name="delect_order" value="1" >删除订单
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="input-refunds-comment">备注：</label>
                                                    <div class="col-sm-10">
                                                        <textarea name="refunds_content" rows="8" id="input-comment" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="text-right">
                                                <button id="button-refund-history" data-loading-text="加载中..." class="btn btn-primary"><i class="fa fa-plus-circle"></i> 处理退还</button>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
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
<script src="dist/js/common.js"></script>
<script src="dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="dist/js/location.js" type="text/javascript" charset="utf-8"></script>
<script src="dist/js/area.js" type="text/javascript" charset="utf-8"></script>
<script src="dist/js/select2/select2.full.min.js"></script>
<script src="plugins/bootstrap-datetimepicker/moment.js"></script>
<script src="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="plugins/summernote/summernote.js"></script>
<script src="plugins/summernote/lang/summernote-zh-CN.js"></script>
<script src="plugins/summernote/upload.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $('.date').datetimepicker({
        pickTime: false
    });
</script>

</body>

</html>