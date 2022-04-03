<?php
require_once "autoload.php";
session_start();

if (isset($_SESSION['autoriser']) == 'oui') {
    $user = new User($_SESSION['id']);

    if ($user->getRole() == 'Client') {
        header('Location:compteCli.php');
        exit();
    } elseif ($user->getRole() == 'admin') {
        header('Location:compteAd.php');
        exit();
    } elseif ($user->getRole() == 'Livreur') {
        header('Location:compteLiv.php');
        exit();
    }
}