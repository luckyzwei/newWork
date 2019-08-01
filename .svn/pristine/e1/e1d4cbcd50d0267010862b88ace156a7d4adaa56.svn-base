<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
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
                        广告管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class="active">广告管理</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">广告列表</h3>
                            <div class="box-tools">
                                <div class="has-feedback">   
                                   <a href="<?php echo site_url('Advert/addAdvert')?>"> <div class="btn btn-success"><i class="fa fa-plus"></i></div></a>
                                    <button type="button" class="btn btn-default" id="delete"><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive select-messages">
                                <form action="<?php echo site_url('Advert/deleteAdvert') ?>" method="post"  id="form-Coupon">
                                <table class="table table-hover table-striped" style="text-align:center;">
                                    <thead>
                                    <td style="width:1%"><input type="checkbox" class="btn btn-default btn-sm checkbox-toggle"></td>
                                    <td>排序值</td>
                                    <td>广告ID</td>
                                    <td>广告名称</td>
                                    <td>所属广告位</td>
                                    <td>类型</td>
                                    <td>状态</td>
                                    <td>操作</td>
                                    </thead>
                                    <tbody>
                                        <?php foreach($list as $ad){?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="selected[]" value="<?php echo $ad['ad_id']?>">
                                            </td>
                                            <td><?php echo $ad['sort']?></td>
                                            <td><?php echo $ad['ad_id']?></td>
                                            <td ><?php echo $ad['ad_name']?></td>
                                            <td ><?php echo $ad['ad_position_name']?></td>
                                            <td ><?php echo $type_name[$ad['ad_type']] ?></td>
                                            <td ><?php if($ad['ad_status'] == 1){echo "启用";}else{echo "禁用";}?></td>
                                            <td>
                                                    <a class="btn btn-primary btn-xs" href="<?php echo site_url('advert/editAdvert/'.$ad['ad_id']);?>">编辑</a>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </form>
                            </div>
                        </div>
                    </div>
                <div class="box-footer no-padding">
                        <div class="pull-right">
                            <nav aria-label="Page navigation">
                               <?php echo $page_link;?>
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
                        message: "请您选择要删除的广告位",
                        backdrop: true
                    });
                }else{
                bootbox.confirm({
                    title: "删除广告位",
                    message: "您确定要删除广告位"+selecteds+'',
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
                            //点击确定删除
                            $('#form-Coupon').submit();
                        }
                    }
                });
                }
            })


        </script>

</body>

</html>