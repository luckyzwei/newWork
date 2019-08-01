<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ZMShop | 博客管理</title>
        <base href = "<?php echo base_url(); ?>zmcc/views/"/>
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
                        博客管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class="active">博客列表</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">博客列表</h3>
                            <div class="box-tools">
                                <div class="has-feedback">
                                    <a href="<?php echo base_url('Blog/addBlog'); ?>"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button></a>
                                    <button type="button" class="btn btn-default btn-sm" id="delete"><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="box-body no-padding">
                            <div class="mailbox-controls">
                                <div class="has-feedback" style="margin: 0;">
                                    <form action="<?php echo site_url('Blog/index')?>" method="post">
                                        <div class="form-group col-md-5">
                                            <label>博客名称</label>
                                            <input type="text" class="form-control" name="name"  value="<?php echo set_value('name')?>" placeholder="博客名称"/>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label>博客状态</label>
                                           <select name="status" class="form-control select2">
                                                <option <?php
                                                if (set_value('status') == "") {
                                                    echo 'selected="selected"';
                                                }
                                                ?> value="">*</option>
                                                <option <?php
                                                if (set_value('status') == 2) {
                                                    echo 'selected="selected"';
                                                }
                                                ?> value="2">未发布</option>
                                                <option <?php
                                                if (set_value('status') == 1) {
                                                    echo 'selected="selected"';
                                                }
                                                ?> value="1">已发布</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>&nbsp;</label>
                                            <input type="submit" class="btn btn-success"  value="搜索" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive select-messages">
                                <form action="<?php echo site_url('Blog/deleteBlog') ?>" id="form-blog" method="post">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                        <td style="width: 1%"><input type="checkbox" class="btn btn-default btn-sm checkbox-toggle"></td>
                                        <td class="blog-id">博客ID</td>
                                        <td class="blog-name">博客名称</td>
                                        <td class="category_name">分类名称</td>
                                        <td class="image">图像</td>
                                        <td class="status">状态</td>
                                        <td class="hits">点击量</td>
                                        <td class="sort_order">排序</td>
                                        <td class="blog-opreate">操作</td>
                                        <td class="updatetime">修改日期</td>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($list as $row){?>
                                                <tr>
                                                    <td><input name="selected[]" type="checkbox" value="<?php echo $row['blog_id'] ?>"></td>
                                                    <td class="blog-id"><?php echo $row['blog_id'] ?></td>
                                                    <td class="blog-name"><?php echo $row['blog_name'] ?></td>
                                                    <td class="category_name"><?php echo $row['category_name'] ?></td>
                                                    <td class="image"><img style="width: 30px;height: 30px;" src="<?php echo $row['image']?>"/></td>         
                                                    <td class="status">
                                                        <?php 
                                                            if($row['status'] == 2) {
                                                                echo "未发布";
                                                            } else if($row['status'] == 1) {
                                                                echo "已发布";
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="hits"><?php echo $row['hits'] ?></td>
                                                    <td class="sort_order"><?php echo $row['sort_order'] ?></td>
                                                    <td class="goods-opreate"><a href="<?php echo site_url('Blog/editBlog/'.$row['blog_id']);?>" class="btn btn-primary btn-xs">编辑</a></td>
                                                   
                                                    <td class="updatetime"><?php echo date("Y-m-d",$row['updatetime']) ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </form>
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
                        message: "请您选择要删除的博客",
                        backdrop: true
                    });
                } else {
                    bootbox.confirm({
                        title: "删除博客",
                        message: "您确定要删除博客" + selecteds + '',
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
                                $('#form-blog').submit();
                            } 
                        }
                    });
                }
            })
        </script>
    </body>
</html>

