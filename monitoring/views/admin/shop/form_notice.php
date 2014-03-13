<section class="title">
	<h4>Shop form</h4>
</section>

<section class="item">
<?php echo form_open_multipart('admin/monitoring/shop/notice');?>
<table style="width: 450px; border: 1px solid #eee;">
	<tr>
		<td>Notice type:</td>
		<td><?= form_dropdown('notice_id', array('' => 'Select one', '1' => 'Notice', '2' => 'Warning', '3' => 'Error'));?></td>
	</tr>
	<tr>
		<td>Shop:</td>
		<td><?= form_dropdown('shop_id', $shops, $active_shop);?></td>
	</tr>
	<tr>
		<td>Subject:</td>
		<td><?= form_input('subject');?></td>
	</tr>
	<tr>
		<td>Comment:</td>
		<td><?= form_textarea('comment');?></td>
	</tr>
	<tr>
		<td>Send an email to a support group:</td>
		<td><?= form_checkbox('email', 1);?></td>
	</tr>
	<tr>
		<td colspan="2">
			<button class="btn blue" value="save" name="btnAction" type="submit"><span>Save</span></button>
				&nbsp;&nbsp;
			<a class="btn-more" href="/admin/monitoring/shop/view/<?= $active_shop; ?>">Cancel</a>
		</td>
	</tr>
</table>
<?= form_close(); ?>
</section>