<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title ?></title>
        <base href = "<?php echo base_url(); ?>zmcc/views/"/>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
        <link  rel="stylesheet" href="plugins/select2/select2.min.css">
        <link rel="stylesheet" href="plugins/ionicons-2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="dist/css/ZMShop.min.css">
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
                        供货商管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>  
                            <a href="<?php echo site_url('Supplier/index') ?>">供货商管理</a>
                        </li>
                        <li class="active">供货商管理</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">新增供货商</h3>
                                </div>
                                <form role="form" name="supplier_form"  action="<?php echo site_url('Supplier/addSupplier') ?>" method="post">
                                    <div class="box-body"> 
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="exampleInputNickName1">供货商名称(简介)</label>
                                                <input type="text" class="form-control" name="contact" value="<?php echo set_value('contact'); ?>" id="exampleInputNickName1" placeholder="供货商名称(简介)">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="exampleInputEmail1">选择用户</label>
                                                <input type="text" class="form-control" id="" name="nickname" value="<?php echo set_value('nickname') ?>" placeholder="请选择添加哪位用户为供货商">
                                                <input type="hidden" class="form-control" value="<?php echo set_value('user_id') ?>"  name='user_id' >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="exampleInputTel1">电话</label>
                                                <input type="number" class="form-control" name="moblie" value="<?php echo set_value('moblie'); ?>" id="exampleInputTel1" placeholder="11位">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="exampleInputCall1">联系人</label>
                                                <input type="text" class="form-control" name="name" value="<?php echo set_value('name'); ?>" id="exampleInputCall1" placeholder="填写供货商真实姓名">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="address">供货商地址</label>
                                                <div class="main" style="margin-bottom: 10px;;">
                                                    <select id="loc_province" class="col-md-2" name="province_id" ></select>
                                                    <select id="loc_city" class="col-md-2" name="city_id" ></select>
                                                    <select id="loc_town" class="col-md-2" name="districe_id" ></select>
                                                </div>
                                                <input type="text" class="form-control" name="address" value="<?php echo set_value('address'); ?>"  placeholder="填写供货商的详细地址">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="exampleInputTime1">结算时间</label>
                                                <input type="number" class="form-control" name="settlement_rate" value="<?php echo set_value('settlement_rate'); ?>" id="exampleInputTime1" placeholder="结算频次单位为天，例如3天表示仅结算三天前的订单">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="exampleInputTime1">审核状态</label>
                                                <input type="checkbox" class="form-control" name="status">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">保存</button>  
                                        <button type="button" class="btn btn-prompt" onclick="location.href = ' <?php echo site_url('Supplier/index') ?>'">返回</button>
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
        <script src="plugins/select2/select2.full.min.js"></script>
        <script src="dist/js/location.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/area.js" type="text/javascript" charset="utf-8"></script>
        <script src="plugins/iCheck/icheck.min.js"></script>
        <script src="dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/common.js"></script>
        <script type="text/javascript">
                                            $('input[type="radio"].flat-blue').iCheck({
                                                radioClass: 'iradio_flat-blue'
                                            });

                                            $('input[name=\'nickname\']').autocomplete({
                                                'source': function (request, response) {
                                                    $.ajax({
                                                        url: '<?php echo site_url('Coupon/autoUser'); ?>' + '?user_id=' + request,
                                                        dataType: 'json',
                                                        success: function (json) {
                                                            response($.map(json, function (item) {
                                                                return {
                                                                    label: item['nickname'],
                                                                    value: item['user_id']
                                                                }
                                                            }));
                                                        }
                                                    });
                                                },
                                                'select': function (item) {
                                                    $('input[name=\'nickname\']').val(item['label']);
                                                    $('input[name=\'user_id\']').val(item['value']);
                                                }
                                            });

        </script>
    </body>

</html>