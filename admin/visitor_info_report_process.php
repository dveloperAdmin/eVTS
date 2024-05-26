<head>

  <title>VMS</title>
  <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
  <style>
  table {
    color: #0f267c;
    border-color: #ffb9b9;
  }

  @media print {
    body * {
      visibility: hidden;
      background: white;
    }

    .print_container * {
      visibility: visible;
      background: white;
    }

    .print_container {
      position: absolute;
      left: 0px;
      top: 0px;
    }
  }

  .btn-primary {
    width: 5rem;
    height: 2.5rem;
    background-color: #fff;
    border-color: #448aff;
    color: #448aff;
    cursor: pointer;
    -webkit-transition: all ease-in 0.3s;
    transition: all ease-in 0.3s;
    font-size: 1rem;
    font-weight: bold;
  }

  .btn-primary:hover {
    background-color: #77aaff;
    border-color: #77aaff;
    color: #fff;
  }

  @media print {
    @page {
      margin-top: 0;
      margin-bottom: 0;
    }

    body {
      padding-top: 72px;
      padding-bottom: 72px;
    }
  }
  </style>

</head>
<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head = "Visitor Report Process";
$des = "Page Load visitor_info_report_process";
$rem = "Visitor Info Report Process";
include '../include/_audi_log.php';



function info_excel($sql_data, $file_name)
{

    include '../include/_dbconnect.php';
    include '../include/_function.php';
    $des = "Page Load visitor_info_report Process";
    $rem = "Visitor info Report generated";
    include '../include/_audi_log.php';
    $branchCode = "";
    $comName = mysqli_fetch_assoc(mysqli_query($conn, "select * from company_details"));
    if ($comName != "") {
        $comName = $comName['companyFname'];
    } else {
        $comName = "";
    }



    $datatable = '<table border="1">
    <tbody>
    <tr>
    <th colspan = "12" style= "font-size: 23px;
     font-style: italic;">' . $comName . '</th>
    
    </tr>
    <tr>
    <th colspan = "12"style= "font-size: 18px;
     font-style: italic;" >Visitor Info Report</th>
    
    </tr>
                    
                        <tr style="text-align:center;">
                            <td><b>Sl no</b></td>
                            <td><b>Visitor Id <b></td>
                            <td><b>Id Type <b></td>
                            <td><b>Id No <b></td>
                            <td><b>Visitor Name <b></td>
                            <td><b>Comapny Name <b></td>
                            <td><b>Designation <b></td>
                            <td><b>Email ID <b></td>
                            <td><b>Mobile No <b></td>
                            <td><b>Address <b></td>
                            <td><b>Last Visited Branch <b></td>
                            <td><b> Count<b></td>
                       </tr>
                ';
    for ($i = 1; $i <= mysqli_num_rows($sql_data); $i++) {
        $info_report = mysqli_fetch_assoc($sql_data);
        $user_code_id = "";
        $emp_code_id = "";
        $emp_formate = "";
        $user_code_id = $info_report['register_by'];
        if ($user_code_id != "") {
            include '../include/_emp_details.php';
            $emp_formate = $emp_name . "( " . $emp_code_user_id . " )";

        } else {
            $emp_formate = "";
        }
        $v_id = $info_report['visitor_id'];
        if (in_array($user_role, array("Developer", "Super Admin"))) {
            $visitorData = mysqli_query($conn, "SELECT * FROM `visitor_log` WHERE `visitor_id` = '$v_id' order by Arrival_time_stamp desc");
            $count = mysqli_num_rows($visitorData);
        } else {

            $visitorData = mysqli_query($conn, "select * from `visitor_log` where branch_id = '$branch_id' and `visitor_id` = '$v_id' order by Arrival_time_stamp desc");
            $count = mysqli_num_rows($visitorData);
        }
        if ($visitorData != "") {
            $visitorDataftch = mysqli_fetch_assoc($visitorData);
            if ($visitorDataftch != "") {
                $branchCode = $visitorDataftch['branch_id'];
            } else {
                $branchCode = "";
            }
            if ($branchCode != "") {
                $branchName = findBranch($conn, $branchCode);
            } else {
                $branchName = "Not Visited";
            }
        }

        if ($count > 0) {
            $datatable .= ' <tr style="text-align:center;">
                <td>' . $i . '</td>
                <td>' . $info_report['visitor_id'] . '</td>
                <td>' . $info_report['govt_id_type'] . '</td>
                <td>' . $info_report['govt_id_no'] . '</td>
                <td>' . ucfirst($info_report['name']) . '</td>
                <td>' . ucfirst($info_report['com_name']) . '</td>
                <td>' . $info_report['designation'] . '</td>
                <td>' . $info_report['mail_id'] . '</td>
                <td>' . $info_report['contact_no'] . '</td>
                <td>' . $info_report['address'] . '</td>
                <td>' . $branchName . '</td>
                <td>' . $count . '</td>
            </tr>';
        }

    }

    $datatable .= '</tbody></table>';

    header('Content-Type:application/octet-stream');
    header('Content-Disposition:attachment; filename=' . $file_name . '.xls');

    echo $datatable;

    $des = "Txn Log report download";
    $rem = " TXn Log Report";
    include "../include/_audi_log.php";

    exit;


}

function v_info_view($sql_data)
{
    include '../include/_dbconnect.php';
    include '../include/_function.php';
    $des = "Page Load visitor_info_report Process";
    $rem = "Visitor info Report generated";
    include '../include/_audi_log.php';
    $branchCode = "";
    $comName = mysqli_fetch_assoc(mysqli_query($conn, "select * from company_details"));
    if ($comName != "") {
        $comName = $comName['companyFname'];
    } else {
        $comName = "";
    }



    $datatable = '<table border="1">
    <tbody>
    <tr>
    <th colspan = "12" style= "font-size: 23px;
     font-style: italic;">' . $comName . '</th>
    
    </tr>
    <tr>
    <th colspan = "12"style= "font-size: 18px;
     font-style: italic;" >Visitor Info Report</th>
    
    </tr>
                    
                        <tr style="text-align:center;">
                            <td><b>Sl no</b></td>
                            <td><b>Visitor Id <b></td>
                            <td><b>Id Type <b></td>
                            <td><b>Id No <b></td>
                            <td><b>Visitor Name <b></td>
                            <td><b>Comapny Name <b></td>
                            <td><b>Designation <b></td>
                            <td><b>Email ID <b></td>
                            <td><b>Mobile No <b></td>
                            <td><b>Address <b></td>
                            <td><b>Last Visited Branch <b></td>
                            <td><b> Count<b></td>
                       </tr>
                ';
    for ($i = 1; $i <= mysqli_num_rows($sql_data); $i++) {
        $info_report = mysqli_fetch_assoc($sql_data);
        $user_code_id = "";
        $emp_code_id = "";
        $emp_formate = "";
        $user_code_id = $info_report['register_by'];
        if ($user_code_id != "") {
            include '../include/_emp_details.php';
            $emp_formate = $emp_name . "( " . $emp_code_user_id . " )";

        } else {
            $emp_formate = "";
        }
        $v_id = $info_report['visitor_id'];
        if (in_array($user_role, array("Developer", "Super Admin"))) {
            $visitorData = mysqli_query($conn, "SELECT * FROM `visitor_log` WHERE `visitor_id` = '$v_id' order by Arrival_time_stamp desc");
            $count = mysqli_num_rows($visitorData);
        } else {

            $visitorData = mysqli_query($conn, "select * from `visitor_log` where branch_id = '$branch_id' and `visitor_id` = '$v_id' order by Arrival_time_stamp desc");
            $count = mysqli_num_rows($visitorData);
        }
        if ($visitorData != "") {
            $visitorDataftch = mysqli_fetch_assoc($visitorData);
            if ($visitorDataftch != "") {
                $branchCode = $visitorDataftch['branch_id'];
            } else {
                $branchCode = "";
            }
            if ($branchCode != "") {
                $branchName = findBranch($conn, $branchCode);
            } else {
                $branchName = "Not Visited";
            }
        }

        if ($count > 0) {

            $datatable .= ' <tr style="text-align:center;">
                    <td>' . $i . '</td>
                    <td>' . $info_report['visitor_id'] . '</td>
                    <td>' . $info_report['govt_id_type'] . '</td>
                    <td>' . $info_report['govt_id_no'] . '</td>
                    <td>' . ucfirst($info_report['name']) . '</td>
                    <td>' . ucfirst($info_report['com_name']) . '</td>
                    <td>' . $info_report['designation'] . '</td>
                    <td>' . $info_report['mail_id'] . '</td>
                    <td>' . $info_report['contact_no'] . '</td>
                    <td>' . $info_report['address'] . '</td>
                    <td>' . $branchName . '</td>
                    <td>' . $count . '</td>
            </tr>';
        }

    }

    $datatable .= '</tbody></table>';
    // echo $datatable;
    echo '  <button class="btn-primary"  onclick="window.print()">Print</button>
            <a href="visitor_info_report.php"><button class="btn-primary" >Back</button></a>';
    echo '<div class="print_container" style="">' . $datatable . '</div>';


}











// details report from visitor
if (isset($_POST['v_info_monthly'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    try {
        if ($month != "" && $year != "") {
            $from_date = date("Y-m-d H:i:s", strtotime($from_date . "00:00:01"));
            $to_date = date("Y-m-d H:i:s", strtotime($to_date . "23:59:59"));

            $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `register_date` between '$from_date' and '$to_date'");
            $file_name = "Visitor_Informaton";
            info_excel($sql_v_info, $file_name);
        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Provide correct Info';
            header("location:visitor_info_report");
        }
    } catch (Exception $e) {
        $_SESSION['icon'] = 'info';
        $_SESSION['status'] = 'Please try again leter';
        header("location:visitor_report");
    }
}
// details report from visitor
if (isset($_POST['view_log_monthly'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    try {
        if ($month != "" && $year != "") {
            $from_date = date("Y-m-d H:i:s", strtotime($from_date . "00:00:01"));
            $to_date = date("Y-m-d H:i:s", strtotime($to_date . "23:59:59"));
            $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `register_date` between '$from_date' and '$to_date'");
            v_info_view($sql_v_info);
        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Provide correct Info';
            header("location:visitor_info_report");
        }

    } catch (Exception $e) {
        $_SESSION['icon'] = 'info';
        $_SESSION['status'] = 'Please try again leter';
        header("location:visitor_info_report");
    }
}

// details report from visitor name
if (isset($_POST['v_name_report'])) {
    $v_name = $_POST['v_name'];
    try {
        if ($v_name != "") {
            $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `name` like '%$v_name%'");
            $file_name = "Visitor_Informaton";
            info_excel($sql_v_info, $file_name);
        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Provide correct Info';
            header("location:visitor_info_report");
        }
    } catch (Exception $e) {
        $_SESSION['icon'] = 'info';
        $_SESSION['status'] = 'Please try again leter';
        header("location:visitor_info_report");
    }
}
// details report from visitor
if (isset($_POST['view_v_name_report'])) {
    $v_name = $_POST['v_name'];
    try {
        if ($v_name != "") {
            $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `name` like '%$v_name%'");
            v_info_view($sql_v_info);
        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Provide correct Info';
            header("location:visitor_info_report");
        }
    } catch (Exception $e) {
        $_SESSION['icon'] = 'info';
        $_SESSION['status'] = 'Please try again leter';
        header("location:visitor_info_report");
    }
}

// details report from visitor mobile no
if (isset($_POST['details_mobile_report'])) {
    $mobile_no = $_POST['mob_no'];
    try {
        if ($mobile_no != "") {
            if (strlen($mobile_no) == 10) {
                $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `contact_no` = '$mobile_no'");
                $file_name = "Visitor_Informaton";
                info_excel($sql_v_info, $file_name);

            } else {
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] = 'Please Entere 10 Digit Mobile no';
                header("location:visitor_info_report");
            }
        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Provide correct Info';
            header("location:visitor_info_report");
        }
    } catch (Exception $e) {
        $_SESSION['icon'] = 'info';
        $_SESSION['status'] = 'Please try again leter';
        header("location:visitor_info_report");
    }
}
// details report from visitor mobile no
if (isset($_POST['view_details_mobile_report'])) {
    $mobile_no = $_POST['mob_no'];
    try {
        if ($mobile_no != "") {
            if (strlen($mobile_no) == 10) {
                $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `contact_no` = '$mobile_no'");
                v_info_view($sql_v_info);
            } else {
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] = 'Please Entere 10 Digit Mobile no';
                header("location:visitor_info_report");
            }
        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Provide correct Info';
            header("location:visitor_info_report");
        }
    } catch (Exception $e) {
        $_SESSION['icon'] = 'info';
        $_SESSION['status'] = 'Please try again leter';
        header("location:visitor_info_report");
    }
}
// details report according govt id
if (isset($_POST['details_gvt_id'])) {
    $govt_id_type = $_POST['govt_type'];
    $govt_id = $_POST['gvt_no'];
    try {
        if ($govt_id_type != "" && $govt_id != "") {
            $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `govt_id_type` = '$govt_id_type' and `govt_id_no` = '$govt_id'");
            $file_name = "Visitor_Informaton";
            info_excel($sql_v_info, $file_name);
        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Provide correct Info';
            header("location:visitor_info_report");
        }
    } catch (Exception $e) {
        $_SESSION['icon'] = 'info';
        $_SESSION['status'] = 'Please try again leter';
        header("location:visitor_info_report");
    }
}
// details report view according govt id
if (isset($_POST['view_details_gvt_id'])) {
    $govt_id_type = $_POST['govt_type'];
    $govt_id = $_POST['gvt_no'];
    try {
        if ($govt_id_type != "" && $govt_id != "") {
            $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `govt_id_type` = '$govt_id_type' and `govt_id_no` = '$govt_id'");
            v_info_view($sql_v_info);
        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Provide correct Info';
            header("location:visitor_info_report");
        }
    } catch (Exception $e) {
        $_SESSION['icon'] = 'info';
        $_SESSION['status'] = 'Please try again leter';
        header("location:visitor_info_report");
    }
}
?>