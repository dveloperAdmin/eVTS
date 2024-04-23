<?php
$emp_code_user_id ="";

  if($emp_code_id!=""){
    $emp_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where `Emp_code` = '$emp_code_id'"));
    if($emp_details!=""){
        $empployeeid = $emp_details['EmployeeId'];
        $user_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `EmployeeId` = '$empployeeid'"));
        if($user_details!=""){
            $emp_code_user_id = $user_details['uid'];
        }
    }
  }else if($user_code_id!=""){
    $user_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `uid` = '$user_code_id'"));
    if($user_details!=""){
      $empployeeid = $user_details['EmployeeId'];
      $emp_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where `EmployeeId` = '$empployeeid'"));
      if($emp_details!=""){
        $emp_code_user_id = $emp_details['Emp_code'];
        $emp_name = $emp_details['EmployeeName'];
      }
    }
  }


?>