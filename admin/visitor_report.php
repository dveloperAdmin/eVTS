<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head="Visitor Details Report";
$des="Page Load visitor_report";
$rem="Visitor Report";
include '../include/_audi_log.php';
$month = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];

$short = array('Jan', 'Feb',  'Mar',  'Apr',  'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );
$sql_user_data = mysqli_query($conn,"select * from `user`");

$emp_code_id="";
$user_code_id= $_SESSION['user_id'];
include '../include/_emp_details.php';
$v_emp_code = $emp_code_user_id;
include '../include/_approval.php';
$approvat = $refer_status;



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
                                            <div class="col-md-6" style="max-width: 90%; flex: 1 0 56%;">
                                                <div class="card">
                                                    <div class="card-header"
                                                        style="padding-bottom:8px;padding-top:8px;">
                                                        <h5>Visitor Report</h5>
                                                    </div>
                                                    <div class="card-block table-border-style" style="padding-bottom:0px">
                                                        <form action="visitor_log_report_process" method="post">
                                                            <div class="form-group row" style="margin-bottom: .5em;    place-items: center;">
                                                                <label class="col-sm-3 col-form-label" style="flex: 0 0 12%;">Date Range</label>
                                                                <div class="col-sm-9" style="display:flex; max-width: 48%; height:auto;">
                                                                    
                                                                   <input type="date" class="form-control" name="fm_date" id="" style=""required>
                                                                   <input type="date" class="form-control" name="to_date" id="" style="margin-left: 0.5rem; "required>
                                                                    
                                                                        
                                                                </div>
                                                                <div class="user-entry">
                                                                    <button class="btn waves-effect waves-light btn-primary btn-outline-primary"  style="padding: 7px 20px; background-color:none;" name="besic_log_date_range"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Besic Report</button>
                                                                    <button class="btn waves-effect waves-light btn-success btn-outline-success"  style="padding: 7px 20px; background-color:none;" name="details_log_date_range"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Details Report</button>
                                                                    <button class="btn waves-effect waves-light btn-danger btn-outline-danger" style="padding: 7px 20px; background-color:none;" name="view_log_date_range"><i class="icofont icofont-eye" style="    font-size: 20px;margin-right: 10px;"></i>  View</button>
                                                                </div>
                                                            </div>
                                                        </form> 
                                                        <form action="visitor_log_report_process" method="post">
                                                            <div class="form-group row" style="margin-bottom: .5em;    place-items: center;">
                                                                <label class="col-sm-3 col-form-label" style="flex: 0 0 12%;">Employe Name &nbsp; & Date Range</label>
                                                                <div class="col-sm-9" style="display:flex; max-width: 48%; height:auto;">
                                                                    <input list="emps" type="text" class="form-control" style=" width:160%" placeholder="Enter Employe Name " name="Emp_code" oninput="this.value = this.value.toUpperCase()" required id="emp" >
                                                                    <datalist id="emps">
                                                                        <option value="All"></option>
                                                                            <?php 
                                                                                $sql_emp_data = mysqli_query($conn,"select * from `eomploye_details`");
                                                                                while($emp_data = mysqli_fetch_assoc($sql_emp_data)){                                                                           
                                                                            ?>
                                                                            <option value="<?php echo $emp_data['Emp_code'].' '.$emp_data['EmployeeName'];?>">
                                                                            <?php }?>
                                                                    </datalist>
                                                                   <input type="date" class="form-control" name="fm_date" id="" style="margin-left: 0.5rem; width: 27.6%;"required>
                                                                   <input type="date" class="form-control" name="to_date" id="" style="margin-left: 0.5rem; width: 27.6%;"required>
                                                                    
                                                                        
                                                                </div>
                                                                <div class="user-entry">
                                                                    <button class="btn waves-effect waves-light btn-primary btn-outline-primary"  style="padding: 7px 20px; background-color:none;" name="basic_log_by_emp_daterange"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Besic Report</button>
                                                                    <button class="btn waves-effect waves-light btn-success btn-outline-success"  style="padding: 7px 20px; background-color:none;" name="details_log_by_emp_daterange"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Details Report</button>
                                                                    <button class="btn waves-effect waves-light btn-danger btn-outline-danger" style="padding: 7px 20px; background-color:none;" name="view_log_by_emp_daterange"><i class="icofont icofont-eye" style="    font-size: 20px;margin-right: 10px;"></i>  View</button>
                                                                 
                                                                </div>
                                                            </div>
                                                        </form> 
                                                        <form action="visitor_log_report_process" method="post">
                                                            <div class="form-group row" style=" margin-bottom:.5em;   place-items: center;">
                                                                <label class="col-sm-3 col-form-label" style="flex: 0 0 12%;">Employe Name &nbsp; & Monthly</label>
                                                                <div class="col-sm-9" style="display:flex; max-width: 48%; height:auto;">
                                                                    <input list="emps" type="text" class="form-control" style=" width:160%" placeholder="Enter Employe Name " name="Emp_code" oninput="this.value = this.value.toUpperCase()" required id="emp" >
                                                                    <datalist id="emps">
                                                                            <?php 
                                                                                $sql_emp_data = mysqli_query($conn,"select * from `eomploye_details`");
                                                                                while($emp_data = mysqli_fetch_assoc($sql_emp_data)){                                                                           
                                                                            ?>
                                                                            <option value="<?php echo $emp_data['Emp_code'].' '.$emp_data['EmployeeName'];?>">
                                                                            <?php }?>
                                                                    </datalist>
                                                                    <select name="month_report" id="emp_month" class="form-control" style="margin-right:.5rem;margin-left: 0.5rem;">
                                                                        <option value=""disabled selected hidden>Select month</option>
                                                                        <?php for($i = 0; $i<count($month); $i++){?>
                                                                        <option value="<?php echo $short[$i];?>"><?php echo $month[$i];?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <select name="year_report" id="emp_year" class="form-control" style="">
                                                                        <option value=""disabled selected hidden>Select Year</option>
                                                                        <?php for($i = date("Y"); $i>=2020; $i--){?>
                                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                        
                                                                </div>
                                                                <div class="user-entry">
                                                                    <button class="btn waves-effect waves-light btn-primary btn-outline-primary"  style="padding: 7px 20px; background-color:none;" name="besic_log_by_emp_monthly"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Besic Report</button>
                                                                    <button class="btn waves-effect waves-light btn-success btn-outline-success"  style="padding: 7px 20px; background-color:none;" name="details_log_by_emp_monthly"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Details Report</button>
                                                                    <button class="btn waves-effect waves-light btn-danger btn-outline-danger" style="padding: 7px 20px; background-color:none;" name="view_log_by_emp_monthly"><i class="icofont icofont-eye" style="    font-size: 20px;margin-right: 10px;"></i>  View</button>
                                                                   
                                                                </div>
                                                            </div>
                                                        </form> 
                                                        <form action="visitor_log_report_process" method="post">
                                                            <div class="form-group row" style=" margin-bottom: .5em;   place-items: center;">
                                                                <label class="col-sm-3 col-form-label" style="flex: 0 0 12%;">Check Sts. & Date Range</label>
                                                                <div class="col-sm-9" style="display:flex; max-width: 48%; height:auto;">
                                                                    
                                                                <select name="check_sts" id="" class="form-control" style="margin-right: 0.5rem;">
                                                                    <option value="" disabled selected hidden>Select Status</option>
                                                                    <option value="IN">IN</option>
                                                                    <option value="OUT">OUT</option>
                                                                    
                                                                </select>
                                                                <input type="date" class="form-control" name="fm_date" id="" style=""required>
                                                                <input type="date" class="form-control" name="to_date" id="" style="margin-left: 0.5rem; "required>
                                                                        
                                                                </div>
                                                                <div class="user-entry">
                                                                    <button class="btn waves-effect waves-light btn-primary btn-outline-primary"  style="padding: 7px 20px; background-color:none;" name="besic_log_by_sts_daterange"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Besic Report</button>
                                                                    <button class="btn waves-effect waves-light btn-success btn-outline-success"  style="padding: 7px 20px; background-color:none;" name="details_log_by_sts_daterange"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Details Report</button>
                                                                    <button class="btn waves-effect waves-light btn-danger btn-outline-danger" style="padding: 7px 20px; background-color:none;" name="view_log_by_sts_daterange"><i class="icofont icofont-eye" style="    font-size: 20px;margin-right: 10px;"></i>  View</button>
                                                                 </div>
                                                            </div>
                                                        </form> 
                                                        <form action="visitor_log_report_process" method="post">
                                                            <div class="form-group row" style=" margin-bottom: .5em;   place-items: center;">
                                                                <label class="col-sm-3 col-form-label" style="flex: 0 0 12%;">Type & Purpose </label>
                                                                <div class="col-sm-9" style="display:flex; max-width: 48%; height:auto;">
                                                                    <select name="v_type" id="" class="form-control" style="" required>
                                                                        <option value="" disabled selected hidden>Select Visitor Type</option>
                                                                        <option value="ALL">ALL</option>
                                                                        <?php $sql_visit_type = mysqli_query($conn, "select * from `vsitor_type`");
                                                                            while($type_data = mysqli_fetch_assoc($sql_visit_type)){ ?>
                                                                        <option value="<?php echo $type_data['type_id'];?>"><?php echo $type_data['type_name'];?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                    <select name="v_purpose" id="" class="form-control" style="margin-left: 0.5rem;"required>
                                                                        <option value="" disabled selected hidden>Select Visit Purpose</option>
                                                                        <option value="ALL">ALL</option>
                                                                        <?php $sql_visit_purpus = mysqli_query($conn, "select * from `visit_purpose`");
                                                                            while($purpos_data = mysqli_fetch_assoc($sql_visit_purpus)){ ?>
                                                                        <option value="<?php echo $purpos_data['purpose_id'];?>"><?php echo $purpos_data['purpose'];?></option>
                                                                        <?php }?>
                                                                        
                                                                    </select>
                                                                        
                                                                </div>
                                                                <div class="user-entry">
                                                                    <button class="btn waves-effect waves-light btn-primary btn-outline-primary"  style="padding: 7px 20px; background-color:none;" name="baseic_log_by_visit_type_purpose"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Besic Report</button>
                                                                    <button class="btn waves-effect waves-light btn-success btn-outline-success"  style="padding: 7px 20px; background-color:none;" name="details_log_by_visit_type_purpose"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Details Report</button>
                                                                    <button class="btn waves-effect waves-light btn-danger btn-outline-danger" style="padding: 7px 20px; background-color:none;" name="view_log_by_visit_type_purpose"><i class="icofont icofont-eye" style="    font-size: 20px;margin-right: 10px;"></i>  View</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <?php if($approvat =='Active'){?>
                                                        <form action="visitor_log_report_process" method="post">
                                                            <div class="form-group row" style=" margin-bottom: .5em;   place-items: center;">
                                                                <label class="col-sm-3 col-form-label" style="flex: 0 0 12%;">Reffer By &nbsp; & Date Range</label>
                                                                <div class="col-sm-9" style="display:flex; max-width: 48%; height:auto;">
                                                                    <input list="emps" type="text" class="form-control" style=" width:160%" placeholder="Enter Employe Name " name="Emp_code" oninput="this.value = this.value.toUpperCase()" required id="emp" >
                                                                    <datalist id="emps">
                                                                        <option value="ALL"></option>
                                                                            <?php 
                                                                                $sql_emp_data = mysqli_query($conn,"select * from `eomploye_details`");
                                                                                while($emp_data = mysqli_fetch_assoc($sql_emp_data)){                                                                           
                                                                            ?>
                                                                            <option value="<?php echo $emp_data['Emp_code'].' '.$emp_data['EmployeeName'];?>">
                                                                            <?php }?>
                                                                    </datalist>
                                                                   <input type="date" class="form-control" name="fm_date" id="" style="margin-left: 0.5rem; width: 27.6%;"required>
                                                                   <input type="date" class="form-control" name="to_date" id="" style="margin-left: 0.5rem; width: 27.6%;"required>
                                                                    
                                                                        
                                                                </div>
                                                                <div class="user-entry">
                                                                    <!-- <button class="btn waves-effect waves-light btn-primary btn-outline-primary"  style="padding: 7px 20px; background-color:none;" name="besic_refer_by_log"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Besic Report</button> -->
                                                                    <button class="btn waves-effect waves-light btn-success btn-outline-success"  style="padding: 7px 20px; background-color:none;" name="details_log_report_refer_by"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Details Report</button>
                                                                    <button class="btn waves-effect waves-light btn-danger btn-outline-danger" style="padding: 7px 20px; background-color:none;" name="view_refer_by_log"><i class="icofont icofont-eye" style="    font-size: 20px;margin-right: 10px;"></i>  View</button>
                                                                </div>
                                                            </div>
                                                        </form> 
                                                        <form action="visitor_log_report_process" method="post">
                                                            <div class="form-group row" style="margin-bottom: .5em;    place-items: center;">
                                                                <label class="col-sm-3 col-form-label" style="flex: 0 0 12%;">Reffer To &nbsp; & Date Range</label>
                                                                <div class="col-sm-9" style="display:flex; max-width: 48%; height:auto;">
                                                                    <input list="emps" type="text" class="form-control" style=" width:160%" placeholder="Enter Employe Name " name="Emp_code" oninput="this.value = this.value.toUpperCase()" required id="emp" >
                                                                    <datalist id="emps">
                                                                            <?php 
                                                                                $sql_emp_data = mysqli_query($conn,"select * from `eomploye_details`");
                                                                                while($emp_data = mysqli_fetch_assoc($sql_emp_data)){                                                                           
                                                                            ?>
                                                                            <option value="<?php echo $emp_data['Emp_code'].' '.$emp_data['EmployeeName'];?>">
                                                                            <?php }?>
                                                                    </datalist>
                                                                   <input type="date" class="form-control" name="fm_date" id="" style="margin-left: 0.5rem; width: 27.6%;"required>
                                                                   <input type="date" class="form-control" name="to_date" id="" style="margin-left: 0.5rem; width: 27.6%;"required>
                                                                    
                                                                        
                                                                </div>
                                                                <div class="user-entry">
                                                                    <!-- <button class="btn waves-effect waves-light btn-primary btn-outline-primary"  style="padding: 7px 20px; background-color:none;" name="besic_refer_to_log"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Besic Report</button> -->
                                                                    <button class="btn waves-effect waves-light btn-success btn-outline-success"  style="padding: 7px 20px; background-color:none;" name="details_refer_to_log"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Details Report</button>
                                                                    <button class="btn waves-effect waves-light btn-danger btn-outline-danger" style="padding: 7px 20px; background-color:none;" name="view_refer_to_log"><i class="icofont icofont-eye" style="    font-size: 20px;margin-right: 10px;"></i>  View</button>
                                                                </div>
                                                            </div>
                                                        </form> 
                                                        <?php }?> 
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