<section class="title">
	<h4><?= lang('view_sended_messages'); ?></h4>
</section>

<section class="item">
<div>
	<form action="/admin/monitoring/index" method="get" accept-charset="utf-8">
		<input style="width: 80%" type="text" name="q" value="" placeholder="Enter a word"  />
		<button style="width: 18%" type="submit" class="btn blue"><span>Search for shop</span></button>
	</form>
</div>
<? if (!empty($shops)) { ?>
<div id="filter-stage">
			<table border="0" class="table-list">
				<thead>
					<tr>
						<th>ID</th>
						<th>Code</th>
						<th>Name</th>
						<th>Address</th>
						<th>Status</th>
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
					<? foreach ($shops as $shop): ?>
						<tr>
							<td class="collapse"><?= $shop->id; ?></td>
							<td class="collapse"><?= $shop->code; ?></td>
							<td class="collapse"><?= $shop->name; ?></td>
							<td class="collapse"><a target="_blank" href="http://maps.google.ru/?q=<?= $shop->address; ?>"><?= $shop->address; ?></a></td>
							<td class="collapse"><?= isset($shop->state) ? "Open" : "Close"; ?></td>
							<td class="actions">
								<?= anchor('admin/monitoring/shop/view/' . $shop->id, lang('global:view'), array('class'=>'button delete')); ?>
								<?= anchor('admin/monitoring/edit/' . $shop->id, lang('global:edit'), array('class'=>'button delete')); ?>
								<?= anchor('admin/monitoring/delete/' . $shop->id, lang('global:delete'), array('class'=>'button delete')); ?>
							</td>
							</tr>
					<? endforeach; ?>
				</tbody>
			</table>
</div>
<? } else { ?>
    <div class="no_data">shops is not found</div>
<? } ?>

</section>