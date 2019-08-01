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
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
        <link rel="stylesheet" href="dist/css/ZMShop.min.css">
        <link rel="stylesheet" href="plugins/select2/select2.min.css">
        <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
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
                        <li class="<?php echo site_url('Order/index'); ?>">订单管理</li>
                        <li class="active">订单详情</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">订单管理</h3>
                            <button type="submit" class="btn btn-primary pull-right">保存</button>
                        </div>
                    </div>
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1" data-toggle="tab" aria-expanded="true">订单详情</a>
                            </li>
                            <li class="">
                                <a href="#tab_2" data-toggle="tab" aria-expanded="false">状态</a>
                            </li>
                            <li class="">
                                <a href="#tab_3" data-toggle="tab" aria-expanded="false">支付</a>
                            </li>
                            <li class="">
                                <a href="#tab_4" data-toggle="tab" aria-expanded="false">选项</a>
                            </li>
                            <li class="">
                                <a href="#tab_5" data-toggle="tab" aria-expanded="false">属性</a>
                            </li>
                        </ul>
                        <form role="form">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <section class="invoice">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h2 class="page-header">
                                                    <i class="fa fa-globe"></i> 订单详情
                                                    <small class="pull-right">日期: 2/1/2018</small>
                                                </h2>
                                            </div>
                                        </div>
                                        <div class="row invoice-info">
                                            <div class="col-sm-4 invoice-col">
                                                寄件人:
                                                <address>
                                                    <strong>ZMshop仓库1</strong><br>
                                                    河南省郑州市<br>
                                                    郑开大道<br>
                                                    电话: (0371) 123-5432<br>
                                                    Email: info@zhimo.com
                                                </address>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4 invoice-col">
                                                收件人:
                                                <address>
                                                    <strong>张晓明</strong><br>
                                                    湖南省长沙市<br>
                                                    橘子洲头<br>
                                                    Phone: 124345354354<br>
                                                    Email: xiaoming@example.com
                                                </address>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4 invoice-col">
                                                <b>订单编号 #007612</b><br>
                                                <br>
                                                <b>支付方式:</b> 微信支付<br>
                                                <b>支付时间:</b> 2/22/2018<br>
                                                <b>支付账户:</b> 24325432543
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->

                                        <!-- Table row -->
                                        <div class="row">
                                            <div class="col-xs-12 table-responsive">
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
                                                        <tr>
                                                            <td><a href="#">好东西好东西</a></td>
                                                            <td>红色,2ml</td>
                                                            <td>1</td>
                                                            <td>￥11</td>
                                                            <td>￥45</td>
                                                        </tr>
                                                        <tr>
                                                            <td><a href="#">好东西好东西</a></td>
                                                            <td>红色,2ml</td>
                                                            <td>1</td>
                                                            <td>￥11</td>
                                                            <td>￥45</td>
                                                        </tr>
                                                        <tr>
                                                            <td><a href="#">好东西好东西</a></td>
                                                            <td>红色,2ml</td>
                                                            <td>1</td>
                                                            <td>￥11</td>
                                                            <td>￥45</td>
                                                        </tr>
                                                        <tr>
                                                            <td><a href="#">赠品：好东西</a></td>
                                                            <td>红色,2ml</td>
                                                            <td>1</td>
                                                            <td>￥11</td>
                                                            <td>￥45</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <p class="lead">订单总计 2/22/2017</p>

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tr>
                                                            <th style="width:50%">商品总计:</th>
                                                            <td>￥250.30</td>
                                                        </tr>
                                                        <tr>
                                                            <th>优惠券：</th>
                                                            <td>￥10</td>
                                                        </tr>
                                                        <tr>
                                                            <th>促销活动:</th>
                                                            <td>满一赠一</td>
                                                        </tr>
                                                        <tr>
                                                            <th>订单总计:</th>
                                                            <td>￥265.24</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row no-print">
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
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#tab-history" data-toggle="tab" aria-expanded="true">订单状态历史记录</a></li>
                                                <li class=""><a href="#tab-additional" data-toggle="tab" aria-expanded="false">其他</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab-history">
                                                    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> 警告: 无权限访问 API 接口！ <button type="button" class="close" data-dismiss="alert">×</button></div><div id="history"><div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <td class="text-left">添加日期</td>
                                                                        <td class="text-left">备注</td>
                                                                        <td class="text-left">状态</td>
                                                                        <td class="text-left">通知了会员</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-left">2017-12-24</td>
                                                                        <td class="text-left">支付成功1</td>
                                                                        <td class="text-left">支付完成</td>
                                                                        <td class="text-left">是</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6 text-left"></div>
                                                            <div class="col-sm-6 text-right">显示 1 到 1 / 1 (总 1 页)</div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <fieldset>
                                                        <legend>新增订单历史记录</legend>
                                                        <form class="form-horizontal">
                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label" for="input-order-status">订单状态</label>
                                                                <div class="col-sm-10">
                                                                    <select name="order_status_id" id="input-order-status" class="form-control">
                                                                        <option value="2">处理中</option>
                                                                        <option value="14">失效</option>
                                                                        <option value="10">失败</option>
                                                                        <option value="7">已取消</option>
                                                                        <option value="15">已处理</option>
                                                                        <option value="17">已完成</option>
                                                                        <option value="8">已拒绝</option>
                                                                        <option value="11">已退款</option>
                                                                        <option value="18">待评价</option>
                                                                        <option value="13">拒付</option>
                                                                        <option value="9">撤销取消</option>
                                                                        <option value="5" selected="selected">支付完成</option>
                                                                        <option value="16">无效</option>
                                                                        <option value="1">等待处理</option>
                                                                        <option value="3">配送中</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label" for="input-override"><span data-toggle="tooltip" title="" data-original-title="在由于反欺诈而造成订单被锁的情况下，仍然可以覆盖操作。">覆盖</span></label>
                                                                <div class="col-sm-10">
                                                                    <input type="checkbox" name="override" value="1" id="input-override">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label" for="input-notify">提示会员</label>
                                                                <div class="col-sm-10">
                                                                    <input type="checkbox" name="notify" value="1" id="input-notify">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label" for="input-comment">备注</label>
                                                                <div class="col-sm-10">
                                                                    <textarea name="comment" rows="8" id="input-comment" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </fieldset>
                                                    <div class="text-right">
                                                        <button id="button-history" data-loading-text="加载中..." class="btn btn-primary"><i class="fa fa-plus-circle"></i> 添加历史记录</button>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab-additional">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <td colspan="2">浏览器</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>IP 地址</td>
                                                                    <td>122.245.80.134</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>User Agent</td>
                                                                    <td>Mozilla/5.0 (iPhone; CPU iPhone OS 11_2_1 like Mac OS X) AppleWebKit/604.4.7 (KHTML, like Gecko) Mobile/15C153 MicroMessenger/6.6.0 NetType/WIFI Language/zh_CN</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>语言</td>
                                                                    <td>zh-cn</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box box-primary">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <label for="goodName">建议零售价</label>
                                                            <input type="text" class="form-control" id="goodName" placeholder="建议零售价">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-5">
                                                            <label>是否配送</label>
                                                            <select class="form-control">
                                                                <option selected="selected">是</option>
                                                                <option>否</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_3">
                                    <div class="table-responsive">
                                        <table id="special" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <td class="text-left">会员等级</td>
                                                    <td class="text-right">优先级</td>
                                                    <td class="text-right">价格</td>
                                                    <td class="text-left">开始日期</td>
                                                    <td class="text-left">结束日期</td>
                                                    <td></td>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5"></td>
                                                    <td class="text-left">
                                                        <button type="button" onclick="addSpecial();" data-toggle="tooltip"
                                                                title="" class="btn btn-primary"
                                                                data-original-title="添加特权价格"><i
                                                                class="fa fa-plus-circle"></i></button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">保存</button>
                            </div>
                        </form>

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
        <script src="plugins/select2/select2.full.min.js"></script>
        <script src="dist/js/common.js"></script>
        <script src="dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/location.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/area.js" type="text/javascript" charset="utf-8"></script>
        <link href="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
        <script src="plugins/bootstrap-datetimepicker/moment.js"></script>
        <script src="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
        <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <script src="plugins/summernote/summernote.js"></script>
        <script src="plugins/summernote/lang/summernote-zh-CN.js"></script>
        <script src="plugins/summernote/upload.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
                                                            var special_row = 0;

                                                            function addSpecial() {
                                                                html = '<tr id="special-row' + special_row + '">';
                                                                html += '  <td class="text-left"><select name="product_special[' + special_row + '][customer_group_id]" class="form-control">';
                                                                html += '      <option value="3">VIP</option>';
                                                                html += '      <option value="2">VIP(测试人元)</option>';
                                                                html += '      <option value="6">代理会员</option>';
                                                                html += '      <option value="1">普通会员</option>';
                                                                html += '      <option value="5">正式会员</option>';
                                                                html += '      <option value="4">贵宾群</option>';
                                                                html += '  </select></td>';
                                                                html += '  <td class="text-right"><input type="text" name="product_special[' + special_row + '][priority]" value="" placeholder="优先级" class="form-control" /></td>';
                                                                html += '  <td class="text-right"><input type="text" name="product_special[' + special_row + '][price]" value="" placeholder="价格" class="form-control" /></td>';
                                                                html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="product_special[' + special_row + '][date_start]" value="" placeholder="开始日期" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
                                                                html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="product_special[' + special_row + '][date_end]" value="" placeholder="结束日期" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
                                                                html += '  <td class="text-left"><button type="button" onclick="$(\'#special-row' + special_row + '\').remove();" data-toggle="tooltip" title="移除" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
                                                                html += '</tr>';

                                                                $('#special tbody').append(html);

                                                                $('.date').datetimepicker({
                                                                    pickTime: false
                                                                });

                                                                special_row++;
                                                            }
        </script>


        <script type="text/javascript">
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
        </script>

    </body>

</html>