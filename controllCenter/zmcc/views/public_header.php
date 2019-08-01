<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$adminInfo=$_SESSION['adminInfo'];
?>
<a href="index.html" class="logo">
    <span class="logo-mini"><b>Z</b>zzzShop</span>
    <span class="logo-lg"><b>ZZZZ</b>shop</span>
</a>

<nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">切换导航</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
<!--            <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-envelope-o"></i>
                    <span class="label label-success">4</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="header">你有4条消息</li>
                    <li>
                        <ul class="menu">
                            <li>
                                <a href="#">
                                    <div class="pull-left">
                                        <img src="./dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                    </div>
                                    <h4>
                                        支持团队
                                        <small><i class="fa fa-clock-o"></i> 5 分钟</small>
                                    </h4>
                                    <p>为什么不买一个新的主题?</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="pull-left">
                                        <img src="./dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                    </div>
                                    <h4>
                                        AdminLTE 设计团队
                                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                    </h4>
                                    <p>为什么不买一个新的主题?</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="pull-left">
                                        <img src="./dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                    </div>
                                    <h4>
                                        开发者
                                        <small><i class="fa fa-clock-o"></i> 今天</small>
                                    </h4>
                                    <p>为什么不买一个新的主题?</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="pull-left">
                                        <img src="./dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                    </div>
                                    <h4>
                                        销售部
                                        <small><i class="fa fa-clock-o"></i> 昨天</small>
                                    </h4>
                                    <p>为什么不买一个新的主题?</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="pull-left">
                                        <img src="./dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                    </div>
                                    <h4>
                                        评论
                                        <small><i class="fa fa-clock-o"></i> 2 天</small>
                                    </h4>
                                    <p>为什么不买一个新的主题?</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer">
                        <a href="#">查看所有消息</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <span class="label label-warning">10</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="header">你有10条通知</li>
                    <li>
                        <ul class="menu">
                            <li>
                                <a href="#">
                                    <i class="fa fa-users text-aqua"></i> 5 个新会员加入
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-users text-red"></i> 5 个新会员加入
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-shopping-cart text-green"></i> 25 个订单
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-user text-red"></i> 更改你的用户名
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer">
                        <a href="#">查看所有</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-flag-o"></i>
                    <span class="label label-danger">9</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="header">你有9条任务</li>
                    <li>
                        <ul class="menu">
                            <li>
                                <a href="#">
                                    <h3>
                                        设计按钮
                                        <small class="pull-right">20%</small>
                                    </h3>
                                    <div class="progress xs">
                                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                            <span class="sr-only">完成 20% </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <h3>
                                        创建漂亮的主题
                                        <small class="pull-right">40%</small>
                                    </h3>
                                    <div class="progress xs">
                                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                            <span class="sr-only">完成 40%</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <h3>
                                        还有一些任务要做
                                        <small class="pull-right">60%</small>
                                    </h3>
                                    <div class="progress xs">
                                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                            <span class="sr-only">完成 60%</span>
                                        </div>
                                    </div>
                                </a>
                            <li>
                                <a href="#">
                                    <h3>
                                        制作漂亮的过渡效果
                                        <small class="pull-right">80%</small>
                                    </h3>
                                    <div class="progress xs">
                                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                            <span class="sr-only">完成 80%</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer">
                        <a href="#">查看所有任务</a>
                    </li>
                </ul>
            </li>-->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?php echo $adminInfo['avatar']?>" class="user-image" alt="User Image">
                    <span class="hidden-xs"><?php echo $adminInfo['nickname']?></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img src="<?php echo $adminInfo['avatar']?>" class="img-circle" alt="User Image">

                        <p>
                            <?php echo $adminInfo['nickname']?> - <?php echo $adminInfo['role_name']?>
                            <small>帐号有效期至 <?php echo date("Y.m.d",$adminInfo['expiretime'])?></small>
                        </p>
                    </li>
<!--                     Menu Body 
                    <li class="user-body">
                        <div class="row">
                            <div class="col-xs-4 text-center">
                                <a href="#">点赞</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">销售</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">朋友</a>
                            </div>
                        </div>
                         /.row 
                    </li>-->
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="<?php echo site_url('AdminLogin/editPrivateInfo')?>" class="btn btn-default btn-flat">修改资料</a>
                        </div>
                        <div class="pull-right">
                            <a href="<?php echo site_url("AdminLogin/logout")?>" class="btn btn-default btn-flat">退出</a>
                        </div>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
        </ul>
    </div>
</nav>