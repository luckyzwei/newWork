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
                    <h1>
                        分销商管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('Agent/index') ?>">分销商管理</a>
                        </li>
                        <li class="active">审核分销商</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">审核分销商</h3>
                                </div>
                                <form role="form" name="agent_form" id="agent" action="<?php echo site_url('Agent/agent') ?>" method="post">
                                    <input type="hidden" value="<?php echo $agent['agent_id'] ?>" name="agent_id">
                                    <div class="box-body"> 
                                        <div class="form-group col-md-8">
                                            <label for="exampleInputNickName1">申请姓名：</label>
                                            <?php echo $agent['agent_name'] ?>
                                        </div>

                                        <div class="form-group col-md-8">
                                            <label for="exampleInputNickName1">联系电话：</label>
                                            <?php echo $agent['dot_mobile']; ?>
                                        </div>
                                        <div class=" form-group col-md-8">
                                            <label for="address">常住地址：</label>
                                            <?php echo $user_ext_info['province'] . $user_ext_info['city'] ?>
                                        </div>
                                        <div class=" form-group col-md-8">
                                            <label for="address">宠物类别：</label>
                                            <?php echo $user_ext_info['pet_type'] ? "猫" : "狗" ?>
                                        </div>
                                        <div class=" form-group col-md-8">
                                            <label for="address">宠物类型：</label>
                                            <?php echo $user_ext_info['pet_breed'] ?>
                                        </div>
                                        <div class=" form-group col-md-8">
                                            <label for="address">宠物年龄：</label>
                                            <?php echo $user_ext_info['pet_age'] ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="exampleInputNickName1">所属分组</label>
                                                <select name="agent_group_id" class="form-control"  style="width: 300px;"">
                                                    <?php foreach ($agent_group as $group): ?>
                                                        <option value="<?php echo $group['agent_group_id'] ?>"><?php echo $group['agent_group_name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="exampleInputNickName1">审核</label>
                                                <select name="agent_status" class="form-control"  style="width: 100px;">
                                                    <option <?php if ($agent['agent_status'] === 0) { ?>selected="selected" <?php } else { ?> value="0">审核中</option>
                                                        <option <?php $agent['agent_status'] === 1 ?>selected="selected" <?php } ?> value="1">已审核</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">保存</button>    
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('Agent/index') ?>'">返回</button>
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
        <script src="dist/js/common.js"></script>
        <script src="plugins/iCheck/icheck.min.js"></script>
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
        <script>
                                            /**区域选择*/
                                            $(document).ready(function () {
                                                var pid =<?php echo $agent['dot_province'] ? $agent['dot_province'] : 0 ?>;
                                                var cid =<?php echo $agent['dot_city'] ? $agent['dot_city'] : 0 ?>;
                                                var did =<?php echo $agent['dot_districe'] ? $agent['dot_districe'] : 0 ?>;
                                                $.post("<?php echo site_url('area/getProvinces') ?>",
                                                        {"province_id": pid},
                                                        function (res) {
                                                            $("#province").html(res);
                                                        });

                                                if (pid) {
                                                    $.post("<?php echo site_url('area/getCitys') ?>",
                                                            {"province_id": pid, "city_id": cid},
                                                            function (res) {
                                                                $("#city").html(res);
                                                            });
                                                }


                                                if (cid) {
                                                    $.post("<?php echo site_url('area/getDistricts') ?>",
                                                            {"city_id": cid, "district_id": did},
                                                            function (res) {
                                                                $("#district").html(res);
                                                            });
                                                }




                                                $("#province").change(function () {
                                                    var pid = $(this).val();
                                                    if (pid) {
                                                        $.post("<?php echo site_url('area/getCitys') ?>",
                                                                {"province_id": pid, "city_id": cid},
                                                                function (res) {
                                                                    $("#city").html(res);
                                                                });
                                                    }
                                                });

                                                $("#city").change(function () {
                                                    var cid = $(this).val();
                                                    if (cid) {
                                                        $.post("<?php echo site_url('area/getDistricts') ?>",
                                                                {"city_id": cid, "district_id": did},
                                                                function (res) {
                                                                    $("#district").html(res);
                                                                });
                                                    }
                                                });


                                            });
        </script>
    </body>

</html>