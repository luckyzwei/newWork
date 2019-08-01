<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title?></title>
  <base href = "<?php echo base_url(); ?>zmcc/views/"/>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="plugins/ionicons-2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/ZMShop.min.css">
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="/"><b><?php echo $site_name?></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">管理账号登录</p>

    <div class="external-event bg-red ui-draggable ui-draggable-handle" id="resultTips" style="display:<?php if(!empty($_SESSION['error'])): echo 'block';else: echo 'none';
endif;?>">
        <span id="resultMsg"><?php echo @$_SESSION['error'];?></span>
          
      </div>
    <form action="<?php echo site_url('AdminLogin/login');?>" method="post" id="loginform">
        <div class="form-group has-feedback">
            <input type="text" class="form-control" name="name" id="name" placeholder="用户名" value="" size="32">
          <span class="glyphicon glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" name="password" id="password" placeholder="密码"  size="32">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row" style="padding-left:25px">
            <div class="col-xs-5">
                <button type="button" class="btn btn-primary btn-block btn-flat" id="cancel" onclick="location:/">取消</button>
          </div>
          <div class="col-xs-5">
            <button type="button" class="btn btn-primary btn-block btn-flat" id="submitBut">登录</button>
          </div>
        </div>
    </form>



  </div>
</div>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
    
    $("#submitBut").click(function(){
        var name=$.trim($("#name").val());
        var password=$.trim($("#password").val());
        if(name==="" || password===""){
            $("#resultMsg").text("请把帐号密码输入完整");
            $("#resultTips").show();
            $("#resultTips").fadeOut(3000);
            return false;
        }
        else{
            $("#loginform").submit();
        }
    });
    $("#resultTips").fadeOut(3000);
  });
</script>
</body>
</html>
