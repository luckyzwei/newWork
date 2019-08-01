<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title ?></title>
        <base href = '<?php echo base_url() . "zmcc/views/" ?>'/>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="./plugins/bootstrap-treeview/bootstrap-treeview.css">
        <link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="plugins/ionicons-2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="./dist/css/ZMShop.min.css">
        <link rel="stylesheet" href="./plugins/iCheck/flat/blue.css">
        <link rel="stylesheet" href="./plugins/summernote/summernote.css">
        <link rel="stylesheet" href="./dist/css/skins/all-skins.min.css">
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
            <div class="content-wrapper" style="min-height: 848px;">
                <section class="content-header">
                    <h1>
                        配送区域费用管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>  
                            <a href="<?php echo site_url('Logistics/getList') ?>">配送区域费用管理</a>
                        </li>
                        <li class="active">新增配送区域费用</li>
                    </ol>
                </section>
                <section class="content">
                   <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">新增配送区域费用</h3>
                                </div>
                                <form role="form" name="paymentoption_form" id="logisticsForm" action="" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="payment_name">配送区域费用名称 </label>
                                                <input type="text" class="form-control"  name="logistics_name" placeholder="配送方式名称" value="<?php if(validation_errors()!="") echo set_value('logistics_name')?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="payment_name">首重 (Kg)</label>
                                                <input type="text" class="form-control"  name="logistics_weight"  value="<?php if(validation_errors()!="") echo set_value('logistics_weight')?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="payment_name">首重费用(RMB/元) </label>
                                                <input type="text" class="form-control"  name="logistics_fee"  value="<?php if(validation_errors()!="") echo set_value('logistics_fee')?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="payment_name">续重费用(RMB/元) </label>
                                                <input type="text" class="form-control" name="logistics_add_fee"  value="<?php if(validation_errors()!="") echo set_value('logistics_add_fee')?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                            <div id="treeview-checkable" class="treeview"  style="overflow-y: auto;height: 500px">
                                        </div>    
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="payment_name">立即启用</label>
                                                <input type="checkbox" name="status" <?php echo set_value("status")?"checked":""?> value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <input type="hidden" name="support_area" id="areaids">
                                        <button type="submit" class="btn btn-primary" id="saveLogistics">保存</button>
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('Logistics/getList')?>'">返回</button>
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
        <script src="./plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="./bootstrap/js/bootstrap.min.js"></script>
        <script src="./plugins/bootstrap-treeview/bootstrap-treeview.js"></script>
        <script src="./dist/js/app.min.js"></script>
        <script src="./plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="./plugins/iCheck/icheck.min.js"></script>
        <script src="./dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
        <script src="./dist/js/common.js"></script>
        <script src="./dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="./dist/js/bootbox.js"></script>
        <script type="text/javascript">
            data =<?php echo $areas ?>;
            $(function () {
                var $checkableTree = $('#treeview-checkable').treeview({
                    data: data,
                    showIcon: false,
                    showCheckbox: true,
                    levels: 2,
                    onNodeChecked: function (event, node) {
                        var selectNodes = getChildNodeIdArr(node);
                        if (selectNodes) {
                            $('#treeview-checkable').treeview('checkNode', [selectNodes, {silent: true}]);
                        }
                        var parentNode = $("#treeview-checkable").treeview("getNode", node.parentId);
                        setParentNodeCheck(node);
                    },
                    onNodeUnchecked: function (event, node) {
                        var selectNodes = getChildNodeIdArr(node);
                        if (selectNodes) {
                            $('#treeview-checkable').treeview('uncheckNode', [selectNodes, {silent: true}]);
                        }
                    }
                });
            });
            
            function getChildNodeIdArr(node) {
                var ts = [];
                if (node.nodes) {
                    for (x in node.nodes) {
                        ts.push(node.nodes[x].nodeId);
                        if (node.nodes[x].nodes) {
                            var getNodeDieDai = getChildNodeIdArr(node.nodes[x]);
                            for (j in getNodeDieDai) {
                                ts.push(getNodeDieDai[j]);
                            }
                        }
                    }
                } else {
                    ts.push(node.nodeId);
                }
                return ts;
            }

            function setParentNodeCheck(node) {
                var parentNode = $("#treeview-checkable").treeview("getNode", node.parentId);
                if (parentNode.nodes) {
                    var checkedCount = 0;
                    for (x in parentNode.nodes) {
                        if (parentNode.nodes[x].state.checked) {
                            checkedCount ++;
                        } else {
                            break;
                        }
                    }
                    if (checkedCount === parentNode.nodes.length) {
                        $("#treeview-checkable").treeview("checkNode", parentNode.nodeId);
                        setParentNodeCheck(parentNode);
                    }
                }
            }
            
            function removeByValue(arr, val) {
                for(var i=0; i<arr.length; i++) {
                  if(arr[i].indexOf(val)>=0) {
                    arr.splice(i, 1);
                  }
                }
                return arr;
              }
            
            $("#saveLogistics").click(function(){
                var node = $('#treeview-checkable').treeview('getChecked');
                    if (node.length == 0) {
                        bootbox.alert({
                            message: "必须为当前管理员选择一种权限",
                            backdrop: true
                        });
                        return false;
                    }

                    var ids = "";
                    var sourceids="";
                    var nodeids=new Array();
                    for(var i=0;i<node.length;i++){
                        nodeids.push(node[i].id);
                    }
                    ids="|"+nodeids.join("|")+"|";
                    $("#areaids").val(ids);
                    $("#logisticsForm").submit();
            })
        </script>
        <!--./文件管理器-->
    </body>
</html>