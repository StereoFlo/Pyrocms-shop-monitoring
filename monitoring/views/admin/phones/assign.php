<section class="title">
	<h4>Edit a phone</h4>
</section>

<section class="item">
<?= form_open('/admin/monitoring/phones/phone/save');?>
<table style="width: 450px; border: 1px solid #eee;">
	<tr>
		<td>Shop:</td>
		<td><?= form_dropdown('shop_id', $shops);?></td>
	</tr>
	<tr>
		<td>Number:</td>
		<td><?= form_dropdown('phone', $phones, isset($active_phone[0]->id) ? $active_phone[0]->id : '');?></td>
	</tr>
	<tr>
		<td colspan="2">
			<button class="btn blue" value="save" name="btnAction" type="submit"><span>Save</span></button>
				&nbsp;&nbsp;
			<a class="btn-more" href="/admin/monitoring/phones">Cancel</a>
		</td>
	</tr>
</table>
<? if (isset($active_phone[0]->id)) { ?>
	<input type="hidden" name="active_phone" value="<?= $active_phone[0]->id; ?>" />
<? } ?>
<?= form_close(); ?>
</section>