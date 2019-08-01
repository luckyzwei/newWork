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
                    <h1>
                        商品评价管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>  
                            <a href="<?php echo site_url('Comment/index') ?>">商品评价管理</a>
                        </li>
                        <li class="active">修改商品评价</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <form role="form" name="comment_form" id="comment" action="" method="post">
                                    <input type="hidden" value="<?php echo $comment['comment_id'] ?>" name="comment_id">
                                    <div class="box-body"> 
                                        <div class="form-group">
                                            <div class="col-md-5">
                                                <label for="exampleInputNickName1">商品评价内容</label>
                                                <textarea class="form-control" rows="3" cols="" name="product_content"><?php echo $comment['product_content'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">
                                                <label for="exampleInputNickName1">评价等级</label>
                                                <select name="product_score" class="form-control" style="width:100px;">
                                                    <option value="1" <?php if ($comment['product_score'] == 1) echo "selected" ?>>1级</option>
                                                    <option value="2" <?php if ($comment['product_score'] == 2) echo "selected" ?>>2级</option>
                                                    <option value="3" <?php if ($comment['product_score'] == 3) echo "selected" ?>>3级</option>
                                                    <option value="4" <?php if ($comment['product_score'] == 4) echo "selected" ?>>4级</option>
                                                    <option value="5" <?php if ($comment['product_score'] == 5) echo "selected" ?>>5级</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">
                                                <label for="exampleInputNickName1">评价状态</label>
                                                <select name="status" class="form-control" style="width:110px;">
                                                    <option value="0" <?php if ($comment['status'] == 0) echo "selected" ?>>待审核</option>
                                                    <option value="1" <?php if ($comment['status'] == 1) echo "selected" ?>>已审核</option>
                                                    <option value="-1" <?php if ($comment['status'] == -1) echo "selected" ?>>已删除</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">保存</button>   
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('Comment/index')?>'">返回</button>
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
        <script src="dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/common.js"></script>
    </body>

</html>