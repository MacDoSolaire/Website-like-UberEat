<?php
require_once "autoload.php";
session_start();
if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        if ($_GET["type"] == "menu") {
            foreach ($_SESSION["panier"]["menu"] as $key => $values) {
                if ($values == $_GET['id']) {
                    unset($_SESSION["panier"]["menu"][$key]);
                    echo '<script>window.location="panier.php"</script>';
                }
            }
        }
        if ($_GET["type"] == "plat") {
            foreach ($_SESSION["panier"]["plat"] as $key => $values) {
                if ($values == $_GET['id']) {
                    unset($_SESSION["panier"]["plat"][$key]);
                    echo '<script>window.location="panier.php"</script>';
                }
            }
        }
        if ($_GET["type"] == "entree") {
            foreach ($_SESSION["panier"]["entree"] as $key => $values) {
                if ($values == $_GET['id']) {
                    unset($_SESSION["panier"]["entree"][$key]);
                    echo '<script>window.location="panier.php"</script>';
                }
            }
        }
        if ($_GET["type"] == "boisson") {
            foreach ($_SESSION["panier"]["boisson"] as $key => $values) {
                if ($values == $_GET['id']) {
                    unset($_SESSION["panier"]["boisson"][$key]);
                    echo '<script>window.location="panier.php"</script>';
                }
            }
        }
        if ($_GET["type"] == "dessert") {
            foreach ($_SESSION["panier"]["dessert"] as $key => $values) {
                if ($values == $_GET['id']) {
                    unset($_SESSION["panier"]["dessert"][$key]);
                    echo '<script>window.location="panier.php"</script>';
                }
            }
        }
    }
}

if (isset($_SESSION['autoriser']) == 'oui') {
    $showNbPanier = count($_SESSION['panier']['menu']) +
                    count($_SESSION['panier']['plat']) +
                    count($_SESSION['panier']['entree']) +
                    count($_SESSION['panier']['boisson']) +
                    count($_SESSION['panier']['dessert']);

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

    <div class="table-responsive">
        <table class="table table-dark">
            <tr><th colspan="4"><h3>Details de la commande</h3></th></tr>
            <tr>
               <th width="20%">Nom du produit</th>
               <th width="10%">Quantité</th>
               <th width="10%">Prix</th>
               <th width="10%">Total</th>
               <th width="5%">Action</th>
            </tr>
HTML;
    $prixF = 0;

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
            $prixF += $prixT;

            $page .= "<tr><td>$nom</td><td>$qte</td><td>$prix.€</td><td>$prixT.€</td><td>" . "<a href=" . "panier.php?action=delete&id=$id&type=menu>" . "<span class='text-danger'>Enlever</span></a></td></tr>";
        }
    }

    if (count($_SESSION['panier']['plat']) > 0) {
        $platListe = array_unique($_SESSION['panier']['plat']);
        $platCount = array_count_values($_SESSION['panier']['plat']);
        foreach ($platListe as $elmt) {
            $id = (int) $elmt;
            $qte = $platCount[$id];
            $plat = new Plat($id);
            $nom = $plat->getName();
            $prix = (float) $plat->getPrice();
            $prixT = $qte * $prix;
            $prixF += $prixT;

            $page .= "<tr><td>$nom</td><td>$qte</td><td>$prix.€</td><td>$prixT.€</td><td>" . "<a href=" . "panier.php?action=delete&id=$id&type=plat>" . "<span class='text-danger'>Enlever</span></a></td></tr>";
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
            $prixT = $qte * $prix;
            $prixF += $prixT;

            $page .= "<tr><td>$nom</td><td>$qte</td><td>$prix.€</td><td>$prixT.€</td><td>" . "<a href=" . "panier.php?action=delete&id=$id&type=entree>" . "<span class='text-danger'>Enlever</span></a></td></tr>";
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
            $prixT = $qte * $prix;
            $prixF += $prixT;

            $page .= "<tr><td>$nom</td><td>$qte</td><td>$prix.€</td><td>$prixT.€</td><td>" . "<a href=" . "panier.php?action=delete&id=$id&type=boisson>" . "<span class='text-danger'>Enlever</span></a></td></tr>";
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
            $prixT = $qte * $prix;
            $prixF += $prixT;
            $page .= "<tr><td>$nom</td><td>$qte</td><td>$prix.€</td><td>$prixT.€</td><td>" . "<a href=" . "panier.php?action=delete&id=$id&type=boisson>" . "<span class='text-danger'>Enlever</span></a></td></tr>";
        }
    }

    if ($showNbPanier == 0) {
        $page .= <<<HTML
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th colspan="4">Votre panier est vide !</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </table>
</body>
</html>
HTML;

    } else {
        $page .= <<<HTML
            <tr>
                <th></th>
                <th></th>
                <th colspan="1">Total de la commande : </th>
                <td>$prixF €</td>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <td colspan="2">
                    <form action="recapCommande.php" method="post">
                        <input type="hidden" name="prixCommande" value="$prixF">
                        <button type="submit" class="btn btn-warning">Passer la commande</button>
                    </form>
                </td>
                <th></th>
                <th></th>
            </tr>
        </table>
</body>
</html>
HTML;
    }
} else {
    $page = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Restaurant</title>
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
                    <li><a href="login.php">SE CONNECTER</a></li>
                </ul>
            </div>
            <div class="cart">
                <img height="30px" src="img/cart.png">
                <a href="panier.php">PANIER</a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-dark">
            <tr><th colspan="4"><h3>Details de la commande</h3></th></tr>
            <tr>
               <th width="20%">Nom du produit</th>
               <th width="10%">Quantité</th>
               <th width="10%">Prix</th>
               <th width="10%">Total</th>
               <th width="5%">Action</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th colspan="3">Connectez-vous pour remplir votre panier !</th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
HTML;
        $page .= <<<HTML
        </table>
    </div>
</body>
</html>
HTML;
}

echo $page;