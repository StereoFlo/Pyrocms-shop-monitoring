<section class="title">
	<h4>Shop view</h4>
</section>
<section class="item">
    <table style="width: 100%">
        <tr>
            <td style="width: 50%;">
                <table style="border: 1px solid #eee;">
                        <tr>
                                <td>ID:</td>
                                <td><?= $shop[0]->id;?></td>
                        </tr>
                        <tr>
                                <td>Code:</td>
                                <td><?= $shop[0]->code;?></td>
                        </tr>
                        <tr>
                                <td>Name:</td>
                                <td><?= $shop[0]->name;?></td>
                        </tr>
                        <tr>
                                <td>Address</td>
                                <td><?= $shop[0]->address;?></td>
                        </tr>
                        <tr>
                                <td>State</td>
                                <td><?= $shop[0]->state;?></td>
                        </tr>
                        <tr>
                                <td>Region</td>
                                <td><?= isset($region[0]->name) ? $region[0]->name : "&nbsp;";?></td>
                        </tr>
			<tr>
				<td>Phone</td>
				<td><?= isset($phone->id) ? '<a href="/admin/monitoring/phones/view/'.$phone->pool_id.'">'.$phone->phone.'</a>' : '<a href="/admin/monitoring/phones">assign a phone</a>'?></td>
			</tr>
                </table>
            </td>
            <td style="width: 50%; vertical-align: top">
		<table style="border: 1px solid #eee;">
		<? if (isset($providers)) { ?>
                        <tr>
                                <td colspan=6>Providers of the shop:</td>
                        </tr>
			<?  foreach ($providers as $provider) { ?>
                        <tr id="tip_<?= $provider['provider_id'];?>" title="Speed: <?= $provider['speed'];?><br/>Comment: <?= $provider['comment'];?>">
				<? if ($provider['state'] == 1) { ?>
				<td><div style="height: 10px; width: 10px; background: green"></div></td>
				<? } else { ?>
				<td><div style="height: 10px; width: 10px; background: red"></div></td>
				<? } ?>
                                <td><a href="/admin/monitoring/providers/view/<?= $provider['provider_id'];?>"><?= $provider['provider_name'];?></a></td>
				<td>IP: <?= $provider['ip'];?></td>
				<td>MASK: <?= $provider['mask'];?></td>
				<td>GATE: <?= $provider['gate'];?></td>
				<td><a href="/admin/monitoring/networks/delete/<?= $provider['id'];?>">X</a></td>
                        </tr>
			<? } ?>
			<tr>
				<td colspan=6>
					<p style="text-align: center"><a href="/admin/monitoring/shop/assign_provider?shop=<?= $active_shop;?>">U can to add one more provider</a></p>
				</td>
			</tr>
		<? } else { ?>
			<tr>
				<td>
					<div class="no_data">no shops found</div>
					<p style="text-align: center"><a href="/admin/monitoring/shop/assign_provider?shop=<?= $active_shop;?>">Assign provider to this shop</a></p>
				</td>
			</tr>
		<? } ?>
		</table>
            </td>
        </tr>
    </table>
    <p>&nbsp;</p>
    <table style="border: 1px solid #eee;">
	<tr>
		<th>Type</th>
		<th>Subject</th>
		<th>Message</th>
		<th>Date</th>
	</tr>
	<? if ($notices) { ?>
	<? foreach ($notices as $notice) { ?>
	<tr>
		<td>
			<? if ($notice->notice_id == 1) print "<div style='color: gray'>[NOTICE]</div>";?>
			<? if ($notice->notice_id == 2) print "<div style='color: orange'>[WARNING]</div>";?>
			<? if ($notice->notice_id == 3) print "<div style='color: red'>[ERROR]</div>";?>
		</td>
		<td><?= $notice->subject;?></td>
		<td><?= $notice->comment;?></td>
		<td><?= $notice->date;?></td>
	</tr>
	<? } ?>
	<? } else { ?>
	<tr>
		<td colspan=4>
			<div class="no_data">no noticies found for this shop, u can to add a <a href="/admin/monitoring/shop/notice?shop=<?= $shop[0]->id;?>">new notice</a></div>
		</td>
	</tr>
	<? } ?>
    </table>
    <p>&nbsp;</p>
    <table style="border: 1px solid #eee;">
    <? if (isset($addreses)) { ?>
        
		<tr>
			<th>State</th>
			<th>Address</th>
			<th>DNS name</th>
			<th>Type</th>
			<th>
				Manage
				<?= anchor('admin/monitoring/shop/network_delete/' . $active_shop, lang('global:delete'), array('class'=>'button delete')); ?>
				<?= anchor('admin/monitoring/shop/network_update/' . $active_shop, 'Update', array('class'=>'button delete')); ?>
			</th>
		</tr>
		<? foreach ($addreses as $address) { ?>
                <tr>
			<? if ($address->state == 1) { ?>
			<td><div style="height: 10px; width: 10px; background: green"></div></td>
			<? } else { ?>
			<td><div style="height: 10px; width: 10px; background: red"></div></td>
			<? } ?>
                        <td><?= $address->ip;?></td>
			<td><?= $address->host;?></td>
			<td><?= $address->type;?></td>
			<td class="actions">
				<?= anchor('admin/monitoring/shop/edit_ip/edit/' . $address->id, lang('global:edit'), array('class'=>'button delete')); ?>
			</td>
                </tr>
		<? } ?>
     <? } else { ?>
		<td>
			<div class="no_data">no local networks found</div>
			<p style="text-align: center"><a href="/admin/monitoring/shop/network_add/<?= $active_shop;?>/add">Add a local network</a></p>
		</td>
     <? } ?>
     </table>
</section>