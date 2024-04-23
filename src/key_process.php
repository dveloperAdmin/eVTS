<?php
// include "../include/_session.php";
include "../include/_dbconnect.php";

$key="";
$blank = 0;
for($i = 1 ; $i<=29; $i++){
    if($_POST['digit-'.$i] !=""){

        $key.= $_POST['digit-'.$i];
    }else{
        $blank+=1;
    }

}
echo strlen($key);




?>