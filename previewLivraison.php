<?php
require_once "autoload.php";
session_start();

$stmt = MyPDO::getInstance()->prepare(<<<SQL
    SELECT idCommande, idCli
    FROM commande
    WHERE etat = :etat
SQL);

$stmt->bindValue(':etat', 'Pret');

$stmt->execute();

if ($idCli = $stmt->fetchAll(PDO::FETCH_COLUMN, 1)) {
    $graph = new Graph($idCli);
    $graph->fillMap();
    $graph->glouton();
}

$rLat = Graph::RESTO_COORD['lat'];
$rLon = Graph::RESTO_COORD['lon'];

$arrayPath = $graph->getPath();

$marker = array(
    'icon:small-red-cutout',
    'icon:small-blue-cutout',
    'icon:small-yellow-cutout',
    'icon:small-orange-cutout',
    'icon:small-green-cutout',
    'icon:small-purple-cutout',
    'icon:small-red-cutout'
);

$commande = $graph->getCommandeArray();
$lstimages = [];

for ($r=0; $r < count($arrayPath); $r++) {
    $src = "https://maps.locationiq.com/v2/staticmap?key=pk.c3a10f2c79ce96af55cae373ed449a1e&center=$rLat,$rLon&zoom=18&size=500x350&format=png&maptype=roadmap&";
    
    for ($i = 0; $i < count($arrayPath) - $r; $i++) {
        $lat = $commande[$arrayPath[$i]]['lat'];
        $lon = $commande[$arrayPath[$i]]['lon'];
        $src .= "markers=$marker[$i]|$lat,$lon&";
    }

    $src .= "path=weight:2|color:red";

    for ($j = 0; $j < count($arrayPath) - $r; $j++) {
        $lat = $commande[$arrayPath[$j]]['lat'];
        $lon = $commande[$arrayPath[$j]]['lon'];
        $src .= "|$lat,$lon";
    }

    $src .= '|';

    array_push($lstimages, $src);
}

$frames = array_reverse($lstimages);

$durations = array(150);

$anim = new AnimGif();
$anim->create($frames, $durations);

$gif = $anim->get();

unlink("./img/animated.gif");
$anim->save("./img/animated.gif");

$ret = <<<HTML
    <h4>Itinéraire de livraison</h4>
    <img id="image" style="display: block; margin-left: 280px; margin-bottom: 10px" src="./img/animated.gif">
HTML;

$nbCom = MyPDO::getInstance()->prepare(<<<SQL
    SELECT count(idCommande)
    FROM commande
    WHERE etat = :etat
SQL);

$nbCom->bindValue(':etat', 'Pret');

$nbCom->execute();

$nb = $nbCom->fetchAll(PDO::FETCH_COLUMN, 0);

if ($nb[0] >= 5) {
    $ret .= <<<HTML
    <button type="submit" onclick="validateDelivery()" class="btn btn-warning" style="margin-left: 450px">Lancer la livraison</button>
    <button type="submit" onclick="preview()" class="btn btn-info" style="margin-left: 30px">Aperçu du trajet</button>
HTML;
}

echo $ret;