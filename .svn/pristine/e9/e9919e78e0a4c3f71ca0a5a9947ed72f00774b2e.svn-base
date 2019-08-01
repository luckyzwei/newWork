<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ZMShop | 编辑博客</title>
        <base href = "<?php echo base_url(); ?>zmcc/views/"/>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="plugins/ionicons-2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="plugins/summernote/summernote.css">
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
                        <li>
                            <a href="<?php echo site_url('Blog/index'); ?>">博客管理</a>
                        </li>
                        <li class="active">编辑博客</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">编辑博客</h3>
                                </div>
                                <form role="form" method="post" action="<?php echo site_url('Blog/editBlog') ?>" >
                                    <div class="box-body">
                                        <input type="hidden" value="<?php echo $blog['return']['blog_id'] ?>" name="blog_id">
                                        <div class="form-group ">
                                            <div class="col-md-8">
                                                <label for="category_name">分类名称</label>
                                                <input type="text" class="form-control" id="blog_category-id" name="category_name" placeholder="分类名称" value="<?php echo $blog['return']['category_name'] ?>">
                                                <input type="hidden" class="form-control" id="blog_category-id" name="blog_category_id" placeholder="分类ID" value="<?php echo $blog['return']['blog_category_id'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label>博客内容</label>
                                                <textarea name="content" class="summernote"><?php echo empty($blog['return']['content']) ? '' : $blog['return']['content']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="col-md-8">
                                                <label for="blog_name">博客名称 </label>
                                                <input type="text" name="blog_name" value="<?php echo $blog['return']['blog_name'] ?>" class="form-control" id="exampleInputEmail1" placeholder="博客名称">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">
                                                <label>状态</label>
                                                <select name="status" value="<?php echo $blog['return']['status'] ?>" class="form-control select2" style="width:110px;">
                                                    <?php if ($blog['return']['status'] == 1) { ?>
                                                        <option  selected="selected" value="1">发布</option>
                                                        <option  value="2">未发布</option>  
                                                    <?php } else if ($blog['return']['status'] == 2) { ?> 
                                                        <option selected="selected"  value="2">未发布</option>
                                                        <option  value="1">发布</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="hits">点击量</label>
                                                <input type="text" name="hits" value="<?php echo $blog['return']['hits'] ?>" class="form-control" id="exampleInputPassword1" placeholder="点击量">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <tr>
                                                        <td class="text-left">图像</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">
                                                            <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail" data-original-title="" title="">
                                                                <img height="100px" src="<?php echo empty($blog['return']['image']) ? '/upload/image/no_image.png' : $this->zmsetting->get('img_url').$this->zmsetting->get('file_upload_dir').$blog['return']['image']; ?>" alt="" title="" data-placeholder="<?php echo empty($blog['return']['image']) ? '/upload/image/no_image.png' : $this->zmsetting->get('img_url').$this->zmsetting->get('file_upload_dir').$blog['return']['image']; ?>">
                                                            </a>
                                                            <input type="hidden" name="image" value="<?php echo empty($blog['return']['image']) ? '/no_image.png' : $blog['return']['image']; ?>" id="input-image">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="keywords">关键字</label>
                                                <input type="text" name="keywords" value="<?php echo $blog['return']['keywords'] ?>" class="form-control" id="exampleInputPassword1" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="sort_order">排序</label>
                                                <input type="text" name="sort_order" value="<?php echo $blog['return']['sort_order'] ?>" class="form-control" id="exampleInputPassword1" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">
                                                <label for="enable_product">关联商品</label>
                                                <input type="text" class="form-control" id="enable_product" name="enable_product" placeholder="选择商品">
                                                <div id="enable-product" class="well well-sm" style="height: 150px;overflow: auto">
                                                    <?php
                                                    if (!empty($blog['shop'])) {
                                                        foreach ($blog['shop'] as $key => $value):
                                                            ?>
                                                            <div id="enable-product<?php echo $value["product_id"]; ?>"><i class="fa fa-minus-circle"></i> <?php
                                                                echo $value["product_name"];
                                                                echo '<input type="hidden" name="enable_product[' . $key . ']" value="' . $value["product_id"] . '" />';
                                                                ?>

                                                            </div>
                                                            <?php
                                                        endforeach;
                                                    }else {
                                                        echo '<div id="enable_product"></div>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-primary">保存</button>   
                                            <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('Blog/index') ?>'">返回</button>
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
        <script src="dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="plugins/summernote/summernote.js"></script>
        <script src="plugins/summernote/lang/summernote-zh-CN.js"></script>
        <script src="plugins/summernote/upload.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/common.js"></script>
        <script type="text/javascript">
                                                var link_row = <?php
                if (!empty($blog['shop'])) {
                    echo count($blog['shop'], COUNT_NORMAL) > 0 ? count($blog['shop'], COUNT_NORMAL) : 0;
                } else {
                    echo 0;
                }
                ?>;
                                                $('input[name=\'enable_product\']').autocomplete({
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
                                                        $('input[name=\'enable_product\']').val('');
                                                        $('#enable-product' + item['value']).remove();
                                                        $('#enable-product').append('<div id="enable-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="enable_product[' + link_row + ']" value="' + item['value'] + '" /></div>');
                                                        link_row++;
                                                    }
                                                });

                                                $('#enable-product').delegate('.fa-minus-circle', 'click', function () {
                                                    $(this).parent().remove();
                                                });
                                                $('input[name=\'category_name\']').autocomplete({
                                                    'source': function (request, response) {
                                                        $.ajax({
                                                            url: '<?php echo site_url('BlogCategory/autoCategory/1'); ?>' + '?blog_category_id=' + encodeURIComponent(request),
                                                            dataType: 'json',
                                                            success: function (json) {
                                                                response($.map(json, function (item) {
                                                                    return {
                                                                        label: item['category_name'],
                                                                        value: item['blog_category_id']
                                                                    }
                                                                }));
                                                            }
                                                        });
                                                    },
                                                    'select': function (item) {
                                                        $('input[name=\'category_name\']').val(item['label']);
                                                        $('input[name=\'blog_category_id\']').val(item['value']);
                                                    }
                                                });

                                                $('#category-filter').delegate('.fa-minus-circle', 'click', function () {
                                                    $(this).parent().remove();
                                                });
        </script>
    </body>
</html>

