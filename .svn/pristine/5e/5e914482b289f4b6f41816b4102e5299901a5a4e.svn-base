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
                <?php include 'public_header.php' ?>
            </header>
            <aside class="main-sidebar">
                <?php include 'public_left.php' ?>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        子店铺管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class="active">子店铺管理</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <form action="<?php echo site_url('Store/storeSon?store_id='.$store_id) ?>" method="post">
                                <h3 class="box-title">子店铺信息列表</h3>
                                <div class="has-feedback">
                                    <input type="text" class="form-control input-md" id="filter_product_content" name="store_name" value="" placeholder="搜索店铺名称" autocomplete="off" style="width: 200px;"/>
                                </div>
                                <button stype="submit" class="btn btn-success" style="position: absolute;">搜索</button>
                            </form>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive select-messages">
                                    <table class="table table-hover table-striped" style=" text-align:left;table-layout: fixed; width:100%;height: 100%";>
                                        <thead>
                                        <td style="width: 10%;">店铺ID</td>
                                        <td style="width: 15%;">店铺名称</td>
                                        <td style="width: 20%;">店铺简介</td>
                                        <td style="width: 10%;">店铺负责人</td>
                                        <td style="width: 15%;">开店时间</td>
                                        <td style="width: 10%;">开店状态</td>
                                        <!--<td style="width: 10%;">操作</td>-->
                                        </thead>
                                        <tbody style="text-align: left">
                                            <?php foreach ($list as $value): ?>
                                                <tr>
                                                    <td ><?php echo $value['store_id'] ?></td>
                                                    <td ><?php echo $value['store_name'] ?></td>
                                                    <td style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="<?php echo $value['store_content'] ?>";><?php echo $value['store_content'] ?></td>
                                                    <td style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="<?php echo $value['user_name'] ?>";><?php echo $value['user_name']?></td>
                                                    <td><?php echo date('Y-m-d  H:i:s', $value['store_addtime']) ?></td>
                                                    <td><?php
                                                        if ($value['store_status'] == 1) {
                                                            echo "正常";
                                                        } else {
                                                            echo "封停";
                                                        }
                                                        ?></td>
<!--                                                    <td >    
                                                        <a class="btn btn-primary btn-xs" href="<?php echo site_url('Store/edit/'.$value['store_id']);?>">管理</a>
                                                        <a class="btn btn-primary btn-xs" href="<?php echo site_url('Store/info/'.$value['store_id']);?>">订单详情</a>
                                                        <a class="btn btn-primary btn-xs" href="<?php echo site_url('Store/storeProduct?store_id='.$value['store_id']);?>">商品管理</a>
                                                        <a class="btn btn-primary btn-xs" href="<?php echo site_url('Store/storeSon?store_id='.$value['store_id']);?>">子店铺列表</a>
                                                        <a class="btn btn-primary btn-xs" href="<?php echo site_url('Store/storeReward?store_id='.$value['store_id']);?>">佣金信息</a>
                                                    </td>-->
                                                    <td/>
                                                </tr>
<?php endforeach;
?>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                        <div class="box-footer no-padding">
                            <div class="mailbox-controls">
                                <div class="pull-right">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
<?php echo $linklist; ?>
                                        </ul>
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
        </div>
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="plugins/iCheck/icheck.min.js"></script>
        <script src="dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootbox.js"></script>
        <script src="dist/js/common.js"></script>
    </body>

</html>