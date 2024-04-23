<?php
include '_dbconnect.php';
session_start();
date_default_timezone_set("Asia/Calcutta");
$current_date=date("d-M-Y");
$current_time=date("H:i:s");
$current_date_time=$current_date." - ".$current_time;
$log_id = $_SESSION['log_id'];
$logout_sql = mysqli_query($conn,"update `log_book` set `logout_date`='$current_date',`logout_time`='$current_time',`status`='Success' where `uid`='$log_id'");
if($logout_sql){
    $des="Click On Logout Button";
    $rem="Logout Success";
    include '../include/_audi_log.php';

    session_unset();
    session_destroy();
    header("location:../");
}



?>