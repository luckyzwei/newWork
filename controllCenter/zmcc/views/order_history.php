<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<tr>
				<td class="text-left">添加日期</td>
				<td class="text-left">备注</td>
				<td class="text-left">操作人</td>
			</tr>
		</thead>
		<tbody>
	   <?php foreach ($orderlog as $value){?>
			<tr>
				<td class="text-left"><?php echo date('Y-m-d H:m',$value['createtime'])?></td>
				<td class="text-left"><?php echo $value['content']?></td>
				<td class="text-left"><?php echo $value['operator_id']?></td>
			</tr>
	   <?php }?>
		</tbody>
	</table>
</div>
