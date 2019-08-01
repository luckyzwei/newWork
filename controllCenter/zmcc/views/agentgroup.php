<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

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
                        分销商等级管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class="active">分销商管理</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <form action="<?php echo site_url('AgentGroup/index') ?>" method="post">
                                <h3 class="box-title">分销商等级列表</h3>
                                <div class="has-feedback">
                                    <input type="text" class="form-control input-md" id="filter_group_name" name="filter_group_name" value="<?php echo $filter_group_name; ?>" placeholder="搜索分销商分组名称" autocomplete="off"/>
                                </div>
                                <button stype="submit" class="btn btn-success" style="position: absolute;">搜索</button>
                            </form>
                            <div class="box-tools">
                                <div class="has-feedback">
                                    <a href="<?php echo site_url('AgentGroup/addAgentGroup')?>">
                                        <button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button>
                                    </a>
                                    <button type="button" class="btn btn-default btn-sm" id="delete"><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive select-messages">
                                <form action="<?php echo site_url('AgentGroup/deleteAgentGroup') ?>" method="post"  id="form-agentgroup">
                                    <table class="table table-hover table-striped" style="text-align:left;">
                                        <thead>
                                        <td style="width: 1%"><input type="checkbox" class="btn btn-default btn-sm checkbox-toggle"></td>
                                        <td class="user-name">
                                            ID
                                        </td>
                                        <td class="user-nickname">等级名称
                                        </td>
                                        <td>一级返利</td>
                                        <td>二级返利</td>
                                        <td>升级标准</td>
                                        <td class="user-opreate">操作</td>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($list as $value): ?>
                                                <tr>
                                                    <td><?php if($value['agent_group_id']!=1):?>
                                                        <input type="checkbox" name="selected[]" value="<?php echo $value['agent_group_id'] ?>">
                                                    <?php endif;?></td>
                                                    <td class="user-name">
                                                        <?php echo $value['agent_group_id'] ?>
                                                    </td>
                                                    <td class="user-nickname"><?php echo $value['agent_group_name'] ?>
                                                    </td>
                                                    <?php foreach(unserialize($value['commission_rate']) as $vv) {?>
                                                    <td><?php echo $vv>1?$vv:($vv*100).' %' ?></td>
                                                    <?php }?>
                                                    <td><?php 
                                                    if($value['need_reward']||$value['need_member']):
                                                        echo "佣金达到".$value['need_reward']."元".($value['condation']?"并且":"或者")."邀请客户达到".$value['need_member']."人";
                                                    else:
                                                        echo "未设置标准";
                                                    endif;
?></td>
                                                    <td class="user-opreate">
                                                        <a class="btn btn-primary btn-xs" href="<?php echo site_url('AgentGroup/updateAgentGroup/'.$value['agent_group_id']);?>">编辑</a>
                                                    </td>
                                                    <td/>
                                                </tr>
                                            <?php endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </form>
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
                        message: "请您选择要删除的分销商分组",
                        backdrop: true
                    });
                } else {
                    bootbox.confirm({
                        title: "删除分销商分组",
                        message: "您确定要删除这个分销商分组ID为" + selecteds + '的分组?',
                        buttons: {
                            cancel: {
                                label: '<i class="fa fa-times"></i> 取消'
                            },
                            confirm: {
                                label: '<i class="fa fa-check"></i> 确认',
                            }
                        },
                        callback: function (result) {
                            console.log('result=' + result);
                            if (result) {
                                $('#form-agentgroup').submit();
                            }
                        }
                    });
                }
            });
            $("#setDefault").click(function(){
                var agent_group_id=$(this).attr("data-id");
                $.post("<?php echo site_url('agentGroup/setDefault')?>",{"agent_group_id":agent_group_id},function(res){
                    location.reload();
                },'json')
            })
        </script>
    </body>

</html>