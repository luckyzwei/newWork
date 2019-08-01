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
                        商品管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class="active">商品管理</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">商品列表</h3>
                            <div class="box-tools">
                                <div class="has-feedback">
                                    <a  href="<?php echo site_url('Product/addProduct'); ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                    <button type="button" class="btn btn-default btn-sm" id="delete"><i class="fa fa-trash-o"></i></button>
                                    <!-- <a  href="<?php echo site_url('Product/productRecycle'); ?>" class="btn btn-success btn-big">回收站</a> -->
                                </div>
                            </div>
                        </div>
                        <form action="<?php echo site_url('Product/index') ?>" method="post" id="form-search">

                            <div class="row"  style="padding:5px;">
                                <div class="col-md-2">
                                    <label>状态</label> 
                                    <select name="filter_status" class="form-control select2">
                                        <option value="0">全部</option>
                                        <option value="1" <?php
                                        if (set_value('filter_status') == 1) {
                                            echo 'selected="selected"';
                                        }
                                        ?> >正常</option>
                                        <option value="2" <?php
                                        if (set_value('filter_status') == 2) {
                                            echo 'selected="selected"';
                                        }
                                        ?>>下架</option>
                                    </select>
                                     </div>

                                <div class="col-md-5 input-group">
                                    <label class="form-label">商品名称/编号/ID/价格</label>
                                    <input type="text" placeholder="商品名称/编号/ID/价格" class="form-control col-sm-5" name="filter_name"  value="<?php echo set_value('filter_name'); ?>" />
                                    
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-primary" style="margin-top:25px">搜索</button>
                                        <button type="button" class="btn btn-default" style="margin-top:25px" onclick="javascript:location.href='<?php echo site_url("Product/index")?>'">重置</button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>

                        <div class="box-body no-padding">

                            <div class="table-responsive select-messages">
                                <form action="<?php echo site_url('Product/deleteProduct') ?>" method="post" id="form-product">
                                    <table class="table table-hover table-striped" style="text-align:center">
                                        <thead>
                                        <td style="width:1%"><input type="checkbox" class="btn btn-default btn-sm checkbox-toggle"></td>
                                        <td class="goods-id">商品ID</td>
                                        <td class="goods-id">商品编号</td>
                                        <td class="goods-name">商品名称</td>
                                        <td class="goods-price">商品价格</td>
                                        <td class="goods-num">商品数量</td>
                                        <td class="goods-status">商品状态</td>
                                        <td class="goods-num">售/车/点/喜</td>
                                        <td class="goods-opreate">操作</td>
                                        <td class="goods-addDate">修改日期</td>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($list)) {
                                                foreach ($list as $item):
                                                    ?>
                                                    <tr>
                                                        <td><input name="selected[]" type="checkbox"  value="<?php echo $item['product_id']; ?>"></td>
                                                        <td class="goods-id"><?php echo $item['product_id']; ?></td>
                                                        <td class="goods-id"><?php echo $item['product_sn']; ?></td>
                                                      
                                                        <td class="goods-name" style="text-align: left;"><?php echo $item['product_name']; ?></td>
                                                        <td class="goods-price">￥<?php echo $item['price']; ?></td>
                                                        <td class="goods-num"><?php echo $item['store_number']; ?></td>
                                                        <td class="goods-status"><?php
                                                            if ($item['status'] == 2) {
                                                                echo "下架";
                                                            } elseif ($item['status'] == 1) {
                                                                echo "正常";
                                                            }
                                                            ?></td>
                                                        <td class="goods-num">
                                                            <?php echo empty($item['sale_number']) ? 0 : $item['sale_number']; ?>
                                                            /<?php echo empty($item['incart_number']) ? 0 : $item['incart_number']; ?>
                                                            /<?php echo empty($item['click_number']) ? 0 : $item['click_number']; ?>
                                                            /<?php echo empty($item['like_number']) ? 0 : $item['like_number']; ?>
                                                        </td>
                                                        <td class="goods-opreate">
                                                            <a  href="javascript:void(1)"  class="btn btn-success btn-xs" name="status" 
                                                                data="<?php echo $item['product_id'] ?>" status="<?php if($item['status'] == 1){echo 2;}else{echo 1;}?>">
                                                                <?php if($item['status'] == 1){echo "下架";}else{ echo "上架";}?>
                                                            </a>
                                                            <a  href="javascript:void(0)"  class="btn btn-primary btn-xs" name="recommend" 
                                                                data="<?php echo $item['product_id'] ?>" recommend="<?php echo $item['recommend']?0:1;?>">
                                                                <?php echo $item['recommend']?"取消推荐":"推荐"?>
                                                            </a>
                                                            <a  href="<?php echo site_url('Product/editProduct?product_id=' . $item['product_id']) . "&page=" . $page; ?>"  class="btn btn-primary btn-xs">编辑</a>
                                                        </td>
                                                        <td class="goods-addDate"><?php echo date("Y-m-d H:m", $item['updatetime']); ?></td>
                                                    </tr>

                                                    <?php
                                                endforeach;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <div class="box-footer no-padding">
                            <div class="mailbox-controls">
                                <div class="pull-left">
                                    总计：<?php echo $count; ?>
                                </div>
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
                $("[name='status']").click(function () {
                    var that=this;
                    $.post('<?php echo site_url("product/status") ?>', {"product_id": $(that).attr("data"),"status":$(that).attr("status")}, function (res) {
                           if(!res.error_code){
                               if($(that).attr("status")=="2"){
                                   $(that).text("上架");
                                   $(that).attr("status","1");
                                   location.reload();
                               }
                               else{
                                   $(that).text("下架");
                                   $(that).attr("status","2");
                                   location.reload();
                               }
                           }
                    },'json'
                    )
                })
                $("[name='recommend']").click(function () {
                    var that=this;
                    $.post('<?php echo site_url("product/recommend") ?>', {"product_id": $(that).attr("data"),"recommend":$(that).attr("recommend")}, function (res) {
                           if(!res.error_code){
                              console.log($(that).attr("recommend"));
                               if($(that).attr("recommend")=="0"){
                                   $(that).text("推荐");
                                   $(that).attr("recommend","1");
                               }
                               else{
                                   $(that).text("取消推荐");
                                   $(that).attr("recommend","0");
                               }
                           }
                    },'json'
                    )
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
                    if (selecteds == "") {
                        bootbox.alert({
                            message: "请您选择要删除的商品",
                            backdrop: true
                        });
                    } else {
                        bootbox.confirm({
                            title: "删除商品",
                            message: "您确定要删除商品ID：" + selecteds + '',
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

                $('input[name=\'filter_name\']').autocomplete({
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
                            },
                        });
                    },
                    'select': function (item) {
                        $('input[name=\'filter_name\']').val(item['label']);
                    }
                });
            });
        </script>
    </body>

</html>