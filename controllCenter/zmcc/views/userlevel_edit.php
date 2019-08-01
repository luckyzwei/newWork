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
                <?php include 'public_header.php'; ?>
            </header>
            <aside class="main-sidebar">
                <?php include 'public_left.php'; ?>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        会员等级管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>   
                            <a href="<?php echo site_url('UserLevel/index') ?>">会员等级管理</a>
                        </li>
                        <li class="active">编辑会员等级</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">编辑会员等级</h3>
                                </div>
                                <form role="form" action="<?php echo site_url('UserLevel/editUserLevel/'.$level['level_id']); ?>" method="post" name="userleveloption_form" id="userleveloption" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="level_name">等级名称</label>
                                                <input type="text" name="level_name" class="form-control" id="level_name" placeholder="等级名称" value="<?php echo $level['level_name']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="integral">自动升级所需积分</label>
                                                <input type="text" name="integral" class="form-control" id="integral" placeholder="自动升级所需积分" value="<?php echo $level['integral']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="auto_upgrade">是否自动升级</label>

                                                <input type="radio" name="auto_upgrade" value="0" id="auto_upgrade" class="flat-blue" <?php if ($level['auto_upgrade'] == '0') echo "checked" ?>>否
                                                <input type="radio" name="auto_upgrade" value="1" id="auto_upgrade" class="flat-blue" <?php if ($level['auto_upgrade'] == '1') echo "checked" ?>>是
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="level_sort">等级排序</label>
                                                <input type="text" name="level_sort" value="<?php echo $level['level_sort']; ?>" class="form-control" id="level_sort" placeholder="等级排序">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="level_image">等级图片</label>
                                                <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail" data-original-title="" title="图片上传">
                                                    <img height="100px" src="<?php echo base_url(''); ?>upload/image/<?php echo empty($level['level_image']) ? 'no_image.png' : $level['level_image']; ?>" alt="" title="" data-placeholder="<?php echo empty($userlevelinfo['level_image']) ? 'no_image.png' : $userlevelinfo['level_image']; ?>">
                                                </a>
                                                <input type="hidden" name="level_image" value="<?php echo empty($level['level_image']) ? 'no_image.png' : $level['level_image']; ?>" id="input-image">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <input type="hidden" name="level_id" value="<?php echo $level['level_id']; ?>">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('UserLevel/index')?>'">返回</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                <?php include'public_footer.php'; ?>
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
        <script>
                                            $('input[type="radio"].flat-blue').iCheck({
                                                radioClass: 'iradio_flat-blue'
                                            });
        </script>
    </body>
</html>
