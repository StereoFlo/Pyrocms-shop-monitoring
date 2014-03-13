    <? if (isset($shop[0]->address)) { ?>
    <script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
    <script type='text/javascript'>
        ymaps.ready(init);
    
        function init(){
    
            var geocoder = new ymaps.geocode(
                '<?= $shop[0]->address ?>',
                { results: 1 }
            );
            geocoder.then(
                    function (res) {
                        var coord = res.geoObjects.get(0).geometry.getCoordinates();
    
                        var map = new ymaps.Map('map', {
                            center: coord,
                            zoom: 7,
                            behaviors: ['default', 'scrollZoom'],
                            controls: ['mapTools']
                        });
                        map.geoObjects.add(res.geoObjects.get(0));
                        map.zoomRange.get(coord).then(function(range){
                            map.setCenter(coord, range[1] - 1)
                        });
                        map.controls.add('mapTools')
                                .add('zoomControl')
                                .add('typeSelector');
    
                    }
            );
        }
    </script>
    <? } ?>
<h1>Shop: <?= $shop[0]->name; ?></h1>
<div class="tabsblock">
	<ul class="tabs">
		<li name="main" class="active">
			<a href="#main">Main</a>
		</li>
		<li name="provider">
			<a href="#provider">Provider</a>
		</li>
		<li name="networks">
			<a href="#networks">Networks</a>
		</li>
		<li name="notices">
			<a href="#notices">Notices</a>
		</li>
	</ul>
	<div id="tab_main" class="info">
		<table>
			<tr>
				<td>
					ID:
				</td>
				<td>
					<?= $shop[0]->id; ?>
				</td>
			</tr>
			<tr>
				<td>
					Code:
				</td>
				<td>
					<?= $shop[0]->code; ?>
				</td>
			</tr>
			<tr>
				<td>
					Name:
				</td>
				<td>
					<?= $shop[0]->name; ?>
				</td>
			</tr>
			<tr>
				
				<td colspan='2'>
					<? if (isset($shop[0]->address)) { ?>
					<table>
						<tr>
							<td>Address:</td>
							<td><p><?= $shop[0]->address ?></p></td>
						</tr>
						<tr>
							<td colspan='2'>
								<div id='map' style='width: 550px; height: 400px'></div>
							</td>
						</tr>
					</table>
					<? } else { ?>
					<p>no address for this shop</p>
					<? } ?>
				</td>
			</tr>
			<tr>
				<td>
					State
				</td>
				<td>
					<?= isset($shop[0]->state) ? $shop[0]->state : 'No set'; ?>
				</td>
			</tr>
			<tr>
				<td>
					Region
				</td>
				<td>
					<?= $region[0]->name; ?>
				</td>
			</tr>
		</table>
	</div>
	<div id="tab_networks" class="info hidden">
		<table style="border: 1px solid #eee; width: 100%">
		<? if (isset($addreses)) { ?>
		    
			    <tr>
				    <th>State</th>
				    <th>Address</th>
				    <th>DNS name</th>
				    <th>Type</th>
			    </tr>
			    <? foreach ($addreses as $address) { ?>
			    <tr onmouseover="this.bgColor='#e0e0e0';" onmouseout="this.bgColor='';">
				    <? if ($address->state == 1) { ?>
				    <td><div style="height: 10px; width: 10px; background: green"></div></td>
				    <? } else { ?>
				    <td><div style="height: 10px; width: 10px; background: red"></div></td>
				    <? } ?>
				    <td><?= $address->ip;?></td>
				    <td><?= $address->host;?></td>
				    <td><?= $address->type;?></td>
			    </tr>
			    <? } ?>
		 <? } else { ?>
			    <td>
				    <div class="no_data">no local networks found</div>
				    <p style="text-align: center"><a href="/admin/monitoring/shop/network_add/<?= $active_shop;?>/add">Add a local network</a></p>
			    </td>
		 <? } ?>
		 </table>
	</div>

	<div id="tab_notices" class="info hidden">
		<table style="width: 100%">
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
	</div>
	<div id="tab_provider" class="info hidden">
		<table style="border: 1px solid #eee; width: 100%">
		<? if (isset($providers)) { ?>
			<?  foreach ($providers as $provider) { ?>
                        <tr id="tip_<?= $provider['provider_id'];?>" title="Speed: <?= $provider['speed'];?><br/>Comment: <?= $provider['comment'];?>">
				<? if ($provider['state'] == 1) { ?>
				<td><div style="height: 10px; width: 10px; background: green"></div></td>
				<? } else { ?>
				<td><div style="height: 10px; width: 10px; background: red"></div></td>
				<? } ?>
                                <td><?= $provider['provider_name'];?></td>
				<td>IP: <?= $provider['ip'];?></td>
				<td>MASK: <?= $provider['mask'];?></td>
				<td>GATE: <?= $provider['gate'];?></td>
                        </tr>
			<? } ?>
		<? } ?>
		</table>
	</div>
</div>