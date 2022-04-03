<?php
require_once "autoload.php";

   session_start();
   @$nom=$_POST["nom"];
   @$prenom=$_POST["prenom"];
   @$mail = $_POST["mail"];
   @$tel = $_POST["tel"];
   @$adrCli = $_POST["adrCli"];
   @$ville = $_POST["ville"];
   @$cdPost = $_POST["cdPost"];
   @$login=$_POST["login"];
   @$pass=$_POST["pass"];
   @$repass=$_POST["repass"];
   @$valider=$_POST["valider"];
   $erreur="";



   if(isset($valider)){
      if(empty($nom)) $erreur="Nom laissé vide!";
      elseif(empty($prenom)) $erreur="Prénom laissé vide!";
      elseif(empty($mail)) $erreur="mail laissé vide!";
      elseif(empty($adrCli)) $erreur = "Adresse laisé vide";
      elseif(empty($ville)) $erreur="Ville laissé vide!";
      elseif(empty($cdPost)) $erreur="Code Postal laissé vide!";
      elseif(empty($tel)) $erreur="Telephone laissé vide!";
      elseif(empty($login)) $erreur="Login laissé vide!";
      elseif(empty($pass)) $erreur="Mot de passe laissé vide!";
      elseif($pass!=$repass) $erreur="Mots de passe non identiques!";
      else{
         include("connexion.php");
         $sel= MyPDO::getInstance()->prepare("select idCli from client where login=? limit 1");
         $sel->execute(array($login));
         $tab=$sel->fetchAll();
         if(count($tab)>0)
            $erreur="Login existe déjà!";
         else{
            $ins= MyPDO::getInstance()->prepare("insert into client(nomCli,prnCli,paswCli,login,mailCli,telCli,adrCli,ville,cdPost) values(?,?,?,?,?,?,?,?,?)");
            if($ins->execute(array($nom,$prenom,md5($pass),$login,$mail,$tel,$adrCli,$ville,$cdPost)))
               header("location:session.php");
         }   
      }
   }
?>

<!--doctype html-->
<html>

<head>
    <meta charset="utf-8">
    <title>22th Avenue</title>
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

<body>
<div class="login-page">
      <div class="form">
         <form class="login-form" name="fo" method="post" action="">
            <input type="text" name="nom" placeholder="Nom" value="<?php echo $nom?>" /><br />
            <input type="text" name="prenom" placeholder="Prénom" value="<?php echo $prenom?>" /><br />
            <input type="text" name="mail" placeholder="E-Mail" value="<?php echo $mail?>" /><br />
            <input type="text" name="adrCli" placeholder="Rue" value="<?php echo $adrCli?>" /><br />
            <input type="text" name="ville" placeholder="ville" value="<?php echo $ville?>" /><br />
            <input type="text" name="cdPost" placeholder="cdPost" value="<?php echo $cdPost?>" /><br />
            <input type="text" name="tel" placeholder="Telephone" value="<?php echo $tel?>" /><br />
            <input type="text" name="login" placeholder="Login" value="<?php echo $login?>" /><br />
            <input type="password" name="pass" placeholder="Mot de passe" /><br />
            <input type="password" name="repass" placeholder="Confirmer Mot de passe" /><br />

            <input class="button" type="submit" name="valider" value="S'authentifier" />
            <p class="message">Registered? <a href="login.php">Sign Up</a></p>
         </form>
      </div>
      </div>
</body>

</html>