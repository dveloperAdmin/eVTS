<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
include '../include/_company.php';
$head = "Visitor Info";
$des = "Page Load new_visit_token";
$rem = "New visitor";
include '../include/_audi_log.php';
include '../include/_function.php';
$rules_sql = mysqli_query($conn, "select * from `rules`");
$company_name = "";

$v_name = "";
$v_c_name = "";
$v_c_no = "";
$v_g_no = "";
$v_p = "";
$empName = "";
$v_time = "";
$v_date = "";
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
  // echo $check_date;
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
    mysqli_query($conn, "insert into `meeting_referrable`(`refer_by`, `refer_to`, `refer_visitor`, `refer_date`, `refer_time`, `reffer_status`,`visitor_enetry`) values ('$refer_by_user_id','$refer_to_user_id','$visit_id','$today','$time','Entry', 'Register')");
  }
  $visit_data = mysqli_fetch_assoc(mysqli_query($conn, "select visitor_log.*,coalesce(eomploye_details.EmployeeName, 'Not exsist') as EmployeeName   from `visitor_log` left join eomploye_details on visitor_log.emp_id = eomploye_details.Emp_code where visitor_log.`visit_uid`='$visit_id'"));

  $v_c_no = $visit_data['id_card_no'];
  $v_g_no = $visit_data['gate_no'];
  $v_time = $visit_data['checkin_time'];
  $o_time = $visit_data['checkout_time'];
  $o_time = date("h:i:s A", strtotime($o_time));
  $v_time = date("h:i:s A", strtotime($v_time));
  $v_date = $visit_data['checkin_date'];
  $v_date = date("d-M-Y", strtotime($v_date));
  $vEmpApproveSts = $visit_data['Emp_approve'];
  $empName = $visit_data['EmployeeName'];
  $checkInBY = $visit_data['check_in_by'];
  $branchCode = $visit_data['branch_id'];
  $checkSts = $visit_data['check_status'];

  $securitydetails = mysqli_fetch_assoc((mysqli_query($conn, "select * from `user` where `uid`='$checkInBY'")));
  if ($securitydetails != "") {
    $sequrity_name = $securitydetails['name'];

  } else {

    $sequrity_name = "Not Found";
  }

  $v_p = $visit_data['visit_purpose'];
  $visito_purpse_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visit_purpose` where `purpose_id` = '$v_p'"));
  if ($visito_purpse_sql != "") {

    $v_p = $visito_purpse_sql['purpose'];
  } else {
    $v_p = "";
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
  }

  //count prints
  $print_of = $visit_id;
  $print_type = "Token";
  include '../include/_count_print.php';




}




?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="assets/css/token_4.css">
  <title>Visit Token </title>
  <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
  <link
    href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@700&family=Josefin+Sans:ital,wght@1,700&family=Noto+Serif:ital,wght@1,600&family=Raleway:ital,wght@0,800;1,500&display=swap"
    rel="stylesheet">
</head>

<body onload="zoom()">
  <div class="ticket">
    <!-- <img src="./logo.png" alt="Logo"> -->
    <div style="display: flex;padding:.3rem .3rem 0 .3rem ;">
      <span style="flex:0 0 50%;"><?php echo $v_date; ?></span>
      <span style="flex:0 0 50%;text-align:end;float:right; font-weight:700;"><?php echo $id; ?></span>

    </div>
    <div class="com_head" style="    padding: 1rem 0 .5rem 0;">
      <span
        style="font-family: 'El Messiri', sans-serif;"><?php echo strtoupper($company_name) . '<span style="font-size: 13px; font-weight: 500; font-style: italic;"> ( ' . findBranch($conn, $branchCode) . ' )</span>'; ?>
        </spna>
    </div>
    <!-- <p class="centered">
                <br>Address line 1
                <br>Address line 2</p> -->
    <table>

      <tbody>
        <tr>
          <th class="quantity">Name:</th>
          <td class="description"><?php echo ucfirst($v_name); ?></td>

        </tr>
        <tr>
          <th class="quantity">Company:</th>
          <td class="description"><?php echo $v_c_name; ?> </td>

        </tr>
        <tr>
          <th class="quantity">Purpose:</th>
          <td class="description"><?php echo $v_p; ?></td>

        </tr>
        <tr>
          <th class="quantity">To Meet:</th>
          <td class="description"><?php echo $empName; ?></td>

        </tr>
        <tr>
          <th class="quantity">In Time:</th>
          <td class="description"><?php echo $v_time; ?></td>

        </tr>
        <?php if ($checkSts === "OUT") { ?>
          <tr>
            <th class="quantity">Out Time:</th>
            <td class="description"><?php echo $o_time; ?></td>

          </tr>
        <?php } ?>
        <tr>
          <th class="quantity">Gate No:</th>
          <td class="description"><?php echo $v_g_no; ?></td>

        </tr>
        <tr>
          <th class="quantity">Card NO:</th>
          <td class="description"><?php echo $v_c_no; ?></td>

        </tr>
        <tr></tr>
      </tbody>
    </table>
    <div style="display:flex;">

      <p class="centered" style="flex:0 0 48%; padding-left:0;"><span class="signed">Auth. Signature</span><br>
        <span style="word-break: break-all;"><?php
        if ($vEmpApproveSts == 'Approve') {
          echo ucwords($empName);
        } else {
          echo " ";
        }
        ?></span>
      </p>
      <p class="centered" style="float:right; flex:0 0 50%"><span class="signed">Secq. Signature</span>
        <br><span style="word-break: break-all;"><?php echo $sequrity_name; ?></span>
      </p>
    </div>

    <!-- <div style=" display: grid; place-items: center;padding: 1rem;">
                <span>
                    * Please return the slip before exit
                </span>
            </div> -->
    <footer class="txt-center">
      <p>
      <h5 style="border-bottom:2px solid black; margin:0; text-align:center;">*** Inportant Information ***</h5>
      </p>


    </footer>
    <div style="padding-left: 1rem; padding-bottom:1rem;  ">
      <?php $i = 0;
      while ($rules = mysqli_fetch_assoc($rules_sql)) {
        if ($rules != "") {
          $i++ ?>
          <p style="font-weight:700; font-size:10px; color:red;     text-align: justify;   margin-right: 1rem;">
            <?php echo $i . ". " . $rules['rules']; ?>
          </p>
        <?php }
      } ?>

    </div>
  </div>
  <div style="display:flex; margin:1rem;">
    <button id="btnPrint" class="hidden-print">Print</button>
    <button id="btnClose" class="hidden-print" style="margin-left:1rem;cursor:pointer;">Close</button>

  </div>

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

  function zoom() {
    document.body.style.zoom = "140%"
  }
</script>