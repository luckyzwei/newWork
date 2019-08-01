   <?php
   defined('BASEPATH') OR exit('No direct script access allowed');
   ?><!DOCTYPE html>
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
                <?php include 'public_header.php';?>
            </header>
            <aside class="main-sidebar">
                <?php include 'public_left.php';?>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        活动管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 控制面板</a>
                        </li>
                        <li class="active">活动管理</li>
                    </ol>
                </section>
        <section class="content">   
                <!--公用提示-->
                    <?php include 'public_middletips.php'; ?>
                        
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">活动列表</h3>
                        
                            <div class="box-tools">
                                <div class="has-feedback">
                                   <a href="<?php echo site_url('Activity/addActivity') ?>">
                                        <div class="btn btn-success"><i class="fa fa-plus"></i></div>
                                    </a>
                                    <button type="button" class="btn btn-danger" id="delete"><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>   
                     <form method="post" action="<?php echo site_url('Activity/deleteActivity');?>" id="deleteforms">  
                        <div class="box-body no-padding">
                            <div class="table-responsive select-messages">
                                <table class="table table-hover table-striped">
                                    <thead>
                                    <td><input type="checkbox" class="checkbox-toggle"></td>
                                    <td>活动编号</td>
                                    <td>活动名称</td>
                                    <td>活动图片</td>
                                    <td>开始时间</td>
                                    <td>结束时间</td>
                                    <td>报名费用</td>
                                    <td>操作</td>
                                    </thead>
                                    <tbody>
                                          <?php foreach($acticvitylist as $activity):?> 
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="selected[]" value="<?php echo $activity['activity_id'];?>">
                                                </td>
                                                <td><?php echo $activity['activity_id'];?></td>
                                                <td><?php echo $activity['activity_title'];?></td>
                                                <td><img style="width: 30px;" src="<?php echo base_url();?>upload/image/<?php echo $activity['thumb'];?>"></td>
                                                <td><?php if(!empty($activity['start_time'])){ echo date('Y-m-d H:i', $activity['start_time']);}?></td> 
                                                <td><?php if(!empty($activity['end_time'])){ echo date('Y-m-d H:i', $activity['end_time']);}?></td>
                                                <td><?php echo $activity['price']>0?$activity['price']:"免费";?></td>
                                                <td>
                                                    <a href="<?php echo site_url('Activity/editActivity/'.$activity['activity_id']);?>" class="btn btn-primary btn-xs">编辑</a>
                                                    <a href="<?php echo site_url('ActivityOrder/index').'?activity_id='.$activity['activity_id'];?>" class="btn btn-primary btn-xs">报名列表</a>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                    </div>
                <div class="box-footer no-padding">
                        <div class="pull-right">
                            <nav aria-label="Page navigation">
                               <?php echo $links;?>
                            </nav>
                        </div>
                </div>           
        </section>
    </div>
    <footer class="main-footer">
        <?php include 'public_footer.php';?>
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
<script src="dist/js/bootbox.js"></script>
        <script>
            $("#delete").click(function () {
                var str="";
                var selecteds="";
                $("input[name='selected[]']:checkbox").each(function(){
                    if(true == $(this).is(':checked')){
                        str+=$(this).val()+",";
                    }
                });
                if(str.substr(str.length-1)== ','){
                    selecteds = str.substr(0,str.length-1);
                }
                
                if(selecteds==""){
                    bootbox.alert({
                        message: "请您选择要删除活动",
                        backdrop: true
                    });
                }else{
                bootbox.confirm({
                    title: "删除活动",
                    message: "您确定要删除编号为:【"+selecteds+'】的活动？',
                    buttons: {
                        cancel: {
                            label: '<i class="fa fa-times"></i> 取消'
                        },
                        confirm: {
                            label: '<i class="fa fa-check"></i> 确认',
                        }
                    },
                    callback: function (result) {
                        if(result){
                             $('#deleteforms').submit();
                        }
                    }
                });
                }
            })
</script>


<!--筛选-->
</body>

</html>