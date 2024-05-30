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
$email = "";
$camApp = false;
if (isset($_POST['u_submit'])) {
  try {
    $e = true;
    $emp_code = "";
    $i = 0;
    $emp_name_v = "";
    $visitor_data = $_POST['visit'];
    $emp_details = $visitor_data[0];
    $time = $visitor_data[2];
    $gate_no = $visitor_data[3];
    $purpose = $visitor_data[4];

    if ($emp_details != "" && $time != "" && $gate_no != "" && $purpose != "") {

      // $emp_name_v = substr($emp_details, strpos($emp_details, ' '), strlen($emp_details));
      // echo $emp_name;
      $purpose_check = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visit_purpose` where `purpose_id` = '$purpose'"));
      if ($purpose_check != "") {
        $purpose = strtoupper($purpose_check['purpose']);
      }
      $full1 = explode(' ', $emp_details);
      $emp_code = $full1[0];
      $sql_emp_data = mysqli_fetch_assoc(mysqli_query($conn, "select eomploye_details.* from eomploye_details join user on eomploye_details.EmployeeId = user.EmployeeId where user.user_role != 'Security' and eomploye_details.Emp_code ='$emp_code'"));
      if ($sql_emp_data != "") {
        $emp_name_v = $sql_emp_data['EmployeeName'];
        $email = $sql_emp_data['email_id'];
        if ($email == "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $_SESSION['icon'] = 'error';
          $_SESSION['status'] = 'Invalid Employee Mail Id';

          header("location:new_visitor1");
        }
      } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Enter a valid employee details';

        header("location:new_visitor1");
      }
    } else {
      $_SESSION['icon'] = 'error';
      $_SESSION['status'] = 'Please Fill All The Input Carefully';

      header("location:new_visitor1");
    }
    if ($Approval['Camera'] != "" && $Approval['Camera'] != null) {
      $camApp = $Approval['Camera'];
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
<style>
#expandingTextarea {
  width: calc(100% - 10px);
  transition: height 0.3s ease;
  overflow: hidden;
  resize: none;
  border: none;
  text-overflow: ellipsis;

}
</style>

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
                      <div class="card-header" style="padding-bottom:5px; padding-top:10px;">
                        <div class="row">
                          <div class="col-md-3" style="flex:0 0 28%; max-width:35%; padding-right:0;">

                            <h5>Emp.name :- </h5><?php echo $emp_name_v; ?>
                          </div>
                          <div class="col-md-3" style="flex:0 0 30%; max-width:35%; padding-right:0;">
                            <div style="display:flex;flex-wrap:wrap;">

                              <div>
                                <h5>Purpose :- </h5>
                              </div>
                              <div id="containerOverFlow" style="flex:0 0 72%; max-width: 75%; overflow: hidden;">
                                <textarea id="expandingTextarea" rows="1" style="width: 100%;"
                                  readonly><?= $purpose; ?></textarea>

                              </div>
                            </div>

                            <!--  -->
                          </div>
                          <div class="col-md-3" style="flex:0 0 20.5%; padding-right:0;">

                            <h5>Arrive-Time:- <?php echo $time; ?></h5>
                          </div>
                          <div class="col-md-3" style="flex:0 0 20%; padding-right:0px;">

                            <h5>Gate No :- <?php echo $gate_no; ?></h5>
                          </div>



                        </div>


                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <?php
                          if ($camApp == 'Activate') {
                            $formUrl = "new_visitor3";
                          } else {
                            $formUrl = "newVisitor3";

                          }
                          ?>

                          <div class="card-block">
                            <form action="<?= $formUrl; ?>" method="post" id="save_next" enctype="multipart/form-data">
                              <div class="form-group row" style="margin-bottom:.65rem;">
                                <?php
                                if ($e == true) {

                                  foreach ($visitor_data as $id => $value) { ?>
                                <input type="hidden" name="visit[]" value="<?php echo $value; ?>">
                                <?php
                                  }
                                }
                                ?>
                                <label class="col-sm-3 col-form-label">ID Type<span
                                    style="color:red;padding:2px;">*</span></label>
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
                                <label class="col-sm-3 col-form-label"> Govt. ID Number<span
                                    style="color:red;padding:2px;">*</span></label>
                                <div class="col-sm-9">
                                  <input type="text" name="visit[]" id="id_no" class="form-control" disabled="true"
                                    placeholder="Enter Govt. ID Number" required>

                                </div>
                              </div>
                              <div class="col_1">

                                <div class="form-group row" style="margin-bottom:.65rem;">
                                  <label class="col-sm-3 col-form-label">Visitor Name<span
                                      style="color:red;padding:2px;">*</span></label>
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
                                  <label class="col-sm-3 col-form-label">Com. Name<span
                                      style="color:red;padding:2px;">*</span></label>
                                  <div class="col-sm-9">
                                    <input type="text" name="visit[]" id="com_name" class="form-control"
                                      placeholder="Enter Com. Name" required>

                                  </div>
                                </div>
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
                        </div>


                        <div class="col-md-6">
                          <div class="card-block ">

                            <div class="col_1">
                              <div class="form-group row" style="margin-bottom:.65rem;">
                                <label class="col-sm-3 col-form-label">Visitor Id Card No<span
                                    style="color:red;padding:2px;">*</span></label>
                                <div class="col-sm-9">
                                  <input type="text" style="text-transform: uppercase" name="visit[]" id="vidcard"
                                    class="form-control" value="<?php echo strtoupper(uniqid()); ?>"
                                    placeholder="Enter Visitor ID Number" required>

                                </div>
                              </div>

                              <div class="form-group row" style="margin-bottom:.65rem;">
                                <label class="col-sm-3 col-form-label">Visitor Type<span
                                    style="color:red;padding:2px;">*</span></label>
                                <div class="col-sm-9">
                                  <select name="visit[]" id="cont" class="form-control" required>
                                    <option value="" selected disabled hidden>Select Visitor Type</option>
                                    <?php
                                    $sql_visitor_type = mysqli_query($conn, "select * from `vsitor_type`");
                                    while ($visitor_type = mysqli_fetch_assoc($sql_visitor_type)) {
                                      ?>
                                    <option value="<?php echo $visitor_type['type_id']; ?>">
                                      <?php echo $visitor_type['type_name']; ?>
                                    </option>
                                    <?php }
                                    ?>
                                  </select>


                                </div>
                              </div>
                              <div class="form-group row" style="margin-bottom:.65rem;">
                                <label class="col-sm-3 col-form-label">Carry Inside </label>
                                <div class="col-sm-9">

                                  <textarea type="textarea" name="visit[]" class="form-control"
                                    placeholder="Enter The Things You are carring " value="" rows="4"
                                    cols="50"></textarea>
                                </div>
                              </div>
                              <div class="form-group row" style="margin-bottom:.65rem;">
                                <label class="col-sm-3 col-form-label">Vehicle Type<span
                                    style="color:red;padding:2px;">*</span></label>
                                <div class="col-sm-9">
                                  <select name="visit[]" id="vehicle" class="form-control" required>
                                    <option value="" selected disabled hidden>Select Vehicle Type</option>
                                    <option value="NO">NO</option>
                                    <option value="Cycle">Two While(Cycle)</option>
                                    <option value="Bike">Two While(Bike)</option>
                                    <option value="Car">CAR</option>
                                    <option value="SUV">SUV</option>
                                    <option value="VAN">VAN</option>
                                    <option value="TAXI">TAXI</option>
                                    <option value="AUTO">AUTO</option>
                                    <option value="OLA">OLA</option>
                                    <option value="UBER">UBER</option>
                                    <option value="CAB">CAB</option>
                                    <option value="TRUCK">TRUCK</option>
                                    <option value="DUMPER TRUCK">DUMPER TRUCK</option>
                                    <option value="PICKUP VAN">PICKUP VAN</option>
                                    <option value="PICKUP TRUCK">PICKUP TRUCK</option>
                                    <option value="TIPPER TRUCK">TIPPER TRUCK</option>
                                    <option value="SMALL TRUCK">SMALL TRUCK</option>
                                    <option value="BOX TRUCK">BOX TRUCK</option>
                                    <option value="CONCRETE TRUCK">CONCRETE TRUCK</option>
                                    <option value="TANKER">TANKER</option>
                                    <option value="CRAN">CRAN</option>
                                    <option value="Others">Others</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row" style="margin-bottom:.65rem;">
                                <label class="col-sm-3 col-form-label">Vehicale number</label>
                                <div class="col-sm-9">
                                  <input type="text" name="visit[]" id="v_no" class="form-control"
                                    placeholder="Enter Vehicale Number" value="">

                                </div>
                              </div>



                            </div>
                          </div>

                          <div class="user-entry" style="margin-right: 1.3rem;">

                            <a href="new_visitor1"><button type="button"
                                class="btn waves-effect waves-light btn-inverse btn-outline-inverse"><i
                                  class="icofont icofont-exchange"></i>Cancel</button></a>
                            <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"
                              name="u_submit"><i class="fa fa-arrow-right"
                                style="    font-size: 20px;margin-right: 10px;"></i>Save & Next</button>
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
$(document).ready(function() {
  $("#vidcard").val(randomString(13).toUpperCase());
});


$(document).ready(function() {
  var $textarea = $('#expandingTextarea');
  var originalHeight = $textarea.height(); // Store the original height

  function adjustHeight() {
    // Reset the height to auto to recalculate the scrollHeight
    $textarea.css('height', 'auto');

    // Calculate the scroll height and set it as the new height if it exceeds the current height
    var scrollHeight = $textarea.prop('scrollHeight');
    var currentHeight = $textarea.height();

    if (scrollHeight > currentHeight) {
      $textarea.css('height', scrollHeight + 'px');
    }
  }

  // Adjust height on input
  $textarea.on('input', adjustHeight);

  // Adjust height on hover
  $textarea.hover(
    function() {
      adjustHeight();
    },
    function() {
      // Revert to the original height on mouse leave
      $textarea.css('height', originalHeight + 'px');
    }
  );
});
</script>