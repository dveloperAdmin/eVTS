<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head = "Visitor Details Report";
$des = "Page Load visitor_report";
$rem = "Visitor Report";
include '../include/_audi_log.php';
$month = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];

$short = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
$sql_user_data = mysqli_query($conn, "select * from `user`");

$emp_code_id = "";
$user_code_id = $_SESSION['user_id'];
include '../include/_emp_details.php';
$v_emp_code = $emp_code_user_id;
include '../include/_approval.php';
$approvat = $refer_status;
$bracnOption = "";
if (in_array($user_role, array("Developer", "Super Admin"))) {
    $sql_Emp_data = mysqli_query($conn, "select * from `eomploye_details`");
    $sql_Emp_dataM = mysqli_query($conn, "select * from `eomploye_details`");
    $sql_Emp_datap = mysqli_query($conn, "select * from `eomploye_details`");
    $sql_Emp_datar = mysqli_query($conn, "select * from `eomploye_details`");
    $sql_Emp_datae = mysqli_query($conn, "select * from `eomploye_details`");
    $branchDetails = mysqli_query($conn, "select * from `branch`");
    $branchDetails2 = mysqli_query($conn, "select * from `branch`");
    $branchOption = "<option value ='All' >All</option>";
} else {
    $sql_Emp_data = mysqli_query($conn, "select * from `eomploye_details` where BranchId = '$branch_id'");
    $sql_Emp_dataM = mysqli_query($conn, "select * from `eomploye_details` where BranchId = '$branch_id'");
    $sql_Emp_datap = mysqli_query($conn, "select * from `eomploye_details` where BranchId = '$branch_id'");
    $sql_Emp_datar = mysqli_query($conn, "select * from `eomploye_details` where BranchId = '$branch_id'");
    $sql_Emp_datae = mysqli_query($conn, "select * from `eomploye_details` where BranchId = '$branch_id'");
    $branchDetails = mysqli_query($conn, "select * from `branch` where branch_code = '$branch_id'");
    $branchDetails2 = mysqli_query($conn, "select * from `branch` where branch_code = '$branch_id'");

}


?>
<!DOCTYPE html>
<html lang="en">

<?php include "include/head.php"; ?>

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
            <?php include "include/header.php" ?>
            <!-- Page-header end -->
            <div class="pcoded-inner-content">
              <!-- Main-body start -->
              <div class="main-body">
                <div class="page-wrapper">
                  <!-- Page body start -->
                  <div class="page-body">
                    <div class="row">
                      <div class="col-md-6" style="max-width: 100%; flex: 1 0 56%;">
                        <div class="card">
                          <div class="card-header" style="padding-bottom:8px;padding-top:8px;">
                            <h5>Visitor Report</h5>
                          </div>
                          <div class="card-block table-border-style" style="padding-bottom:0px">
                            <form action="visitor_log_report_process" method="post">
                              <div class="form-group row" style="margin-bottom: .5em;    place-items: center;">
                                <label class="col-sm-3 col-form-label" style="padding: 2px 10px;flex: 0 0 16%;">Branch &
                                  Employee</label>
                                <div class="col-sm-9"
                                  style="display:flex; max-width: 45%;; height:auto; flex-wrap: wrap; justify-content: space-between;">
                                  <select name="branchData" id="branchSelect" class="form-control"
                                    style="height: 35px; width: 49%;">
                                    <option value="" disabled selected hidden>Select
                                      Branch</option>
                                    <?= $branchOption; ?>
                                    <?php while ($branch = mysqli_fetch_assoc($branchDetails)) { ?>
                                    <option value="<?php echo $branch['branch_code']; ?>">
                                      <?php echo $branch['branch_name']; ?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                  <input list="suggestionListe" id="empd" name="" class="form-control"
                                    placeholder="Enter Employee Name" oninput="this.value = this.value.toUpperCase()"
                                    required style="width: 50.5%;" disabled>
                                  <datalist id="suggestionListe">

                                    <option data-value="All">All</option>
                                    <?php while ($user = mysqli_fetch_assoc($sql_Emp_datae)) { ?>
                                    <option data-value="<?php echo $user['Emp_code']; ?>">
                                      <?php echo $user['EmployeeName']; ?>
                                    </option>
                                    <?php } ?>
                                  </datalist>
                                  <input type="hidden" name="Emp_code" id="empd-hidden">


                                </div>
                                <div class="user-entry">
                                  <button class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                    style="padding: 7px 20px; background-color:none;" name="besic_log_branch_emp"><i
                                      class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Besic Report</button>
                                  <button class="btn waves-effect waves-light btn-success btn-outline-success"
                                    style="padding: 7px 20px; background-color:none;" name="details_log_branch_emp"><i
                                      class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Details Report</button>
                                  <button class="btn waves-effect waves-light btn-danger btn-outline-danger"
                                    style="padding: 7px 20px; background-color:none;" name="view_log_branch_emp"><i
                                      class="icofont icofont-eye" style="    font-size: 20px;margin-right: 10px;"></i>
                                    View</button>
                                </div>
                              </div>
                            </form>
                            <form action="visitor_log_report_process" method="post">
                              <div class="form-group row" style="margin-bottom: .3em;    place-items: center;">
                                <label class="col-sm-3 col-form-label" style="padding: 2px 10px;flex: 0 0 16%;"> Branch
                                  & Date
                                  Range</label>
                                <div class="col-sm-9"
                                  style="display:flex; max-width: 45%;; height:auto;flex-wrap: wrap; justify-content: space-between;">
                                  <select name="branchData" id="branchSelect" class="form-control"
                                    style="height: 35px; width: 49%;">
                                    <option value="" disabled selected hidden>Select
                                      Branch</option>
                                    <?= $branchOption; ?>
                                    <?php while ($branch = mysqli_fetch_assoc($branchDetails2)) { ?>
                                    <option value="<?php echo $branch['branch_code']; ?>">
                                      <?php echo $branch['branch_name']; ?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                  <input type="date" class="form-control" name="fm_date" id="" style=" width: 25%;"
                                    required>
                                  <input type="date" class="form-control" name="to_date" id="" style=" width: 25%; "
                                    required>


                                </div>
                                <div class="user-entry">
                                  <button class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                    style="padding: 7px 20px; background-color:none;" name="besic_log_date_range"><i
                                      class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Besic Report</button>
                                  <button class="btn waves-effect waves-light btn-success btn-outline-success"
                                    style="padding: 7px 20px; background-color:none;" name="details_log_date_range"><i
                                      class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Details Report</button>
                                  <button class="btn waves-effect waves-light btn-danger btn-outline-danger"
                                    style="padding: 7px 20px; background-color:none;" name="view_log_date_range"><i
                                      class="icofont icofont-eye" style="    font-size: 20px;margin-right: 10px;"></i>
                                    View</button>
                                </div>
                              </div>
                            </form>
                            <form action="visitor_log_report_process" method="post">
                              <div class="form-group row" style="margin-bottom: .3em;    place-items: center;">
                                <label class="col-sm-3 col-form-label" style="padding: 2px 10px;flex: 0 0 16%;">Employee
                                  & Date
                                  Range</label>
                                <div class="col-sm-9"
                                  style="display:flex; max-width: 45%;; height:auto;flex-wrap: wrap; justify-content: space-between;">
                                  <input list="suggestionList" id="emp" name="" class="form-control"
                                    placeholder="Enter Employee Name" oninput="this.value = this.value.toUpperCase()"
                                    required style="width:49%">
                                  <datalist id="suggestionList">

                                    <option data-value="All">All</option>
                                    <?php while ($user = mysqli_fetch_assoc($sql_Emp_data)) { ?>
                                    <option data-value="<?php echo $user['Emp_code']; ?>">
                                      <?php echo $user['EmployeeName']; ?>
                                    </option>
                                    <?php } ?>
                                  </datalist>
                                  <input type="hidden" name="Emp_code" id="emp-hidden">
                                  <input type="date" class="form-control" name="fm_date" id="" style="width: 25%;"
                                    required>
                                  <input type="date" class="form-control" name="to_date" id="" style="width: 25%;"
                                    required>


                                </div>
                                <div class="user-entry">
                                  <button class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                    style="padding: 7px 20px; background-color:none;"
                                    name="basic_log_by_emp_daterange"><i class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Besic Report</button>
                                  <button class="btn waves-effect waves-light btn-success btn-outline-success"
                                    style="padding: 7px 20px; background-color:none;"
                                    name="details_log_by_emp_daterange"><i class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Details Report</button>
                                  <button class="btn waves-effect waves-light btn-danger btn-outline-danger"
                                    style="padding: 7px 20px; background-color:none;"
                                    name="view_log_by_emp_daterange"><i class="icofont icofont-eye"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    View</button>

                                </div>
                              </div>
                            </form>
                            <form action="visitor_log_report_process" method="post">
                              <div class="form-group row" style=" margin-bottom:.5em;   place-items: center;">
                                <label class="col-sm-3 col-form-label" style="padding: 2px 10px;flex: 0 0 16%;">Employee
                                  &
                                  Month</label>
                                <div class="col-sm-9"
                                  style="display:flex; max-width: 45%;; height:auto; flex-wrap: wrap; justify-content: space-between;">
                                  <input list="suggestionListS" id="empS" name="" class="form-control"
                                    placeholder="Enter Employee Name" oninput="this.value = this.value.toUpperCase()"
                                    required style="height: 35px; width:49%">
                                  <datalist id="suggestionListS">

                                    <option data-value="ALL">All</option>
                                    <?php while ($user = mysqli_fetch_assoc($sql_Emp_dataM)) { ?>
                                    <option data-value="<?php echo $user['Emp_code']; ?>">
                                      <?php echo $user['EmployeeName']; ?>
                                    </option>
                                    <?php } ?>
                                  </datalist>
                                  <input type="hidden" name="Emp_code" id="empS-hidden">
                                  <select name="month_report" id="emp_month" class="form-control"
                                    style="width:25%;    height: 35px;">
                                    <option value="" disabled selected hidden>Select
                                      month</option>
                                    <?php for ($i = 0; $i < count($month); $i++) { ?>
                                    <option value="<?php echo $short[$i]; ?>">
                                      <?php echo $month[$i]; ?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                  <select name="year_report" id="emp_year" class="form-control"
                                    style="width:25%;    height: 35px;">
                                    <option value="" disabled selected hidden>Select
                                      Year</option>
                                    <?php for ($i = date("Y"); $i >= 2020; $i--) { ?>
                                    <option value="<?php echo $i; ?>">
                                      <?php echo $i; ?>
                                    </option>
                                    <?php } ?>
                                  </select>

                                </div>
                                <div class="user-entry">
                                  <button class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                    style="padding: 7px 20px; background-color:none;" name="besic_log_by_emp_monthly"><i
                                      class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Besic Report</button>
                                  <button class="btn waves-effect waves-light btn-success btn-outline-success"
                                    style="padding: 7px 20px; background-color:none;"
                                    name="details_log_by_emp_monthly"><i class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Details Report</button>
                                  <button class="btn waves-effect waves-light btn-danger btn-outline-danger"
                                    style="padding: 7px 20px; background-color:none;" name="view_log_by_emp_monthly"><i
                                      class="icofont icofont-eye" style="    font-size: 20px;margin-right: 10px;"></i>
                                    View</button>

                                </div>
                              </div>
                            </form>
                            <form action="visitor_log_report_process" method="post">
                              <div class="form-group row" style=" margin-bottom: .3em;   place-items: center;">
                                <label class="col-sm-3 col-form-label" style="padding: 2px 10px;flex: 0 0 16%;">Check
                                  Sts. & Date
                                  Range</label>
                                <div class="col-sm-9"
                                  style="display:flex; max-width: 45%;; height:auto;flex-wrap: wrap; justify-content: space-between;">

                                  <select name="check_sts" id="" class="form-control" style="height: 35px; width:49%">
                                    <option value="" disabled selected hidden>Select
                                      Status</option>
                                    <option value="IN">IN</option>
                                    <option value="OUT">OUT</option>

                                  </select>
                                  <input type="date" class="form-control" name="fm_date" id="" required
                                    style="height: 35px; width:25%">
                                  <input type="date" class="form-control" name="to_date" id="" required
                                    style="height: 35px; width:25%">

                                </div>
                                <div class="user-entry">
                                  <button class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                    style="padding: 7px 20px; background-color:none;"
                                    name="besic_log_by_sts_daterange"><i class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Besic Report</button>
                                  <button class="btn waves-effect waves-light btn-success btn-outline-success"
                                    style="padding: 7px 20px; background-color:none;"
                                    name="details_log_by_sts_daterange"><i class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Details Report</button>
                                  <button class="btn waves-effect waves-light btn-danger btn-outline-danger"
                                    style="padding: 7px 20px; background-color:none;"
                                    name="view_log_by_sts_daterange"><i class="icofont icofont-eye"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    View</button>
                                </div>
                              </div>
                            </form>
                            <form action="visitor_log_report_process" method="post">
                              <div class="form-group row" style=" margin-bottom: .3em;   place-items: center;">
                                <label class="col-sm-3 col-form-label" style="padding: 2px 10px;flex: 0 0 16%;">Type &
                                  Purpose </label>
                                <div class="col-sm-9"
                                  style="display:flex; max-width: 45%;; height:auto;height:auto;flex-wrap: wrap; justify-content: space-between;">
                                  <select name="v_type" id="" class="form-control" style="height: 35px; width: 49%;"
                                    required>
                                    <option value="" disabled selected hidden>Select
                                      Visitor Type</option>
                                    <option value="ALL">ALL</option>
                                    <?php $sql_visit_type = mysqli_query($conn, "select * from `vsitor_type`");
                                                                        while ($type_data = mysqli_fetch_assoc($sql_visit_type)) { ?>
                                    <option value="<?php echo $type_data['type_id']; ?>">
                                      <?php echo $type_data['type_name']; ?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                  <select name="v_purpose" id="" class="form-control" style="height: 35px; width:50.5%"
                                    required>
                                    <option value="" disabled selected hidden>Select
                                      Visit Purpose</option>
                                    <option value="ALL">ALL</option>
                                    <?php $sql_visit_purpus = mysqli_query($conn, "select * from `visit_purpose`");
                                                                        while ($purpos_data = mysqli_fetch_assoc($sql_visit_purpus)) { ?>
                                    <option value="<?php echo $purpos_data['purpose_id']; ?>">
                                      <?php echo $purpos_data['purpose']; ?>
                                    </option>
                                    <?php } ?>

                                  </select>

                                </div>
                                <div class="user-entry">
                                  <button class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                    style="padding: 7px 20px; background-color:none;"
                                    name="baseic_log_by_visit_type_purpose"><i class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Besic Report</button>
                                  <button class="btn waves-effect waves-light btn-success btn-outline-success"
                                    style="padding: 7px 20px; background-color:none;"
                                    name="details_log_by_visit_type_purpose"><i class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Details Report</button>
                                  <button class="btn waves-effect waves-light btn-danger btn-outline-danger"
                                    style="padding: 7px 20px; background-color:none;"
                                    name="view_log_by_visit_type_purpose"><i class="icofont icofont-eye"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    View</button>
                                </div>
                              </div>
                            </form>
                            <?php if ($approvat == 'Active') { ?>
                            <form action="visitor_log_report_process" method="post">
                              <div class="form-group row" style=" margin-bottom: .3em;   place-items: center;">
                                <label class="col-sm-3 col-form-label" style="padding: 2px 10px;flex: 0 0 16%;">Reffer
                                  By &nbsp; & Date
                                  Range</label>
                                <div class="col-sm-9"
                                  style="display:flex; max-width: 45%;; height:auto;flex-wrap: wrap; justify-content: space-between;">
                                  <input list="suggestionList" id="empp" name="" class="form-control"
                                    placeholder="Enter Employee Name" oninput="this.value = this.value.toUpperCase()"
                                    required style=" width:49%">
                                  <datalist id="suggestionList">

                                    <option data-value="All">All</option>
                                    <?php while ($user = mysqli_fetch_assoc($sql_Emp_datap)) { ?>
                                    <option data-value="<?php echo $user['Emp_code']; ?>">
                                      <?php echo $user['EmployeeName']; ?>
                                    </option>
                                    <?php } ?>
                                  </datalist>
                                  <input type="hidden" name="Emp_code" id="empp-hidden">
                                  <input type="date" class="form-control" name="fm_date" id="" style=" width: 25%;"
                                    required>
                                  <input type="date" class="form-control" name="to_date" id="" style=" width: 25%;"
                                    required>


                                </div>
                                <div class="user-entry">
                                  <!-- <button class="btn waves-effect waves-light btn-primary btn-outline-primary"  style="padding: 7px 20px; background-color:none;" name="besic_refer_by_log"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Besic Report</button> -->
                                  <button class="btn waves-effect waves-light btn-success btn-outline-success"
                                    style="padding: 7px 20px; background-color:none;"
                                    name="details_log_report_refer_by"><i class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Details Report</button>
                                  <button class="btn waves-effect waves-light btn-danger btn-outline-danger"
                                    style="padding: 7px 20px; background-color:none;" name="view_refer_by_log"><i
                                      class="icofont icofont-eye" style="    font-size: 20px;margin-right: 10px;"></i>
                                    View</button>
                                </div>
                              </div>
                            </form>
                            <form action="visitor_log_report_process" method="post">
                              <div class="form-group row" style="margin-bottom: .3em;    place-items: center;">
                                <label class="col-sm-3 col-form-label" style="padding: 2px 10px;flex: 0 0 16%;">Reffer
                                  To &nbsp; & Date
                                  Range</label>
                                <div class="col-sm-9"
                                  style="display:flex; max-width: 45%;; height:auto;flex-wrap: wrap; justify-content: space-between;">
                                  <input list="suggestionList" id="empr" name="" class="form-control"
                                    placeholder="Enter Employee Name" oninput="this.value = this.value.toUpperCase()"
                                    required style=" width:49%">
                                  <datalist id="suggestionList">

                                    <option data-value="All">All</option>
                                    <?php while ($user = mysqli_fetch_assoc($sql_Emp_datar)) { ?>
                                    <option data-value="<?php echo $user['Emp_code']; ?>">
                                      <?php echo $user['EmployeeName']; ?>
                                    </option>
                                    <?php } ?>
                                  </datalist>
                                  <input type="hidden" name="Emp_code" id="empr-hidden">
                                  <!-- <input list="emps" type="text" class="form-control" style=" width:160%"
                                      placeholder="Enter Employe Name " name="Emp_code"
                                      oninput="this.value = this.value.toUpperCase()" required id="emp">
                                    <datalist id="emps">
                                      <?php
                                      $sql_emp_data = mysqli_query($conn, "select * from `eomploye_details`");
                                      while ($emp_data = mysqli_fetch_assoc($sql_emp_data)) {
                                          ?>
                                        <option
                                          value="<?php echo $emp_data['Emp_code'] . ' ' . $emp_data['EmployeeName']; ?>">
                                        <?php } ?>
                                    </datalist> -->
                                  <input type="date" class="form-control" name="fm_date" id="" style="width: 25%;"
                                    required>
                                  <input type="date" class="form-control" name="to_date" id="" style=" width: 25%;"
                                    required>


                                </div>
                                <div class="user-entry">
                                  <!-- <button class="btn waves-effect waves-light btn-primary btn-outline-primary"  style="padding: 7px 20px; background-color:none;" name="besic_refer_to_log"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Besic Report</button> -->
                                  <button class="btn waves-effect waves-light btn-success btn-outline-success"
                                    style="padding: 7px 20px; background-color:none;" name="details_refer_to_log"><i
                                      class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Details Report</button>
                                  <button class="btn waves-effect waves-light btn-danger btn-outline-danger"
                                    style="padding: 7px 20px; background-color:none;" name="view_refer_to_log"><i
                                      class="icofont icofont-eye" style="    font-size: 20px;margin-right: 10px;"></i>
                                    View</button>
                                </div>
                              </div>
                            </form>
                            <?php } ?>
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
  <?php include "include/footer.php"; ?>
</body>

</html>
<script>
$("#emp").change(function() {
  $("#emp_date").val('');
  $("#emp_month").val('');
  $("#emp_year").val('');
})
$("#emp_date").change(function() {
  $("#emp").val('');
  $("#emp_month").val('');
  $("#emp_year").val('');
})
$("#emp_month , #emp_year").change(function() {
  $("#emp").val('');
  $("#emp_date").val('');

})
</script>