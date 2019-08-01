<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
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
                <?php include 'public_header.php';?>
            </header>
            <aside class="main-sidebar">
                <?php include 'public_left.php';?>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        广告位管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class="active">广告位管理</li>
                    </ol>
                </section>
                <section class="content">
                     <!--公用提示-->
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary select-messages">
                        <div class="box-header with-border">
                            <form action="<?php echo site_url('Advert/getPositionList') ?>" method="post">
                                <h3 class="box-title">广告位列表</h3>
                                <div class="has-feedback">
                                    <input type="text" class="form-control input-md" id="filter_agent_name" name="ad_position_name" value="<?php echo  $ad_position_name ?>" placeholder="请输入广告位名称" autocomplete="off" style="width: 200px;"/>
                                </div>
                                <button stype="submit" class="btn btn-success" style="position: absolute;">搜索</button>
                            </form>
                            <div class="box-tools">
                                <div class="has-feedback">
                                     <a href="<?php echo site_url('/Advert/addPosition') ?>">
                                        <button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button>
                                    </a>
                                    <button type="button" class="btn btn-default btn-sm" id="delete"><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>
                         <form name="position" id="adPosition" method="post" action="<?php echo site_url('Advert/deletePosition')?>">
                        <div class="box-body no-padding">
                            <div class="table-responsive select-messages"> 
                                <table class="table table-hover table-striped" style="table-layout: fixed;text-align:center;">
                                    <thead>
                                    <td style="width: 1%"><input type="checkbox" class="btn btn-default btn-sm checkbox-toggle"></td>
                                    <td style="width: 100px">广告位ID</td>
                                    <td style="width: 200px">广告位名称</td>
                                    <td style="width: 300px">备注</td>
                                    <td style="width: 200px">广告位类型</td>
                                    <td style="width: 300px">操作</td>
                                    </thead>
                                    <tbody>
                                        <?php foreach($list as $position){?>
                                            <tr>
                                                <td style="width: 50px">
                                                    <input type="checkbox" name="position_id[]" value="<?php echo $position['ad_position_id']?>">
                                                </td>
                                                <td style="width: 100px"><?php echo $position['ad_position_id']?></td>
                                                <td style="width: 200px"><?php echo $position['ad_position_name']?></td>
                                                <td style="width: 300px;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="<?php echo $position['remark']?>"><?php echo $position['remark']==""?""."无":$position['remark']?></td>
                                                <td style="width: 200px"><?php if($position['ad_position_type']==1){echo "图片";}elseif($position['ad_position_type']==2){echo "文字";}elseif($position['ad_position_type']==3){echo "视频";}?></td>
                                                <td style="width: 300px"><a href="<?php echo site_url('Advert/getAdvertList/'.$position['ad_position_id'])?>">查看广告</a></td>
                                            </tr>
                                        <?php }?>
                        </form>
                                    </tbody>
                                    <input type="hidden" name="pagenum" value="<?php echo $pagenum?>">
                                </table>
                            </div>
                        </div></form>
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
                var tempArray=[];
                  $("input[name='position_id[]']:checkbox").each(function(){
                    if(true == $(this).is(':checked')){
                        tempArray.push($(this).val());
                    }
                });
                
                if(tempArray.length==0){
                    bootbox.alert({
                        message: "请您选择要删除的广告位",
                        backdrop: true
                    });
                }else{
                bootbox.confirm({
                    title: "删除广告位",
                    message: "您确定要删除广告位ID："+tempArray.join(","),
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
                            $("#adPosition").submit();
                        }
                    }
                });
                }
            });

        </script>

</body>

</html>