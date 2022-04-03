<?php
require_once "autoload.php";
session_start();

$stmt = MyPDO::getInstance()->prepare(<<<SQL
    SELECT idCommande
    FROM commande
    WHERE etat = :etat
SQL);

$stmt->bindValue(':etat', 'En attente');
$stmt->execute();
$req = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$commande = <<<HTML
    <h4>Commandes en attente</h4>
    <div class="commandeLst">
HTML;

$i = 1;

foreach ($req as $idCommande) {
    $id = (int) $idCommande;
    $stmtLigne = MyPDO::getInstance()->prepare(<<<SQL
    SELECT ligne
    FROM commandeLigne
    INNER JOIN commande ON commande.idCommande = commandeLigne.idCommande
    WHERE commande.idCommande = :id
SQL);

    $stmtLigne->bindValue(':id', $id);
    $stmtLigne->execute();

    $commande .= <<<HTML
        <h6 id="$id.Title">Commande #$i</h6>
        <div class="card" id="$id">
            <div class="card-body">
HTML;

    $reqLigne = $stmtLigne->fetchAll(PDO::FETCH_COLUMN, 0);

    foreach ($reqLigne as $ligne) {
        if ($reqLigne[count($reqLigne) - 1] == $ligne) {
            $commande .= <<<HTML
            Total : $ligne &euro;
HTML;
        } else {
            $commande .= <<<HTML
            $ligne<br>
HTML;
        }
    }

    $commande .= <<<HTML
            </div>
        </div>
        <button id="$id.But" type="submit" onclick="validateOrder($id)" class="btn btn-warning" style="display: block; margin-left: 215px">Valider</button>
HTML;
    $i++;
}

$commande .= <<<HTML
    </div>
HTML;

echo $commande;