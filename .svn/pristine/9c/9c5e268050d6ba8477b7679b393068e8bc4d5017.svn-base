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
                    <h1>营销策略管理</h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>  
                            <a href="<?php echo site_url('Marketing/index') ?>">营销策略管理</a>
                        </li>
                        <li class="active">添加营销策略</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">添加营销策略</h3>
                                </div>
                                <form role="form" action="<?php echo site_url('Marketing/addMarketing'); ?>" name="adminoption_form" id="adminoption" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label" for="marketing_name">策略名称</label>
                                            <div class="col-md-8">

                                                <input type="text" name="marketing_name" id="marketing_name" class="form-control" placeholder="策略名称" value="<?php echo set_value('marketing_name') ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label  class="col-sm-1 control-label" for="marketing_type">策略类型</label>
                                            <div class="col-md-8">
                                                <select id="input-type" name="marketing_type" class="form-control" style="width:15%">
                                                    <option value="O" selected>订单策略</option>
                                                    <option value="P">商品策略</option>

                                                </select> 
                                            </div>
                                        </div>
                                        <div class="form-group" container='marketingtrigger' id='marketingtiggerprice'>
                                            <label for="" class="col-sm-1 control-label"> 满足金额</label>
                                            <div class="col-md-8">

                                                <input type="number" name="marketing_trigger_price" id='marketing_trigger_price' class="form-control" value="<?php echo set_value('marketing_trigger_price') ?>">
                                            </div>
                                        </div>
                                        <div class="form-group" id="marketingtirggernumber" container='marketingtrigger'> 
                                            <label for="input-marketing_trigger_number" class="col-sm-1 control-label"> 满足件数</label>    
                                            <div class="col-md-8">
                                                <input type="number" name="marketing_trigger_number" id='marketing_trigger_number' class="form-control" value="<?php echo set_value('marketing_trigger_number') ?>">
                                            </div>
                                        </div>
                                        <!--div class="form-group" id="marketingparallel" container='marketingparallel'>
                                            <label for="input-marketing_parallel" class="col-sm-1 control-label">策略并行</label>
                                            <div class="col-md-8">
                                                <input type="checkbox" name="marketing_parallel" value="0" id="input-marketing-parallel" class="form-control"/>
                                                <input type='hidden' name='marketing_id' value="">
                                                <span>(关于策略的并行！策略并行：是指在商品策略下 该商品同时享受商品策略和订单策略，无并行:是该商品如果有商品策略 则不享受订单策略)</span>
                                            </div>
                                        </div-->
                                        <div class="form-group">
                                            <label for="marketing_kind" class="col-sm-1 control-label">优惠方式</label>
                                            <div class="col-md-8">
                                                <select id="marketing_kind" name="marketing_kind" class="form-control" style="width:15%">
                                                    <option value="achieve_discount">满减金额</option>
                                                    <option value="achieve_give">满赠商品</option>
                                                    <option value="achieve_coupon">满赠优惠券</option>
                                                    <option value="achieve_reward">满赠积分</option>
                                                    <option value="achieve_freeshipping">满额包邮</option>  
                                                </select> 
                                            </div>
                                        </div>
                                        <!-- 隐藏优惠方式显示开始 -->
                                        <div class="form-group" container='marketing' id='achieve_discount'>
                                            <label class="col-sm-1 control-label" for="input-marketing_discount">优惠金额</label>
                                            <div class="col-md-8">
                                                <input type="number" name="marketing_discount" placeholder="优惠金额" class="form-control" id="marketing_discount" value="<?php echo set_value('marketing_discount') ?>">
                                            </div>
                                        </div>
                                        <div class="form-group" container='marketing' id='achieve_give'>
                                            <label class="col-sm-1 control-label" for="give_product">满赠商品</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="give_products" name="give_products" placeholder="关联商品">
                                                <div id="give-product" class="well well-sm" style="height: 150px; overflow: auto;">
                                                    <?php if (!empty($marketing['give_product'])) { ?>
                                                        <?php foreach ($marketing['give_product'] as $give_product): ?>
                                                            <div id="give-product<?php echo $give_product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $give_product['name']; ?>
                                                                <input type="hidden" name="give_product[]" value="<?php echo $give_product['product_id']; ?>" />
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-group" container='marketing' id='achieve_coupon'>
                                            <label class="col-sm-1 control-label" for="input-marketing_coupon">满赠优惠券</label>
                                            <div class="col-md-8">
                                                <select  name="marketing_coupon" id="input-marketing_coupon" class="form-control">

                                                    <option value="0">请选择赠送的优惠券</option>  
                                                    <?php foreach ($couponLists as $couponList): ?>
                                                        <option value="<?php echo $couponList['coupon_id'] ?>"><?php echo $couponList['coupon_name']; ?></option>
                                                    <?php endforeach ?>

                                                </select>
                                                <div class="text-danger"></div>             
                                            </div>
                                        </div>

                                        <div class="form-group required" container='marketing' id='achieve_reward'>
                                            <label class="col-sm-1 control-label" for="input-marketing_reward">满赠积分</label>
                                            <div class="col-md-8">
                                                <input type="number" name="marketing_reward" placeholder="赠送积分" class="form-control" id="marketing_reward" value="<?php echo set_value('marketing_reward') ?>">
                                            </div>
                                        </div>
                                        <!--<div class="form-group required"  container='marketing' id='achieve_freeshipping'>
                                            <label class="col-sm-1 control-label" for="input-marketing_shipping">满减运费</label>
                                           <div class="col-md-8">
                                                <input name="marketing_shipping" placeholder="满减运费" class="form-control" id="marketing_shipping" value="">
                                               
                                                <div class="text-danger"></div>
                                            </div>
                                        </div>-->
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label" for="input-user-group"><span data-toggle="tooltip" title="适用的用户分组">适用群组</span></label>
                                            <div class="col-md-8">
                                                <select name="user_group" id="marketing_user_group" class="form-control">
                                                    <option value='0'>所有群组</option>

                                                    <?php foreach ($usergroups as $usergroup) : ?>
                                                        <option value="<?php echo $usergroup['user_group_id'] ?>"><?php echo $usergroup['user_group_name'] ?></option>
                                                    <?php endforeach ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-1 control-label" for="input-category">
                                                <select name='category_applyorno'>
                                                    <option value='1'>适用</option>
                                                    <option value='0'>例外</option>
                                                </select>
                                                分类</label>
                                            <div class="col-md-8">
                                                <input type="text" name="marketing_categorys" value="" placeholder="商品分类" id="input-category" class="form-control" />

                                                <div id="marketing-category" class="well well-sm" style="height: 150px; overflow: auto;">
                                                    <?php if (!empty($marketing['marketing_category'])) { ?>
                                                        <?php foreach ($marketing['marketing_category'] as $marketing_category): ?>
                                                            <div id="marketing-category<?php echo $marketing_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $marketing_category['name']; ?>
                                                                <input type="hidden" name="marketing_category[]" value="<?php echo $marketing_category['category_id']; ?>" />
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-1 control-label" for="input-product">
                                                <select name='product_applyorno'>
                                                    <option value='1'>适用</option>
                                                    <option value='0'>例外</option>
                                                </select>商品
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" name="marketing_products" value="" placeholder="商品设定" id="input-product" class="form-control" />
                                                <div id="marketing-product" class="well well-sm" style="height: 150px; overflow: auto;">
                                                    <?php if (!empty($marketing['marketing_product'])) { ?>
                                                        <?php foreach ($marketing['marketing_product'] as $marketing_product): ?>
                                                            <div id="marketing-product<?php echo $marketing_product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $marketing_product['name']; ?>
                                                                <input type="hidden" name="marketing_product[]" value="<?php echo $marketing_product['product_id']; ?>" />
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="expiretime" class="col-sm-1 control-label">开始时间</label>  
                                            <div class="col-md-8">
                                                <div class="input-group date"><input type="text" name="starttime" value="" placeholder="开始日期" data-date-format="YYYY-MM-DD HH:mm:ss" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>       
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="expiretime" class="col-sm-1 control-label">结束时间</label>
                                            <div class="col-md-8">
                                                <div class="input-group date"><input type="text" name="endtime" value="" placeholder="结束日期" data-date-format="YYYY-MM-DD HH:mm:ss" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--div class="form-group">
                                            <label for="marketing_level" class="col-sm-1 control-label">优先级</label>
                                            <div class="col-md-8">
                                                <input type="number" name="marketing_level" id="marketing_level" class="form-control" placeholder="优先级" value="<?php echo set_value('marketing_level') ?>">
                                            </div>
                                        </div-->
                                        <div class="form-group">
                                            <label for="marketing_level" class="col-sm-1 control-label">策略分组</label>
                                            <div class="col-md-8">
                                                <input type="text" name="marketing_group" id="marketing_group" class="form-control" placeholder="策略分组" value="<?php echo set_value('marketing_level') ?>">
                                            </div>
                                        </div>
                                    </div>              
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">保存</button>    
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('Marketing/index')?>'">返回</button>
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
                                                    $("#" + $("#marketing_kind").val()).show();

                                                    if ($("#input-type").val() == "P") {
                                                        $("#marketingtirggernumber").show();
                                                        $("#marketingparallel").show();
                                                        $("#marketingtirggerprice").hide();
                                                    }

                                                    if ($("#input-type").val() == "O") {
                                                        $("#marketingtirggernumber").hide();
                                                        $("#marketingparallel").hide();
                                                        $("#marketingtiggerprice").show();
                                                    }

                                                    $("#input-type").change(function () {
                                                        console.log($(this).val());
                                                        if ($(this).val() == "P") {
                                                            $("#marketingtirggernumber").show();
                                                            $("#marketingparallel").show();
                                                            $("#marketingtiggerprice").hide();

                                                        }
                                                        if ($(this).val() == "O") {
                                                            $("#marketingtirggernumber").hide();
                                                            $("#marketingparallel").hide();
                                                            $("#marketingtiggerprice").show();
                                                        }
                                                    })

                                                    $("#marketing_kind").change(function () {
                                                        $("[container='marketing']").hide();
                                                        $("#" + $(this).val()).show();
                                                        console.log($(this).val());
                                                    })
                                                })

        </script>
        <script type="text/javascript">
            $('.date').datetimepicker({
                pickTime: false
            });
        </script>
            <script type="text/javascript">
  $('input[name=\'give_products\']').autocomplete({
        'source': function (request, response) {
            $.ajax({
                url: '<?php echo site_url('Product/autoProduct') ?>?product_id=' + request,
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
            $('input[name=\'give_products\']').val('');

            $('#give-product' + item['value']).remove();

            $('#give-product').append('<div id="give-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="give_product[]" value="' + item['value'] + '" /></div>');
        }
    });

    $('#give-product').delegate('.fa-minus-circle', 'click', function () {
        $(this).parent().remove();
    });
</script>


                    <script type="text/javascript">
                        // 例外适用商品关联
                        $('input[name=\'marketing_products\']').autocomplete({
                            'source': function (request, response) {
                                $.ajax({
                                    url: '<?php echo site_url('Product/autoProduct') ?>?product_id=' + request,
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
                                $('input[name=\'marketing_products\']').val('');

                                $('#marketing-product' + item['value']).remove();

                                $('#marketing-product').append('<div id="for-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="marketing_product[]" value="' + item['value'] + '" /></div>');
                            }
                        });

                        $('#marketing-product').delegate('.fa-minus-circle', 'click', function () {
                            $(this).parent().remove();
                        });

                        // Category 适用，例外分类关联
                        $('input[name=\'marketing_categorys\']').autocomplete({
                            'source': function (request, response) {
                                $.ajax({
                                    url: '<?php echo site_url('Category/autoCategory') ?>?search_name=' + request,
                                    dataType: 'json',
                                    success: function (json) {
                                        response($.map(json, function (item) {
                                            return {
                                                label: item['name'],
                                                value: item['category_id']
                                            }
                                        }));
                                    }
                                });
                            },
                            'select': function (item) {
                                $('input[name=\'marketing_categorys\']').val('');

                                $('#marketing-category' + item['value']).remove();

                                $('#marketing-category').append('<div id="mareting-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="marketing_category[]" value="' + item['value'] + '" /></div>');
                            }
                        });

                        $('#marketing-category').delegate('.fa-minus-circle', 'click', function () {
                            $(this).parent().remove();
                        });
                        </script>

                    </body>

                </html>


