<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title ?></title>
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
                <?php include 'public_header.php' ?>
            </header>
            <aside class="main-sidebar">
                <?php include 'public_left.php' ?>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        账户佣金管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>
                            <a href=" <?php echo site_url('User/index') ?>">分销商管理</a>
                        </li>
                        <li class="active">账户佣金管理</li>
                    </ol>
                </section>
                <section class="content"> 
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary"> 
                        <div class="box-header with-border">
                            <h3 class="box-title">佣金记录</h3>
                            <div class="box-tools">
                                <div class="has-feedback">
                                    <a href=" <?php echo site_url('agent/index') ?>">
                                    <button type="button" class="btn btn-default btn-sm" id="change"><i class="fa fa-backward">返回</i></button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive select-messages">
                                <table class="table table-hover table-striped">
                                     <thead>
                                    <td class="order_id">ID</td>
                                    <td class="order_reward">佣金分成</td>
                                    <td class="reward_status">佣金状态</td>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($rewardinfos)):?>
                                        <tr><td colspan="3"> 暂无佣金记录</td></tr>
                                            <?php endif;?>
                                        <?php foreach ($rewardinfos as $reward):?>                             
                                            <tr>
                                                <td class="order_id"><?php echo $reward['reward_id'] ?></td>

                                                <td class="order_amount"><?php echo $reward['order_reward']?></td>
                                                <td class="reward_status">
                                                    <?php if($reward['reward_status'] == 1) echo '已结算';?>
                                                    <?php if($reward['reward_status'] == 0) echo '未结算';?>
                                                </td>
                                               
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>

                                </table>
                            </div>                           
                        </div>
                        <div class="box-footer no-padding">
                            <div class="pull-right">
                                <nav aria-label="Page navigation">
                                    <?php echo $links; ?>
                                </nav>
                            </div>
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

    <div class="modal" id="changeAccount">
        <form action="" method="post">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">调节账户佣金</h4>
                    </div>
                    <div class="modal-body">
                        <p>调节量<input type="text" name="change_intergal" class="form-control small" id="changeNumber"></p>
                        <p>调节原因<textarea type="text" name="change_cause" class="form-control" id="changeCause"></textarea></p>
                        <input type="hidden" name="user_id" value="<?php echo $user_id?>"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary" id="confirmChange">确认修改</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </form>
        <!-- /.modal-dialog -->
    </div>

</div>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="dist/js/app.min.js"></script>
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script src="dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
<script src="dist/js/common.js"></script>
<script>

</script>
</body>

</html>