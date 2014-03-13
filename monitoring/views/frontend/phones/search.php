<script>
    var params = 'width=575,height=520,top='+screen.availHeight/4+',left='+screen.availWidth/4+',resizable=no,toolbar=no,location=no,directories=no';
</script>
<?
foreach ($search as $result)
{
?>
    <p><div style="float: left; width: 80%">
        <a href="/monitoring/shop/?id=<?= $result->id; ?>" target="_blank" onClick="window.open(this.href, '', params); return false;">
        <?= $result->name; ?>
        </a>
    </div>
    <div style="float: left; width: 20%">
        <b><?= $result->phone; ?></b>
    </div>
<?        
}
?>