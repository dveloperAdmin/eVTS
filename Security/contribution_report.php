<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
$head = "Contribution Report";
$des="Page Load Contribution-report";
$rem="Contribution Report";
include '../include/_audi_log.php';
$month = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
$short = ['Jan', 'Feb',  'Mar',  'Apr',  'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

$today = date("l");

$sql_emp_data = mysqli_query($conn,"select * from `eomploye_details`");
$sql_co_data = mysqli_query($conn,"select * from `company_details`");
$sql_itm_data = mysqli_query($conn,"select distinct `Item_name`, `itm_code` from `canteen_item`"); 
$sql_itm_data2 = mysqli_query($conn,"select distinct `Item_name`, `itm_code` from `canteen_item`"); 
$sql_itm_data3 = mysqli_query($conn,"select distinct `Item_name`, `itm_code` from `canteen_item`"); 
$sql_itm_data4 = mysqli_query($conn,"select distinct `Item_name`, `itm_code` from `canteen_item`"); 

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
                                            <!-- <form action="#" method="post">

                                                <div class="card-header"
                                                    style="padding-bottom:8px;padding-top:8px;margin-bottom:.5rem;">
                                                    <div class="form-group " style="margin:0; display:flex; ">
                                                        <h5 style="width:56%"><label class="col-sm-3 col-form-label"
                                                                style="padding-right: 0;max-width: 52%;">
                                                                <input type="radio" id="td_d" name="fav_language"
                                                                    value="1">
                                                                Today (<?php echo date("d-M-Y");?>)
                                                            </label>
                                                        </h5>
                                                        <h5 style="width:50%">
                                                            <label class="col-sm-3 col-form-label td"
                                                                style="padding-right: 0;max-width: 47%;">
                                                                <input type="radio" id="td_t" name="fav_language"
                                                                    value="2">
                                                                Date Range
                                                            </label>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </form> -->

                                            <div class="row" style="place-content: center;">
                                                <!-- <div class="col-md-6" style="max-width: 70%; flex: 1 0 75%;">
                                                    <div class="card" id="today_r" style="margin-bottom:.5rem;display:none;">
                                                        <div class="card-block table-border-style">
                                                            <form action="contribution_report_process" method="post">
                                                                <div class="form-group row" style="place-items:center;">
                                                                    <label class="col-sm-3 col-form-label" style="padding-right: 0;">Employe Wise Report</label>
                                                                    <div class="col-sm-9" style="max-width: 48%;">
                                                                        <input list="emp_list" type="text" class="form-control" id="emp_date" placeholder="Enter Employee Name" name="emp_w_input" required>
                                                                        <datalist id="emp_list">
                                                                            <option value="0 All">
                                                                        <!-- <option value="All">All</option> 
                                                                        <?php while($emp_data = mysqli_fetch_assoc($sql_emp_data)){ ?>
                                                                            <option value="<?php echo $emp_data['EmployeeId'].' '. $emp_data['EmployeeName'];?>"></option>
                                                                            <?php }?>
                                                                        </datalist>
                                                                    </div>
                                                                    <div class="user-entry">
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px; background-color:none;" name="can_emp_r_xls"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i>Excel</button>
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px; background-color:none;" name="can_emp_r_pdf"><i class="icofont icofont-print" style="font-size: 20px;margin-right: 10px;"></i>Print</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <form action="contribution_report_process" method="post">
                                                                <div class="form-group row"  style="place-items:center;">
                                                                    <label class="col-sm-3 col-form-label" style="padding-right: 0;">Item Wise Report</label>
                                                                        <div class="col-sm-9" style="max-width:48%;">
                                                                        <select name="item_w_input" id="emp"  class="form-control" required>
                                                                            <option value="" disable selected hidden> Select Item</option>
                                                                            <?php while($item_data=mysqli_fetch_assoc($sql_itm_data)){?>
                                                                            <option value="<?php echo  $item_data['itm_code'];?>"><?php echo $item_data['Item_name'];?></option>
                                                                            <?php } ?>
                                                                        </select>

                                                                    </div>
                                                                    <div class="user-entry">
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;" name="items_r_xls"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i>Excel</button>
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;" name="items_r_pdf"><i class="icofont icofont-print" style="    font-size: 20px;margin-right: 10px;"></i>Print</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <!-- <form action="canteen-report-process" method="post">
                                                                <div class="form-group row"  style="place-items:center;">
                                                                    <label class="col-sm-3 col-form-label" style="padding-right: 0;">Company Wise Report</label>
                                                                        <div class="col-sm-9" style="max-width:48%; display:flex;">
                                                                            
                                                                            <select name="co_input" id="emp"  class="form-control" style="" required>
                                                                                <option value="" disable selected hidden> Select Company</option>
                                                                                <?php while($co_data=mysqli_fetch_assoc($sql_co_data)){?>
                                                                                <option value="<?php echo  $co_data['company_id'];?>"><?php echo $co_data['companyFname'];?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                            <select name="item_input" id="emp"  class="form-control" style="margin-left:1rem;" required>
                                                                                <option value="" disable selected hidden> Select Item</option>
                                                                                <?php while($item_data=mysqli_fetch_assoc($sql_itm_data2)){?>
                                                                                <option value="<?php echo  $item_data['itm_code'];?>"><?php echo $item_data['Item_name'];?></option>
                                                                                <?php } ?>
                                                                            </select>

                                                                        </div>
                                                                        <div class="user-entry">
                                                                            <button class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px;" name="co_item_r_xls"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Excel</button>
                                                                            <button class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px;"name="co_item_r_pdf"><i class="icofont icofont-print" style="    font-size: 20px;margin-right: 10px;"></i>Print</button>
                                                                        </div>
                                                                </div>
                                                            </form> 
                                                        </div>
                                                    </div>
                                                    </div>
                                                     -->
                                                    <div class="col-md-6" style="max-width: 80%; flex: 1 0 85%;">
                                                    <div class="card" id="date_r" style="margin-bottom:.5rem;">
                                                        <div class="card-block table-border-style">

                                                            
                                                            <!-- <form action="contribution_report_process" method="post">
                                                                <div class="form-group row" style="place-items: center;">
                                                                    <label class="col-sm-3 col-form-label" style="padding-right: 0; max-width:8rem;">Employee & Date-Range </label>
                                                                    <div class="col-sm-9" style="display:flex; max-width: 64%;">
                                                                        <input list="emp_list" type="text" class="form-control" id="emp_date" placeholder="Enter Employee Name" name="emp_w_input" style=" margin-right: 0.8rem;" required>
                                                                        <input type="date" class="form-control" id="emp_date" placeholder="Enter Item Name" name="date_f_input" style="max-width:11rem;    margin-right: 0.8rem; " required>
                                                                        <input type="date" class="form-control" id="emp_date" placeholder="Enter Item Name" name="date_t_input" style="max-width:11rem;   " required>
                                                                        
                                                                                
                                                                    </div>
                                                                    <div class="user-entry">
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px; background-color:none;"   name="emp_D_r_xls"><i class="icofont icofont-file-excel"  style="    font-size: 20px;margin-right: 10px;"></i> Excel</button>
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px; background-color:none;"  name="emp_D_r_pdf"><i  class="icofont icofont-print" style="    font-size: 20px;margin-right: 10px;"></i>Print</button>
                                                                    </div>
                                                                </div>
                                                            </form>


                                                            <form action="contribution_report_process" method="post">
                                                                <div class="form-group row" style="place-items: center;">
                                                                    <label class="col-sm-3 col-form-label" style="padding-right: 0; max-width:8rem;">Employee & Month </label>
                                                                    <div class="col-sm-9" style="display:flex; max-width: 64%;">
                                                                    <input list="emp_list" type="text" class="form-control" id="emp_date" placeholder="Enter Employee Name" name="emp_w_input" style=" margin-right: 0.8rem;" required>
                                                                        <select name="month_report" id="emp_month" class="form-control" style="max-width:11rem;    margin-right: 0.8rem;"   required>
                                                                            <option value="" disabled selected hidden>Select month</option>
                                                                            <?php for($i = 0; $i<count($month); $i++){?>
                                                                            <option value="<?php echo ($i+1);?>"><?php echo $month[$i];?></option>
                                                                                <?php echo $month[$i];?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <select name="year_report" id="emp_month" class="form-control"  style="max-width:11rem;    "  required>
                                                                            <option value="" disabled selected hidden>Select Year</option>
                                                                            <?php for($i = 2022; $i>=2018; $i--){?>
                                                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                                
                                                                            <?php } ?>
                                                                        </select>
                                                                        
                                                                    </div>
                                                                    <div class="user-entry">
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px; background-color:none;"   name="emp_m_r_xls"><i class="icofont icofont-file-excel"  style="    font-size: 20px;margin-right: 10px;"></i> Excel</button>
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px; background-color:none;"  name="emp_m_r_pdf"><i  class="icofont icofont-print" style="    font-size: 20px;margin-right: 10px;"></i>Print</button>
                                                                    </div>
                                                                </div>
                                                            </form> -->


                                                            <form action="contribution_report_process" method="post">
                                                                <div class="form-group row" style="place-items: center;">
                                                                    <label class="col-sm-3 col-form-label" style="padding-right: 0; max-width:8rem;">Item & Date-Range</label>
                                                                    <div class="col-sm-9" style="display:flex; max-width: 64%;">
                                                                        <select name="item_report" id="emp_month" class="form-control" style="margin-right: 0.8rem;"   required>

                                                                            <option value="" disabled selected hidden>Select Item</option>
                                                                            <?php while($item_data=mysqli_fetch_assoc($sql_itm_data4)){?>
                                                                            <option value="<?php echo  $item_data['itm_code'];?>"><?php echo $item_data['Item_name'];?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <input type="date" class="form-control" id="emp_date" placeholder="Enter Item Name" name="date_F_report" style="max-width:11rem;    margin-right: 0.8rem;" required>
                                                                        <input type="date" class="form-control" id="emp_date" placeholder="Enter Item Name" name="date_T_report" style="max-width:11rem;   " required>
                                                                        
                                                                                
                                                                    </div>
                                                                    <div class="user-entry">
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px; background-color:none;"   name="Item_D_r_xls"><i class="icofont icofont-file-excel"  style="    font-size: 20px;margin-right: 10px;"></i> Excel</button>
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px; background-color:none;"  name="Item_D_r_pdf"><i  class="icofont icofont-print" style="    font-size: 20px;margin-right: 10px;"></i>Print</button>
                                                                    </div>
                                                                </div>
                                                            </form>


                                                            <form action="contribution_report_process" method="post">
                                                                <div class="form-group row" style="place-items: center;">
                                                                    <label class="col-sm-3 col-form-label" style="padding-right: 0; max-width:8rem;">Item & Month</label>
                                                                    <div class="col-sm-9" style="display:flex; max-width: 64%;">
                                                                    <select name=" item_report" id="emp_month" class="form-control" style="margin-right: 0.8rem;"   required>

                                                                        <option value="" disabled selected hidden>Select Item</option>
                                                                        <?php while($item_data=mysqli_fetch_assoc($sql_itm_data3)){?>
                                                                        <option value="<?php echo  $item_data['itm_code'];?>"><?php echo $item_data['Item_name'];?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <select name="month_report" id="emp_month" class="form-control" style="max-width:11rem;    margin-right: 0.8rem;"  required> 
                                                                        <option value="" disabled selected hidden>Select month</option>
                                                                        <?php for($i = 0; $i<count($month); $i++){?>
                                                                        <option value="<?php echo ($i+1);?>"><?php echo $month[$i];?></option>
                                                                            <?php echo $month[$i];?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <select name="year_report" id="emp_month" class="form-control"  style="max-width:11rem;    "  required>
                                                                        <option value="" disabled selected hidden>Select Year</option>
                                                                        <?php for($i = 2022; $i>=2018; $i--){?>
                                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                            
                                                                        <?php } ?>
                                                                    </select>
                                                                                
                                                                    </div>
                                                                    <div class="user-entry">
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px; background-color:none;"   name="item_m_r_xls"><i class="icofont icofont-file-excel"  style="    font-size: 20px;margin-right: 10px;"></i> Excel</button>
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px; background-color:none;"  name="item_m_r_pdf"><i  class="icofont icofont-print" style="    font-size: 20px;margin-right: 10px;"></i>Print</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <form action="contribution_report_process" method="post">
                                                                <div class="form-group row" style="place-items: center;">
                                                                    <label class="col-sm-3 col-form-label" style="padding-right: 0; max-width:8rem;">Month</label>
                                                                    <div class="col-sm-9" style="display:flex; max-width: 64%;">
                       
                                                                    <select name="month_report" id="emp_month" class="form-control" style="margin-right: 0.8rem;"  required> 
                                                                        <option value="" disabled selected hidden>Select month</option>
                                                                        <?php for($i = 0; $i<count($month); $i++){?>
                                                                        <option value="<?php echo ($i+1);?>"><?php echo $month[$i];?></option>
                                                                            <?php echo $month[$i];?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <select name="year_report" id="emp_month" class="form-control"  style=" "  required>
                                                                        <option value="" disabled selected hidden>Select Year</option>
                                                                        <?php for($i = 2022; $i>=2018; $i--){?>
                                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                            
                                                                        <?php } ?>
                                                                    </select>
                                                                                
                                                                    </div>
                                                                    <div class="user-entry">
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px; background-color:none;"   name="m_r_xls"><i class="icofont icofont-file-excel"  style="    font-size: 20px;margin-right: 10px;"></i> Excel</button>
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px; background-color:none;"  name="m_r_pdf"><i  class="icofont icofont-print" style="    font-size: 20px;margin-right: 10px;"></i>Print</button>
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
let dr_val;

$("#td_d").click(function() {
    dr_val = $(this).val();
    console.log(dr_val);
    if (dr_val == 1) {
        $("#today_r").css('display', '-webkit-box');

        $("#date_r").css('display', 'none');

    }
})
$("#td_t").click(function() {
    dr_val = $(this).val();
    console.log(dr_val);
    if (dr_val == 2) {
        $("#today_r").css('display', 'none');

        $("#date_r").css('display', '-webkit-box');

    }
})
</script>