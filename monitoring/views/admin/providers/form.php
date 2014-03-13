<section class="title">
	<h4>Shop form</h4>
</section>

<section class="item">
<?php echo form_open('admin/monitoring/providers/save');?>
<table style="width: 450px; border: 1px solid #eee;">
	<tr>
		<td>Name:</td>
		<td><?= form_input('name', (isset($provider[0]->name)) ? $provider[0]->name : "");?></td>
	</tr>
	<tr>
		<td>Dogovor:</td>
		<td><?= form_input('dogovor', (isset($provider[0]->dogovor)) ? $provider[0]->dogovor : "");?></td>
	</tr>
	<tr>
		<td>Manager phone:</td>
		<td><?= form_input('manager_phone', (isset($provider[0]->manager_phone)) ? $provider[0]->manager_phone : "");?></td>
	</tr>
	<tr>
		<td>tech phone:</td>
		<td><?= form_input('tech_phone', (isset($provider[0]->tech_phone)) ? $provider[0]->tech_phone : "");?></td>
	</tr>
	<tr>
		<td>Comment:</td>
		<td><?= form_textarea('comment', (isset($provider[0]->comment)) ? $provider[0]->comment : "");?></td>
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
 if(isset($provider[0]->id)){
?>
<input type="hidden" name="id" value="<?= $provider[0]->id; ?>">
<?php } ?>

<?= form_close(); ?>
</section>