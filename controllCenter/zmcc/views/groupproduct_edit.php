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
        <link rel="stylesheet" href="dist/css/ZMShop.min.css">
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
                        线上拼团管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url("GroupProduct/index"); ?>">线上拼团</a>
                        </li>
                        <li class="active">编辑商线上拼团</li>
                    </ol>
                </section>
                <section class="content">
                    <!--提示框 -->
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">编辑商线上拼团</h3>
                                </div>
                                <!-- form start -->
                                <form role="form" name="GroupProduct_form" id="GroupProduct" action="" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label>团购名称</label>
                                                <input  class="form-control" name="group_product_name" value="<?php echo $groupproduct['group_product_name'] ?>" placeholder="团购名称介绍"/>
                                                <input type="hidden" value="<?php echo $groupproduct['group_product_id'] ?>" name="group_product_id"> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="">商品名称</label>
                                                <input type="text" class="form-control" id="" name="product_name" value="<?php echo $name['product_name'] ?>" placeholder="商品名称">
                                                <input type="hidden" class="form-control" value="<?php echo $groupproduct['product_id'] ?>"  name='product_id' >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label >团购允许购买总数量(依旧会减商品库存)</label>
                                                <input  type="number" class="form-control" name="group_product_store" value="<?php echo $groupproduct['group_product_store'] ?>" placeholder="0不限制,当购买这么多数量后团活动会自动截至"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label >团购价格</label>
                                                <input  type="number" class="form-control" name="group_product_price" value="<?php echo $groupproduct['group_product_price'] ?>" placeholder="团购商品价格"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label >团购人数(2-100)</label>
                                                <input  type="number" class="form-control" name="group_user_num" value="<?php echo $groupproduct['group_user_num'] ?>" placeholder="团购商品人数"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label >单人限制购买数量</label>
                                                <input  type="number" class="form-control" name="group_user_num_every" value="<?php echo $groupproduct['group_user_num_every'] ?>" placeholder="0不限制,本次团购每人的限购数量"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label>开始时间</label>
                                                <div class="input-group date">
                                                    <input type="text" name="starttime" value="<?php echo empty($groupproduct['starttime']) ? "" : date('Y-m-d', $groupproduct['starttime']) ?>" placeholder="开始日期" data-date-format="YYYY-MM-DD" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label>结束时间</label>
                                                <div class="input-group date">
                                                    <input type="text" name="endtime" value="<?php echo empty($groupproduct['starttime']) ? "" : date('Y-m-d', $groupproduct['endtime']) ?>" placeholder="结束日期(不设置将不限时)" data-date-format="YYYY-MM-DD" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label >等待拼团时间(小时)</label>
                                                <input  type="number" class="form-control" name="group_time" value="<?php echo $groupproduct['group_time'] ?>" placeholder="成团时间"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label >开启凑团</label>
                                                <input  type="checkbox" class="form-control" name="show_group_list" value="1" <?php echo empty($groupproduct['show_group_list']) ? '' : 'checked' ?> />在商品详情页显示未成团列表,提高成团
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label >模拟成团</label>
                                                <input  type="checkbox" class="form-control" name="auto_group" value="1"  <?php echo empty($groupproduct['auto_group']) ? '' : 'checked' ?>/>当团时间快结束时,系统自动模拟成团
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label >开启预告</label>
                                                <input  type="checkbox" class="form-control" name="notice_group" value="1"  <?php echo empty($groupproduct['notice_group']) ? '' : 'checked' ?>/>在活动页面提前显示该商品公告
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label>团购描述(用于商品详情开始解释团购规则,可空,不影响商品详情正常展示)</label>
                                                <textarea name="group_description" id="group_description" class="summernote"><?php echo $groupproduct['group_description'] ?></textarea>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('GroupProduct/index') ?>'">返回</button>
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
        <script src="plugins/summernote/summernote.js"></script>
        <script src="plugins/summernote/lang/summernote-zh-CN.js"></script>
        <script src="plugins/summernote/upload.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
                                            $('input[name=\'product_name\']').autocomplete({
                                                'source': function (request, response) {
                                                    $.ajax({
                                                        url: '<?php echo site_url('Product/autoProduct'); ?>' + '?product_id=' + encodeURIComponent(request),
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
                                                    $('input[name=\'product_name\']').val(item['label']);
                                                    $('input[name=\'product_id\']').val(item['value']);
                                                }
                                            });

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
        </script>

    </body>

</html>