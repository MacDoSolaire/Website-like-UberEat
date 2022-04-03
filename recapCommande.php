<?php
require_once "autoload.php";
session_start();

if (isset($_POST["prixCommande"])) {
    $_SESSION["prixCommande"] = $_POST["prixCommande"];
}

    $showNbPanier = count($_SESSION['panier']['menu']) +
    count($_SESSION['panier']['plat']) +
    count($_SESSION['panier']['entree']) +
    count($_SESSION['panier']['boisson']) +
    count($_SESSION['panier']['dessert']);

    $commande = array();
    $menuCommande = array();

    $page = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>22th Avenue</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .recap {
            width:1200px;
            margin:100px auto;
            color: white;
            font-family: 'Architects Daughter', cursive;
            background-color: #101010;
            justify-content:space-between;
        }

        h4 {
            text-align:center;
            display: block;
            padding: 20px;
            margin-bottom:40px;
        }

        .card {
            color: black;
            pointer-events:none;
        }

        select {
            display: block;
            margin-left: 50px;
        }

        label {
            margin-left: 30px;
        }
    </style>
</head>
<body>
    <div class="navigation-container">
        <div class="navigation-content">
            
            <div class="logo"><a href="index.php"><img height="180px" src="img/logoGros.png"></a></div>
            <div class="menu">
                <ul>
                    <li><a href="index.php">CARTE</a></li>
                    <li><a href="#">NOS OFFRES</a></li>
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
HTML;

    $page .= <<<HTML
    <div class="recap">
        <h4>Choisissez vos boissons</h4>
        <form name="form" action="payment.php" method="post">
HTML;

    if (count($_SESSION['panier']['menu']) > 0) {
        $menuListe = array_unique($_SESSION['panier']['menu']);
        $menuCount = array_count_values($_SESSION['panier']['menu']);
        foreach ($menuListe as $elmt) {
            $id = (int) $elmt;
            $qte = $menuCount[$id];
            $menu = new Menu($id);
            $nom = $menu->getName();
            $prix = (float) $menu->getPrice();
            $prixT = $qte * $prix;
            $url = $menu->getUrl();
            $menuCommande[$id] = "$nom x $qte";

            $page .= <<<HTML
            <div class="card">
                <div class="card-body">
                    $nom
                </div>
            </div>
            <select name="menuBoisson[]" required>
                <option value="">Boisson...</option>         
HTML;
            $listeIdBoisson = Boisson::getAllId();
            foreach ($listeIdBoisson as $id) {
                $boisson = new Boisson($id);
                $nom = $boisson->getName();
                $page .= <<<HTML
                <option value="$id">$nom</option>
HTML;
            }
            $page .= <<<HTML
            </select>
HTML;
        }
    }
    array_push($commande, $menuCommande);

    if (count($_SESSION['panier']['plat']) > 0) {
        $platListe = array_unique($_SESSION['panier']['plat']);
        $platCount = array_count_values($_SESSION['panier']['plat']);
        foreach ($platListe as $elmt) {
            $id = (int) $elmt;
            $qte = $platCount[$id];
            $plat = new Plat($id);
            $nom = $plat->getName();
            $prix = (float) $plat->getPrice();
            $url = $plat->getUrl();
            array_push($commande, "$nom x $qte");

            $page .= <<<HTML
                <div class="card" style="display: inline-block;height: 250px; width: 200px;">
                    <img height="150" class="card-img-top" src="$url" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">$nom</h5>
                    </div>
                </div>
HTML;
        }
    }

    if (count($_SESSION['panier']['entree']) > 0) {
        $entreeListe = array_unique($_SESSION['panier']['entree']);
        $entreeCount = array_count_values($_SESSION['panier']['entree']);
        var_dump($entreeListe);
        foreach ($entreeListe as $elmt) {
            $id = (int) $elmt;
            $qte = $entreeCount[$id];
            $entree = new Entree($id);
            $nom = $entree->getName();
            $prix = (float) $entree->getPrice();
            $url = $entree->getUrl();
            array_push($commande, "$nom x $qte");

            $page .= <<<HTML
                <div class="card" style="display: inline-block;height: 250px; width: 200px;">
                    <img height="150" class="card-img-top" src="$url" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">$nom</h5>
                    </div>
                </div>
HTML;
        }
    }

    if (count($_SESSION['panier']['boisson']) > 0) {
        $boissonListe = array_unique($_SESSION['panier']['boisson']);
        $boissonCount = array_count_values($_SESSION['panier']['boisson']);
        foreach ($boissonListe as $elmt) {
            $id = (int) $elmt;
            $qte = $boissonCount[$id];
            $boisson = new Boisson($id);
            $nom = $boisson->getName();
            $prix = (float) $boisson->getPrice();
            $url = $boisson->getUrl();
            array_push($commande, "$nom x $qte");

            $page .= <<<HTML
                <div class="card" style="display: inline-block;height: 250px; width: 200px;">
                    <img height="150" class="card-img-top" src="$url" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">$nom</h5>
                    </div>
                </div>
HTML;
        }
    }

    if (count($_SESSION['panier']['dessert']) > 0) {
        $dessertListe = array_unique($_SESSION['panier']['dessert']);
        $dessertCount = array_count_values($_SESSION['panier']['dessert']);
        foreach ($dessertListe as $elmt) {
            $id = (int) $elmt;
            $qte = $dessertCount[$id];
            $dessert = new Dessert($id);
            $nom = $dessert->getName();
            $prix = (float) $dessert->getPrice();
            $url = $dessert->getUrl();
            array_push($commande, "$nom x $qte");

            $page .= <<<HTML
                <div class="card" style="display: inline-block;height: 250px; width: 200px;">
                    <img height="150" class="card-img-top" src="$url" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">$nom</h5>
                    </div>
                </div>
HTML;
        }
    }

    $page .= <<<HTML
            <br>
            <label for="promo">Entrez un code de réduction :</label>
            <input type="text" name="promo" placeholder="CODE" onkeyup="checkReduc(this.value)">
            <div id='promo'></div>
            <button type="submit" class="btn btn-warning" style="display: block; margin: 20px auto;">Valider</button>
            <br>
        </form>
    </div>
    <script type='text/javascript' src='js/ajaxrequest.js'></script>
    <script type="text/javascript">
        function checkReduc(val) {
            if (val.length == 0) {
                document.getElementById('promo').innerHTML = "";
            }
            if (val.length > 0) {
                new AjaxRequest(
            {
                url        : "checkReduc.php",
                method     : 'post',
                parameters : {
                    code: val,
                    wait: 'wait'
                },
                onSuccess  : function(res) {
                        document.getElementById('promo').innerHTML = res;
                    },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                    }
            }) ;
            }
        }
    </script>
HTML;
$_SESSION["commande"] = $commande;

echo $page;