<?php
require_once "autoload.php";
session_start();

$stmt = MyPDO::getInstance()->prepare(<<<SQL
    SELECT idCommande, etat
    FROM commande
    WHERE idCli = :id
SQL);

$stmt->bindValue(':id', $_SESSION['id']);
$stmt->execute();
$req = $stmt->fetchAll();

$commande = <<<HTML
    <h4>Historique de commande</h4>
    <div class="commandeLst">
HTML;

$i = 1;

for ($j=0; $j < count($req); $j++) {
    $id = (int) $req[$j]['idCommande'];

    $stmtLigne = MyPDO::getInstance()->prepare(<<<SQL
    SELECT ligne
    FROM commandeLigne
    INNER JOIN commande ON commande.idCommande = commandeLigne.idCommande
    WHERE commande.idCommande = :id
SQL);

    $stmtLigne->bindValue(':id', $id);
    $stmtLigne->execute();

    if ($req[$j]['etat'] == 'En attente') {
        $commande .= <<<HTML
        <h6>Commande #$i</h6>
        <div class="card bg-warning text-white">
            <div class="card-body">
HTML;
        $etat = 'En attente';
    } elseif ($req[$j]['etat'] == 'Pret') {
        $commande .= <<<HTML
        <h6>Commande #$i</h6>
        <div class="card bg-info text-white">
            <div class="card-body">
HTML;
        $etat = 'Pret pour livraison';
    } elseif ($req[$j]['etat'] == 'Livre') {
        $commande .= <<<HTML
        <h6>Commande #$i</h6>
        <div class="card bg-success text-white">
            <div class="card-body">
HTML;
        $etat = 'Livré';
    }

    $reqLigne = $stmtLigne->fetchAll(PDO::FETCH_COLUMN, 0);

    foreach ($reqLigne as $ligne) {
        if ($reqLigne[count($reqLigne) - 1] == $ligne) {
            $commande .= <<<HTML
            Total : $ligne &euro;<br>
            Etat : $etat
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
HTML;
    $i++;
}

$commande .= <<<HTML
    </div>
HTML;

echo $commande;