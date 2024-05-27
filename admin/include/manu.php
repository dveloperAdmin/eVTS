<?php
$log_pout = "Active5";
include '../include/_dbconnect.php';
$user_id = $_SESSION['user_id'];
$reffer = "";
$user_data_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `uid`='$user_id'"));
$emp_id = $user_data_sql['EmployeeId'];
$user_name = $user_data_sql['name'];
$user_role = $user_data_sql['user_role'];
if ($user_name != "ADMIN") {

  $emp_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` where `EmployeeId` = '$emp_id'"));
  $com_code = $emp_details['CompanyId'];
  $branchCode = $emp_details['BranchId'];
  $emp_code = $emp_details['Emp_code'];
  $_SESSION['emp_code'] = $emp_details['Emp_code'];
  $approval = "Deactivate";
  $check_approve_status = mysqli_fetch_assoc(mysqli_query($conn, "select * from `approval_sts` where `branch_id` = '$branchCode'"));
  if ($check_approve_status != "") {
    $approval = $check_approve_status['Approve_status'];
    // echo "$approval";
    $reffer = $check_approve_status['referral_status'];

  }
  $check_pending_number = mysqli_num_rows(mysqli_query($conn, "select * from `visitor_log` where `emp_id`='$emp_code' and `Emp_approve`='Pending'"));
} else {
  $_SESSION['emp_code'] = "";
  $approval = "Activate";
  $check_pending_number = 0;
}
?>
<nav class="pcoded-navbar">
  <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
  <div class="pcoded-inner-navbar main-menu">
    <div class="">
      <div class="main-menu-header">
        <img class="img-80 img-radius" src="assets/images/458.jpg" alt="User-Profile-Image">
        <div class="user-details">
          <span id="more-details"><?php if ($user_data_sql['name'] != 'ADMIN') {
            echo ucfirst($user_data_sql['user_role']);
          } else {
            echo 'Developer';
          } ?></span>
        </div>
      </div>
      <!-- <div class="main-menu-content">
                <ul>
                    <li class="more-details">
                        <a href="user-profile.html"><i class="ti-user"></i>Change Password</a>
                         <a href="#!"><i class="ti-settings"></i>Settings</a>
                        <a href="auth-normal-sign-in.html"><i class="ti-lock"></i>Logout</a>
                    </li>
                </ul>
            </div> -->
    </div>

    <div class="pcoded-navigation-label"></div>
    <ul class="pcoded-item pcoded-left-item">
      <li class="">
        <a href="index" class="waves-effect waves-dark">
          <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
          <span class="pcoded-mtext">Dashboard</span>
          <span class="pcoded-mcaret"></span>
        </a>
      </li>
      <?php if ($approval == 'Activate' && $user_role != 'Developer') { ?>
      <li class="">
        <a href="view_visitor?id=1" class="waves-effect waves-dark">
          <span class="pcoded-micon"><i class="fa fa-commenting"></i><b>D</b></span>
          <span class="pcoded-mtext">Notification <?php if ($check_pending_number >= 1) { ?><i class="fa fa-circle"
              id="blink_me" style="margin-left: 4.5rem; color: #36d000;font-size: 12px;"></i><?php } ?></span>
          <span class="pcoded-mcaret"></span>
        </a>
      </li>
      <?php } ?>

      <!-- <li class="">
                <a href="form-elements-component.html" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                    <span class="pcoded-mtext">Form</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li> -->

      <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
          <span class="pcoded-micon"><i class="icofont icofont-ui-settings m-r-15 text-c-black"></i></span>
          <span class="pcoded-mtext">Master Setup</span>
          <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
          <?php if (in_array($user_role, array("Developer", "Super Admin"))) { ?>
          <li class=" ">
            <a href="branch" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Branch</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <?php } ?>
          <li class=" ">
            <a href="department" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Department</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>

          <li class=" ">
            <a href="sub-department" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Sub-Department</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>

          <li class=" ">
            <a href="designation" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Designation</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>

          <li class=" ">
            <a href="grade" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Grade</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>

          <li class=" ">
            <a href="location" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Location</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <?php if (in_array($user_role, array("Developer", "Super Admin"))) { ?>
          <li class=" ">
            <a href="emp-type" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Employee Type</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li class=" ">
            <a href="emp-cat" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Employee Category</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <?php } ?>
          <li class=" ">
            <a href="visitor-type" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Visitor Type</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li class=" ">
            <a href="visitor-purpose" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Visit Purpose</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li class=" ">
            <a href="gate_info" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Gate NO</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <?php if (in_array($user_role, array("Developer", "Super Admin"))) { ?>
          <li class=" ">
            <a href="important_rules" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Importent Rules</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <?php } ?>


        </ul>
      </li>



      <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
          <span class="pcoded-micon"><i class="icofont icofont-address-book" style="font-size: 20px;"></i></span>
          <span class="pcoded-mtext">Employee Info </span>
          <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
          <li class=" ">
            <a href="empDashbord" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Employee Dashbord </span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li class=" ">
            <a href="new-employe" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Add Employee </span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li class=" ">
            <a href="employe-view" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Employee List</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>

          <li class=" ">
            <a href="export_emp " class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Export Emp. Info </span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
        </ul>
      </li>

      <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
          <span class="pcoded-micon"><i class="icofont icofont-users" style="font-size: 20px;"></i></span>
          <span class="pcoded-mtext">User Info </span>
          <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
          <li class=" ">
            <a href="new-user" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">New Users</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>

          <li class=" ">
            <a href="user_view" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Users List</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li class=" ">
            <a href="change_pass" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Reset User PWD</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>

        </ul>
      </li>
      <?php if ($user_data_sql['name'] != 'ADMIN') { ?>
      <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
          <span class="pcoded-micon"><i class="fa fa-id-badge" style="font-size: 20px;"></i></span>
          <span class="pcoded-mtext">Visitor</span>
          <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">

          <li class=" ">
            <a href="visitor_info" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Visitor Info</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li class=" ">
            <a href="new_visitor1" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Pre Schedule</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li class=" ">
            <a href="view_visitor" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">My Visitor Log</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <?php if ($reffer == 'Activate') { ?>
          <li class=" ">
            <a href="view_refer_visitor" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Reffer Visitor Log</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <?php } ?>
          <li class=" ">
            <a href="viewVisitor" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Total Visitor Log</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>



        </ul>
      </li>

      <?php } ?>
      <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
          <span class="pcoded-micon"><i class="icofont icofont-prescription" style="font-size: 20px;"></i></span>
          <span class="pcoded-mtext">Report </span>
          <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">

          <li class=" ">
            <a href="audit_log_report" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Audit Log Report </span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li class=" ">
            <a href="visitor_info_report" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Visitor Info Report</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li class=" ">
            <a href="visitor_report" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Visitor Log Report</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>

          <li class=" ">
            <a href="log_report" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Log Report</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>

        </ul>
      </li>
      <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
          <span class="pcoded-micon"><i class="icofont icofont-database" style="font-size: 20px;"></i></span>
          <span class="pcoded-mtext">Database</span>
          <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
          <li class=" ">
            <a href="db_backup" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Database Backup</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>


        </ul>
      </li>
      <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
          <span class="pcoded-micon"><i class="icofont icofont-qr-code" style="font-size: 20px;"></i></span>
          <span class="pcoded-mtext">License Info</span>
          <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
          <li class=" ">
            <a href="about_license" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">About License</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li class=" ">
            <a href="license_extends" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">License Extend</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>


        </ul>
      </li>
      <?php if ($user_data_sql['name'] == 'ADMIN') { ?>
      <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
          <span class="pcoded-micon"><i class="icofont icofont-user-alt-5" style="font-size: 20px;"></i></span>
          <span class="pcoded-mtext">Developer</span>
          <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
          <li class=" ">
            <a href="company" class="waves-effect waves-dark">

              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Company</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li class=" ">
            <a href="approval" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Aproval Status </span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li class=" ">
            <a href="dev" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Log out Timing </span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li class=" ">
            <a href="import_emp" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Import Emp. Info </span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li class=" ">
            <a href="db_formate" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Formate Database</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>


        </ul>
      </li>
      <?php } ?>


  </div>
</nav>