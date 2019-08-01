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
        <link rel="stylesheet" href="plugins/summernote/summernote.css">
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
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
                        限时秒杀管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url("TimelimitProduct/index"); ?>">限时秒杀</a>
                        </li>
                        <li class="active">编辑限时秒杀</li>
                    </ol>
                </section>
                <section class="content">
                    <!--提示框 -->
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">编辑限时秒杀</h3>
                                </div>
                                <form role="form" name="TimelimitProduct_form" id="TimelimitProduct" action="<?php echo site_url("TimelimitProduct/editTimelimitProduct")?>" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="">商品名称</label>
                                                <input type="text" class="form-control" id="" name="timelimit_product_name" value="<?php echo $timelimit['timelimit_product_name'] ?>" placeholder="商品名称或活动名称">
                                                <input type="hidden" class="form-control" value="<?php echo $timelimit['timelimit_product_id'] ?>"  name="timelimit_product_id" >
                                                <input type="hidden" class="form-control" value="<?php echo $timelimit['product_id'] ?>"  name="product_id" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label >限时秒杀价格</label>
                                                <input  type="tel" class="form-control" name="timelimit_price" value="<?php echo $timelimit['timelimit_price'] ?>" placeholder="活动商品价格"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label >限时秒杀库存</label>
                                                <input  type="number" class="form-control" name="timelimit_num" value="<?php echo $timelimit['timelimit_num'] ?>" placeholder="活动商品库存"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
										     <label class="col-sm-12 control-label" for="expiretime">开始时间</label>
                                            <div class="col-md-8">
                                                <div class="input-group date">
                                                    <input type="text" name="starttime" value="<?php if(empty($timelimit['starttime'])){ echo "";}else{ echo (date('Y-m-d',$timelimit['starttime'])." ".date('H:i:s',$timelimit['starttime']));} ?>" data-date-format="YYYY-MM-DD HH:mm:ss" placeholder="填写开始时间" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
										 <label class="col-sm-12 control-label" for="expiretime">结束时间</label>
                                            <div class="col-md-8">
                                                <div class="input-group date"><input type="text" name="endtime" value="<?php if(empty($timelimit['endtime'])){ echo "";}else{ echo (date('Y-m-d',$timelimit['endtime'])." ".date('H:i:s',$timelimit['endtime']));} ?>" class="form-control" placeholder="填写结束时间" data-date-format="YYYY-MM-DD HH:mm:ss" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>          
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label>排序</label>
                                                <input  type="number" class="form-control" id="" name="sort_order" value="<?php echo $timelimit['sort_order'] ?>" placeholder="数值越大越靠前">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label>商品描述</label>
                                                <textarea name="timelimit_description" id="timelimit_description" class="summernote"><?php echo $timelimit['timelimit_description'] ?></textarea>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('TimelimitProduct/index')?>'">返回</button>
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
        <script src="plugins/iCheck/icheck.min.js"></script>
        <script src="dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/common.js"></script>
        <script src="dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="plugins/bootstrap-datetimepicker/moment.js"></script>
        <script src="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="plugins/summernote/summernote.js"></script>
        <script src="plugins/summernote/lang/summernote-zh-CN.js"></script>
        <script src="plugins/summernote/upload.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
		$('.date').datetimepicker({
            pickTime: false
            });
		
                                            $('input[name=\'timelimit_product_name\']').autocomplete({
                                                'source': function (request, response) {
                                                    $.ajax({
                                                        url: '<?php echo site_url('Product/autoProduct'); ?>' + '?parent_id=' + encodeURIComponent(request),
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
                                                    $('input[name=\'timelimit_product_name\']').val(item['label']);
                                                    $('input[name=\'product_id\']').val(item['value']);
                                                    //获取选中ID商品的详情内容
                                                    $.ajax({
                                                        url: '<?php echo site_url('TimelimitProduct/autoProduct'); ?>' + '?product_id=' + item['value'],
                                                        dataType: 'json',
                                                        success: function (json) {
                                                            $('input[name=\'timelimit_price\']').val(json.price);
                                                            $('input[name=\'timelimit_num\']').val(json.store_number);
                                                            $('input[name=\'sort_order\']').val(json.sort);
                                                            $('input[name=\'timelimit_description\']').val(json.description);
                                                            $('#timelimit_description').summernote('code', json.description);
                                                        }
                                                    });
                                                }
                                            });

                                            $('#category-filter').delegate('.fa-minus-circle', 'click', function () {
                                                $(this).parent().remove();
                                            });
        </script>

    </body>

</html>