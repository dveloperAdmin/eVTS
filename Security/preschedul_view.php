<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head = "Visitor Info Print";
$des = "Page Load new_visit_details_print";
$rem = "New visit print process";
include '../include/_audi_log.php';
include '../include/_function.php';

if (isset($_POST['view_v'])) {
  $company_name = "Not Found";
  $v_name = "Not Found";
  $v_c_name = "Not Found";
  $v_c_no = "Not Found";
  $v_g_no = "Not Found";
  $v_p = "Not Found";
  $v_type = "Not Found";
  $v_e_code = "Not Found";
  $v_e_name = "Not Found";
  $v_time = "Not Found";
  $v_date = "Not Found";
  $v_sts = "Not Found";
  $v_desig = "Not Found";
  $v_address = "Not Found";
  $v_email = "Not Found";
  $v_mobile = "Not Found";
  $v_govt_id = "Not Found";
  $v_mertial = "Not Found";
  $v_vehicle_type = "Not Found";
  $v_vehicle_no = "Not Found";
  $v_e_depart = "Not Found";
  $v_e_desig = "Not Found";
  $arr_time = "Not Found";
  $v_preschedul_date = "";
  $approval_sts = "Pending";
  $empApprove = "Pending";
  $branchCode = "";
  $com = "Not Found";
  $vlog_id = $_POST['v_id'];
  $id = explode('-', $vlog_id);
  $id = $id[1];

  $dami_img = "'../src/error.png'";
  $visit_data = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_log` where `visit_uid`='$vlog_id'"));
  if ($visit_data != "") {
    $v_emp_approve = $visit_data['Emp_approve'];
    $v_seq_approve = $visit_data['security_approval'];
    if ($v_emp_approve == "Approve" && $v_seq_approve == 'Approve') {
      $approval_sts = "Approve";
    } else if ($v_emp_approve == "Reject" || $v_seq_approve == 'Reject') {
      $approval_sts = "Reject";
    }
    $v_preschedul_date = $visit_data['pre_schedule_date'];
    $v_preschedul_date = date("Y-m-d", strtotime($v_preschedul_date));
    $v_c_no = $visit_data['id_card_no'];
    $v_g_no = $visit_data['gate_no'];
    $v_time = $visit_data['Arrival_time_stamp'];
    $arr_time = date("h:i:s A", strtotime($v_time));
    $v_date = $visit_data['checkin_date'];
    $v_date = date("d-M-Y", strtotime($v_date));
    $v_sts = ucfirst($visit_data['check_status']);
    $v_mertial = $visit_data['things_brought'];
    $v_vehicle_type = $visit_data['vehical_type'];
    $v_vehicle_no = $visit_data['vahical_num'];
    $empApprove = $visit_data['Emp_approve'];
    $arrival_date_time = $visit_data['Arrival_time_stamp'];
    $prereg = $visit_data['pre_schedule_date'];
    if ($arrival_date_time == '0000-00-00 00:00:00') {
      $arr_time = "00:00:00";
      $v_date = date("d-M-Y", strtotime($prereg));
    } else if ($v_time == '00:00:00' && $arrival_date_time != '0000-00-00 00:00:00') {
      $arr_time = date("h:i:s A", strtotime($arrival_date_time));
      $v_date = date("d-M-Y", strtotime($arrival_date_time));
    }

    $v_p = $visit_data['visit_purpose'];
    $visito_purpse_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visit_purpose` where `purpose_id` = '$v_p'"));
    if ($visito_purpse_sql != "") {

      $v_p = $visito_purpse_sql['purpose'];
    } else {
      $v_p = "";
    }

    // $v_type=$visit_data['visitor_type'];
    // $visit_type_sql = mysqli_fetch_assoc(mysqli_query($conn,"select * from `vsitor_type` where `type_id` = '$v_type'"));
    // $v_type = $visit_type_sql['type_name'];


    $v_e_code = $visit_data['emp_id'];
    $emp_details = mysqli_fetch_assoc(mysqli_query($conn, "select *from `eomploye_details` where `Emp_code`='$v_e_code'"));
    if ($emp_details) {
      $v_e_name = $emp_details['EmployeeName'];
      $v_e_depart = $emp_details['DepartmentId'];
      $branchCode = $emp_details['BranchId'];
      $v_department_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `department` where `department_code`='$v_e_depart'"));
      if ($v_department_sql != "") {
        $v_e_depart = $v_department_sql['department_name'];

      } else {
        $v_e_depart = "";
      }
      $v_e_desig = $emp_details['DesignationId'];
      $v_desig_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `designation` where `designation_code`='$v_e_desig'"));
      if ($v_desig_sql != "") {
        $v_e_desig = $v_desig_sql['designation'];
      } else {
        $v_e_desig = "";
      }

      $com_id = $emp_details['CompanyId'];

      $company_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `company_details` where `company_id` = '$com_id'"));
      if ($company_sql != "") {
        $company_name = $company_sql['companyFname'];
      }

    }


    $visitor_details_id = $visit_data['visitor_id'];
    $visitor_details_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_info` where `visitor_id` = '$visitor_details_id'"));
    if ($visitor_details_sql != "") {
      $v_name = $visitor_details_sql['name'];
      $v_c_name = $visitor_details_sql['com_name'];
      $v_desig = $visitor_details_sql['designation'];
      $v_address = $visitor_details_sql['address'];
      $v_email = $visitor_details_sql['mail_id'];
      $v_mobile = $visitor_details_sql['contact_no'];
      $v_govt_id = $visitor_details_sql['govt_id_no'];

      $v_govt_id = $masked = str_pad(substr($v_govt_id, -4), strlen($v_govt_id), '*', STR_PAD_LEFT);
    }
  }

}

if (!empty($branchCode)) {
  $com = strtoupper($company_name) . '<span style="font-size: 18px; font-weight: 500; font-style: italic;"> ( ' . findBranch($conn, $branchCode) . ' )</span>';
}

if ($Approval['Camera'] != "" && $Approval['Camera'] != null) {
  $preschedul_Image = $Approval['Camera'];
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
          <!-- <?php echo $pass; ?> -->
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
                    <!-- <div class="card"> -->
                    <div class="row">


                      <div class="col-md-6" style="padding-left:0px; flex:0 0 63%; max-width: 63%;">

                        <div class="col-md-6" style="padding-left: 45px;flex: 0 0 98%; max-width: 98%;">


                          <div class="card " id="contact1">
                            <section class="animate pop">
                              <div class="container" style="padding:1rem;">
                                <div class="admit-card">
                                  <div class="BoxA border- padding mar-bot">
                                    <div class="row">
                                      <div class="col-sm-4" style="flex:0 0 38%">
                                        <h5 style="font-size:15px;">Schedul Date
                                          :- <?php echo $v_date; ?></h5>
                                        <p style="margin-bottom:.5rem;">Schedul
                                          time: -
                                          <? echo $arr_time; ?>
                                        </p>
                                      </div>
                                      <div class="col-sm-4 txt-center" style="flex:0 0 29%; max-width:50%">
                                        <h5
                                          style="text-align:center;font-family: 'El Messiri', sans-serif;font-size:27px;">
                                          <?= $com; ?>
                                        </h5>
                                      </div>
                                      <div class="col-sm-4" style="flex:0 0 38%">
                                        <div style="display:grid; justify-content:end;">

                                          <h5 style="font-size:15px;">UID:-
                                            <?php echo $id; ?>
                                          </h5>
                                          <p style="margin-bottom:.5rem;">Approval
                                            Sts.: - <?php echo $approval_sts; ?>
                                          </p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="BoxD mar-bot">
                                    <div class="row">
                                      <div class="col-sm-10" style=" max-width: 100%; flex: 0 0 100%;">
                                        <table class="table" style="margin-bottom:0px">
                                          <tbody>
                                            <tr>
                                              <td colspan="3"
                                                style="font-size:16px; padding:.3rem 1px 0px;font-weight:700;border-bottom:2px solid #000;text-align:left;font-family: 'El Messiri', sans-serif; font-style:italic;">
                                                Visitor Info</td>
                                            </tr>
                                            <tr>
                                              <td id="tb" style="padding:0; height:2rem;text-align:left; width:45%;">
                                                <b>Visitor Name:-
                                                </b><?php echo $v_name; ?>
                                              </td>
                                              <td style="padding:0; height:2rem;text-align:left;">
                                                <b>Govt. Id:-
                                                </b><?php echo $v_govt_id; ?>
                                              </td>
                                              <th rowspan="4" scope="row txt-center" style="width:8rem;"><img
                                                  src="../upload/<?php echo $vlog_id; ?>.png" width="123px"
                                                  height="130px" onerror="this.src=<?php echo $dami_img; ?>" />
                                              </th>

                                            </tr>
                                            <tr>
                                              <td id="tb" style="padding:0; height:2rem;text-align:left; width:45%;">
                                                <b>Comopany:-
                                                </b><?php echo $v_c_name; ?>
                                              </td>
                                              <td style="padding:0; height:2rem;text-align:left;">
                                                <b>Mobile No :-
                                                </b><?php echo $v_mobile; ?>
                                              </td>

                                            </tr>
                                            <tr>
                                              <td id="tb" style="padding:0; height:2rem;text-align:left; width:45%;">
                                                <b>Designation:-
                                                </b><?php echo $v_desig; ?>
                                              </td>
                                              <td style="padding:0; height:2rem;text-align:left;">
                                                <b>Email:-
                                                </b><?php echo $v_email; ?>
                                              </td>

                                            </tr>
                                            <tr>
                                              <td id="tb" style="padding:0; height:2rem;text-align:left; width:45%;">
                                                <b>Address:-
                                                </b><?php echo $v_address; ?>
                                              </td>
                                              <td style="padding:0; height:2rem;text-align:left;">
                                                <b>Issued Id No:-
                                                </b><?php echo $v_c_no; ?>
                                              </td>

                                            </tr>
                                            <tr>
                                              <td id="tb" style="padding:0; height:2rem;text-align:left; width:45%;">
                                                <b>Visitor Type:-
                                                </b><?php echo $v_type; ?>
                                              </td>
                                              <td style="padding:0; height:2rem;text-align:left;">
                                                <b>Purpose:
                                                </b><?php echo $v_p; ?>
                                              </td>
                                              <td style="padding:0; height:2rem;text-align:left;">
                                                <b>Gate No:-
                                                </b><?php echo $v_g_no; ?>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td id="tb" style="padding:0; height:2rem;text-align:left; width:45%;">
                                                <b>Materials Carried:-
                                                </b><span
                                                  style="word-break: break-all;"><?php echo $v_mertial; ?></span>
                                              </td>
                                              <td style="padding:0; height:2rem;text-align:left;">
                                                <b>Vehicle Type(With
                                                  No):
                                                </b><?php echo $v_vehicle_type; ?>
                                              </td>
                                              <td style="padding:0; height:2rem;text-align:left;">
                                                <?php echo $v_vehicle_no; ?>
                                              </td>
                                            </tr>

                                          </tbody>
                                        </table>
                                      </div>

                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-10" style="max-width: 100%; flex: 0 0 100%;">
                                      <table class="table" style="margin:0;">
                                        <tbody>
                                          <tr>
                                            <td colspan="2"
                                              style="font-size:16px; padding: .3rem 1px 0px;font-weight:700;border-bottom:2px solid #000;text-align:left;font-family: 'El Messiri', sans-serif; font-style:italic;">
                                              TO Meet</td>
                                          </tr>
                                          <tr>
                                            <td id="tb" style="padding:0; height:2rem;text-align:left;">
                                              <b>Employe Code:-
                                              </b><?php echo $v_e_code; ?>
                                            </td>
                                            <td style="padding:0; height:2rem;text-align:left;">
                                              <b>Employe Name:-
                                              </b><?php echo $v_e_name; ?>
                                            </td>
                                            <!-- <td><b>DOB: </b>02 Jul 2019</td> -->
                                          </tr>
                                          <tr>
                                            <td id="tb" style="padding:0; height:2rem;text-align:left;">
                                              <b>Department:-
                                              </b><?php echo $v_e_depart; ?>
                                            </td>
                                            <td style="padding:0; height:2rem;text-align:left;">
                                              <b>Designation:-
                                              </b><?php echo $v_e_desig; ?>
                                            </td>
                                            <!-- <td><b>DOB: </b>02 Jul 2019</td> -->
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                    <!-- <!-- <div class="BoxA border- padding mar-bot">  -->
                                  </div>
                                  <div style="display:grid;    justify-content: end;">

                                    <?php if (strtotime(date("Y-m-d")) == strtotime($v_preschedul_date) && $empApprove == "Approve") {

                                      if ($preschedul_Image == 'Activate') {
                                        $formUrl = "preschedul_Image";
                                      } else {
                                        $formUrl = "preschedulImage";

                                      }

                                      ?>
                                      <form action="<?= $formUrl; ?>" method="post">
                                        <div class="user-entry">
                                          <input type="hidden" name="v_id" value="<?php echo $vlog_id; ?>" />
                                          <button type="submit"
                                            class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                            name="view_v"
                                            style="font:normal normal normal 14px/1 FontAwesome;font-size: 20px;padding:.2rem 1rem;">Next
                                            <i class="fa fa-arrow-right" style="    font-size: 20px;margin-right: 10px;">
                                            </i></button>
                                      </form>

                                    <?php } ?>

                                    <a href="view_visitor?id=1">
                                      <button class="btn waves-effect waves-light btn-inverse btn-outline-inverse"
                                        name="dept_update" style="padding:.2rem 1rem;"><i class="fa fa-arrow-left"
                                          style="font-size: 20px;margin-right: 10px;">
                                          Back </i></button>
                                    </a>

                                  </div>
                                </div>


                              </div>
                          </div>

                          </section>
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
  <?php include "include/footer.php"; ?>
</body>

</html>


<script>
  function randomString(length) {
    return Math.round((Math.pow(36, length + 1) - Math.random() * Math.pow(36, length))).toString(36).slice(1);
  }
  $(document).ready(function () {

    $("#vidcard").val(randomString(13).toUpperCase());

  });

  function showTime() {
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";

    if (h == 0) {
      h = 12;
    }

    if (h > 12) {
      h = h - 12;
      session = "PM";
    }

    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;

    var time = h + ":" + m + ":" + s + " " + session;
    document.getElementById("clock_span2").innerText = time;
    document.getElementById("clock_span2").textContent = time;

    setTimeout(showTime, 1000);

  }

  showTime();
</script>