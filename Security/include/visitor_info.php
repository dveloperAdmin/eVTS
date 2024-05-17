<?php
$first_date = date("Y-m-01");
$last_date = date("Y-m-t");
$today = date("Y-m-d");
$sql_total_no_of_v_day = mysqli_num_rows(mysqli_query($conn, "select * from `visitor_log` where `checkin_date`= '$today' and `check_status` != 'Pending' and branch_id = '$branch_id'"));
$sql_total_no_of_v_month = mysqli_num_rows(mysqli_query($conn, "select * from `visitor_log` where `check_status` != 'Pending' and `checkin_date` between '$first_date' and '$last_date' and branch_id = '$branch_id'"));
$sql_total_no_of_check_in = mysqli_num_rows(mysqli_query($conn, "select * from `visitor_log` where branch_id = '$branch_id'"));


?>


<div class="col-xl-6 col-md-12">
  <div class="row">
    <!-- sale card start -->

    <div class="col-md-6">
      <div class="card text-center order-visitor-card" id="active">
        <div class="card-block dsh-card">
          <i class="fa fa-users m-r-15 text-c-black"></i>
          <div class="card-text">
            <h6 class="m-b-0 m-b-275">TODAY ( <?php echo date("l"); ?> ) </h6>
            <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_v_day; ?></h4>
            <p class="m-b-0"></p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card text-center order-visitor-card" id="total-B">
        <div class="card-block dsh-card">
          <i class="fa fa-calendar m-r-15 text-c-black"></i>
          <div class="card-text ">
            <h6 class="m-b-0 m-b-275">THIS MONTH ( <?php echo date("F"); ?> )</h6>
            <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_v_month ?></h4>
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
                    <h4 class="m-t-15 m-b-15"><?php //echo $total_active ?></h4>
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
                    <h4 class="m-t-15 m-b-15"><?php //echo $total_deactive; ?></h4>
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
            <h6 class="m-b-0 m-b-275"> TOTAL VISITORS</h6>
            <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_check_in; ?></h4>
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