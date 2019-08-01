<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
                        会员管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class="active">会员管理</li>
                    </ol>
                </section>
                <section class="content">   
                <?php include 'public_middletips.php'; ?>
                <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">会员列表</h3>
                        
                            <div class="box-tools">
                                <div class="has-feedback">
                                   <button type="button" class="btn btn-default" id="delete"><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>   
                       
                        <div class="mailbox-controls">
                            <div class="has-feedback" style="margin: 0;">
                                <form action="<?php echo site_url('User/index')?>" method="post">
<!--                                    <div class="form-group col-md-3">
                                        <label>会员名称</label>
                                        <input type="text" class="form-control input-sm" id="filter_user_name" name="filter_user_name" value="<?php echo $user_name ?>" placeholder="会员名称" autocomplete="off"/>

                                    </div>-->
<!--                                    <div class="form-group col-md-3">
                                        <label>会员邮箱</label>
                                        <input type="text" class="form-control input-sm" id="filter_email" name="filter_email" value="<?php echo $email ?>" placeholder="会员邮箱" autocomplete="off"/>

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>会员身份</label>
                                        <select name="filter_identity" id="filter_identity" class="form-control input-sm">
                                            <option value="">--请选择身份--</option>
                                            <option value="supplier" <?php if ($identity == "supplier") echo "selected" ?>>供货商</option>
                                            <option value="offlinestoreowner" <?php if ($identity == "offlinestoreowner") echo "selected" ?>>店主</option>
                                            <option value="offlinestoregroup" <?php if ($identity == "offlinestoregroup") echo "selected" ?>>线下店群组管理员</option>
                                        </select>
                                    </div>-->
                                    <div class="form-group col-md-3">
                                        <label>会员等级</label>
                                        <select name="filter_level_id" id="filter_level_id" class="form-control input-sm">
                                        <option value="">--请选择等级--</option>
                                        <?php if(!empty($userlevels)){ ?>
                                        <?php foreach ($userlevels as $userlevel) :?>
                                            <option value="<?php echo $userlevel['level_id']?>" <?php if ($level_id == $userlevel['level_id']) echo "selected" ?>><?php echo $userlevel['level_name']?></option>
                                        <?php endforeach ?>
                                        <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>会员昵称</label>
                                        <input type="text" class="form-control input-sm" id="filter_nickname" name="filter_nickname" value="<?php echo $nickname ?>" placeholder="会员昵称" autocomplete="off"/>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>会员分组</label>
                                        <select name="filter_user_group_id" id="filter_user_group_id" class="form-control input-sm">
                                            <option value="">--请选择分组--</option>
                                            <?php if(!empty($usergroups)){ ?>
                                            <?php foreach ($usergroups as $usergroup) :?>
                                                <option value="<?php echo $usergroup['user_group_id']?>" <?php if ($user_group == $usergroup['user_group_id']) echo "selected" ?>><?php echo $usergroup['user_group_name']?></option>
                                            <?php endforeach ?>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <button stype="submit" class="btn btn-success">搜索</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <form method="post" action="<?php echo site_url('User/deleteUser');?>" id="deleteforms">  
                        <div class="box-body no-padding">
                            <div class="table-responsive select-messages">
                                <table class="table table-hover table-striped">
                                    <thead>
                                    <td style="width: 1%"><input type="checkbox" class="btn btn-default btn-sm checkbox-toggle"></td>
                                    <td class="customer-id">ID</td>
                                    <!--<td class="customer-name">会员名称</td>-->
                                    <td class="customer-name">会员昵称</td>
                                    <!--<td class="customer-name">会员邮箱</td>-->
                                    <!--<td class="customer-name">用户身份</td>-->
                                    <td class="customer-name">用户余额</td>
                                    <td class="customer-name">用户积分</td>
                                    <td class="customer-name">会员等级</td>
                                    <td class="customer-name">会员分组</td>
                                    <td class="customer-name">创建时间</td>
                                    <td class="customer-name">更新时间</td>
                                    <td class="customer-opreate">操作</td>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($userlist as $user): ?>                             
                                            <tr>
                                                <td><input type="checkbox" name="selected[]" value="<?php echo $user['user_id']?>"/></td>
                                                <td class="user-id"><?php echo $user['user_id']?></td>
                                                <!--<td class="user_name"><?php echo $user['user_name']?></td>-->
                                                <td class="nickname"><?php echo $user['nickname']?></td>
                                                <!--<td class="email"><?php echo $user['email']?></td>-->
<!--                                                <td class="level_name">
                                                    <?php if($user['identity']=='supplier') echo "供货商"?>
                                                    <?php if($user['identity']=='offlinestoreowner') echo "店主"?>
                                                    <?php if($user['identity']=='offlinestoregroup') echo "线下店群组管理员"?>
                                                </td>-->
                                                <td class="user_money">￥<?php echo $user['user_money']?></td>
                                                <td class="user_money"><?php echo $user['user_intergal']?></td>
                                                <td class="level_name"><?php echo $user['level_name']?></td>
                                                <td class="user_group_name"><?php echo $user['user_group_name']?></td>
                                                <td class="createtime"><?php echo date("Y-m-d",$user['createtime'])?></td>
                                                <td class="updatetime"><?php echo date("Y-m-d",$user['updatetime'])?></td>
                                                <td class="customer-opreate">   
                                                    <a href="<?php echo site_url('User/userDetail/'.$user['user_id'])?>" class="btn btn-primary btn-xs">详情</a>
                                                    <a href="<?php echo site_url('User/editUser/'.$user['user_id'])?>" class="btn btn-primary btn-xs">编辑</a>
                                                    <a href="<?php echo site_url('User/editUserBalance/'.$user['user_id'])?>" class="btn btn-success btn-xs">
                                                        余额
                                                    </a>     
                                                    <a href="<?php echo site_url('User/editUserIntergal/'.$user['user_id']) ?>" class="btn btn-success btn-xs">
                                                        积分
                                                    </a>   
                                                    

                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                    <div class="box-footer no-padding">
                        <div class="pull-right">
                            <nav aria-label="Page navigation">
                               <?php echo $links;?>
                            </nav>
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
<script src="dist/js/common.js"></script>
<script src="dist/js/bootbox.js"></script>
 <script type="text/javascript">
            $("#delete").click(function () {
                var str = "";
                var selecteds = "";
                $("input[name='selected[]']:checkbox").each(function () {
                    if (true == $(this).is(':checked')) {
                        str += $(this).val() + ",";
                    }
                });
                if (str.substr(str.length - 1) == ',') {
                    selecteds = str.substr(0, str.length - 1);
                }
                if (selecteds == "") {
                    bootbox.alert({
                        message: "请您选择要删除的会员",
                        backdrop: true
                    });
                } else {
                    bootbox.confirm({
                        title: "删除会员",
                        message: "您确定要删除会员Id为：【" + selecteds + '】的会员信息?',
                        buttons: {
                            cancel: {
                                label: '<i class="fa fa-times"></i> 取消'
                            },
                            confirm: {
                                label: '<i class="fa fa-check"></i> 确认',
                            }
                        },
                        callback: function (result) {
                          
                            if (result) {
                                $('#deleteforms').submit();
                                console.log("确认")
                            } else {
                                console.log("取消")
                            }
                        }
                    });
                }
            })

        </script>
<script type="text/javascript">
    //邮箱自动加载筛选
    $('input[name=\'filter_email\']').autocomplete({
        'source': function (request, response) {
            $.ajax({
                url: '<?php echo site_url('User/autoUser'); ?>' + '?filter_email=' + encodeURIComponent(request),
                dataType: 'json',
                success: function (json) {
                    response($.map(json, function (item) {
                        return {
                            label: item['email'],
                            value: item['user_id']
                        }
                    }));
                }
            });
        },
        'select': function (item) {
            $('input[name=\'filter_email\']').val(item['label']);
        }
    });
    //用户名自动加载筛选
    $('input[name=\'filter_user_name\']').autocomplete({
        'source': function (request, response) {
            $.ajax({
                url: '<?php echo site_url('User/autoUser'); ?>' + '?filter_user_name=' + encodeURIComponent(request),
                dataType: 'json',
                success: function (json) {
                    response($.map(json, function (item) {
                        return {
                            label: item['user_name'],
                            value: item['user_id']

                        }
                    }));
                }
            });
        },
        'select': function (item) {
            $('input[name=\'filter_user_name\']').val(item['label']);
        }
    });
    //用户昵称自动加载筛选
    $('input[name=\'filter_nickname\']').autocomplete({
        'source': function (request, response) {
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
        'select': function (item) {
            $('input[name=\'filter_nickname\']').val(item['label']);
        }
    });


</script>
</body>

</html>