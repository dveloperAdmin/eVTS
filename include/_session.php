<?php 
session_start();
date_default_timezone_set("Asia/Calcutta");
$current_date=date("d-M-Y");
$current_time=date("H:i:s");
$current_date_time=$current_date." - ".$current_time;
if(!isset($_SESSION['loged_in']) && $_SESSION['loged_in'] != true){
    session_unset();
    session_destroy();
    header("location:../index.php");
    exit;
}

?>