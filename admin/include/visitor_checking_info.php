<?php

$first_date = date("Y-m-01");
 $last_date = date("Y-m-t");
 $today = date("Y-m-d");
 if(in_array($user_role, array("Developer", "Super Admin"))){
     $sql_total_no_of_v_day= mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `checkin_date`= '$today'"));
     $sql_total_no_of_v_day_out= mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `checkin_date`= '$today' and `check_status` = 'OUT'"));
     $sql_total_no_of_v_day_stay= mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `checkin_date`= '$today' and `check_status` != 'OUT'"));
     $sql_total_no_of_v_month = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `checkin_date` between '$first_date' and '$last_date'"));
     $sql_total_no_of_v_month_out = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `check_status` = 'OUT' and `checkin_date` between '$first_date' and '$last_date'"));
     $sql_total_no_of_v_month_stay = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where  `check_status` != 'OUT' and `checkin_date` between '$first_date' and '$last_date'"));
     $sql_total_no_of_V = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log`where `checkin_date`!='0000-00-00'"));
     $sql_total_no_of_V_out = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `checkout_date`!='0000-00-00'"));
     $sql_total_no_of_V_stay = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `checkin_date`='0000-00-00' and `check_status` = 'IN'"));
     $sql_total_no_of_check_in = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `checkin_date`= '$today' and `check_status` = 'IN'"));

 }else{

     $sql_total_no_of_v_day= mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `branch_id`='$branch_id'and `checkin_date`= '$today'"));
     $sql_total_no_of_v_day_out= mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `branch_id`='$branch_id'and `checkin_date`= '$today' and `check_status` = 'OUT'"));
     $sql_total_no_of_v_day_stay= mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `branch_id`='$branch_id'and `checkin_date`= '$today' and `check_status` != 'OUT'"));
     $sql_total_no_of_v_month = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `branch_id`='$branch_id'and `checkin_date` between '$first_date' and '$last_date'"));
     $sql_total_no_of_v_month_out = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `branch_id`='$branch_id'and `check_status` = 'OUT' and `checkin_date` between '$first_date' and '$last_date'"));
     $sql_total_no_of_v_month_stay = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `branch_id`='$branch_id'and  `check_status` != 'OUT' and `checkin_date` between '$first_date' and '$last_date'"));
     $sql_total_no_of_V = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log`where `branch_id`='$branch_id'and `checkin_date`!='0000-00-00'"));
     $sql_total_no_of_V_out = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `branch_id`='$branch_id' and `checkout_date`!='0000-00-00'"));
     $sql_total_no_of_V_stay = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `branch_id`='$branch_id'and `checkin_date`='0000-00-00' and `check_status` = 'IN'"));
     $sql_total_no_of_check_in = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `branch_id`='$branch_id'and `checkin_date`= '$today' and `check_status` = 'IN'"));
 }


?>


<div class="col-xl-6 col-md-12">
<div class="row">
        <!-- sale card start -->

        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="total-u">
                <div class="card-block dsh-card">
                    <img src="assets/images/icons.png" alt="" srcset="">
                <i class="icofont icofont-swoosh-left"></i>
                <div class="card-text">
                    <h6 class="m-b-0 m-b-275">TODAY CHECK - IN <br> &nbsp;[ <?php echo date("d-M-y");?> ]</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_v_day;?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="total-A">
                <div class="card-block dsh-card">
                <img src="assets/images/icons.png" alt="" srcset=""><i class="icofont icofont-swoosh-right"></i>
                <div class="card-text ">
                <h6 class="m-b-0 m-b-275">TODAY CHECK - OUT <br> &nbsp;[ <?php echo date("d-M-y");?> ]</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_v_day_out?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="active">
                <div class="card-block dsh-card">
                <i class="fa fa-user-plus m-r-15 text-c-black"><i class="icofont icofont-calendar" style="font-size: 1.2rem;"></i></i>
                <div class="card-text">
                    <h6 class="m-b-0 m-b-275">MONTHLY CHECK - IN <br> &nbsp;[ <?php echo strtoupper(date("F"));?> ]</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_v_month?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="deactive">
                <div class="card-block dsh-card">
                <i class="fa fa-user-times m-r-15 text-c-black" style="margin:0;"><i class="icofont icofont-calendar" style="font-size: 1.2rem;"></i></i>
                <div class="card-text">
                <h6 class="m-b-0 m-b-275">MONTHLY CHECK - OUT <br> &nbsp;[ <?php echo strtoupper(date("F"));?> ]</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_v_month_out;?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        
        
        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="users">
                <div class="card-block dsh-card">
                <i class="fa fa-calendar-plus-o m-r-15 text-c-black"></i>
                <div class="card-text">
                    <h6 class="m-b-0 m-b-275">TOTAL CHECK - IN</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_V;?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="deactive1">
                <div class="card-block dsh-card">
                <i class="fa fa-calendar-minus-o m-r-15 text-c-black"></i>
                <div class="card-text">
                    <h6 class="m-b-0 m-b-275">TOTAL CHECK - OUT</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_V_out;?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        <!-- sale card end -->
    </div>
</div>
<div class="col-xl-6 col-md-12">
    <div class="row">
        <!-- sale card start -->

        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="users2">
                <div class="card-block dsh-card">
                <i class=" icofont icofont-users-alt-4 m-r-15 text-c-black " style="font-size:3rem;" ></i>
                <div class="card-text">
                <h6 class="m-b-0 m-b-275">TODAY STAYING <br> &nbsp;[ <?php echo date("d-M-y");?> ]</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_v_day_stay;?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        </div>
        <div class="row">
        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="users">
                <div class="card-block dsh-card">
                <i class="icofont icofont-users-alt-4 m-r-15 text-c-black " style="font-size:3rem;"><i class="icofont icofont-calendar" style="font-size: 1.2rem;"></i></i>
                <div class="card-text">
                <h6 class="m-b-0 m-b-275"> MONTHLY STAYING <br> &nbsp;<span >[ <?php echo strtoupper(date("F"));?> ]</span></h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_v_month_stay;?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        </div>
        <div class="row">
        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="users3">
                <div class="card-block dsh-card">
                <i class="fa fa-user m-r-15 text-c-black"></i>
                <div class="card-text">
                    <h6 class="m-b-0 m-b-275"> TOTAL STYAING</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_V_stay;?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
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