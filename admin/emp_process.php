<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$emp_code = "";
$emp_name = "";
$emp_co_name = "";
$emp_branch = "";
$emp_dept = "";
$emp_subdept = "";
$emp_desig = "";
$emp_grade = "";
$emp_loc = "";
$emp_type = "";
$emp_cat = "";
$emp_mob = "";
$emp_sts = "";
$emp_email = "";


if (isset($_POST['user_submit'])) {
    try {
        $emp_code = $_POST['emp_code'];  //*
        $emp_name = $_POST['emp_name']; //*
        $emp_co_name = $_POST['emp_co_name']; //*
        $emp_branch = $_POST['emp_branch']; //*
        $emp_dept = $_POST['emp_dept']; //*
        $emp_subdept = $_POST['emp_subdept'];
        $emp_desig = $_POST['emp_Desig'];
        $emp_grade = $_POST['emp_grade'];
        $emp_loc = $_POST['emp_loc'];
        $emp_type = $_POST['emp_type'];
        $emp_cat = $_POST['emp_cat'];
        $emp_mob = $_POST['emp_mob']; //*
        $emp_sts = $_POST['emp_sts']; //*
        $emp_email = $_POST['emp_email'];

        $desi_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `designation` where `designation_code`='$emp_desig'"));
        $degnation = $desi_sql['designation'];


        $numof_cms_emp = mysqli_num_rows(mysqli_query($conn, "select * from `eomploye_details`"));


        if ($emp_code != "" && $emp_name != "" && $emp_co_name != "" && $emp_branch != "" && $emp_dept != "" && $emp_mob != "" && $emp_email != "" && $emp_sts != "") {
            $sql_check_dublicate = mysqli_query($conn, "select * from `eomploye_details` where `Emp_code`='$emp_code' and `ContactNo`='$emp_mob'");


            if (mysqli_num_rows($sql_check_dublicate) < 1) {
                $insert_emp_cms_db = mysqli_query($conn, "insert into `eomploye_details`(`Emp_code`, `EmployeeName`, `CompanyId`, `DepartmentId`, `BranchId`, `Sub_DepartmentId`, `DesignationId`, `GradeId`, `Location`, `EmployeType`, `CategoryId`, `ContactNo`, `email_id` ,`Status`) values ('$emp_code','$emp_name','$emp_co_name','$emp_dept','$emp_branch','$emp_subdept','$emp_desig','$emp_grade','$emp_loc','$emp_type','$emp_cat','$emp_mob','$emp_email','$emp_sts')");

                if ($insert_emp_cms_db) {
                    $_SESSION['icon'] = 'success';
                    $_SESSION['status'] = 'Employee Added Successfull';
                    $des = "Click On Add Employe ";
                    $rem = "Employe add success";
                    include '../include/_audi_log.php';
                    header("location:new-employe");

                } else {
                    $_SESSION['icon'] = 'error';
                    $_SESSION['status'] = 'Employee Not Added ';
                    $des = "Click On Add Employe ";
                    $rem = "Employe add unsuccess";
                    include '../include/_audi_log.php';
                    header("location:new-employe");
                }
            } else {
                $_SESSION['icon'] = 'warning';
                $_SESSION['status'] = 'Dubliacte Employe Data';
                $des = "Click On Add Employe ";
                $rem = "Employe add unsuccess";
                include '../include/_audi_log.php';
                header("location:new-employe");
            }

        } else {
            $_SESSION['icon'] = 'warning';
            $_SESSION['status'] = 'Enter Input CareFully';
            $des = "Click On Add Employe ";
            $rem = "Employe add unsuccess";
            include '../include/_audi_log.php';
            header("location:new-employe");
        }

    } catch (Exception $e) {
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Employee Add Carefully.....';
        $des = "Click On Add Employe ";
        $rem = "Employe add unsuccess";
        include '../include/_audi_log.php';
        header("location:new-employe");
    }
}

//employee edit
if (isset($_POST['user_edit'])) {
    try {
        $edit_id = $_POST['edit_id'];
        // $emp_code = $_POST['uemp_code'];  //*
        $emp_name = $_POST['uemp_name']; //*
        $emp_co_name = $_POST['uemp_co_name']; //*
        $emp_branch = $_POST['uemp_branch']; //*
        $emp_dept = $_POST['uemp_dept']; //*
        $emp_subdept = $_POST['uemp_subdept'];
        $emp_desig = $_POST['uemp_Desig'];
        $emp_grade = $_POST['uemp_grade'];
        $emp_loc = $_POST['uemp_loc'];
        $emp_type = $_POST['uemp_type'];
        $emp_cat = $_POST['uemp_cat'];
        $emp_mob = $_POST['uemp_mob']; //*
        $emp_sts = $_POST['uemp_sts']; //*
        $emp_email = $_POST['emp_email'];


        $desi_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `designation` where `designation_code`='$emp_desig'"));
        $degnation = $desi_sql['designation'];

        if ($emp_name != "" && $emp_co_name != "" && $emp_branch != "" && $emp_dept != "" && $emp_mob != "" && $emp_email != "" && $emp_sts != "") {

            //update user table data

            $sql_user_update = mysqli_query($conn, "update `user` set`name`='$emp_name' where `EmployeeId`='$edit_id'");
            if ($emp_sts == 'Resign') {
                $sql_check_user_sts = mysqli_query($conn, "select * from `user` where `EmployeeId`='$edit_id' and `user_sts`='Deactive'");
                if (mysqli_num_rows($sql_check_user_sts) < 1) {
                    $sql_user_update = mysqli_query($conn, "update `user` set `user_sts`='Deactive' where `EmployeeId`='$edit_id'");

                }

            } else if ($emp_sts == 'Working') {
                $sql_check_user_sts = mysqli_query($conn, "select * from `user` where `EmployeeId`='$edit_id' and `user_sts`='Active'");
                if (mysqli_num_rows($sql_check_user_sts) < 1) {
                    $sql_user_update = mysqli_query($conn, "update `user` set `user_sts`='Active' where `EmployeeId`='$edit_id'");
                }

            }




            $sql_check_cms_dublicate = mysqli_query($conn, "select * from `eomploye_details` where `EmployeeId`='$edit_id'");



            if (mysqli_num_rows($sql_check_cms_dublicate) <= 1) {
                $sql_emp_data = mysqli_fetch_assoc($sql_check_cms_dublicate);
                $check_cms_emp_code = mysqli_query($conn, "select * from `eomploye_details` where `Emp_code` = '$emp_code'");

                if (mysqli_num_rows($check_cms_emp_code) < 1) {

                    if ($sql_emp_data['email_id'] == $emp_email) {

                        if ($sql_emp_data['ContactNo'] == $emp_mob) {

                            $update_cms_emp = mysqli_query($conn, "update `eomploye_details` set `EmployeeName`='$emp_name',`CompanyId`='$emp_co_name',`DepartmentId`='$emp_dept',`BranchId`='$emp_branch',`Sub_DepartmentId`='$emp_subdept',`DesignationId`='$emp_desig',`GradeId`='$emp_grade',`Location`='$emp_loc',`EmployeType`='$emp_type',`CategoryId`='$emp_cat',`ContactNo`='$emp_mob',`Status`='$emp_sts' where `EmployeeId`='$edit_id'");
                            if ($update_cms_emp != "") {
                                $_SESSION['icon'] = 'success';
                                $_SESSION['status'] = 'Employee Update Successfull';
                                $des = "Click On Update Employe ";
                                $rem = "Employe Update success";
                                include '../include/_audi_log.php';
                                header("location:employe-view");

                            } else {
                                $_SESSION['icon'] = 'error';
                                $_SESSION['status'] = 'Employee Not Update ';
                                $des = "Click On Update Employe ";
                                $rem = "Employe Update unsuccess";
                                include '../include/_audi_log.php';
                                header("location:employe-view");
                            }


                        } else {

                            $check_emp_mob = mysqli_query($conn, "select * from `eomploye_details` where `ContactNo` = '$emp_mob'");

                            if (mysqli_num_rows($check_emp_mob) < 1) {
                                $update_cms_emp = mysqli_query($conn, "update `eomploye_details` set `EmployeeName`='$emp_name',`CompanyId`='$emp_co_name',`DepartmentId`='$emp_dept',`BranchId`='$emp_branch',`Sub_DepartmentId`='$emp_subdept',`DesignationId`='$emp_desig',`GradeId`='$emp_grade',`Location`='$emp_loc',`EmployeType`='$emp_type',`CategoryId`='$emp_cat',`ContactNo`='$emp_mob',`Status`='$emp_sts' WHERE `EmployeeId`='$edit_id'");

                                if ($update_cms_emp != "") {
                                    $_SESSION['icon'] = 'success';
                                    $_SESSION['status'] = 'Employee Update Successfull';
                                    $des = "Click On Update Employe ";
                                    $rem = "Employe Update success";
                                    include '../include/_audi_log.php';
                                    header("location:employe-view");

                                } else {
                                    $_SESSION['icon'] = 'error';
                                    $_SESSION['status'] = 'Employee Not Update ';
                                    $des = "Click On Update Employe ";
                                    $rem = "Employe Update unsuccess";
                                    include '../include/_audi_log.php';
                                    header("location:employe-view");
                                }
                            } else {
                                $_SESSION['icon'] = 'error';
                                $_SESSION['status'] = 'Dublicate Contact';
                                $des = "Click On Update Employe ";
                                $rem = "Employe Update unsuccess";
                                include '../include/_audi_log.php';
                                header('location:employe-view');
                            }

                        }
                    } else {
                        $check_emp_mail = mysqli_query($conn, "select * from `eomploye_details` where `email_id` = '$emp_email'");
                        if (mysqli_num_rows($check_emp_mail) >= 1) {
                            if ($sql_emp_data['ContactNo'] == $emp_mob) {

                                $update_cms_emp = mysqli_query($conn, "update `eomploye_details` set `EmployeeName`='$emp_name',`CompanyId`='$emp_co_name',`DepartmentId`='$emp_dept',`BranchId`='$emp_branch',`Sub_DepartmentId`='$emp_subdept',`DesignationId`='$emp_desig',`GradeId`='$emp_grade',`Location`='$emp_loc',`EmployeType`='$emp_type',`CategoryId`='$emp_cat',`ContactNo`='$emp_mob',`email_id`='$emp_email', `Status`='$emp_sts' where `EmployeeId`='$edit_id'");
                                if ($update_cms_emp != "") {
                                    $_SESSION['icon'] = 'success';
                                    $_SESSION['status'] = 'Employee Update Successfull';
                                    $des = "Click On Update Employe ";
                                    $rem = "Employe Update success";
                                    include '../include/_audi_log.php';
                                    header("location:employe-view");

                                } else {
                                    $_SESSION['icon'] = 'error';
                                    $_SESSION['status'] = 'Employee Not Update ';
                                    $des = "Click On Update Employe ";
                                    $rem = "Employe Update unsuccess";
                                    include '../include/_audi_log.php';
                                    header("location:employe-view");
                                }


                            } else {

                                $check_emp_mob = mysqli_query($conn, "select * from `eomploye_details` where `ContactNo` = '$emp_mob'");

                                if (mysqli_num_rows($check_emp_mob) < 1) {
                                    $update_cms_emp = mysqli_query($conn, "update `eomploye_details` set `EmployeeName`='$emp_name',`CompanyId`='$emp_co_name',`DepartmentId`='$emp_dept',`BranchId`='$emp_branch',`Sub_DepartmentId`='$emp_subdept',`DesignationId`='$emp_desig',`GradeId`='$emp_grade',`Location`='$emp_loc',`EmployeType`='$emp_type',`CategoryId`='$emp_cat',`ContactNo`='$emp_mob',`email_id`='$emp_email',`Status`='$emp_sts' WHERE `EmployeeId`='$edit_id'");

                                    if ($update_cms_emp != "") {
                                        $_SESSION['icon'] = 'success';
                                        $_SESSION['status'] = 'Employee Update Successfull';
                                        $des = "Click On Update Employe ";
                                        $rem = "Employe Update success";
                                        include '../include/_audi_log.php';
                                        header("location:employe-view");

                                    } else {
                                        $_SESSION['icon'] = 'error';
                                        $_SESSION['status'] = 'Employee Not Update ';
                                        $des = "Click On Update Employe ";
                                        $rem = "Employe Update unsuccess";
                                        include '../include/_audi_log.php';
                                        header("location:employe-view");
                                    }
                                } else {
                                    $_SESSION['icon'] = 'error';
                                    $_SESSION['status'] = 'Dublicate Contact';
                                    $des = "Click On Update Employe ";
                                    $rem = "Employe Update unsuccess";
                                    include '../include/_audi_log.php';
                                    header('location:employe-view');
                                }

                            }
                        } else {
                            $_SESSION['icon'] = 'error';
                            $_SESSION['status'] = 'NO Email id';
                            $des = "Click On Update Employe ";
                            $rem = "Employe Update unsuccess";
                            include '../include/_audi_log.php';
                            header('location:employe-view');
                        }

                    }
                } else {
                    $_SESSION['icon'] = 'error';
                    $_SESSION['status'] = 'Dublicate Employe Code';
                    $des = "Click On Update Employe ";
                    $rem = "Employe Update unsuccess";
                    include '../include/_audi_log.php';

                    header('location:employe-view');
                }

            } else {
                $_SESSION['icon'] = 'warning';
                $_SESSION['status'] = 'Dubliacte Employe Data';
                $des = "Click On Update Employe ";
                $rem = "Employe Update unsuccess";
                include '../include/_audi_log.php';
                header("location:employe-view");
            }

        } else {
            $_SESSION['icon'] = 'warning';
            $_SESSION['status'] = 'Enter Input CareFully';
            $des = "Click On Update Employe ";
            $rem = "Employe Update unsuccess";
            include '../include/_audi_log.php';
            header("location:employe-view");
        }

    } catch (Exception $e) {
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Employee Add Carefully.....';
        $des = "Click On Add Employe ";
        $rem = "Employe add unsuccess";
        include '../include/_audi_log.php';
        header("location:new-employe");
    }
}
// emp_delete 

if (isset($_GET['del_id'])) {
    $del_id = $_GET['del_id'];
    $checkAqurateEmpUser = mysqli_fetch_assoc(mysqli_query($conn, "select case when u.user_role in ('Admin', 'Super Admin', 'Developer') then 'A' else 'U' end as role_type, u.user_role as role from eomploye_details e join user u on e.EmployeeId = u.EmployeeId where e.EmployeeId = '$del_id'"));
    if ($checkAqurateEmpUser['role_type'] == 'A') {
        $alertStatus = 'Can`t Delete ' . $checkAqurateEmpUser['role'] . ' Employee';
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = $alertStatus;
        $des = "Click On Delete  ";
        $rem = "Employe Delete unsuccess";
        include '../include/_audi_log.php';
        header("location:employe-view");


    } else {

        $delete_sql_vms = mysqli_query($conn, "delete from `eomploye_details` where `EmployeeId`='$del_id'");
        $delete_user = mysqli_query($conn, "delete from `user` where `EmployeeId`='$del_id'");

        if ($delete_sql_vms) {
            $_SESSION['icon'] = 'success';
            $_SESSION['status'] = 'Employe Details Delete Successfull';
            $des = "Click On Delete  ";
            $rem = "Employe Delete success";
            include '../include/_audi_log.php';
            header("location:employe-view");
        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Employe Details Delete UnSuccessfull';
            $des = "Click On Delete  ";
            $rem = "Employe Delete unsuccess";
            include '../include/_audi_log.php';
            header("location:employe-view");
        }
    }
}

?>