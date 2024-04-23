<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Page Load log_report";
$rem="User Log Report";
$head= "User Log Report";
include '../include/_audi_log.php';
$month = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];

$short = array('Jan', 'Feb',  'Mar',  'Apr',  'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );
$sql_user_data = mysqli_query($conn,"select * from `user`");





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
                                  


                                            <div class="col-md-6" style="max-width: 65%; flex: 1 0 56%;">
                                                <div class="card">
                                                <div class="card-header"
                                                        style="padding-bottom:8px;padding-top:8px;">
                                                        <h5>User Log Report</h5>
                                                    </div>
                                                    <div class="card-block table-border-style">
                                                        <form action="report_process" method="post">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Select Employe</label>
                                                                <div class="col-sm-9" style="max-width: 45%;">
                                                                <select name="emp_id_report" id="emp" class="form-control">
                                                                    <option value="" disable selected hidden> Select Emplyee</option>
                                                                    <option value="1">All</option>
                                                                    <?php while($user = mysqli_fetch_assoc($sql_user_data)){?>
                                                                        <option value="<?php echo $user['uid'];?>"><?php echo $user['name'];?></option>
                                                                     <?php }?>   
                                                                </select>
                                                                   
                                                                </div>
                                                                <div class="user-entry">
                                                                <button
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    style="padding: 7px 20px; background-color:none;" name="emp_r_xls"><i
                                                                        class="icofont icofont-file-excel"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>
                                                                    Excel</button>
                                                                <button
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    style="padding: 7px 20px; background-color:none;" name="emp_r_pdf"><i
                                                                        class="icofont icofont-print"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>
                                                                    Print</button>
                                                            </div>
                                                            </div>
                                                        </form>
                                                        <form action="report_process" method="post">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Date Wise</label>
                                                                <div class="col-sm-9" style="max-width: 45%;">
                                                                    <input type="date" class="form-control" id="emp_date"
                                                                        placeholder="Enter Item Name" name="date_report"
                                                                        >
                                                                </div>
                                                                <div class="user-entry">
                                                                <button
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    style="padding: 7px 20px;" name="date_r_xls"><i
                                                                        class="icofont icofont-file-excel"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>
                                                                    Excel</button>
                                                                <button
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    style="padding: 7px 20px;" name="date_r_pdf"><i
                                                                        class="icofont icofont-print"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>
                                                                    Print</button>
                                                            </div>
                                                            </div>
                                                        </form>
                                                        <form action="report_process" method="post">
                                                                
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Month Wise</label>
                                                                <div class="col-sm-9" style="display:flex; max-width: 45%;"">
                                                                <select name="month_report" id="emp_month" class="form-control" style="margin-right:.5rem;">
                                                                    <option value="" disabled selected hidden>Select month</option>
                                                                        <?php for($i = 0; $i<count($month); $i++){?>
                                                                        <option value="<?php echo $short[$i];?>"><?php echo $month[$i];?></option>
                                                                        <?php } ?>
                                                                </select>
                                                                <select name="year_report" id="emp_year" class="form-control" style="margin-left:.5rem;">
                                                                    <option value=""disabled selected hidden>Select Year</option>
                                                                    <?php for($i = date("Y"); $i>=2020; $i--){?>
                                                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                            <?php } ?>
                                                                </select>
                                                                
                                                                
                                                                    

                                                                    

                                                                </div>
                                                                <div class="user-entry">
                                                                <button
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    style="padding: 7px 20px;" name="mon_r_xls"><i
                                                                        class="icofont icofont-file-excel"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>
                                                                    Excel</button>
                                                                <button
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    style="padding: 7px 20px;" name="mon_r_pdf"><i
                                                                        class="icofont icofont-print"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>
                                                                    Print</button>
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
<script>
    $("#emp").change(function(){
       $("#emp_date").val('');
       $("#emp_month").val('');
       $("#emp_year").val('');
    })
    $("#emp_date").change(function(){
       $("#emp").val('');
       $("#emp_month").val('');
       $("#emp_year").val('');
    })
    $("#emp_month , #emp_year").change(function(){
       $("#emp").val('');
       $("#emp_date").val('');
       
    })

</script>