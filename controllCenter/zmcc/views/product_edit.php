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
        <link href="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
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
                        商品管理
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> 主页</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url("Product/index"); ?>">商品管理</a>
                        </li>
                        <li class="active">修改商品</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include 'public_middletips.php'; ?>
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">修改商品</h3>
                            <div onclick="$('#form-product-data').submit();" class="btn btn-primary pull-right">保存</div>
                        </div>

                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1" data-toggle="tab" aria-expanded="true">基本信息</a>
                                </li>
                                <li class="">
                                    <a href="#tab_6" data-toggle="tab" aria-expanded="false">商品聚合</a>
                                </li>
                                <li class="">
                                    <a href="#tab_7" data-toggle="tab" aria-expanded="false">商品图片</a>
                                </li>
                                <li class="">
                                    <a href="#tab_3" data-toggle="tab" aria-expanded="false">规格属性</a>
                                </li>
                                <li class="">
                                    <a href="#tab_4" data-toggle="tab" aria-expanded="false">分销和折扣</a>
                                </li>

                            </ul>
                            <form role="form" action="<?php echo site_url('product/editProduct');?>" method="post" id="form-product-data">
                                <div class="tab-content margin">
                                    <div class="tab-pane active " id="tab_1">

                                        <!-- form start -->
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="">商品名称</label>&nbsp;&nbsp;<i class="tip" style="font-size:12px;color:#cccccc">必须填写</i>
                                                <input type="text" class="form-control" id="" name="product_name" value="<?php echo empty($product_name) ? '' : $product_name; ?>" placeholder="商品名称">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">
                                                <label >商品短名称</label>
                                                <input  class="form-control" name="short_name" value="<?php echo empty($short_name) ? '' : $short_name; ?>" placeholder="商品短标题"/>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="product_sn">商品编号</label>&nbsp;&nbsp;<i class="tip" style="font-size:12px;color:#cccccc">不填写系统将会自动生成一个</i>
                                                <input type="text" class="form-control" value="<?php echo empty($product_sn) ? '' : $product_sn; ?>" id="product_sn" name='product_sn' placeholder="商品编号">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label for="price">商品价格</label>&nbsp;&nbsp;<i class="tip" style="font-size:12px;color:#cccccc">必须填写</i>
                                                <input type="text" class="form-control" value="<?php echo empty($price) ? '' : $price; ?>" id="price" name='price' placeholder="商品出售价格">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="market_price">商品市场价</label>
                                                <input type="text" class="form-control" value="<?php echo empty($market_price) ? '' : $market_price; ?>" id="market_price" name='market_price' placeholder="商品市场价">
                                            </div>

                                            <div class="col-md-2">
                                                <label for="in_price">商品进价</label>
                                                <input type="text" class="form-control" value="<?php echo empty($in_price) ? '' : $in_price; ?>" id="goodsPrice" name="in_price" placeholder="商品进价">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label for="weight">商品重量(g)</label>
                                                <input type="text" class="form-control" value="<?php echo empty($weight) ? '' : $weight; ?>" id="weight" name="weight" placeholder="商品重量（单位：克）">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="store_number">商品库存</label>
                                                <input type="text" class="form-control" value="<?php echo empty($store_number) ? '9999' : $store_number; ?>" id="store_number" name="store_number" placeholder="商品库存">
                                            </div>

                                            <div class="col-md-2">
                                                <label for="product_sn">商品排序</label>
                                                <input type="text" class="form-control" value="<?php echo empty($sort) ? '' : $sort; ?>" id="sort" name='sort' placeholder="值越大越靠前">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label for="">可用最大积分</label>
                                                <input type="text" class="form-control" name="apply_intergal" value='<?php if(!empty($apply_intergal)):echo $apply_intergal;endif;?>' placeholder="购买时可用积分的最大数量">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="">接受定制</label>
                                                <select class="form-control" name='ratio_intergal'>
                                                    <option value="0" <?php if(empty($ratio_intergal)||$ratio_intergal==0):echo "selected";endif;?>>不接受</option>
                                                    <option value="1" <?php if(!empty($ratio_intergal)&&$ratio_intergal==1):echo "selected";endif;?>>接受</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">赠送积分</label>
                                                <input type="text" class="form-control" name="give_intergal" value='<?php if(!empty($give_intergal)):echo $give_intergal;endif;?>'  placeholder="购买时赠送X积分">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label for="">供货商</label>
                                                <select class="form-control" name='supplier_id'>
                                                    <option value="0">平台商品</option>
                                                    <?php if(!empty($suppliers)): foreach($suppliers as $supplier):?>
                                                    <option value="<?php echo $supplier['supplier_id']?>" <?php if(!empty($supplier_id)&&$supplier_id==$supplier['supplier_id']):echo "selected";endif;?>>
                                                        <?php echo $supplier['name']?>
                                                    </option>
                                                    <?php endforeach;endif;?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">商品状态</label>
                                                <select class="form-control" name='status'>
                                                    <option value="1" <?php if(!empty($status)&&$status==1):echo "selected";endif;?>>上架</option>
                                                    <option value="2" <?php if(!empty($status)&&$status==2):echo "selected";endif;?>>不上架</option>
                                                </select>
                                            </div>
                                        
                                            <div class="col-md-2">
                                                <label for="">库存状态</label>
                                                <select class="form-control" name='check_store'>
                                                    <option value="0" <?php if($check_store==0):echo "selected";endif;?>>遵从系统配置</option>
                                                    <option value="1" <?php if(!empty($check_store)&&$check_store==1):echo "selected";endif;?>>启用</option>
                                                    <option value="2" <?php if(!empty($check_store)&&$check_store==2):echo "selected";endif;?>>不启用</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                         <div class="col-md-3">
                                                <label for="">可使用积分抵扣</label>
                                                <select class="form-control" name='intergral_deduce'>
                                                    <option value="0" <?php if(empty($intergral_deduce)||$intergral_deduce==0):echo "selected";endif;?>>否</option>
                                                    <option value="1" <?php if(!empty($intergral_deduce)&&$intergral_deduce==1):echo "selected";endif;?>>是</option>
                                                </select>
                                            </div>
                                            </div>

                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label>简介描述</label>
                                                <textarea name="explain" class="form-control" ><?php echo empty($explain) ? '' : $explain; ?></textarea>  
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label>商品描述</label>
                                                <textarea name="description" class="summernote"><?php echo empty($description) ? '' : $description; ?></textarea>  
                                            </div>
                                        </div>

                                    </div>

                                    <!--规格属性-->
                                    <div class="tab-pane" id="tab_3">
                                        <div class="row" style="padding:5px">
                                            <div class="col-md-2">
                                                <div class="box  box-info">
                                                    <div class="box-header with-border">
                                                        <h5 class="box-title">选择商品类型</h5>
                                                    </div>
                                                    <div class="box-body">
                                                        <!-- the events -->
                                                        <div id="external-events">
                                                            <button type="button" class="btn btn-block btn-info btn-sm"  onclick="javascript:getAttrAndSpe(0)">自定义类型</button>
                                                            <?php foreach ($commodityTyps as $cdytyp): ?>
                                                                <button type="button" class="btn btn-block btn-info btn-sm" 
                                                                        onclick="javascript:getAttrAndSpe(<?php echo $cdytyp['cdytyp_id'] ?>)"><?php echo $cdytyp['cdytyp_name'] ?></button>
                                                                    <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                    <!-- /.box-body -->
                                                </div>
                                                <div class="box box-info">
                                                    <div class="box-header with-border">
                                                        <h4 class="box-title">商品属性 &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle" style="color:#00c0ef" id="addAttribute" onclick="javascript:addAttribute();"></i></h4>
                                                    </div>
                                                    <div class="box-body" id="attribute_div">
                                                        <div class="row" id="attribute-div-tpl" style="display: none">
                                                            <div class="col-sm-4">
                                                                <input type="text" name="attribute_name[]" placeholder='名称' disabled="disabled" class="form-control">
                                                            </div>
                                                            <div class="input-group col-sm-6">
                                                                <input type="text" name="attribute_value[]" class="form-control" disabled="disabled" placeholder='属性值'>
                                                                <span class="input-group-addon"><i class="fa fa-minus" style="color:red" onclick="javascript:minusAttribute(this)"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if(!empty($attribute_name)):foreach($attribute_name as $key=>$name):?>
                                                   
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <input type="text" name="attribute_name[]" placeholder='名称' value='<?php echo $name?>' class="form-control">
                                                            </div>
                                                            <div class="input-group col-sm-6">
                                                                <input type="text" name="attribute_value[]" class="form-control" value='<?php echo $attribute_value[$key]?>' placeholder='属性值'>
                                                                <span class="input-group-addon"><i class="fa fa-minus" style="color:red" onclick="javascript:minusAttribute(this)"></i></span>
                                                            </div>
                                                        </div>
                                                    
                                                    <?php endforeach; endif;?>
                                                    <!-- /.box-body -->
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="box box-info">
                                                    <div class="box-header with-border">
                                                        <h4 class="box-title">商品规格</h4>
                                                        <div class="box-tools">
                                                            <div  class="row col-xs-9 pull-right">
                                                                <div class="col-xs-3">
                                                                    <input type="text" value='' id="special_name" placeholder='规格名称' class="form-control">
                                                                </div>
                                                                <div class="input-group col-xs-9">
                                                                    <input type="text" value='' id='special_options' class="form-control"  placeholder='规格选项请用逗号隔开'>
                                                                    <span class="input-group-addon"><i class="fa fa-plus" style="color:#00c0ef" onclick="javascript:addSpeical()"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <table class="table table-bordered">
                                                            <tbody id="specialTable">

                                                            </tbody></table>
                                                    </div>
                                                    <!-- /.box-body -->
                                                </div>
                                            </div>

                                        </div>  
                                    </div>

                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_4">
                                        <div class="row" style="padding:5px">
                                            <div class="col-md-7">
                                                <div class="box box-default">
                                                    <div class="box-header with-border">
                                                        <h4 class="box-title">商品分销 &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle" style="color:#00c0ef" id="addAttribute" onclick="javascript:addAgent();"></i></h4>
                                                    </div>
                                                    <div class="box-body" id="agent_div">
                                                        <div class="row" id="agent_div_tpl" style="display: none">
                                                            <div class="col-sm-4">
                                                                <select name="agent_group[]" disabled="disabled" class="form-control">
                                                                    <?php foreach ($agentgrouplist as $agentList): ?>
                                                                        <option value="<?php echo $agentList['agent_group_id'] ?>"><?php echo $agentList['agent_group_name'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <input type="text" name="agent_commission[]" placeholder='一级分成' disabled="disabled" class="form-control">
                                                            </div>
                                                            <div class="input-group col-sm-3">
                                                                <input type="text" name="agent_commission[]" placeholder='二级分成' disabled="disabled" class="form-control">
                                                            
                                                                <span class="input-group-addon"><i class="fa fa-minus" style="color:red" onclick="javascript:minusAgent(this)"></i></span>
                                                            </div>
                                                            <br>
                                                        </div>
                                                        
                                                        <?php if(!empty($agent_group)): 
                                                            foreach($agent_group as $key=>$agent):
                                                            $commission=array_slice($agent_commission,$key*2,2);?>
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <select name="agent_group[]" class="form-control">
                                                                    <?php foreach ($agentgrouplist as $agentList): ?>
                                                                        <option value="<?php echo $agentList['agent_group_id'] ?>" <?php if($agent==$agentList['agent_group_id']):echo "selected";endif;?>><?php echo $agentList['agent_group_name'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <input type="text" name="agent_commission[]" value='<?php echo $commission[0]?>' placeholder='一级分成' class="form-control">
                                                            </div>
                                                            <div class="input-group col-sm-3">
                                                                <input type="text" name="agent_commission[]"  value='<?php echo $commission[1]?>' placeholder='二级分成' class="form-control">
                                                            
                                                                <span class="input-group-addon"><i class="fa fa-minus" style="color:red" onclick="javascript:minusAgent(this)"></i></span>
                                                            </div>
                                                            <br>
                                                        </div>
                                                        <?php endforeach;endif;?>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-7">
                                                <div class="box box-default">
                                                    <div class="box-header with-border">
                                                        <h4 class="box-title">会员折扣 &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle" style="color:#00c0ef" id="addAttribute" onclick="javascript:addUserGroupdiscount();"></i></h4>
                                                    </div>
                                                    <div class="box-body" id="discount_div">
                                                        <div class="row" id="discount_div_tpl" style="display: none">
                                                            <div class="col-sm-3">
                                                                <select name="user_group[]" disabled="disabled" class="form-control">
                                                                    <?php foreach ($usergrouplist as $usergroup): ?>
                                                                        <option value="<?php echo $usergroup['user_group_id'] ?>"><?php echo $usergroup['user_group_name'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                           
                                                            <div class="input-group col-sm-8">
                                                                <input type="text" name="user_group_discount[]" placeholder='折扣/或者固定价格,90%表示9折，90表示固定价格为90元' disabled="disabled" class="form-control">
                                                                <span class="input-group-addon"><i class="fa fa-minus" style="color:red" onclick="javascript:minusUserGroupdiscount(this)"></i></span>
                                                            </div>
                                                            <br>
                                                        </div>
                                                        
                                                        <?php if(!empty($user_group)):
                                                            foreach($user_group as $key=>$group):?>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <select name="user_group[]"  class="form-control">
                                                                    <?php foreach ($usergrouplist as $usergroup): ?>
                                                                        <option value="<?php echo $usergroup['user_group_id'] ?>" <?php if($usergroup['user_group_id']==$group):echo "selected";endif;?>><?php echo $usergroup['user_group_name'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                           
                                                            <div class="input-group col-sm-8">
                                                                <input type="text" name="user_group_discount[]" value='<?php echo $user_group_discount[$key]?>' placeholder='折扣/或者固定价格,90%表示9折，90表示固定价格为90元'  class="form-control">
                                                                <span class="input-group-addon"><i class="fa fa-minus" style="color:red" onclick="javascript:minusUserGroupdiscount(this)"></i></span>
                                                            </div>
                                                            <br>
                                                        </div>
                                                        
                                                            <?php
                                                            endforeach;
                                                            endif;?>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_6">

                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="product_category">商品分类</label>&nbsp;&nbsp;<i class="tip" style="font-size:12px;color:#cccccc">必须选择</i>
                                                <input type="text" class="form-control" id="product_category" placeholder="商品分类">
                                                <div id="product-category" class="well well-sm" style="height: 150px;overflow: auto">
                                                    <?php
                                                    if (!empty($category_id)) {
                                                        foreach ($category_id as $key => $value) {
                                                            echo '<div id="product-category' . $value['category_id'] . '"><i class="fa fa-minus-circle"></i> ' . $value['category_name'] . '<input type="hidden" name="category_id[' . $key . '][category_id]" value="' . $value['category_id'] . '" /><input type="hidden" name="categories[' . $key . '][category_name]" value="' . $value['category_name'] . '" /></div>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="product_tag">关联标签</label>
                                                <input type="text" class="form-control" id="product_tag" name="product_tag" placeholder="关联标签">
                                                <div id="product-tag" class="well well-sm" style="height: 150px;overflow: auto">
                                                    <?php
                                                    if (!empty($product_tag_id)) {
                                                        foreach ($product_tag_id as $key => $value) {
                                                            echo '<div id="product-tag' . $value['product_tag_id'] . '"><i class="fa fa-minus-circle"></i> ' . $value['tag_name'] . '<input type="hidden" name="product_tag_id[' . $key . '][product_tag_id]" value="' . $value['product_tag_id'] . '" /><input type="hidden" name="product_tags[' . $key . '][tag_name]" value="' . $value['tag_name'] . '" /></div>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label for="product_link">关联商品</label>
                                                <input type="text" class="form-control" id="product_link" name="product_link" placeholder="关联商品">
                                                <div id="product-link" class="well well-sm" style="height: 150px;overflow: auto">
                                                    <?php
                                                    if (!empty($link_product_id)) {
                                                        foreach ($link_product_id as $key => $value) {
                                                            echo '<div id="product-link' . $value['link_product_id'] . '"><i class="fa fa-minus-circle"></i> ' . $value['product_name'] . '<input type="hidden" name="link_product_id[' . $key . '][link_product_id]" value="' . $value['link_product_id'] . '" /><input type="hidden" name="link_product_id[' . $key . '][product_name]" value="' . $value['product_name'] . '" /></div>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="tab_7">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="box box-solid">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">图像预览</h3>
                                                    </div>
                                                    <!-- /.box-header -->
                                                    <div class="box-body">
                                                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                                            <ol class="carousel-indicators">
                                                                <?php if(!empty($product_images)):foreach($product_images as $key=>$image):?>
                                                                <li data-target="#carousel-example-generic" data-slide-to="<?php echo $key?>" class="<?php if($key==0):?>active<?php endif;?>"></li>
                                                                <?php endforeach;else:?>
                                                                <li data-target="#carousel-example-generic" data-slide-to="0" class=""></li>
                                                                <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                                                                <li data-target="#carousel-example-generic" data-slide-to="2" class="active"></li>
                                                                <?php endif;?>
                                                            </ol>
                                                            <div class="carousel-inner">
                                                                 <?php if(!empty($product_images)):$slide=0;foreach($product_images as $key=>$image):?>
                                                                <div class="item <?php if($slide==0):?>active<?php endif;?>">
                                                                    <img src="<?php echo $this->zmsetting->get('img_url').$this->zmsetting->get('file_upload_dir').$image?>" alt="slide">
                                                                </div>
                                                                <?php $slide++; endforeach;else:?>
                                                                
                                                                <div class="item">
                                                                    <img src="http://placehold.it/900x500/39CCCC/ffffff&amp;text=This+is+Demo+ESANER" alt="First slide">
                                                                </div>
                                                                <div class="item">
                                                                    <img src="http://placehold.it/900x500/3c8dbc/ffffff&amp;text=This+is+Demo+ESANER" alt="Second slide">
                                                                </div>
                                                                <div class="item active">
                                                                    <img src="http://placehold.it/900x500/f39c12/ffffff&amp;text=This+is+Demo+ESANER" alt="Third slide">
                                                                </div>
                                                                <?php endif;?>
                                                            </div>
                                                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                                                <span class="fa fa-angle-left"></span>
                                                            </a>
                                                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                                                <span class="fa fa-angle-right"></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <!-- /.box-body -->
                                                </div>
                                                <!-- /.box -->
                                            </div>
                                            <div class="col-md-5">
                                                <div class="box box-solid">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">图像操作区</h3>
                                                        &nbsp;尺寸:800*800
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="row" id="productImageList">
                                                            <?php if(!empty($product_images)):foreach($product_images as $key=>$image):?>
                                                            
                                                            <a class="col-sm-4 img-thumbnail margin" id="productImage" data-toggle='image' name='imgAlink'>
                                                                <img src="<?php echo $show_images[$key]?>" height='120px' width='130px' name='imgProductShow'>
                                                                <input type="hidden" name="product_images[]" value="<?php echo $image?>">
                                                            </a>
                                                            <?php endforeach;endif;?>
                                                            
                                                            <a class="col-sm-4 img-thumbnail margin" id="productImage" data-toggle='image' name='imgAlink'>
                                                                <img src="/upload/image/no_image.png" height='120px' width='130px' name='imgProductShow'>
                                                                <input type="hidden" name="product_images[]" value="/no_image.png">
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <input type="hidden" value="" id="special_struct" name="special_struct">
                                        <input type="hidden" value="<?php echo $product_id?>"  name="product_id">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                        <button type="button" class="btn btn-prompt" onclick="location.href = '<?php echo site_url("product/index");?>'">返回</button>
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
            <div id="hiddenDiv"></div>
        </div>
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="plugins/iCheck/icheck.min.js"></script>
        <script src="dist/js/changethemes.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/common.js"></script>
        <script src="dist/js/js.cookie-2.1.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="plugins/bootstrap-datetimepicker/moment.js"></script>
        <script src="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="plugins/summernote/summernote.js"></script>
        <script src="plugins/summernote/lang/summernote-zh-CN.js"></script>
        <script src="plugins/summernote/upload.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootbox.js"></script>
        <script type="text/javascript">
                                            var specification = [];
                                            var goods_code=[];
                                            <?php if(!empty($special_struct)):
                                                echo "specification=".$special_struct;
                                            endif;?>
                                            <?php if(!empty($goods_code)):
                                                if(empty($hidenChk)):
                                                    $hidenChk=array();
                                                endif;
                                                echo "\r\n goods_code=".json_encode($goods_code).";";
                                                echo "\r\n plus_price=".json_encode($plus_price).";";
                                                echo "\r\n goods_store=".json_encode($goods_store).";";
                                                if(!empty($specialimg)):
                                                    echo "\r\n specialimg=".json_encode($specialimg).";";
                                                    echo "\r\n show_specialimg=".json_encode($show_specialimg).";";
                                                endif;
                                                echo "\r\n hidenChk=".json_encode($hidenChk).";";
                                                endif;?>
                                                    
                                                $(function(){
                                                    showSpecification();//回显规格
                                                });
                                                function setSpecialValue(){
                                                    for(var g in goods_code){
                                                        $("[name='plus_price["+goods_code[g]+"]']").val(plus_price[goods_code[g]]);
                                                        $("[name='goods_store["+goods_code[g]+"]']").val(goods_store[goods_code[g]]);
                                                        <?php if(!empty($specialimg)):?>
                                                        $("[name='specialimg["+goods_code[g]+"]']").val(specialimg[goods_code[g]]);
                                                        $("#a_specialimg"+goods_code[g]+"").find('img').attr('src', show_specialimg[goods_code[g]]);//a_specialimggoods_0
                                                        <?php endif;?>
                                                        if(typeof hidenChk[goods_code[g]]!="undefined"&&hidenChk[goods_code[g]]!="0"){
                                                            $("[name='hidenChk["+goods_code[g]+"]']").attr("checked",true);
                                                        }
                                                    }
                                                }
                                            function productSlide() {
                                                var imglength = $("#productImageList").find("img").length;
                                                if (imglength > 1) {
                                                    var dotHtml = "";
                                                    var imgHtml = "";

                                                    $("#productImageList :input").each(function (index) {
                                                        if (index < imglength-1) {
                                                            var active="";
                                                            if(index==0) {
                                                                active="active";
                                                            }
                                                            dotHtml += ' <li data-target="#carousel-example-generic" data-slide-to="' + index + '" class=""></li>'
                                                            imgHtml += ' <div class="item '+active+'"><img src="<?php echo $this->zmsetting->get('img_url').$this->zmsetting->get('file_upload_dir')?>' + $(this).val() + '" alt="图' + index + '"></div>';
                                                        }
                                                    });
                                                   // $("#carousel-example-generic").carousel('pause');
                                                    $(".carousel-indicators").html(dotHtml);
                                                    $(".carousel-inner").html(imgHtml);
                                                    $("#carousel-example-generic").carousel('cycle');
                                                }
                                            }

                                            /*增加商品属性*/
                                            function addAttribute() {
                                                var attrHtml = $("#attribute-div-tpl").clone();
                                                attrHtml.removeAttr("id");
                                                attrHtml.find(":input").removeAttr("disabled");
                                                attrHtml.show();
                                                $("#attribute_div").append(attrHtml);

                                            }
                                            /*减少商品属性*/
                                            function minusAttribute(m) {
                                                $(m).parent().parent().parent().remove();
                                            }

                                            /**增加商品规格**/
                                            function addSpeical() {
                                                var special_name = $.trim($("#special_name").val());
                                                var special_options = $.trim($("#special_options").val());
                                                if (special_name === "" || special_options === "") {
                                                    bootbox.alert("请将规格项数据填写完整");
                                                    return;
                                                }
                                                special_options = special_options.replace(/，/ig, ",");
                                                var optionsArray = special_options.split(",");

                                                var data = {"special_name": special_name, "specification": optionsArray};
                                                for (var x in specification) {
                                                    var merge = false;
                                                    if (specification[x].special_name == special_name) {
                                                        specification[x].specification = MergeArray(specification[x].specification, optionsArray);
                                                        merge = true;
                                                    }

                                                }
                                                if (!merge) {
                                                    specification.push(data);
                                                }
                                                showSpecification();
                                            }
                                            function minusSpecial(i) {
                                                specification.splice(i, 1);
                                                showSpecification();
                                            }


                                            //合并并去重
                                            function MergeArray(arr1, arr2) {
                                                var _arr = new Array();
                                                for (var i = 0; i < arr1.length; i++) {
                                                    if (arr1[i] != "") {
                                                        _arr.push(arr1[i]);
                                                    }
                                                }
                                                for (var i = 0; i < arr2.length; i++) {
                                                    var flag = true;
                                                    for (var j = 0; j < arr1.length; j++) {
                                                        if (arr2[i] == arr1[j]) {
                                                            flag = false;
                                                            break;
                                                        }
                                                    }
                                                    if (flag && arr2[i] != "") {
                                                        _arr.push(arr2[i]);
                                                    }
                                                }
                                                return _arr;
                                            }

                                            function getAttrAndSpe(cdytyp_id) {
                                                if (cdytyp_id === 0) {
                                                    $("#attribute_div").children("div:gt(0)").remove();
                                                    $("#specialTable").html("");
                                                } else {
                                                    $.get('<?php echo site_url("product/getAttrAndSpecial") ?>?cdytyp_id=' + cdytyp_id,
                                                            function (res) {
                                                                specification = res.specification;
                                                                showAttribute(res.attribute);
                                                                showSpecification();
                                                            }, 'json')
                                                }
                                            }

                                            function showAttribute(attributes) {
                                                $("#attribute_div").children("div").each(function (index) {
                                                    if (index > 0) {
                                                        $(this).remove();
                                                    }
                                                });

                                                for (var i in attributes) {
                                                    var attributeCon = $("#attribute-div-tpl").clone(true);
                                                    attributeCon.removeAttr("id");
                                                    attributeCon.find(":input").removeAttr("disabled");
                                                    attributeCon.find("[name='attribute_name[]']").val(attributes[i]);
                                                    $("#attribute_div").append(attributeCon);
                                                    attributeCon.show();
                                                }
                                            }

                                            function showSpecification() {
                                                $("#specialTable").html("");
                                                $("#special_struct").val(JSON.stringify(specification));
                                                
                                                var thhtml = "";

                                                var trhtml = "";//三列数据是固定的
                                                //处理表头
                                                for (var i in specification) {
                                                    thhtml += "<th>" + specification[i].special_name + " &nbsp;<i class='fa fa-minus-circle' style='color:red' onclick='javascript:minusSpecial(" + i + ")'></i></th>";
                                                    trhtml += "<td></td>";
                                                }
                                                thhtml = "<tr>" + thhtml + "<th class='bg-aqua disabled' style='width:15%'>货品码</th><th class='bg-aqua disabled'  style='width:15%'>价格(￥)</th><th class='bg-aqua disabled'  style='width:15%'>库存</th><th class='bg-aqua disabled' style='width:200px'>缩略图</th><th class='bg-aqua disabled' style='width:5%'>隐藏</th></tr>";
                                                trhtml = "<tr isnew='1'>" + trhtml + "<td></td><td></td><td></td><td></td><td></td></tr>";


                                                $("#specialTable").append(thhtml);
                                                var specialfications = [];
                                                for (var x in specification) {
                                                    specialfications.push(specification[x].specification);
                                                }

                                                for (var s in specialfications) {
                                                    if (s === "0") {
                                                        for (var item in specialfications[s]) {
                                                            var itemkey = item;
                                                            $("#specialTable").append(trhtml);
                                                            $("#specialTable").find("tr:gt(0)").attr("name", "0");
                                                            $("[isnew='1'").find("td").eq(s).html(specialfications[s][item]);
                                                            $("[isnew='1'").attr("keyIndex", itemkey);
                                                            $("[isnew='1'").attr("parentkeyIndex", itemkey);
                                                            //如果是最后一个级别，加入input
                                                            if (s == (specialfications.length - 1)) {
                                                                var inputHtml = "goods_" + itemkey + "<input type='hidden' value='goods_" + itemkey + "' name='goods_code[]'>";
                                                                $("[isnew='1']").find("td").eq(parseInt(s) + 1).html(inputHtml);
                                                                var inputHtml = "<div class='form-group'><input size='8' class='form_control' value='0' name='plus_price[goods_" + itemkey + "]'></div>";
                                                                $("[isnew='1']").find("td").eq(parseInt(s) + 2).html(inputHtml);
                                                                var inputHtml = "<input class='form_control' size='8' value='0' name='goods_store[goods_" + itemkey + "]'>";
                                                                $("[isnew='1']").find("td").eq(parseInt(s) + 3).html(inputHtml);
                                                                var specialimg = '<a class="col-sm-8 img-thumbnail"  data-toggle="image" id="a_specialimggoods_' + itemkey + '" ><img src="/upload/image/no_image.png" height="90px" width="90px" > </a><input id="specialimggoods_' + itemkey + '" type="hidden" value="/no_image.png" name="specialimg[goods_' + itemkey + ']">';
                                                                $("[isnew='1']").find("td").eq(parseInt(s) + 4).html(specialimg);
                                                                var hide = '<input type="checkbox" value="1" name="hidenChk[goods_' + itemkey + ']">';
                                                                $("[isnew='1']").find("td").eq(parseInt(s) + 5).html(hide);
                                                            }
                                                            $("[isnew='1']").removeAttr("isnew");
                                                        }
                                                        setSpecialValue();
                                                    } else {
                                                        $("[name='" + (parseInt(s) - 1) + "']").each(function (index) {
                                                            for (var item in specialfications[s]) {
                                                                var keyIndex = $(this).attr("keyIndex") + "-" + item;
                                                                $(this).after(trhtml);
                                                                $("[isnew='1']").attr("name", (parseInt(s)));
                                                                $("[isnew='1'").attr("keyIndex", keyIndex);
                                                                $("[isnew='1'").attr("parentkeyIndex", $(this).attr("keyIndex"));
                                                                $("[isnew='1']").find("td").eq(s).html(specialfications[s][item]);
                                                                //如果是最后一个级别，加入input
                                                                if (s == (specialfications.length - 1)) {
                                                                    var inputHtml = "goods_" + keyIndex + "<input type='hidden' value='goods_" + keyIndex + "' name='goods_code[]'>";
                                                                    $("[isnew='1']").find("td").eq(parseInt(s) + 1).html(inputHtml);
                                                                    var inputHtml = "<div class='form-group'><input size='8' class='form_control' value='0' name='plus_price[goods_" + keyIndex + "]'></div>";
                                                                    $("[isnew='1']").find("td").eq(parseInt(s) + 2).html(inputHtml);
                                                                    var inputHtml = "<input class='form_control' size='8' value='0' name='goods_store[goods_" + keyIndex + "]'>";
                                                                    $("[isnew='1']").find("td").eq(parseInt(s) + 3).html(inputHtml);
                                                                    var specialimg = '<a class="col-sm-8 img-thumbnail"  data-toggle="image" id="a_specialimggoods_' + keyIndex + '" ><img src="/upload/image/no_image.png" height="90px" width="90px" > </a><input id="specialimggoods_' + keyIndex + '" type="hidden" value="/no_image.png" name="specialimg[goods_' + keyIndex + ']">';
                                                                    $("[isnew='1']").find("td").eq(parseInt(s) + 4).html(specialimg);
                                                                    var hide = '<input type="checkbox" value="1" name="hidenChk[goods_' + keyIndex + ']">';
                                                                    $("[isnew='1']").find("td").eq(parseInt(s) + 5).html(hide);
                                                                }

                                                                $("[isnew='1']").removeAttr("isnew");
                                                            }
                                                        })
                                                        setSpecialValue();
                                                    }
                                                }

                                            }

                                            $('.date').datetimepicker({
                                                pickTime: false
                                            });

                                            /**分销折扣设置**/
                                            function addAgent() {
                                                var newAgent = $("#agent_div_tpl").clone();
                                                newAgent.css("display", "block");
                                                newAgent.find("[disabled='disabled']").removeAttr("disabled");
                                                $("#agent_div").append(newAgent);
                                            }
                                            function minusAgent(mine) {
                                                $(mine).parent().parent().parent().remove();
                                            }
                                            
                                             function addUserGroupdiscount() {
                                                var newDis = $("#discount_div_tpl").clone();
                                                newDis.css("display", "block");
                                                newDis.find("[disabled='disabled']").removeAttr("disabled");
                                                $("#discount_div").append(newDis);
                                            }
                                            function minusUserGroupdiscount(mine) {
                                                $(mine).parent().parent().parent().remove();
                                            }
                                            
                                            
                                            /*分销折扣设置结束*/

                                            var category_row =<?php
                if (!empty($category_id)) {
                    echo count($category_id, COUNT_NORMAL) > 0 ? count($category_id, COUNT_NORMAL) : 0;
                } else {
                    echo 0;
                }
                ?>;
                                            $('#product_category').autocomplete({
                                                'source': function (request, response) {
                                                    $.ajax({
                                                        url: '<?php echo site_url('Product/autoCategory') ?>?parent_id=' + request,
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
                                                    $('input[name=\'product_category\']').val('');
                                                    $('#product-category' + item['value']).remove();
                                                    $('#product-category').append('<div id="product-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="category_id[' + category_row + '][category_id]" value="' + item['value'] + '" /><input type="hidden" name="category_id[' + category_row + '][category_name]" value="' + item['label'] + '" /></div>');
                                                    category_row++;
                                                }
                                            });
                                            $('#product-category').delegate('.fa-minus-circle', 'click', function () {
                                                $(this).parent().remove();
                                            });
                                            var tag_row =<?php
                if (!empty($product_tag_id)) {
                    echo count($product_tag_id, COUNT_NORMAL) > 0 ? count($product_tag_id, COUNT_NORMAL) : 0;
                } else {
                    echo 0;
                }
                ?>;
                                            $('input[name=\'product_tag\']').autocomplete({
                                                'source': function (request, response) {
                                                    $.ajax({
                                                        url: '<?php echo site_url('Tag/autoTag') ?>?file_tag=' + request,
                                                        dataType: 'json',
                                                        success: function (json) {
                                                            response($.map(json, function (item) {
                                                                return {
                                                                    label: item['tag_name'],
                                                                    value: item['product_tag_id']
                                                                }
                                                            }));
                                                        }
                                                    });
                                                },
                                                'select': function (item) {
                                                    $('input[name=\'product_tag\']').val('');
                                                    $('#product-tag' + item['value']).remove();
                                                    $('#product-tag').append('<div id="product-tag' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_tag_id[' + tag_row + '][product_tag_id]" value="' + item['value'] + '" /><input type="hidden" name="product_tag_id[' + tag_row + '][tag_name]" value="' + item['label'] + '" /></div>');
                                                    tag_row++;
                                                }
                                            });
                                            $('#product-tag').delegate('.fa-minus-circle', 'click', function () {
                                                $(this).parent().remove();
                                            });
                                            var link_row = <?php
                if (!empty($link_product_id)) {
                    echo count($link_product_id, COUNT_NORMAL) > 0 ? count($link_product_id, COUNT_NORMAL) : 0;
                } else {
                    echo 0;
                }
                ?>;
                                            $('input[name=\'product_link\']').autocomplete({
                                                'source': function (request, response) {
                                                    $.ajax({
                                                        url: '<?php echo site_url('Product/autoProduct') ?>?parent_id=' + request,
                                                        dataType: 'json',
                                                        success: function (json) {
                                                            response($.map(json, function (item) {
                                                                return {
                                                                    label: item['product_name'],
                                                                    value: item['product_id']
                                                                }
                                                            }));
                                                        }
                                                    });
                                                },
                                                'select': function (item) {
                                                    $('input[name=\'product_link\']').val('');
                                                    $('#product-link' + item['value']).remove();
                                                    $('#product-link').append('<div id="product-link' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="link_product_id[' + link_row + '][link_product_id]" value="' + item['value'] + '" /><input type="hidden" name="link_product_id[' + link_row + '][product_name]" value="' + item['label'] + '" /></div>');
                                                    link_row++;
                                                }
                                            });

                                            $('#product-link').delegate('.fa-minus-circle', 'click', function () {
                                                $(this).parent().remove();
                                            });
        </script>
        <!--关联-->
    </body>

</html>