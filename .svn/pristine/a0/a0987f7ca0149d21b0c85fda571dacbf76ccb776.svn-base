<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
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
                <?php include 'public_header.php'; ?>
            </header>
            <aside class="main-sidebar">
                <?php include 'public_left.php'; ?>
            </aside>

            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        活动管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('Activity') ?>">活动管理</a>
                        </li>
                        <li class="active"><?php echo $headings;?></li>
                    </ol>
                </section>
                <section class="content">
                     <!--公用提示-->
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo $headings;?></h3>
                                </div>
                                <form role="form" action="<?php echo $action ?>" method="post" >
                                    <input type="hidden" name="activity_id" value="<?php if(!empty($activity['activity_id']) && isset($activity)){ echo $activity['activity_id'];}elseif(!empty($activity_add['activity_id'])){echo $activity_add['activity_id'];}?>">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="">活动名称</label>
                                                <input type="text" name="activity_title" value="<?php if(!empty($activity['activity_title'])  && isset($activity)){ echo $activity['activity_title'];}elseif(!empty($activity_add['activity_title'])){ echo $activity_add['activity_title'];}?>" class="form-control" placeholder="活动名称" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="">活动内容</label>
                                                <textarea name="description" class="summernote" ><?php if(!empty($activity['description'])  && isset($activity)){ echo $activity['description'];}elseif(!empty($activity_add['description'])){echo $activity_add['description'];} ?></textarea>  
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                        <div class="col-md-8">
                                                            <label for="images">活动图片</label><br>
                                                            <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail" data-original-title="" title="图片上传">
                                                                <img height="100px" src="<?php echo base_url(); ?>upload/image/<?php echo empty($activity['thumb']) ? 'no_image.png' : $activity['thumb']; ?>" alt="" title="" data-placeholder="<?php echo empty($activity['thumb']) ? 'no_image.png' : $activity['thumb']; ?>">
                                                            </a>
                                                            <input type="hidden" name="thumb" value="<?php echo empty($activity['thumb']) ? 'no_image.png' : $activity['thumb']; ?>" id="input-image">
                                                        </div>
                                                    </div>
                                        
                                        <div class="form-group">
                                                <label class="col-sm-1 control-label" for="expiretime">开始时间</label>
                                            <div class="col-md-3">
                                                <div class="input-group date">
                                                    <input type="text" name="start_time" value="<?php if(!empty($activity['start_time'])  && isset($activity)){ echo date('Y-m-d H:i:s', $activity['start_time']);}elseif(!empty($activity_add['start_time'])){echo $activity_add['start_time'];} ?>" placeholder="开始日期" data-date-format="YYYY-MM-DD HH:mm:ss" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-sm-1 control-label" for="expiretime">结束时间</label>
                                            <div class="col-md-3">
                                                <div class="input-group date">
                                                    <input type="text" name="end_time" value="<?php if(!empty($activity['end_time'])  && isset($activity)){ echo date('Y-m-d H:i:s', $activity['end_time']);}elseif(!empty($activity_add['end_time'])){echo $activity_add['end_time'];} ?>" placeholder="结束时间" data-date-format="YYYY-MM-DD HH:mm:ss" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="">限制人数</label>
                                                <input type="text" name="number" value="<?php if(!empty($activity['number'])  && isset($activity)){ echo $activity['number'];}elseif(!empty($activity_add['number'])){echo $activity_add['number'];}?>" class="form-control" placeholder="限制报名人数,不填则表示不限制" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="">报名费用</label>
                                                <input type="text" name="price" value="<?php if(!empty($activity['price'])  && isset($activity)){ echo $activity['price'];}elseif(!empty($activity_add['price'])){echo $activity_add['price'];}?>" class="form-control" placeholder="报名费用" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                         <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('Activity/index')?>'">返回</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                <?php include 'public_footer.php'; ?>
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
        <script src="plugins/summernote/summernote.js"></script>
        <script src="plugins/summernote/lang/summernote-zh-CN.js"></script>
        <script src="plugins/summernote/upload.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootbox.js"></script>
        <script src="plugins/bootstrap-datetimepicker/moment.js"></script>
        <script src="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript">
            $('.date').datetimepicker({
                pickTime: false
            });
        </script>
    </body>
</html>
