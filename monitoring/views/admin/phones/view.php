<section class="title">
	<h4>Manage pools</h4>
</section>

<section class="item">
<div>
	<form action="/admin/monitoring/phones/view/<?= $pool_id;?>" method="get" accept-charset="utf-8">
		<input style="width: 80%"  type="text" name="q" value="" placeholder="Enter a number"  />
		<button style="width: 18%"  type="submit" class="btn blue"><span>Search</span></button>
	</form>
</div>
<div>
	<p>Show: <?= anchor('/admin/monitoring/phones/view/' . $pool_id . "?show=free" , 'Free', array('class'=>'button delete')); ?> or  <?= anchor('/admin/monitoring/phones/view/' . $pool_id . '?show=all', 'All', array('class'=>'button delete')); ?></p>
</div>
<div id="filter-stage">
    <table border="0">
            <td style="width: 95%; vertical-align: top">
            <? if (!empty($phones)) { ?>
                <table>
                    <tr>
                        <td>Num</td><td>Shop</td><td>delete</td>
                    </tr>
                    <? foreach ($phones as $phone) { ?>
                    <tr>
                        <td><?= $phone->phone; ?></td>
                        <td><?= is_null($phone->shop_id) ? "Free" : '<a href="/admin/monitoring/shop/view/'.$phone->shop_id['id'].'">'.$phone->shop_id['name'].'</a>'; ?></td>
                        <td>
				<?= anchor('admin/monitoring/phones/phone/assign/' . $phone->id, 'Assign', array('class'=>'button delete')); ?>
				<?= anchor('admin/monitoring/phones/phone/clear/' . $phone->id, 'Clear', array('class'=>'button delete')); ?>
			</td>
                    </tr>
                    <? } ?>
                </table>
            <? } else { ?>
                <div class="no_data">phones is not found</div>
            <? } ?>
            </td>
        </tr>
    </table>
</div>

</section>