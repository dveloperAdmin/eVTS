<?php
$approve_branch = "";
$approval = "";
$emp_status = "Approve";
$end_status = 'End';
$refer_status = "Deactive";
$check_emp_sql  = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` where `Emp_code` = '$v_emp_code'"));
if($check_emp_sql!=""){
    $approve_branch= $check_emp_sql['BranchId'];
    $check_approve_status = mysqli_fetch_assoc(mysqli_query($conn,"select * from `approval_sts` where `branch_id` = '$approve_branch'"));
    if($check_approve_status!=""){
        $approval= $check_approve_status['Approve_status'];
        if($approval == "Activate"){
            $emp_status = "Pending";
        }
        if($check_approve_status['meet_end_status'] == 'Activate'){
            $end_status = 'Pending';
        }
        if($check_approve_status['referral_status'] == 'Activate'){
            $refer_status = 'Active';
        }
    }
}




?>