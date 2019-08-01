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
        <link href="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="dist/css/ZMShop.min.css">
        <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
        <link rel="stylesheet" href="plugins/summernote/summernote.css">
        <link rel="stylesheet" href="dist/css/skins/all-skins.min.css">
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
        <style type="text/css">
            #myModalLabel {
            }
        </style>
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
                <?php include 'public_header.php'; ?>
            </header>
            <aside class="main-sidebar">
                <?php include 'public_left.php'; ?>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        充值策略管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/index.php/Welcome/index"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>   
                            <a href="<?php echo site_url('RechargeStrategy/index') ?>">充值策略管理</a>
                        </li>
                        <li class="active">编辑充值策略</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">编辑充值策略</h3>
                                </div>
                                <form role="form" action="<?php echo site_url('RechargeStrategy/addRechargeStrategy'); ?>" name="adminoption_form" id="adminoption" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label" for="strategy_name">策略名称</label>
                                            <div class="col-md-8">
                                                <input type="text" name="strategy_name" id="marketing_name" class="form-control" placeholder="策略名称" value="<?php echo $strategy_name; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group" container='marketingtrigger' id='min_amount'>
                                            <label class="col-sm-1 control-label" for="min_amount"> 满足金额</label>
                                            <div class="col-md-8">
                                                <input  name="min_amount" id='min_amount' class="form-control" value="<?php echo $min_amount; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label" for="give_type">赠送类型</label>
                                            <div class="col-md-8">
                                                <select id="input-type" name="give_type" class="form-control" style="width:20%">
                                                    <option value="give_amount" <?php if ($give_type == 'give_amount') echo 'selected'; ?>>赠送金额</option>
                                                    <option style="display:none" value="give_intergal" <?php if ($give_type == 'give_intergal') echo 'selected'; ?>>赠送积分</option>
                                                    <option value="give_product" <?php if ($give_type == 'give_product') echo 'selected'; ?>>赠送商品</option>
                                                    <option style="display:none" value="give_coupon" <?php if ($give_type == 'give_coupon') echo 'selected'; ?>>赠送优惠卷</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" container='marketing' id='div_give_amount'>
                                            <label for="input-marketing_discount" class="col-sm-1 control-label">赠送金额</label>
                                            <div class="col-md-8">
                                                <input  name="give_amount" placeholder="(0-1为百分比赠送，大于1为赠送该数值)" class="form-control" id="give_amount" value="<?php echo $give_amount; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group" container='marketing' id='div_give_product'>
                                            <label for="give_product" class="col-sm-1 control-label" >赠送商品</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="auto_product" name="auto_product" placeholder="关联商品">
                                                <div id="give-product" class="well well-sm" style="height: 150px; overflow: auto;">
                                                    <?php if(!empty($give_products)) foreach ($give_products as $give_productitem): ?>
                                                        <div id="give-product<?php echo $give_productitem['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $give_productitem['product_name']; ?>
                                                            <input type="hidden" name="give_product[]" value="<?php echo $give_productitem['product_id']; ?>" />
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" container='marketing' id='div_give_intergal'>
                                            <label for="input-give_intergal" class="col-sm-1 control-label">赠送积分</label>
                                            <div class="col-md-8">
                                                <input type="number" name="give_intergal" placeholder="(0-1为百分比赠送，大于1为赠送该数值)" class="form-control" id="give_intergal" value="<?php echo $give_intergal; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group" container='marketing' id='div_give_coupon'>
                                            <label for="input-marketing_coupon" class="col-sm-1 control-label" >赠送优惠券</label>
                                            <div class="col-md-8">
                                                <select  name="give_coupon" id="give_coupon" class="form-control">
                                                    <option value="0">请选择赠送的优惠券</option>  
                                                    <?php foreach ($couponLists as $couponList): ?>
                                                        <option value="<?php echo $couponList['coupon_id'] ?>"><?php echo $couponList['coupon_name']; ?></option>
                                                    <?php endforeach ?>                     
                                                </select>
                                                <div class="text-danger"></div>             
                                            </div>
                                        </div>
                                        <div class="form-group" >
                                            <label class="col-sm-1 control-label" for="expiretime">开始时间</label>
                                            <div class="col-md-2">
                                                <div class="input-group date">
                                                    <input type="text" name="starttime" value="<?php if(!empty($starttime)) echo date('Y-m-d H:i:s', $starttime); ?>" placeholder="开始日期" data-date-format="YYYY-MM-DD HH:mm:ss" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label" for="expiretime">结束时间</label>
                                            <div class="col-md-2">
                                                <div class="input-group date"><input type="text" name="endtime" value="<?php if(!empty($endtime)) echo date('Y-m-d H:i:s', $endtime); ?>" placeholder="结束时间" data-date-format="YYYY-MM-DD HH:mm:ss" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>          
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label class="col-sm-1 control-label" for="level">优先级</label>
                                            <div class="col-md-8">
                                                <input type="number" name="level" id="level" class="form-control" placeholder="优先级" value="<?php echo $level; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <input type='hidden' name='strategy_id' value="<?php echo isset($strategy_id) ? $strategy_id : 0; ?>">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('RechargeStrategy/index') ?>'">返回</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                <?php include 'public_footer.php'; ?>
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
        <script src="plugins/summernote/summernote.js"></script>
        <script src="plugins/summernote/lang/summernote-zh-CN.js"></script>
        <script src="plugins/summernote/upload.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootbox.js"></script>
        <script src="plugins/bootstrap-datetimepicker/moment.js"></script>
        <script src="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript">
                                            $(function () {
                                                $("[container='marketing']").hide();
                                                $("#div_" + $("#give_type").val()).show();
                                                if ($("#input-type").val() == "give_amount") {
                                                    $("#div_give_amount").show();
                                                    $("#div_give_intergal").hide();
                                                    $("#div_give_product").hide();
                                                    $("#div_give_coupon").hide();
                                                }

                                                if ($("#input-type").val() == "give_intergal") {
                                                    $("#div_give_amount").hide();
                                                    $("#div_give_intergal").show();
                                                    $("#div_give_product").hide();
                                                    $("#div_give_coupon").hide();
                                                }
                                                if ($("#input-type").val() == "give_product") {
                                                    $("#div_give_amount").hide();
                                                    $("#div_give_intergal").hide();
                                                    $("#div_give_product").show();
                                                    $("#div_give_coupon").hide();
                                                }
                                                if ($("#input-type").val() == "give_coupon") {
                                                    $("#div_give_amount").hide();
                                                    $("#div_give_intergal").hide();
                                                    $("#div_give_product").hide();
                                                    $("#div_give_coupon").show();
                                                }

                                                $("#input-type").change(function () {
                                                    console.log($(this).val());
                                                    if ($("#input-type").val() == "give_amount") {
                                                    $("#div_give_amount").show();
                                                    $("#div_give_intergal").hide();
                                                    $("#div_give_product").hide();
                                                    $("#div_give_coupon").hide();
                                                }

                                                if ($("#input-type").val() == "give_intergal") {
                                                    $("#div_give_amount").hide();
                                                    $("#div_give_intergal").show();
                                                    $("#div_give_product").hide();
                                                    $("#div_give_counpon").hide();
                                                }
                                                if ($("#input-type").val() == "give_product") {
                                                    $("#div_give_amount").hide();
                                                    $("#div_give_intergal").hide();
                                                    $("#div_give_product").show();
                                                    $("#div_give_coupon").hide();
                                                }
                                                if ($("#input-type").val() == "give_coupon") {
                                                    $("#div_give_amount").hide();
                                                    $("#div_give_intergal").hide();
                                                    $("#div_give_product").hide();
                                                    $("#div_give_coupon").show();
                                                }
                                                })
                                            })

        </script>
        <script type="text/javascript">
            $('.date').datetimepicker({
                pickTime: false
            });
        </script>
        <script type="text/javascript">
            $('input[name=\'auto_product\']').autocomplete({
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
                    $('input[name=\'auto_product\']').val('');
                    $('#give-product' + item['value']).remove();
                    $('#give-product').append('<div id="give-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="give_product[]" value="' + item['value'] + '" /></div>');
                }
            });
            $('#give-product').delegate('.fa-minus-circle', 'click', function () {
                $(this).parent().remove();
            });
     </script>

    </body>

</html>


