<?php
   try{
      // $pdo=new PDO("mysql:host=localhost;dbname=devtek","root","");
   }
   catch(PDOException $e){
      echo $e->getMessage();
   }
