<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
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
                        商品分类管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class="active">商品分类管理</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">商品分类列表</h3>
                            <div class="box-tools">
                                <div class="has-feedback">
                                    <a href="<?php echo site_url('Category/addCategory'); ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div id="categoryList"></div>
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
        <script type="text/javascript" src="plugins/treeGrid/TreeGrid.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="plugins/iCheck/icheck.min.js"></script>
        <script src="dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootbox.js"></script>
        <script src="dist/js/common.js"></script>
        <script type="text/javascript">
            window.onload = function () {
                var config = {
                    id: "tg1",
                    renderTo: "categoryList",
                    indentation: "20",
                    folderOpenIcon: "plugins/treeGrid/images/folderOpen.png",
                    folderCloseIcon: "plugins/treeGrid/images/folderClose.png",
                    defaultLeafIcon: "plugins/treeGrid/images/defaultLeaf.gif",
                    hoverRowBackground: "false",
                    folderColumnIndex: "1",
                    columns: [
                        {
                            headerText: "",
                            headerAlign: "left",
                            dataAlign: "left",
                        },
                        {
                            headerText: "名称",
                            dataField: "name",
                            headerAlign: "left",
                            dataAlign: "left",
                            handler: "customOrgName"
                        },
                        {
                            headerText: "分类ID",
                            dataField: "id",
                            headerAlign: "left",
                            dataAlign: "left",
                            handler: "customOrgName"
                        },

                        {
                            headerText: "图片",
                            dataField: "images",
                            headerAlign: "center",
                            dataAlign: "center",
                            handler: "customOrgImg",
                        },
                        {
                            headerText: "操作",
                            dataField: "edit",
                            headerAlign: "center",
                            dataAlign: "center",
                            handler: "customOption"
                        }],
                    data: <?php echo $categorylist ?>
                };
                // debugger;
                var treeGrid = new TreeGrid(config);
                treeGrid.show()
                treeGrid.expandAll('N')
            }

            function delDialog(id, name) {

                bootbox.confirm({
                    title: "删除分类",
                    message: "您确定要删除分类" + id + ", " + name,
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
                            $.ajax({
                                url: '<?php echo site_url("Category/deleteCategory")?>',
                                data: {category_id: id},
                                type: 'post',
                                success: function (data) {
                                    +
                                            console.log(data);
                                    var data = JSON.parse(data)
                                    if (data.return == 0) {
                                        alert("删除失败" + data.data);
                                    }
                                    window.location.href = "<?php echo site_url('Category/index')?>";
                                },
                            });
                        } else {
                        }
                    }
                });

            }
        </script>
    </body>
</html>