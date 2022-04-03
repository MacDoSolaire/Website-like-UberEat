<?php
require_once "autoload.php";
session_start();

$lstCom = $_SESSION['commande'];

$stmt1 = MyPDO::getInstance()->prepare(<<<SQL
    UPDATE commande
    SET etat = 'Livre'
    WHERE idCommande = :idCom
SQL);

$stmt1->bindValue(':idCom', (int) $lstCom[0]);

$stmt1->execute();

$stmt2 = MyPDO::getInstance()->prepare(<<<SQL
    UPDATE commande
    SET etat = 'Livre'
    WHERE idCommande = :idCom
SQL);

$stmt2->bindValue(':idCom', (int) $lstCom[1]);

$stmt2->execute();

$stmt3 = MyPDO::getInstance()->prepare(<<<SQL
    UPDATE commande
    SET etat = 'Livre'
    WHERE idCommande = :idCom
SQL);

$stmt3->bindValue(':idCom', (int) $lstCom[2]);

$stmt3->execute();

$stmt4 = MyPDO::getInstance()->prepare(<<<SQL
    UPDATE commande
    SET etat = 'Livre'
    WHERE idCommande = :idCom
SQL);

$stmt4->bindValue(':idCom', (int) $lstCom[3]);

$stmt4->execute();

$stmt5 = MyPDO::getInstance()->prepare(<<<SQL
    UPDATE commande
    SET etat = 'Livre'
    WHERE idCommande = :idCom
SQL);

$stmt5->bindValue(':idCom', (int) $lstCom[4]);

$stmt5->execute();

echo "<span style: color=green; margin-left: 450px>Livraison réalisé avec succès !</span>";