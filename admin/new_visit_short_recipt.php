<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
// include '../include/_company.php';
$head = "Visitor Info";
$des = "Page Load new_visit_recipt";
$rem = "New visitor";
include '../include/_audi_log.php';
include '../include/_function.php';
$company_name = "";

$v_name = "";
$v_c_name = "";
$v_c_no = "";
$v_g_no = "";
$v_p = "";
$v_type = "";
$v_e_code = "";
$v_e_name = "";
$v_time = "";
$o_time = "";
$o_time_p = "";
$v_date = "";
$v_sts = "";
$v_desig = "";
$v_address = "";
$v_email = "";
$v_mobile = "";
$v_govt_id = "";
$v_mertial = "";
$v_vehicle_type = "";
$v_vehicle_no = "";
$v_e_depart = "";
$v_e_desig = "";
$empName = "";
$branchCode = "";
$user_id = $_SESSION['user_id'];
$user_data_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `uid`='$user_id'"));
$sequrity_name = $user_data_sql['name'];

$id = explode("-", rtrim($_SERVER['REQUEST_URI']));
$id = $id[1];
$visit_id = "VSL-" . $id;
$visit_data = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_log` where `visit_uid`='$visit_id'"));
if ($visit_data != "") {
  if ($visit_data['checkin_time'] != "00:00:00") {

    $check_time = $visit_data['checkin_time'];
    $check_date = date("Y-m-d");
  } else {
    $check_date = date("Y-m-d");
    $check_time = date("H:i:s");

  }
  $emp_code_id = "";
  $user_code_id = $user_id;
  include "../include/_emp_details.php";
  $refer_by_user_id = $emp_code_user_id;
  $refer_to_user_id = $visit_data['emp_id'];

  $today = date("Y-m-d");
  $time = date("H:i:s");
  $v_emp_code = $visit_data['emp_id'];
  include '../include/_approval.php';
  $emp_visit_status = $emp_status;
  $end_sts = $end_status;

  if ($visit_data['check_status'] != "OUT" && $visit_data['check_in_by'] == "") {
    mysqli_query($conn, "update `visitor_log` set `check_status`='IN', `check_in_by`='$user_id', `checkin_date`='$check_date', `checkin_time`='$check_time', `meeting_status`='$end_sts' where `visit_uid` ='$visit_id'");
    mysqli_query($conn, "insert into `meeting_referrable`(`refer_by`, `refer_to`, `refer_visitor`, `refer_date`, `refer_time`, `reffer_status`, `visitor_enetry`) values ('$refer_by_user_id','$refer_to_user_id','$visit_id','$today','$time','Entry', 'Register')");

  }

  $visit_data = mysqli_fetch_assoc(mysqli_query($conn, "select visitor_log.*,coalesce(eomploye_details.EmployeeName, 'Not exsist') as EmployeeName  from `visitor_log` left join eomploye_details on visitor_log.emp_id = eomploye_details.Emp_code where visitor_log.`visit_uid`='$visit_id'"));

  $v_c_no = $visit_data['id_card_no'];
  $v_g_no = $visit_data['gate_no'];
  $v_time = $visit_data['checkin_time'];
  $v_time_p = date("h:i:s A", strtotime($v_time));
  $o_time = $visit_data['checkout_time'];
  $o_time_p = date("h:i:s A", strtotime($o_time));
  $v_date = $visit_data['checkin_date'];
  $v_date_p = date("d-M-Y", strtotime($v_date));
  $branchCode = $visit_data['branch_id'];


  $vEmpApproveSts = $visit_data['Emp_approve'];
  $empName = $visit_data['EmployeeName'];
  $checkInBY = $visit_data['check_in_by'];
  $v_sts = ucfirst($visit_data['check_status']);
  $v_mertial = $visit_data['things_brought'];
  $v_vehicle_type = $visit_data['vehical_type'];
  $v_vehicle_no = $visit_data['vahical_num'];

  $securitydetails = mysqli_fetch_assoc((mysqli_query($conn, "select * from `user` where `uid`='$checkInBY'")));
  if ($securitydetails != "") {
    $sequrity_name = $securitydetails['name'];

  } else {

    $sequrity_name = "Not Found";
  }


  // $arrival_date_time =$visit_data['Arrival_time_stamp'];
  // $prereg = $visit_data['pre_schedule_date'];
  // if($arrival_date_time == '0000-00-00 00:00:00'){
  // 	$v_time_p = "00:00:00";
  // 	$v_date_p = date("d-M-Y", strtotime($prereg));
  // }else if($v_time == '00:00:00' && $arrival_date_time != '0000-00-00 00:00:00'){
  // 	$v_time_p = date("h:i:s A", strtotime($arrival_date_time));
  // 	$v_date_p = date("d-M-Y", strtotime($arrival_date_time));
  // }


  $v_p = $visit_data['visit_purpose'];
  $visito_purpse_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visit_purpose` where `purpose_id` = '$v_p'"));
  if ($visito_purpse_sql != "") {

    $v_p = $visito_purpse_sql['purpose'];
  } else {
    $v_p = "";
  }

  $v_type = $visit_data['visitor_type'];
  $visit_type_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `vsitor_type` where `type_id` = '$v_type'"));
  if ($visit_type_sql != "") {
    $v_type = $visit_type_sql['type_name'];

  } else {
    $v_type = "";
  }


  $v_e_code = $visit_data['emp_id'];
  $emp_details = mysqli_fetch_assoc(mysqli_query($conn, "select *from `eomploye_details` where `Emp_code`='$v_e_code'"));
  if ($emp_details) {
    $v_e_name = $emp_details['EmployeeName'];
    $v_e_depart = $emp_details['DepartmentId'];
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


  }
  $company_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `company_details`"));
  if ($company_sql != "") {
    $company_name = $company_sql['companyFname'];
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

  //count prints
  $print_of = $visit_id;
  $print_type = "Short Info";
  include '../include/_count_print.php';
}




?>





<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="assets/css/recipt_6.css">
  <title>Visit Info</title>
  <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
  <link
    href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@700&family=Josefin+Sans:ital,wght@1,700&family=Noto+Serif:ital,wght@1,600&family=Raleway:ital,wght@0,800;1,500&display=swap"
    rel="stylesheet">
  <style>
  @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&family=Lora:ital,wght@0,400..700;1,400..700&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Oleo+Script:wght@400;700&family=Orbitron:wght@400..900&family=Oswald:wght@200..700&display=swap');
  </style>


</head>

<body>
  <div style="display:flex; margin:1rem;">
    <button id="btnPrint" class="hidden-print">Print</button>
    <button id="btnClose" class="hidden-print" style="margin-left:1rem;cursor:pointer;">Close</button>

  </div>
  <section>
    <div class="container">
      <div class="admit-card">
        <div class="BoxA border- padding mar-bot" style="padding:7px;">
          <div class="row">
            <div class="col-sm-4" style="flex:0 0 30%;  padding-right:0px">
              <h5>Date :- <?= $v_date_p; ?></h5>
              <?php if ($v_sts === "OUT") { ?>
              <p>Time:- <span style="font-size:14px;"><?= $v_time_p . " - " . $o_time_p; ?></span> </p>

              <?php } else { ?>
              <p>In time: - <?= $v_time_p; ?> </p>

              <?php } ?>
            </div>
            <div class="col-sm-4 txt-center" style="flex:0 0 33%; max-width:50%">
              <span
                style="font-family: 'El Messiri', sans-serif; font-size:25px"><?= strtoupper($company_name) . '<span style="font-size: 18px; font-weight: 500; font-style: italic;"> ( ' . findBranch($conn, $branchCode) . ' )</span>'; ?>
                </spna>
            </div>
            <div class="col-sm-4" style="flex:0 0 20%">
              <h5>UID:- <?php echo $id; ?></h5>
              <p>Arrive Sts.: - <?php echo $v_sts; ?> </p>
            </div>
          </div>
        </div>

        <div class="BoxD mar-bot">
          <div class="row">
            <div class="col-sm-10">
              <table class="table">
                <tbody>
                  <tr>
                    <td colspan="3"
                      style="font-size:24px;font-family: 'El Messiri', sans-serif; font-weight:700;border-bottom:2px solid #000; padding-bottom:0px; font-style:italic;">
                      Visitor Info
                    </td>
                  </tr>
                  <tr>
                    <td id="tb" style="padding:.2rem .5rem;"><b>Visitor Name:- </b><?php echo $v_name; ?> </td>
                    <td style="padding:.2rem .5rem;"><b>Issued Id No:- </b><?php echo $v_c_no; ?></td>
                    <th rowspan="4" scope="row txt-center" style="width:8rem;"><img
                        src="../upload/<?php echo $visit_id; ?>.png" width="123px" height="120px"
                        onerror="this.src='../src/error.png';" /></th>

                  </tr>
                  <tr>
                    <td id="tb" style="padding:.2rem .5rem;"><b>Comopany:- </b><?php echo $v_c_name; ?></td>
                    <td style="padding:.2rem .5rem;"><b>Designation:- </b><?php echo $v_desig; ?></td>
                    <!-- <td><b>Sex: </b>M</td> -->
                  </tr>

                  <tr>
                    <td id="tb" style="padding:.2rem .5rem;"><b>Address:- </b><?php echo $v_address; ?></td>
                    <td style="padding:.2rem .5rem;"><b>Gate No:- </b><?php echo $v_g_no; ?></td>
                    <!-- <td><b>DOB: </b>02 Jul 2019</td> -->
                  </tr>
                  <tr>
                    <td id="tb" style="padding:.2rem .5rem;"><b>Visitor Type:- </b><?php echo $v_type; ?></td>
                    <td style="padding:.2rem .5rem;"><b>Purpose: </b><?php echo $v_p; ?></td>

                  </tr>
                  <!-- <tr>
                <td id="tb"><b>Mterials Carried:- </b><span style="word-break: break-all;"><?php echo $v_mertial; ?></span></td>
                <td><b>Vehicle Type(With No): </b><?php echo $v_vehicle_type; ?></td>
                <td><?php echo $v_vehicle_no; ?></td>
              </tr> -->

                </tbody>
              </table>
            </div>

          </div>
        </div>
        <div class="row">
          <div class="col-sm-10">
            <table class="table">
              <tbody>
                <tr>
                  <td colspan="2"
                    style="font-size:24px;font-family: 'El Messiri', sans-serif; font-weight:700;border-bottom:2px solid #000; padding-bottom:0px; font-style:italic;">
                    TO Meet</td>
                </tr>
                <tr>
                  <!-- <td ><b>Employe Code:- </b><?php echo $v_e_code; ?></td> -->
                  <td id="tb"><b>Employe Name:- </b><?php echo $v_e_name;
                  ?>
                  </td>
                  <td><b>Department:- </b><?php echo $v_e_depart;
                  if ($v_e_desig != "") {
                    echo " - " . $v_e_desig;
                  } ?></td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>
        <div style="display:flex;padding: 2rem; padding-bottom:1rem;">

          <div class="centered" style="flex:0 0 33%; padding-left:0;">
            <div class="signed" style="font-weight:700;text-decoration-line: underline;">Auth. Signature</div>
            <div
              style="word-break: break-all;  font-family: 'Lobster Two', sans-serif;etter-spacing: 1.5px;font-style: italic;">
              <?php
              if ($vEmpApproveSts == 'Approve') {
                echo ucwords($empName);
              } else {
                echo " ";
              }
              ?>

            </div>
          </div>
          <div class="centered" style="flex:0 0 34%; padding-left:0; text-align:center">
            <div class="signed" style="font-weight:700;text-decoration-line: underline;">Visitor Signature</div>
            <div
              style="word-break: break-all;  font-family: 'Lobster Two', sans-serif;etter-spacing: 1.5px;font-style: italic;">
              <?php
              if ($v_sts != 'Pending') {
                echo ucwords($v_name);
              } else {
                echo " ";
              }
              ?>

            </div>
          </div>
          <div class="centered" style="float:right; flex:0 0 33%; text-align:end;">
            <div class="signed" style="font-weight:700;text-decoration-line: underline;">Secq. Signature</div>

            <div
              style="word-break: break-all;font-family: 'Lobster Two', sans-serif;etter-spacing: 1.5px;font-style: italic;">
              <?php echo ucwords($sequrity_name); ?>
            </div>
          </div>
        </div>

      </div>
    </div>

  </section>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
</body>

</html>
<script>
const $btnPrint = document.querySelector("#btnPrint");
$btnPrint.addEventListener("click", () => {
  window.print();
});
const $btnClose = document.querySelector("#btnClose");
$btnClose.addEventListener("click", () => {
  window.close();
});
</script>