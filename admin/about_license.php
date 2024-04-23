<?php 
include "../include/_session.php";
include "../include/_dbconnect.php";
$des="Page Load About License";
$rem="About License";
$head = "About License";
include "../include/_audi_log.php";

// pick MAC Id
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


  $myFile = fopen("../src/license.lic",'r');
      $id="";
      for($i=1; $i<=29;$i++){
          $id.=fgetc($myFile);
      }
      fclose($myFile);
      
      $theData = file("../src/license.lic");
      $id_key =$theData[1];
      //lic expired date
      $ac_date= substr($id,4,2 ).substr($id, 8,2). substr($id, 12,2).substr($id,26,3); ;
      $m_date = ($ac_date/7);
      $date = substr($m_date,0,4)."-".substr($m_date,4,2)."-".substr($m_date,6,2);

      // User Limitation
      $ac_user = substr($id,16,2 ).substr($id,20,2 ).substr($id,24,2 ) ;
      $users = (($ac_user/12)-57);
?>
<!DOCTYPE html>
<html lang="en">

<?php include "include/head.php";?>

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
                                                <h5 id="bio_sync" style="margin: 0;">Your MAC ID :- <span style="color:red;">&nbsp;<?php echo mac_id();?></span></h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            
                                        </div>
                                        <div class="card" style="padding:.5rem;    margin-bottom: 0.8rem;">
                                            <div class="col-md-6">
                                                <h5 id="bio_sync" style="margin: 0;">License Code Expire :- <span style="color:red;">&nbsp; <?php echo date("d-M-Y", strtotime($date))?></span></h5>
                                            </div>
                                        </div>
                                        <div class="row" id="timegap">
                                         <!-- dashbord start -->
                                            <?php //include "include/emp_bio_device_dashbord.php";?>
                                         <!-- dashbord end -->
                                        </div>
                                        <div class="card" style="padding:.5rem;    margin-bottom: 0.8rem;">
                                            <div class="col-md-6">
                                                <h5 id="bio_sync" style="margin: 0;">Employe Limitation :- <span style="color:red;">&nbsp; <?php echo $users;?></span> </h5>
                                            </div>
                                        </div>
                                         <!-- dashbord start -->
                                        <?php //include "include/emp_bio_dashbord.php";?>
                                         <!-- dashbord end -->
                                    </div>
                                    <!-- Page-body end -->
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <!-- Required Jquery -->
    <?php include "include/footer.php";?>
</body>

</html>
