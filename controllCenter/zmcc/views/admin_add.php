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
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            .avatar .img{ padding:3px; border:1px solid #CBCBCB;filter:alpha(Opacity=60);-moz-opacity:0.6;opacity: 0.6}
            .avatar .img:hover{border:2px solid #0089db;background:#f0f0f0;filter:alpha(Opacity=100);-moz-opacity:10;opacity: 10}
            .selectedAvatar{border:2px solid #0089db;background:#f0f0f0;filter:alpha(Opacity=100);-moz-opacity:10;opacity: 10}
        </style>
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
                        会员管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href='<?php echo site_url("Welcome/index") ?>'><i class="fa fa-dashboard"></i> 控制面板</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('Admin/index') ?>">管理员管理</a>
                        </li>
                        <li class="active">添加管理员</li>
                    </ol>
                </section>
                <section class="content">
                    <!--公用提示-->
                    <?php include 'public_middletips.php'; ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">添加管理员</h3>
                                </div>
                                <form role="form" action="<?php echo site_url('Admin/addAdmin'); ?>" name="adminoption_form" id="adminoption" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="name">管理员名称</label>
                                                <input type="text" name="name" id="name" class="form-control" placeholder="管理员名称"  value="<?php echo set_value('name');?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="password">管理员密码</label>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-eye" id="showOrHidepwd" style="color:#3c8dbc"></i>
                                                <input type="text" name="password" value="<?php echo set_value('password') ?>" id="password" class="form-control" placeholder="管理员密码">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="nickname">管理员昵称</label>
                                                <input type="text" name="nickname" id="nickname" value="<?php echo set_value('nickname') ?>" class="form-control" placeholder="管理员昵称" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-8 avatar">
                                                <label for="status">选择头像</label>
                                                <?php for ($i = 1; $i < 7; $i++) { ?>
                                                    <img src="./dist/avatar/male0<?php echo $i; ?>.jpg" width="60" class="img">
                                                <?php } ?>
                                                <?php for ($i = 1; $i < 7; $i++) { ?>
                                                    <img src="./dist/avatar/female0<?php echo $i; ?>.jpg" width="60" class="img">
                                                <?php } ?>
                                                <input type="hidden" value="./dist/avatar/female01.jpg" name="avatar" id="avatar">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="role_id">管理员角色</label>
                                                <select id="role_id" name="role_id"  style="width:100%;height:34px;">
                                                    <?php foreach ($rolelists as $rolelist): ?> 
                                                        <option value="<?php echo $rolelist['role_id'] ?>"><?php echo $rolelist['role_name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select> 
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="expiretime">管理员失效时间</label>
                                                <div class="input-group date"><input type="text" name="expiretime" value="<?php echo set_value('expiretime') ?>" placeholder="失效日期" data-date-format="YYYY-MM-DD" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>          
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="status">管理员状态</label>
                                                <select id="status" name="status" style="width:100%;height:34px;">
                                                    <option value="1">正常</option>
                                                    <option value="2">锁定</option>
                                                    <option value="-1">删除</option>
                                                </select>                                                   
                                            </div>
                                        </div>      

                                    </div>                
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                        <button type="button" class="btn btn-prompt"  onclick="location.href = '<?php echo site_url('Admin/index')?>'">返回</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
            <footer class="main-footer">
                <?php include 'public_footer.php'; ?>
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
        <script src="dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
        <link href="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
        <script src="plugins/bootstrap-datetimepicker/moment.js"></script>
        <script src="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript">
                                            $('.date').datetimepicker({
                                                pickTime: false
                                            });
                                            $(".img").click(function () {
                                                $(".avatar img").attr("class", "img");
                                                $(this).removeClass("img");
                                                $(this).addClass("selectedAvatar");
                                                $("#avatar").val($(this).attr("src"));
                                            });
                                            //明文密码切换
                                            $('#showOrHidepwd').click(function () {
                                                var changeType = $("#password").attr("type") === "text" ? "password" : "text";
                                                $("#password").attr("type", changeType);
                                                console.log(changeType);
                                                if (changeType === "text") {
                                                    $("#showOrHidepwd").removeClass("fa-eye-slash").addClass('fa-eye');
                                                } else {
                                                    $("#showOrHidepwd").removeClass("fa-eye").addClass('fa-eye-slash');
                                                }
                                            });
        </script>
    </body>

</html>


