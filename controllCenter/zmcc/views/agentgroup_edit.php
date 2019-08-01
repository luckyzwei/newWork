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
                    <h1>分销商分组管理</h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>  
                            <a href="<?php echo site_url('AgentGroup/index') ?>">分销商分组管理</a>
                        </li>
                        <li class="active">修改分销商分组</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">修改分销商分组</h3>
                                </div>
                                <form role="form" name="agentgroup_form" id="settingoption" action="" method="post">
                                    <input type="hidden" value="<?php echo $agentgroup['agent_group_id'] ?>" name="agent_group_id">
                                    <div class="box-body"> 
                                        <div class="form-group">
                                            <div class="col-md-5">
                                                <label for="exampleInputNickName1">分销商分组名称</label>
                                                <input type="text" class="form-control" name="agent_group_name" value="<?php echo $agentgroup['agent_group_name']; ?>"  placeholder="最多12个汉字" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">
                                                <label for="exampleInputNickName1">一级佣金比例</label>
                                                <input type="text"  class="form-control" name="commission_rate[]" value="<?php echo $agentgroup['commission_rate'][0]; ?>"  placeholder="大于1表示固定金额，小于1表示百分比">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">
                                                <label for="exampleInputNickName1">二级佣金比例</label>
                                                <input type="text"  class="form-control" name="commission_rate[]" value="<?php echo $agentgroup['commission_rate'][1]; ?>"  placeholder="大于1表示固定金额，小于1表示百分比">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                                <div class="col-md-2 inline">
                                                    <label>佣金达到(元)</label>
                                                    <input type="text" class="form-control" name="need_reward" value="<?php echo $agentgroup['need_reward']?$agentgroup['need_reward']:"0"; ?>"  required>
                                                <span class="tip"><i>自动升级到该等级需要达到的佣金数</i></span>
                                                </div>
                                                <div class="col-md-1">
                                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                    <select class="form-control" name="condation">
                                                        <option value="0" <?php if($agentgroup['condation']==0): echo 'selected';endif;?>>或者</option>
                                                        <option value="1" <?php if($agentgroup['condation']==1): echo 'selected';endif;?>>同时</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 inline">
                                                    <label>邀请客户(人)</label>
                                                    <input type="text" class="form-control" name="need_member" value="<?php echo $agentgroup['need_member']?$agentgroup['need_member']:"0"; ?>"  required>
                                                    <span class="tip"><i>自动升级到该等级需要邀请的总客户数</i></span>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">保存</button>   
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('AgentGroup/index') ?>'">返回</button>
                                    </div>
                                </form>
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
    </body>

</html>