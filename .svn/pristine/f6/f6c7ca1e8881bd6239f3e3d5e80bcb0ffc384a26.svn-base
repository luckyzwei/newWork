<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ZMShop | 文章管理</title>
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
                        文章管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class="active">文章管理</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">文章列表</h3>
                            <div class="box-tools">
                                <div class="has-feedback">
                                    <a href="<?php echo site_url('Article/addArticle'); ?>"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button></a>
                                    <button type="button" class="btn btn-default btn-sm" id="delete"><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="box-body no-padding">
                            <div class="mailbox-controls">
                                <div class="has-feedback" style="margin: 0;">
                                    <form action="<?php echo site_url('Article/index') ?>" method="post" id="form-search">
                                        <div class="form-group col-md-5">
                                            <label>文章标题</label>
                                            <input type="text" class="form-control" name="name"  value="<?php echo set_value('name'); ?>" placeholder="文章标题"/>
                                        </div>
                                        
                                        <div class="form-group col-md-5">
                                            <label>文章作者</label>
                                            <input type="text" class="form-control" name="article_author"  value="<?php echo set_value('article_author'); ?>" placeholder="文章作者"/>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>&nbsp;</label>
                                            <input type="submit" class="btn btn-success"  value="搜索" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive select-messages">
                                <form action="<?php echo site_url('Article/deleteArticle') ?>" method="post" id="form-article">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <td style="width: 1%"><input type="checkbox" class="btn btn-default btn-sm checkbox-toggle"></td>
                                            <td class="article-id">文章ID</td>
                                            <td class="image">文章图片</td>
                                            <td class="article-name">文章标题</td>
                                            <td class="category_name">分类名称</td>
                                            <td class="author">文章作者</td>
                                            <td class="article-opreate">操作</td>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($list as $row): ?>
                                                <tr>
                                                    <td><input name="selected[]" type="checkbox" value="<?php echo $row['article_id'] ?>"></td>

                                                    <td class="article-id"><?php echo $row['article_id'] ?></td>
                                                    <td class="image"><img style="width: 30px;height: 30px;" src="<?php echo site_url()."upload/image".$row['images'] ?>"/></td>
                                                    <td class="article-name"><?php echo $row['article_name'] ?></td>
                                                    <td class="category_name"><?php echo $row['category_name'] ?></td>
                                                    <td class="author"><?php echo $row['author'] ?></td>
                                                    
                                                    <td class="article-opreate"><a href="<?php echo site_url('Article/editArticle/'.$row['article_id']);?>" class="btn btn-primary btn-xs">编辑</a></td>
                                                </tr>
                                            <?php endforeach; ?>
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
                        message: "请您选择要删除的文章",
                        backdrop: true
                    });
                } else {
                    bootbox.confirm({
                        title: "删除文章",
                        message: "您确定要删除文章" + selecteds + '',
                        buttons: {
                            cancel: {
                                label: '<i class="fa fa-times"></i> 取消'
                            },
                            confirm: {
                                label: '<i class="fa fa-check"></i> 确认',
                            }
                        },
                        callback: function (result) {
                            console.log('result=' + result);
                            if (result) {
                                $('#form-article').submit();
                            }
                        }
                    });
                }
            })
            $('input[name=\'category_name\']').autocomplete({
                'source': function (request, response) {
                    $.ajax({
                        url: '<?php echo site_url('ArticleCategory/autoCategory'); ?>' + '?article_category_id=' + encodeURIComponent(request),
                        dataType: 'json',
                        success: function (json) {
                            response($.map(json, function (item) {
                                return {
                                    label: item['category_name'],
                                    value: item['article_category_id']
                                }
                            }));
                        },
                    });
                },
                'select': function (item) {
                    $('input[name=\'category_name\']').val(item['label']);
                }
            });
        </script>
    </body>
</html>