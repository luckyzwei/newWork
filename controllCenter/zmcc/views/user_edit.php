<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title;?></title>
<base href = "<?php echo base_url(); ?>zmcc/views/"/>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="plugins/ionicons-2.0.1/css/ionicons.min.css">

<link rel="stylesheet" href="dist/css/ZMShop.min.css">
<link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
<link rel="stylesheet" href="plugins/summernote/summernote.css">
<link rel="stylesheet" href="dist/css/skins/all-skins.min.css">
<style type="text/css">
#user_group_id{
    width: 100px;
}
</style>
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
            会员管理
            </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
            </li>
            <li>  
                <a href=" <?php echo site_url('User/index') ?>">会员管理</a>
            </li>
            <li class="active">编辑会员</li>
        </ol>
        </section>
        <section class="content">
            <?php include 'public_middletips.php'; ?>
                <form role="form" action="" name="useroption_form" id="useroption" method="post" enctype="multipart/form-data">
                    <div class="tab-content">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">编辑会员</h3>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">  
                                        <div class="tab-content">
                                            <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <label for="user_name">用户名</label>
                                                            <input disabled="disabled" type="text" name="user_name" id="user_name" value="<?php if(!empty($userinfo['user_name'])) echo $userinfo['user_name']?>" class="form-control" placeholder="会员用户名">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <label for="password">用户密码</label>
                                                            <input type="text" name="password" value="" id="password" class="form-control" placeholder="会员密码">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                                <label for="nickname">会员昵称</label>
                                                                <input type="text" name="nickname" id="nickname" value="<?php echo $userinfo['nickname']?>" class="form-control" placeholder="最长为八个汉字">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <label for="email">邮箱</label>
                                                            <input type="text" name="email" id="email" value="<?php echo $userinfo['email']?>" class="form-control" placeholder="会员邮箱">
                                                        </div>
                                                    </div>
                                                     <div class="form-group">
                                                            <div class="col-md-8">
                                                                <label for="identity">会员身份</label>
                                                                <select name="identity" id="identity" style="width:100%;height:34px;">
                                                                    <option value="0">系统会员</option>
                                                                    <option value="supplier" <?php if($userinfo['identity']=='supplier') echo "selected"?>>供货商</option>
                                                                </select>
                                                            </div>
                                                    </div>

                                                    <div class="form-group">
                                                            <div class="col-md-8">
                                                                <label for="level_id">会员等级</label>
                                                               
                                                                <select name="level_id" id="level_id" style="width:100%;height:34px;">
                                                                 <?php foreach ($userlevels as $userlevel) :?>
                                                                    <option value="<?php echo $userlevel['level_id']?>" <?php if($userlevel['level_id']==$userinfo['level_id']) echo "selected"?>><?php echo $userlevel['level_name']?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                    </div>
                                                    <div class="form-group">
                                                            <div class="col-md-8">
                                                                <label for="user_group_id">会员分组</label>
                                                               
                                                                <select name="user_group_id" id="user_group_id" style="width:100%;height:34px;">
                                                                 <?php foreach ($usergroups as $usergroup) :?>
                                                                    <option value="<?php echo $usergroup['user_group_id']?>" <?php if($usergroup['user_group_id']==$userinfo['user_group_id']) echo "selected"?>><?php echo $usergroup['user_group_name']?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                    </div>
                                                <div class="box-footer">
                                                    <input type="hidden" name="user_id" value="<?php echo $userinfo['user_id']?>">
                                                    <button type="submit" class="btn btn-primary">保存</button>
                                                    <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('User/index')?>'">返回</button>
                                                </div>
                                            </div>
                                       
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                </form>
           

        </section>
    </div>
    <footer class="main-footer">
    <?php include 'public_footer.php';?>
    </footer>
    <aside class="control-sidebar control-sidebar-dark">

    <ul class="nav nav-tabs nav-justified control-sidebar-tabs"></ul>

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
<link href="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
<script src="plugins/bootstrap-datetimepicker/moment.js"></script>
<script src="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="dist/js/location.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
</script>

</body>

</html>


