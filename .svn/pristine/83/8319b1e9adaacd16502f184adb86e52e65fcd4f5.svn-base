<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title ?></title>
        <base href = '<?php echo base_url() . "zmcc/views/" ?>'/>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="plugins/ionicons-2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="plugins/summernote/summernote.css">
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
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
                        优惠劵管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url("Coupon/index"); ?>">优惠劵管理</a>
                        </li>
                        <li class="active">发放优惠券</li>
                    </ol>
                </section>
                <section class="content">
                    <!--提示框 -->
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">发放优惠劵</h3>
                                </div>
                                <form role="form" name="Coupon_form" id="Coupon" action="" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>根据用户分组发放:</label>
                                                <p>
                                                    <?php if (!empty($userGroups)) { ?>
                                                        <?php foreach ($userGroups as $group): ?>
                                                            &nbsp;<input type="checkbox" name="user_group_id[]" value="<?php echo $group['user_group_id'] ?> ">&nbsp;<?php echo $group['user_group_name']?>
                                                        <?php endforeach; ?>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="user_id">单个用户发放</label>
                                                <input type="text" class="form-control" id="user_id"  placeholder="选择用户">
                                                <div id="product-link" class="well well-sm" style="height: 150px;overflow: auto">
                                                    <?php
                                                    if (!empty($user_id)) {
                                                        foreach ($user_id as $key => $value) {
                                                            echo '<div id="product' . $value['lproduct_id'] . '"><i class="fa fa-minus-circle"></i> ' . $value['nickname'] . '<input type="hidden" name="user_id[' . $key . '][user_id]" value="' . $value['user_id'] . '" /></div>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="">发放优惠劵张数</label>
                                                <input type="number" min="1" class="form-control" id="coupon_num" name="coupon_num" value="<?php echo set_value('coupon_num') ?>" placeholder="发送给每个用户的张数">
                                                <input type="hidden" name="coupon_id" value="<?php echo $coupon['coupon_id'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="">当前优惠劵名称</label>
                                                <input type="text" class="form-control"  disabled="disabled"  value="<?php echo $coupon['coupon_name'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="">当前优惠劵属性</label>
                                                <input type="text" class="form-control"  disabled="disabled" name="coupon_name" value="<?php if ($coupon['coupon_type'] == 1) {
                                                        echo "指定金额,直接抵扣";
                                                    } elseif ($coupon['coupon_type'] == 2) {
                                                        echo "百分比打折劵";
                                                    } elseif ($coupon['coupon_type'] == 0) {
                                                        echo "减少邮费";
                                                    } elseif ($coupon['coupon_type'] == -1) {
                                                        echo "免邮费,包邮";
                                                    } ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary" id="fa">发放</button>
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('Coupon/index')?>'">返回</button>
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
        <script src="dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
                                            var link_row = <?php
if (!empty($user_id)) {
    echo count($user_id, COUNT_NORMAL) > 0 ? count($user_id, COUNT_NORMAL) : 0;
} else {
    echo 0;
}
?>;
                                            $('#user_id').autocomplete({
                                                'source': function (request, response) {
                                                    $.ajax({
                                                        url: '<?php echo site_url('Coupon/autoUser') ?>?user_id=' + request,
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
                                                    $('#user_id').val('');
                                                    $('#product-link' + item['value']).remove();
                                                    $('#product-link').append('<div id="product-link' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="user_id[' + link_row + '][user_id]" value="' + item['value'] + '" /><input type="hidden" name="user_id[' + link_row + '][nickname]" value="' + item['label'] + '" /></div>');
                                                    link_row++;
                                                }
                                            });

                                            $('#product-link').delegate('.fa-minus-circle', 'click', function () {
                                                $(this).parent().remove();
                                            });
                                            $("#fa").click(function () {
                                                var str = "";
                                                var selecteds = "";
                                                $("input[name='level_id[]']:checkbox").each(function () {
                                                    if (true == $(this).is(':checked')) {
                                                        str += $(this).val() + ",";
                                                    }
                                                });
                                                if (str.substr(str.length - 1) == ',') {
                                                    selecteds = str.substr(0, str.length - 1);
                                                }
                                            })

        </script>

    </body>

</html>