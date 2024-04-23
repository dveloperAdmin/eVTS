<?php
include '../include/_dbconnect.php';
include '../include/_function.php';


if (isset($_POST['uid'])) {

    $uid = $_POST['uid'];
    $emp_name = "";
    $branchName = "";
    $deptName = "";
    $desigName = "";
    $sql_user_id = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `user_name` = '$uid'"));

    if ($sql_user_id != "") {
        $emp_id = $sql_user_id['EmployeeId'];
        $sql_emp_data = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` where `EmployeeId`='$emp_id'"));
        if ($sql_emp_data != "") {
            $emp_name = $sql_emp_data['EmployeeName'];
            $branchName = findBranch($conn, $sql_emp_data['BranchId']);
            $deptName = findDepartment($conn, $sql_emp_data['DepartmentId']);
            $desigName = findDesig($conn, $sql_emp_data['DesignationId']);

        } else {
            $emp_name = "Data Not Found";
            $branchName = "Data Not Found";
            $deptName = "Data Not Found";
            $desigName = "Data Not Found";
        }


    }
    echo ' <div class="card" style="margin-bottom: 8px;">
                <div class="card-header"
                    style="padding-bottom:8px;padding-top:8px;">
                    <h5>User Details</h5>
                </div>
                <div class="card-block">
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label" style="max-width: 100%;    font-size: 1rem; font-weight: 600;">User Name &nbsp; :- &nbsp;' . $emp_name . '</label>
                        <label class="col-sm-3 col-form-label" style="max-width: 100%;    font-size: 1rem; font-weight: 600;">Branch &nbsp; :- &nbsp;' . $branchName . '</label>
                        <label class="col-sm-3 col-form-label" style="max-width: 100%;    font-size: 1rem; font-weight: 600;">Department &nbsp; :- &nbsp;' . $deptName . '</label>
                        <label class="col-sm-3 col-form-label" style="max-width: 100%;    font-size: 1rem; font-weight: 600;">Designation &nbsp; :- &nbsp;' . $desigName . '</label>
                        
                        </div>
                    </div>
                </div>
            </div>
        ';
}

?>