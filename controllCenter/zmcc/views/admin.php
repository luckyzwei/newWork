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
                        管理员管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 控制面板</a>
                        </li>
                        <li class="active">管理员管理</li>
                    </ol>
                </section>
        <section class="content">   
                <!--公用提示-->
                    <?php include 'public_middletips.php'; ?>
                        
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">管理员列表</h3>
                        
                            <div class="box-tools">
                                <div class="has-feedback">
                                   <a href="<?php echo site_url('Admin/addAdmin') ?>">
                                        <div class="btn btn-success"><i class="fa fa-plus"></i></div>
                                    </a>
                                    <button type="button" class="btn btn-danger" id="delete"><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>   
                     <form method="post" action="<?php echo site_url('Admin/deleteAdmin');?>" id="deleteforms">  
                        <div class="box-body no-padding">
                            <div class="table-responsive select-messages">
                                <table class="table table-hover table-striped">
                                    <thead>
                                    <td style="width: 1%"><input type="checkbox" class="checkbox-toggle"></td>
                                    <td class="admin-id">管理员ID</td>
                                    <td class="admin-name">管理员名称</td>
                                    <td class="admin-role">管理员角色</td>
                                    <td class="admin-nickname">管理员昵称</td>
                                     <td class="admin-createtime">创建时间</td>
                                    <td class="admin-expiretime">管理员过期时间</td>
                                    <td class="admin-status">管理员状态</td>
                                    <td class="admin-createtime">操作</td>
                                    </thead>
                                    <tbody>
                                          <?php foreach($adminlists as $admin):?> 
                                            <tr>
                                                <td><?php if($admin['name']!="root"):?>
                                                    <input type="checkbox" name="selected[]" value="<?php echo $admin['admin_id']?>">
                                                    <?php endif;?>
                                                </td>
                                                <td class="admin-id"><?php echo $admin['admin_id']?></td>
                                                <td class="admin-name"><?php echo $admin['name']?></td>
                                                <td class="admin-role"><?php echo $admin['role_name']?></td> 
                                                <td class="admin-nickname"><?php echo $admin['nickname']?></td>
                                                <td class="admin-createtime"><?php echo date('Y-m-d',$admin['createtime']);?></td>
                                                <td class="admin-expiretime"><?php echo date('Y-m-d',$admin['expiretime']);?></td>
                                                <td class="admin-status">
                                                    <?php if($admin['status']==1) echo '正常'?>
                                                    <?php if($admin['status']==2) echo '锁定'?>
                                                </td>
                                                <td class="customer-opreate">
                                                    <a href="<?php echo site_url('Admin/editAdmin/'.$admin['admin_id']);?>" class="btn btn-primary btn-xs">编辑</a>
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
                        message: "请您选择要删除的管理员",
                        backdrop: true
                    });
                }else{
                bootbox.confirm({
                    title: "删除管理员",
                    message: "您确定要删除管理员ID为:【"+selecteds+'】的管理员？',
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

//筛选
    $('input[name="filter_nickname"]').autocomplete({
       source: function (request, response) {
            $.ajax({
                url: '<?php echo site_url('User/autoUser'); ?>' + '?filter_nickname=' + encodeURIComponent(request),
                dataType: 'json',
                success: function (json) {
                    response($.map(json, function (item) {
                        return {
                            label: item['nickname'],
                            value: item['user_id']

                        }
                    }));
                }
            });
        },
        select: function (item) {
            $('input[name="filter_nickname"]').val(item['label']);
        }
    });


</script>


<!--筛选-->
</body>

</html>