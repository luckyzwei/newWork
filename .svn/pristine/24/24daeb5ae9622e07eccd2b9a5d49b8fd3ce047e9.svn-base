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
                        商品回收站
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class="active">商品回收站</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">商品列表</h3>
                        </div>
                        <form action="<?php echo site_url('ProductRecycle/index') ?>" method="post" id="form-search">
                            <div class="has-feedback">
                                <div class="form-group col-md-8">
                                    <label>商品名称</label>
                                    <input type="text" placeholder="商品名称"  class="form-control col-sm-8" name="product_name"  value="<?php echo set_value('product_name'); ?>" />
                                </div>
                                <div class="form-group col-md-1">
                                    <label>&nbsp;</label>
                                    <button stype="submit" class="btn btn-success">搜索</button>
                                </div>
                            </div>
                        </form>

                        <div class="box-body no-padding">

                            <div class="table-responsive select-messages">
                                    <table class="table table-hover table-striped" style="text-align:center">
                                        <thead>
                                        <td class="goods-id">商品ID</td>
                                        <td class="goods-name">商品名称</td>
                                        <td class="goods-price">商品价格</td>
                                        <td class="goods-num">商品数量</td>
                                        <td class="goods-num">售/车/点/喜</td>
                                        <td class="goods-opreate">操作</td>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($list)) { ?>
                                                <tr>
                                                    <td colspan="6">回收站是空的 oooo</td>
                                                </tr>
                                                <?php
                                            } else {
                                                foreach ($list as $item):
                                                    ?>
                                                    <tr>
                                                        <td class="goods-id"><?php echo $item['product_id']; ?></td>
                                                        <td class="goods-name" style="text-align: left;"><?php echo $item['product_name']; ?></td>
                                                        <td class="goods-price">￥<?php echo $item['price']; ?></td>
                                                        <td class="goods-num"><?php echo $item['store_number']; ?></td>
                                                        <td class="goods-num">
                                                            <?php echo empty($item['sale_number']) ? 0 : $item['sale_number']; ?>
                                                            /<?php echo empty($item['incart_number']) ? 0 : $item['incart_number']; ?>
                                                            /<?php echo empty($item['click_number']) ? 0 : $item['click_number']; ?>
                                                            /<?php echo empty($item['like_number']) ? 0 : $item['like_number']; ?>
                                                        </td>
                                                        <td class="goods-opreate">
                                                            <a  href="javascript:void(0)"  class="btn btn-success btn-xs" name="recovery" data="<?php echo $item['product_id'] ?>">还原</a>
                                                            <a  href="javascript:void(0)"  class="btn btn-danger btn-xs" name="thorough" data="<?php echo $item['product_id'] ?>">彻底删除</a>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                endforeach;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
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
        <script>
            $(function () {
                $("[name='recovery']").click(function () {
                    var that=this;
                    $.post(
                        '<?php echo site_url("ProductRecycle/recoveryProduct") ?>', 
                        {"product_id": $(that).attr("data")}, 
                        function (res) {
                            if(res.error_code == 1){
                                alert('还原失败');
                            }else{
                                alert('还原成功');
                                location.reload();
                            }
                    },'json')
                })
                
                 $("[name='thorough']").click(function () {
                    var that=this;
                    $.post(
                        '<?php echo site_url("ProductRecycle/deleteProduct") ?>', 
                        {"product_id": $(that).attr("data")}, 
                        function (res) {
                            if(res.error_code == 1){
                                alert('删除失败');
                            }else{
                                alert('删除成功');
                                location.reload();
                            }
                    },'json')
                })


                // $("#delete").click(function () {

                //     var str = "";
                //     var selecteds = "";
                //     $("input[name='selected[]']:checkbox").each(function () {
                //         if (true == $(this).is(':checked')) {
                //             str += $(this).val() + ",";
                //         }
                //     });
                //     if (str.substr(str.length - 1) == ',') {
                //         selecteds = str.substr(0, str.length - 1);
                //     }
                //     console.log(selecteds);
                //     if (selecteds == "") {
                //         bootbox.alert({
                //             message: "请您选择要删除的商品",
                //             backdrop: true
                //         });
                //     } else {
                //         bootbox.confirm({
                //             title: "删除商品",
                //             message: "您确定要删除商品ID：" + selecteds + '',
                //             buttons: {
                //                 cancel: {
                //                     label: '<i class="fa fa-times"></i> 取消'
                //                 },
                //                 confirm: {
                //                     label: '<i class="fa fa-check"></i> 确认',
                //                 }
                //             },
                //             callback: function (result) {
                //                 if (result) {
                //                     $('#form-product').submit();
                //                 } else {
                //                 }
                //             }
                //         });
                //     }
                // });

                $('input[name=\'product_name\']').autocomplete({
                    'source': function (request, response) {
                        $.ajax({
                            url: '<?php echo site_url('ProductRecycle/autoDelProduct'); ?>' + '?product_id=' + encodeURIComponent(request),
                            dataType: 'json',
                            success: function (json) {
                                response($.map(json, function (item) {
                                    return {
                                        label: item['product_name'],
                                        value: item['product_id']
                                    }
                                }));
                            },
                        });
                    },
                    'select': function (item) {
                        $('input[name=\'product_name\']').val(item['label']);
                    }
                });
            });
        </script>
    </body>

</html>