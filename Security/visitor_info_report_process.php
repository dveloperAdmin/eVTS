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
    <th colspan = "13" style= "font-size: 23px;
     font-style: italic;">' . $comName . '</th>
    
    </tr>
    <tr>
    <th colspan = "13"style= "font-size: 18px;
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
                            <td><b>Times of Arrived <b></td>
                            <td><b>Times of Not Arrive<b></td>
                            <td><b>Total Times of Entries<b></td>
                       </tr>
                ';
    $branches = [];
    while ($row = mysqli_fetch_assoc($sql_data)) {
        $branches[$row['branch_id']][] = $row;
    }
    foreach ($branches as $branch_id => $visitors) {
        $datatable .= '<tr  style="text-align:center;">
        <th>Branch Name </th>
                              <th colspan = "12" style= "font-size: 28px; font-style: italic;"> ' . findBranch($conn, $branch_id) . '</th>
                    </tr>';
        $i = 1;
        foreach ($visitors as $info_report) {
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
                    <td>' . $info_report['arrive_count'] . '</td>
                    <td>' . (int) $info_report['visit_count'] - (int) $info_report['arrive_count'] . '</td>
                    <td>' . $info_report['visit_count'] . '</td>
            </tr>';
            $i++;
        }
        $datatable .= ' <tr style="text-align:center;"> <td colspan = "13">&nbsp;</td></tr>';
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
    <th colspan = "13" style= "font-size: 23px;
     font-style: italic;">' . $comName . '</th>
    
    </tr>
    <tr>
    <th colspan = "13"style= "font-size: 18px;
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
        <td><b>Times of Arrived <b></td>
        <td><b>Times of Not Arrive<b></td>
        <td><b>Total Times of Entries<b></td>
    </tr>
                ';
    $branches = [];
    while ($row = mysqli_fetch_assoc($sql_data)) {
        $branches[$row['branch_id']][] = $row;
    }
    foreach ($branches as $branch_id => $visitors) {
        $datatable .= '<tr  style="text-align:center;">
        <th>Branch Name </th>
                              <th colspan = "12" style= "font-size: 28px; font-style: italic;"> ' . findBranch($conn, $branch_id) . '</th>
                    </tr>';
        $i = 1;
        foreach ($visitors as $info_report) {
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
                    <td>' . $info_report['arrive_count'] . '</td>
                    <td>' . (int) $info_report['visit_count'] - (int) $info_report['arrive_count'] . '</td>
                    <td>' . $info_report['visit_count'] . '</td>
            </tr>';
            $i++;
        }
        $datatable .= ' <tr style="text-align:center;"> <td colspan = "13">&nbsp;</td></tr>';
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
            if (in_array($user_role, array("Developer", "Super Admin"))) {
                $sql_v_info = mysqli_query($conn, "SELECT vi.*, vi.visitor_id, vi.name, vl.branch_id, MAX(vl.Arrival_time_stamp) AS last_visit_time, COUNT(vl.visitor_id) AS visit_count,COUNT(CASE WHEN vl.Arrival_time_stamp != '0000-00-00 00:00:00' THEN 1 END) AS arrive_count FROM visitor_info vi inner JOIN visitor_log vl ON vi.visitor_id = vl.visitor_id where vl.Arrival_time_stamp between '$from_date' and '$to_date' GROUP BY vi.visitor_id, vi.name, vl.branch_id ORDER BY vl.branch_id ASC");
            } else {
                $sql_v_info = mysqli_query($conn, "SELECT vi.*, vi.visitor_id, vi.name, vl.branch_id, MAX(vl.Arrival_time_stamp) AS last_visit_time, COUNT(vl.visitor_id) AS visit_count,COUNT(CASE WHEN vl.Arrival_time_stamp != '0000-00-00 00:00:00' THEN 1 END) AS arrive_count FROM visitor_info vi inner JOIN visitor_log vl ON vi.visitor_id = vl.visitor_id where  vl.branch_id = '$branch_id' AND vl.Arrival_time_stamp between '$from_date' and '$to_date' GROUP BY vi.visitor_id, vi.name, vl.branch_id ORDER BY vl.branch_id ASC");
            }

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
            if (in_array($user_role, array("Developer", "Super Admin"))) {
                $sql_v_info = mysqli_query($conn, "SELECT vi.*, vi.visitor_id, vi.name, vl.branch_id, MAX(vl.Arrival_time_stamp) AS last_visit_time, COUNT(vl.visitor_id) AS visit_count,COUNT(CASE WHEN vl.Arrival_time_stamp != '0000-00-00 00:00:00' THEN 1 END) AS arrive_count FROM visitor_info vi inner JOIN visitor_log vl ON vi.visitor_id = vl.visitor_id where vl.Arrival_time_stamp between '$from_date' and '$to_date' GROUP BY vi.visitor_id, vi.name, vl.branch_id ORDER BY vl.branch_id ASC");
            } else {
                $sql_v_info = mysqli_query($conn, "SELECT vi.*, vi.visitor_id, vi.name, vl.branch_id, MAX(vl.Arrival_time_stamp) AS last_visit_time, COUNT(vl.visitor_id) AS visit_count,COUNT(CASE WHEN vl.Arrival_time_stamp != '0000-00-00 00:00:00' THEN 1 END) AS arrive_count FROM visitor_info vi inner JOIN visitor_log vl ON vi.visitor_id = vl.visitor_id where  vl.branch_id = '$branch_id' AND vl.Arrival_time_stamp between '$from_date' and '$to_date' GROUP BY vi.visitor_id, vi.name, vl.branch_id ORDER BY vl.branch_id ASC");
            }
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
            if (in_array($user_role, array("Developer", "Super Admin"))) {
                $sql_v_info = mysqli_query($conn, "SELECT vi.*, vi.visitor_id, vi.name, vl.branch_id, MAX(vl.Arrival_time_stamp) AS last_visit_time, COUNT(vl.visitor_id) AS visit_count,COUNT(CASE WHEN vl.Arrival_time_stamp != '0000-00-00 00:00:00' THEN 1 END) AS arrive_count FROM visitor_info vi inner JOIN visitor_log vl ON vi.visitor_id = vl.visitor_id where vi.name LIKE '%$v_name%' GROUP BY vi.visitor_id, vi.name, vl.branch_id ORDER BY vl.branch_id ASC");
            } else {
                $sql_v_info = mysqli_query($conn, "SELECT vi.*, vi.visitor_id, vi.name, vl.branch_id, MAX(vl.Arrival_time_stamp) AS last_visit_time, COUNT(vl.visitor_id) AS visit_count, COUNT(CASE WHEN vl.Arrival_time_stamp != '0000-00-00 00:00:00' THEN 1 END) AS arrive_count  FROM visitor_info vi inner JOIN visitor_log vl ON vi.visitor_id = vl.visitor_id where  vl.branch_id = '$branch_id' AND vi.name LIKE '%$v_name%' GROUP BY vi.visitor_id, vi.name, vl.branch_id ORDER BY vl.branch_id ASC");
            }
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
            if (in_array($user_role, array("Developer", "Super Admin"))) {
                $sql_v_info = mysqli_query($conn, "SELECT vi.*, vi.visitor_id, vi.name, vl.branch_id, MAX(vl.Arrival_time_stamp) AS last_visit_time, COUNT(vl.visitor_id) AS visit_count,COUNT(CASE WHEN vl.Arrival_time_stamp != '0000-00-00 00:00:00' THEN 1 END) AS arrive_count FROM visitor_info vi inner JOIN visitor_log vl ON vi.visitor_id = vl.visitor_id where  vi.name LIKE '%$v_name%' GROUP BY vi.visitor_id, vi.name, vl.branch_id ORDER BY vl.branch_id ASC");
            } else {
                $sql_v_info = mysqli_query($conn, "SELECT vi.*, vi.visitor_id, vi.name, vl.branch_id, MAX(vl.Arrival_time_stamp) AS last_visit_time, COUNT(vl.visitor_id) AS visit_count,COUNT(CASE WHEN vl.Arrival_time_stamp != '0000-00-00 00:00:00' THEN 1 END) AS arrive_count FROM visitor_info vi inner JOIN visitor_log vl ON vi.visitor_id = vl.visitor_id where  vl.branch_id = '$branch_id' AND vi.name LIKE '%$v_name%' GROUP BY vi.visitor_id, vi.name, vl.branch_id ORDER BY vl.branch_id ASC");
            }
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
                if (in_array($user_role, array("Developer", "Super Admin"))) {
                    $sql_v_info = mysqli_query($conn, "SELECT vi.*, vi.visitor_id, vi.name, vl.branch_id, MAX(vl.Arrival_time_stamp) AS last_visit_time, COUNT(vl.visitor_id) AS visit_count,COUNT(CASE WHEN vl.Arrival_time_stamp != '0000-00-00 00:00:00' THEN 1 END) AS arrive_count FROM visitor_info vi inner JOIN visitor_log vl ON vi.visitor_id = vl.visitor_id where vi.`contact_no` = '$mobile_no' GROUP BY vi.visitor_id, vi.name, vl.branch_id ORDER BY vl.branch_id ASC");
                } else {
                    $sql_v_info = mysqli_query($conn, "SELECT vi.*, vi.visitor_id, vi.name, vl.branch_id, MAX(vl.Arrival_time_stamp) AS last_visit_time, COUNT(vl.visitor_id) AS visit_count,COUNT(CASE WHEN vl.Arrival_time_stamp != '0000-00-00 00:00:00' THEN 1 END) AS arrive_count FROM visitor_info vi inner JOIN visitor_log vl ON vi.visitor_id = vl.visitor_id where  vl.branch_id = '$branch_id' AND vi.`contact_no` = '$mobile_no'  GROUP BY vi.visitor_id, vi.name, vl.branch_id ORDER BY vl.branch_id ASC");
                }
                // $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `contact_no` = '$mobile_no'");
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
                if (in_array($user_role, array("Developer", "Super Admin"))) {
                    $sql_v_info = mysqli_query($conn, "SELECT vi.*, vi.visitor_id, vi.name, vl.branch_id, MAX(vl.Arrival_time_stamp) AS last_visit_time, COUNT(vl.visitor_id) AS visit_count,COUNT(CASE WHEN vl.Arrival_time_stamp != '0000-00-00 00:00:00' THEN 1 END) AS arrive_count FROM visitor_info vi inner JOIN visitor_log vl ON vi.visitor_id = vl.visitor_id where vi.`contact_no` = '$mobile_no' GROUP BY vi.visitor_id, vi.name, vl.branch_id ORDER BY vl.branch_id ASC");
                } else {
                    $sql_v_info = mysqli_query($conn, "SELECT vi.*, vi.visitor_id, vi.name, vl.branch_id, MAX(vl.Arrival_time_stamp) AS last_visit_time, COUNT(vl.visitor_id) AS visit_count,COUNT(CASE WHEN vl.Arrival_time_stamp != '0000-00-00 00:00:00' THEN 1 END) AS arrive_count FROM visitor_info vi inner JOIN visitor_log vl ON vi.visitor_id = vl.visitor_id where  vl.branch_id = '$branch_id' AND vi.`contact_no` = '$mobile_no'  GROUP BY vi.visitor_id, vi.name, vl.branch_id ORDER BY vl.branch_id ASC");
                }
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
            if (in_array($user_role, array("Developer", "Super Admin"))) {
                $sql_v_info = mysqli_query($conn, "SELECT vi.*, vi.visitor_id, vi.name, vl.branch_id, MAX(vl.Arrival_time_stamp) AS last_visit_time, COUNT(vl.visitor_id) AS visit_count,COUNT(CASE WHEN vl.Arrival_time_stamp != '0000-00-00 00:00:00' THEN 1 END) AS arrive_count FROM visitor_info vi inner JOIN visitor_log vl ON vi.visitor_id = vl.visitor_id where vi.`govt_id_type` = '$govt_id_type' and vi.`govt_id_no` = '$govt_id' GROUP BY vi.visitor_id, vi.name, vl.branch_id ORDER BY vl.branch_id ASC");
            } else {
                $sql_v_info = mysqli_query($conn, "SELECT vi.*, vi.visitor_id, vi.name, vl.branch_id, MAX(vl.Arrival_time_stamp) AS last_visit_time, COUNT(vl.visitor_id) AS visit_count,COUNT(CASE WHEN vl.Arrival_time_stamp != '0000-00-00 00:00:00' THEN 1 END) AS arrive_count FROM visitor_info vi inner JOIN visitor_log vl ON vi.visitor_id = vl.visitor_id where  vl.branch_id = '$branch_id' AND vi.`govt_id_type` = '$govt_id_type' and vi.`govt_id_no` = '$govt_id'  GROUP BY vi.visitor_id, vi.name, vl.branch_id ORDER BY vl.branch_id ASC");
            }
            // $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `govt_id_type` = '$govt_id_type' and `govt_id_no` = '$govt_id'");
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
            if (in_array($user_role, array("Developer", "Super Admin"))) {
                $sql_v_info = mysqli_query($conn, "SELECT vi.*, vi.visitor_id, vi.name, vl.branch_id, MAX(vl.Arrival_time_stamp) AS last_visit_time, COUNT(vl.visitor_id) AS visit_count,COUNT(CASE WHEN vl.Arrival_time_stamp != '0000-00-00 00:00:00' THEN 1 END) AS arrive_count FROM visitor_info vi inner JOIN visitor_log vl ON vi.visitor_id = vl.visitor_id where vi.`govt_id_type` = '$govt_id_type' and vi.`govt_id_no` = '$govt_id' GROUP BY vi.visitor_id, vi.name, vl.branch_id ORDER BY vl.branch_id ASC");
            } else {
                $sql_v_info = mysqli_query($conn, "SELECT vi.*, vi.visitor_id, vi.name, vl.branch_id, MAX(vl.Arrival_time_stamp) AS last_visit_time, COUNT(vl.visitor_id) AS visit_count,COUNT(CASE WHEN vl.Arrival_time_stamp != '0000-00-00 00:00:00' THEN 1 END) AS arrive_count FROM visitor_info vi inner JOIN visitor_log vl ON vi.visitor_id = vl.visitor_id where  vl.branch_id = '$branch_id' AND vi.`govt_id_type` = '$govt_id_type' and vi.`govt_id_no` = '$govt_id'  GROUP BY vi.visitor_id, vi.name, vl.branch_id ORDER BY vl.branch_id ASC");
            }
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