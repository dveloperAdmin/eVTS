<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head="Device Command ";
$des="Page Load add_device_comand";
$rem="Device Command";
include '../include/_audi_log.php';

$device_sql = mysqli_query($conn_bio, "select * from `devices`");


if(isset($_POST['command_next'])){
    $device_id = $_POST['device_id'];
    $comad_id = $_POST['comand_id'];

    if($comad_id !="" && $comad_id!=""){
        $device_sl_no="";
        $device_sl_no_sql = mysqli_fetch_assoc(mysqli_query($conn_bio,"select * from `devices` where `DeviceId`='$device_id'"));
        if($device_sl_no_sql != ""){
            $device_sl_no= $device_sl_no_sql['SerialNumber'];
        }
        if($comad_id == 1){

            $title = "RESET TRANSACTION STAMP";
            $devicecommand = "C:UniqueId:CHECK";
            $serialnumber = $device_sl_no;
            $status = "PENDING";
            $type = "RESET TRANSACTION STAMP";
           

            $insert_sql = mysqli_query($conn_bio,"insert into `devicecommands`(`Title`, `DeviceCommand`, `SerialNumber`, `Status`, `Type`, `CreationDate`) values ('$title','$devicecommand','$serialnumber','$status','$type',CURRENT_TIMESTAMP)");
            if($insert_sql){
                $_SESSION['icon']='success';
                $_SESSION['status']=$title.' Added SucessFully...';
                $des="Click On Next button ";
                $rem="Add Device Command success";
                include '../include/_audi_log.php';
                
            } else{
                $_SESSION['icon']='error';
                $_SESSION['status']=$title.'Added UnsucessFull...';
                $des="Click On Next button ";
                $rem="Add Device Command  unsuccess";
                include '../include/_audi_log.php';
            }

        }else if($comad_id == 2){
            $title = "RESET OPSTAMP";
            $devicecommand = "C:UniqueId:CHECK";
            $serialnumber = $device_sl_no;
            $status = "PENDING";
            $type = "RESET OPSTAMP";
           
          

            $insert_sql = mysqli_query($conn_bio,"insert into `devicecommands`(`Title`, `DeviceCommand`, `SerialNumber`, `Status`, `Type`, `CreationDate`) values ('$title','$devicecommand','$serialnumber','$status','$type',CURRENT_TIMESTAMP)");
            if($insert_sql){
                $_SESSION['icon']='success';
                $_SESSION['status']=$title.' Added SucessFully...';
                $des="Click On Next button ";
                $rem="Add Device Command success";
                include '../include/_audi_log.php';
                
            } else{
                $_SESSION['icon']='error';
                $_SESSION['status']=$title.'Added UnsucessFull...';
                $des="Click On Next button ";
                $rem="Add Device Command  unsuccess";
                include '../include/_audi_log.php';
            }
        }else if($comad_id == 3){
            header("location:add_employee_command?divi=".$device_id);
        }else if($comad_id == 4){
            header("location:add_employee_command?divi=".$device_id);
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Not Possible to Add Device Comand ';
            $des="Click On Next button ";
            $rem="Add Device Command  unsuccess";
            include '../include/_audi_log.php';
        }

    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']='Please Give Currect Input';
        $des="Click On Next button ";
        $rem="Add Device Command  unsuccess";
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
                                        <div class="row">



                                            <div class="col-md-6" style="max-width: 60%; flex: 1 0 56%;">
                                                <div class="card">
                                                    <div class="card-header"
                                                        style="padding-bottom:8px;padding-top:8px;margin-bottom:1rem;">
                                                        <h5>Device Command</h5>
                                                    </div>
                                                    <div class="card-block table-border-style">


                                                        <form action="" method="post">

                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" style="padding-right: 0;max-width:9rem;">Device</label>
                                                                <div class="col-sm-9" style="display:flex; max-width: 50%;">
                                                                    <select name="device_id" id="com" class="form-control"style="margin-right:.5rem;max-height: 93%;" required>
                                                                        <option value="" disabled selected hidden>Select Device</option>
                                                                        <?php if($device_sql !=""){
                                                                            while($res = mysqli_fetch_assoc($device_sql)){?>

                                                                            <option value="<?php echo $res['DeviceId'];?>"><?php echo $res['SerialNumber']."&nbsp;&nbsp;&nbsp;&nbsp;".$res['DeviceFName'];?></option>

                                                                        <?php    }
                                                                            } ?>

                                                                    </select>



                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"style="padding-right: 0;max-width:9rem;">Command Perform</label>
                                                                <div class="col-sm-9"    style="display:flex; max-width: 50%;">
                                                        
                                                                <select name="comand_id" id="bran" class="form-control"   style="margin-right:.5rem;max-height: 93%;"required>
                                                                    <option value="" disabled selected hidden>Select Command</option>
                                                                        <option value="1">RESET TRANSACTION STAMP</option>
                                                                        <option value="2">RESET OPSTAMP</option>
                                                                        <option value="3">ADD Employee</option>
                                                                        <option value="4">DELETE Employee</option>

                                                                    </select>


                                                                </div>
                                                            </div>
                                                                    <div class="user-entry">
                                                                        <!-- <button class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;"name="com_emp_xls"><i class="icofont icofont-file-excel"style="    font-size: 20px;margin-right: 10px;"></i>  Back</button> -->
                                                                        <button  class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px;"  name="command_next"><i class="icofont icofont-arrow-right" style="    font-size: 20px;margin-right: 10px;"></i>  Next</button>
                                                                    </div>
                                                                </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
    </div>
    </div>
    </div>

    <!-- Required Jquery -->
    <?php include "include/footer.php";?>
</body>

</html>