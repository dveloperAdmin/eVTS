<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head="Developer option";
$des="Page Load dev.php";
$rem="apdeveloper option";
include '../include/_audi_log.php';

// $any_variable="canteen_report_calculation_datewise";
if(isset($_POST['set_process_type'])){
    // $type_calculation = $_POST['process_type'];
    $content = file_get_contents('include/manu.php'); 

    $new_content = preg_replace('/\$process_link=\"(.*?)\";/', '$process_link="'.$type_calculation.'";', $content);
    
    file_put_contents('include/manu.php', $new_content);
}


// $sql_1 = mysqli_query($conn_bio,"SELECT `devicelogs_2_2023`.*, `eomploye_details`.* FROM biometric.`devicelogs_2_2023` LEFT join cms.`eomploye_details` on biometric.`devicelogs_2_2023`.`UserId` = cms.`eomploye_details`.`Emp_code`;");
// echo mysqli_num_rows($sql_1);

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
                                        <div class="card-header"
                                            style="padding-bottom:8px;padding-top:8px;margin-bottom:.5rem;">
                                            <div class="form-group " style="margin:0; display:flex;">
                                                <h5 style="width:56%"><label class="col-sm-3 col-form-label"
                                                        style="padding-right: 0;max-width: 52%;font-size: 1.2rem;">
                                                        Log out date time setup
                                                    </label>
                                                </h5>
                                                
                                            </div>
                                        </div>
                                    
                                            
                                    <div class="row" style="place-content: center;">
                                        <div class="col-md-6" style="max-width: 70%; flex: 1 0 75%;">
                                            <div class="card" id="today_r" style="margin-bottom:.5rem">
                                                <div class="card-block table-border-style">
                                                    <form action="" method="post">
                                                        <div class="form-group row" style="place-items: center;">
                                                            <label class="col-sm-3 col-form-label" style="padding-right: 0; max-width:20rem;">Type of Log Out Timing Status</label>
                                                            <div class="col-sm-9" style="max-width: 45%; display:flex;">
                                                                <select name="process_type" id="" class="form-control">
                                                                    <option value="" selected disable hidden>Select Type of Canteen Report Process</option>
                                                                    <option value="canteen_report_calculation_datewise">Active</option>
                                                                    <option value="canteen_report_calculation_monthly">Deactive</option>
                                                                </select>
                                                            </div>
                                                            <div class="user-entry">
                                                                
                                                                <button class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px; background-color:none;"name="set_process_type">
                                                                    <i class="fa fa-cog"style="    font-size: 20px;margin-right: 10px;"></i>
                                                                    SET
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
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
