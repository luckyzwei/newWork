<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--商品属性-->

<div class="col-sm-5">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title small">商品属性 <i class="fa fa-plus-circle" style="color:green" id="addAttribute"  onclick="javascript:addAttribute()">添加</i></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <table class="table table-condensed">
                <tbody>
                    <?php foreach($attribute as $attr):?>
                    <tr>
                        <td style="width:10%"><input value="<?php echo $attr?>" name='attribute_name[]' class="form-control"></td>
                        <td><input value="<?php echo $attr?>" name='attribute_value[]' class="form-control"></td>
                    </tr>
                    <?php endforeach;?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--商品规格-->
<div class="col-sm-8">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">商品规格 <i class="fa fa-plus-circle" style="color:green" id="addSpecial" onclick="javascript:addSpecial()">添加</i></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <table class="table table-condensed">
                <tbody>
                    <?php foreach($specification as $sepcial):?>
                    <tr>
                        <td style="width:10%">蓝色</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="width:10%"></td>
                        <td>xl</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="width:10%"></td>
                        <td></td>
                        <td>骏马：库存<input > 加价<input></td>

                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
</div>
