<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head="Export Employee Info";
$des="Page Load export_emp";
$rem="Export Info";
include '../include/_audi_log.php';
$month = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];

$short = array('Jan', 'Feb',  'Mar',  'Apr',  'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );
$sql_user_data = mysqli_query($conn,"select * from `user`");

$sql_company = mysqli_query($conn,"select * from `company_details`");
$sql_dept = mysqli_query($conn,"select * from `department`");
$sql_branch = mysqli_query($conn,"select * from `branch`");

                                                            

                                                        



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
                                  


                                            <div class="col-md-6" style="max-width: 80%; flex: 1 0 56%;">
                                                <div class="card">
                                                <div class="card-header"
                                                        style="padding-bottom:8px;padding-top:8px;margin-bottom:1rem;">
                                                        <h5>Export Employee Details</h5>
                                                    </div>
                                                    <div class="card-block table-border-style">
                                                        <form action="export_emp_process" method="post">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;max-width:7.7rem;">Mobile No Wise</label>
                                                                <div class="col-sm-9" style="max-width: 61%;">
                                                                <input type="text" class="form-control" id="mob" placeholder="Enter Mobile NO" name="mob_report" style="max-width:66%;   " maxlength="10">
                                                                        
                                                                </div>
                                                                <div class="user-entry">
                                                                <button
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    style="padding: 7px 20px; background-color:none;" name="emp_mob_xls"><i
                                                                        class="icofont icofont-file-excel"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>
                                                                    Excel</button>
                                                                <button
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    style="padding: 7px 20px; background-color:none;" name="emp_mob_pdf"><i
                                                                        class="icofont icofont-print"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>
                                                                    Print</button>
                                                            </div>
                                                            </div>
                                                        </form>
                                                        <form action="export_emp_process" method="post">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;max-width:7.7rem;">Employee Name</label>
                                                                <div class="col-sm-9" style="max-width: 61%;">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Enter Employee Name" name="emp_nam"
                                                                        id="emp_name" style="max-width: 66%;">
                                                                </div>
                                                                <div class="user-entry">
                                                                <button
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    style="padding: 7px 20px;" name="emp_name_xls"><i
                                                                        class="icofont icofont-file-excel"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>
                                                                    Excel</button>
                                                                <button
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    style="padding: 7px 20px;" name="emp_name_pdf"><i
                                                                        class="icofont icofont-print"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>
                                                                    Print</button>
                                                            </div>
                                                            </div>
                                                        </form>
                                                   
                                                    <form action="export_emp_process" method="post">
                                                            
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label"
                                                                style="padding-right: 0;max-width:7.7rem;">Company Wise</label>
                                                            <div class="col-sm-9" style="display:flex; max-width: 61%;"">
                                                            <select name="com_id" id="com" class="form-control" style="margin-right:.5rem;max-height: 93%;">
                                                                <option value="" disabled selected hidden>Select Company</option>
                                                                <option value="1" >All</option>
                                                                <?php while($co_details= mysqli_fetch_assoc($sql_company)){?>
                                                                    <option value="<?php echo $co_details['company_id'];?>"><?php echo $co_details['companyFname'];?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <select name="branch_id" id="bran" class="form-control" style="margin-right:.5rem;max-height: 93%;">
                                                                <option value="" disabled selected hidden>Select Branch</option>
                                                                <?php if(in_array($user_role, array("Developer", "Super Admin"))){?>
                                                                <option value="1" >All</option>
                                                                <?php while($branch_details= mysqli_fetch_assoc($sql_branch)){?>
                                                                    <option value="<?php echo $branch_details['branch_code'];?>"><?php echo $branch_details['branch_name'];?></option>
                                                                <?php } }else{
                                                                    $sql_branch_s = mysqli_fetch_assoc(mysqli_query($conn,"select * from `branch` where `branch_code`= '$branch_id'"));
                                                                    ?>
                                                                       <option value="<?php echo $sql_branch_s['branch_code'];?>"><?php echo $sql_branch_s['branch_name'];?></option> 
                                                                    <?php }?>
                                                            </select>
                                                            <select name="dept_id" id="dept" class="form-control" style="margin-left:.5rem;max-height: 93%;">
                                                                <option value="" disabled selected hidden>Select Department</option>
                                                                <option value="1" >All</option>
                                                                <?php while($dept_details= mysqli_fetch_assoc($sql_dept)){?>
                                                                    <option value="<?php echo $dept_details['department_code'];?>"><?php echo $dept_details['department_name'];?></option>
                                                                <?php } ?>
                                                            </select>
                                                            
                                                            </div>
                                                            <div class="user-entry">
                                                            <button
                                                                class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                style="padding: 7px 20px;" name="com_emp_xls"><i
                                                                    class="icofont icofont-file-excel"
                                                                    style="    font-size: 20px;margin-right: 10px;"></i>
                                                                Excel</button>
                                                            <button
                                                                class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                style="padding: 7px 20px;" name="com_emp_pdf"><i
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
    $("#mob").keyup(function(){
       $("#emp_name").val('');
       $("#com").val('');
       $("#dept").val('');
       $("#bran").val('');
    })
    $("#emp_name").keyup(function(){
       $("#mob").val('');
       $("#com").val('');
       $("#dept").val('');
       $("#bran").val('');
    })
    $("#com , #dept, #bran").change(function(){
       $("#mob").val('');
       $("#emp_name").val('');
       
    })

</script>