<?php
require_once "autoload.php";
session_start();

if (isset($_POST['add'])) {
    if (isset($_SESSION)) {
        if (isset($_SESSION['panier'])) {
            if ($_POST['typeProduit'] == 'menu') {
                array_push($_SESSION['panier']['menu'], $_POST['idProduit']);
            } elseif ($_POST['typeProduit'] == 'plat') {
                array_push($_SESSION['panier']['plat'], $_POST['idProduit']);
            } elseif ($_POST['typeProduit'] == 'entree') {
                array_push($_SESSION['panier']['entree'], $_POST['idProduit']);
            } elseif ($_POST['typeProduit'] == 'boisson') {
                array_push($_SESSION['panier']['boisson'], $_POST['idProduit']);
            } elseif ($_POST['typeProduit'] == 'dessert') {
                array_push($_SESSION['panier']['dessert'], $_POST['idProduit']);
            }
        }
    }
}

$page = <<<HTML
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>22th Avenue</title>

    <!-- Link -->
    <link rel="icon" type="image/png" href="img/restaurant.png" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Architects+Daughter&display=swap" rel="stylesheet"> 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@300;400&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
HTML;

if (isset($_SESSION['autoriser']) == 'oui') {
    $showNbPanier = count($_SESSION['panier']['menu']) +
    count($_SESSION['panier']['plat']) +
    count($_SESSION['panier']['entree']) +
    count($_SESSION['panier']['boisson']) +
    count($_SESSION['panier']['dessert']);

    $page .= <<<HTML
    <div class="navigation-container">
        <div class="navigation-content">
            <div class="logo"><a href="index.php"><img height="180px" src="img/logoGros.png" /></a></div>
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
HTML;
} else {
    $page .= <<<HTML
    <div class="navigation-container">
        <div class="navigation-content">
            <div class="logo"><a href="index.php"><img height="180px" src="img/logoGros.png" /></a></div>
            <div class="menu">
                <ul>
                    <li><a href="index.php">CARTE</a></li>
                    <li><a href="login.php">SE CONNECTER</a></li>
                </ul>
            </div>
            <div class="cart">
                <img height="30px" src="img/cart.png">
                <a href="panier.php">PANIER</a>
            </div>
        </div>
    </div>
HTML;
}
    
$page .= <<<HTML
    <!-- Menu -->


    <div class="wrapper">

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="img/fondCarte.png" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="img/reduc2.png" alt="Second slide">
            </div>
            <!--<div class="carousel-item">
                <img class="d-block w-100" src="..." alt="Third slide">
            </div>-->
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

        <div class="title">
            <h4><span>Des bons ingredients, une bonne recette</span>Notre carte</h4>
        </div>

        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link" href="#lstMenu">Menus</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#lstEntree">Entrées</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#lstPlat">Plats</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#lstDesserts">Desserts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#lstBoisson">Boissons</a>
            </li>
        </ul>

        <br />
        <br />

        <!-- Menu -->
        <div id="lstMenu">
            <!-- Ajout d'un titre-->
            <div class="titreCarte">
                <h3> Les menus : </h3>
            </div>
            
            <div class="menu">
HTML;

$listeIdMenu = Menu::getAllId();
foreach ($listeIdMenu as $id) {
    $menu1 = new Menu($id);
    $id = $menu1->getId();
    $nom = $menu1->getName();
    $prix = $menu1->getPrice();
    $desc = $menu1->getDesc();
    $url = $menu1->getUrl();
    $page .= <<<HTML
    <div class="single-menu">
        <img src="{$url}" alt="">
            <div class="menu-content">
                <h4>$nom <span> $prix €</span></h4>
                <p>$desc</p>
                <form action="index.php" method="post">
                    <button class="button" type="submit" name="add">Ajouter au panier</button>
                    <input type="hidden" name="idProduit" value="$id">
                    <input type="hidden" name="typeProduit" value="menu">
                </form>
            </div>
    </div>
HTML;
}

$page .= <<<HTML
            </div>
        </div>

        <div id="lstEntree">
        <div class="titreCarte">
                <h3> Les entrées : </h3>
            </div>
            <div class="menu">
HTML;

$listeIdEntree = Entree::getAllId();
foreach ($listeIdEntree as $id) {
    $entree = new Entree($id);
    $idEntree = $entree->getId();
    $nomEntree = $entree->getName();
    $prixEntree = $entree->getPrice();
    $descEntree = $entree->getDesc();
    $urlEntree = $entree->getUrl();
    $page .= <<<HTML
    <div class="single-menu">
        <img src="{$urlEntree}" alt="">
            <div class="menu-content">
                <h4>$nomEntree <span> $prixEntree €</span></h4>
                <p>$descEntree</p>
                <form action="index.php" method="post">
                    <button class="button" type="submit" name="add">Ajouter au panier</button>
                    <input type="hidden" name="idProduit" value="$idEntree">
                    <input type="hidden" name="typeProduit" value="entree">
                </form>
            </div>
    </div>
HTML;
}
$page .= <<<HTML
            </div>
        </div>

        <!-- Plats -->
        <div id="lstPlat">
            <!-- Ajout d'un titre-->
            <div class="titreCarte">
                <h3> Les plats : </h3>
            </div>
            <div class="menu">
HTML;

$listeIdPlat = Plat::getAllId();
foreach ($listeIdPlat as $id) {
    $plat = new Plat($id);
    $idPlat = $plat->getId();
    $nomPlat = $plat->getName();
    $prixPlat = $plat->getPrice();
    $descPlat = $plat->getDesc();
    $urlPlat = $plat->getUrl();
    $page .= <<<HTML
    <div class="single-menu">
        <img src="{$urlPlat}" alt="">
            <div class="menu-content">
                <h4>$nomPlat <span> $prixPlat €</span></h4>
                <p>$descPlat</p>
                <form action="index.php" method="post">
                    <button class="button" type="submit" name="add">Ajouter au panier</button>
                    <input type="hidden" name="idProduit" value="$idPlat">
                    <input type="hidden" name="typeProduit" value="plat">
                </form>
            </div>
    </div>
HTML;
}
$page .= <<<HTML
            </div>
        </div>

            <!-- Desserts -->
            <div id="lstDesserts">
                <!-- Ajout d'un titre-->
                <div class="titreCarte">
                <h3> Les desserts : </h3>
            </div>
                <div class="menu">

HTML;

$listeIdDessert = Dessert::getAllId();
foreach ($listeIdDessert as $id) {
    $dess = new Dessert($id);
    $idDess = $dess->getId();
    $nomDess = $dess->getName();
    $prixDess = $dess->getPrice();
    $descDess = $dess->getDesc();
    $urlDess = $dess->getUrl();
    $page .= <<<HTML
    <div class="single-menu">
        <img src="{$urlDess}" alt="">
            <div class="menu-content">
                <h4>$nomDess <span> $prixDess €</span></h4>
                <p>$descDess</p>
                <form action="index.php" method="post">
                    <button class="button" type="submit" name="add">Ajouter au panier</button>
                    <input type="hidden" name="idProduit" value="$idDess">
                    <input type="hidden" name="typeProduit" value="dessert">
                </form>
            </div>
    </div>
HTML;
}
$page .= <<<HTML
            </div>
        </div>
                <!-- Boisson -->
                <div id="lstBoisson">
                    <!-- Ajout d'un titre-->
                    <div class="titreCarte">
                        <h3> Les boissons : </h3>
                    </div>
                    <div class="menu">
HTML;

$listeIdBoisson = Boisson::getAllId();
foreach ($listeIdBoisson as $id) {
    $bois = new Boisson($id);
    $idBois = $bois->getId();
    $nomBois = $bois->getName();
    $prixBois = $bois->getPrice();
    $descBois = $bois->getDesc();
    $urlBois = $bois->getUrl();
    $page .= <<<HTML
    <div class="single-menu">
        <img src="{$urlBois}" alt="">
            <div class="menu-content">
                <h4>$nomBois <span> $prixBois €</span></h4>
                <p>$descBois</p>
                <form action="index.php" method="post">
                    <button class="button" type="submit" name="add">Ajouter au panier</button>
                    <input type="hidden" name="idProduit" value="$idBois">
                    <input type="hidden" name="typeProduit" value="boisson">
                </form>
            </div>
    </div>
HTML;
}
$page .= <<<HTML

                </div>
            </div>
        </div>
                
    <!--footer-->
    <div class="footer">
        <div class="navigation-content">
            <div class="footer-menu">
                <ul>
                    <li><a href="https://www.economie.gouv.fr/dgccrf/Publications/Vie-pratique/Fiches-pratiques/Allergene-alimentaire">ALLERGENES</a></li>
                    <li><a href="mailto:vincent.ruelle1@etudiant.univ-reims.fr">CONTACTEZ NOUS</a></li>
                    <li><a href="equipe.html">EQUIPE</a></li>
                    <li><a href="https://goo.gl/maps/BDvw45sBvY4UNSEn6">NOUS-TROUVER</a></li>
                </ul>
            </div>
            <div class="social">
                <ul>
                    <li><a href="https://fr-fr.facebook.com/"><img src="img/facebook.png"></a></li>
                    <li><a href="https://twitter.com/"><img src="img/twitter.png"></a></li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            <p>Site conçu par "Devtek &copy;" Copyright 2020</p>
        </div>
    </div>
    <script type='text/javascript' src='js/index.js'></script>
</body>

</html>
HTML;

echo $page;