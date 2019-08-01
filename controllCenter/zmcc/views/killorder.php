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
<!--                                    <button  type="button" class="btn btn-success btn-sm"  id="fhexportOrder" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-cloud-upload" aria-hidden="true">导入发货单号</i>
                                    </button>
                                    <button  type="button" class="btn btn-success btn-sm"  id="exportOrder"><i class="fa fa-cloud-download" aria-hidden="true">导出订单</i></button>-->
                                    <button type="button" class="btn btn-default btn-sm" id="refresh"><i class="fa fa-refresh">刷新</i></button>
                                    <button type="button" class="btn btn-default btn-sm" id="delete"><i class="fa fa-trash-o">删除</i></button>
                                </div>
                            </div>

                        </div>
                        <form action="<?php echo site_url("export/export_order") ?>" method="post" id="form-export">
                            <input type="hidden" value="" name="ids" id="orderids">
                        </form>
                        <form action="<?php echo site_url('Order/index') ?>" method="post" id="form-search">
                            <div class="row"  style="padding:5px;">
                                <div class="form-group col-md-2">
                                    <label>状态</label>
                                    <select name="filter_status" class="form-control select2">
                                        <option value="">所有订单</option>
                                        <option <?php
                                        if (set_value('filter_status') === '0') {
                                            echo 'selected';
                                        }
                                        ?> value="0">未支付</option>
                                        <option <?php
                                        if (set_value('filter_status') == 1) {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="1">已支付</option>
                                        <option <?php
                                        if (set_value('filter_status') == 2) {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="2">已发货</option>
                                        <!--<option <?php
                                        if (set_value('filter_status') == 3) {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="3">部分发货</option>
                                        <option <?php
                                        if (set_value('filter_status') == 4) {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="4">部分退货</option>-->
                                        <option <?php
                                        if (set_value('filter_status') == 5) {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="5">已收货</option>
                                        <option <?php
                                        if (set_value('filter_status') == 7) {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="7">售后中</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>会员</label>
                                    <input type="text" class="form-control" name="user_name"  value="<?php echo set_value('user_name'); ?>" />
                                    <input type="hidden" name="user_id"  value="<?php echo set_value('user_id'); ?>" />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>下单开始时间</label> 
                                    <div class="input-group date">
                                        <input type="text" name="start_time" value="<?php echo set_value('start_time') ?>" placeholder="创建日期" data-date-format="YYYY-MM-DD" class="form-control" />
                                        <span class="input-group-btn">
                                            <button  type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>下单结束时间</label>
                                    <div class="input-group date">
                                        <input type="text" name="end_time" value="<?php echo set_value('end_time') ?>" placeholder="截止日期" data-date-format="YYYY-MM-DD" class="form-control " />
                                        <span class="input-group-btn">
                                            <button  type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="input-group col-md-3">
                                    <label>订单编号</label>
                                    <input type="text" class="form-control" name="order_sn"  value="<?php echo set_value('order_sn'); ?>" />
                                    <div class="input-group-btn">
                                        <button stype="submit" style="margin-top:25px" class="btn btn-success">搜索</button>
                                        <button type="button" class="btn btn-default" style="margin-top:25px" onclick="javascript:location.href = '<?php echo site_url("Order/index") ?>'">重置</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="box-body no-padding">
                            <div class="table-responsive select-messages">
                                <?php if (empty($list)) { ?>
                                    <div style="text-align: center;">
                                        暂时还没有收到订单
                                    </div>
                                <?php } else { ?>
                                    <form action="<?php echo site_url('Order/deleteOrder') ?>" method="post" id="form-product">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                            <td style="width: 1%"><input type="checkbox" class="btn btn-default btn-sm checkbox-toggle"></td>
                                            <td>订单编号</td>
                                            <td >会员昵称</td>
                                            <td >手机号码</td>
                                            <td >支付金额</td>
                                            <td >订单状态</td>
                                            <td >下单时间</td>
                                            <td >操作</td>
                                            </thead>
                                            <tbody>
                                                </br>
                                                <?php
                                                foreach ($list as $item):
                                                    ?>
                                                    <tr>
                                                        <td><input name="selected[]" type="checkbox"  value="<?php echo $item['order_id']; ?>"></td>
                                                        <td ><?php echo $item['order_sn']; ?></td>
                                                        <td ><?php echo $item['nickname']; ?></td>
                                                        <td ><?php echo $item['user_phone'] ? $item['user_phone'] : "/"; ?></td>
                                                        <td >￥<?php echo $item['order_amount']; ?></td>
                                                        <td ><?php echo $statusname[$item['status']]; ?></td>
                                                        <td ><?php echo date("Y-m-d H:m", $item['createtime']); ?></td>
                                                        <td>
                                                            <a  href="<?php echo site_url('Order/editOrderInfo/' . $item['order_id']); ?>"  class="btn btn-primary btn-xs"><i class="fa fa-eye">砍价详情</i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                endforeach;
                                                ?>
                                            </tbody>
                                        </table>
                                    </form>
                                <?php } ?>
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
            <!--导入发货单号弹窗-->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">
                                导入发货单号
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                        </div>
                        <form enctype='multipart/form-data' method="post" id="order_file_form">
                            <div class="modal-body">
                                <input type="file" id="orderFile" name="orderFile" value="导入发货单号">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                </button>
                                <button type="button" id="order_file" class="btn btn-primary">
                                    导入
                                </button>
                            </div> 
                        </form>
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
        <script src="plugins/bootstrap-datetimepicker/moment.js"></script>
        <script src="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="dist/js/bootbox.js"></script>
        <script src="dist/js/common.js"></script>
        <script>
                                            function jsOpenModals() {
                                                $('#myModal').modal('show');//手动打开模态框。
                                            }
                                            function jsOpenModal() {
                                                $('#myModal').modal('hide');//手动隐藏模态框。
                                            }
                                            $('.date').datetimepicker({
                                                pickTime: false
                                            });
                                            var orderIdsObj = [];
                                            $(function () {
                                                if (sessionStorage.getItem("orderIds")) {
                                                    orderIdstr = sessionStorage.getItem("orderIds");
                                                    orderIdsObj = JSON.parse(orderIdstr);
                                                    //选中所有已经选中的的checkbox
                                                    for (var o in orderIdsObj) {
                                                        $("[value='" + orderIdsObj[o] + "']").iCheck('check');
                                                    }
                                                }

                                                $("[name='selected[]']").on("ifChanged", function () {
                                                    if ($(this).is(":checked")) {
                                                        orderIdsObj.push($(this).attr("value"));
                                                    } else {
                                                        orderIdsObj.splice(orderIdsObj.indexOf($(this).attr("value")), 1);
                                                    }
                                                    sessionStorage.setItem("orderIds", JSON.stringify(orderIdsObj));
                                                });
                                                /*导入发货单号*/
                                                $('#order_file').click(function () {
                                                    var formData = new FormData($('#order_file_form')[0]);
                                                    $.ajax({
                                                        type: 'post',
                                                        url: "<?php echo site_url('Order/orderTracter') ?>",
                                                        data: formData,
                                                        cache: false,
                                                        processData: false,
                                                        contentType: false,
                                                    }).success(function (res) {
                                                        if (typeof (res) == 'string') {
                                                            var res = JSON.parse(res);
                                                        }
                                                        $('#myModal').modal('hide');
                                                        if (res.error_code == 0) {
                                                            location.reload();
                                                        } else if (res.error_code == 9) {
                                                            $("#power_operation").append("<div class='alert alert-warning alert-dismissible' role='alert'>\n\
                                                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>\n\
                                                                    <strong>警告!</strong>权限错误，请联系管理员分配权限</div>");
                                                        }
                                                    }).error(function () {

                                                    });
                                                });

                                                /**导出订单**/
                                                $("#exportOrder").click(function () {
                                                    var ids = sessionStorage.getItem("orderIds");
                                                    if (ids === "") {
                                                        bootbox.alert({
                                                            message: "请您选择要导出的订单<br><font style='color:red'>如果您刚才导出了数据，请点击刷新按钮之后重新选择</font>",
                                                            backdrop: true
                                                        });
                                                        return;
                                                    } else {
                                                        sessionStorage.setItem("orderIds", "");
                                                        $("#orderids").val(ids);
                                                        $("#form-export").submit();

                                                    }
                                                });
                                                $("#refresh").click(function () {
                                                    sessionStorage.setItem("orderIds", "");
                                                    location.reload()
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
                                                            url: '<?php echo site_url('User/autoUser'); ?>' + '?user_id=' + encodeURIComponent(request) + '&filter_nickname=' + encodeURIComponent(request),
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

                                            })
        </script>
    </body>

</html>