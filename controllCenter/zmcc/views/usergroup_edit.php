<?php defined('BASEPATH') or exit('No direct script access allowed');?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ZMShop | 新增会员等级</title>
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
                 <?php include 'public_header.php';?>
            </header>
            <aside class="main-sidebar">
                 <?php include 'public_left.php';?>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                       会员分组管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('UserGroup/index'); ?>">会员分组管理</a>
                        </li>
                        <li class="active">编辑会员分组</li>
                    </ol>
                </section>
                <section class="content">
                   <?php include 'public_middletips.php';?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">编辑会员分组</h3>
                                </div>
                                <form role="form" name="groupoption_form" id="groupoption" action="<?php echo site_url('UserGroup/editGroup/'.  $userGroup_info['user_group_id']); ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="user_group_id" value="<?php echo $userGroup_info['user_group_id']?>">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="user_group_name">会员分组名称</label>
                                                <input type="text" name="user_group_name" value="<?php echo $userGroup_info['user_group_name']; ?>" id="user_group_name" class="form-control" placeholder="会员分组名称">
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="integral">自动升级所需积分</label>
                                                <input type="text" name="integral" class="form-control" id="integral" placeholder="自动升级所需积分" value="<?php echo $userGroup_info['integral']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="auto_upgrade">是否自动升级</label>

                                                <input type="radio" name="auto_upgrade" value="0" id="auto_upgrade" class="flat-blue" <?php if ($userGroup_info['auto_upgrade'] == '0') echo "checked" ?>>否
                                                <input type="radio" name="auto_upgrade" value="1" id="auto_upgrade" class="flat-blue" <?php if ($userGroup_info['auto_upgrade'] == '1') echo "checked" ?>>是
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="user_group_discount">会员分组折扣</label>
                                                <input type="number" min="0" max="100" name="user_group_discount" id="user_group_discount" class="form-control" placeholder="单位为%且只能为整数" value="<?php echo $userGroup_info['user_group_discount'];?>">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('UserGroup/index'); ?>'">返回</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                <?php include 'public_footer.php';?>
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


