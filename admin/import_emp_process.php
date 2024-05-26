<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head = "Import Employee Info";
$des = "Page Load import_emp_process";
$rem = "Import Info process";
include '../include/_audi_log.php';

// $sql_emp_code_temp = mysqli_query($conn, "select * from `temp_import_emp`");
// // if(mysqli_num_rows($sql_emp_code_temp) >= 1){


// }
$bio_last = "";
$emp_last = "";
// $sql_bio_emp = mysqli_query($conn_bio,"select * from `employees` order by `EmployeeId` desc");
$sql_cms_emp = mysqli_query($conn, "select * from `eomploye_details` order by `EmployeeId` desc");
// $sql_fectch_bio = mysqli_fetch_assoc($sql_bio_emp);
$sql_fectch_emp = mysqli_fetch_assoc($sql_cms_emp);

// if($sql_fectch_bio!=""){
//     $bio_last = $sql_fectch_bio['EmployeeId'];
// }
if ($sql_fectch_emp != "") {
    $emp_last = $sql_fectch_emp['EmployeeId'];
}



function com_insert($cf_name)
{
    include '../include/_dbconnect.php';
    $sql_no_com = mysqli_num_rows(mysqli_query($conn, "select * from `company_details`"));
    $c_id = 'Com-' . (time() + $sql_no_com);
    $com_insert_sql = mysqli_query($conn, "insert into `company_details`(`company_id`, `companyFname`, `companySname`) values ('$c_id','$cf_name','$cf_name')");
    return ($c_id);
}
function branch_insert($branch_name)
{
    include '../include/_dbconnect.php';
    $sql_total_branch = mysqli_num_rows(mysqli_query($conn, "select * from `branch`"));
    $branch_id = "B-" . ($sql_total_branch + 1) . '-' . date("hiys");

    $sql_branch_insert = mysqli_query($conn, "insert into `branch`(`branch_code`, `branch_name`) values ('$branch_id','$branch_name')");
    return ($branch_id);
}
function dept_insert($dept)
{
    include '../include/_dbconnect.php';
    $sql_no_dept = mysqli_num_rows(mysqli_query($conn, "select * from `department`"));
    $dep_id = 'D-' . (time() + $sql_no_dept);

    $insert_depart_sql = mysqli_query($conn, "insert into `department`(`department_code`, `department_name`) values ('$dep_id','$dept')");
    return ($dep_id);
}
function sub_dept_insert($subdept)
{
    include '../include/_dbconnect.php';
    $sql_no_subdept = mysqli_num_rows(mysqli_query($conn, "select * from `subdepartment`"));
    $subdep_id = 'SD-' . (time() + $sql_no_subdept);

    $insert_subdepart_sql = mysqli_query($conn, "insert into `subdepartment`(`subdepartment_code`, `subdepartment_name`) values ('$subdep_id','$subdept')");
    return ($subdep_id);
}
function desig_insert($designation)
{
    include '../include/_dbconnect.php';
    $sql_no_desig = mysqli_num_rows(mysqli_query($conn, "select * from `designation`"));
    $desig_id = 'DES-' . (time() + $sql_no_desig);

    $insert_designation_sql = mysqli_query($conn, "insert into `designation`(`designation_code`, `designation`) values ('$desig_id','$designation')");
    return ($desig_id);
}
function loc_insert($locate)
{
    include '../include/_dbconnect.php';
    $sql_no_loc = mysqli_num_rows(mysqli_query($conn, "select * from `location`"));
    $loc_id = 'LOC-' . (time() + $sql_no_loc);

    $insert_grade_sql = mysqli_query($conn, "insert into `location`(`location_code`, `location`) values ('$loc_id','$locate')");
    return ($loc_id);
}
function emp_type_insert($emp_type)
{
    include '../include/_dbconnect.php';
    $sql_no_emp_type = mysqli_num_rows(mysqli_query($conn, "select * from `employetype`"));
    $lemp_type_id = 'EMPT-' . (time() + $sql_no_emp_type);

    $insert_grade_sql = mysqli_query($conn, "insert into `employetype`(`emptype_code`, `emptype`) values ('$lemp_type_id','$emp_type')");
    return ($lemp_type_id);
}

function cat_insert($emp_cat)
{
    include '../include/_dbconnect.php';
    $sql_no_cat = mysqli_num_rows(mysqli_query($conn, "select * from `empcategory`"));
    $emp_cat_id = 'EMPC-' . (time() + $sql_no_cat);

    $insert_grade_sql = mysqli_query($conn, "insert into `empcategory`(`empcat_code`, `empcat`) values ('$emp_cat_id','$emp_cat')");
    return ($emp_cat_id);
}









if (isset($_POST['excel_upload'])) {
    try {
        mysqli_query($conn, "truncate `import_emp_temp`");
        include "../include/xlsx.php";
        $file_name = $_FILES['excel_file']['name'];
        $file_tmp_name = $_FILES['excel_file']['tmp_name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

        // if(mysqli_num_rows($sql_bio_emp) == mysqli_num_rows($sql_cms_emp) ){

        if ($file_ext == 'xlsx') {
            $excel = SimpleXLSX::parse($file_tmp_name);
            $sql_column_name = mysqli_query($conn, "select column_name from information_schema.columns where table_name='import_emp_temp'");
            // $rowcol=$excel->dimension($sheet);
            $i = 0;
            // $c=3;
            $error = false;
            $error2 = false;
            $error3 = false;
            $sql_insert_temp = "";
            // if($rowcol[0]!=1 &&$rowcol[1]!=1){
            foreach ($excel->rows() as $key => $row) {
                // $com="";
                // $branch="";
                // $dept="";
                $emp_code = $row[1];
                $emp_name = $row[2];
                $com = $row[3];
                $branch = $row[4];
                $dept = $row[5];
                $sub_dept = $row[6];
                $desig = $row[7];
                $loca = $row[8];
                $emp_type = $row[9];
                $cat = $row[10];
                $contact = $row[11];
                $email = $row[12];
                if ($emp_code != "" && $emp_name != "" && $com != "" && $branch != "" && $dept != "" && $contact != "" && $email != "") {
                    // echo $i;
                    // echo $email;

                    if ($i == 0) {
                        foreach ($row as $key => $cell) {
                            $m = mysqli_fetch_array($sql_column_name);
                            // echo $m['column_name'] ." - ".$cell."<br>" ;

                            if ($m['column_name'] != $cell) {
                                $error = true;
                                break;
                            }
                        }
                    } else {

                        $sql_com = mysqli_query($conn, "select * from `company_details` where `companyFname` = '$com'");
                        if (mysqli_num_rows($sql_com) == 1) {
                            $fetch_data = mysqli_fetch_assoc($sql_com);
                            $com = $fetch_data['company_id'];
                        } else {
                            $com = com_insert($com);
                        }

                        $sql_branch = mysqli_query($conn, "select * from `branch` where `branch_name` = '$branch'");
                        if (mysqli_num_rows($sql_branch) == 1) {
                            $fetch_data = mysqli_fetch_assoc($sql_branch);
                            $branch = $fetch_data['branch_code'];
                        } else {
                            $branch = branch_insert($branch);
                        }
                        $sql_dept = mysqli_query($conn, "select * from `department` where `department_name` = '$dept'");
                        if (mysqli_num_rows($sql_dept) == 1) {
                            $fetch_data = mysqli_fetch_assoc($sql_dept);
                            $dept = $fetch_data['department_code'];
                        } else {
                            $dept = dept_insert($dept);
                        }

                        if ($sub_dept != "") {
                            $sql_sub_dept = mysqli_query($conn, "select * from `subdepartment` where `subdepartment_name` = '$sub_dept'");
                            if (mysqli_num_rows($sql_sub_dept) == 1) {
                                $fetch_data = mysqli_fetch_assoc($sql_sub_dept);
                                $sub_dept = $fetch_data['subdepartment_code'];
                            } else {
                                $sub_dept = sub_dept_insert($sub_dept);
                            }
                        } else {
                            $sub_dept = "Default";
                        }

                        if ($desig != "") {
                            $sql_desig = mysqli_query($conn, "select * from `designation` where `designation` = '$desig'");
                            if (mysqli_num_rows($sql_desig) == 1) {
                                $fetch_data = mysqli_fetch_assoc($sql_desig);
                                $desig = $fetch_data['designation_code'];
                            } else {
                                $desig = desig_insert($desig);
                            }
                        } else {
                            $desig = "Default";
                        }

                        if ($loca != "") {

                            $sql_loc = mysqli_query($conn, "select * from `location` where `location` = '$loca'");
                            if (mysqli_num_rows($sql_loc) == 1) {
                                $fetch_data = mysqli_fetch_assoc($sql_loc);
                                // $loca = $fetch_data['location_code'];
                            } else {
                                loc_insert($loca);
                            }
                        } else {
                            $loca = "Default";
                        }

                        if ($emp_type != "") {
                            $sql_emp_type = mysqli_query($conn, "select * from `employetype` where `emptype` = '$emp_type'");
                            if (mysqli_num_rows($sql_emp_type) == 1) {
                                $fetch_data = mysqli_fetch_assoc($sql_emp_type);
                                // $emp_type = $fetch_data['emptype_code'];
                            } else {
                                emp_type_insert($emp_type);
                            }
                        } else {
                            $emp_type = "Default";
                        }

                        if ($cat != "") {

                            $sql_cat = mysqli_query($conn, "select * from `empcategory` where `empcat` = '$cat'");
                            if (mysqli_num_rows($sql_cat) == 1) {
                                $fetch_data = mysqli_fetch_assoc($sql_cat);
                                $cat = $fetch_data['empcat_code'];
                            } else {
                                $cat = cat_insert($cat);
                            }
                        } else {
                            $cat = "Default";
                        }
                    }
                    $row[3] = $com;
                    $row[4] = $branch;
                    $row[5] = $dept;
                    $row[6] = $sub_dept;
                    $row[7] = $desig;
                    $row[8] = $loca;
                    $row[9] = $emp_type;
                    $row[10] = $cat;

                    $q = "";
                    foreach ($row as $key => $cell) {
                        if ($i > 0) {
                            $q .= "'" . $cell . "',";
                        }
                    }
                    if ($i != 0) {
                        // $emp_code="ES012563";
                        $q = "'" . ltrim($q, ("'" . $row[0] . ","));
                        $sql_emp_code = mysqli_query($conn, "select * from `eomploye_details` where `Emp_code` = '$emp_code'");
                        if (mysqli_num_rows($sql_emp_code) == 1) {
                            // echo $emp_code;
                            $q = $q . "'Update'";
                        } else {
                            // echo $emp_code;
                            $q = $q . "'Insert'";
                        }
                        $sql_insert_temp = mysqli_query($conn, "insert into `import_emp_temp`(`Employee_Code`, `Employee_Name`, `Company_Name`, `Branch`, `Department`, `Sub_Department`, `Designation`, `Location`, `Employee_Type`, `Category`, `Contact`, `Email`,`Status`) values (" . $q . ")");
                    }
                    $i++;
                } else {
                    $error3 = true;
                    break;
                }
            }

            if ($sql_insert_temp != "") {
                $_SESSION['icon'] = 'info';
                $_SESSION['status'] = 'File Import ! PLease Click Process Button';
                $des = "Click On Import ";
                $rem = "Employe Import Process unsuccess";
                include '../include/_audi_log.php';
                header("location:import_process");
            } else {
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] = 'Import Not Posible .....';
                $des = "Click On Import ";
                $rem = "Employe Import Process unsuccess";
                include '../include/_audi_log.php';
                header("location:import_emp");
            }
            if ($error2 == true) {
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] = 'Wrong Excel Sheet Format.....';
                $des = "Click On Import ";
                $rem = "Employe Import Process unsuccess";
                include '../include/_audi_log.php';
                header("location:import_emp");
            }
            if ($error == true) {
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] = 'Wrong Excel Sheet Format 22';
                $des = "Click On Import ";
                $rem = "Employe Import Process unsuccess";
                include '../include/_audi_log.php';
                // header("location:import_emp");
            }
            if ($error3 == true) {
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] = 'Fill All the fields Properly.... ';
                $des = "Click On Import ";
                $rem = "Employe Import Process unsuccess";
                include '../include/_audi_log.php';
                header("location:import_emp");
            }
        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Wrong File Formate';
            $des = "Click On Import ";
            $rem = "Employe Import Process unsuccess";
            include '../include/_audi_log.php';
            header("location:import_emp");
        }
        // }else{
        //     $_SESSION['icon'] = 'warning';
        //     $_SESSION['status'] = 'Atfast Sync Employe...';
        //     $des="Click On Import ";
        //     $rem="Employe Import Process unsuccess";
        //     include '../include/_audi_log.php';
        //     header("location:import_emp");
        // }
    } catch (Exception $e) {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = "Please Import Excel File Properly..... ";
        $des = "Click On Import ";
        $rem = "Employe Import Process unsuccess";
        include '../include/_audi_log.php';
        header("location:import_emp");
    }
}


// import process start
$bio_last1 = "";
$emp_last1 = "";
// $sql_bio_emp1 = mysqli_query($conn_bio,"select * from `employees` order by `EmployeeId` desc");
$sql_cms_emp1 = mysqli_query($conn, "select * from `eomploye_details` order by `EmployeeId` desc");
// $sql_fectch_bio1 = mysqli_fetch_assoc($sql_bio_emp1);
$sql_fectch_emp1 = mysqli_fetch_assoc($sql_cms_emp1);

// if($sql_fectch_bio!=""){
//     $bio_last = $sql_fectch_bio['EmployeeId'];
// }
if ($sql_fectch_emp != "") {
    $emp_last = $sql_fectch_emp['EmployeeId'];
}


if (isset($_POST['emp_import_process'])) {
    try {

        // if(mysqli_num_rows($sql_bio_emp1) == mysqli_num_rows($sql_cms_emp1)){
        $sql_temp_data = mysqli_query($conn, "select * from `import_emp_temp`");
        echo mysqli_num_rows($sql_temp_data);
        if ($sql_temp_data != "") {
            $count = 0;
            while ($sql_temp_emp_data = mysqli_fetch_assoc($sql_temp_data)) {
                $emp_code = $sql_temp_emp_data['Employee_Code'];
                $emp_name = $sql_temp_emp_data['Employee_Name'];
                $com = $sql_temp_emp_data['Company_Name'];
                $branch = $sql_temp_emp_data['Branch'];
                $dept = $sql_temp_emp_data['Department'];
                $subdpt = $sql_temp_emp_data['Sub_Department'];
                $desig = $sql_temp_emp_data['Designation'];
                $location = $sql_temp_emp_data['Location'];
                $emp_type = $sql_temp_emp_data['Employee_Type'];
                $category = $sql_temp_emp_data['Category'];
                $contact = $sql_temp_emp_data['Contact'];
                $email = $sql_temp_emp_data['Email'];
                $emp_status = $sql_temp_emp_data['Status'];

                if ($emp_status == 'Update') {

                    // $update_bio_emp = mysqli_query($conn_bio,"update `employees` set `EmployeeName`='$emp_name' where `EmployeeCode`='$emp_code'");
                    $update_cms_emp = mysqli_query($conn, "update `eomploye_details` set `EmployeeName`='$emp_name',`CompanyId`='$com',`DepartmentId`='$dept',`BranchId`='$branch',`Sub_DepartmentId`='$subdpt',`DesignationId`='$desig',`GradeId`='GEN',`Location`='$location',`EmployeType`='$emp_type',`CategoryId`='$category',`email_id` = '$email',`ContactNo`='$contact' where `Emp_code`='$emp_code'");


                    $count++;
                } else {
                    // $insert_emp_bio_db =mysqli_query($conn_bio,"insert into `employees`(`EmployeeName`, `EmployeeCode`,`Gender`,`CompanyId`,`DepartmentId`,`CategoryId`,`DOJ`,`DOR`,`DOC`,`EmployeeCodeInDevice`,`EmployementType`,`Status`,`EmployeeDevicePassword`,`EmployeeDeviceGroup`,`RecordStatus`,`HolidayGroup`,`ShiftGroupId`,`ShiftRosterId`) values ('$emp_name','$emp_code','Male','1','1','1','1900-01-01 00:00:00','3000-01-01 00:00:00','1900-01-01 00:00:00','$emp_code','Permanent','Working','','1','1','-1','0','0')");

                    $insert_emp_cms_db = mysqli_query($conn, "insert into `eomploye_details`(`Emp_code`, `EmployeeName`, `CompanyId`, `DepartmentId`, `BranchId`, `Sub_DepartmentId`, `DesignationId`, `GradeId`, `Location`, `EmployeType`, `CategoryId`, `ContactNo`,`email_id`, `Status`) values ('$emp_code','$emp_name','$com','$dept','$branch','$subdpt','$desig','GEN','$location','$emp_type','$category','$contact','$email','Working')");

                    $count++;
                }

            }
            $sql_temp_data1 = mysqli_num_rows(mysqli_query($conn, "select * from `import_emp_temp`"));
            if ($sql_temp_data1 == $count) {
                $_SESSION['icon'] = 'success';
                $_SESSION['status'] = 'Import Employee SuccessFull..';
                $des = "Click On Process ";
                $rem = "Employe Import Process success";
                include '../include/_audi_log.php';
                mysqli_query($conn, "truncate `import_emp_temp`");
                header("location:import_emp");
            } else {
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] = 'All Employee not Import..';
                $des = "Click On Process ";
                $rem = "Employe Import Process unsuccess";
                include '../include/_audi_log.php';
                mysqli_query($conn, "truncate `import_emp_temp`");
                header("location:import_emp");
            }
        } else {
            $_SESSION['icon'] = 'warning';
            $_SESSION['status'] = 'Employee data not found..';
            $des = "Click On Process ";
            $rem = "Employe Import Process unsuccess";
            include '../include/_audi_log.php';
            header("location:import_emp");

        }


        // }else{
        //     $_SESSION['icon'] = 'warning';
        //     $_SESSION['status'] = 'Atfast Sync Employe...';
        //     $des="Click On Process ";
        //     $rem="Employe Import Process unsuccess";
        //     include '../include/_audi_log.php';
        //     header("location:import_emp");
        // }

    } catch (Exception $e) {
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Please Import And Process Carefully';
        $des = "Click On Process ";
        $rem = "Employe Import Process unsuccess";
        include '../include/_audi_log.php';
        header("location:import_emp");
    }





}

// import process end
?>