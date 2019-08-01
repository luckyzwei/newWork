<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
        <link rel="stylesheet" href="./plugins/daterangepicker/daterangepicker.css">
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
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        仪表盘
                        <small>Version 1.0</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/"><i class="fa fa-dashboard"></i> 主页</a></li>
                        <li class="active">仪表盘</li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3><?php echo $allordermoney['order_count'] ? $allordermoney['order_count'] : 0 ?></h3>

                                    <p>总订单</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3><?php echo $todayordermoney['order_count'] ? $todayordermoney['order_count'] : 0 ?></h3>

                                    <p>今日订单</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3><?php echo $user_num ?></h3>

                                    <p>注册会员</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3><?php echo $today_user_number ?></h3>

                                    <p>新增会员</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>

                    <!-- Main row -->
                    <div class="row">
                        <div class="col-md-12">

                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">30天交易数据</h3>

<!--                                    <div class="box-tools pull-right col-sm-4">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" id="reservation">
                                        </div>
                                    </div>-->
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div id="weekCharts" style="width: 100%;height:400px;">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box box-success">
                                <div class="box-header ui-sortable-handle">
                                    <i class="fa fa-comments-o"></i>
                                    <h3 class="box-title">评论</h3>
                                </div>
                                <div class="box-body chat" id="chat-box">
                                    <!-- chat item -->
                                    <?php
                                    foreach ($comments as $comment) {
                                        ?>

                                        <div class="item" style="padding-top: 10px">
                                            <img  class="online" style="width:30px;height:30px" src='<?php echo $comment["wx_headimg"] ?>' >
                                            <p class="message">
                                                <a href="#" class="name">
                                                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?php echo date("Y.m.d H:i:s", $comment['createtime']) ?></small>
                                                    <?php echo $comment['nickname'] ? $comment['nickname'] : "匿名用户" ?>
                                                </a>
                                                <span <?php
                                                if (!$comment['status']): echo "style='color:#f39c13'";
                                                endif;
                                                ?>>
    <?php echo $comment['product_content'] ?>
                                                </span>
                                            </p>
                                            <!-- /.attachment -->
                                        </div>
                                        <!-- /.item -->
                                    <?php }
                                    ?>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">其它</h3>

                                </div>
                                <div class="box-body">
<!--                                    <div id="weekmemberCharts" style="width: 100%;height:400px;">

                                    </div>-->
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

        <script src="./plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="./bootstrap/js/bootstrap.min.js"></script>
        <script src="./dist/js/app.min.js"></script>
        <script src="./plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="./plugins/iCheck/icheck.min.js"></script>
        <script src="./plugins/daterangepicker/moment.min.js"></script>
        <script src="./plugins/daterangepicker/daterangepicker.js"></script>
        <script src="./plugins/Echarts/echarts.min.js"></script>
        <script src="./dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
        <script src="./dist/js/common.js"></script>
        <script src="./dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
            var staticsData=<?php echo $statics?>;
            $("#searchSetting").click(function () {
                var keyword = $("#keyword").val();
                location.href = "/index.php/setting/settinglist/keyword/" + keyword
            });
            $(function () {
                $('#chat-box').slimScroll({
                    height: '300px'
                });
                $('#reservation').daterangepicker({
                    locale: {
                        format: 'YYYY.MM.DD'
                    },
                    startDate: '<?php echo date("Y.m.d", strtotime("-30 days")) ?>',
                    endDate: '<?php echo date("Y.m.d") ?>'}
                );

                indexCharts()
            });
            function indexCharts() {
                // 基于准备好的dom，初始化echarts实例
                var weekCharts = echarts.init(document.getElementById('weekCharts'));

                // 指定图表的配置项和数据
                option = {

                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: ['订单数量', '支付数量', '交易金额','支付数量','支付金额', '新增会员', '访客数', '浏览量']
                    },
                    grid: {
                        left: '3%',
                        right: '3%',
                        bottom: '3%',
                        containLabel: true
                    },
                    toolbox: {
                        feature: {
                            saveAsImage: {}
                        }
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: staticsData.timestr
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            name: '订单数量',
                            type: 'line',
                            stack: '总量',
                            data: staticsData.orders
                        },
                        {
                            name: '支付数量',
                            type: 'line',
                            stack: '总量',
                            data:staticsData.pays
                        },
                        {
                            name: '交易金额',
                            type: 'line',
                            stack: '总量',
                            data: staticsData.totalfee
                        },
                        {
                            name: '支付金额',
                            type: 'line',
                            stack: '总量',
                            data: staticsData.payfee
                        },
                        {
                            name: '新增会员',
                            type: 'line',
                            stack: '总量',
                            data: staticsData.newuser
                        },
                        {
                            name: '访客数',
                            type: 'line',
                            stack: '总量',
                            data: staticsData.visiter
                        },
                        {
                            name: '浏览量',
                            type: 'line',
                            stack: '总量',
                            data: staticsData.visited
                        }
                    ]
                };
                weekCharts.setOption(option);
            }
            
        </script>
    </body>

</html>