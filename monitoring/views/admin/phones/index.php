<section class="title">
	<h4>Manage pools</h4>
</section>

<section class="item">
<div id="filter-stage">
    <table border="0" class="table-list">
        <tr>
            <td style="width: 50%; vertical-align: top">
                <?= form_open('admin/monitoring/phones/pools/save');?>
                <p>
                    name of a new pool:<br/>
                    <input type="text" name="name" style="width: 90%" />
                </p>
                <p>
                    first number of a new pool:<br/>
                    <input type="text" name="start"  style="width: 90%" />
                </p>
                <p>
                    last number of a new pool<br/>
                    <input type="text" name="end"  style="width: 90%" />
                </p>
                <p>
                    <input type="submit" value="Save" class="btn blue" />
                </p>
                <?= form_close(); ?>
            </td>
            <td style="width: 50%; vertical-align: top">
            <? if (!empty($pools)) { ?>
                <table>
                    <tr>
                        <td>Name</td><td>Start</td><td>End</td><td>delete</td>
                    </tr>
                    <? foreach ($pools as $pool) { ?>
                    <tr>
                        <td><?= anchor('admin/monitoring/phones/view/' . $pool->id, $pool->name); ?></td>
                        <td><?= $pool->start; ?></td>
                        <td><?= $pool->end; ?></td>
                        <td><?= anchor('admin/monitoring/phones/pools/delete/' . $pool->id, lang('global:delete'), array('class'=>'button delete')); ?></td>
                    </tr>
                    <? } ?>
                </table>
            <? } else { ?>
                <div class="no_data">pools is not found</div>
            <? } ?>
            </td>
        </tr>
    </table>
</div>

</section>