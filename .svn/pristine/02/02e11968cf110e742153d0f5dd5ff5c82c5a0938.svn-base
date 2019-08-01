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
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>  
                            <a href=" <?php echo site_url('User/index') ?>">会员管理</a>
                        </li>
                        <li class="active">会员信息</li>
                    </ol>
                </section>


                <section class="content">
                    <?php include 'public_middletips.php'; ?>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">会员信息</h3>
                        </div>
                        <section class="invoice">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <h2 class="page-header">
                                        <i class="fa fa-globe"></i><?php echo $nickname?$nickname:$wx_nickname;?>
                                        <small class="pull-right">最后登陆时间: <?php echo date("d/m/Y",$last_logintime);?></small>
                                    </h2>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <b>基本信息</b><br><br/>
                                    <address>
                                        用户等级：<?php echo $level_name;?><br>
                                        用户群组：<?php echo $user_group_name;?><br>
                                        联系电话：<?php echo $user_phone?$user_phone:"暂无绑定手机";?><br>
                                        Email: <?php echo $email?$email:"暂无绑定邮箱";?>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>账户信息</b><br><br/>
                                    <address>
                                        账户余额：<?php echo $user_money?><br>
                                        可提现金额：<?php echo $settlement_money?><br>
                                        账户积分： <?php echo $user_intergal?><br>
                                    </address>
                                </div>

                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-xs-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>订单编号</th>
                                                <th>订单金额</th>
                                                <th>下单时间</th>
                                                <th>是否支付</th>
                                                <th>订单备注</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(empty($orders)):?>
                                            <tr><td colspan="5">暂无订单</td></tr>
                                                <?php endif;?>
                                            <?php foreach($orders as $order):?>
                                            <tr>
                                                <td><?php echo $order['order_sn']?></td>
                                                <td><?php echo $order['order_amount']?></td>
                                                <td><?php echo date("Y-m-d",$order['createtime'])?></td>
                                                <td><?php echo $order['status']>0?"已支付":"未支付"?></td>
                                                <td>$64.50</td>
                                            </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
<?php $extends= unserialize($extends);
                                                if(!empty($extends)):?>
                            <div class="row">
                                <!-- /.col -->
                                <div class="col-xs-4">
                                    <p class="lead">用户扩展信息</p>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <?php
                                                    foreach($extends as $extend):
                                                ?>
                                                <tr>
                                                    <th style="width:20%"><?php echo $extend['label']?>:</th>
                                                    <td style="text-align:left"><?php echo $extend['value']?></td>
                                                </tr>
                                                <?php endforeach;?>
                                                
                                            </tbody></table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <?php endif;?>
                            <!-- /.row -->

                        </section>



                        <div class="box-footer">
                            <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('User/index') ?>'">返回</button>
                        </div>

                    </div>


                </section>
            </div>
            <footer class="main-footer">
                <?php include 'public_footer.php'; ?>
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


