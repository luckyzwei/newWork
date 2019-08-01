<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
                        配置支付方式
                        <small>支付方式管理</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>   
                            <a href="<?php echo site_url('payment/paymentlist') ?>">支付方式管理</a>
                        </li>
                        <li class="active">配置支付方式</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">配置支付方式</h3>
                                    <span><?php echo $payment['payment_name']; ?>（<?php echo $payment['payment_code']; ?>）</span>
                                </div>
                                <form role="form" name="paymentoption_form" id="paymentoption" action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <!---支付方式配置信息-->
                                        <?php foreach ($settingOptions as $setting) { ?>
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <label for="<?php echo $setting['setting_key'] ?>"><?php echo $setting['setting_name'] ?></label>
                                                    <?php if ($setting['setting_type'] == "text") { ?>
                                                        <input type="text" class="form-control" id="payment_code" name="<?php echo $setting['setting_key'] ?>"  value="<?php echo $setting['setting_value']; ?>">
                                                    <?php } ?>
                                                    <?php if ($setting['setting_type'] == "file") { ?>
                                                        <input type="file" class="form-control" id="payment_code" name="<?php echo $setting['setting_key'] ?>">
                                                        <?php if(trim($setting['setting_value'])!=""){ ?>
                                                        <span class="danger" style="color:red">文件已经上传不修改请留空</span>
                                                        <?php }?>
                                                    <?php } ?>
                                                    <?php if ($setting['setting_type'] == "checkbox") {

                                                        foreach ($setting['setting_content'] as $op) {
                                                            $item = explode(":", $op)
                                                            ?>
                                                            <input type="checkbox"  name="<?php echo $setting['setting_key'] ?>[]"  value="<?php echo $item[0]; ?>"  <?php if (in_array($item[0], $setting['setting_value'])) echo "checked" ?>><?php echo $item[1] ?>

                                                        <?php }
                                                    }
                                                    ?>

                                                           <?php if ($setting['setting_type'] == "radio") { ?>
                                                               <?php foreach ($setting['setting_content'] as $op) {
                                                                   $opa = explode(":", $op); ?>
                                                            <input type="radio"  name="<?php echo $setting['setting_key'] ?>"  value="<?php echo $opa[0]; ?>" 
                                                            <?php if ($opa[0] == $setting['setting_value']) echo "checked" ?>><?php echo $opa[1] ?>

                                                            <?php }
                                                        } ?>

                                                                 <?php if ($setting['setting_type'] == "select") { ?>
                                                        <select name="<?php echo $setting['setting_key'] ?>">
                                                        <?php foreach ($setting['setting_content'] as $op) {
                                                            $opa = explode(":", $op); ?>
                                                                <option  value="<?php echo $opa[0]; ?>" 
                                                            <?php if ($opa[0] == $setting['setting_value']) echo "selected" ?>><?php echo $opa[1] ?></option>
        <?php }
    } ?>
                                                    </select>
                                            <?php if ($setting['setting_type'] == "textarea") { ?>
                                                        <textarea name="<?php echo $setting['setting_key'] ?>"  class="form-control"><?php echo $setting['setting_value']; ?></textarea>
    <?php } ?>

                                                </div>
                                                
                                            </div>
<?php } ?>
                                        <div class="form-group">
                                                <div class="col-md-8">
                                                     <label for="payment_status">是否启用</label>
                                                     <input class="form-control" type="checkbox" name="payment_status" <?php if($payment['payment_status']) echo"checked"?> >
                                                    </div>
                                                </div>
                                    </div>

                                    <div class="box-footer">
                                        <input type="hidden" name="payment_id" value="<?php echo $payment['payment_id'] ?>">
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