<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head = "Visitor Info Report";
$des = "Page Load visitor_info_report";
$rem = "Visitor info Report";
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
                      <div class="col-md-6" style="max-width: 65%; flex: 1 0 56%;">
                        <div class="card">
                          <div class="card-header" style="padding-bottom:8px;padding-top:8px;">
                            <h5>Visitor Info Report</h5>
                          </div>
                          <div class="card-block table-border-style" style="padding-bottom:0px">
                            <form action="visitor_info_report_process.php" method="post">
                              <div class="form-group row" style="margin-bottom: .5em;    place-items: center;">
                                <label class="col-sm-3 col-form-label" style="flex: 0 0 17%;">Date Range</label>
                                <div class="col-sm-9" style="display:flex; max-width: 45%; height:auto;">
                                  <input type="date" name="from_date" id="" class="form-control"
                                    style="margin-right:.5rem;" required>
                                  <input type="date" name="to_date" id="" class="form-control" required>


                                </div>
                                <div class="user-entry">
                                  <!-- <button class="btn waves-effect waves-light btn-primary btn-outline-primary"  style="padding: 7px 20px; background-color:none;" name="besic_log_date_range"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Besic Report</button> -->
                                  <button class="btn waves-effect waves-light btn-success btn-outline-success"
                                    style="padding: 7px 20px; background-color:none;" name="v_info_monthly"><i
                                      class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Details Report</button>
                                  <button class="btn waves-effect waves-light btn-danger btn-outline-danger"
                                    style="padding: 7px 20px; background-color:none;" name="view_log_monthly"><i
                                      class="icofont icofont-eye" style="    font-size: 20px;margin-right: 10px;"></i>
                                    View</button>
                                </div>
                              </div>
                            </form>
                            <form action="visitor_info_report_process.php" method="post">
                              <div class="form-group row" style="margin-bottom: .5em;    place-items: center;">
                                <label class="col-sm-3 col-form-label" style="flex: 0 0 17%;">Visitor Name </label>
                                <div class="col-sm-9" style="display:flex; max-width: 45%; height:auto;">
                                  <input type="text" class="form-control" style=" width:100%"
                                    placeholder="Enter Visitor Name " name="v_name" required id="emp">



                                </div>
                                <div class="user-entry">
                                  <!-- <button class="btn waves-effect waves-light btn-primary btn-outline-primary"  style="padding: 7px 20px; background-color:none;" name="basic_log_by_emp_daterange"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Besic Report</button> -->
                                  <button class="btn waves-effect waves-light btn-success btn-outline-success"
                                    style="padding: 7px 20px; background-color:none;" name="v_name_report"><i
                                      class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Details Report</button>
                                  <button class="btn waves-effect waves-light btn-danger btn-outline-danger"
                                    style="padding: 7px 20px; background-color:none;" name="view_v_name_report"><i
                                      class="icofont icofont-eye" style="    font-size: 20px;margin-right: 10px;"></i>
                                    View</button>

                                </div>
                              </div>
                            </form>
                            <form action="visitor_info_report_process.php" method="post">
                              <div class="form-group row" style=" margin-bottom:.5em;   place-items: center;">
                                <label class="col-sm-3 col-form-label" style="flex: 0 0 17%;">Mobile Number</label>
                                <div class="col-sm-9" style="display:flex; max-width: 45%; height:auto;">
                                  <input type="text" class="form-control" style=" width:100%"
                                    placeholder="Enter visitor contact no " name="mob_no" required id="emp"
                                    maxlength="10">


                                </div>
                                <div class="user-entry">
                                  <!-- <button class="btn waves-effect waves-light btn-primary btn-outline-primary"  style="padding: 7px 20px; background-color:none;" name="besic_log_by_emp_monthly"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Besic Report</button> -->
                                  <button class="btn waves-effect waves-light btn-success btn-outline-success"
                                    style="padding: 7px 20px; background-color:none;" name="details_mobile_report"><i
                                      class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Details Report</button>
                                  <button class="btn waves-effect waves-light btn-danger btn-outline-danger"
                                    style="padding: 7px 20px; background-color:none;"
                                    name="view_details_mobile_report"><i class="icofont icofont-eye"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    View</button>

                                </div>
                              </div>
                            </form>
                            <form action="visitor_info_report_process.php" method="post">
                              <div class="form-group row" style=" margin-bottom: .5em;   place-items: center;">
                                <label class="col-sm-3 col-form-label" style="flex: 0 0 17%;">ID Type</label>
                                <div class="col-sm-9" style="display:flex; max-width: 45%; height:auto;">

                                  <select name="govt_type" id="" class="form-control" style="margin-right: 0.5rem;"
                                    required>
                                    <option value="" selected disabled hidden>Select
                                      ID Type</option>
                                    <option value="Aadhaar">Aadhaar</option>
                                    <option value="PAN">PAN</option>
                                    <option value="Voter">Voter</option>
                                    <option value="License">Driving License</option>
                                    <option value="MobileNumber">Mobile Number
                                    </option>
                                    <option value="Others">Others</option>


                                  </select>
                                  <input type="text" class="form-control" placeholder="Enter Govt. Id No" name="gvt_no"
                                    id="" style="" required>

                                </div>
                                <div class="user-entry">
                                  <!-- <button class="btn waves-effect waves-light btn-primary btn-outline-primary"  style="padding: 7px 20px; background-color:none;" name="besic_log_by_sts_daterange"><i class="icofont icofont-file-excel" style="    font-size: 20px;margin-right: 10px;"></i> Besic Report</button> -->
                                  <button class="btn waves-effect waves-light btn-success btn-outline-success"
                                    style="padding: 7px 20px; background-color:none;" name="details_gvt_id"><i
                                      class="icofont icofont-file-excel"
                                      style="    font-size: 20px;margin-right: 10px;"></i>
                                    Details Report</button>
                                  <button class="btn waves-effect waves-light btn-danger btn-outline-danger"
                                    style="padding: 7px 20px; background-color:none;" name="view_details_gvt_id"><i
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