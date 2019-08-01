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
                        优惠劵管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url("Coupon/index"); ?>">优惠劵管理</a>
                        </li>
                        <li class="active">编辑优惠劵</li>
                    </ol>
                </section>
                <section class="content">
                    <!--提示框 -->
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">编辑优惠劵</h3>
                                </div>
                                <form role="form" name="Coupon_form" id="Coupon" action="" method="post">
                                    <input type="hidden" name="createtime" value="<?php echo $xqing['createtime'] ?>">
                                    <input type="hidden" name="coupon_id" value="<?php echo $xqing['coupon_id'] ?>">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label for="">优惠劵名称</label>
                                                <input type="text" class="form-control" id="" name="coupon_name" value="<?php echo $xqing['coupon_name'] ?>" placeholder="优惠劵名称">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label >优惠劵面值（元/%）</label>
                                                <input class="form-control" name="coupon_denomination" value="<?php echo $xqing['coupon_denomination'] ?>" placeholder="优惠券面值,如果选择优惠券属性为打折券,这里则填写数字最大不能超过99"/>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <div class="col-md-3">
                                                <label>使用条件（最低订单金额）</label>
                                                <input  type="number" min="1" class="form-control" name="limit_order_amount" value="<?php echo $xqing['limit_order_amount'] ?>" placeholder="低于多少钱的订单不可以使用此优惠劵"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label >优惠劵属性</label>
                                                <select name="coupon_type" class="form-control" style="width:200px;">
                                                    <option value="1" <?php if ($xqing['coupon_type'] == 1) echo "selected" ?>>指定金额,直接抵扣</option>
                                                    <option value="2" <?php if ($xqing['coupon_type'] == 2) echo "selected" ?>>百分比打折劵</option>
                                                    <option value="-1" <?php if ($xqing['coupon_type'] == -1) echo "selected" ?>>免邮费.包邮</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label >是否允许用户领取</label>
                                                <select name="receive" class="form-control" style="width:200px;">
                                                    <option value="1" <?php if ($xqing['receive'] == 1) echo "selected" ?>>允许领取</option>
                                                    <option value="0" <?php if ($xqing['receive'] == 0) echo "selected" ?>>不允许领取</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label>数量</label>
                                                <input  type="number" min="1" class="form-control" name="receive_num" value="<?php echo $xqing['receive_num'] ?>" placeholder="本优惠劵的数量"/>
                                            </div>
                                        </div>
                                    </div>
<!--                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="image">优惠劵图片</label>
                                                <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail" data-original-title="" title="">
                                                    <img height="100px" src="<?php echo empty($xqing['image']) ? '/timg.jpg' : $xqing['image']; ?>" alt="" title="" data-placeholder="<?php echo empty($xqing['image']) ? '/timg.jpg' : $xqing['image']; ?>">
                                                </a>
                                                <input type="hidden" name="image" value="<?php echo empty($xqing['image']) ? '/timg.jpg' : $xqing['image']; ?>" id="input-image">
                                            </div>
                                        </div>-->
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label>优惠券有效期开始时间</label>
                                                <div class="input-group date">
                                                    <input type="text" name="start_time" value="<?php echo date('Y-m-d',$xqing['start_time']); ?>" placeholder="开始日期" data-date-format="YYYY-MM-DD" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label>优惠券有效期结束时间</label>
                                                <div class="input-group date">
                                                    <input type="text" name="end_time" value="<?php echo  date('Y-m-d',$xqing['end_time']); ?>" placeholder="结束日期" data-date-format="YYYY-MM-DD" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
<!--                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="enable_product">适用商品</label>
                                                <input type="text" class="form-control" id="enable_products" name="enable_products" placeholder="选择适用的商品">
                                                <div id="enable_product" class="well well-sm" style="height: 150px;overflow: auto">
                                                    <?php if (!empty($name)) {
                                                        foreach ($name as $value):
                                                            ?>
                                                            <div id="enable_product<?php echo $value["product_id"]; ?>"><i class="fa fa-minus-circle"></i> <?php echo $value["product_name"]; ?>
                                                                <input type="hidden" name="enable_product[]" value="<?php echo $value["product_id"]; ?>" />
                                                            </div>
                                                        <?php
                                                        endforeach;
                                                    }else {
                                                        echo '
                                                                    <div id="enable_product">
                                                                    </div>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="disable_product">不适用商品</label>
                                                <input type="text" class="form-control" id="disable_products" name="disable_products" placeholder="选择不适用的商品">
                                                <div id="disable_product" class="well well-sm" style="height: 150px;overflow: auto">
<?php if (!empty($disable_product)) {
    foreach ($disable_product as $v):
        ?>
                                                            <div id="enable_product<?php echo $v["product_id"]; ?>"><i class="fa fa-minus-circle"></i> <?php echo $v["product_name"]; ?>
                                                                <input type="hidden" name="disable_product[]" value="<?php echo $v["product_id"]; ?>" />
                                                            </div>
                                                        <?php
                                                        endforeach;
                                                    }else {
                                                        echo '
                                                                    <div id="enable_product">
                                                                    </div>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>-->
                                       
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('Coupon/index')?>'">返回</button>
                                    </div>
                                </form>
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
        <script src="dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
        <script src="plugins/iCheck/icheck.min.js"></script>
        <script src="dist/js/common.js"></script>
        <script src="dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="plugins/bootstrap-datetimepicker/moment.js"></script>
        <script src="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript">

                                            $('input[name=\'enable_products\']').autocomplete({
                                                'source': function (request, response) {
                                                    $.ajax({
                                                        url: '<?php echo site_url('Product/autoProduct') ?>?parent_id=' + request,
                                                        dataType: 'json',
                                                        success: function (json) {
                                                            response($.map(json, function (item) {
                                                                return {
                                                                    label: item['product_name'],
                                                                    value: item['product_id']
                                                                }
                                                            }));
                                                        }
                                                    });
                                                },
                                                'select': function (item) {
                                                    $('input[name=\'enable_products\']').val('');
                                                    $('#enable_product' + item['value']).remove();
                                                    $('#enable_product').append('<div id="enable_product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="enable_product[]" value="' + item['value'] + '" /></div>');
                                                }
                                            });

                                            $('#enable_product').delegate('.fa-minus-circle', 'click', function () {
                                                $(this).parent().remove();
                                            });

                                            $('input[name=\'disable_products\']').autocomplete({
                                                'source': function (request, response) {
                                                    $.ajax({
                                                        url: '<?php echo site_url('Product/autoProduct') ?>?parent_id=' + request,
                                                        dataType: 'json',
                                                        success: function (json) {
                                                            response($.map(json, function (item) {
                                                                return {
                                                                    label: item['product_name'],
                                                                    value: item['product_id']
                                                                }
                                                            }));
                                                        }
                                                    });
                                                },
                                                'select': function (item) {
                                                    $('input[name=\'disable_products\']').val('');
                                                    $('#disable_product' + item['value']).remove();
                                                    $('#disable_product').append('<div id="disable_product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="disable_product[]" value="' + item['value'] + '" /></div>');
                                                }
                                            });

                                            $('#disable_product').delegate('.fa-minus-circle', 'click', function () {
                                                $(this).parent().remove();
                                            });


                                            $('#category-filter').delegate('.fa-minus-circle', 'click', function () {
                                                $(this).parent().remove();
                                            });
                                            $('.date').datetimepicker({
                                                pickTime: false
                                            });
        </script>

    </body>

</html>