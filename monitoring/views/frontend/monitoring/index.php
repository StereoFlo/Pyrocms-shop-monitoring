<section class="title">
	<h1>View shops</h1>
</section>

<section class="item">
<div>
	<form action="/monitoring/index" method="get" accept-charset="utf-8" class="simple">
		<input type="text" name="q" placeholder="Enter a word"  />
		<button type="submit" class="btn blue"><span>Search for shop</span></button>
	</form>
</div>
<? if (!empty($shops)) { ?>

	<? foreach ($shops as $shop): ?>
        <p>
            <div class="code"><a href="<?= base_url('monitoring/view/' . $shop->id); ?>"><?= isset($shop->code) ? $shop->code : "&nbsp;"; ?></a></div>
	    <div class="name"><a href="<?= base_url('monitoring/view/' . $shop->id); ?>"><?= isset($shop->name) ? $shop->name : "&nbsp;"; ?></a></div>
	    <div class="state"><a href="<?= base_url('monitoring/view/' . $shop->id); ?>"><?= isset($shop->state) ? "Open" : "Close"; ?></a></div>
        </p>
	<? endforeach; ?>
<div class="inner">
    <?= $pagination['links']; ?>
</div>
<? } else { ?>
    <div class="no_data">shops is not found</div>
<? } ?>

</section>