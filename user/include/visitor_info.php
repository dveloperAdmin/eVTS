<?php
$sql_total_no_of_v_day=0;
$sql_total_no_of_v_month = 0;
$sql_total_no_of_check_in =0;
$sql_pre_regist =0;
 $user_name=$_SESSION['user_name'] ;
 $user_data = mysqli_fetch_assoc(mysqli_query($conn,"select * from `user` where `user_name`='$user_name'"));
 $emp_id="";
 if($user_data!=""){
    $emp_id = $user_data['EmployeeId'];
    $emp_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where `EmployeeId` = '$emp_id'"));
    $emp_code = $emp_details['Emp_code'];
    $_SESSION['emp_code'] = $emp_code;

    $first_date = date("Y-m-01");
    $last_date = date("Y-m-t");
    $today = date("Y-m-d");
    $sql_total_no_of_v_day= mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `checkin_date`= '$today' and `emp_id`='$emp_code'"));
    $sql_total_no_of_v_month = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `emp_id`='$emp_code' and `checkin_date` between '$first_date' and '$last_date'"));
    $sql_total_no_of_check_in = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `emp_id`='$emp_code'"));
    $sql_pre_regist = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `emp_id`='$emp_code' and `register_type` = 'PRE SCHEDULE'  and `pre_schedule_date`>= '$today' and `check_status`='Pending'"));
 }
 


?>


<div class="col-xl-6 col-md-12">
<div class="row">
        <!-- sale card start -->

        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="deactive1">
                <div class="card-block dsh-card">
                <i class="fa fa-users m-r-15 text-c-black"></i>
                <div class="card-text">
                    <h6 class="m-b-0 m-b-275">TODAY ( <?php echo date("l");?> ) </h6>
                    <h4 class="m-t-15 m-b-15"><?php echo  $sql_total_no_of_v_day;?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="total-A">
                <div class="card-block dsh-card">
                <i class="fa fa-calendar m-r-15 text-c-black"></i>
                <div class="card-text ">
                    <h6 class="m-b-0 m-b-275">THIS MONTH ( <?php echo date("F");?> )</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_v_month?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="active">
                <div class="card-block dsh-card">
                <i class="fa fa-user-plus m-r-15 text-c-black"></i>
                <div class="card-text">
                    <h6 class="m-b-0">ACTIVE</h6>
                    <h4 class="m-t-15 m-b-15"><?php //echo $total_active?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="deactive">
                <div class="card-block dsh-card">
                <i class="fa fa-user-times m-r-15 text-c-black"></i>
                <div class="card-text">
                    <h6 class="m-b-0">DE-ACTIVE</h6>
                    <h4 class="m-t-15 m-b-15"><?php //echo $total_deactive;?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div> -->
        
        
        <!-- <div class="col-md-6">
            <div class="card text-center order-visitor-card">
                <div class="card-block">
                    <h6 class="m-b-0">Unique Visitors</h6>
                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-down m-r-15 text-c-red"></i>652</h4>
                    <p class="m-b-0">36% From Last 6 Months</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center order-visitor-card">
                <div class="card-block">
                    <h6 class="m-b-0">Monthly Earnings</h6>
                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>5963</h4>
                    <p class="m-b-0">36% From Last 6 Months</p>
                </div>
            </div>
        </div> -->
        <!-- sale card end -->
    </div>
</div>
<div class="col-xl-6 col-md-12">
    <div class="row">
        <!-- sale card start -->

        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="users3">
                <div class="card-block dsh-card">
                <i class="icofont icofont-users-social m-r-15 text-c-black" style="font-size:3rem"></i>
                <div class="card-text">
                    <h6 class="m-b-0 m-b-275"> PRE SCHEDULE VISITORS</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $sql_pre_regist;?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="active">
                <div class="card-block dsh-card">
                <i class="icofont icofont-users-social m-r-15 text-c-black" style="font-size:3rem"></i>
                <div class="card-text">
                    <h6 class="m-b-0 m-b-275"> TOTAL VISITORS</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_check_in;?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-6">
            <div class="card text-center order-visitor-card">
                <div class="card-block">
                    <h6 class="m-b-0">Order Status</h6>
                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>6325</h4>
                    <p class="m-b-0">36% From Last 6 Months</p>
                </div>
            </div>
        </div> -->
        <!-- <div class="col-md-6">
            <div class="card bg-c-red total-card">
                <div class="card-block">
                    <div class="text-left">
                        <h4>489</h4>
                        <p class="m-0">Total Comment</p>
                    </div>
                    <span class="label bg-c-red value-badges">15%</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-c-green total-card">
                <div class="card-block">
                    <div class="text-left">
                        <h4>$5782</h4>
                        <p class="m-0">Income Status</p>
                    </div>
                    <span class="label bg-c-green value-badges">20%</span>
                </div>
            </div>
        </div> -->
        <!-- <div class="col-md-6">
            <div class="card text-center order-visitor-card">
                <div class="card-block">
                    <h6 class="m-b-0">Unique Visitors</h6>
                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-down m-r-15 text-c-red"></i>652</h4>
                    <p class="m-b-0">36% From Last 6 Months</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center order-visitor-card">
                <div class="card-block">
                    <h6 class="m-b-0">Monthly Earnings</h6>
                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>5963</h4>
                    <p class="m-b-0">36% From Last 6 Months</p>
                </div>
            </div>
        </div> -->
        <!-- sale card end -->
    </div>
</div>