<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';

$des = "Page Load new_visit_process";
$rem = "New visit process";
include '../include/_audi_log.php';

$sequri_sts = "Pending";
$approval_sts = "Panding";
$user_id = "";
function is_connected()
{
    $connected = @fsockopen("www.example.com", 80);
    //website, port  (try 80 or 443)
    if ($connected) {
        $is_conn = true; //action when connected
        fclose($connected);
    } else {
        $is_conn = false; //action in connection failure
    }
    return $is_conn;

}
function mail_send($approv_sts, $email, $v_log_id, $v_id, $name, $company, $add, $cont, $visit_purpose, $arr_time, $check_sts_mail)
{
    // $url = "";

    // if ($url == "") {
    //     $url_host = gethostname();
    // } else {
    //     $url_host = $url;
    // }
    // $ipaddress_server = gethostbynamel($url_host);
    $url = $_SERVER['REQUEST_URI'];

    // Parse the URL and get the host/domain name
    $parsed_url = parse_url($url);
    $domain = $parsed_url['host'];



    // Get the IP address
    $ip = gethostbyname($domain);
    $localhost = $ip . ":" . $_SERVER['SERVER_PORT'];
    $emp_visit_status =
        $destination_mail = $email;
    $attechment = "";
    $emp_name_mail = ucfirst($name);
    $visit_code = $v_id;
    $html = '
<tr>
<th style="width: 45%">Visitor Log Id </th>
<td>' . $v_id . '</td>
</tr>
<tr>
<th style="width: 45%">Visitor Name </th>
<td>' . ucfirst($name) . '</td>
</tr>
<tr>
<th style="width: 45%">Company Name </th>
<td>' . $company . '</td>
</tr>
<tr>
<th style= "width:45%">Address </th>
<td>' . $add . '</td>
</tr>
<tr>
<th style="width: 45%">Mobile No </th>
<td>' . $cont . '</td>
</tr>
<tr>
<th style="width: 45%">Visit of Purpose </th>
<td>' . $visit_purpose . '</td>
</tr>
<tr>
<th style="width: 45%">Arival Time </th>
<td>' . $arr_time . '</td>
</tr>
<tr>
<th style="width: 45%">Check Status </th>
<td>' . $check_sts_mail . '</td>
</tr>

';
    if ($approv_sts != "Approve") {
        $button = "<tr>
    <td valign='middle' class='hero bg_white' style='padding: 2em 0 4em 0;'>
        <table>
            <tr>
                <td>
                    <div class='text' style='padding: 0 2.5em; text-align: center;'>
                        <h2>Please verify and give your Reponse </h2>
                        
                        
                        <p>
                            <a href='http://" . $localhost . "/vms/approve_by_mail.php?sts=IN&vc=" . $visit_code . "'><button type='button' class='btn btn-primary' style='cursor:pointer; mergin-right:1rem; background-color:#068711;'>Approve</button></a>
                            <a href='http://" . $localhost . "/vms/approve_by_mail.php?sts=OUT&vc=" . $visit_code . "'><button type='button' class='btn btn-denger' style='cursor:pointer;'>Reject</button></a>
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>";
    } else {
        $button = "<tr></tr>";
    }

    include '../include/_mail.php';
}
if (isset($_POST['final_dubmit'])) {
    $v_log_id = $_POST['uid'];
    $v_id = explode("-", $v_log_id);
    $v_id = $v_id[1];
    $visit_id = $_POST['visit_id'];
    $v_info = $_POST["visit"];
    $emp_details = $v_info[0];
    $full1 = explode(' ', $emp_details);
    $emp_code = $full1[0];

    $sql_emp_data = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` where `Emp_code`='$emp_code'"));
    if ($sql_emp_data != "") {
        $employee_name = $sql_emp_data['EmployeeName'];
        $dept_id = $sql_emp_data['DepartmentId'];
        $co_id = $sql_emp_data['CompanyId'];
        $contact_no = $sql_emp_data['ContactNo'];
        $designation = $sql_emp_data['DesignationId'];
        $email = $sql_emp_data['email_id'];
        $emp_branch_id = $sql_emp_data['BranchId'];


    }
    $v_desig_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `designation` where `designation_code`='$designation'"));
    if ($v_desig_sql != "") {
        $designation = $v_desig_sql['designation'];
    } else {
        $designation = "";
    }


    $sql_co = mysqli_fetch_assoc(mysqli_query($conn, "select * from `company_details` where`company_id` ='$co_id'"));
    if ($sql_co != "") {
        $employee_com = $sql_co['companyFname'];
    }
    $sql_dept = mysqli_fetch_assoc(mysqli_query($conn, "select * from `department` where `department_code`='$dept_id'"));
    if ($sql_dept != "") {
        $employee_depart = $sql_dept['department_name'];
    }

    $arr_status = $v_info[1];
    $arr_time = $v_info[2];
    // $arr_time_db = date("H:i:s", strtotime($arr_time));
    // $arr_date = date("Y-m-d");
    $v_in_date = date("d-M-Y");
    $gate_no = $v_info[3];
    $visit_pur_id = $v_info[4];
    $visito_purpse_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visit_purpose` where `purpose_id` = '$visit_pur_id'"));
    $visit_purpose = $visito_purpse_sql['purpose'];
    $v_govt_id = $v_info[6];
    $name = $v_info[7] . " " . $v_info[8];
    $company = $v_info[9];
    $desig = $v_info[10];
    $add = $v_info[11];
    $gmail = $v_info[12];
    $cont = $v_info[13];
    // $issud_id_no = $v_info[14]; 
    // $visitor_type_id = $v_info[15];
    // $visit_type_sql = mysqli_fetch_assoc(mysqli_query($conn,"select * from `vsitor_type` where `type_id` = '$visitor_type_id' "));
    // $visitor_type = $visit_type_sql['type_name'];

    // $vehical_type = $v_info[16];
    // if($vehical_type!="" && $vehical_type!="NO" && $vehical_type!="Cycle"){
    //     $vehical_no = $v_info[17];
    // }
    $user_id = $_SESSION['user_id'];

    $v_emp_code = $emp_code;
    include '../include/_approval.php';
    $emp_visit_status = $emp_status;

    if ($emp_code == $emp_code_details) {
        $emp_visit_status = "Approve";
    }
    if ($emp_visit_status == "Approve") {
        $approval_sts = "Approve";
    }
    if ($sequri_sts == "Approve") {
        $check_sts_mail = "IN";
    } else {
        $check_sts_mail = "Pending";
    }
    if ($emp_code == $_SESSION['emp_code']) {
        $emp_visit_status = "Approve";
    }
    if ($visit_id != "" && $emp_branch_id != "" && $emp_code != "" && $gate_no != "" && strtotime($arr_time) >= strtotime(date("Y-m-d"))) {
        $sql_exist_data = mysqli_num_rows(mysqli_query($conn, "select * from `visitor_log` where `visitor_id`='$visit_id' and `emp_id` = '$emp_code' and `visit_uid`='$v_log_id'"));
        if ($sql_exist_data < 1) {

            $insert_sql = mysqli_query($conn, "insert into `visitor_log`(`visit_uid`, `visitor_id`, `emp_id`,`branch_id`,`visit_purpose`, `gate_no`,`pre_schedule_date`,`register_by`, `register_type`, `Emp_approve`,`security_approval`,`check_status`, `register_time_stamp`) values ('$v_log_id','$visit_id','$emp_code','$emp_branch_id','$visit_pur_id','$gate_no','$arr_time','$user_id','$arr_status','$emp_visit_status','$sequri_sts','Pending',current_timestamp)");

            if ($insert_sql != "") {
                // $source = '../upload_temp/'.$v_log_id.".png";
                // $destination = '../upload/';
                // rename($source, $destination . basename($source));

                if ($emp_code != $emp_code_details) {
                    // check Mail Approval
                    $checkMailApp = mysqli_query($conn, "select * from approval_sts where branch_id = '$emp_branch_id' and emailApproval = 'Activate'");
                    if (mysqli_num_rows($checkMailApp) >= 1) {
                        mail_send($approval_sts, $email, $v_log_id, $v_id, $name, $company, $add, $cont, $visit_purpose, $arr_time, $check_sts_mail);
                    }

                }

                if ($approval_sts != "Approve") {
                    $des = "Page Load new_visitor_final";
                    $rem = "New visitor registered";
                    include '../include/_audi_log.php';
                    $_SESSION['icon'] = 'success';
                    $_SESSION['status'] = 'Wait For Approval Visitor Uid :- ' . $v_id;
                    header("location:new_visitor1");


                } else {
                    $des = "Page Load new_visitor_final";
                    $rem = "New visitor registered";
                    include '../include/_audi_log.php';
                    $_SESSION['icon'] = 'success';
                    $_SESSION['status'] = 'PreSchudul Successfull Visitor Uid :- ' . $v_id;
                    header("location:new_visitor1");
                }


            } else {
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] = 'Vistor Log Not Register.....';
                $des = "Page Load new_visitor_final";
                $rem = "New visitor not register";
                include '../include/_audi_log.php';
                header("location:new_visitor1");
            }

        } else {
            $v_info = "";
            $_SESSION['icon'] = 'info';
            $_SESSION['status'] = 'Visitor Already Register...';
            $des = "Page Load new_visitor_final";
            $rem = "New visitor not register";
            include '../include/_audi_log.php';
            header("location:new_visitor1");

        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Please Fill All Information Carefully';
        header("location:new_visitor1");

    }

}

// meeting_end
if (isset($_POST['end_meeting'])) {
    $v_id = $_POST['v_id'];
    $back_page = $_POST['back_page'];
    $emp_code = $_POST['emp_code'];
    $u_id = $_SESSION['user_id'];
    $todate = date("Y-m-d");
    $time = date("H:i:s");
    if ($v_id != "") {

        $end_meeting = mysqli_query($conn, "update `visitor_log` set `meeting_status`='End',`meeting_end_by`='$u_id',`meeting_end_date`='$todate',`meeting_end_time`='$time' where `visit_uid`='$v_id'");
        $update_sts = mysqli_query($conn, "update `meeting_referrable` set `reffer_status`='Reffer End' where `refer_visitor`= '$v_id'");

        if ($end_meeting != "") {
            $_SESSION['icon'] = 'success';
            $_SESSION['status'] = 'Meeting End Successfully..........';
            header("location:" . $back_page);
        } else {
            $_SESSION['icon'] = 'warning';
            $_SESSION['status'] = 'Meeting Not End Please Check..........';
            header("location:" . $back_page);
        }
    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Insuficiant Data for meeting Ending....';
        header("location:" . $back_page);
    }


}

// referral

if (isset($_POST['refer_submit'])) {
    $v_log_id = $_POST['v_log_id'];
    $emp_code = $_POST['refer_to'];
    $back_page = $_POST['back_page'];
    if ($v_log_id != "" && $emp_code != "") {

        $emp_id = explode(" ", $emp_code);
        $emp_id = $emp_id[0];
        if ($emp_id != "") {
            $emp_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` where `Emp_code` = '$emp_id'"));
            if ($emp_details != "") {
                $empployeeid = $emp_details['EmployeeId'];
                $user_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `EmployeeId` = '$empployeeid'"));
                if ($user_details != "") {
                    $refer_user_id = $user_details['uid'];
                    $emp_code_id = "";
                    $user_code_id = $refer_user_id;
                    include "../include/_emp_details.php";
                    $refer_user_id = $emp_code_user_id;
                    $user_id = $_SESSION['user_id'];
                    $emp_code_id = "";
                    $user_code_id = $user_id;
                    include "../include/_emp_details.php";
                    $user_id = $emp_code_user_id;
                    $today = date("Y-m-d");
                    $time = date("H:i:s");
                    $update_sts = mysqli_query($conn, "update `meeting_referrable` set `reffer_status`='Reffer End' where `refer_to` = '$user_id' and `refer_visitor`= '$v_log_id'");

                    $insert_sql = mysqli_query($conn, "insert into `meeting_referrable`(`refer_by`, `refer_to`, `refer_visitor`, `refer_date`, `refer_time`, `reffer_status`) values ('$user_id','$refer_user_id','$v_log_id','$today','$time','Reffer')");
                    if ($insert_sql != "" && $update_sts != "") {
                        $_SESSION['icon'] = 'success';
                        $_SESSION['status'] = 'Reffer Successfully....';
                        header("location:" . $back_page);
                    } else {
                        $_SESSION['icon'] = 'error';
                        $_SESSION['status'] = 'Reffer Not Done....';
                        header("location:" . $back_page);
                    }
                } else {
                    $_SESSION['icon'] = 'error';
                    $_SESSION['status'] = 'User Not Available....';
                    header("location:" . $back_page);
                }
            } else {
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] = 'Reffer Employee Not Available....';
                header("location:" . $back_page);
            }
        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Insaficiant data for Referral....';
            header("location:" . $back_page);
        }

    } else {
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Insaficiant data for Referral';
        header("location:" . $back_page);
    }
}

?>