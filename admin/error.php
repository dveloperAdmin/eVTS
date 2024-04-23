<?php
$error_msg1 = "";
if(isset($_GET['error_id'])){
    $erro_id = $_GET['error_id'];

    if($erro_id == 1){
        $error_msg1= "Invalid Activation Code.......(Manualy Changed) ";
    }
    elseif($erro_id == 2){
        $error_msg1= "Someone Change Your License Details.........(Manualy Changed) ";
    }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <style>
        .btn-extend{
        padding: 0.2rem 2rem;
       
        text-align: center;
        font-family: inherit;
        color: #fff;
        background:#166beff7; 
        cursor:pointer;
        border-radius: 9px;
        height: 50px;
        font-size: 25px;
        border:none;

    }
    </style>
</head>
<body>
    
<span style="color:red"><h1><?php echo $error_msg1;?></h1></span>


<a href="../"><button class="btn-extend">Loging</button></a>
</body>
</html>