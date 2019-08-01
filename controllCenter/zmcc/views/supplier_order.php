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
<style type="text/css">
    .totle_money {
        padding: 30px auto;
    }
    .totle_money ul{
        list-style: none;
    }
    .totle_money li{
        float: left;
        margin-right: 20px;
    }
</style>
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
                        <li class="active">订单管理</li>
                    </ol>
                </section>
                <section class="content">
                   <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">订单列表</h3>
                            <div class="box-tools">
                                <div class="has-feedback">
                                    <button type="button" class="btn btn-default btn-sm" id="delete"><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="box-body no-padding">
                            <div class="mailbox-controls">
                                <div class="has-feedback" style="margin: 0;">
                                    <form action="<?php echo site_url('Supplier/supplierOrder?supplier_id='.$supplier_id) ?>" method="post" id="form-search">
                                        <!-- <div class="form-group col-md-3">
                                            <label>会员</label>
                                            <input type="text" class="form-control" name="user_name"  value="<?php //echo set_value('user_name'); ?>" />
                                            <input type="hidden" name="user_id"  value="<?php //echo set_value('user_id'); ?>" />
                                        </div> -->
                                        <div class="form-group col-md-3">
                                            <input type="text" class="form-control" name="order_sn" placeholder="订单编号" value="<?php echo $order_sn ?>" />
                                        </div>
                                         <div class="input-group date col-md-2" style="float:left;">
                                            <input type="text" name="bg_time" value="<?php echo $bg_time;?>" placeholder="开始日期" data-date-format="YYYY-MM-DD" class="form-control" />
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                        <div class="input-group date col-md-2" style="float:left;">
                                            <input type="text" name="ed_time" value="<?php echo $ed_time;?>" placeholder="结束日期" data-date-format="YYYY-MM-DD" class="form-control" />
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <select name="filter_status" class="form-control select2">
                                                <option value=''>--订单状态--</option>
                                                <option <?php
                                                if ($filter_status == '-1') {
                                                    echo 'selected="selected"';
                                                }
                                                ?> value="-1">售后中</option>
                                                <option <?php
                                                if ($filter_status == '0') {
                                                    echo 'selected="selected"';
                                                }
                                                ?> value="0">未支付</option>
                                                <option <?php
                                                if ($filter_status == '1') {
                                                    echo 'selected="selected"';
                                                }
                                                ?> value="1">已支付</option>
                                                <option <?php
                                                if ($filter_status == '2') {
                                                    echo 'selected="selected"';
                                                }
                                                ?> value="2">已发货</option>
                                                <option <?php
                                                if ($filter_status == '3') {
                                                    echo 'selected="selected"';
                                                }
                                                ?> value="3">部分发货</option>
                                                <option <?php
                                                if ($filter_status == '4') {
                                                    echo 'selected="selected"';
                                                }
                                                ?> value="4">部分退货</option>
                                                <option <?php
                                                if ($filter_status == '5') {
                                                    echo 'selected="selected"';
                                                }
                                                ?> value="5">已收货</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-1">
                                            <input type="submit" class="btn btn-success"  value="搜索" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                             <?php if (empty($list)) { ?>
                                <div style="text-align: center;">
                                    你还没有数据
                                </div>
                            <?php }else{ ?>
                            <div class="table-responsive select-messages">
                                <div class="totle_money">
                                    <ul>
                                        <li>订单总量：<?php echo $totle['order_num'] ?></li>
                                        <li>销售总额：<?php echo $totle['all'] ?></li>
                                        <li>可提现订单总量：<?php echo $totle['withdraw_order_num'] ?></li>
                                        <li>可提现总额：<?php echo $totle['withdraw'] ?></li>
                                    </ul>
                                </div>
                                <form action="<?php echo site_url('Order/deleteOrder') ?>" method="post" id="form-product">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                        <td style="width: 1%"><input type="checkbox" class="btn btn-default btn-sm checkbox-toggle"></td>
                                        <td>订单编号</td>
                                        <td >会员昵称</td>
                                        <td >支付金额</td>
                                        <td >订单状态</td>
                                        <td >下单时间</td>
                                        <td >操作</td>
                                        </thead>
                                        <tbody>
                                                <?php
                                                foreach ($list as $item):
                                                    ?>
                                                    <tr>
                                                        <td><input name="selected[]" type="checkbox"  value="<?php echo $item['order_id']; ?>"></td>
                                                        <td ><?php echo $item['order_sn']; ?></td>
                                                        <td ><?php echo $item['nickname']; ?></td>
                                                        <td >￥<?php echo $item['pay_money']; ?></td>
                                                        <td ><?php echo $statusname[$item['status']]; ?></td>
                                                        <td ><?php echo date("Y-m-d H:m", $item['createtime']); ?></td>
                                                        <td >
                                                            <a  href="<?php echo site_url('Order/subOrderInfo/' . $item['order_id']);?>"  class="btn btn-primary btn-xs"><i class="fa fa-eye">详情</i></a>
                                                            <a style="display:none" href="<?php echo site_url('Order/editOrder/' . $item['order_id']); ?>"  class="btn btn-primary btn-xs"><i class="fa fa-pencil">编辑</i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            <?php }?>
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

        <script src="plugins/bootstrap-datetimepicker/moment.js"></script>
        <script src="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script>
            $('#category-filter').delegate('.fa-minus-circle', 'click', function () {
                                                $(this).parent().remove();
                                            });
                                            $('.date').datetimepicker({
                                                pickTime: false
                                            });

                                            $('.time').datetimepicker({
                                                pickDate: false
                                            });

                                            $('.datetime').datetimepicker({
                                                pickDate: true,
                                                pickTime: true
                                            });

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
                console.log(selecteds);
                if (selecteds == "") {
                    bootbox.alert({
                        message: "请您选择要删除的订单",
                        backdrop: true
                    });
                } else {
                    bootbox.confirm({
                        title: "删除订单",
                        message: "您确定要删除订单ID：" + selecteds + '',
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
                                $('#form-product').submit();
                            } else {
                            }
                        }
                    });
                }
            });

            $('input[name=\'user_name\']').autocomplete({
                'source': function (request, response) {
                    $.ajax({
                        url: '<?php echo site_url('User/autoUser'); ?>' + '?user_id=' + encodeURIComponent(request)+'&filter_nickname='+ encodeURIComponent(request),
                        dataType: 'json',
                        success: function (json) {
                            response($.map(json, function (item) {
                                return {
                                    label: item['nickname'],
                                    value: item['user_id']
                                }
                            }));
                        },
                    });
                },
                'select': function (item) {
                    $('input[name=\'user_name\']').val(item['label']);
                    $('input[name=\'user_id\']').val(item['value']);
                }
            });
        </script>
    </body>

</html>