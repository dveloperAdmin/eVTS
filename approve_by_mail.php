<?php
$sts="done";
include 'include/_dbconnect.php';
if(isset($_GET['sts'])){
    $sts = $_GET['sts'];
    $vc = $_GET['vc'];
    $v_id = "VSL-".$vc;
    $check_sts_of_app = mysqli_query($conn,"select * from `visitor_log` where `visit_uid`='$v_id' and `Emp_approve`='Pending'");
    if(mysqli_num_rows($check_sts_of_app)>=1){
        if($sts == "IN"){
            $update_app = mysqli_query($conn, "update `visitor_log` set `Emp_approve`='Approve' where `visit_uid`='$v_id' and `Emp_approve`='Pending'");
            if($update_app){
                $sts="true";
    
            }
        }else if($sts == "OUT"){
            $update_app = mysqli_query($conn, "update `visitor_log` set `Emp_approve`='Reject',`meeting_status`='Reject',`security_approval` = 'Reject',`check_status`='OUT' where `visit_uid`='$v_id' and `Emp_approve`='Pending'");
            if($update_app){
                $sts="false";
    
            }
    
        }

    }else{
        $sts = "done";
    }
}
// $serverName = $_SERVER['SERVER_NAME'];
// $serverPort = $_SERVER['SERVER_PORT'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VMS</title>
    <link rel="icon" href="admin/assets/images/favicon.png" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@800&display=swap');
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: 'Raleway', sans-serif;
        }
        body{
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:90vh;
            background:#8e8a8a;
        }
        h2{
            position:relative;
            font-size:8.5vw;
            color:#fff;
            -webkit-text-stroke: 0.3vw gray;
            
            /* text-transform: uppercase; */
        }
        #appro::before{
            content: attr(data-text1);
            position:absolute;
            top:0;
            left:0;
            width:0;
            height:100%;
            color:#44ff0dfa;
            -webkit-text-stroke: 0.2vw gray;
            border-right:2px solid #44ff0dfa;
            overflow:hidden;
            animation: animate 6s linear infinite;

        }
        #reje::before{
            content: attr(data-text2);
            position:absolute;
            top:0;
            left:0;
            width:0;
            height:100%;
            color:#ae0000fa;
            -webkit-text-stroke: 0.2vw gray;
            border-right:2px solid #ae0000fa;
            overflow:hidden;
            animation: animate 6s linear infinite;

        }
        #other::before{
            content: attr(data-text3);
            position:absolute;
            top:0;
            left:0;
            width:0;
            height:100%;
            color:#00ffd8fa;
            -webkit-text-stroke: 0.2vw gray;
            border-right:2px solid #00ffd8fa;
            overflow:hidden;
            animation: animate 6s linear infinite;

        }
        #done::before{
            content: attr(data-text4);
            position: absolute;
            top: 7px;
            left: 0px;
            width: 0px;
            height: 58%;
            color: #da3c03db;
            -webkit-text-stroke: 0.2vw gray;
            border-right: 2px solid #dcc70dfa;
            overflow: hidden;
            animation: animate 6s cubic-bezier(0.22, 0.61, 0.36, 1) infinite;
        
        }
        @keyframes animate {
            0%,10%{
                width:0;
            }
            70%,90%,100%{
                width:100%
            }

            
        }
    </style>
</head>
<body>
   
    <?php if($sts == "true"){?>
        <h2 id = "appro"data-text1="Approved.....">Approved.....</h2>
    <?php } else if($sts == "false"){ ?>
       <h2 id = "reje"data-text2="Rejected.....">Rejected.....</h2>
        
    <?php } else if( $sts == "done"){?>
        <h2 id = "done" data-text4="Action&nbsp;already&nbsp;done">Action&nbsp;already&nbsp;done</h2>
    <?php } else{ ?>
        <h2 id = "other" data-text3="No&nbsp;Response...">No&nbsp;Response...</h2>
    <?php } ?>

</body>
</html>

