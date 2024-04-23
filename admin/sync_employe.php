<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Page Load sync_employe";
$rem="sync_employe";
$head  = "Biometric SetUp";
include '../include/_audi_log.php';


$numof_bio_emp = mysqli_num_rows(mysqli_query($conn_bio ,"select * from `employees`"));
$numof_cms_emp =mysqli_num_rows(mysqli_query($conn,"select * from `eomploye_details`"));
$p = $numof_bio_emp-$numof_cms_emp;


$sql_last_sysnc_data= mysqli_fetch_assoc(mysqli_query($conn,"select * from `sync_time_table` order by `sl_no` desc"));





if(isset($_POST['sync_upadate'])){
    // echo $_POST['id'];
    $numof_bio_emp = mysqli_num_rows(mysqli_query($conn_bio ,"select * from `employees`"));
    $numof_cms_emp =mysqli_num_rows(mysqli_query($conn,"select * from `eomploye_details`"));

    $last_cms_emp_id = 0;
    $last_bio_emp_id = 0;
    $last_emp_id_cms = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` order by `EmployeeId` desc"));
    $last_emp_id_bio = mysqli_fetch_assoc(mysqli_query($conn_bio ,"select * from `employees` order by `EmployeeId` desc"));

    if($last_emp_id_cms!=""){
        $last_cms_emp_id = $last_emp_id_cms['EmployeeId'];
    }
    if($last_emp_id_bio!=""){
        $last_bio_emp_id = $last_emp_id_bio['EmployeeId'];
    }
    if(($numof_cms_emp<$numof_bio_emp) && ($numof_cms_emp !=  $numof_bio_emp)){
        if( $last_cms_emp_id <$last_bio_emp_id){
            
            
            $p = $numof_bio_emp-$numof_cms_emp;
            $sql_insert_cms_emp="";
            for($i =($last_cms_emp_id+1); $i<= $last_bio_emp_id; $i++){
                
                $sql_bio_data = mysqli_fetch_assoc(mysqli_query($conn_bio,"select * from `employees` where `EmployeeId`='$i'"));
                if($sql_bio_data!=""){
                    $emp_name = $sql_bio_data['EmployeeName'];
                    $emp_code = $sql_bio_data['EmployeeCode'];
                    $emp_co = $sql_bio_data['CompanyId'];
                    $emp_dept = $sql_bio_data['DepartmentId'];
                $emp_desig = $sql_bio_data['Designation'];
                $emp_loc = $sql_bio_data['Location'];
                $emp_type=$sql_bio_data['EmployementType'];
                $emp_cat = $sql_bio_data['CategoryId'];
                $emp_con = $sql_bio_data['ContactNo'];
                $emp_sts = $sql_bio_data['Status'];
                
                $sql_insert_cms_emp = mysqli_query($conn,"insert into `eomploye_details`(`Emp_code`, `EmployeeName`, `CompanyId`, `DepartmentId`,`DesignationId`,`Location`, `EmployeType`, `CategoryId`, `ContactNo`, `Status`) values ('$emp_code','$emp_name','$emp_co','$emp_dept','$emp_desig','$emp_loc','$emp_type','$emp_cat','$emp_con','$emp_sts')");
                // echo $i;
                }else{
                    mysqli_query($conn,"insert into `eomploye_details`(`Emp_code`) values ('')");
                    mysqli_query($conn, "delete from `eomploye_details` where `Emp_code`=''");
                    $p+=1;
                    
                }
                
            }
            $numof_bio_emp = mysqli_num_rows(mysqli_query($conn_bio ,"select * from `employees`"));
            $numof_cms_emp =mysqli_num_rows(mysqli_query($conn,"select * from `eomploye_details`"));
            $p = $numof_bio_emp-$numof_cms_emp;
            
            if($sql_insert_cms_emp!=""){
                $user_id = $_SESSION['user_name'];
                $date = date("d-M-Y");
                $time = date("H:i:S");
                mysqli_query($conn,"insert into `sync_time_table`(`user_id`, `sync_date`, `sync_time`) values ('$user_id','$date','$time')");
                
                
                $_SESSION['icon'] = 'success';
                $_SESSION['status'] = 'Data Synced Successfully';
                $des="Click Update To Sync ";
                $rem="Sync Success";
                include '../include/_audi_log.php';
            }else{
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] = 'Data Synced UnSuccessfully';
                $des="Click Update To Sync ";
                $rem="Sync UnSuccess";
                include '../include/_audi_log.php';
            }
        
        }else{
            $_SESSION['icon'] = 'warning';
            $_SESSION['status'] = 'No Data To be Synced';
            $des="Click Update To Sync ";
            $rem="Sync unSuccess";
            include '../include/_audi_log.php';
        }
    }else{
        $_SESSION['icon'] = 'info';
        $_SESSION['status'] = 'Already Synced Data';
        $des="Click Update To Sync ";
        $rem="Already Synced Data";
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
                                        
                                    <div class="card" style="padding:1rem">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5 id="bio_sync"><?php if($p!=0){echo"Sync Employe Details :- <span style='color:red;font-family: emoji; font-size: 16px;  padding-left: 2rem'>".$p." No of Data You Have To Sync</span>";} ?></h5>
                                                <h5 id="bio_sync" style="font-size:1rem;    font-family: emoji;">Last Sync Details :-<?php  if($sql_last_sysnc_data!=""){ echo"<span style='color:red; font-size: 16px;  padding-left: 2rem'>".$sql_last_sysnc_data['sync_date'].'&nbsp; - &nbsp;'.$sql_last_sysnc_data['sync_time'];} ?></h5>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="user-entry">
                                                    <form action="sync_employe.php" method="post">
                                                        
                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;"  name="sync_upadate"><i class="fa fa-angle-double-up" style="    font-size: 20px;margin-right: 10px;"></i> Sync now</button>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                               
                                            </div>
                                    <div class="row">
                                            <div class="col-md-6">
                                            <div class="card text-center order-visitor-card" id="total-emp-emp" style="margin-bottom:8px">
                                                        <div class="card-block dsh-card signle-dash" >
                                                            <i class="fa fa-users m-r-15 text-c-black" style="font-size:8rem; margin-right:5rem"></i>
                                                            <div class="card-text">
                                                                <h6 class="m-b-0">Total Employe In Canteen </h6>
                                                                <h4 class="m-t-15 m-b-15"><?php echo $numof_cms_emp;?></h4>
                                                                <p class="m-b-0" style="font-weight: bold;    font-size: 15px;"> </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                          
                                            
                                            <div class="col-md-6">
                                              
                                                    <div class="card text-center order-visitor-card" id="total-subdept" style="margin-bottom:8px">
                                                        <div class="card-block dsh-card signle-dash" >
                                                            <i class="fa fa-ils m-r-15 text-c-black" style="font-size:8rem; margin-right:5rem"></i>
                                                            <div class="card-text">
                                                                <h6 class="m-b-0">Total Employe In Bimetric</h6>
                                                                <h4 class="m-t-15 m-b-15"><?php echo $numof_bio_emp;?></h4>
                                                                <p class="m-b-0" style="font-weight: bold;    font-size: 15px;"> </p>
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
