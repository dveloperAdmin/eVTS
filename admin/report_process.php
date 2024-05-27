<head>

    <title>CMS</title>
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
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
    </style>
</head>



<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des = "Page Load Report Process";
$rem = "Report Process";
include '../include/_audi_log.php';
include '../include/_function.php';

// date modifi function
function date_edit_1($input_date)
{
    $temp_expire_date = $input_date;   //gate row date from date picker
    $t_1 = substr($temp_expire_date, 8, 2);    //days
    $t_2 = substr($temp_expire_date, 5, 2); //month
    $t_3 = substr($temp_expire_date, 0, 4); //year
    $temp_apply_date_arrange = $t_1 . "-" . $t_2 . "-" . $t_3;  //date arrange
    $get_apply_date = date("d-M-Y", strtotime($temp_apply_date_arrange));

    return ($get_apply_date);
}

//log report function
function table_data($data)
{
    include '../include/_dbconnect.php';
    // include '../include/_function.php';
    $comName = mysqli_fetch_assoc(mysqli_query($conn, "select * from company_details"));
    if ($comName != "") {
        $comName = $comName['companyFname'];
    } else {
        $comName = "";
    }
    $datatable = "<table border='1' style='text-align:center;'>
     <tr>
        <th colspan = '11' style= 'font-size: 23px; font-style: italic;'>" . $comName . "</th>
        
    </tr>
    <tr>
        <th colspan = '11'style= 'font-size: 18px;font-style: italic;' >LogIn Report</th>
    
    </tr>

    <tr>
        <th>Sl NO</th>
        <th>Log ID</th>
        <th>User ID</th>
        <th>Name</th>
        <th>Branch</th>
        <th>Role</th>
        <th>Status</th>
        <th>Login Date</th>
        <th>Login Time</th>
        <th>Logout Date</th>
        <th>Logout Time</th>
        <th>Log Status</th>
    </tr>";

    $setdata = "";
    $i = 0;
    while ($rec = mysqli_fetch_assoc($data)) {
        $i++;
        $user_id = $rec['user_id'];
        $user_data_pick = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `uid`='$user_id'"));

        if ($rec != "" && $user_data_pick != "") {

            $user_name = $user_data_pick['user_name'];



            $datatable .= "<tr>
            <td>" . $i . "</td>
            <td>" . $rec['uid'] . "</td>
            <td>" . $user_name . "</td>
            <td>" . $user_data_pick['name'] . "</td>
            <td>" . findBranch($conn, $rec['BranchId']) . "</td>
            <td>" . $user_data_pick['user_role'] . "</td>
            <td>" . $user_data_pick['user_sts'] . "</td>
            <td>" . $rec['login_date'] . "</td>
            <td>" . $rec['login_time'] . "</td>
            <td>" . $rec['logout_date'] . "</td>
            <td>" . $rec['logout_time'] . "</td>
            <td>" . $rec['status'] . "</td>
        </tr>";
        }
    }
    $datatable .= "</table>";
    return ($datatable);
}

//Audit Log report function
function audit_table_data($data)
{
    include '../include/_dbconnect.php';
    $comName = mysqli_fetch_assoc(mysqli_query($conn, "select * from company_details"));
    if ($comName != "") {
        $comName = $comName['companyFname'];
    } else {
        $comName = "";
    }
    $datatable = "<table border='1' style='text-align:center;'>
   <tr>
   <th colspan = '9' style= 'font-size: 23px;
    font-style: italic;'>" . $comName . "</th>
   
   </tr>
   <tr>
   <th colspan = '9'style= 'font-size: 18px;
    font-style: italic;' >Audit Log Report</th>
   
   </tr>


    <tr>
        <th>Sl NO</th>
        <th>Log ID</th>
        <th>User Name</th>
        <th>Name</th>
        <th>Branch</th>
        <th>Date Time</th>
        <th>Url</th>
        <th>Description</th>
        <th>Remarks</th>
        
    </tr>";

    $setdata = "";
    $i = 0;
    while ($rec = mysqli_fetch_assoc($data)) {
        $i++;
        $user_id = $rec['user_id'];
        $user_name = "Data not available";
        $name = "Data not available";
        $branch = "Data not available";
        $user_data_pick_2 = mysqli_fetch_assoc(mysqli_query($conn, "select u.*, coalesce(b.branch_name,'') as branch from `user` u left join branch b on u.BranchId = b.branch_code where u.`uid`='$user_id'"));
        if ($user_data_pick_2 != "") {
            $user_name = $user_data_pick_2['user_name'];
            $name = $user_data_pick_2['name'];
            $branch = $user_data_pick_2['branch'];

        }




        $datatable .= "<tr>
        <td>" . $i . "</td>
        <td>" . $rec['log_id'] . "</td>
        <td>" . $user_name . "</td>
        <td>" . $name . "</td>
        <td>" . $branch . "</td>
        <td>" . $rec['date_time'] . "</td>
        
        <td>" . $rec['url'] . "</td>
        <td>" . $rec['description'] . "</td>
        <td>" . $rec['remarks'] . "</td>
        
    </tr>";
    }
    $datatable .= "</table>";
    return ($datatable);
}

//TXN LOG report function
function txn_table_data($data)
{
    include '../include/_dbconnect.php';

    $datatable = "<table border='1' style='text-align:center;'>

    <tr>
        <th>Sl NO</th>
        <th>Device Serial no</th>
        <th>Device Name</th>
        <th>Employee Code</th>
        <th>Employee Name</th>
        <th>Log Date Time</th>
        
        
    </tr>";

    $setdata = "";
    $i = 0;
    while ($rec = mysqli_fetch_assoc($data)) {
        $i++;
        $user_id = $rec['UserId'];
        $device_id = $rec['DeviceId'];
        $LOg_details = $rec['LogDate'];
        $user_name = "";
        $device_name = "";
        $device_sl_no = "";
        $user_data_pick_2 = mysqli_fetch_assoc(mysqli_query($conn_bio, "select * from `employees` where `EmployeeCode`='$user_id'"));
        if ($user_data_pick_2 != "") {
            $user_name = $user_data_pick_2['EmployeeName'];
            // $name =$user_data_pick_2['name'];

        }
        $device_sql = mysqli_fetch_assoc(mysqli_query($conn_bio, "select * from `devices` where `DeviceId`='$device_id'"));
        if ($device_sql != "") {
            $device_name = $device_sql['DeviceFName'];
            $device_sl_no = $device_sql['SerialNumber'];
            // $name =$user_data_pick_2['name'];

        }





        $datatable .= "<tr>
        <td>" . $i . "</td>
        <td>" . $device_sl_no . "</td>
        <td>" . $device_name . "</td>
        <td>" . $user_id . "</td>
        <td>" . $user_name . "</td>
        <td>" . $LOg_details . "</td>
        
        
    </tr>";
    }
    $datatable .= "</table>";
    return ($datatable);
}








// Txn log report xls
if (isset($_POST['mon_txr_xls'])) {
    $month = $_POST['month_report'];
    $year = $_POST['year_report'];

    if ($month != "" && $year != "") {
        $table_name = "devicelogs_" . $month . "_" . $year;
        $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio, "select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
        if ($sql_check_table > 0) {

            $sql_get_data = mysqli_query($conn_bio, "select * from `$table_name`");

            $datatable = txn_table_data($sql_get_data);

            $fname = $month . "_" . $year . "_Txnlog_report.xls";
            header('Content-Type:application/octet-stream');
            header('Content-Disposition:attachment; filename=' . $fname);

            echo $datatable;

            $des = "Txn Log report download";
            $rem = " TXn Log Report";
            include "../include/_audi_log.php";

            exit;
        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Data Not Found';

            header("location:txn_log");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Missing Input';

        header("location:txn_log");
    }
}
// Txn log report pdf
if (isset($_POST['mon_txr_pdf'])) {
    $month = $_POST['month_report'];
    $year = $_POST['year_report'];

    if ($month != "" && $year != "") {
        $table_name = "devicelogs_" . $month . "_" . $year;
        $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio, "select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
        if ($sql_check_table > 0) {

            $sql_get_data = mysqli_query($conn_bio, "select * from `$table_name`");

            $datatable = txn_table_data($sql_get_data);

            echo '
            <button class="btn-primary"  onclick="window.print()">Print</button>
            <a href="txn_log.php"><button class="btn-primary" >Back</button></a>
            ';
            echo '<div class="print_container" style="">' . $datatable . '</div>';

            $des = "Txn Log report download";
            $rem = " TXn Log Report";
            include "../include/_audi_log.php";

            exit;
        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Data Not Found';

            header("location:txn_log");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Missing Input';

        header("location:txn_log");
    }
}


// date wise report in xls
if (isset($_POST['date_r_xls'])) {
    $in_date = $_POST['date_report'];
    $data = date_edit_1($in_date);
    if ($in_date != "") {
        if (in_array($user_role, array("Developer", "Super Admin"))) {
            if ($user_role == 'Developer') {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where lb.`login_date` ='$data'";
            } else {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where u.user_role!='Developer' and lb.`login_date` ='$data'";
            }
            $sql_get_data = mysqli_query($conn, $userSql);

        } else {
            $sql_get_data = mysqli_query($conn, "select * from `log_book` lb left join `user` u on  where lb.`login_date` ='$data' and u.BranchId = '$branch_id'");
        }

        if ($sql_get_data != "") {
            $datatable = table_data($sql_get_data);

            $fname = $in_date . "_log_report.xls";
            header('Content-Type:application/octet-stream');
            header('Content-Disposition:attachment; filename=' . $fname);

            echo $datatable;

            $des = "Log report download";
            $rem = "Log Report";
            include "../include/_audi_log.php";

            exit;

        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Data Not Found';

            header("location:log_report");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Missing Input';

        header("location:log_report");
    }
}


// month wise report in xls
if (isset($_POST['mon_r_xls'])) {
    $month = $_POST['month_report'];
    $year = $_POST['year_report'];

    if ($month != "" && $year != "") {
        if (in_array($user_role, array("Developer", "Super Admin"))) {
            if ($user_role == 'Developer') {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where lb.`log_month` ='$month' and lb.`log_year` ='$year'";
            } else {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where u.user_role!='Developer' and lb.`log_month` ='$month' and lb.`log_year` ='$year'";
            }
            $sql_get_data = mysqli_query($conn, $userSql);

        } else {
            $sql_get_data = mysqli_query($conn, "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where lb.`log_month` ='$month' and lb.`log_year` ='$year' and u.BranchId = '$branch_id'");
        }
        // $sql_get_data = mysqli_query($conn, "select * from `log_book` where `log_month` ='$month' and `log_year` ='$year'");

        if ($sql_get_data != "") {
            $datatable = table_data($sql_get_data);

            $fname = $month . '_' . $year . "_log_report.xls";
            header('Content-Type:application/octet-stream');
            header('Content-Disposition:attachment; filename=' . $fname);

            echo $datatable;

            $des = "Log report download";
            $rem = "Log Report";
            include "../include/_audi_log.php";

            exit;

        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Data Not Found';

            header("location:log_report");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Missing Input';

        header("location:log_report");
    }
}



//EMP user wise Audi report in xls
if (isset($_POST['emp_audi_xls'])) {
    $emp_id = $_POST['emp_id_report'];
    if ($emp_id != "") {

        // if ($emp_id == 1) {
        //     $sql_get_data = mysqli_query($conn, "select * from `audi_log`");
        //     $user_name = "All";
        // } else {
        //     $sql_get_data = mysqli_query($conn, "select * from `log_book`where `user_id`='$emp_id'");
        //     $sql_get_data2 = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `uid`='$emp_id'"));
        //     $user_name = $sql_get_data2['user_name'];
        // }
        if ($emp_id == 1) {
            if (in_array($user_role, array("Developer", "Super Admin"))) {
                $sql_get_data = mysqli_query($conn, "select * from audi_log");
            } else {
                $sql_get_data = mysqli_query($conn, "select al.* from audi_log al join user u on al.user_id = u.uid where u.user_role!='Developer' and u.BranchId='$branch_id'");
            }
            $user_name = "All";
        } else {
            if (in_array($user_role, array("Developer", "Super Admin"))) {
                $sql_get_data = mysqli_query($conn, "select * from `audi_log` where `user_id`='$emp_id'");
            } else {
                $sql_get_data = mysqli_query($conn, "select al.* from audi_log al join user u on al.user_id = u.uid where u.user_role!='Developer' and u.BranchId='$branch_id' and al.`user_id`='$emp_id'");
            }
            $sql_get_data2 = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `uid`='$emp_id'"));
            $user_name = $sql_get_data2['user_name'];

        }

        if ($sql_get_data != "") {
            $datatable = audit_table_data($sql_get_data);

            $fname = $user_name . "_audi_report.xls";
            header('Content-Type:application/octet-stream');
            header('Content-Disposition:attachment; filename=' . $fname);

            echo $datatable;

            $des = "Audi Log report download";
            $rem = "Audi Log Report";
            include "../include/_audi_log.php";

            exit;

        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Data Not Found';

            header("location:audit_log_report");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Missing Input';

        header("location:audit_log_report");
    }
}
//date  wise Audi report in xls
if (isset($_POST['date_audi_xls'])) {
    $date = $_POST['date_report'];
    $date_m = date_edit_1($date);
    if ($date != "") {


        if (in_array($user_role, array("Developer", "Super Admin"))) {
            $sql_get_data = mysqli_query($conn, "select * from `audi_log` where `date`='$date'");
        } else {
            $sql_get_data = mysqli_query($conn, "select al.* from audi_log al join user u on al.user_id = u.uid where u.BranchId='$branch_id' and al.`date`='$date' ");
        }



        if ($sql_get_data != "") {
            $datatable = audit_table_data($sql_get_data);

            $fname = $date_m . "_audi_report.xls";
            header('Content-Type:application/octet-stream');
            header('Content-Disposition:attachment; filename=' . $fname);

            echo $datatable;

            $des = "Audi Log report download";
            $rem = "Audi Log Report";
            include "../include/_audi_log.php";

            exit;

        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Data Not Found';

            header("location:audit_log_report");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Missing Input';

        header("location:audit_log_report");
    }
}
//Month  wise Audi report in xls
if (isset($_POST['mon_audit_xls'])) {
    $month = $_POST['month_report'];
    $year = $_POST['year_report'];

    if ($month != "" && $year != "") {
        $sql_get_data = mysqli_query($conn, "select * from `audi_log` where `month`='$month' and `year`='$year'");

        if (in_array($user_role, array("Developer", "Super Admin"))) {
            $sql_get_data = mysqli_query($conn, "select * from `audi_log` where `month`='$month' and `year`='$year'");
        } else {
            $sql_get_data = mysqli_query($conn, "select al.* from audi_log al join user u on al.user_id = u.uid where u.user_role!='Developer' and u.BranchId='$branch_id' and al.`month`='$month' and al.`year`='$year' ");
        }
        if ($sql_get_data != "") {
            $datatable = audit_table_data($sql_get_data);

            $fname = $month . '_' . $year . "_audi_report.xls";
            header('Content-Type:application/octet-stream');
            header('Content-Disposition:attachment; filename=' . $fname);

            echo $datatable;

            $des = "Audi Log report download";
            $rem = "Audi Log Report";
            include "../include/_audi_log.php";

            exit;

        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Data Not Found';

            header("location:audit_log_report");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Missing Input';

        header("location:audit_log_report");
    }
}

// user report in xls
if (isset($_POST['emp_r_xls'])) {
    $emp_id = $_POST['userCode'];
    if ($emp_id != "") {
        if ($emp_id == "VMS-U-1") {
            if (in_array($user_role, array("Developer", "Super Admin"))) {
                if ($user_role == 'Developer') {
                    $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid";
                } else {
                    $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where u.user_role!='Developer'";
                }

            } else {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where u.user_role!='Developer' and u.BranchId = '$branch_id'";
            }
            $user_name = "All";
        } else {
            $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where lb.`user_id`='$emp_id'";
            $sql_get_data2 = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `uid`='$emp_id'"));
            $user_name = $sql_get_data2['user_name'];

        }
        $sql_get_data = mysqli_query($conn, $userSql);

        if ($sql_get_data != "") {
            $datatable = table_data($sql_get_data);

            $fname = $user_name . "_log_report.xls";
            header('Content-Type:application/octet-stream');
            header('Content-Disposition:attachment; filename=' . $fname);

            echo $datatable;

            $des = "Log report download";
            $rem = "Log Report";
            include "../include/_audi_log.php";

            exit;

        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Data Not Found';

            header("location:log_report");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Missing Input';

        header("location:log_report");
    }
}
// user report in pdf
if (isset($_POST['emp_r_pdf'])) {
    $emp_id = $_POST['userCode'];

    if ($emp_id != "") {

        if ($emp_id == "VMS-U-1") {
            if (in_array($user_role, array("Developer", "Super Admin"))) {
                if ($user_role == 'Developer') {
                    $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid";
                } else {
                    $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where u.user_role!='Developer'";
                }

            } else {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where u.user_role!='Developer' and u.BranchId = '$branch_id'";
            }
        } else {
            $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where lb.`user_id`='$emp_id'";

        }
        $sql_get_data = mysqli_query($conn, $userSql);
        if ($sql_get_data != "") {
            $datatable = table_data($sql_get_data);


            echo '
                 <button class="btn-primary"  onclick="window.print()">Print</button>
                 <a href="log_report.php"><button class="btn-primary" >Back</button></a>
                 ';
            echo '<div class="print_container" style="">' . $datatable . '</div>';

        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Data Not Found';

            header("location:log_report");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Missing Input';

        header("location:log_report");
    }
}


// date wise report in pdf
if (isset($_POST['bran_r_pdf'])) {
    $branchData = $_POST['branchData'];
    $fromdate = $_POST['fromDate'];
    $todate = $_POST['toDate'];
    $fromDate = date_edit_1($fromdate);
    $toDate = date_edit_1($todate);

    if ($in_date != "" && $branchData != "") {
        if ($branchData === "All") {
            if ($user_role == 'Developer') {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where lb.`login_date` in ('$fromDate','$toDate')";
            } else {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where u.user_role!='Developer' and lb.`login_date` in ('$fromDate','$toDate')";
            }
        } else {
            if ($user_role == 'Developer') {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where u.BranchId = '$branchData' and lb.`login_date` in ('$fromDate','$toDate')";
            } else {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where  u.BranchId = '$branchData' and  u.user_role!='Developer' and lb.`login_date` in ('$fromDate','$toDate')";
            }
        }
        $sql_get_data = mysqli_query($conn, $userSql);
        if ($sql_get_data != "") {
            $datatable = table_data($sql_get_data);

            echo '
                 <button class="btn-primary" onclick="window.print()">Print</button>
                 <a href="log_report.php"><button class="btn-primary" >Back</button></a>
                 ';
            echo '<div class="print_container" style="">' . $datatable . '</div>';

        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Data Not Found';

            header("location:log_report");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Missing Input';

        header("location:log_report");
    }
}
// date wise report in pdf
if (isset($_POST['bran_r_xls'])) {
    $branchData = $_POST['branchData'];
    $fromdate = $_POST['fromDate'];
    $todate = $_POST['toDate'];
    $fromDate = date_edit_1($fromdate);
    $toDate = date_edit_1($todate);

    if ($in_date != "" && $branchData != "") {
        if ($branchData === "All") {
            if ($user_role == 'Developer') {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where lb.`login_date` in ('$fromDate','$toDate')";
            } else {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where u.user_role!='Developer' and lb.`login_date` in ('$fromDate','$toDate')";
            }
            $fileName = "All_Branch";
        } else {
            if ($user_role == 'Developer') {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where u.BranchId = '$branchData' and lb.`login_date` in ('$fromDate','$toDate')";
            } else {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where  u.BranchId = '$branchData' and  u.user_role!='Developer' and lb.`login_date` in ('$fromDate','$toDate')";
            }
            $fileName = findBranch($conn, $branchData);
        }
        $sql_get_data = mysqli_query($conn, $userSql);
        if ($sql_get_data != "") {
            $datatable = table_data($sql_get_data);

            $fname = $fileName . "_log_report.xls";
            header('Content-Type:application/octet-stream');
            header('Content-Disposition:attachment; filename=' . $fname);

            echo $datatable;
        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Data Not Found';

            header("location:log_report");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Missing Input';

        header("location:log_report");
    }
}
if (isset($_POST['date_r_pdf'])) {
    $in_date = $_POST['date_report'];
    $data = date_edit_1($in_date);
    if ($in_date != "") {
        if (in_array($user_role, array("Developer", "Super Admin"))) {
            if ($user_role == 'Developer') {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where lb.`login_date` ='$data'";
            } else {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where u.user_role!='Developer' and lb.`login_date` ='$data'";
            }
            $sql_get_data = mysqli_query($conn, $userSql);

        } else {
            $sql_get_data = mysqli_query($conn, "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where lb.`login_date` ='$data' and u.BranchId = '$branch_id'");
        }
        if ($sql_get_data != "") {
            $datatable = table_data($sql_get_data);


            echo '
                 <button class="btn-primary" onclick="window.print()">Print</button>
                 <a href="log_report.php"><button class="btn-primary" >Back</button></a>
                 ';
            echo '<div class="print_container" style="">' . $datatable . '</div>';

        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Data Not Found';

            header("location:log_report");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Missing Input';

        header("location:log_report");
    }
}


// month wise report in pdf
if (isset($_POST['mon_r_pdf'])) {
    $month = $_POST['month_report'];
    $year = $_POST['year_report'];

    if ($month != "" && $year != "") {
        if (in_array($user_role, array("Developer", "Super Admin"))) {
            if ($user_role == 'Developer') {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where lb.`log_month` ='$month' and lb.`log_year` ='$year'";
            } else {
                $userSql = "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where u.user_role!='Developer' and lb.`log_month` ='$month' and lb.`log_year` ='$year'";
            }
            $sql_get_data = mysqli_query($conn, $userSql);

        } else {
            $sql_get_data = mysqli_query($conn, "select * from `log_book` lb left join `user` u on lb.user_id = u.uid where lb.`log_month` ='$month' and lb.`log_year` ='$year' and u.BranchId = '$branch_id'");
        }
        // $sql_get_data = mysqli_query($conn, "select * from `log_book` where `log_month` ='$month' and `log_year` ='$year'");

        if ($sql_get_data != "") {
            $datatable = table_data($sql_get_data);


            echo '
                 <button class="btn-primary" onclick="window.print()">Print</button>
                 <a href="log_report.php"><button class="btn-primary" >Back</button></a>
                 ';
            echo '<div class="print_container" style="">' . $datatable . '</div>';

        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Data Not Found';

            header("location:log_report");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Missing Input';

        header("location:log_report");
    }
}



// emp wise audi log report in pdf
if (isset($_POST['emp_audi_pdf'])) {
    $emp_id = $_POST['emp_id_report'];
    if ($emp_id != "") {
        if (in_array($user_role, array("Developer", "Super Admin"))) {
            if ($emp_id == 1) {
                $sql_get_data = mysqli_query($conn, "select * from `audi_log`");
            } else {
                $sql_get_data = mysqli_query($conn, "select * from `audi_log` where `user_id`='$emp_id'");
            }
        } else {
            if ($emp_id == 1) {
                $sql_get_data = mysqli_query($conn, "select al.* from audi_log al join user u on al.user_id = u.uid where u.user_role!='Developer' and u.BranchId='$branch_id'");
            } else {
                $sql_get_data = mysqli_query($conn, "select al.* from audi_log al join user u on al.user_id = u.uid where u.user_role!='Developer' and u.BranchId='$branch_id' and al.`user_id`='$emp_id'");
            }

        }
        if ($sql_get_data != "") {
            $datatable = audit_table_data($sql_get_data);


            echo '
                 <button class="btn-primary"  onclick="window.print()">Print</button>
                 <a href="audit_log_report.php"><button class="btn-primary">Back</button></a>
                 ';
            echo '<div class="print_container" style="">' . $datatable . '</div>';

        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Data Not Found';

            header("location:audit_log_report");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Missing Input';

        header("location:audit_log_report");
    }
}
// date wise audi log report in pdf
if (isset($_POST['date_audi_pdf'])) {
    $date = $_POST['date_report'];
    if ($date != "") {
        if (in_array($user_role, array("Developer", "Super Admin"))) {
            $sql_get_data = mysqli_query($conn, "select * from `audi_log` where `date`='$date'");
        } else {
            $sql_get_data = mysqli_query($conn, "select al.* from audi_log al join user u on al.user_id = u.uid where u.BranchId='$branch_id' and al.`date`='$date' ");
        }

        if ($sql_get_data != "") {
            $datatable = audit_table_data($sql_get_data);


            echo '
                 <button class="btn-primary"  onclick="window.print()">Print</button>
                 <a href="audit_log_report.php"><button class="btn-primary" >Back</button></a>
                 ';
            echo '<div class="print_container" style="">' . $datatable . '</div>';

        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Data Not Found';

            header("location:audit_log_report");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Missing Input';

        header("location:audit_log_report");
    }
}

// month wise report in pdf
if (isset($_POST['mon_audi_pdf'])) {
    $month = $_POST['month_report'];
    $year = $_POST['year_report'];

    if ($month != "" && $year != "") {
        if (in_array($user_role, array("Developer", "Super Admin"))) {
            $sql_get_data = mysqli_query($conn, "select * from `audi_log` where `month`='$month' and `year`='$year'");
        } else {
            $sql_get_data = mysqli_query($conn, "select al.* from audi_log al join user u on al.user_id = u.uid where u.user_role!='Developer' and u.BranchId='$branch_id' and al.`month`='$month' and al.`year`='$year' ");
        }

        if ($sql_get_data != "") {
            $datatable = audit_table_data($sql_get_data);


            echo '
                 <button class="btn-primary" onclick="window.print()">Print</button>
                 <a href="audit_log_report.php"><button class="btn-primary" >Back</button></a>
                 ';
            echo '<div class="print_container" style="">' . $datatable . '</div>';

        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Data Not Found';

            header("location:audit_log_report");
        }

    } else {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Missing Input';

        header("location:audit_log_report");
    }
}






?>