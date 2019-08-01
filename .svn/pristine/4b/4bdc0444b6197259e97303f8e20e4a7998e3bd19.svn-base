<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title ?></title>
        <base href = '<?php echo base_url() . "zmcc/views/" ?>'/>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="plugins/ionicons-2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="./dist/css/ZMShop.min.css">
        <link rel="stylesheet" href="./plugins/iCheck/flat/blue.css">
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
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        系统配置
                        <small>系统配置</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li class="active">系统配置</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary  ">
                        <div class="box-header with-border">
                            <h3 class="box-title">系统配置</h3>
                        </div>
                    </div>
                    <div class="nav-tabs-custom select-messages">
                        <ul class="nav nav-tabs">
                            <?php $i=0;foreach ($settings as $setting) { ?>
                                <li <?php if($i==0) echo 'class="active"'?>>
                                    <a href="#tab_<?php echo $setting['setting_id'] ?>" data-toggle="tab" aria-expanded="true"><?php echo $setting['setting_group'] ?></a>
                                </li>
                            <?php $i++;} ?>
                        </ul>
                        <form role="form" method="post" name="setting_form">
                            <div class="tab-content">
                                <?php $ki=0; foreach ($settings as $setting) { ?>
                                    <div class="tab-pane <?php if($ki==0){?>active<?php }?>" id="tab_<?php echo $setting['setting_id'] ?>">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box-body">
                                                    <?php foreach ($setting['items'] as $item) { ?>
                                                        <div class="form-group">
                                                            <div class="col-md-8">
                                                                <label for="<?php echo 'item-' . $item['setting_id'] ?>">
                                                                    <?php echo $item['setting_name'] ?>
                                                                    
                                                                </label>
                                                                <?php if(!empty($item['description'])){?>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;<i style="color:red"><?php echo $item['description']?></i>
                                                                    <?php }?>
                                                                
                                                                <?php if ($item['setting_type'] == "text") { ?>
                                                                    <input type="text" class="form-control" id="<?php echo 'item-' . $item['setting_id'] ?>" 
                                                                           name="<?php echo $item['setting_key']?>" value="<?php echo !empty($item['setting_value']) ? $item['setting_value'] : "" ?>">
                                                                       <?php } ?>

                                                                <?php if ($item['setting_type'] == "textarea") { ?>
                                                                    <textarea id="<?php echo 'item-' . $item['setting_id'] ?>"  class="form-control"  name="<?php echo $item['setting_key']?>" >
                                                                        <?php echo $item['setting_value'] ?>
                                                                    </textarea>
                                                                <?php } ?>
                                                                <?php if ($item['setting_type'] == "select") { ?>
                                                                    <select name="<?php echo $item['setting_key']?>"  class="form-control"  id="<?php echo 'item-' . $item['setting_id'] ?>">
                                                                        <?php foreach ($item['options'] as $key=>$option) { ?>
                                                                            <option  value="<?php echo $option ?>"  <?php if($option==$item["setting_value"]) echo "selected";?>><?php echo $key ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                <?php } ?>
                                                                <?php if ($item['setting_type'] == "checkbox") { ?><br>
                                                                    <?php foreach ($item['options'] as $key => $option) { ?>
                                                                        <input type="checkbox" name="<?php echo $item['setting_key']?>"  class="form-control"   value="<?php echo $option ?>"  <?php if($option==$item["setting_value"]) echo "checked";?>><?php echo $key ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($item['setting_type'] == "radio") { ?><br>
                                                                    <?php foreach ($item['options'] as $key => $option) { ?>
                                                                        <input type="radio" name="<?php echo $item['setting_key']?>"  class="form-control"  value="<?php echo $option ?>" <?php if($option==$item["setting_value"]) echo "checked";?>><?php echo $key ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">保存</button>
                                                         <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('Welcome/index')?>'">返回</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php $ki++; } ?>
                            </div>
                        </form>
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
        <script src="./dist/js/app.min.js"></script>
        <script src="./plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="./plugins/iCheck/icheck.min.js"></script>
        <script src="./dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
        <script src="./dist/js/common.js"></script>
        <script src="./dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
            $("form[name=setting_form]").submit(function(){
                var t1 = $("input[type=checkbox]");
                for(i=0;i<t1.length;i++)
                {
                    if(!(t1[i].checked))
                    {
                        t1[i].checked = true;
                        t1[i].value = "0";
                    }
                }
            })
        </script>
    </body>
</html>