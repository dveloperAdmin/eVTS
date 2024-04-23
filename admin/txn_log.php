<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Page Load txn_log";
$rem="transection log";
$head  = "Biometric SetUp";
include '../include/_audi_log.php';

$month_id = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];

// $short = array('Jan', 'Feb',  'Mar',  'Apr',  'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );





$month = date("m");//'07' ;
$year = date("Y");
$today = date("Y-m-d");
$count_day=0;
$count_no_month =0;
$error_mas = "";
$e = false;
if($month < 10){
    $m = substr($month , 1, null);
}else{

    $m = $month;
}
$table_name = "devicelogs_".$m."_".$year;
$sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
if($sql_check_table >0){
$e=true;
$sql_devicelog_data = mysqli_query($conn_bio,"select * from `$table_name`");

    while($log_data = mysqli_fetch_assoc($sql_devicelog_data)){
        $last_date = substr($log_data['LogDate'], 0, 10);
        if($today == $last_date){
            $count_day++;
        }
    
        $count_no_month ++;
    }
}else{
    $e=false;
    $error_mas="This month ".$table_name." not Exist";
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

                                        <?php if($e!=false){?>
                                        <div class="card" style="padding:1rem">
                                            <div class="col-md-6">
                                                <h5 id="bio_sync">TXN Log Details </h5>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card text-center order-visitor-card" id="total-subdept"
                                                    style="margin-bottom:8px">
                                                    <div class="card-block dsh-card signle-dash">
                                                        <i class="fa fa-calendar-check-o m-r-15 text-c-black"
                                                            style="font-size:8rem; margin-right:5rem"></i>
                                                        <div class="card-text">
                                                            <h6 class="m-b-0"> Today Total Transection </h6>
                                                            <h4 class="m-t-15 m-b-15"><?php echo $count_day;?></h4>
                                                            <p class="m-b-0"
                                                                style="font-weight: bold;    font-size: 15px;"> </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-6">

                                                <div class="card text-center order-visitor-card" id="total-emp-emp"
                                                    style="margin-bottom:8px">
                                                    <div class="card-block dsh-card signle-dash">
                                                        <i class="fa fa-calendar m-r-15 text-c-black"
                                                            style="font-size:8rem; margin-right:5rem"></i>
                                                        <div class="card-text">
                                                            <h6 class="m-b-0">This Month Total TRansection</h6>
                                                            <h4 class="m-t-15 m-b-15"><?php echo $count_no_month ;?>
                                                            </h4>
                                                            <p class="m-b-0"
                                                                style="font-weight: bold;    font-size: 15px;"> </p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <?php }else{?>
                                        <div class="card" style="padding:1rem">
                                            <div class="col-md-6">
                                                <h5 id="bio_sync"><?php echo $error_mas;?></h5>
                                            </div>

                                        </div>


                                        <?php   }?>
                                        <div class="card" style="padding-top: 1rem;">
                                            <form action="report_process.php" method="post">

                                                <div class="form-group row" style="display:-webkit-box; margin-left:.5rem;">
                                                    <label class="col-sm-3 col-form-label"
                                                        style="padding-right: 0;"> Txn - Log Report Month Wise</label>
                                                    <div class="col-sm-9" style="display:flex; max-width: 45%;"">
                                                                    <select name=" month_report" id="emp_month"
                                                        class="form-control" style="margin-right:.5rem;">
                                                        <option value="" disabled selected hidden>Select month</option>
                                                        <?php for($i=0; $i<count($month_id);$i++){?>
                                                        <option value="<?php echo ($i+1);?>" ><?php echo $month_id[$i];?> </option>
                                                        <?php }?>

                                                        </select>
                                                        <select name="year_report" id="emp_year" class="form-control"
                                                            style="margin-left:.5rem;">
                                                            <option value="" disabled selected hidden>Select Year </option>
                                                            <?php for($i = date("Y"); $i>=2020; $i--){?>
                                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                            <?php } ?>


                                                        </select>
                                                    </div>
                                                    <div class="user-entry">
                                                        <button
                                                            class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                            style="padding: 7px 20px;" name="mon_txr_xls"><i
                                                                class="icofont icofont-file-excel"
                                                                style="    font-size: 20px;margin-right: 10px;"></i>
                                                            Excel</button>
                                                        <button
                                                            class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                            style="padding: 7px 20px;" name="mon_txr_pdf"><i
                                                                class="icofont icofont-print"
                                                                style="    font-size: 20px;margin-right: 10px;"></i>
                                                            Print</button>
                                                    </div>
                                                </div>
                                            </form>
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