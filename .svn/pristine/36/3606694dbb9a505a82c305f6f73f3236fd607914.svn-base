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
                        商品类型管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('CommodityTyp/index'); ?>"> 商品类型管理</a>
                        </li>
                        <li class="active">新增商品类型</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <form role="form" method="post" id='form-cdytyp' action="<?php echo site_url('commodityTyp/commodityTypEdit'); ?>">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="cdytyp_name">类型名称</label>
                                                <input type="text" name="cdytyp_name" value="<?php echo $cdytyp['cdytyp_name']?>" placeholder="商品类型名称"  class="form-control">
                                                <input type="hidden" name="cdytyp_id" value="<?php echo $cdytyp['cdytyp_id']?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="attribute">类型属性 &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle" style="color:green" id="addAttribute">添加</i></label>
                                            </div>

                                        </div>
                                        <block id="attributes">
                                            <?php
                                            if(!empty($cdytyp['attribute'])):$i=0;
                                            foreach($cdytyp['attribute'] as $attribute):?>
                                            <div class="form-group col-md-8"<?php if($i==0):?> id="attribute_html" <?php endif;?>>
                                                <div class="input-group col-sm-3">
                                                    <input type="text" name="attribute_name[]" value="<?php echo $attribute?>"  placeholder="属性名称" class="form-control col-xs-3">
                                                    <span class="input-group-addon"><i class="fa fa-minus-circle" style="color:red" name="minus-attribute" onclick="javascript:minusAttribute(this);"></i></span>
                                                </div>
                                            </div>
                                            <?php $i++; endforeach;else:;?>
                                            <div class="form-group col-md-8" id="attribute_html" style="display: none">
                                                <div class="input-group col-sm-3">
                                                    <input type="text" name="attribute_name[]" value=""  placeholder="属性名称" class="form-control col-xs-3" disabled="disabled">
                                                    <span class="input-group-addon"><i class="fa fa-minus-circle" style="color:red" name="minus-attribute" onclick="javascript:minusAttribute(this);"></i></span>
                                                </div>
                                            </div>
                                            <?php endif;?>
                                        </block>

                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="sepcifiation">类型规格&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle" style="color:green" id="addSpecifiation" onclick="javascript:addSpecifiation()">添加</i></label>
                                            </div>
                                        </div>
                                        <block id="specifications">
                                            <?php $i=0; $len=count($cdytyp['specification']);
                                            if($len):
                                                foreach($cdytyp['specification'] as $specifi):?>
                                            <div class="form-group col-md-8" <?php if($i==0):?> id="specification_html" <?php endif;?> name="specification_group">
                                                <div class="input-group col-sm-6">
                                                    <input type="text" name="specification_name[]" value="<?php echo $specifi['special_name']?>"  placeholder="<?php echo $len-$i?>级规格分组名称" class="form-control" value="<?php echo $specifi['special_name']?>" >
                                                    <textarea name="specification_options[]"  placeholder="规格选项（每行一个）" class="form-control" rows="5" ><?php echo implode("\r\n", $specifi['specification'])?></textarea>
                                                    <span class="input-group-addon"><i class="fa fa-minus-circle" style="color:red" name="minus-attribute" onclick="javascript:minusSpecifiation(this);"></i></span>
                                                </div>
                                            </div>
                                            <?php $i++; endforeach;else:?>
                                            <div class="form-group col-md-8"  id="specification_html" name="specification_group" style="display: none">
                                                <div class="input-group col-sm-6">
                                                    <input type="text" name="specification_name[]" value=""  placeholder="1级规格分组名称" class="form-control"  disabled="disabled">
                                                    <textarea name="specification_options[]"  placeholder="规格选项（每行一个）" class="form-control" rows="5"  disabled="disabled"></textarea>
                                                    <span class="input-group-addon"><i class="fa fa-minus-circle" style="color:red" name="minus-attribute" onclick="javascript:minusSpecifiation(this);"></i></span>
                                                </div>
                                            </div>
                                            <?php endif;?>
                                        </block>

                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="sort">类型备注</label>
                                                <textarea class="form-control" name="remark"><?php echo $cdytyp['remark']?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="button" class="btn btn-primary" id="saveCdyTyp">保存</button>
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url('commodityTyp/index'); ?>'">返回</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>

        </section>
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
    <script src="dist/js/bootbox.js"></script>
    <script src="dist/js/common.js"></script>
    <script>
                                            $(function () {
                                                /**添加属性**/
                                                $("#addAttribute").click(function () {
                                                    if ($("#attribute_html").css("display") === "none") {
                                                        $("#attribute_html").show();
                                                        $("#attribute_html").find(":input").removeAttr("disabled");

                                                    } else {
                                                        var newAttribute = $("#attribute_html").clone();//克隆原始对象
                                                        newAttribute.removeAttr("id").find(":input").val("");
                                                        $("#attributes").prepend(newAttribute);

                                                    }
                                                });
                                                /*保存按钮*/
                                                $("#saveCdyTyp").click(function () {
                                                    var inputData = $("#form-cdytyp").serialize();
                                                    var postUrl = $("#form-cdytyp").attr("action");
                                                    $.post(postUrl, inputData, function (res) {
                                                        if (res.error) {
                                                            bootbox.alert({
                                                                message:res.msg,
                                                                size:"small"
                                                            })
                                                        }
                                                        else{
                                                            location.href='<?php echo site_url("commodityTyp/index")?>'
                                                        }
                                                    }, 'json');
                                                })

                                            });
                                            /**减少属性**/
                                            function minusAttribute(e) {
                                                var divElem = $(e).parent().parent().parent();
                                                var divId = divElem.attr("id");
                                                if (divId === "attribute_html") {
                                                    $("#attribute_html").find(":input").val("");
                                                    divElem.hide();
                                                    $("#attribute_html").find(":input").attr("disabled", "disabled");
                                                } else {
                                                    divElem.remove();
                                                }
                                            }
                                            /**添加商品规格*/
                                            function addSpecifiation() {
                                                if ($("#specification_html").css("display") === "none") {
                                                    $("#specification_html").show();
                                                    $("#specification_html").find(":input").removeAttr("disabled");
                                                    $("#specification_html").find("textarea").removeAttr("disabled");
                                                } else {
                                                    var newSpe = $("#specification_html").clone();//克隆原始对象

                                                    var nameplaceholder = ($("[name='specification_group']").length + 1) + "级分组名称";
                                                    var optionplaceholder = ($("[name='specification_group']").length + 1) + "级规格选项（每行一个）";
                                                    newSpe.removeAttr("id").find(":input").val("").attr("placeholder", nameplaceholder);
                                                    newSpe.find("textarea").val("").attr("placeholder", optionplaceholder);

                                                    $("#specifications").prepend(newSpe);
                                                }
                                            }

                                            /**减少规格**/
                                            function minusSpecifiation(e) {
                                                var divElem = $(e).parent().parent().parent();
                                                var divId = divElem.attr("id");
                                                if (divId === "specification_html") {
                                                    $("#specification_html").find(":input").val("");
                                                    $("#specification_html").find("textarea").val("");
                                                    $("#specification_html").find(":input").attr("disabled", "disabled");
                                                    $("#specification_html").find("textarea").attr("disabled", "disabled");
                                                    divElem.hide();
                                                } else {
                                                    divElem.remove();
                                                    //重新编号
                                                    var groupList = $("[name='specification_group']").length;
                                                    $("[name='specification_group']").each(function () {
                                                        var nameplaceholder = groupList + "级分组名称";
                                                        var optionplaceholder = groupList + "级规格选项（每行一个）";
                                                        $(this).find(":input").attr("placeholder", nameplaceholder);
                                                        $(this).find("textarea").attr("placeholder", optionplaceholder);
                                                        groupList--;
                                                    });
                                                }
                                            }
    </script>
</body>
</html>