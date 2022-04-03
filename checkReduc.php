<?php
require_once "autoload.php";

$stmt = MyPDO::getInstance()->prepare(<<<SQL
    SELECT montant 
    FROM CodePromo 
    WHERE nomCode = :code
SQL);

$stmt->bindValue(':code', $_POST['code']);
$stmt->execute();

$ret = "";
if ($req = $stmt->fetchAll()) {
    $montant = (float) $req[0]['montant'] * 100;
    $ret = "<span style='color: green; margin-left: 30px'>Reduction de $montant% sur le total</span>";
} else {
    $ret = "<span style='color: red; margin-left: 30px'>Ce code est invalide !</span>";
}

echo $ret;