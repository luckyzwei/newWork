<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title ?></title>
        <base href = '<?php echo base_url() . "zmcc/views/" ?>'/>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="plugins/ionicons-2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="./dist/css/ZMShop.min.css">
        <link rel="stylesheet" href="./plugins/iCheck/flat/blue.css">
        <link rel="stylesheet" href="./dist/css/skins/all-skins.min.css">
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
            <div class="content-wrapper" style="min-height: 848px;">
                <section class="content-header">
                    <h1>
                        支付方式管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>   
                            <a href="<?php echo site_url('payment/paymentlist') ?>">支付方式管理</a>
                        </li>
                        <li class="active">修改支付方式</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">修改支付方式</h3>
                                </div>
                                <form role="form" name="paymentoption_form" id="paymentoption" action="" method="post" >
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="payment_name">支付方式名称 </label>
                                                <input type="text" class="form-control" id="payment_name" name="payment_name" placeholder="支付方式名称" value="<?php echo $payment['payment_name'];?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="payment_key">支付方式配置key</label>
                                                <input type="text" class="form-control" id="setting_flag"  name="setting_flag" placeholder="key只能是英文字母和下划线组成"  value="<?php echo $payment['setting_flag'];?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="payment_group">支付方式代号</label>
                                                <input type="text" class="form-control" id="payment_code" name="payment_code" placeholder="支付方式代号只能是英文字母和下划线组成" value="<?php echo $payment['payment_code'];?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="sort_order">支持终端</label><br>
                                                <input type="checkbox" name="support_client[]" value="1" 
                                                    <?php if(in_array(1,$payment['support_client'])) echo "checked"?>>手机网页
                                                <input type="checkbox" name="support_client[]" value="2"
                                                       <?php if(in_array(2,$payment['support_client'])) echo "checked"?>>微信公众号
                                                <input type="checkbox" name="support_client[]" value="3"
                                                       <?php if(in_array(3,$payment['support_client'])) echo "checked"?>>微信小程序
                                                <input type="checkbox" name="support_client[]" value="4"
                                                       <?php if(in_array(4,$payment['support_client'])) echo "checked"?>>PC
                                                <input type="checkbox" name="support_client[]" value="5"
                                                       <?php if(in_array(5,$payment['support_client'])) echo "checked"?>>App
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <input type="hidden" name="payment_id" value="<?php echo $payment['payment_id']?>">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('Payment/paymentList')?>'">返回</button>
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
        <script src="./plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="./bootstrap/js/bootstrap.min.js"></script>
        <script src="./dist/js/app.min.js"></script>
        <script src="./plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="./plugins/iCheck/icheck.min.js"></script>
        <script src="./dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
        <script src="./dist/js/common.js"></script>
        <script src="./dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
        </script>
        <!--./文件管理器-->
    </body>
</html>