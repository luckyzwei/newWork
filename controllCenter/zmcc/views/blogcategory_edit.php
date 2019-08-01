<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ZMShop | 编辑博客分类</title>
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
                        博客分类管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('BlogCategory/index'); ?>">博客分类管理</a>
                        </li>
                        <li class="active">编辑博客分类</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">编辑博客分类</h3>
                                </div>
                                <form role="form" method="post" action="<?php echo site_url('BlogCategory/editBlogCategory') ?>">
                                    <div class="box-body">
                                        <input type="hidden" value="<?php echo $blogcategory_info['blog_category_id'] ?>" name="blog_category_id">
                                        <div class="form-group ">
                                            <div class="col-md-5">
                                                    <label>顶级分类</label>
                                                    <select class="form-control select2 addrealname" name="parent_id">
                                                        <option value="0">--顶级分类--</option>
                                                        <?php foreach($blogcategory as $row): ?>
                                                        <option value="<?php echo $row['blog_category_id'] ?>" <?php if($row['blog_category_id'] == $blogcategory_info['parent_id'] ){echo "selected";}?>><?php echo $row['category_name']; ?></option>
                                                    <?php endforeach ; ?>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="exampleInputNickName1">分类名称</label>
                                                <input type="text" class="form-control" name="category_name" id="exampleInputNickName1" value="<?php echo $blogcategory_info['category_name'] ?>" placeholder="修改分类名称">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label >是否公开</label>
                                                <select name="published" class="form-control" style="width:200px;">
                                                    <option value="1" <?php if ($blogcategory_info['published'] == 1) echo "selected" ?>>保密</option>
                                                    <option value="0" <?php if ($blogcategory_info['published'] == 0) echo "selected" ?>>公开</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="exampleInputPassword1">店铺ID</label>
                                                <input type="text" name="store_id" class="form-control" id="exampleInputPassword1" placeholder="收藏ID" value="<?php echo $blogcategory_info['store_id'] ?>" >
                                                <input type="hidden" name="store_id" class="form-control" id="exampleInputPassword1" placeholder="收藏ID" value="<?php echo $blogcategory_info['store_id'] ?>" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="image">图片</label><br>
                                                <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail" data-original-title="" title="图片上传">
                                                    <img height="100px" src="<?php echo base_url(); ?>upload/image/<?php echo empty($blogcategory_info['image']) ? 'no_image.png' : $blogcategory_info['image']; ?>" alt="" title="" data-placeholder="<?php echo empty($blogcategory_info['image']) ? 'no_image.png' : $blogcategory_info['image']; ?>">
                                                </a>
                                                <input type="hidden" name="image" value="<?php echo empty($blogcategory_info['image']) ? 'no_image.png' : $blogcategory_info['image']; ?>" id="input-image">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="exampleInputPassword1">关键字</label>
                                                <input type="text" name="keywords" class="form-control" id="exampleInputPassword1" placeholder="关键字" value="<?php echo $blogcategory_info['keywords'] ?>" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="exampleInputPassword1">排序</label>
                                                <input type="text" name="sort_order" class="form-control" id="exampleInputPassword1" placeholder="排序" value="<?php echo $blogcategory_info['sort_order'] ?>" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label >状态</label>
                                                <select name="status" class="form-control" style="width:200px;">
                                                    <option value="1" <?php if ($blogcategory_info['status'] == 1) echo "selected" ?>>未发布</option>
                                                    <option value="2" <?php if ($blogcategory_info['status'] == 2) echo "selected" ?>>删除</option>
                                                    <option value="0" <?php if ($blogcategory_info['status'] == 0) echo "selected" ?>>发布</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('BlogCategory/index')?>'">返回</button>
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
        <script src="plugins/summernote/summernote.js"></script>
        <script src="plugins/summernote/lang/summernote-zh-CN.js"></script>
        <script src="plugins/summernote/upload.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
            $('input[name=\'parent_name\']').autocomplete({
                'source': function (request, response) {
                    $.ajax({
                        url: '<?php echo site_url('BlogCategory/autoCategory/1'); ?>' + '?parent_id=' + encodeURIComponent(request),
                        dataType: 'json',
                        success: function (json) {
                            response($.map(json, function (item) {
                                return {
                                    label: item['name'],
                                    value: item['blog_category_id']
                                }
                            }));
                        }
                    });
                },
                'select': function (item) {
                    $('input[name=\'parent_name\']').val(item['label']);
                    $('input[name=\'parent_id\']').val(item['value']);
                }
            });
            $('#category-filter').delegate('.fa-minus-circle', 'click', function () {
                $(this).parent().remove();
            });
        </script>
    </body>
</html>



