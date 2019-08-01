<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ZMShop | 文章分类新增</title>
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
                        文章分类管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('ArticleCategory/index');?>">文章分类管理</a>
                        </li>
                        <li class="active">添加文章分类</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">添加文章分类</h3>
                                </div>
                                <form role="form" method="post" action="<?php echo site_url('ArticleCategory/doaddArticleCategory') ?>">
                                    <div class="box-body">
                                        <div class="form-group ">                                           
                                                <div class="form-group">
                                                    <div class="col-md-5">
                                                        <label>顶级分类</label>
                                                        <select class="form-control select2 addrealname" name="parent_id">
                                                            <option value="0">--顶级分类--</option>
                                                            <?php foreach($articlecategory as $row): ?>
                                                                <option value="<?php echo $row['article_category_id'] ?>"><?php echo $row['category_name'] ?></option>
                                                            <?php endforeach ; ?>
                                                        </select>                                                   
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="category_name">分类名称</label>
                                                <input type="text" name="category_name" class="form-control" id="exampleInputNickName1" placeholder="添加分类名">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="sort_order">排序</label>
                                                <input type="text" name="sort_order" class="form-control" id="exampleInputPassword1" placeholder="值越大越靠前">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">保存</button>    
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('ArticleCategory/index')?>'">返回</button>
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
    </body>
</html>

