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
                        店铺佣金管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>   
                            <a href="<?php echo site_url('Store/index') ?>">店铺管理</a>
                        </li>
                        <li class="active">店铺佣金管理列表</li>
                    </ol>
                </section>
        <?php if(!empty($orderrewardlists)) { ?>
                <section class="content"> 
    
                    <div class="box box-primary"> 
                        <div class="box-body no-padding">
                            <div class="table-responsive select-messages">
                                <table class="table table-hover table-striped">
                                    <thead>
                                    <td class="order_id">订单Id</td>
                                    <td class="status">订单状态</td>
                                    <td class="order_amount">订单总金额</td>
                                    <td class="reward_status">佣金提现状态</td>
                                    <td class="order_reward">佣金分成</td>
                                    <td class="customer-opreate">操作</td>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orderrewardlists as $orderrewardlist):?>                             
                                            <tr>
                                                <td class="order_id"><?php echo $orderrewardlist['order_id'] ?></td>
                                                <td class="status">
                                                   <?php if($orderrewardlist['status'] ==1 ) echo '已支付';?>
                                                   <?php if($orderrewardlist['status'] ==2 ) echo '已发货';?>
                                                   <?php if($orderrewardlist['status'] ==3 ) echo '部分发货';?>
                                                   <?php if($orderrewardlist['status'] ==4 ) echo '部分退货';?>
                                                   <?php if($orderrewardlist['status'] ==5 ) echo '已收货';?>
                                                </td>
                                                <td class="order_amount"><?php echo $orderrewardlist['order_amount']?></td>
                                                <td class="reward_status">
                                                    <?php if($orderrewardlist['reward_status'] == 1) echo '已发放';?>
                                                    <?php if($orderrewardlist['reward_status'] == 0) echo '未发放';?>
                                                </td>
                                                <td class="order_reward"><?php echo $orderrewardlist['order_reward']?></td>
                                                <td class="customer-opreate"><a href="<?php echo base_url('/index.php/Store/editRewardStatus') ?>?reward_id=<?php echo $orderrewardlist['reward_id'] ?>" class="btn btn-primary btn-xs">编辑</a></td>
                                                
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer no-padding">
                            <div class="pull-right">
                                <nav aria-label="Page navigation">
                                   <?php echo $links;?>
                                </nav>
                            </div>
                        </div>
                    </div>
        </section>
   <?php } else { ?>
        <section class="content">
                    <h1>
                       暂无分成信息
                    </h1>
        </section>
   <?php }?>
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
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script src="dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
<script src="dist/js/common.js"></script>
</body>
</html>