<?php
include '../include/_dbconnect.php';
$user_id = $_SESSION['user_id'];
$user_data_sql = mysqli_fetch_assoc(mysqli_query($conn,"select * from `user` where `uid`='$user_id'"));
$user_code_id = $user_id;
$emp_code_id="";
include "../include/_emp_details.php";
$v_emp_code = $emp_code_user_id;
include "../include/_approval.php";
$end_sts =  $end_status ;
$sql_vistor5 =  mysqli_query($conn,"select * from `visitor_log` where `check_status`='IN' and `meeting_status`='End' order by `sl_no` desc");

?>
<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="">
            <div class="main-menu-header">
                <img class="img-80 img-radius" src="assets/images/user_1.png" alt="User-Profile-Image">
                <div class="user-details">
                    <span id="more-details"><?php echo ucfirst($user_data_sql['user_role']) ?></span>
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
                    <span class="pcoded-micon"><i class="icofont icofont-dashboard-web"
                            style="font-size: 20px;"></i></span>
                    <span class="pcoded-mtext">Dashbord</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <?php if($end_sts!="End"){?>

                <li class="">
                    <a href="view_visitor_check_out?id=1" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa fa-commenting"></i><b>D</b></span>
                        <span class="pcoded-mtext">Notification <?php if(mysqli_num_rows($sql_vistor5)>=1){?><i class="fa fa-circle" id="blink_me" style="margin-left: 4.5rem; color: #36d000;font-size: 12px;"></i><?php }?></span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            <?php }?>
                
            <!-- <li class="">
                <a href="form-elements-component.html" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                    <span class="pcoded-mtext">Form</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li> -->

        
                    <li class=" ">
                        <a href="my_details" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="icofont icofont-user"
                            style="font-size: 20px;"></i></span>
                            <span class="pcoded-mtext">My Details </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><img src="assets/images/visitor-card.png" alt="" srcset="" style="width: 1.5rem;"></span>
                    <span class="pcoded-mtext">Visitor Details</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="new_visitor1" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Check - In</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    
                    <li class=" ">
                        <a href="check_out1" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Check - Out </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="visitor_info" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Visitor Info </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="view_visitor?id=1" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Pre Schedule </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="view_visitor" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Vsitor Log  </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="icofont icofont-prescription"
                            style="font-size: 20px;"></i></span>
                    <span class="pcoded-mtext">Report </span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <!-- <li class=" ">
                        <a href="canteen-report" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Canteen Report </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="contribution_report" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Contribution Report</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li> -->
                    <li class=" ">
                        <a href="visitor_info_report" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext"> Visitor Info Report</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="visitor_report" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext"> Visitor Log Report</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
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
                    <span class="pcoded-micon"><i class="icofont icofont-unlock"
                            style="font-size: 20px;"></i></span>
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