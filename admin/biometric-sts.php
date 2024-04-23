<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Page Load biometric-sts";
$rem="Biometric Status";
$head  = "Biometric SetUp";
include '../include/_audi_log.php';

$sql_device_details = mysqli_query($conn_bio,"select * from `devices` order by `DeviceId` desc");

$device_name="";

if(isset($_POST['device_name'])){

    // audi_log entry
    $des="Click Edit To change Biometric Device Name";
    $rem="Change device name";
    include '../include/_audi_log.php';


    $sl_no= $_POST['devce_sl'];
    $sql_device_name = mysqli_fetch_assoc(mysqli_query($conn_bio,"select * from `devices` where `SerialNumber`='$sl_no'"));
    $device_name= $sql_device_name['DeviceFName'];
}

if(isset($_POST['bio_update'])){
    $div_name = $_POST['bio_device_name'];
    $device_sl_no = $_POST['serial_no'];
    $sql_update_device_name = mysqli_query($conn_bio,"update `devices` set `DeviceFName`='$div_name',`DevicesName`='$div_name' where `SerialNumber`='$device_sl_no'");
    if($sql_update_device_name){
        $sql_device_details = mysqli_query($conn_bio,"select * from `devices`");
        $_SESSION['icon'] = 'success';
        $_SESSION['status'] = 'Device Name Updated SuccessFull..';
        $des="Click Update To Update Biometric Device Name";
        $rem="Update Success";
        include '../include/_audi_log.php';
        // header("location:biometric-sts.php");
    }else{
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Device Name Updated Not Done...';
        $des="Click Update To Update Biometric Device Name";
        $rem="Update UnSuccess";
        include '../include/_audi_log.php';
    }
}





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

                                    <!-- Page body start -->
                                    <div class="page-body">
                                        
                                    <div class="card">
                                                <div class="card-block table-border-style">
                                                <div class="table-responsive table-short" style="height: 173px;">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 5rem;">Sl No.</th>
                                                                <th>Device Serial NO</th>
                                                                <th>Device Name</th>
                                                                <th>Device Direction</th>
                                                                <th>Ip Address</th>
                                                                <th>Last Ping</th>
                                                                <th>Location</th>
                                                                <th>Staus</th>
                                                                
                                                                <th style="  width: 10%;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                                $i=0;
                                                                while($device_data = mysqli_fetch_assoc($sql_device_details)){
                                                                    $i++;
                                                                    // device Status 
                                                                    $db_last_ping =  $device_data['LastPing'];
                                                                    $minutes_to_add = 5; 
                                                                    $time = new DateTime ($db_last_ping); 
                                                                    $time->add (new DateInterval ('PT'. $minutes_to_add. 'M')); 
                                                                    $stamp = $time->format ('Y-m-d H:i');
                                                                  
                                                                    $current_time = date("Y-m-d H:i");
                                                                   




                                                            ?>
                                                            <tr>
                                                                <th scope="row"><?php echo $i;?></th>
                                                                <td><?php echo $device_data['SerialNumber']; ?></td>
                                                                <td><?php echo $device_data['DeviceFName']; ?></td>
                                                                <td><?php echo $device_data['DeviceDirection']; ?></td>
                                                                <td><?php echo $device_data['IpAddress']; ?></td>
                                                                <td><?php echo $db_last_ping ; ?></td>
                                                                <td><?php echo $device_data['DeviceLocation']; ?></td>
                                                                <td><?php 
                                                                       if( $db_last_ping!="" && $current_time <= $stamp){
                                                                           echo "<span style='color:#02db49; font-weight:bold'>Online</span>";
                                                                        }else{
                                                                           echo "<span style='color:red; font-weight:bold'>Offline</span>";
                                                                       }
                                                                    ?>
                                                                </td>
                                                                
                                                                
                                                                <td>
                                                                    <form action="" method="post">
                                                                        <input type="hidden" name="devce_sl" value="<?php echo $device_data['SerialNumber']; ?>">
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary" name="device_name"><i class="icofont icofont-ui-edit"></i>Edit</button>

                                                                    </form>
                                                                    
                                                                   
                                                                </td>
                                                                
                                                          
                                                            </tr>
                                                            <?php }?>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                                </div>
                                            
                                            </div>
                                            </div>
                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="card" style="margin-bottom: 8px;">
                                                    <div class="card-header"  style="padding-bottom:8px;padding-top:8px;">
                                                        <h5>Device Details</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <form action="" method="post">
                                                        <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" style="padding-right: 0;">Device Name</label>
                                                                <div class="col-sm-9">
                                                                    <input type="hidden" name="serial_no"value="<?php echo $sl_no;?>">
                                                                    <input type="text" class="form-control" placeholder="Enter Device Name" name="bio_device_name" required value="<?php echo $device_name;?>">
                                                                </div>
                                                            </div>
                                                       
                                                          
                                                            <div class="user-entry">

                                                                <button type="reset"class="btn waves-effect waves-light btn-inverse btn-outline-inverse"style="padding: 7px 20px;"><i class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit"class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;" name="bio_update"><i class="fa fa-angle-double-up" style="    font-size: 20px;margin-right: 10px;"></i> Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                          
                                            
                                            <div class="col-md-6">
                                              
                                                    <div class="card text-center order-visitor-card" id="total-bio-sts" style="margin-bottom:8px">
                                                        <div class="card-block dsh-card signle-dash" >
                                                            <i class="icofont icofont-finger-print" style="font-size:8rem; margin-right:5rem"></i>
                                                            <div class="card-text">
                                                                <h6 class="m-b-0">Total BIOMETRIC</h6>
                                                                <h4 class="m-t-15 m-b-15"><?php $p = mysqli_num_rows($sql_device_details); echo $p;?></h4>
                                                                <p class="m-b-0" style="font-weight: bold;    font-size: 15px;"> </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!-- </div> -->
                                                <!-- <div class="row">
                                                <div class="col-md-6">
                                                    <div class="card text-center order-visitor-card" id="total-ca">
                                                        <div class="card-block dsh-card">
                                                            <i class="fa fa-check-square m-r-15 text-c-black"></i>
                                                            <div class="card-text">
                                                                <h6 class="m-b-0">Total Active Biometric</h6>
                                                                <h4 class="m-t-15 m-b-15">7652</h4>
                                                                <p class="m-b-0"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card text-center order-visitor-card" id="total-cda">
                                                        <div class="card-block dsh-card">
                                                            <i class="fa fa-window-close m-r-15 text-c-black"></i>
                                                            <div class="card-text">
                                                                <h6 class="m-b-0"> Total De-Active biometric</h6>
                                                                <h4 class="m-t-15 m-b-15">7652</h4>
                                                                <p class="m-b-0"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div> -->
                                                </div>
                                                </div>
                                         
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
