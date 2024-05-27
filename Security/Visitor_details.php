<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head = "Visitor Info";
$des = "Page Load new_visitor_final";
$rem = "New visitor";
include '../include/_audi_log.php';

$visitor_log_id = "";
$visitor_data = "";
$gvt_id_type = "";
$gvt_id_no = "";
$name = "";
$company = "";
$desig = "";
$add = "";
$gmail = "";
$cont = "";
$id_no = "";
$visit_id = "";
$arr_time = "";
$arr_date = "";
$gate_no = "";
$arr_status = "";
$visit_purpose = "";
$meterial = "";
$visitor_type = "";
$emp_code = "";
$employee_name = "";
$employee_com = "";
$employee_depart = "";
$contact_no = "";
$vehical_type = "";
$vehical_no = "";
$issud_id_no = "";
$v_log_id = "";
$v_in_date = "";
$approval_sts = "Pending";
$check_in_sts = "";
$v_e_desig = "";
if (isset($_POST['view_v'])) {
  $visitor_id = $_POST['v_id'];
  $visit_data = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_log` where `visit_uid`='$visitor_id'"));
  if ($visit_data != "") {
    $check_in_sts = $visit_data['check_status'];
    $visitor_log_id = $visitor_id;
    $v_log_id = $visitor_id;
    $issud_id_no = $visit_data['id_card_no'];
    $gate_no = $visit_data['gate_no'];
    $v_time = $visit_data['checkin_time'];
    $arr_time = date("h:i:s A", strtotime($v_time));
    $v_date = $visit_data['checkin_date'];
    $v_in_date = date("d-M-Y", strtotime($v_date));
    $arr_status = ucfirst($visit_data['check_status']);
    $meterial = $visit_data['things_brought'];
    $v_vehicle_type = $visit_data['vehical_type'];
    $v_vehicle_no = $visit_data['vahical_num'];
    $v_emp_approve = $visit_data['Emp_approve'];
    $v_seq_approve = $visit_data['security_approval'];
    if ($v_emp_approve == "Approve" && $v_seq_approve == 'Approve') {
      $approval_sts = "Approve";
    } else if ($v_emp_approve == 'Reject' || $v_seq_approve == 'Reject') {
      $approval_sts = "Reject";

    }
    // echo $v_emp_approve;
    // echo  $v_seq_approve;
    // echo $approval_sts;
    $arrival_date_time = $visit_data['Arrival_time_stamp'];
    $prereg = $visit_data['pre_schedule_date'];
    if ($arrival_date_time == '0000-00-00 00:00:00') {
      $arr_time = "00:00:00";
      $v_in_date = date("d-M-Y", strtotime($prereg));
    } else if ($v_time == '00:00:00' && $arrival_date_time != '0000-00-00 00:00:00') {
      $arr_time = date("h:i:s A", strtotime($arrival_date_time));
      $v_in_date = date("d-M-Y", strtotime($arrival_date_time));
    }
    if ($check_in_sts == 'OUT') {

      $out_time = $visit_data['checkout_time'];
      $out_date = $visit_data['checkout_date'];
      if ($visit_data['checkout_time'] != "0000-00-00" && $visit_data['checkout_date'] != "0000-00-00") {
        // echo  $out_date;
        // echo $out_time;
        $check_out = date("d-M-Y h:i:s A", strtotime($out_date . ' ' . $out_time));
      } else {

        $check_out = "-:-:-";
      }
      $status = "Check Sts.:- " . $check_in_sts;
      $status = "Approval Sts.:- " . $approval_sts;
      // echo $status;
    } else {
      $check_out = "-:-:-";
      $status = "Approval Sts.:- " . $approval_sts;
    }

    $v_emp_code = $visit_data['emp_id'];
    include '../include/_approval.php';
    $end_meeting_sts = $end_status;

    $meeting_status = $visit_data['meeting_status'];


    // $meeting_status = $visit_data['meeting_status'];

    if ($end_meeting_sts == 'Pending') {
      if ($visit_data['meeting_end_by'] != "") {
        $emp_code_id = "";
        $user_code_id = $visit_data['meeting_end_by'];
        include '../include/_emp_details.php';
        $meeting_end_by = $emp_name;

      } else {
        $meeting_end_by = "";
      }
      if ($visit_data['meeting_status'] == 'Pending' && $check_in_sts == 'IN') {
        $meeting_end_sts = 'Going On';
        $meeting_end_date_time = "-:-:-";
      } else {
        $meeting_end_sts = $visit_data['meeting_status'];
        if ($visit_data['meeting_end_date'] != "0000-00-00" && $visit_data['meeting_end_time'] != "0000-00-00") {

          $meeting_end_date_time = date("d-M-Y h:i:s A", strtotime($visit_data['meeting_end_date'] . ' ' . $visit_data['meeting_end_time']));
        } else {
          $meeting_end_date_time = $check_out;

        }
      }
    } else {
      $meeting_end_by = "";
      $meeting_end_date_time = "";
      $meeting_end_sts = "";
    }








    $v_p = $visit_data['visit_purpose'];
    $visito_purpse_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visit_purpose` where `purpose_id` = '$v_p'"));
    if ($visito_purpse_sql != "") {

      $visit_purpose = $visito_purpse_sql['purpose'];
    } else {
      $visit_purpose = "";
    }

    $v_type = $visit_data['visitor_type'];
    $visit_type_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `vsitor_type` where `type_id` = '$v_type'"));
    if ($visit_type_sql != "") {

      $visitor_type = $visit_type_sql['type_name'];
    }


    $v_e_code = $visit_data['emp_id'];
    $emp_details = mysqli_fetch_assoc(mysqli_query($conn, "select *from `eomploye_details` where `Emp_code`='$v_e_code'"));
    if ($emp_details) {
      $employee_name = $emp_details['EmployeeName'];
      $contact_no = $emp_details['ContactNo'];
      $v_e_depart = $emp_details['DepartmentId'];
      $v_department_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `department` where `department_code`='$v_e_depart'"));
      if ($v_department_sql != "") {
        $employee_depart = $v_department_sql['department_name'];

      } else {
        $employee_depart = "";
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
        $employee_com = $company_sql['companyFname'];
      }

    }


    $visitor_details_id = $visit_data['visitor_id'];
    $visitor_details_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_info` where `visitor_id` = '$visitor_details_id'"));
    if ($visitor_details_sql != "") {
      $name = $visitor_details_sql['name'];
      $company = $visitor_details_sql['com_name'];
      $desig = $visitor_details_sql['designation'];
      $add = $visitor_details_sql['address'];
      $gmail = $visitor_details_sql['mail_id'];
      $cont = $visitor_details_sql['contact_no'];
      $v_govt_id = $visitor_details_sql['govt_id_no'];
      // $v_govt_id = $masked =  str_pad(substr($v_govt_id, -4), strlen($v_govt_id), '*', STR_PAD_LEFT);
    }
  }

} else {
  $_SESSION['icon'] = 'info';
  $_SESSION['status'] = 'Please Fill This Form At Fast';
  header("location:new_visitor1");
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
                    <div class="card" style="margin-bottom:0px;">
                      <div class="card-header" style="    padding: 0.5rem 1px 0.5rem 1.4rem;">
                        <div class="row" style="height:1.5rem;">
                          <div class="col-md-3" style="flex:0 0 40%; max-width:40%;">
                            <h5 style="width:90%">Visitor Details:-
                              <?php $v_id = explode('-', $visitor_log_id);
                              echo $v_id[1]; ?>
                            </h5>

                          </div>
                        </div>
                      </div>

                      <section class="animate pop">
                        <div class="container" style="padding:.5rem;">
                          <div class="admit-card">
                            <div class="BoxA border- padding mar-bot">
                              <div class="row">
                                <div class="col-sm-4" style="flex:0 0 33%; ">
                                  <h5 style="font-size:15px;">
                                    <?php if ($check_in_sts == "Pending" || $approval_sts == "Reject") {
                                      echo "Arrival ";
                                    } else {
                                      echo "IN ";
                                    } ?>Date-Time
                                    :-&nbsp; <span
                                      style="font-style: italic;"><?php echo $v_in_date . ' ' . $arr_time; ?></span>
                                  </h5>

                                </div>
                                <div class="col-sm-4 txt-center"
                                  style="flex:0 0 33%; max-width:50%; text-align: center;">
                                  <h5 style="font-size:15px;">Approval Sts.: -
                                    <?php echo $approval_sts; ?>
                                  </h5>
                                </div>
                                <div class="col-sm-4" style="flex:0 0 35%;">
                                  <h5 style="font-size:15px;">Out Date-Time :- <span
                                      style="font-style: italic;"><?php echo $check_out ?></span>
                                  </h5>

                                </div>
                              </div>
                            </div>
                            <?php if ($end_meeting_sts == "Pending") { ?>
                            <div class="BoxA border- padding mar-bot">
                              <div class="row">
                                <div class="col-sm-4" style="flex:0 0 33%; ">
                                  <h5 style="font-size:15px;">Meeting status :- <span
                                      style="font-style: italic;"><?php echo $meeting_end_sts ?></span>
                                  </h5>

                                </div>
                                <div class="col-sm-4 txt-center"
                                  style="flex:0 0 33%; max-width:50%; text-align: center;">
                                  <h5 style="font-size:15px;">Meeting End By : -
                                    <?php echo $meeting_end_by; ?>
                                  </h5>
                                </div>
                                <div class="col-sm-4" style="flex:0 0 35%;">
                                  <h5 style="font-size:15px;">End Date-Time :- <span
                                      style="font-style: italic;"><?php echo $meeting_end_date_time ?></span>
                                  </h5>

                                </div>
                              </div>
                            </div>
                            <?php } ?>

                            <div class="BoxD mar-bot">
                              <div class="row">
                                <div class="col-sm-10" style=" max-width: 100%; flex: 0 0 100%;">
                                  <table class="table" style="margin-bottom:0px">
                                    <tbody>
                                      <tr>
                                        <td colspan="3"
                                          style="font-size:19px; padding:0rem;font-family: 'Aboreto', cursive;font-weight:700;border-bottom:2px solid #000;text-align:left;font-family: 'El Messiri', sans-serif; font-style:italic;">
                                          Visitor Info</td>
                                      </tr>
                                      <tr>
                                        <td id="tb"
                                          style="padding:0;padding-left: 1rem; height:2rem;text-align:left; width:45%;">
                                          <b>Visitor Name:-
                                            &nbsp;</b><?php echo $name; ?>
                                        </td>
                                        <td style="padding:0; height:2rem;text-align:left;">
                                          <b>Govt. Id:-
                                            &nbsp;</b><?php echo $v_govt_id; ?>
                                        </td>
                                        <th rowspan="4" scope="row txt-center" style="width:8rem;"><img
                                            src="../upload/<?php echo $visitor_id; ?>.png" width="103px" height="100px"
                                            onerror="this.src='../src/error.png'" />
                                        </th>

                                      </tr>
                                      <tr>
                                        <td id="tb"
                                          style="padding:0;padding-left: 1rem; height:2rem;text-align:left; width:45%;">
                                          <b>Comopany:-
                                            &nbsp;</b><?php echo $company; ?>
                                        </td>
                                        <td style="padding:0; height:2rem;text-align:left;">
                                          <b>Mobile No :-
                                            &nbsp;</b><?php echo $cont; ?>
                                        </td>

                                      </tr>
                                      <tr>
                                        <td id="tb"
                                          style="padding:0;padding-left: 1rem; height:2rem;text-align:left; width:45%;">
                                          <b>Designation:-
                                            &nbsp;</b><?php echo $desig; ?>
                                        </td>
                                        <td style="padding:0; height:2rem;text-align:left;">
                                          <b>Email:-
                                            &nbsp;</b><?php echo $gmail; ?>
                                        </td>

                                      </tr>
                                      <tr>
                                        <td id="tb"
                                          style="padding:0;padding-left: 1rem; height:2rem;text-align:left; width:45%;">
                                          <b>Address:-
                                            &nbsp;</b><?php echo $add; ?>
                                        </td>
                                        <td style="padding:0; height:2rem;text-align:left;">
                                          <b>Issued Id No:-
                                            &nbsp;</b><?php echo $issud_id_no; ?>
                                        </td>

                                      </tr>
                                      <tr>
                                        <td id="tb"
                                          style="padding:0;padding-left: 1rem; height:2rem;text-align:left; width:45%;">
                                          <b>Visitor Type:-
                                            &nbsp;</b><?php echo $visitor_type; ?>
                                        </td>
                                        <td style="padding:0; height:2rem;text-align:left;">
                                          <b>Purpose:
                                            &nbsp;</b><?php echo $visit_purpose; ?>
                                        </td>
                                        <td style="padding:0; height:2rem;text-align:left;">
                                          <b>Gate No:-
                                            &nbsp;</b><?php echo $gate_no; ?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td id="tb"
                                          style="padding:0;padding-left: 1rem; height:2rem;text-align:left; width:45%;">
                                          <b>Mterials Carried:-
                                            &nbsp;</b><span
                                            style="word-break: break-all;"><?php echo $meterial; ?></span>
                                        </td>
                                        <td style="padding:0; height:2rem;text-align:left;">
                                          <b>Vehicle Type(With No):
                                            &nbsp;</b><?php echo $v_vehicle_type; ?>
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
                                <table class="table" style="margin-bottom:0;">
                                  <tbody>
                                    <tr>
                                      <td colspan="2"
                                        style="font-size:19px; padding:0rem;font-family: 'Aboreto', cursive;font-weight:700;border-bottom:2px solid #000;text-align:left;font-family: 'El Messiri', sans-serif; font-style:italic;">
                                        TO Meet</td>
                                    </tr>
                                    <tr>
                                      <td id="tb" style="padding:0;padding-left: 1rem; height:2rem;text-align:left;">
                                        <b>Employe Code:-
                                          &nbsp;</b><?php echo $v_e_code; ?>
                                      </td>
                                      <td style="padding:0; height:2rem;text-align:left;">
                                        <b>Employe Name:-
                                          &nbsp;</b><?php echo $employee_name; ?>
                                      </td>
                                      <!-- <td><b>DOB: </b>02 Jul 2019</td> -->
                                    </tr>
                                    <tr>
                                      <td id="tb" style="padding:0;padding-left: 1rem; height:2rem;text-align:left;">
                                        <b>Department:-
                                          &nbsp;</b><?php echo $employee_depart; ?>
                                      </td>
                                      <td style="padding:0; height:2rem;text-align:left;">
                                        <b>Designation:-
                                          &nbsp;</b><?php echo $v_e_desig; ?>
                                      </td>
                                      <!-- <td><b>DOB: </b>02 Jul 2019</td> -->
                                    </tr>
                                  </tbody>
                                </table>
                              </div>

                            </div>
                          </div>
                        </div>
                      </section>
                      <div class="card-block " style=" padding-top:0;">
                        <div class="user-entry"
                          style="margin-right: 1.3rem; display:flex; width:30rem;place-content: end;">
                          <?php if ($approval_sts == "Approve") { ?>
                          <select class="form-control" name="" id="url" style="margin-right:1rem;height:40%" autofocus>
                            <option value="" selected disabled hidden>Select Print Option
                            </option>
                            <!-- <?php if ($check_in_sts != "OUT") { ?> -->
                            <!-- <?php } ?> -->
                            <option value="new_visit_token">Short Token Print</option>
                            <option value="new_visit_token_with_rules">Token Print</option>
                            <option value="new_visit_short_recipt">Short Info Print</option>
                            <option value="new_visit_recipt">Info Print</option>
                          </select>


                          <button class="btn waves-effect waves-light btn-primary btn-outline-primary" id="print_url"
                            style="width:60%; margin-right:1rem;height:2.1rem; padding:0rem;"><i class="fa fa-print"
                              style="    font-size: 20px;margin-right: 10px;"></i>Print</button>

                          <a href="view_visitor" style="width:25%;  ">
                            <button class="btn waves-effect waves-light btn-inverse btn-outline-inverse"
                              style="height:2.1rem; padding:5px "><i class="fa fa-arrow-left"
                                style="    font-size: 20px;margin-right: 10px;"></i>Back</button>
                          </a>
                          <?php } else { ?>

                          <a href="view_visitor" style="width:25%; display:grid; "><button
                              class="btn waves-effect waves-light btn-inverse btn-outline-inverse" style="padding:5px;">
                              <i class="fa fa-arrow-left"
                                style="font-size: 20px;margin-right: 10px;"></i>Back</button></a>
                          <?php } ?>
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

<script>
$("#print_url").click(function(e) {
  // e.preventDefault();
  var url = $("#url").val();
  url = url + "?id=<?php echo $v_log_id; ?>-";

  printExternal(url);


})

function printExternal(url) {
  window.open(url, "print", "width=800, height=800, scrollbars=yes");


}
</script>