<?php
$user_id = $_SESSION['user_id'];
$url = $_SERVER['REQUEST_URI'];
$month = date("M");
$year = date("Y");
$in_date = date("Y-m-d");
$no_of_row = mysqli_fetch_assoc(mysqli_query($conn, "select `uid` from `audi_log` order by `uid` desc"));
$log_id = "AUDI-" . time();
if ($des != "") {

    mysqli_query($conn, "insert into `audi_log`(`log_id`, `user_id`, `date_time`, `date`, `month`, `year`, `url`, `description`, `remarks`) values ('$log_id','$user_id',current_timestamp,'$in_date','$month','$year','$url','$des','$rem')");
}

// $user_id = $_SESSION['user_id'];
$emp_id = "";
$branch_id = "";
$user_data_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `uid`='$user_id'"));
$emp_id = $user_data_sql['EmployeeId'];
// $user_name = $user_data_sql['name'];
$user_role = $user_data_sql['user_role'];
// $emp_id = $user_data['EmployeeId'];
$emp_code_details = "";
$branchNameNav = "";

if ($emp_id != "") {

    $emp_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` where `EmployeeId` = '$emp_id'"));


    if ($emp_details != "") {
        $branch_id = $emp_details['BranchId'];
        $emp_code_details = $emp_details['Emp_code'];
        if (in_array($user_role, array("User", "Security", "Admin"))) {
            $branchDetails = mysqli_fetch_assoc(mysqli_query($conn, "select * from `branch` where `branch_code`='$branch_id'"));
            if ($branchDetails != "") {
                $branchNameNav = " - <span style='font-style:italic;'>" . $branchDetails['branch_name'] . "</span>";
            }
        }
    }
}

?>