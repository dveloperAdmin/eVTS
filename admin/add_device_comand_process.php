<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Device Command add process";
$rem="page Load add_employee_command_process";

include '../include/_audi_log.php';

if(isset($_POST['add_emp'])){
    $emp_id = $_POST['emp_id'];
    $div_sl_no = $_POST['div_sl_no'];
    if( $emp_id!="" && $div_sl_no!=""){
        $insert_sql="";
        foreach($emp_id as  $x => $val){
            $emp_code = "";
            $emp_name = "";
            $emp_data  = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details`where `EmployeeId`='$val'"));
            if($emp_data!=""){
                $emp_code = $emp_data['Emp_code'];
                $emp_name = $emp_data['EmployeeName'];
            }
            $title = "ADD USER $emp_code";
            $devicecommand = "C:UniqueId:DATA UPDATE USERINFO PIN=$emp_code	    Name=$emp_name Pri=0	Passwd=	Card=	Grp=1";
            $serialnumber = $div_sl_no;
            $status = "PENDING";
            $type = "ADD USER";
            $insert_sql = mysqli_query($conn_bio,"insert into `devicecommands`(`Title`, `DeviceCommand`, `SerialNumber`, `Status`, `Type`, `CreationDate`) values ('$title','$devicecommand','$serialnumber','$status','$type',CURRENT_TIMESTAMP)");
        //    echo $title ."<br>";
        //    echo $devicecommand ."<br>";
        }
        if($insert_sql !=""){
            $_SESSION['icon']='success';
            $_SESSION['status']='Add Employee Command SucessFully...';
            $des="Click On Next button ";
            $rem="Add Device Command success";
            include '../include/_audi_log.php';
            header("location:add_device_command");
            
        } else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Add Employee Command UnsucessFull...';
            $des="Click On Next button ";
            $rem="Add Device Command  unsuccess";
            include '../include/_audi_log.php';
            header("location:add_device_command");
        }


    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']='Please Give Currect Input';
        $des="Click On Next button ";
        $rem="Add Device Command  unsuccess";
        include '../include/_audi_log.php';
        header("location:add_device_command");
    }
    // echo $emp_id ;

}
if(isset($_POST['delete_emp'])){
    $emp_id = $_POST['emp_id'];
    $div_sl_no = $_POST['div_sl_no'];
    if( $emp_id!="" && $div_sl_no!=""){
        $insert_sql="";
        foreach($emp_id as  $x => $val){
            $emp_code = "";
            $emp_name = "";
            $emp_data  = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details`where `EmployeeId`='$val'"));
            if($emp_data!=""){
                $emp_code = $emp_data['Emp_code'];
                $emp_name = $emp_data['EmployeeName'];
            }
            $title = "DELETE USER $emp_code";
            $devicecommand = "C:UniqueId:DATA DELETE USERINFO PIN=$emp_code";
            $serialnumber = $div_sl_no;
            $status = "PENDING";
            $type = "DELETE USER";
            $insert_sql = mysqli_query($conn_bio,"insert into `devicecommands`(`Title`, `DeviceCommand`, `SerialNumber`, `Status`, `Type`, `CreationDate`) values ('$title','$devicecommand','$serialnumber','$status','$type',CURRENT_TIMESTAMP)");
        //    echo $title ."<br>";
        //    echo $devicecommand ."<br>";
        }
        if($insert_sql !=""){
            $_SESSION['icon']='success';
            $_SESSION['status']='Delete Employee Command SucessFully...';
            $des="Click On Next button ";
            $rem="Add Device Command success";
            include '../include/_audi_log.php';
            header("location:add_device_command");
            
        } else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Delete Employee Command UnsucessFull...';
            $des="Click On Next button ";
            $rem="Add Device Command  unsuccess";
            include '../include/_audi_log.php';
            header("location:add_device_command");
        }


    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']='Please Give Currect Input';
        $des="Click On Next button ";
        $rem="Add Device Command  unsuccess";
        include '../include/_audi_log.php';
        header("location:add_device_command");
    }
    // echo $emp_id ;

}




?>