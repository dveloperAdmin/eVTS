<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
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
    $url = $_SERVER['REQUEST_URI'];

    // Parse the URL and get the host/domain name
    $parsed_url = parse_url($url);
    $domain = $parsed_url['host'];



    // Get the IP address
    $ip = gethostbyname($domain);

    // $url = "";

    // if ($url == "") {
    //     $url_host = gethostname();
    // } else {
    //     $url_host = $url;
    // }
    // $ipaddress_server = gethostbynamel($url_host);
    $localhost = $ip . ":" . $_SERVER['SERVER_PORT'];
    $emp_visit_status =
        $destination_mail = $email;
    $attechment = '../upload/' . $v_log_id . '.png';
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
    <tr>
    <th style="width: 45%">Visito Image </th>
    <td>Please Check Attachment</td>
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
                                <a href='http://" . $localhost . "/vms/approve_by_mail?sts=IN&vc=" . $visit_code . "'><button type='button' class='btn btn-primary' style='cursor:pointer; mergin-right:1rem;background-color:#068711;'>Approve</button></a>
                                <a href='http://" . $localhost . "/vms/approve_by_mail?sts=OUT&vc=" . $visit_code . "'><button type='button' class='btn btn-denger' style='cursor:pointer;'>Reject</button></a>
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

$des = "Page Load new_visit_process";
$rem = "New visit process";
include '../include/_audi_log.php';

$sequri_sts = "Approve";
$approval_sts = "Pending";
$check_sts_mail = "Pending";
if (isset($_POST['final_dubmit'])) {
    $v_log_id = $_POST['uid'];
    $v_id = explode("-", $v_log_id);
    $v_id = $v_id[1];
    $visit_id = $_POST['visit_id'];
    $v_info = $_POST["visit"];
    $emp_details = $v_info[0];
    $full1 = explode(' ', $emp_details);
    $emp_code = $full1[0];
    $email = "";
    $vehical_no = "";
    $sql_emp_data = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` where `Emp_code`='$emp_code'"));
    if ($sql_emp_data != "") {
        $employee_name = $sql_emp_data['EmployeeName'];
        $dept_id = $sql_emp_data['DepartmentId'];
        $co_id = $sql_emp_data['CompanyId'];
        $contact_no = $sql_emp_data['ContactNo'];
        $designation = $sql_emp_data['DesignationId'];
        $email = $sql_emp_data['email_id'];
        $branch_code = $sql_emp_data['BranchId'];
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
    $arr_time_db = date("H:i:s", strtotime($arr_time));
    $arr_date = date("Y-m-d");
    $v_in_date = date("d-M-Y");
    $gate_no = $v_info[3];
    $visit_pur_id = $v_info[4];
    $visito_purpse_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visit_purpose` where `purpose_id` = '$visit_pur_id'"));
    $visit_purpose = $visito_purpse_sql['purpose'];
    $v_govt_id = $v_info[6];
    $name = $v_info[7];
    $company = $v_info[8];
    $desig = $v_info[9];
    $add = $v_info[10];
    $gmail = $v_info[11];
    $cont = $v_info[12];
    $issud_id_no = $v_info[13];
    $visitor_type_id = $v_info[14];
    $visit_type_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `vsitor_type` where `type_id` = '$visitor_type_id' "));
    $visitor_type = $visit_type_sql['type_name'];
    $meterial = $v_info[15];
    $vehical_type = $v_info[16];
    if ($vehical_type != "" && $vehical_type != "NO" && $vehical_type != "Cycle") {
        $vehical_no = $v_info[17];
    }
    $user_id = $_SESSION['user_id'];

    $v_emp_code = $emp_code;
    include '../include/_approval.php';
    $emp_visit_status = $emp_status;
    $end_sts = $end_status;

    if ($sequri_sts == "Approve" && $emp_visit_status == "Approve") {
        $approval_sts = "Approve";
        $check_sts_mail = 'IN';
    }
    if ($visit_id != "" && $issud_id_no != "" && $emp_code != "" && $visitor_type_id != "" && $gate_no != "" && $arr_time_db != "" && $vehical_type != "") {
        $sql_exist_data = mysqli_num_rows(mysqli_query($conn, "select * from `visitor_log` where `visitor_id`='$visit_id' and `emp_id` = '$emp_code' and `checkin_time`='$arr_time_db'"));
        if ($sql_exist_data < 1) {


            $insert_sql = mysqli_query($conn, "insert into `visitor_log`(`visit_uid`, `visitor_id`,`id_card_no`, `emp_id`,`branch_id`, `visitor_type`,`visit_purpose`, `gate_no`,`Arrival_time_stamp`,`register_by`, `register_type`, `checkin_date`,`things_brought`, `vehical_type`, `vahical_num`,`Emp_approve`,`security_approval`,`check_status`,`meeting_status` ,`register_time_stamp`) values ('$v_log_id','$visit_id','$issud_id_no','$emp_code','$branch_code','$visitor_type_id','$visit_pur_id','$gate_no',current_timestamp,'$user_id','ON BOARDING','$arr_date','$meterial','$vehical_type','$vehical_no','$emp_visit_status','$sequri_sts','Pending','$end_sts',current_timestamp)");

            if ($insert_sql != "") {
                $source = '../upload_temp/' . $v_log_id . ".png";
                $destination = '../upload/';
                rename($source, $destination . basename($source));
                // if($approval_sts !="Approve"){
                // if(filter_var($email, FILTER_VALIDATE_EMAIL)){

                // check Mail Approval
                $checkMailApp = mysqli_query($conn, "select * from approval_sts where branch_id = '$branch_code' and emailApproval = 'Activate'");
                if (mysqli_num_rows($checkMailApp) >= 1) {
                    if (is_connected()) {
                        mail_send($approval_sts, $email, $v_log_id, $v_id, $name, $company, $add, $cont, $visit_purpose, $arr_time, $check_sts_mail);
                        if ($approval_sts != "Approve") {
                            $_SESSION['icon'] = 'success';
                            $_SESSION['status'] = 'Wait For Approval Visitor Uid :- ' . $v_id;
                            header("location:new_visitor1");
                        } else {
                            $_SESSION['icon'] = 'success';
                            $_SESSION['status'] = 'Visitor Uid :- ' . $v_id;
                            header("location:new_visitor_details_print?vid=" . $v_id);

                        }
                        $des = "Page Load new_visitor_process";
                        $rem = "New visitor register and mail sended";
                        include '../include/_audi_log.php';
                    } else {
                        if ($approval_sts != "Approve") {
                            $_SESSION['icon'] = 'warning';
                            $_SESSION['status'] = 'You got disconnected (Approval Mail not sended)! Wait For Approval Visitor Uid :- ' . $v_id;
                            header("location:new_visitor1");
                        } else {
                            $_SESSION['icon'] = 'warning';
                            $_SESSION['status'] = 'You got disconnected! Uid :- ' . $v_id;
                            header("location:new_visitor_details_print?vid=" . $v_id);
                        }
                        $des = "Page Load new_visitor_process";
                        $rem = "New visitor register but mail not sended";
                        include '../include/_audi_log.php';
                    }
                } else {
                    if ($approval_sts != "Approve") {
                        $_SESSION['icon'] = 'success';
                        $_SESSION['status'] = 'Wait For Approval Visitor Uid :- ' . $v_id;
                        header("location:new_visitor1");
                    } else {
                        $_SESSION['icon'] = 'success';
                        $_SESSION['status'] = 'Visitor Uid :- ' . $v_id;
                        header("location:new_visitor_details_print?vid=" . $v_id);

                    }
                    $des = "Page Load new_visitor_process";
                    $rem = "New visitor register";
                    include '../include/_audi_log.php';
                }
            } else {
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] = 'Vistor Log Not Register.....';
                $des = "Page Load new_visitor_process";
                $rem = "New visitor not register";
                include '../include/_audi_log.php';
                header("location:new_visitor1");
            }

        } else {
            $v_info = "";
            $_SESSION['icon'] = 'info';
            $_SESSION['status'] = 'Visitor Already Register...';
            $des = "Page Load new_visitor_process";
            $rem = "New visitor not register";
            include '../include/_audi_log.php';
            header("location:new_visitor1");

        }

    } else {
        $des = "Page Load new_visitor_process";
        $rem = "New visitor not register";
        include '../include/_audi_log.php';
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Please Fill All Information Carefully';
        header("location:new_visitor1");

    }

}


if (isset($_POST['v_app'])) {
    $v_id = $_POST['vid'];
    $id = explode('-', $v_id);
    $id = $id[1];
    $v_id_card = $_POST['v_id_card'];
    $v_type = $_POST['visit_type'];
    $arr_date_time = $_POST['arrive_date_time'];
    $vehical_type = $_POST['v_type'];
    $vehcal_no = $_POST['v_no'];
    $carry_in = $_POST['carry_in'];
    $action = $_POST['action'];
    if ($v_id != "" && $arr_date_time != "" && $vehical_type != "" && $action != "" && $v_id_card != "" && $v_type != "") {

        $check_v_log = mysqli_query($conn, "select * from `visitor_log` where `visit_uid`= '$v_id' and `security_approval` = 'Pending'");
        if (mysqli_num_rows($check_v_log) >= 1) {
            echo $v_type;
            echo $v_id_card;
            $upadet_query = mysqli_query($conn, "update `visitor_log` set `id_card_no` = '$v_id_card' , `visitor_type`='$v_type' , `Arrival_time_stamp`='$arr_date_time',`things_brought`='$carry_in',`vehical_type`='$vehical_type',`vahical_num`='$vehcal_no',`security_approval`='$action' where `visit_uid`= '$v_id'");
            if ($upadet_query != "") {
                $v_data = mysqli_num_rows(mysqli_query($conn, "select * from `visitor_log` where `visit_uid`= '$v_id' and `security_approval` = 'Approve' and `Emp_approve`='Approve'"));
                if ($v_data >= 1) {
                    $source = '../upload_temp/' . $v_id . ".png";
                    $destination = '../upload/';
                    rename($source, $destination . basename($source));
                    unlink($source);

                    header("location:new_visitor_details_print?vid=" . base64_encode(base64_encode($id)) . "&id=" . base64_encode(base64_encode('1')));
                } else {
                    $_SESSION['icon'] = 'success';
                    $_SESSION['status'] = 'Visitor Details Update successfully ';
                    $des = "Page Load new_visitor_process";
                    $rem = "New visitor updated ";
                    include '../include/_audi_log.php';
                    header("location:view_visitor?id=1");
                }


            } else {
                $_SESSION['icon'] = 'warning';
                $_SESSION['status'] = 'Update not possible';
                $des = "Page Load new_visitor_process";
                $rem = "New visitor not update";
                include '../include/_audi_log.php';
                header("location:view_visitor?id=1");
            }

        } else {
            $_SESSION['icon'] = 'warning';
            $_SESSION['status'] = 'Visitor Not Found..';
            $des = "Page Load new_visitor_process";
            $rem = "New visitor not update";
            include '../include/_audi_log.php';
            header("location:view_visitor?id=1");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Insuficiant data...';
        $des = "Page Load new_visitor_process";
        $rem = "New visitor not update";
        include '../include/_audi_log.php';
        header("location:view_visitor?id=1");
    }

}



if (isset($_POST['check_out'])) {
    $id = $_POST['uid'];
    $date = $_POST['check_out_date'];
    $hrs = $_POST['hrs'];
    $mnt = $_POST['mnt'];
    $ampm = $_POST['ampm'];
    $time = $hrs . ":" . $mnt . " " . $ampm;


    if ($id != "" && $date != "" && $hrs != "" && $mnt != "" && $ampm != "") {
        $id = "VSL-" . $id;
        $date = date("Y-m-d", strtotime($date));
        $time = date("H:i:s", strtotime($time));
        $user_id = $_SESSION['user_id'];
        // echo $id;
        $sql_check = mysqli_query($conn, "select * from `visitor_log` where `visit_uid` = '$id' and `check_status`!='OUT'");
        if (mysqli_num_rows($sql_check) >= 1) {
            $vi = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_log` where `visit_uid` = '$id' "));
            $check_sts = $vi['check_status'];
            $end_sts = $vi['meeting_status'];
            if ($check_sts == 'IN') {
                if ($end_sts == 'End') {


                    $check_in_date = strtotime($vi['checkin_date']);
                    $check_in_time = strtotime($vi['checkin_time']);

                    $date_check = strtotime($date);
                    $time_check = strtotime($time);
                    if ($check_in_date < $date_check) {

                        $sql_check_out = mysqli_query($conn, "update `visitor_log` set `checkout_date`='$date',`checkout_time`='$time',`check_out_by`='$user_id',`check_status`='OUT' where `visit_uid` = '$id'");
                        $update_sts = mysqli_query($conn, "update `meeting_referrable` set `reffer_status`='Reffer End' where `refer_visitor`= '$id'");

                        if ($sql_check_out != "") {
                            $_SESSION['icon'] = 'success';
                            $_SESSION['status'] = 'Successfully Checked Out....';
                            header("location:view_visitor_check_out?id=1");
                        } else {
                            $_SESSION['icon'] = 'error';
                            $_SESSION['status'] = 'Checked Out Not Possible....';
                            header("location:view_visitor_check_out?id=1");
                        }

                    } else if ($check_in_date == $date_check && $check_in_time < $time_check) {
                        $sql_check_out = mysqli_query($conn, "update `visitor_log` set `checkout_date`='$date',`checkout_time`='$time',`check_out_by`='$user_id',`check_status`='OUT' where `visit_uid` = '$id'");
                        $update_sts = mysqli_query($conn, "update `meeting_referrable` set `reffer_status`='Reffer End' where `refer_visitor`= '$id'");

                        if ($sql_check_out != "") {
                            $_SESSION['icon'] = 'success';
                            $_SESSION['status'] = 'Successfully Checked Out....';
                            header("location:view_visitor_check_out?id=1");
                        } else {
                            $_SESSION['icon'] = 'error';
                            $_SESSION['status'] = 'Checked Out Not Possible....';
                            header("location:view_visitor_check_out?id=1");
                        }
                    } else {
                        $_SESSION['icon'] = 'info';
                        $_SESSION['status'] = "Check Out Not Possible Before Check In Date & Time....";
                        header("location:view_visitor_check_out?id=1");
                    }

                } else {
                    $_SESSION['icon'] = 'info';
                    $_SESSION['status'] = 'Visitor Meeting Not Ended....';
                    header("location:view_visitor_check_out?id=1");
                }
            } else {
                $_SESSION['icon'] = 'info';
                $_SESSION['status'] = 'Visitor Not Checked In....';
                header("location:view_visitor_check_out?id=1");
            }
        } else {
            $_SESSION['icon'] = 'info';
            $_SESSION['status'] = 'Visitor Already Checked Out....';
            header("location:view_visitor_check_out?id=1");
        }

    } else {
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Insufficient Data...';
        header("location:view_visitor_check_out?id=1");
    }
}
?>

<script>
    $(window).load(function () {
        // executes when complete page is fully loaded, including all frames, objects and images
        alert("window is loaded");
    });
</script>