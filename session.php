<?php
   session_start();
   if($_SESSION["autoriser"]!="oui"){
      header("location:login.php");
      exit();
   }
   if (!(isset($_SESSION['panier']))) {
      $dataPanier = array(
         'menu' => array(),
         'plat' => array(),
         'entree' => array(),
         'boisson' => array(),
         'dessert' => array()
      );
      $_SESSION['panier'] = $dataPanier;
   }
   header('Location: index.php');