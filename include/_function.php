<?php
function findCom($conn, $comCode)
{
  $comName = "Not found";
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
  $branchName = "Not found";
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
  $deptName = "Not found";
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
  $desig = "Not found";
  if ($desigCode != "") {
    $desigDetails = mysqli_fetch_assoc(mysqli_query($conn, "select * from `designation` where `designation_code`='$desigCode'"));
    if ($desigDetails != "") {
      $desig = $desigDetails['designation'];
    }
  }
  return $desig;
}
function findVisitortype($conn, $visitType)
{
  $vType = "Not found";
  if ($visitType != "") {
    $visitTypeDetails = mysqli_fetch_assoc(mysqli_query($conn, "select * from `vsitor_type` where `type_id`='$visitType'"));
    if ($visitTypeDetails != "") {
      $vType = $visitTypeDetails['type_name'];
    }
  }
  return $vType;
}
function findVisitorPurpose($conn, $visitPurpose)
{
  $vpurpose = "Not found";
  if ($visitPurpose != "") {
    $visitPurposeDetails = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visit_purpose` where `purpose_id`='$visitPurpose'"));
    if ($visitPurposeDetails != "") {
      $vpurpose = $visitPurposeDetails['purpose'];
    }
  }
  return $vpurpose;
}
function findEmp($conn, $empCode)
{

  if ($empCode != "") {
    $empDetails = mysqli_fetch_assoc(mysqli_query($conn, "select * from eomploye_details where Emp_code ='$empCode' or EmployeeId = '$empCode'"));
    if ($empDetails != "") {
      return $empDetails;
    } else {
      return null;
    }
  } else {
    return null;
  }

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