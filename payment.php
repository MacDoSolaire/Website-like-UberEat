<?php
require_once "autoload.php";
session_start();

if (isset($_POST["menuBoisson"])) {
    $_SESSION["menuBoisson"] = $_POST["menuBoisson"];
}

$showNbPanier = count($_SESSION['panier']['menu']) +
    count($_SESSION['panier']['plat']) +
    count($_SESSION['panier']['entree']) +
    count($_SESSION['panier']['boisson']) +
    count($_SESSION['panier']['dessert']);

if (isset($_POST['promo'])) {
    $reduc = 0;
    $stmt = MyPDO::getInstance()->prepare("select nomCode,montant from CodePromo where nomCode=?");
    $stmt->execute(array($_POST['promo']));

    if ($req = $stmt->fetchAll()) {
        $reduc = (float) $req[0]['montant'];
        $_SESSION["prixCommande"] = $_SESSION["prixCommande"] - ($_SESSION["prixCommande"] * $reduc);
    }
}

if (isset($_POST['paid'])) {
    $commande = MyPDO::getInstance()->prepare('INSERT INTO commande(idCli, dateCommande, etat) VALUES(?,CURDATE(),?)');
    $commande->execute(array($_SESSION['id'], 'En attente'));

    $menuCommande = $_SESSION["commande"][0];
    $i = 0;
    foreach ($menuCommande as $key => $value) {
        if ($_SESSION["menuBoisson"][$i] && $i < count($_SESSION["menuBoisson"])) {
            $boisson = new Boisson($_SESSION["menuBoisson"][$i]);
            $nom = $boisson->getName();
            $menuCommande[$key] = preg_replace("/boisson/", $nom, $value);
        }
        $i++;
    }
    $req = MyPDO::getInstance()->prepare('SELECT idCommande FROM commande WHERE idCli = ?');
    $req->execute(array($_SESSION['id']));
    $stmt = $req->fetchAll();
    $idCom = (int) $stmt[count($stmt) - 1]["idCommande"];

    $i = 0;
    foreach ($menuCommande as $elmt) {
        $commandeLigne = MyPDO::getInstance()->prepare('INSERT INTO commandeLigne(idCommande, ligne, ligneNum) VALUES(?,?,?)');
        $commandeLigne->execute(array($idCom, $elmt, $i));
        $i++;
    }

    for ($j=1; $j <= count($_SESSION["commande"])-1; $j++) {
        $commandeLigne = MyPDO::getInstance()->prepare('INSERT INTO commandeLigne(idCommande, ligne, ligneNum) VALUES(?,?,?)');
        $commandeLigne->execute(array($idCom, $_SESSION["commande"][$j], $i));
        $i++;
    }

    $commandeLigne = MyPDO::getInstance()->prepare('INSERT INTO commandeLigne(idCommande, ligne, ligneNum) VALUES(?,?,?)');
    $commandeLigne->execute(array($idCom, $_SESSION["prixCommande"], $i));

    $dataPanier = array(
        'menu' => array(),
        'plat' => array(),
        'entree' => array(),
        'boisson' => array(),
        'dessert' => array()
    );
    $_SESSION['panier'] = $dataPanier;

    header('Location:index.php');
    exit();
}

$page = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>22th Avenue</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="navigation-container">
        <div class="navigation-content">
            
            <div class="logo"><a href="index.php"><img height="180px" src="img/logoGros.png"></a></div>
            <div class="menu">
                <ul>
                    <li><a href="index.php">CARTE</a></li>
                    <li><a href="compte.php">MON COMPTE</a></li>
                    <li><a href="deconnexion.php">SE DECONNECTER</a></li>
                </ul>
            </div>
            <div class="cart">
                <img height="30px" src="img/cart.png">
                <a href="panier.php">PANIER $showNbPanier</a>
            </div>
        </div>
    </div>
    <form action="payment.php" method="post">
        <button name="paid" type="submit" class="btn btn-warning" style="display: block; margin: 200px auto;">Payer</button>
    </form>
</body>
</html>
HTML;

echo $page; 