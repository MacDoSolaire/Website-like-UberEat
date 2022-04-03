<?php
require_once "autoload.php";
session_start();

$stmt = MyPDO::getInstance()->prepare(<<<SQL
    UPDATE commande c1
    SET c1.etat = 'Pret'
    WHERE idCommande = :idCom
SQL);

$stmt->bindValue(':idCom', $_POST['idCom']);

$stmt->execute();