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

function tableData($sql_data)
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
    <th colspan = "9" style= "font-size: 23px;
     font-style: italic;">' . $comName . '</th>
    
    </tr>
    <tr>
    <th colspan = "9"style= "font-size: 18px;
     font-style: italic;" >User Info Report</th>
    
    </tr>
                    
    <tr style="text-align:center;">
        <td><b>Sl no</b></td>
        <td><b>User log Id <b></td>
        <td><b>Employee Code <b></td>
        <td><b>Employee Name <b></td>
        <td><b>Branch <b></td>
        <td><b>Department <b></td>
        <td><b>Designation <b></td>
        <td><b>User Role <b></td>
        <td><b>Status<b></td>
        
    </tr>
';
  $i = 1;
  while ($info_report = mysqli_fetch_assoc($sql_data)) {

    $datatable .= ' <tr style="text-align:center;">
                    <td>' . $i . '</td>
                    <td>' . $info_report['user_name'] . '</td>
                    <td>' . $info_report['Emp_code'] . '</td>
                    <td>' . $info_report['name'] . '</td>
                    <td>' . findBranch($conn, $info_report['BranchId']) . '</td>
                    <td>' . findDepartment($conn, $info_report['DepartmentId']) . '</td>
                    <td>' . findDesig($conn, $info_report['DesignationId']) . '</td>
                    
                    <td>' . $info_report['user_role'] . '</td>
                    <td>' . $info_report['user_sts'] . '</td>
                    
            </tr>';
    $i++;
  }


  $datatable .= '</tbody></table>';


  return $datatable;



}


if (isset($_POST['details_log_branch_dept_user'])) {
  $branchCode = $_POST['branchData'];
  $deptCode = $_POST['deptData'];

  if (!empty($branchCode) && !empty($deptCode)) {
    if ($branchCode == "All") {
      if ($deptCode == "All") {
        $sqlUserv = "select * from user u inner join eomploye_details em on u.EmployeeId = em.EmployeeId order by u.registration_time_stamp asc";
      } else {
        $sqlUserv = "select * from user u inner join eomploye_details em on u.EmployeeId = em.EmployeeId where em.DepartmentId = '$deptCode' order by u.registration_time_stamp asc";
      }
    } else {
      if ($deptCode == "All") {
        $sqlUserv = "select * from user u inner join eomploye_details em on u.EmployeeId = em.EmployeeId where em.BranchId ='$branchCode'  order by u.registration_time_stamp asc";
      } else {
        $sqlUserv = "select * from user u inner join eomploye_details em on u.EmployeeId = em.EmployeeId where em.DepartmentId = '$deptCode' and em.BranchId ='$branchCode' order by u.registration_time_stamp asc";
      }
    }

    $queryExiqute = mysqli_query($conn, $sqlUserv);
    $dataTable = tableData($queryExiqute);
    header('Content-Type:application/octet-stream');
    header('Content-Disposition:attachment; filename=' . 'User Report.xls');

    echo $dataTable;

    $des = "Txn Log report download";
    $rem = " TXn Log Report";
    include "../include/_audi_log.php";

    exit;
  } else {
    $_SESSION['icon'] = 'error';
    $_SESSION['status'] = 'Provide proper Info';
    header("location:userReport");
  }

}
if (isset($_POST['view_user_branch_dept'])) {
  $branchCode = $_POST['branchData'];
  $deptCode = $_POST['deptData'];

  if (!empty($branchCode) && !empty($deptCode)) {
    if ($branchCode == "All") {
      if ($deptCode == "All") {
        $sqlUserv = "select * from user u inner join eomploye_details em on u.EmployeeId = em.EmployeeId order by u.registration_time_stamp asc";
      } else {
        $sqlUserv = "select * from user u inner join eomploye_details em on u.EmployeeId = em.EmployeeId where em.DepartmentId = '$deptCode' order by u.registration_time_stamp asc";
      }
    } else {
      if ($deptCode == "All") {
        $sqlUserv = "select * from user u inner join eomploye_details em on u.EmployeeId = em.EmployeeId where em.BranchId ='$branchCode'  order by u.registration_time_stamp asc";
      } else {
        $sqlUserv = "select * from user u inner join eomploye_details em on u.EmployeeId = em.EmployeeId where em.DepartmentId = '$deptCode' and em.BranchId ='$branchCode' order by u.registration_time_stamp asc";
      }
    }

    $queryExiqute = mysqli_query($conn, $sqlUserv);
    $dataTable = tableData($queryExiqute);
    echo '  <button class="btn-primary"  onclick="window.print()">Print</button>
            <a href="userReport.php"><button class="btn-primary" >Back</button></a>';
    echo '<div class="print_container" style="">' . $dataTable . '</div>';

  } else {
    $_SESSION['icon'] = 'error';
    $_SESSION['status'] = 'Provide proper Info';
    header("location:userReport");
  }

}