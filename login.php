<?php
require_once "autoload.php";

   session_start();
   @$login=$_POST["login"];
   @$pass=md5($_POST["pass"]);
   @$valider=$_POST["valider"];
   $erreur="";
   if(isset($valider)){
      include("connexion.php");
      $sel= MyPDO::getInstance()->prepare("select * from client where login=? and paswCli=? limit 1");
      $sel->execute(array($login,$pass));
      $tab=$sel->fetchAll();
      if(count($tab)>0){
         $_SESSION["prenomNom"]=ucfirst(strtolower($tab[0]["prenom"])).
         " ".strtoupper($tab[0]["nom"]);
         $_SESSION["autoriser"]="oui";
         $_SESSION["id"] = $tab[0]['idCli'];
         $_SESSION["boisson"] = array();
         header("location:session.php");
      }
      else
         $erreur="Mauvais login ou mot de passe!";
   }
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <style>
         @import url(https://fonts.googleapis.com/css?family=Roboto:300);

         .login-page {
         width: 360px;
         padding: 8% 0 0;
         margin: auto;
         }
         .form {
         position: relative;
         z-index: 1;
         background: #FFFFFF;
         max-width: 360px;
         margin: 0 auto 100px;
         padding: 45px;
         text-align: center;
         box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
         }
         .form input {
         font-family: "Roboto", sans-serif;
         outline: 0;
         background: #f2f2f2;
         width: 100%;
         border: 0;
         margin: 0 0 15px;
         padding: 15px;
         box-sizing: border-box;
         font-size: 14px;
         }
         .form .button {
         font-family: "Roboto", sans-serif;
         text-transform: uppercase;
         outline: 0;
         background: #2f3640;
         width: 100%;
         border: 0;
         padding: 15px;
         color: #FFFFFF;
         font-size: 14px;
         -webkit-transition: all 0.3 ease;
         transition: all 0.3 ease;
         cursor: pointer;
         }
         .form .button:hover,.form .button:active,.form .button:focus {
         background: #c23616;
         }
         .form .message {
         margin: 15px 0 0;
         color: #2f3640;
         font-size: 12px;
         }
         .form .message a {
         color: #c23616;
         text-decoration: none;
         }
         .form .register-form {
         display: none;
         }
         .container {
         position: relative;
         z-index: 1;
         max-width: 300px;
         margin: 0 auto;
         }
         .container:before, .container:after {
         content: "";
         display: block;
         clear: both;
         }
         .container .info {
         margin: 50px auto;
         text-align: center;
         }
         .container .info h1 {
         margin: 0 0 15px;
         padding: 0;
         font-size: 36px;
         font-weight: 300;
         color: #1a1a1a;
         }
         .container .info span {
         color: #4d4d4d;
         font-size: 12px;
         }
         .container .info span a {
         color: #000000;
         text-decoration: none;
         }
         .container .info span .fa {
         color: #EF3B3A;
         }
         body {
         background: #2f3640;
         font-family: "Roboto", sans-serif;
         -webkit-font-smoothing: antialiased;
         -moz-osx-font-smoothing: grayscale;      
         }
      </style>
   </head>
   <body onLoad="document.fo.login.focus()">
      <div class="login-page">
      <div class="form">
         <form class="login-form" name="fo" method="post" action="">
            <div class="erreur"><?php echo $erreur ?></div>
            <input type="text" name="login" placeholder="Login" />
            <input type="password" name="pass" placeholder="Mot de passe" />
            <input  class="button" type="submit" name="valider" value="S'authentifier" />
            <p class="message">Not registered? <a href="inscription.php">Create an account</a></p>
         </form>
      </div>
      </div>
   </body>
</html> 