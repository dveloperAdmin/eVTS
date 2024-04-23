<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Page Load employe-bio";
$rem="employe-bio";
$head  = "Biometric SetUp";
include '../include/_audi_log.php';

$sql_total_no_of_emp=0;
$sql_total_no_of_bio_complete =0;
$sql_total_no_of_finger_print =0;
$sql_total_no_of_card =0;
$total_complete_bio =0;
$total_complete_bio_face =0;

$sql_total_no_of_emp= mysqli_num_rows(mysqli_query($conn_bio,"select distinct `EmployeeId` from `employees`"));
$sql_total_no_of_bio_complete = mysqli_num_rows(mysqli_query($conn_bio,"select distinct employees.EmployeeId, employeesbio.EmployeeId from `employees`, `employeesbio` where employees.EmployeeId = employeesbio.EmployeeId"));
$sql_total_no_of_finger_print = mysqli_num_rows(mysqli_query($conn_bio,"select distinct employees.EmployeeId, employeesbio.EmployeeId,employeesbio.BioType from `employees`, `employeesbio` where employees.EmployeeId = employeesbio.EmployeeId and employeesbio.BioType='Fingerprint' "));
$sql_total_no_of_card = mysqli_num_rows(mysqli_query($conn_bio,"select distinct `EmployeeId` from `employees` where `EmployeeRFIDNumber`!=''"));
// $total_complete_bio = $sql_total_no_of_bio_complete + $sql_total_no_of_card;
$total_complete_bio_face = mysqli_num_rows(mysqli_query($conn_bio,"select distinct employees.EmployeeId, employeesbio.EmployeeId,employeesbio.BioType from `employees`, `employeesbio` where employees.EmployeeId = employeesbio.EmployeeId and employeesbio.BioType='Face'"));


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
                                        <div class="row">
                                            <div class="col-xl-6 col-md-12">
                                                <div class="row">
                                                    <!-- sale card start -->

                                                    <div class="col-md-6">
                                                        <div class="card text-center order-visitor-card" id="total-A">
                                                            <div class="card-block dsh-card">
                                                                <i class="fa fa-users m-r-15 text-c-black"></i>
                                                                <div class="card-text">
                                                                    <h6 class="m-b-0">TOTAL Employe(ePush)</h6>
                                                                    <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_emp;?></h4>
                                                                    <p class="m-b-0"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card text-center order-visitor-card" id="total-u">
                                                            <div class="card-block dsh-card">
                                                                <i class="icofont icofont-dna-alt-2"></i>
                                                                <div class="card-text ">
                                                                    <h6 class="m-b-0"> Total Biometric Complete</h6>
                                                                    <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_bio_complete;?></h4>
                                                                    <p class="m-b-0"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <div class="card text-center order-visitor-card" id="users">
                                                            <div class="card-block dsh-card">
                                                                <i class="fa fa-500px m-r-15 text-c-black"></i>
                                                                <div class="card-text">
                                                                    <h6 class="m-b-0"> Total Finger Print</h6>
                                                                    <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_finger_print;?></h4>
                                                                    <p class="m-b-0"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card bg-c-red total-card" id="active">
                                                            <div class="card-block dsh-card">
                                                                <i class=" icofont icofont-ui-v-card"></i>
                                                                <div class="card-text">
                                                                    <h6 class="m-b-0">Total Card</h6>
                                                                    <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_card?></h4>
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
                                                        <div class="card text-center order-visitor-card" id="deactive">
                                                            <div class="card-block dsh-card">
                                                                <i class="fa fa-user-times m-r-15 text-c-black" style="margin-right:1rem;"></i>
                                                                <div class="card-text">
                                                                    <h6 class="m-b-0">Total Biometric Incomplete</h6>
                                                                    <h4 class="m-t-15 m-b-15"><?php echo ($sql_total_no_of_emp-$sql_total_no_of_bio_complete);?></h4>
                                                                    <p class="m-b-0"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                       
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card bg-c-red total-card" id="users">
                                                            <div class="card-block dsh-card">
                                                                <i class="fa fa-user-circle m-r-15 text-c-black"></i>
                                                                <div class="card-text">
                                                                    <h6 class="m-b-0">Total Face</h6>
                                                                    <h4 class="m-t-15 m-b-15"><?php echo $total_complete_bio_face?></h4>
                                                                    <p class="m-b-0"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                 
                                                    <!-- sale card end -->
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