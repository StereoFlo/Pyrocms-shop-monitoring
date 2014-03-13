<section class="title">
	<h4>Shop form</h4>
</section>

<section class="item">
<?php echo form_open('admin/monitoring/shop/network_add/'. $shop_id .'/save');?>
<table style="width: 450px; border: 1px solid #eee;">
	<tr>
		<td>Network:</td>
		<td><?= form_input('network');?> (10.183.0.0/29) </td>
	</tr>

	<tr>
		<td colspan="2">
			<button class="btn blue" value="save" name="btnAction" type="submit"><span>Save</span></button>
				&nbsp;&nbsp;
			<a class="btn-more" href="/admin/monitoring/providers">Cancel</a>
		</td>
	</tr>
</table>
<?= form_close(); ?>
</section>