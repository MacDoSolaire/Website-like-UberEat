<?php
require_once "autoload.php";
session_start();

$user = new User($_SESSION['id']);

$prenom = $user->getFirstName();
$nom = $user->getLastName();
$role = ucfirst($user->getRole());

$adresse = $user->getAdr();
$ville = $user->getCity();
$cdPost = $user->getCdPost();

$profile = <<<HTML
    <h4>Informations personnelles</h4>
    <div class="info">
        <div class="section">
            Nom : $nom
        </div>
        <div class="section">
            Prenom : $prenom
        </div>
        <div class="section">
            Type de compte : $role
        </div>
        <div class="section">
            Adresse : $adresse<br>
            $ville, $cdPost
        </div>
    </div>
HTML;

echo $profile;