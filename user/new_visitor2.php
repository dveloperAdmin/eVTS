<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head = "Visitor Info";
$des = "Page Load new_visitor2";
$rem = "New visitor";
include '../include/_audi_log.php';
$e = false;
// registration form submit start 
$visitor_data = "";
$emp_name = "";
$gate_no = "";
$time = "";
$purpose = "";
$e = false;

if (isset($_POST['u_submit'])) {
  try {
    $e = true;
    $emp_code = "";
    $i = 0;
    $visitor_data = $_POST['visit'];
    $emp_details = $visitor_data[0];
    $time = date("d-M-Y", strtotime($visitor_data[2]));
    $gate_no = $visitor_data[3];
    $purpose = $visitor_data[4];
    if ($emp_details != "" && $time != "" && $gate_no != "" && $purpose != "") {

      // $emp_name = substr($emp_details, strpos($emp_details, ' '), strlen($emp_details));
      $purpose_check = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visit_purpose` where `purpose_id` = '$purpose'"));
      if ($purpose_check != "") {
        $purpose = strtoupper($purpose_check['purpose']);
      }
      $full1 = explode(' ', $emp_details);
      $emp_code = $full1[0];
      $sql_emp_data = mysqli_fetch_assoc(mysqli_query($conn, "select eomploye_details.* from eomploye_details join user on eomploye_details.EmployeeId = user.EmployeeId where user.user_role != 'Security'and eomploye_details.`Emp_code`='$emp_code'"));
      if ($sql_emp_data != "") {
        $emp_name = $sql_emp_data['EmployeeName'];
        $email = $sql_emp_data['email_id'];
        if ($email == "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $_SESSION['icon'] = 'error';
          $_SESSION['status'] = 'Invalid Employee Mail Id';

          header("location:new_visitor1");
        }
      } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Please enter valid employee details';

        header("location:new_visitor1");
      }
    } else {
      $_SESSION['icon'] = 'error';
      $_SESSION['status'] = 'Please Fill All The Input Carefully';

      header("location:new_visitor1");
    }
  } catch (Exception $e) {
    $_SESSION['icon'] = 'error';
    $_SESSION['status'] = 'Please Enter Input Properly';

    header("location:new_visitor1");
  }







} else {
  $_SESSION['icon'] = 'info';
  $_SESSION['status'] = 'Please Fill This Form At Fast';
  header("location:new_visitor1");
}

// registration form submit start 











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
                    <div class="card">
                      <div class="card-header" style="padding:8px 20px;">
                        <div class="row">
                          <div class="col-md-3" style="flex:0 0 28%; max-width:35%; padding-right:0;">

                            <h5>Emp.name :- </h5><?php echo $emp_name; ?>
                          </div>
                          <div class="col-md-3" style="flex:0 0 30%; max-width:35%; padding-right:0;">

                            <h5>Purpose :- </h5><?php echo $purpose; ?>
                          </div>
                          <div class="col-md-3" style="flex:0 0 20.5%;  padding-right:0;">

                            <h5>Schedule Date:- <?php echo $time; ?></h5>
                          </div>
                          <div class="col-md-3" style="flex:0 0 20%; padding-right:0;">

                            <h5>Gate No :- <?php echo $gate_no; ?></h5>
                          </div>

                        </div>


                      </div>

                      <div class="row">
                        <div class="col-md-6">


                          <div class="card-block">
                            <form action="new_visitor3" method="post" id="save_next" enctype="multipart/form-data">
                              <div class="form-group row" style="margin-bottom:.65rem;">
                                <?php
                                if ($e == true) {

                                  foreach ($visitor_data as $id => $value) { ?>
                                    <input type="hidden" name="visit[]" value="<?php echo $value; ?>">
                                    <?php
                                  }
                                }
                                ?>
                                <label class="col-sm-3 col-form-label">ID
                                  Type<span style="color:red;padding:2px;">*</span></label>
                                <div class="col-sm-9">
                                  <select class="form-control" name="visit[]" id="govt_id_type" required autofocus>

                                    <option value="" selected disabled hidden>Select ID Type</option>
                                    <option value="Aadhaar">Aadhaar</option>
                                    <option value="PAN">PAN</option>
                                    <option value="Voter">Voter</option>
                                    <option value="License">Driving License</option>
                                    <option value="MobileNumber">Mobile Number</option>
                                    <option value="Others">Others</option>

                                  </select>
                                </div>
                              </div>

                              <div class="form-group row" style="margin-bottom:.65rem;">
                                <label class="col-sm-3 col-form-label"> ID Details
                                  Number<span style="color:red;padding:2px;">*</span></label>
                                <div class="col-sm-9">
                                  <input type="text" name="visit[]" id="id_no" class="form-control" disabled="true"
                                    placeholder="Enter Govt. ID Number" required>

                                </div>
                              </div>
                              <div class="col_1">

                                <div class="form-group row" style="margin-bottom:.65rem;">
                                  <label class="col-sm-3 col-form-label">Visitor
                                    Name<span style="color:red;padding:2px;">*</span></label>
                                  <div class="col-sm-9 " style="display:flex;">
                                    <select class="form-control" name="visit[]" id="v_salu"
                                      style="width: 20%;margin-right: 0.6rem; height: 2.2rem;" required>

                                      <option value="Mr." selected>Mr.</option>
                                      <option value="Ms.">Ms.</option>
                                      <option value="Mrs.">Mrs.</option>
                                    </select>
                                    <input type="text" name="visit[]" id="visit_n" class="form-control"
                                      placeholder="Enter Visitor Name" required>

                                  </div>
                                </div>
                                <div class="form-group row" style="margin-bottom:.65rem;">
                                  <label class="col-sm-3 col-form-label">Com.
                                    Name<span style="color:red;padding:2px;">*</span></label>
                                  <div class="col-sm-9">
                                    <input type="text" name="visit[]" id="com_name" class="form-control"
                                      placeholder="Enter Com. Name" required>

                                  </div>
                                </div>

                              </div>




                          </div>
                        </div>


                        <div class="col-md-6">
                          <div class="card-block ">

                            <div class="col_1">
                              <div class="form-group row" style="margin-bottom:.65rem;">
                                <label class="col-sm-3 col-form-label">Designtion</label>
                                <div class="col-sm-9">
                                  <input type="text" name="visit[]" id="desig" class="form-control"
                                    placeholder="Enter Designation">

                                </div>
                              </div>
                              <div class="form-group row" style="margin-bottom:.65rem;">
                                <label class="col-sm-3 col-form-label">Address<span
                                    style="color:red;padding:2px;">*</span></label>
                                <div class="col-sm-9">
                                  <input type="text" name="visit[]" id="add_ss" class="form-control"
                                    placeholder="Enter Address" required>

                                </div>
                              </div>
                              <div class="form-group row" style="margin-bottom:.65rem;">
                                <label class="col-sm-3 col-form-label">Gamil</label>
                                <div class="col-sm-9">
                                  <input type="text" name="visit[]" id="gmail" class="form-control"
                                    placeholder="Enter Gamil Id">

                                </div>
                              </div>
                              <div class="form-group row" style="margin-bottom:.65rem;">
                                <label class="col-sm-3 col-form-label">Contact No<span
                                    style="color:red;padding:2px;">*</span></label>
                                <div class="col-sm-9">
                                  <input type="text" name="visit[]" id="cont" class="form-control"
                                    placeholder="Enter Contact Number" required maxlength="10">

                                </div>
                              </div>



                            </div>
                          </div>

                          <div class="user-entry" style="margin-right: 1.3rem;">

                            <a href="new_visitor1"><button type="reset"
                                class="btn waves-effect waves-light btn-inverse btn-outline-inverse"><i
                                  class="icofont icofont-exchange"></i>Cancel</button></a>
                            <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"
                              name="u_submit"><i class="fa fa-arrow-right"
                                style="    font-size: 20px;margin-right: 10px;"></i>Save
                              & Next</button>
                          </div>

                        </div>

                        </form>
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
      <?php include "include/footer.php"; ?>
</body>

</html>


<script type="text/javascript">
  function randomString(length) {
    return Math.round((Math.pow(36, length + 1) - Math.random() * Math.pow(36, length))).toString(36).slice(1);
  }
  $(document).ready(function () {
    $("#vidcard").val(randomString(13).toUpperCase());
  });
</script>