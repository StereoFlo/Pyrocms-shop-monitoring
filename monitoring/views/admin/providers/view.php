<section class="title">
	<h4>Provider view</h4>
</section>

<section class="item">
    <table style="width: 100%">
        <tr>
            <td style="width: 50%;">
                <table style="border: 1px solid #eee;">
                        <tr>
                                <td>ID:</td>
                                <td><?= $provider[0]->id;?></td>
                        </tr>
                        <tr>
                                <td>Name:</td>
                                <td><?= $provider[0]->name;?></td>
                        </tr>
                        <tr>
                                <td>Dogovor:</td>
                                <td><?= $provider[0]->dogovor;?></td>
                        </tr>
                        <tr>
                                <td>manager_phone</td>
                                <td><?= $provider[0]->manager_phone;?></td>
                        </tr>
                        <tr>
                                <td>tech_phone</td>
                                <td><?= $provider[0]->tech_phone;?></td>
                        </tr>
                        <tr>
                                <td>comment</td>
                                <td><?= $provider[0]->comment;?></td>
                        </tr>
                        <tr>
                                <td>date</td>
                                <td><?= $provider[0]->date;?></td>
                        </tr>
                </table>
            </td>
            <td style="width: 50%; vertical-align: top">
		<table style="border: 1px solid #eee;">
		<? if (isset($networks)) { ?>
		
                        <tr>
                                <th colspan="3">Shops use this provider:</a></th>
                        </tr> 
		<? foreach ($networks as $network) { ?>
                        <tr>
                                <td>Shop:</td>
                                <td><a href="/admin/monitoring/shop/view/<?= $network['shop_id'];?>"><?= $network['shop_name'];?></a></td>
				<td><a href="/admin/monitoring/networks/delete/<?= $network['id'];?>">X</a></td>
                        </tr>              
		<? } ?>
		
		<? } else { ?>
			<td>
			<div class="no_data">no shops found</div>
			<p style="text-align: center"><a href="/admin/monitoring/shop/assign_provider?provider=<?= $active_provider;?>">Assign shop to this provider</a></p>
			</td>
		<? } ?>
		</table>
            </td>
        </tr>
    </table>
</section>