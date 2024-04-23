<?php 
include "../include/_session.php";
include "../include/_dbconnect.php";
$des="Page Load my_details";
$rem="my_ddetails";
$head = "My Details";
include "../include/_audi_log.php";

$CompanyId ="";
$DepartmentId ="";
$BranchId ="";
$Sub_DepartmentId ="";
$DesignationId ="";
$GradeId ="";
$Location ="";
$EmployeType ="";
$CategoryId ="";
$ContactNo ="";
$Status ="";
$emp_code ="";

$co_name = "";
$dept_name = "";
$desig_name = "";
$barnch_name = "";
$subdept_name="";

$log_id = $_SESSION['user_id'];
$sql_user_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `user` where `uid`='$log_id'"));
$emp_id = $sql_user_details['EmployeeId'];
$sql_emp_details= mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where`EmployeeId`='$emp_id'"));
if($sql_emp_details!=""){
    $emp_code=$sql_emp_details['Emp_code'];
    $CompanyId = $sql_emp_details['CompanyId'];
    $DepartmentId = $sql_emp_details['DepartmentId'];
    $BranchId = $sql_emp_details['BranchId'];
    $Sub_DepartmentId = $sql_emp_details['Sub_DepartmentId'];
    $DesignationId = $sql_emp_details['DesignationId'];
    $GradeId = $sql_emp_details['GradeId'];
    $Location = $sql_emp_details['Location'];
    $EmployeType = $sql_emp_details['EmployeType'];
    $CategoryId = $sql_emp_details['CategoryId'];
    $ContactNo = $sql_emp_details['ContactNo'];
    $Status = $sql_emp_details['Status'];
}
$sql_co_data = mysqli_fetch_assoc(mysqli_query($conn,"select * from `company_details` where `company_id`= '$CompanyId'"));
if($sql_co_data!=""){
    $co_name =$sql_co_data['companyFname']; 
}
$sql_dept_data = mysqli_fetch_assoc(mysqli_query($conn,"select * from `department` where `department_code`= '$DepartmentId'"));
if($sql_dept_data!=""){
    $dept_name =$sql_dept_data['department_name']; 
}
$sql_desig_data = mysqli_fetch_assoc(mysqli_query($conn,"select * from `designation` where `designation_code`= '$DesignationId'"));
if($sql_desig_data!=""){
    $desig_name =$sql_desig_data['designation']; 
}
$sql_branch_data = mysqli_fetch_assoc(mysqli_query($conn,"select * from `branch` where `branch_code`= '$BranchId'"));
if($sql_branch_data!=""){
    $barnch_name =$sql_branch_data['branch_name']; 
}
$sql_subdept_data = mysqli_fetch_assoc(mysqli_query($conn,"select * from `subdepartment` where `subdepartment_code`= '$Sub_DepartmentId'"));
if($sql_subdept_data!=""){
    $subdept_name =$sql_subdept_data['subdepartment_name']; 
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
                                    <!-- Page-body start -->
                                    <div class="page-body">
                                        <div class="row">
                                            <div class="col-md-6" style="flex: 0 0 40%;">
                                                <div class="card" style="margin-bottom: 8px;">
                                            <div class="card-header"  style="padding-bottom:8px;padding-top:8px;">
                                                        <h5>My Details :- <?php echo $sql_user_details['user_name']; ?></h5>
                                                    </div>
                                                <div class="card-block table-border-style">
                                                    <div class="table-responsive" style="height:auto">
                                                        <table class="table" style="color:black; font-weight:600;"border="0">
                                                            
                                                            <tbody>
                                                                <tr style="">
                                                                
                                                                    <td style="padding:.35rem;  border:none;text-align:left;width:7.8rem; border-bottom:1px solid #dee2e6;">Employee Code </td>
                                                                    <td style="border:none;border-bottom:1px solid #dee2e6;width:10%;padding:0;">:-</td>
                                                                    <td style="color:green;padding:.25rem; text-align:left; border:none; border-bottom:1px solid #dee2e6;"><?php echo  $emp_code; ?></td>
                                                                    
                                                                </tr>
                                                                
                                                                <tr style="">
                                                                    
                                                                    <td style="padding:.35rem;  border:none;text-align:left;width:7.8rem; border-bottom:1px solid #dee2e6;">Employee Name </td>
                                                                    <td style="border:none;border-bottom:1px solid #dee2e6;width:10%;padding:0;">:-</td>
                                                                    <td style="color:green;padding:.25rem; text-align:left; border:none; border-bottom:1px solid #dee2e6;"><?php echo $sql_user_details['name'] ;?></td>
                                                                    
                                                                </tr>
                                                                <tr style="">
                                                                    
                                                                    <td style="padding:.35rem;  border:none;text-align:left;width:7.8rem; border-bottom:1px solid #dee2e6;">Contact no </td>
                                                                    <td style="border:none;border-bottom:1px solid #dee2e6;width:10%;padding:0;">:-</td>
                                                                    <td style="color:green;padding:.25rem; text-align:left; border:none; border-bottom:1px solid #dee2e6;"><?php echo $ContactNo;?></td>
                                                                    
                                                                </tr>
                                                                <tr style="">
                                                                    
                                                                    <td style="padding:.35rem;  border:none;text-align:left;width:7.8rem; border-bottom:1px solid #dee2e6;">Company Name </td>
                                                                    <td style="border:none;border-bottom:1px solid #dee2e6;width:10%;padding:0;">:-</td>
                                                                    <td style="color:green;padding:.25rem; text-align:left; border:none; border-bottom:1px solid #dee2e6;"><?php echo $co_name;?></td>
                                                                    
                                                                </tr>
                                                                <tr style="">
                                                                    
                                                                    <td style="padding:.35rem;  border:none;text-align:left;width:7.8rem; border-bottom:1px solid #dee2e6;">Department </td>
                                                                    <td style="border:none;border-bottom:1px solid #dee2e6;width:10%;padding:0;">:-</td>
                                                                    <td style="color:green;padding:.25rem; text-align:left; border:none; border-bottom:1px solid #dee2e6;"><?php echo $dept_name ;?></td>
                                                                    
                                                                </tr>
                                                                <tr style="">
                                                                    
                                                                    <td style="padding:.35rem;  border:none;text-align:left;width:7.8rem; border-bottom:1px solid #dee2e6;">Sub Department </td>
                                                                    <td style="border:none;border-bottom:1px solid #dee2e6;width:10%;padding:0;">:-</td>
                                                                    <td style="color:green;padding:.25rem; text-align:left; border:none; border-bottom:1px solid #dee2e6;"><?php echo $subdept_name ;?></td>
                                                                    
                                                                </tr>
                                                                <tr style="">
                                                                    
                                                                    <td style="padding:.35rem;  border:none;text-align:left;width:7.8rem; border-bottom:1px solid #dee2e6;">Branch </td>
                                                                    <td style="border:none;border-bottom:1px solid #dee2e6;width:10%;padding:0;">:-</td>
                                                                    <td style="color:green;padding:.25rem; text-align:left; border:none; border-bottom:1px solid #dee2e6;"><?php echo $barnch_name ;?></td>
                                                                    
                                                                </tr>
                                                                <tr style="">
                                                                    
                                                                    <td style="padding:.35rem;  border:none;text-align:left;width:7.8rem; border-bottom:1px solid #dee2e6;">Designation </td>
                                                                    <td style="border:none;border-bottom:1px solid #dee2e6;width:10%;padding:0;">:-</td>
                                                                    <td style="color:green;padding:.25rem; text-align:left; border:none; border-bottom:1px solid #dee2e6;"><?php echo $desig_name ;?></td>
                                                                    
                                                                </tr>
                                                                <tr style="">
                                                                    
                                                                    <td style="padding:.35rem;  border:none;text-align:left;width:7.8rem; border-bottom:1px solid #dee2e6;">Employe Type </td>
                                                                    <td style="border:none;border-bottom:1px solid #dee2e6;width:10%;padding:0;">:-</td>
                                                                    <td style="color:green;padding:.25rem; text-align:left; border:none; border-bottom:1px solid #dee2e6;"><?php echo $EmployeType ;?></td>
                                                                    
                                                                </tr>
                                                                <tr style="">
                                                                    
                                                                    <td style="padding:.35rem; border:none;text-align:left;width:7.8rem; border-bottom:1px solid #dee2e6;">Employee Status </td>
                                                                    <td style="border:none;border-bottom:1px solid #dee2e6;width:10%;padding:0;">:-</td>
                                                                    <td style="color:green;padding:.55rem; text-align:left; border:none; border-bottom:1px solid #dee2e6;"><?php echo $Status ;?></td>
                                                                    
                                                                </tr>
                                                            </tbody>
                                                        </table>
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
