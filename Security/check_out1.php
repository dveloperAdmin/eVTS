<?php

include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head  = "Visitor Check Out";
$des="Page Load check_out1";
$rem="Visitor Check Out";
include '../include/_audi_log.php';
$e=false;
$log_out_time_sts = True;

if(isset($_POST['check_out'])){
    $id = $_POST['uid'];
    $date = $_POST['check_out_date'];
    $hrs = $_POST['hrs'];
    $mnt = $_POST['mnt'];
    $ampm = $_POST['ampm'];
    $time = $hrs.":".$mnt." ".$ampm;
    $sql_check_out ="";
    
    if($id!="" && $date!="" && $hrs!="" && $mnt!="" && $ampm!=""){
        $id = "VSL-".$id;
        $date = date("Y-m-d", strtotime($date));
        $time = date("H:i:s", strtotime($time));
        $user_id = $_SESSION['user_id'];
        $sql_check = mysqli_query($conn, "select * from `visitor_log` where `visit_uid` = '$id' and `check_status`!='OUT'");
        if(mysqli_num_rows($sql_check)>=1){
            $vi = mysqli_fetch_assoc(mysqli_query($conn,"select * from `visitor_log` where `visit_uid` = '$id' "));
            $check_sts = $vi['check_status'];
            $end_sts  = $vi['meeting_status'];
            $end_by = $vi['meeting_end_by'];
            if($check_sts == 'IN'){
                if($end_sts == 'End'){

                    
                    $check_in_date= strtotime($vi['checkin_date']);
                    $check_in_time = strtotime($vi['checkin_time']);
                    
                    $date_check = strtotime($date);
                    $time_check = strtotime($time);
                    if($check_in_date < $date_check){
                        if($end_by!=""){
                            $sql_check_out = mysqli_query($conn, "update `visitor_log` set `checkout_date`='$date',`checkout_time`='$time',`check_out_by`='$user_id',`check_status`='OUT' where `visit_uid` = '$id'");
                            
                        }else{
                            
                            $sql_check_out = mysqli_query($conn, "update `visitor_log` set `checkout_date`='$date',`checkout_time`='$time',`check_out_by`='$user_id',`check_status`='OUT',`meeting_end_by`='$user_id',`meeting_end_date`='$date',`meeting_end_time`='$time'  where `visit_uid` = '$id'");

                        }
                        $update_sts = mysqli_query($conn,"update `meeting_referrable` set `reffer_status`='Reffer End' where `refer_visitor`= '$id'");
                        
                        if($sql_check_out!=""){
                            $_SESSION['icon']='success';
                            $_SESSION['status']='Successfully Checked Out....';
                        }else{
                            $_SESSION['icon']='error';
                            $_SESSION['status']='Checked Out Not Possible....';
                        }
                        
                    }else if($check_in_date == $date_check && $check_in_time < $time_check){
                        if($end_by!=""){
                            $sql_check_out = mysqli_query($conn, "update `visitor_log` set `checkout_date`='$date',`checkout_time`='$time',`check_out_by`='$user_id',`check_status`='OUT' where `visit_uid` = '$id'");
                            
                        }else{
                            $sql_check_out = mysqli_query($conn, "update `visitor_log` set `checkout_date`='$date',`checkout_time`='$time',`check_out_by`='$user_id',`check_status`='OUT',`meeting_end_by`='$user_id',`meeting_end_date`='$date',`meeting_end_time`='$time'  where `visit_uid` = '$id'");

                        }
                        
                        $update_sts = mysqli_query($conn,"update `meeting_referrable` set `reffer_status`='Reffer End' where `refer_visitor`= '$id'");
                        
                        if($sql_check_out!=""){
                            $_SESSION['icon']='success';
                            $_SESSION['status']='Successfully Checked Out....';
                        }else{
                            $_SESSION['icon']='error';
                            $_SESSION['status']='Checked Out Not Possible....';
                        }
                    }
                    else{
                        $_SESSION['icon']='info';
                        $_SESSION['status']="Check Out Not Possible Before Check In Date & Time....";
                    }
                    
                }else{
                    $_SESSION['icon']='info';
                    $_SESSION['status']='Visitor Meeting Not Ended....';
                }
            }else{
                $_SESSION['icon']='info';
                $_SESSION['status']='Visitor Not Checked In....';
            }
        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']='Visitor Already Checked Out....';
        }
            
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']='Insufficient Data...';
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
                    <!-- <?php echo $pass; ?> -->
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
                                            <div class="col-md-6" style="flex:0 0 36%;">
                                                
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Visitor Check Out</h5>
                                                    </div>
                                                    
                                                    <div class="card-block">
                                                        <form action="" method="post">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">UID</label>
                                                                <div class="col-sm-9">
                                                                    <input list="emps" type="text" class="form-control"  placeholder="Enter Visitor Log Id " name="uid" required id="emp" autofocus>
                                                                        <datalist id="emps">
                                                                               
                                                                                <?php 
                                                                                    $sql_v_data = mysqli_query($conn,"select * from `visitor_log` where `check_status`='IN' order by `sl_no` desc");
                                                                                    while($v_data = mysqli_fetch_assoc($sql_v_data)){$log_id= explode("-",$v_data['visit_uid']); $log_id = $log_id[1];                                                                            
                                                                                ?>
                                                                                <option value="<?php echo $log_id;?>">
                                                                                <?php }?>
                                                                        </datalist>
                                                                        
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Date</label>
                                                                <div class="col-sm-9">
                                                                   <input type="date" name="check_out_date" class="form-control" value="<?php echo date("Y-m-d");?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Time</label>
                                                                <div class="col-sm-9" style="display:flex">
                                                                    <div style="padding:2px; width:6.1rem;">
                                                                        <select name="hrs" id="" class="form-control" style="text-align:center; font-weight:700;" required>
                                                                            <option value="<?php echo date("h");?>" selected hidden><?php echo date("h");?></option>
                                                                            <?php for($i=1; $i<=12; $i++){ if($i <10){$i = "0".$i;} ?>
                                                                                <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div style="padding:2px; width:6.1rem;">
                                                                        <select name="mnt" id="" class="form-control" style="text-align:center; font-weight:700;" required>
                                                                            <option value="<?php echo date("i");?>" selected hidden><?php echo date("i");?></option>
                                                                            <?php for($i=00; $i<60; $i++){ if($i <10){$i = "0".$i;} ?>
                                                                                <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div style="padding:2px; width:6.1rem;">
                                                                        <select name="ampm" id="" class="form-control" style="text-align:center;" required>
                                                                            <option value="<?php echo date("A");?>" selected hidden><?php echo date("A");?></option>
                                                                            <option value="AM">AM</option>
                                                                            <option value="PM">PM</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                
                                                            </div>
                                                            <div class="form-group row">
                                                                          
                                                            </div>


                                                            <div class="user-entry">

                                                                <button type="reset"    class="btn waves-effect waves-light btn-inverse btn-outline-inverse"><i  class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit"   class="btn waves-effect waves-light btn-primary btn-outline-primary"   name="check_out"><i class="fa fa-arrow-right" style="    font-size: 20px;margin-right: 10px;"></i>Check Out</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                   
                                            </div>
                                            <div class="col-md-6" style="padding-left:0px; flex:0 0 63%; max-width: 63%;">
                                            <div class="card " id="contact1">
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


<script type="text/javascript">

$("#emp").change(function()
{
let emp=$(this).val();
if(emp!=""){

    var emp_spl = emp.split(' ');
    let emp_id='V_log='+emp_spl;
    $.ajax
    ({
    type: "POST",
    url: "ajax.php",
    data: emp_id,
    cache: false,
    success: function(cities)
    {
    $("#contact1").css("display","block");
    $("#contact1").html(cities);
    } 
    });
}else{
    $("#contact1").css("display","none");
} 

});



</script>