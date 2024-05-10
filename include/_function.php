<?php
function findCom($conn, $comCode)
{
  $comName = "Data not found";
  if ($comCode != "") {
    $comDetails = mysqli_fetch_assoc(mysqli_query($conn, "select * from `company_details` where`company_id` ='$comCode'"));
    if ($comDetails != "") {
      $comName = $comDetails['companyFname'];
    }
  }
  return $comName;
}
function findBranch($conn, $branchCode)
{
  $branchName = "Data not found";
  if ($branchCode != "") {
    $branchDetails = mysqli_fetch_assoc(mysqli_query($conn, "select * from `branch` where `branch_code`='$branchCode'"));
    if ($branchDetails != "") {
      $branchName = $branchDetails['branch_name'];
    }
  }
  return $branchName;
}
function findDepartment($conn, $deptCode)
{
  $deptName = "Data not found";
  if ($deptCode != "") {
    $deptDetails = mysqli_fetch_assoc(mysqli_query($conn, "select * from `department` where `department_code`='$deptCode'"));
    if ($deptDetails != "") {
      $deptName = $deptDetails['department_name'];
    }
  }
  return $deptName;
}
function findDesig($conn, $desigCode)
{
  $desig = "Data not found";
  if ($desigCode != "") {
    $desigDetails = mysqli_fetch_assoc(mysqli_query($conn, "select * from `designation` where `designation_code`='$desigCode'"));
    if ($desigDetails != "") {
      $desig = $desigDetails['designation'];
    }
  }
  return $desig;
}

function userDetails($conn, $userid)
{
  if ($conn != "" && $userid != "") {
    $userDetails = mysqli_fetch_array(mysqli_query($conn, "select * from `user` where EmployeeId = '$userid' or user_name = '$userid'"));
    if ($userDetails !== "") {
      return $userDetails;
    } else {
      return null;
    }

  } else {
    return null;
  }
}