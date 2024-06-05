<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head = "Users Details Report";
$des = "Page Load userReport";
$rem = "Users Report";
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
  $branchDetails = mysqli_query($conn, "select * from `branch`");
  $branchOption = "<option value ='All' >All</option>";
} else {
  $branchDetails = mysqli_query($conn, "select * from `branch` where branch_code = '$branch_id'");

}
$departMent = mysqli_query($conn, "select * from `department`");


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
                            <h5>Users Report</h5>
                          </div>
                          <div class="card-block table-border-style" style="padding-bottom:0px">
                            <form action="userReportProcess" method="post">
                              <div class="form-group row" style="margin-bottom: .5em;    place-items: center;">
                                <label class="col-sm-3 col-form-label" style="padding: 2px 10px;flex: 0 0 16%;">Branch &
                                  Department</label>
                                <div class="col-sm-9"
                                  style="display:flex; max-width: 45%;; height:auto; flex-wrap: wrap; justify-content: space-between;">
                                  <select name="branchData" id="" class="form-control"
                                    style="height: 35px; width: 49%;">
                                    <option value="" disabled selected hidden>Select Branch</option>
                                    <?= $branchOption; ?>
                                    <?php while ($branch = mysqli_fetch_assoc($branchDetails)) { ?>
                                    <option value="<?php echo $branch['branch_code']; ?>">
                                      <?php echo $branch['branch_name']; ?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                  <select name="deptData" id="" class="form-control" style="height: 35px; width: 49%;">
                                    <option value="" disabled selected hidden>Select Department</option>
                                    <?= $branchOption; ?>
                                    <?php while ($dept = mysqli_fetch_assoc($departMent)) { ?>
                                    <option value="<?php echo $dept['department_code']; ?>">
                                      <?php echo $dept['department_name']; ?>
                                    </option>
                                    <?php } ?>
                                  </select>

                                </div>
                                <div class="user-entry">
                                  <button class="btn waves-effect waves-light btn-success btn-outline-success"
                                    style="padding: 7px 20px; background-color:none;"
                                    name="details_log_branch_dept_user"><i class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Details Report</button>
                                  <button class="btn waves-effect waves-light btn-danger btn-outline-danger"
                                    style="padding: 7px 20px; background-color:none;" name="view_user_branch_dept"><i
                                      class="icofont icofont-eye" style="    font-size: 20px;margin-right: 10px;"></i>
                                    View</button>
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