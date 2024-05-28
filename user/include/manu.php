<?php
include '../include/_dbconnect.php';
$user_id = $_SESSION['user_id'];
$check_pending_number = 0;
$approval = "";
$refer = "";
$user_data_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `uid`='$user_id'"));
$emp_id = $user_data_sql['EmployeeId'];
$emp_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` where `EmployeeId` = '$emp_id'"));
if ($emp_details != "") {
  $com_code = $emp_details['CompanyId'];
  $branchCode = $emp_details['BranchId'];
  $emp_code = $emp_details['Emp_code'];
  $_SESSION['emp_code'] = $emp_details['Emp_code'];
  $approval = "Deactivate";
  $check_approve_status = mysqli_fetch_assoc(mysqli_query($conn, "select * from `approval_sts` where `branch_id` = '$branchCode'"));
  if ($check_approve_status != "") {
    $approval = $check_approve_status['Approve_status'];
    // echo "$approval";
    $refer = $check_approve_status['referral_status'];

  }
  $check_pending_number = mysqli_num_rows(mysqli_query($conn, "select * from `visitor_log` where `emp_id`='$emp_code' and `Emp_approve`='Pending'"));

}
$sql_refer_vistor1 = mysqli_query($conn, "select * from `meeting_referrable` where `refer_to`='$user_id' and `reffer_status` in ('Reffer', 'Reffer End') and `visitor_enetry`!= 'Register' order by `sl_no` desc");




?>
<nav class="pcoded-navbar">
  <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
  <div class="pcoded-inner-navbar main-menu">
    <div class="">
      <div class="main-menu-header">
        <img class="img-80 img-radius" src="assets/images/user.png" alt="User-Profile-Image">
        <div class="user-details">
          <span id="more-details"><?php echo ucfirst($user_data_sql['user_role']); ?></span>
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
          <span class="pcoded-micon"><i class="icofont icofont-dashboard-web" style="font-size: 20px;"></i></span>
          <span class="pcoded-mtext">Dashbord</span>
          <span class="pcoded-mcaret"></span>
        </a>
      </li>
      <?php if ($approval == 'Activate') { ?>
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


      <!-- <li class=" ">
        <a href="" class="waves-effect waves-dark">
          <span class="pcoded-micon"><i class="icofont icofont-user" style="font-size: 20px;"></i></span>
          <span class="pcoded-mtext">My Details </span>
          <span class="pcoded-mcaret"></span>
        </a>
      </li> -->


      <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
          <span class="pcoded-micon"><img src="assets/images/visitor-card.png" alt="" srcset=""
              style="width: 1.5rem;"></span>
          <span class="pcoded-mtext">Visitor Details
            <?php if ($refer == 'Activate') {
              if (mysqli_num_rows($sql_refer_vistor1) >= 1) { ?><i class="fa fa-circle" id="blink_me"
              style="margin-left: 4.5rem; color: #36d000;font-size: 12px;"></i><?php }
            } ?></span>
          <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
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
              <span class="pcoded-mtext">My Vsitor Log </span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <?php if ($refer == 'Activate') { ?>
          <li class=" ">
            <a href="view_refer_visitor" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext">Refer Vsitor Log<?php if (mysqli_num_rows($sql_refer_vistor1) >= 1) { ?><i
                  class="fa fa-circle" id="blink_me"
                  style="margin-left: 4.5rem; color: #36d000;font-size: 12px;"></i><?php } ?> </span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <?php } ?>
        </ul>
      </li>

      <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
          <span class="pcoded-micon"><i class="icofont icofont-prescription" style="font-size: 20px;"></i></span>
          <span class="pcoded-mtext">Report </span>
          <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
          <li class=" ">
            <a href="log_report" class="waves-effect waves-dark">
              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
              <span class="pcoded-mtext"> My Log Report</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>

        </ul>
      </li>

      <li class=" ">
        <a href="change_password" class="waves-effect waves-dark">
          <span class="pcoded-micon"><i class="icofont icofont-unlock" style="font-size: 20px;"></i></span>
          <span class="pcoded-mtext">Change Password </span>
          <span class="pcoded-mcaret"></span>
        </a>
      </li>

      <!-- <li class="pcoded-hasmenu">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                    <span class="pcoded-mtext">Basic</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="breadcrumb.html" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Breadcrumbs</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="button.html" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Button</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="accordion.html" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Accordion</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="tabs.html" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Tabs</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="color.html" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Color</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="label-badge.html" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Label Badge</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="tooltip.html" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Tooltip And Popover</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="typography.html" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Typography</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="notification.html" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Notifications</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul> -->
      <!-- <div class="pcoded-navigation-label">UI Element</div>
        <div class="pcoded-navigation-label">Forms</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="">
                <a href="form-elements-component.html" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                    <span class="pcoded-mtext">Form</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
        <div class="pcoded-navigation-label">Tables</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="">
                <a href="bs-basic-table.html" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-receipt"></i><b>B</b></span>
                    <span class="pcoded-mtext">Table</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
        <div class="pcoded-navigation-label">Chart And Maps</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="">
                <a href="chart-morris.html" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-bar-chart-alt"></i><b>C</b></span>
                    <span class="pcoded-mtext">Charts</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="">
                <a href="map-google.html" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-map-alt"></i><b>M</b></span>
                    <span class="pcoded-mtext">Maps</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
        <div class="pcoded-navigation-label">Pages</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="pcoded-hasmenu ">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-id-badge"></i><b>A</b></span>
                    <span class="pcoded-mtext">Pages</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="">
                        <a href="auth-normal-sign-in.html" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Login</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="auth-sign-up.html" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Registration</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="sample-page.html" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-layout-sidebar-left"></i><b>S</b></span>
                            <span class="pcoded-mtext">Sample Page</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul> -->
  </div>
</nav>