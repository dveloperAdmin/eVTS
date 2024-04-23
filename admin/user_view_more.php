<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Page Load user more view";
$rem="user more view";
$head  = "User Info";
include '../include/_audi_log.php';

 
$name="";
$mobile_no="";
$role="";
$status="";
if(isset($_POST['view'])){
    $uid= $_POST['view_id'];
    $sql_user_detail = mysqli_fetch_assoc(mysqli_query($conn,"select * from `user` where `uid` ='$uid'"));
    if($sql_user_detail!=""){
        $emp_id = $sql_user_detail['EmployeeId'];
        $sql_emp_data = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where `EmployeeId`='$emp_id'"));
        $name = $sql_user_detail['name'];
        if($sql_emp_data!=""){
            $mobile_no = $sql_emp_data['ContactNo'];

        }
        $role = $sql_user_detail['user_role'];
        $status = $sql_user_detail['user_sts'];

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
                                            <div class="col-md-6">
                                               
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 style="width:25.8rem">View User Details :- <?php echo $sql_user_detail['user_name'];?></h5>
                                                        <a href="user_view.php">
                                                                <button  class="btn waves-effect waves-light btn-primary btn-outline-primary " ><i class="fa fa-arrow-right"  style="    font-size: 20px;margin-right: 10px;"></i>Back To List</button>
                                                            </a>
                                                    </div>
                                                    <div class="card-block">
                                                        
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">User Name</label>
                                                                <div class="col-sm-9">
                                                                    <label for="" class="form-control"><?php echo $name;?></label>
                                                                   
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Mobile NO</label>
                                                                <div class="col-sm-9">
                                                                    <label for="" class="form-control"><?php echo $mobile_no;?></label>
                                                                   
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">User Role</label>
                                                                <div class="col-sm-9">
                                                                    <label for="" class="form-control"><?php echo $role;?></label>
                                                                   
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">User
                                                                    Status</label>
                                                                    <div class="col-sm-9">
                                                                    <label for="" class="form-control"><?php echo $status;?></label>
                                                                   
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
// Swal.fire({
//   icon: 'success',
//   title: 'ok',
//   showCloseButton: true,
//   confirmButton: true,
// })
</script>