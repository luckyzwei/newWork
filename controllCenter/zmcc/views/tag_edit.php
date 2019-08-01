<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?></title>
        <base href = "<?php echo base_url(); ?>zmcc/views/"/>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
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
                        商品标签管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('Tag/index'); ?>"> 商品标签管理</a>
                        </li>
                        <li class="active"><?php
                            if (!empty($product_tag_id)) {
                                echo "编辑商品标签";
                            } else {
                                echo "新增商品标签";
                            }
                            ?></li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <!-- form start -->
                                <form role="form" method="post" id='form-category' action="<?php echo $action; ?>">
                                    <input type="hidden" name="product_tag_id" value="<?php
                                    if (!empty($product_tag_id)) {
                                        echo $product_tag_id;
                                    }
                                    ?>">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="name">标签名称</label>
                                                <input type="text" class="form-control" value="<?php echo empty($tag_name) ? '' : $tag_name; ?>"  name='tag_name' placeholder="标签名称">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">保存</button>   
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('Tag/index') ?>'">返回</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
        </section>

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

</body>

</html>