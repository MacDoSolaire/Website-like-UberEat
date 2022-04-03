<?php
require_once "autoload.php";
session_start();

if (isset($_SESSION['autoriser']) == 'oui') {
    $showNbPanier = count($_SESSION['panier']['menu']) +
        count($_SESSION['panier']['plat']) +
        count($_SESSION['panier']['entree']) +
        count($_SESSION['panier']['boisson']) +
        count($_SESSION['panier']['dessert']);

    $user = new User($_SESSION['id']);
    $nom = $user->getFirstName();

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
            <div class="logo"><img height="180px" src="img/logoGros.png" /></div>
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
    <div class="compteWrapper">
        <div class="sidebar">
            <h2>Tableau de bord</h2>
            <ul>
                <li onclick="loadProfile();return false;"><a href="">Profil</a></li>
                <li onclick="loadOrders();return false;"><a href="">Commandes</a></li>
                <li onclick="loadLivraison();return false;"><a href="">Livraison</a></li>
            </ul>
        </div>

        <div class="content">
            <div id="zone">
                <h4>Bienvenue sur votre espace personnel $nom</h4>
            </div>
        </div>
    </div>
HTML;

$page .= <<<HTML
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

    <script type='text/javascript' src='js/ajaxrequest.js'></script>
    <script type="text/javascript">
        function loadProfile() {
            new AjaxRequest(
            {
                url        : "loadProfile.php",
                method     : 'post',
                parameters : {
                    wait: 'wait'
                },
                onSuccess  : function(res) {
                        document.getElementById('zone').innerHTML = res;
                    },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                    }
            }) ;
        }

        function loadOrders() {
            new AjaxRequest(
            {
                url        : "loadOrders.php",
                method     : 'post',
                parameters : {
                    wait: 'wait'
                },
                onSuccess  : function(res) {
                        document.getElementById('zone').innerHTML = res;
                    },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                    }
            }) ;
        }

        function loadLivraison() {
            new AjaxRequest(
            {
                url        : "loadLivraison.php",
                method     : 'post',
                parameters : {
                    wait: 'wait'
                },
                onSuccess  : function(res) {
                        document.getElementById('zone').innerHTML = res;
                    },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                    }
            }) ;
        }

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        function preview() {
            new AjaxRequest(
            {
                url        : "previewLivraison.php",
                method     : 'post',
                parameters : {
                    wait: 'wait'
                },
                onSuccess  : function(res) {
                    document.getElementById('zone').innerHTML = res;
                    },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                    }
            }) ;
        }

        function validateDelivery() {
            new AjaxRequest(
            {
                url        : "validateDelivery.php",
                method     : 'post',
                parameters : {
                    wait: 'wait'
                },
                onSuccess  : function(res) {
                    document.getElementById('zone').innerHTML = res;
                    },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                    }
            }) ;
        }
    </script>
</body>
</html>
HTML;
} else {
    header('Location:index.php');
    exit();
}

echo $page;