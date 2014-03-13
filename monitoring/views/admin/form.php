<section class="title">
	<h4>Shop form</h4>
</section>

<section class="item">
<?= form_open('admin/monitoring/save');?>
<table style="border: 1px solid #eee;">
	<tr>
		<td>Region:</td>
		<td><?= form_dropdown('region', $regions, (isset($shop[0]->region_id)) ? $shop[0]->region_id : "");?></td>
	</tr>
	<tr>
		<td>Code:</td>
		<td><?= form_input('code', (isset($shop[0]->code)) ? $shop[0]->code : "");?></td>
	</tr>
	<tr>
		<td>Name:</td>
		<td><?= form_input('name', (isset($shop[0]->name)) ? $shop[0]->name : "");?></td>
	</tr>
	<tr>
		<td>Address</td>
		<td><?= form_textarea('address', (isset($shop[0]->address)) ? $shop[0]->address : "");?></td>
	</tr>
	<tr>
		<td>State</td>
		<td><?= form_dropdown('state', array('' => 'Select one', '1' => 'Open', '2' => 'Close'), (isset($shop[0]->state)) ? $shop[0]->state : ""); ?></td>
	</tr>
	<tr>
		<td>Is are terminal mode?</td>
		<td><?= form_dropdown('tmode', array('' => 'Select one', '1' => 'Yes', '2' => 'No'), (isset($shop[0]->tmode)) ? $shop[0]->tmode : ""); ?></td>
	</tr>
	<tr>
		<td colspan="2">
			<button class="btn blue" value="save" name="btnAction" type="submit"><span>Save</span></button>
				&nbsp;&nbsp;
			<a class="btn-more" href="/admin/monitoring">Cancel</a>
		</td>
	</tr>
</table>

<?php 
 if(isset($shop[0]->id)){
?>
<input type="hidden" name="id" value="<?= $shop[0]->id; ?>">
<?php } ?>

<?= form_close(); ?>
</section>