<?php 
include "../include/_session.php";
include "../include/_dbconnect.php";
// include '../include/_lic_check.php';
$des="Page Load License_Extends ";
$rem="License_Extend";
$head = "License Extend";
include "../include/_audi_log.php";

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
        
        if($mac_id == $sys_mac_id ){
            $ac_co = substr($key,0,2);
            $ac_date = substr($key,4,2 ).substr($key, 8,2). substr($key, 12,2).substr($key,26,3);
            $acm_date = ($ac_date/7);
            $date = substr($acm_date,0,4)."-".substr($acm_date,4,2)."-".substr($acm_date,6,2);
            $ac_user = substr($key,16,2 ).substr($key,20,2 ).substr($key,24,2 ) ;
            $users = (($ac_user/12)-57);
           
                if( date("Y-m-d") < $date && $ac_co == "BT"){
                    $myFile = fopen("../src/license.lic",'r');
                    $id="";
                    for($i=1; $i<=29;$i++){
                        $id.=fgetc($myFile);
                    }
                    fclose($myFile);
                    
                    $theData = file("../src/license.lic");
                    
                    $id_key =$theData[1];
                    $db_code = "";
                    $active_key = mysqli_fetch_assoc(mysqli_query($conn,"select * from `activation_key` where `key_id`='$id_key'"));
                    if($active_key !=""){
                        $db_code = $active_key['activation_key'];
                    }
                    if(password_verify($id,$db_code)){    
                        mysqli_query($conn,"truncate `activation_key`");

                        $fp = fopen("../src/license.lic", "r+");
                        ftruncate($fp, 0);
                        fclose($fp);
                        
                        $key_id = "AK-".time();
                        $pass_key =  password_hash($key, PASSWORD_DEFAULT);
                        
                        mysqli_query($conn,"insert into `activation_key`(`key_id`, `activation_key`,
                        `date_expire`,`no_of_user`,`status`) values ('$key_id','$pass_key','$date','$users','Active')");
                        
                        $key_strore = "\n".$key_id;
                        $fp = fopen('../src/license.lic', 'w');
                        fwrite($fp, $key);
                        fwrite($fp, $key_strore);
                        fclose($fp);

                        $_SESSION['update'] = 'success';
                        $_SESSION['status']='Your Activation Key Extended'; 
                            
                    }else{
                        
                        // session_start();
                        $_SESSION['icon'] = 'warning';
                        $_SESSION['status']='Somthing Wrong in The Activation Key'; 
                        
                    }
                }else{
                    
                    $_SESSION['icon'] = 'error';
                    $_SESSION['status']='Activation Key Expired';  
                }
                
            
        }else{
            // session_start();
            $_SESSION['icon'] = 'error';
            $_SESSION['status']='MAC ID Miss Match ';
        }

        
    }else{
        // session_start();
        $_SESSION['icon'] = 'error';
        $_SESSION['status']='Enter Activation Key CareFully';
    }
    
}
   















?>
<!DOCTYPE html>
<html lang="en">

<?php include "include/head.php";?>
<style>
    .style-key-input{
        width: 25px;
        height: 40px;
        text-align: center;
        font-size:15px;
        font-weight:900;
    }
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
    .btn-extend:hover{
        background:#0a8a0ef7;
    }
 </style>   

<body>
    <!-- Pre-loader start -->
    <?php include "include/pre_loader.php"; ?>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <!-- navbar start -->
            <?php include "include/navbar.php"; ?>
            <!-- navbar end -->

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">

                    <!-- Side Manu start -->
                    <?php include "include/manu.php"; ?>
                    <!-- Side Manu end -->

                    <div class="pcoded-content">

                        <!-- Page-header start -->
                        <?php include "include/header.php"?>
                        <!-- Page-header end -->

                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page-body start -->
                                    <div class="page-body">
                                        <div class="card" style="padding:.5rem;    margin-bottom: 0.8rem;">
                                            <div class="col-md-6">
                                                <h5 id="bio_sync" style="margin: 0;">Extend License </h5>
                                            </div>
                                        </div>



                                        <div class="card">


                                            <div class="card-block">


                                                <form action="" method="post" class="digit_group">
                                                    <!-- <form method="post" action="key_process.php" class="digit_group"  data-group-name="digits" data-autosubmit="false" autocomplete="off"> -->
                                                    <input class="style-key-input" type="text" id="digit-1" name="digit-1" data-next="digit-2"
                                                         required />
                                                    <input class="style-key-input" type="text" id="digit-2" name="digit-2" data-next="digit-3"
                                                        data-previous="digit-1" required />
                                                    <input class="style-key-input" type="text" id="digit-3" name="digit-3" data-next="digit-4"
                                                        data-previous="digit-2" required />
                                                    <input class="style-key-input" type="text" id="digit-4" name="digit-4" data-next="digit-5"
                                                        data-previous="digit-3" required />
                                                    <span class="splitter">&ndash;</span>

                                                    <input class="style-key-input" type="text" id="digit-5" name="digit-5" data-next="digit-6"
                                                        data-previous="digit-4" required />
                                                    <input class="style-key-input" type="text" id="digit-6" name="digit-6" data-next="digit-7"
                                                        data-previous="digit-5" required />
                                                    <input class="style-key-input" type="text" id="digit-7" name="digit-7" data-next="digit-8"
                                                        data-previous="digit-6" required />
                                                    <input class="style-key-input" type="text" id="digit-8" name="digit-8" data-next="digit-9"
                                                        data-previous="digit-7" required />
                                                    <span class="splitter">&ndash;</span>
                                                    <input class="style-key-input" type="text" id="digit-9" name="digit-9" data-next="digit-10"
                                                        data-previous="digit-8" required />
                                                    <input class="style-key-input" type="text" id="digit-10" name="digit-10"
                                                        data-next="digit-11" data-previous="digit-9" required />
                                                    <input class="style-key-input" type="text" id="digit-11" name="digit-11"
                                                        data-next="digit-12" data-previous="digit-10" required />
                                                    <input class="style-key-input" type="text" id="digit-12" name="digit-12"
                                                        data-next="digit-13" data-previous="digit-11" required />

                                                    <span class="splitter">&ndash;</span>
                                                    <input class="style-key-input" type="text" id="digit-13" name="digit-13"
                                                        data-next="digit-14" data-previous="digit-12" required />
                                                    <input class="style-key-input" type="text" id="digit-14" name="digit-14"
                                                        data-next="digit-15" data-previous="digit-13" required />
                                                    <input class="style-key-input" type="text" id="digit-15" name="digit-15"
                                                        data-next="digit-16" data-previous="digit-14" required />
                                                    <input class="style-key-input" type="text" id="digit-16" name="digit-16"
                                                        data-next="digit-17" data-previous="digit-15" required />

                                                    <span class="splitter">&ndash;</span>
                                                    <input class="style-key-input" type="text" id="digit-17" name="digit-17"
                                                        data-next="digit-18" data-previous="digit-16" required />
                                                    <input class="style-key-input" type="text" id="digit-18" name="digit-18"
                                                        data-next="digit-19" data-previous="digit-17" required />
                                                    <input class="style-key-input" type="text" id="digit-19" name="digit-19"
                                                        data-next="digit-20" data-previous="digit-18" required />
                                                    <input class="style-key-input" type="text" id="digit-20" name="digit-20"
                                                        data-next="digit-21" data-previous="digit-19" required />

                                                    <span class="splitter">&ndash;</span>
                                                    <input class="style-key-input" type="text" id="digit-21" name="digit-21"
                                                        data-next="digit-22" data-previous="digit-20" required />
                                                    <input class="style-key-input" type="text" id="digit-22" name="digit-22"
                                                        data-next="digit-23" data-previous="digit-21" required />
                                                    <input class="style-key-input" type="text" id="digit-23" name="digit-23"
                                                        data-next="digit-24" data-previous="digit-22" required />
                                                    <input class="style-key-input" type="text" id="digit-24" name="digit-24"
                                                        data-next="digit-25" data-previous="digit-23" required />

                                                    <span class="splitter">&ndash;</span>
                                                    <input class="style-key-input" type="text" id="digit-25" name="digit-25"
                                                        data-next="digit-26" data-previous="digit-24" required />
                                                    <input class="style-key-input" type="text" id="digit-26" name="digit-26"
                                                        data-next="digit-27" data-previous="digit-25" required />
                                                    <input class="style-key-input" type="text" id="digit-27" name="digit-27"
                                                        data-next="digit-28" data-previous="digit-26" required />
                                                    <input class="style-key-input" type="text" id="digit-28" name="digit-28"
                                                        data-next="digit-29" data-previous="digit-27" required />

                                                    <span class="splitter">&ndash;</span>
                                                    <input class="style-key-input" type="text" id="digit-29" name="digit-29"
                                                        data-previous="digit-28" required />

                                                    <div class="prompt" style="margin-top: 2rem;">
                                                        
                                                            <Button type="submit" name="active_key" class="btn-extend"style="">Extend Key</Button>
                                                        
                                                    </div>
                                                </form>



                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <!-- Page-body end -->
                        </div>

                    </div>
                </div>
            </div>
        </div>


<?php if(isset($_SESSION['update']) && $_SESSION['update']!=''){ 
    if($_SESSION['update'] == 'success'){?>
<script>

Swal.fire({
  title: "Extend License",
  text: "Your Software Licnese Key Extend Successfully... Please Login again...",
  icon: "success",
  
  showConfirmButton: true
}).then(function() {
    window.location = "../include/_logout.php";
});

</script>
<?php 
        }
    }
?>
        <!-- Required Jquery -->
        <?php include "include/footer.php";?>
</body>

</html>


<!-- <script type="text/javascript" src="../src/jquery.min.js "></script> -->
<script language="JavaScript" type="text/javascript" src="../src/scq1.js"></script>