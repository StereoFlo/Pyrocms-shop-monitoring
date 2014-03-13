<section class="title">
	<h4>Networks</h4>
</section>
<section class="item">
<? if (!empty($networks)) { ?>
<div id="filter-stage">
			<table border="0" class="table-list">
				<thead>
					<tr>
						<th>ID</th>
						<th>provider</th>
						<th>shop</th>
						<th>type</th>
						<th>ip</th>
						<th>mask</th>
						<th>gate</th>
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
					<?php foreach ($networks as $network) { ?>
						<tr>
							<td class="collapse"><?= $network['id']; ?></td>
							<? if (isset($network['provider_id']) and isset($network['provider_name'])) { ?>
							<td class="collapse"><a href="/admin/monitoring/shop/view/<?= $network['provider_id']; ?>"><?= $network['provider_name']; ?></a></td>
							<? } else { ?>
							<td class="collapse"><a href="/admin/monitoring/shop/assign_provider?shop=<?= isset($network['shop_id']);?>">assign a provider</a></td>
							<? } ?>
							<? if (isset($network['shop_id']) and isset($network['shop_name'])) { ?>
							<td class="collapse"><a href="/admin/monitoring/shop/view/<?= $network['shop_id']; ?>"><?= $network['shop_name']; ?></a></td>
							<? } else { ?>
							<td class="collapse"><a href="/admin/monitoring/shop/assign_provider?provider=<?= isset($network['provider_id']);?>">assign a shop</a></td>
							<? } ?>
							<td class="collapse"><?= $network['type']; ?></td>
							<td class="collapse"><?= $network['ip']; ?></td>
							<td class="collapse"><?= $network['mask']; ?></td>
							<td class="collapse"><?= $network['gate']; ?></td>
							<td class="actions">
								<?php echo anchor('admin/monitoring/providers/edit/' . $network['id'], lang('global:edit'), array('class'=>'button delete')); ?>
								<?php echo anchor('admin/monitoring/networks/delete/' . $network['id'], lang('global:delete'), array('class'=>'button delete')); ?>
							</td>
							</tr>
					<? } ?>
				</tbody>
			</table>
</div>
<? } else { ?>
    <div class="no_data">no networks found</div>
<? } ?>

</section>