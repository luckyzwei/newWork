<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?></title>
        <base href = "<?php echo base_url(); ?>zmcc/views/"/>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="plugins/ionicons-2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="dist/css/ZMShop.min.css">
        <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
        <link rel="stylesheet" href="plugins/summernote/summernote.css">
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
                        <li>
                            <a href="<?php echo site_url('Category/index'); ?>"> 商品分类管理</a>
                        </li>
                        <li class="active">新增商品分类</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <form role="form" method="post" id='form-category' action="<?php echo $action; ?>">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="parent_id">上级分类</label>
                                                <input type="text" name="parent_name" value="<?php echo empty($parent_name) ? '' : $parent_name; ?>" placeholder="上级分类"  class="form-control" autocomplete="off">
                                                <input type="hidden" class="form-control" value="<?php echo empty($parent_id) ? '' : $parent_id; ?>" name='parent_id' id="currParentid">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="name">分类名称</label>
                                                <input type="text" class="form-control" value="<?php echo empty($name) ? '' : $name; ?>"  name='name' placeholder="分类名称">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="image">分类图标</label>
                                                <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail" data-original-title="" title="">
                                                    <img height="100px" src="<?php echo empty($image) ? '/upload/image/no_image.png' : $showimg; ?>" alt="" title="" data-placeholder="<?php echo empty($image) ? '/upload/image/no_image.png' :$showimg; ?>">
                                                </a>
                                                <input type="hidden" name="image" value="<?php echo empty($image) ? '/no_image.png' : $image; ?>" id="input-image">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="sort">分类排序</label>
                                                <input name='sort' type='number' class="form-control" value="<?php echo empty($sort) ? '' : $sort; ?>"  placeholder="值越大越靠前"/>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">
                                                <label>分类状态</label>
                                                <select name='isshow' class="form-control">
                                                    <option <?php
                                                    if (!empty($isshow)) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?> value="1">启用</option>
                                                    <option <?php
                                                    if (empty($isshow)) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?> value="0">停用</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('/Category/index');?>'">返回</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>

        </section>

    </div>

</div>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="dist/js/app.min.js"></script>
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script src="dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
<script src="dist/js/common.js"></script>
<script src="dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="plugins/summernote/summernote.js"></script>
<script src="plugins/summernote/lang/summernote-zh-CN.js"></script>
<script src="plugins/summernote/upload.js" type="text/javascript" charset="utf-8"></script>

<!--筛选-->
<script type="text/javascript">
    $('input[name=\'parent_name\']').autocomplete({
        'source': function (request, response) {
            $.ajax({
                url: '<?php echo site_url('Category/autoCategory'); ?>' + '?add=1&search_name=' + encodeURIComponent(request),
                dataType: 'json',
                success: function (json) {
                    response($.map(json, function (item) {
                        return {
                            label: item['name'],
                            value: item['category_id']
                        }
                    }));
                }
            });
        },
        'select': function (item) {
            $('input[name=\'parent_name\']').val(item['label']);
            $('input[name=\'parent_id\']').val(item['value']);
        }
    });

    $('#category-filter').delegate('.fa-minus-circle', 'click', function () {
        $(this).parent().remove();
    });
</script>

<!--筛选-->
