<section class="title">
	<h4>Shop form</h4>
</section>
<section class="item">
<?php echo form_open('admin/monitoring/shop/edit_ip/save/' . $active_ip);?>
<table style="width: 450px; border: 1px solid #eee;">
	<tr>
		<td>Select a type:</td>
		<td><?= form_dropdown('type', $types, $ip[0]->type);?></td>
	</tr>
	<tr>
		<td colspan="2">
			<button class="btn blue" value="save" name="btnAction" type="submit"><span>Save</span></button>
				&nbsp;&nbsp;
			<a class="btn-more" href="/admin/monitoring/providers">Cancel</a>
		</td>
	</tr>
</table>

<?php 
 if(isset($ip[0]->id)){
?>
<input type="hidden" name="id" value="<?= $ip[0]->id; ?>">
<?php } ?>

<?= form_close(); ?>
</section>