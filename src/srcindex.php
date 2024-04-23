<?php
// include "../include/_session.php";
include "../include/_dbconnect.php";

function mac_id(){
    ob_start();  
     
    //Getting configuration details 
    system('ipconfig /all');  
    
    //Storing output in a variable 
    $configdata=ob_get_contents();  
    
    // Clear the buffer  
    ob_clean();  
    
    //Extract only the physical address or Mac address from the output
    $mac = "Physical";  
    $pmac = strpos($configdata, $mac);
    
    // Get Physical Address  
    $macaddr=substr($configdata,($pmac+36),17);  
    
    //Display Mac Address  
    return($macaddr); 
  }

if(isset($_POST['active_key'])){
    $key="";
    $blank = 0;

    for($i = 1 ; $i<=29; $i++){
        if($_POST['digit-'.$i] !=""){
            
            $key.= $_POST['digit-'.$i];
        }else{
            $blank+=1;
        }
        
    }
    if($blank == 0 && strlen($key)==29){
        $mac_id = substr($key,2,2)."-".substr($key,10,2)."-".substr($key,18,2)."-".substr($key,22,2)."-".substr($key,14,2)."-".substr($key,6,2) ;
        $sys_mac_id = mac_id();
        
        // if($mac_id ==$sys_mac_id ){
            $ac_co = substr($key,0,2);
            $ac_date = substr($key,4,2 ).substr($key, 8,2). substr($key, 12,2).substr($key,26,3);
            $acm_date = ($ac_date/7);
            $date = substr($acm_date,0,4)."-".substr($acm_date,4,2)."-".substr($acm_date,6,2);

            if( date("Y-m-d") <$date ){

                $ac_user = substr($key,16,2 ).substr($key,20,2 ).substr($key,24,2 ) ;
                $users = (($ac_user/12)-57);
                if(file_get_contents('license.lic') == ""){
 
                    $key_id = "AK-".time();
                    $pass_key =  password_hash($key, PASSWORD_DEFAULT);
                    
                    mysqli_query($conn,"insert into `activation_key`(`key_id`, `activation_key`,`date_expire`,`no_of_user`,`status`) values ('$key_id','$pass_key','$date','$users', 'Active')");
                    
                    $key_strore = "\n".$key_id;
                    $fp = fopen('license.lic', 'w');
                    fwrite($fp, $key);
                    fwrite($fp, $key_strore);
                    fclose($fp);
                   
                    header("location:../index.php?i=y");
                    
                }
                else{
                    $myFile = fopen("license.lic",'r');
                    $id="";
                    for($i=1; $i<=29;$i++){
                        $id.=fgetc($myFile);
                    }
                    fclose($myFile);
                    
                    $theData = file("license.lic");
                    $id_key =$theData[1];

                    $db_key = "";
                    $active_key = mysqli_fetch_assoc(mysqli_query($conn,"select * from `activation_key` where `key_id`='$id_key'"));
                    if($active_key!=""){
                        $db_key = $active_key['activation_key'];
                    }

                    if(password_verify($id,$db_key)){
                        // "BT + 1,2 mac" - "1,2 modified date + 16,17 mac" - "3,4 of modified date + 4,5 of mac" - "5,6 of modified date + 13,14 of mac " - "1,2 of modified user + 7,9 of mac" - "3,4 of modified user + 11,12 of mac" - "5,6 of modified user +   7,8 of modified date" - "9 of modified date"
                        $ac_date2 = substr($id,4,2 ).substr($id, 8,2). substr($id, 12,2).substr($id,26,3);
                        $acmarge_date2 = ($ac_date2/7);
                        $date2 = substr($acmarge_date2,0,4)."-".substr($acmarge_date2,4,2)."-".substr($acmarge_date2,6,2);
                        
                        
                        if($date2< date("Y-m-d")){
                            
                            
                            $fp = fopen("license.lic", "r+");
                            ftruncate($fp, 0);
                            fclose($fp);
                            mysqli_query($conn,"truncate `activation_key`");
                            
                            $key_id = "AK-".time();
                            $pass_key =  password_hash($key, PASSWORD_DEFAULT);
                            
                            mysqli_query($conn,"insert into `activation_key`(`key_id`, `activation_key`,`date_expire`,`no_of_user`,`status`) values ('$key_id','$pass_key','$date','$users', 'Active')");
                    
                            
                            $key_strore = "\n".$key_id;
                            $fp = fopen('license.lic', 'w');
                            fwrite($fp, $key);
                            fwrite($fp, $key_strore);
                            fclose($fp);
                            header("location:../index.php?i=y");
                            
                        }else{
                            header("location:../index.php?i=n");
                        }
                    }else{
                        
                        session_start();
                        $_SESSION['icon'] = 'warning';
                        $_SESSION['status']='Somthing Wrong in The Activation Key'; 
                        
                    }
                    
                }
            }else{
                session_start();
                $_SESSION['icon'] = 'error';
                $_SESSION['status']='Activation Key Expired';  
            }
        // }else{
        //     session_start();
        //     $_SESSION['icon'] = 'error';
        //     $_SESSION['status']='MAC ID Miss Match ';
        // }

        
    }else{
        session_start();
        $_SESSION['icon'] = 'error';
        $_SESSION['status']='Enter Activation Key CareFully';
    }
    
}
    


?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script  language="JavaScript" type="text/javascript" src="src.js"></script> -->
    <title>Activation Key</title>
    <link rel="icon" href="logo.png" type="image/icon type">
    <link rel="stylesheet" href="src6.css">

    <script src="sweetalert2.js"></script>
    
</head>
<body>
    <div style="height:73%" id="in_form">

        <div class="prompt">
           Enter The Activation Key 
        </div>
        <div class="prompt">
           Your MAC ID : <?php echo mac_id();?>
        </div>
        <form action="" method="post"  class="digit_group">
        <!-- <form method="post" action="key_process.php" class="digit_group"  data-group-name="digits" data-autosubmit="false" autocomplete="off"> -->
        <input type="text" id="digit-1" name="digit-1" data-next="digit-2" autofocus required/>
            <input type="text" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" required/>
            <input type="text" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" required/>
            <input type="text" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" required/>
            <span class="splitter">&ndash;</span>
            
            <input type="text" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" required/>
            <input type="text" id="digit-6" name="digit-6" data-next="digit-7" data-previous="digit-5" required/>
            <input type="text" id="digit-7" name="digit-7" data-next="digit-8" data-previous="digit-6" required/>
            <input type="text" id="digit-8" name="digit-8" data-next="digit-9" data-previous="digit-7" required/>
            <span class="splitter">&ndash;</span>
            <input type="text" id="digit-9" name="digit-9" data-next="digit-10" data-previous="digit-8" required/>
            <input type="text" id="digit-10" name="digit-10" data-next="digit-11" data-previous="digit-9" required/>
            <input type="text" id="digit-11" name="digit-11" data-next="digit-12" data-previous="digit-10" required/>
            <input type="text" id="digit-12" name="digit-12" data-next="digit-13" data-previous="digit-11" required/>
            
            <span class="splitter">&ndash;</span>
            <input type="text" id="digit-13" name="digit-13" data-next="digit-14" data-previous="digit-12" required/>
            <input type="text" id="digit-14" name="digit-14" data-next="digit-15" data-previous="digit-13" required/>
            <input type="text" id="digit-15" name="digit-15" data-next="digit-16" data-previous="digit-14" required/>
            <input type="text" id="digit-16" name="digit-16" data-next="digit-17" data-previous="digit-15" required/>
            
            <span class="splitter">&ndash;</span>
            <input type="text" id="digit-17" name="digit-17" data-next="digit-18" data-previous="digit-16" required/>
            <input type="text" id="digit-18" name="digit-18" data-next="digit-19" data-previous="digit-17" required/>
            <input type="text" id="digit-19" name="digit-19" data-next="digit-20" data-previous="digit-18" required/>
            <input type="text" id="digit-20" name="digit-20" data-next="digit-21" data-previous="digit-19" required/>
      
            <span class="splitter">&ndash;</span>
            <input type="text" id="digit-21" name="digit-21" data-next="digit-22" data-previous="digit-20" required/>
            <input type="text" id="digit-22" name="digit-22" data-next="digit-23" data-previous="digit-21" required/>
            <input type="text" id="digit-23" name="digit-23" data-next="digit-24" data-previous="digit-22" required/>
            <input type="text" id="digit-24" name="digit-24" data-next="digit-25" data-previous="digit-23" required/>
        
            <span class="splitter">&ndash;</span>
            <input type="text" id="digit-25" name="digit-25" data-next="digit-26" data-previous="digit-24" required/>
            <input type="text" id="digit-26" name="digit-26" data-next="digit-27" data-previous="digit-25" required/>
            <input type="text" id="digit-27" name="digit-27" data-next="digit-28" data-previous="digit-26" required/>
            <input type="text" id="digit-28" name="digit-28" data-next="digit-29" data-previous="digit-27" required/>
           
            <span class="splitter">&ndash;</span>
            <input type="text" id="digit-29" name="digit-29" data-previous="digit-28" required/>
        
           <div class="prompt" style="margin-top: 2rem;" >
                <Button type="submit" name="active_key"style="padding: 0.2rem 2rem; font-size: 2rem; text-align: center;font-family: inherit;color: #fff;background: #11195af7; cursor:pointer;">Active System</Button>
            </div>
        </form>
        <a href="../"><Button  style="padding: 0.2rem 2rem; font-size: 2rem; text-align: center;font-family: inherit;color: #fff;background: #11195af7; cursor:pointer; border:none;">Back</Button></a>
    </div>
    
</body>

<script type="text/javascript" src="jquery.min.js "></script>
<script  language="JavaScript" type="text/javascript" src="scq1.js"></script>

<?php

if(isset($_SESSION['status']) && $_SESSION['status']!=''){ ?>
  <script>
Swal.fire({
icon: '<?php echo $_SESSION['icon'] ?>',
title: '<?php echo $_SESSION['status'] ?>',
showCloseButton: true,
confirmButton: true,

})
</script>
<?php
unset($_SESSION['status']);
unset($_SESSION['icon']);
session_destroy();
}?>
</html>

