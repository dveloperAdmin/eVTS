<?php
     $server ="localhost";
     $username ="root";
     $password ="";
     $db_cms ="vms";
     $db_bio ="biometric";
     try{
          $conn = mysqli_connect($server, $username, $password, $db_cms);
          if(!$conn){
               die("error" . mysqli_connect_error());
          }    
     }catch(Exception $e){
          $_SESSION['icon']='error';
          $_SESSION['status']='DataBase Connection Error';
     }

?>