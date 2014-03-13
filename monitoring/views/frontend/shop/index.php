<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title><?= $shop[0]->name ?> || <?= $shop[0]->code ?> </title>
    <link rel="stylesheet" type="text/css" href="/addons/default/themes/megafon/css/style.css" />
    <script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
    <? if (isset($shop[0]->address)) { ?>
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
</head>
<body>
    <div style="padding: 10px;">
        <h2>Магазин: <?= $shop[0]->name ?>(<?= $shop[0]->code ?>)</h2>
        <? if (isset($shop[0]->address)) { ?>
        <p><span class="logged_mess">Адрес магазина: <?= $shop[0]->address ?></span></p>
        <p><span class="logged_mess">Магазин на карте:</span></p>
        <div id='map' style='width: 550px; height: 400px'></div>
        <? } else { ?>
        <p><span class="logged_mess">У этого магазина адрес не определен</span></p>
        <? } ?>
        <p><button onclick="window.print();">Распечатать</button></p>
    </div>
</body>
</html>