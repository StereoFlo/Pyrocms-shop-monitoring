<section class="title">
	<h4>Assign a provider</h4>
</section>

<section class="item">
<?php echo form_open('admin/monitoring/shop/assign_provider/?action=save');?>
<table style="width: 450px; border: 1px solid #eee;">
	<tr>
		<td>Provider:</td>
		<td><?= form_dropdown('provider', $providers, (isset($active_provider)) ? $active_provider : '');?></td>
	</tr>
	<tr>
		<td>Shop:</td>
		<td><?= form_dropdown('shop', $shops, (isset($active_shop)) ? $active_shop : '');?></td>
	</tr>
	<tr>
		<td>IP</td>
		<td><?= form_input('ip', (isset($network[0]->ip)) ? $network[0]->ip : "");?></td>
	</tr>
	<tr>
		<td>MASK</td>
		<td><?= form_input('mask', (isset($network[0]->mask)) ? $network[0]->mask : "");?></td>
	</tr>
	<tr>
		<td>GATE</td>
		<td><?= form_input('gate', (isset($network[0]->gate)) ? $network[0]->gate : "");?></td>
	</tr>
	<tr>
		<td>Speed</td>
		<td><?= form_input('speed', (isset($network[0]->speed)) ? $network[0]->speed : "");?></td>
	</tr>
	<tr>
		<td>Comment</td>
		<td><?= form_textarea('comment', (isset($network[0]->comment)) ? $network[0]->comment : "");?></td>
	</tr>
	<tr>
		<td colspan="2">
			<button class="btn blue" value="save" name="btnAction" type="submit"><span>Save</span></button>
				&nbsp;&nbsp;
			<a class="btn-more" href="/admin/monitoring">Cancel</a>
		</td>
	</tr>
</table>
<input type="hidden" name="type" value="1">
<? if(isset($network[0]->id)){ ?>
<input type="hidden" name="id" value="<?= $network[0]->id; ?>">
<? } ?>
<?= form_close(); ?>
</section>