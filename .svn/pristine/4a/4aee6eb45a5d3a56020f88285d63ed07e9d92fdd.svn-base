<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ZMShop | 编辑文章</title>
        <base href = "<?php echo base_url(); ?>zmcc/views/"/>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="plugins/ionicons-2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="plugins/iCheck/all.css">
        <link rel="stylesheet" href="dist/css/ZMShop.min.css">
        <link rel="stylesheet" href="plugins/summernote/summernote.css">
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
                        <li>
                            <a href="<?php echo site_url('Article/index'); ?>">文章管理</a>
                        </li>
                        <li class="active">编辑文章</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">编辑文章</h3>
                                </div>
                                <form role="form" method="post" action="<?php echo site_url('Article/editArticle') ?>">
                                    <div class="box-body">
                                        <input type="hidden" value="<?php echo $article['article_id'] ?>" name="article_id">

                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="images">图片</label><br>
                                                <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail" data-original-title="" title="图片上传">
                                                    <img height="100px" src="<?php echo base_url(); ?>upload/image/<?php echo empty($article['images']) ? 'no_image.png' : $article['images']; ?>" alt="" title="" data-placeholder="<?php echo empty($article['images']) ? 'no_image.png' : $article['images']; ?>">
                                                </a>
                                                <input type="hidden" name="images" value="<?php echo empty($article['images']) ? 'no_image.png' : $article['images']; ?>" id="input-image">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label >文章短标题</label>
                                                <input type="text" name="article_name" class="form-control" value="<?php echo $article['article_name'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="category-name">分类名称</label>
                                                <input type="text" class="form-control" id="article_category-id" name="category_name" placeholder="分类名称" value="<?php echo $article['category_name'] ?>">
                                                <input type="hidden" class="form-control" id="article_category-id" value="<?php echo $article['article_category_id'] ?>" name="article_category_id" placeholder="分类ID">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label>文章内容</label>
                                                <textarea name="content" class="summernote"><?php echo empty($article['content']) ? '' : $article['content']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="autor">文章作者</label>
                                                <input type="text" class="form-control" id="autor" name="author" placeholder="文章作者" value="<?php echo $article['author'] ?>" readonly="true">
                                            </div>
                                        </div> 
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-primary">保存</button>
                                            <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('Article/index')?>'">返回</button>
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
                                            $('input[type="radio"].flat-blue').iCheck({
                                                radioClass: 'iradio_flat-blue'
                                            });

        </script>
        <script type="text/javascript">
            $('input[name=\'category_name\']').autocomplete({
                'source': function (request, response) {
                    $.ajax({
                        url: '<?php echo site_url('ArticleCategory/autoCategory/1'); ?>' + '?article_category_id=' + encodeURIComponent(request),
                        dataType: 'json',
                        success: function (json) {
                            response($.map(json, function (item) {
                                return {
                                    label: item['category_name'],
                                    value: item['article_category_id']
                                }
                            }));
                        }
                    });
                },
                'select': function (item) {
                    $('input[name=\'category_name\']').val(item['label']);
                    $('input[name=\'article_category_id\']').val(item['value']);
                }
            });

            $('#category-filter').delegate('.fa-minus-circle', 'click', function () {
                $(this).parent().remove();
            });
        </script>
    </body>

</html>
