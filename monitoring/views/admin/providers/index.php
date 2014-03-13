<section class="title">
	<h4><?= lang('view_sended_messages'); ?></h4>
</section>
<section class="item">
<div>
	<form action="/admin/monitoring/providers/index" method="get" accept-charset="utf-8">
		<input style="width: 80%"  type="text" name="q" value="" placeholder="Enter a word"  />
		<button style="width: 18%"  type="submit" class="btn blue"><span>Search for provider</span></button>
	</form>
</div>
<? if (!empty($providers)) { ?>
<div id="filter-stage">
			<table border="0" class="table-list">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>dogovor</th>
						<th>manager_phone</th>
						<th>tech_phone</th>
						<th>comment</th>
						<th>date</th>
						<th>Manage</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="8">
							<div class="inner"><?= $pagination['links']; ?></div>
						</td>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach ($providers as $provider): ?>
						<tr>
							<td class="collapse"><?= $provider->id; ?></td>
							<td class="collapse"><?= $provider->name; ?></td>
							<td class="collapse"><?= $provider->dogovor; ?></td>
							<td class="collapse"><?= $provider->manager_phone; ?></td>
							<td class="collapse"><?= $provider->tech_phone; ?></td>
							<td class="collapse"><?= $provider->comment; ?></td>
							<td class="collapse"><?= $provider->date; ?></td>
							<td class="actions">
								<?php echo anchor('admin/monitoring/providers/view/' . $provider->id, lang('global:view'), array('class'=>'button delete')); ?>
								<?php echo anchor('admin/monitoring/providers/edit/' . $provider->id, lang('global:edit'), array('class'=>'button delete')); ?>
								<?php echo anchor('admin/monitoring/providers/delete/' . $provider->id, lang('global:delete'), array('class'=>'button delete')); ?>
							</td>
							</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
</div>
<? } else { ?>
    <div class="no_data">no providers found</div>
<? } ?>

</section>