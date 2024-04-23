<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head="Visitor Report Process";
$des="Page Load visitor_log_report_process";
$rem="Visitor Log Report Process";
include '../include/_audi_log.php';
function column($types_report){

    $sl_no = '<html><b>Sl No <b></html>';
    $v_log_id = '<html><b>Visitor Log Id <b></html>';
    $visitor_id = '<html><b>Visitor Id <b></html>';
    $visitor_name = '<html><b>Visitor Name <b></html>';
    $gvt_id_type= '<html><b>Govt. Id Type <b></html>';
    $gvt_id_no= '<html><b>Govt. Id No <b></html>';
    $com_name = '<html><b>Comapny Name <b></html>';
    $desig = '<html><b>Designation <b></html>';
    $mobile_no = '<html><b>Mobile No <b></html>';
    $email = '<html><b>Email ID <b></html>';
    $address = '<html><b>Address <b></html>';
    $id_no = '<html><b>Issued Id Card No <b></html>';
    $v_type = '<html><b>Visitor Type <b></html>';
    $purpose = '<html><b>Purpose <b></html>';
    $m_c_in = '<html><b>Meterial Carried <b></html>';
    $vehical_type = '<html><b>Vehical Type <b></html>';
    $vehical_no = '<html><b>Vehical No <b></html>';
    $emp_code = '<html><b>Employee Code <b></html>';
    $emp_name = '<html><b>Employee Name <b></html>';
    $emp_dpt = '<html><b>Department <b></html>';
    $emp_desig = '<html><b>Department <b></html>';
    $intime = '<html><b>Check In Time <b></html>';
    $outtime = '<html><b>Check Out Time <b></html>';
    $check_sts = '<html><b>Status <b></html>';
    $meeting_end_time = '<html><b>Meeting End Time <b></html>';
    $meeting_end_sts = '<html><b>Meeting End Status <b></html>';
    $security_perm = '<html><b>Security Permission <b></html>';
    $emp_perm = '<html><b>Employee Permission <b></html>';
    // $v_photo = '<html><b>Visitor Photo <b></html>';

    if($types_report == 1){
        $columns = array($sl_no, $v_log_id, $visitor_id, $visitor_name, $com_name, $mobile_no, $id_no, $purpose, $vehical_type, $vehical_no, $emp_code, $emp_name, $emp_dpt,$intime, $outtime,$check_sts, $meeting_end_time, $meeting_end_sts, $security_perm, $emp_perm);
          
        return($columns);
    }else{
        $columns = array($sl_no, $v_log_id, $visitor_id, $visitor_name, $gvt_id_type, $gvt_id_no, $com_name, $desig, $mobile_no, $email, $address, $id_no, $v_type, $purpose, $m_c_in, $vehical_type, $vehical_no, $emp_code, $emp_name, $emp_dpt, $emp_desig,$intime, $outtime, $check_sts, $meeting_end_time, $meeting_end_sts, $security_perm, $emp_perm);
          
        return($columns);
    }
}


function  besic_excle($sql_query, $file_name, $i){
    include "../include/xlsxgen.php";
    include '../include/_dbconnect.php';
    if($i>1){
        $colum_name = array('i','visit_uid','visitor_id','visitor_id','visitor_id','visitor_id','visitor_id','visitor_id','visitor_id','visitor_id','visitor_id','id_card_no','visitor_type','visit_purpose','things_brought','vehical_type','vahical_num','emp_id','emp_id','emp_id','emp_id','visit_uid','visit_uid','check_status','visit_uid','meeting_status','security_approval','Emp_approve');

    }else{
        $colum_name = array('i','visit_uid','visitor_id','visitor_id','','','visitor_id','','visitor_id','','','id_card_no','','visit_purpose','','vehical_type','vahical_num','emp_id','emp_id','emp_id','','visit_uid','visit_uid','check_status','visit_uid','meeting_status','security_approval','Emp_approve');
        // $colum_name = array('i','visit_uid','visitor_id','visitor_id','visitor_id','visitor_id','id_card_no','visit_purpose','vehical_type','vahical_num','emp_id','emp_id','emp_id','visit_uid','visit_uid','check_status','visit_uid','meeting_status','security_approval','Emp_approve');
    
    }
    $table_formate =array(column($i),); 
    $no_data =mysqli_num_rows($sql_query);
    for($i=1; $i<=$no_data; $i++){
        $log_data = mysqli_fetch_assoc($sql_query);
        for($j=0; $j<count($colum_name); $j++){
            if($colum_name[$j]!=""){
                $column = $colum_name[$j];
                if($j==0){
                    $table_formate[$i][$j] = $i;
                }else if(in_array($j, range(3,10))){
                    $v_id = $log_data[$column];
                    $v_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `visitor_info` where `visitor_id` =  '$v_id'"));
                    switch($j){
                        case 3:
                            $table_formate[$i][$j] = ucfirst($v_details['name']);
                            break;
                        case 4:
                            $table_formate[$i][$j] = ucfirst($v_details['govt_id_type']);
                            break;
                        case 5:
                            $table_formate[$i][$j] = $v_details['govt_id_no'];
                            break;
                        case 6:
                            $table_formate[$i][$j] = $v_details['com_name'];
                            break;
                        case 7:
                            $table_formate[$i][$j] = $v_details['designation'];
                            break;
                        case 8:
                            $table_formate[$i][$j] = $v_details['contact_no'];
                            break;
                        case 9:
                            $table_formate[$i][$j] = $v_details['mail_id'];
                            break;
                        case 10:
                            $table_formate[$i][$j] = $v_details['address'];
                            break;
                    }
                }else if($j == 12){
                    $v_type_id = $log_data[$column];
                    $v_type_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `vsitor_type` where `type_id`='$v_type_id'"));
                    $table_formate[$i][$j] = $v_type_details['type_name'];
                }else if($j == 13){
                    $v_p_id = $log_data[$column];
                    $purpose = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visit_purpose` where `purpose_id`='$v_p_id'"));
                    if($purpose !=""){
                        $table_formate[$i][$j] = $purpose['purpose'];

                    }else{
                        $table_formate[$i][$j] = "";
                    }
                }else if(in_array($j, range(18,20))){
                    $emp_code = $log_data[$column];
                    $emp_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where `Emp_code` =  '$emp_code'"));
                    switch($j){
                        case 18:
                            $table_formate[$i][$j] = ucfirst($emp_details['EmployeeName']);
                            break;
                        case 19:
                            $deprtment_id = $emp_details['DepartmentId'];
                            $department = mysqli_fetch_assoc(mysqli_query($conn, "select * from `department` where `department_code`= '$deprtment_id'"));
    
                            $table_formate[$i][$j] = ucfirst($department['department_name']);
                            break;
                        case 20:
                            $desig_id = $emp_details['DesignationId'];
                            $designation = mysqli_fetch_assoc(mysqli_query($conn, "select * from `designation` where `designation_code`= '$desig_id'"));
    
                            $table_formate[$i][$j] = ucfirst($designation['designation']);
                            break;
                    }
                }else if(in_array($j, range(21,22)) || $j==24){
                    $v_lof_id = $log_data[$column];
                    $timeing_data = mysqli_fetch_assoc(mysqli_query($conn,"select * from `visitor_log` where `visit_uid` = '$v_lof_id'"));
                    switch($j){
                        case 21:
                            if($timeing_data['checkin_date'] != '0000-00-00' && $timeing_data['checkin_time'] != '00:00:00'){
                                $table_formate[$i][$j] =date("d-m-Y h:i:s", strtotime($timeing_data['checkin_date'].' '.$timeing_data['checkin_time']));
                            }else{  
                                $table_formate[$i][$j] = "00-00-0000".' '."00:00:00";
                            }
                            break;
                        case 22:
                            if($timeing_data['checkout_date'] != '0000-00-00' && $timeing_data['checkout_time'] != '00:00:00'){
                                $table_formate[$i][$j] = date("d-m-Y h:i:s", strtotime($timeing_data['checkout_date'].' '.$timeing_data['checkout_time']));
                            }else{  
                                $table_formate[$i][$j] = "00-00-0000".' '."00:00:00";
                            }
                            break;
                        case 24:
                            if($timeing_data['meeting_end_date'] != '0000-00-00' && $timeing_data['meeting_end_time'] != '00:00:00'){
                                $table_formate[$i][$j] = date("d-m-Y h:i:s", strtotime($timeing_data['meeting_end_date'].' '.$timeing_data['meeting_end_time']));
                            }else{  
                                $table_formate[$i][$j] = "00-00-0000".' '."00:00:00";
                            }
                            break;
                    }
                }else{
                    $table_formate[$i][$j] =  $log_data[$column];   
                }
            }
        }
    }

    $xlsx = SimpleXLSXGen::fromArray($table_formate);
    $xlsx->downloadAs($file_name.'.xlsx');
}

function referal_excel($sql_data){
    include "../include/xlsxgen.php";
    include '../include/_dbconnect.php';
    $column = array('<html><b>Sl No</b></html>', '<html><b>Reffer By (Emp. Code)</b></html>','<html><b>Reffer By (Emp. Name)</b></html>', '<html><b>Reffer To (Emp. Code)</b></html>', '<html><b>Reffer To (Emp. Name)</b></html>', '<html><b>Visit Log ID</b></html>','<html><b>Visitor Id</b></html>','<html><b>Visitor Name</b></html>', '<html><b>Reffer Timing</b></html>', '<html><b>Status</b></html>');
    $table_formate =array($column,);
    for($i=1; $i<=mysqli_num_rows($sql_data); $i++){
        // $table_formate[$i][0] = $i;
        $reffer_data = mysqli_fetch_assoc($sql_data);
        $emp_code_id = "";
        $visitor_name="";
        $visitor_id="";
        $check_status = "";
        $refer_by_name="";
        $refer_to_name="";
        // $refer_by_id = $reffer_data['refer_by'];
        // $user_code_id = $refer_by_id;
        // include '../include/_emp_details.php';
        // $refer_by_code = $emp_code_user_id;
        // $refer_by_name = $emp_name;

        // $refer_to_id = $reffer_data['refer_to'];
        // $user_code_id = $refer_to_id;
        // include '../include/_emp_details.php';
        // $refer_to_code = $emp_code_user_id;
        // $refer_to_name = $emp_name;
        $refe_by = $reffer_data['refer_by'];
        $refer_by_emp_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where `Emp_code`='$refe_by'"));
        if($refer_by_emp_details!=""){
            $refer_by_name  = $refer_by_emp_details['EmployeeName'];
        }

        $refe_to = $reffer_data['refer_to'];
        $refer_to_emp_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where `Emp_code`='$refe_to'"));
        if($refer_to_emp_details!=""){
            $refer_to_name  = $refer_to_emp_details['EmployeeName'];
        }

        $visit_log_id =$reffer_data['refer_visitor'];
        $v_log_data = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_log` where `visit_uid` = '$visit_log_id'"));
        if($v_log_data!=""){
            $v_log_v_id = $v_log_data['visitor_id'];
            $check_status = $v_log_data['check_status'];
            $visitor_data = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_info` where `visitor_id`='$v_log_v_id'"));
            if($visitor_data!=""){
                $visitor_id = $visitor_data['visitor_id'];
                $visitor_name = $visitor_data['name'];
            }
        }


        for($j=0; $j<count($column); $j++){
            switch($j){
                case 0:
                    $table_formate[$i][$j] = $i;
                    break;
                case 1:
                    $table_formate[$i][$j] = $refe_by;
                    break;
                case 2:
                    $table_formate[$i][$j] = ucfirst($refer_by_name);
                    break;
                case 3:
                    $table_formate[$i][$j] = $refe_to;
                    break;
                case 4:
                    $table_formate[$i][$j] = ucfirst($refer_to_name);
                    break;
                case 5:
                    $table_formate[$i][$j] = $visit_log_id;
                    break;
                case 6:
                    $table_formate[$i][$j] = $visitor_id;
                    break;
                case 7:
                    $table_formate[$i][$j] = ucfirst($visitor_name);
                    break;
                case 8:
                    $table_formate[$i][$j] = date("d-m-Y H:i:s", strtotime($reffer_data['refer_date'].' '.$reffer_data['refer_time']));
                    break;
                case 9:
                    $table_formate[$i][$j] = $check_status ;
                    break;
            }
            
        }
    }
    $file_name= "Refferal_report";
    $xlsx = SimpleXLSXGen::fromArray($table_formate);
    $xlsx->downloadAs($file_name.'.xlsx');
}

// view_data_and_print




//date range basic report
if(isset($_POST['besic_log_date_range'])){
    $from_date = $_POST['fm_date'];
    $to_date = $_POST['to_date'];
    try{

        if($from_date!="" && $to_date!=""){
            $from_date = $_POST['fm_date']."00:00:01";
            $to_date = $_POST['to_date']."23:59:59";
            
            $reg_fm_date  = date("Y-m-d H:i:s", strtotime($from_date));
            $reg_to_date  = date("Y-m-d H:i:s", strtotime($to_date));
            if(strtotime($reg_fm_date)<=strtotime($reg_to_date)){
                $sql_for_v_log = mysqli_query($conn, "select * from `visitor_log` where `register_time_stamp` between '$reg_fm_date' and '$reg_to_date'");
                $file_name="Besic_report_".date("d-m-Y",strtotime($from_date))."_".date("d-m-Y",strtotime($to_date));
                besic_excle($sql_for_v_log, $file_name, 1);
                
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']='From date Should be less then To date';
                header("location:visitor_report");
            }
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please eneter details carefully';
            header("location:visitor_report");
        }
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
//date range details report
if(isset($_POST['details_log_date_range'])){
    $from_date = $_POST['fm_date'];
    $to_date = $_POST['to_date'];
    try{
        if($from_date!="" && $to_date!=""){
            $from_date = $_POST['fm_date']."00:00:01";
            $to_date = $_POST['to_date']."23:59:59";
            
            $reg_fm_date  = date("Y-m-d H:i:s", strtotime($from_date));
            $reg_to_date  = date("Y-m-d H:i:s", strtotime($to_date));
            if(strtotime($reg_fm_date)<=strtotime($reg_to_date)){
                $sql_for_v_log = mysqli_query($conn, "select * from `visitor_log` where `register_time_stamp` between '$reg_fm_date' and '$reg_to_date'");
                $file_name="Details_report_".date("d-m-Y",strtotime($from_date))."_".date("d-m-Y",strtotime($to_date));
                besic_excle($sql_for_v_log, $file_name, 2);  
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']='From date Should be less then To date';
                header("location:visitor_report");
            }
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please eneter details carefully';
            header("location:visitor_report");
        }
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
//date range view report
if(isset($_POST['view_log_date_range'])){
    $from_date = $_POST['fm_date'];
    $to_date = $_POST['to_date'];
    try{

        if($from_date!="" && $to_date!=""){
            $from_date = $_POST['fm_date']."00:00:01";
            $to_date = $_POST['to_date']."23:59:59";
            
            $reg_fm_date  = date("Y-m-d H:i:s", strtotime($from_date));
            $reg_to_date  = date("Y-m-d H:i:s", strtotime($to_date));
            if(strtotime($reg_fm_date)<=strtotime($reg_to_date)){
                $sql_for_v_log = "select * from `visitor_log` where `register_time_stamp` between '$reg_fm_date' and '$reg_to_date'";
                // echo $sql_for_v_log;
                
                
                header("location:visit_report_print.php?data=".base64_encode($sql_for_v_log));
                //    
                
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']='From date Should be less then To date';
                header("location:visitor_report");
            }
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please eneter details carefully';
            header("location:visitor_report");
        }
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}



// basic details emp date range

if(isset($_POST['basic_log_by_emp_daterange'])){
    $emp_code = $_POST['Emp_code'];
    $from_date = $_POST['fm_date'];
    $to_date = $_POST['to_date'];

    try{
        if($emp_code!="" && $from_date!="" && $to_date!=""){
            if(strtotime($from_date)<= strtotime($to_date)){
                $from_date = date("Y-m-d", strtotime($from_date)) ;
                $to_date =  date("Y-m-d", strtotime($to_date));
                if($emp_code=='ALL'){
                    $sql_for_v_log = mysqli_query($conn, "select * from `visitor_log` where `check_status`!='Pending' and `checkin_date` between '$from_date' and '$to_date'");
                }else{
                    $full=explode(' ', $emp_code);
                    $emp_code=$full[0];
                    $sql_for_v_log = mysqli_query($conn, "select * from `visitor_log` where `emp_id`= '$emp_code' and `check_status`!='Pending' and `checkin_date` between '$from_date' and '$to_date'");
                }
                $file_name="Besic_report_of_".$emp_code;
                besic_excle($sql_for_v_log, $file_name, 1);
                
                                
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']='From date Should be less then To date';
                header("location:visitor_report");
            }
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please give proper information';
            header("location:visitor_report");
        }
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
// details emp date range

if(isset($_POST['details_log_by_emp_daterange'])){
    $emp_code = $_POST['Emp_code'];
    $from_date = $_POST['fm_date'];
    $to_date = $_POST['to_date'];

    try{
        if($emp_code!="" && $from_date!="" && $to_date!=""){
            if(strtotime($from_date)<= strtotime($to_date)){
                $from_date = date("Y-m-d", strtotime($from_date)) ;
                $to_date =  date("Y-m-d", strtotime($to_date));
                if($emp_code=='ALL'){
                    $sql_for_v_log = mysqli_query($conn, "select * from `visitor_log` where `check_status`!='Pending' and `checkin_date` between '$from_date' and '$to_date'");
                }else{
                    $full=explode(' ', $emp_code);
                    $emp_code=$full[0];
                    $sql_for_v_log = mysqli_query($conn, "select * from `visitor_log` where `emp_id`= '$emp_code' and `check_status`!='Pending' and `checkin_date` between '$from_date' and '$to_date'");
                }
                $file_name="Details_report_of_".$emp_code;
                besic_excle($sql_for_v_log, $file_name, 2);
                
                                
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']='From date Should be less then To date';
                header("location:visitor_report");
            }
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please give proper information';
            header("location:visitor_report");
        }
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
// view details emp date range

if(isset($_POST['view_log_by_emp_daterange'])){
    $emp_code = $_POST['Emp_code'];
    $from_date = $_POST['fm_date'];
    $to_date = $_POST['to_date'];

    try{
        if($emp_code!="" && $from_date!="" && $to_date!=""){
            if(strtotime($from_date)<= strtotime($to_date)){
                $from_date = date("Y-m-d", strtotime($from_date)) ;
                $to_date =  date("Y-m-d", strtotime($to_date));
                if($emp_code =='ALL'){
                    $sql_for_v_log = "select * from `visitor_log` where `check_status`!='Pending' and `checkin_date` between '$from_date' and '$to_date'";
                }else{
                    $full=explode(' ', $emp_code);
                    $emp_code=$full[0];
                    $sql_for_v_log = "select * from `visitor_log` where `emp_id`= '$emp_code' and `check_status`!='Pending' and `checkin_date` between '$from_date' and '$to_date'";
                }
                header("location:visit_report_print.php?data=".base64_encode($sql_for_v_log));
                
                                
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']='From date Should be less then To date';
                header("location:visitor_report");
            }
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please give proper information';
            header("location:visitor_report");
        }
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}

// basic details emp monthly

if(isset($_POST['besic_log_by_emp_monthly'])){
    $emp_code = $_POST['Emp_code'];
    $month = $_POST['month_report'];
    $year = $_POST['year_report'];

    try{
        if($emp_code!="" && $month!="" && $year!=""){
            
            $from_date = date("Y-m-01", strtotime($month.'-'.$year)) ;
            $to_date =  date("Y-m-t", strtotime($month.'-'.$year));
            if($emp_code=='ALL'){
                $sql_for_v_log = mysqli_query($conn, "select * from `visitor_log` where `check_status`!='Pending' and `checkin_date` between '$from_date' and '$to_date'");
            }else{
                $full=explode(' ', $emp_code);
                $emp_code=$full[0];
                $sql_for_v_log = mysqli_query($conn, "select * from `visitor_log` where `emp_id`= '$emp_code' and `check_status`!='Pending' and `checkin_date` between '$from_date' and '$to_date'");
            }
            $file_name="Besic_report_of_".$emp_code;
            besic_excle($sql_for_v_log, $file_name, 1);
            
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please give proper information';
            header("location:visitor_report");
        }
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
// details emp monthly

if(isset($_POST['details_log_by_emp_monthly'])){
    $emp_code = $_POST['Emp_code'];
    $month = $_POST['month_report'];
    $year = $_POST['year_report'];

    try{
        if($emp_code!="" && $month!="" && $year!=""){
        
            $from_date = date("Y-m-01", strtotime($month.'-'.$year)) ;
            $to_date =  date("Y-m-t", strtotime($month.'-'.$year));
            if($emp_code=='ALL'){
                $sql_for_v_log = mysqli_query($conn, "select * from `visitor_log` where `check_status`!='Pending' and `checkin_date` between '$from_date' and '$to_date'");
            }else{
                $full=explode(' ', $emp_code);
                $emp_code=$full[0];
                $sql_for_v_log = mysqli_query($conn, "select * from `visitor_log` where `emp_id`= '$emp_code' and `check_status`!='Pending' and  `checkin_date` between '$from_date' and '$to_date'");
            }
            $file_name="Details_report_of_".$emp_code;
            besic_excle($sql_for_v_log, $file_name, 2);
                
                                
            
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please give proper information';
            header("location:visitor_report");
        }
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
// details emp monthly

if(isset($_POST['view_log_by_emp_monthly'])){
    $emp_code = $_POST['Emp_code'];
    $month = $_POST['month_report'];
    $year = $_POST['year_report'];

    try{
        if($emp_code!="" && $month!="" && $year!=""){
            
            $from_date = date("Y-m-01", strtotime($month.'-'.$year)) ;
            $to_date =  date("Y-m-t", strtotime($month.'-'.$year));
            if($emp_code=='ALL'){
                $sql_for_v_log = "select * from `visitor_log` where `check_status`!='Pending' and  `checkin_date`  between '$from_date' and '$to_date'";
            }else{
                $full=explode(' ', $emp_code);
                $emp_code=$full[0];
                $sql_for_v_log ="select * from `visitor_log` where `emp_id`= '$emp_code' and `check_status`!='Pending' and `checkin_date` between '$from_date' and '$to_date'";
            }
            header("location:visit_report_print.php?data=".base64_encode($sql_for_v_log));                       
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please give proper information';
            header("location:visitor_report");
        }
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}

// basic repot on check status
if(isset($_POST['besic_log_by_sts_daterange'])){
    $status = $_POST['check_sts'];
    $from_date = $_POST['fm_date'];
    $to_date = $_POST['to_date'];
    try{
        if($status!="" && $from_date!="" && $to_date!=""){
            if(strtotime($from_date)<= strtotime($to_date)){

                $from_date = date("Y-m-d", strtotime($from_date)) ;
                $to_date =  date("Y-m-d", strtotime($to_date));
                if($status=='IN'){
                    $sql_for_v_log = mysqli_query($conn, "select * from `visitor_log` where `check_status`!='Pending' and  `checkin_date` between '$from_date' and '$to_date'");
                    
                }else if($status=='OUT'){
                    $sql_for_v_log = mysqli_query($conn, "select * from `visitor_log` where `check_status`!='Pending' and `checkout_date` between '$from_date' and '$to_date'");

                }else{
                    $_SESSION['icon']='error';
                    $_SESSION['status']='Data Not Found';
                    header("location:visitor_report");
                }
                $file_name="Basic_report_of_".$status."_status";
                besic_excle($sql_for_v_log, $file_name, 1);
                
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']='From date should less then To date';
                header("location:visitor_report");
            }
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please give proper information';
            header("location:visitor_report");
        }
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
// Details repot on check status
if(isset($_POST['details_log_by_sts_daterange'])){
    $status = $_POST['check_sts'];
    $from_date = $_POST['fm_date'];
    $to_date = $_POST['to_date'];
    try{
        if($status!="" && $from_date!="" && $to_date!=""){
            if(strtotime($from_date)<= strtotime($to_date)){

                $from_date = date("Y-m-d", strtotime($from_date)) ;
                $to_date =  date("Y-m-d", strtotime($to_date));
                if($status=='IN'){
                    $sql_for_v_log = mysqli_query($conn, "select * from `visitor_log` where `check_status`!='Pending' and  `checkin_date` between '$from_date' and '$to_date'");
                    
                }else if($status=='OUT'){
                    $sql_for_v_log = mysqli_query($conn, "select * from `visitor_log` where `check_status`!='Pending' and `checkout_date` between '$from_date' and '$to_date'");

                }else{
                    $_SESSION['icon']='error';
                    $_SESSION['status']='Data Not Found';
                    header("location:visitor_report");
                }
                 $file_name="Details_report_of_".$status."_status";
                besic_excle($sql_for_v_log, $file_name, 2);
                
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']='From date should less then To date';
                header("location:visitor_report");
            }
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please give proper information';
            header("location:visitor_report");
        }
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
// view details repot on check status
if(isset($_POST['view_log_by_sts_daterange'])){
    $status = $_POST['check_sts'];
    $from_date = $_POST['fm_date'];
    $to_date = $_POST['to_date'];
    try{
        if($status!="" && $from_date!="" && $to_date!=""){
            if(strtotime($from_date)<= strtotime($to_date)){

                $from_date = date("Y-m-d", strtotime($from_date)) ;
                $to_date =  date("Y-m-d", strtotime($to_date));
                if($status=='IN'){
                    $sql_for_v_log = "select * from `visitor_log` where `check_status`!='Pending' and  `checkin_date` between '$from_date' and '$to_date'";
                    
                }else if($status=='OUT'){
                    $sql_for_v_log = "select * from `visitor_log` where `check_status`!='Pending' and `checkout_date` between '$from_date' and '$to_date'";

                }else{
                    $_SESSION['icon']='error';
                    $_SESSION['status']='Data Not Found';
                    header("location:visitor_report");
                }
                 header("location:visit_report_print.php?data=".base64_encode($sql_for_v_log));
                
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']='From date should less then To date';
                header("location:visitor_report");
            }
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please give proper information';
            header("location:visitor_report");
        }
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}

// visitor type basic report

if(isset($_POST['baseic_log_by_visit_type_purpose'])){
    $v_type = $_POST['v_type'];
    $v_purpose = $_POST['v_purpose'];
    try{
        if($v_type!="" && $v_purpose!=""){
            if($v_type=='ALL'){
                if($v_purpose=='ALL'){
                    $sql_for_v_log  = "select * from `visitor_log` where `check_status`!='Pending'";
                }else{
                    $sql_for_v_log  = "select * from `visitor_log` where `visit_purpose`='$v_purpose' and `check_status`!='Pending'";
                    
                }
            }else if($v_purpose=='ALL'){
                if($v_type=='ALL'){
                    $sql_for_v_log  = "select * from `visitor_log` where `check_status`!='Pending'";
                    
                }else{
                    $sql_for_v_log  = "select * from `visitor_log` where `visitor_type`='$v_type' and `check_status`!='Pending'";
                    
                }
            }else{
                $sql_for_v_log  = "select * from `visitor_log` where `visitor_type`='$v_type' and `visit_purpose`='$v_purpose' and `check_status`!='Pending'";

            }
            $sql_for_v_log = mysqli_query($conn, $sql_for_v_log);
            $file_name="Basic_report";
            besic_excle($sql_for_v_log, $file_name, 1);

        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please Fill all the information carefully';
            header("location:visitor_report");
        }

    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}

// visitor type details report

if(isset($_POST['details_log_by_visit_type_purpose'])){
    $v_type = $_POST['v_type'];
    $v_purpose = $_POST['v_purpose'];
    try{
        if($v_type!="" && $v_purpose!=""){
            if($v_type=='ALL'){
                if($v_purpose=='ALL'){
                    $sql_for_v_log  = "select * from `visitor_log` where `check_status`!='Pending'";
                }else{
                    $sql_for_v_log  = "select * from `visitor_log` where `visit_purpose`='$v_purpose' and `check_status`!='Pending'";
                    
                }
            }else if($v_purpose=='ALL'){
                if($v_type=='ALL'){
                    $sql_for_v_log  = "select * from `visitor_log` where `check_status`!='Pending'";
                    
                }else{
                    $sql_for_v_log  = "select * from `visitor_log` where `visitor_type`='$v_type' and `check_status`!='Pending'";
                    
                }
            }else{
                $sql_for_v_log  = "select * from `visitor_log` where `visitor_type`='$v_type' and `visit_purpose`='$v_purpose' and `check_status`!='Pending'";

            }
            $sql_for_v_log = mysqli_query($conn, $sql_for_v_log);
            $file_name="Details_report";
            besic_excle($sql_for_v_log, $file_name, 2);

        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please Fill all the information carefully';
            header("location:visitor_report");
        }

    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
// view visitor type details report 

if(isset($_POST['view_log_by_visit_type_purpose'])){
    $v_type = $_POST['v_type'];
    $v_purpose = $_POST['v_purpose'];
    try{
        if($v_type!="" && $v_purpose!=""){
            if($v_type=='ALL'){
                if($v_purpose=='ALL'){
                    $sql_for_v_log  = "select * from `visitor_log` where `check_status`!='Pending'";
                }else{
                    $sql_for_v_log  = "select * from `visitor_log` where `visit_purpose`='$v_purpose' and `check_status`!='Pending'";
                    
                }
            }else if($v_purpose=='ALL'){
                if($v_type=='ALL'){
                    $sql_for_v_log  = "select * from `visitor_log` where `check_status`!='Pending'";
                    
                }else{
                    $sql_for_v_log  = "select * from `visitor_log` where `visitor_type`='$v_type' and `check_status`!='Pending'";
                    
                }
            }else{
                $sql_for_v_log  = "select * from `visitor_log` where `visitor_type`='$v_type' and `visit_purpose`='$v_purpose' and `check_status`!='Pending'";

            }
            header("location:visit_report_print.php?data=".base64_encode($sql_for_v_log));
                

        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please Fill all the information carefully';
            header("location:visitor_report");
        }

    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
if(isset($_POST['details_refer_by_log'])){
    $emp_code = $_POST['Emp_code'];
    $from_date = $_POST['fm_date'];
    $to_date=$_POST['to_date'];
    try{
        if($emp_code!="" && $from_date!="" && $to_date!=""){
            if(strtotime($from_date)<= strtotime($to_date)){
                $from_date = date("Y-m-d", strtotime($from_date)) ;
                $to_date =  date("Y-m-d", strtotime($to_date));
                if($emp_code == 'ALL'){
                    $sql_for_reffer = "select * from `meeting_referrable` where `refer_date` between '$from_date' and '$to_date'";
                    
                }else{
                    $full=explode(' ', $emp_code);
                    $emp_code_id=$full[0];
                    include '../include/_emp_details.php';
                    $user_id =$emp_code_user_id;

                    $sql_for_reffer = "select * from `meeting_referrable` where `refer_by`='$user_id' and `refer_date` between '$from_date' and '$to_date'";

                }
                $sql_data = mysqli_query($conn, $sql_for_reffer);
                referal_excel($sql_data);

            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']='To Date should be greter then From date';
                header("location:visitor_report");
            }
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please Provide Proper Informaion';
            header("location:visitor_report");
        }


    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
//reffer_by_detais repport
if(isset($_POST['details_log_report_refer_by'])){
    $emp_code = $_POST['Emp_code'];
    $from_date = $_POST['fm_date'];
    $to_date=$_POST['to_date'];
    try{
        if($emp_code!="" && $from_date!="" && $to_date!=""){
            if(strtotime($from_date)<= strtotime($to_date)){
                $from_date = date("Y-m-d", strtotime($from_date)) ;
                $to_date =  date("Y-m-d", strtotime($to_date));
                if($emp_code == 'ALL'){
                    $sql_for_reffer = "select * from `meeting_referrable` where `refer_date` between '$from_date' and '$to_date'";
                    
                }else{
                    $full=explode(' ', $emp_code);
                    $emp_code_id=$full[0];
                   
                    echo $user_id;
                    $sql_for_reffer = "select * from `meeting_referrable` where `refer_by`='$emp_code_id' and `refer_date` between '$from_date' and '$to_date'";

                }
                // $sql_data = mysqli_query($conn, $sql_for_reffer);
                // referal_excel($sql_data);

            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']='To Date should be greter then From date';
                header("location:visitor_report");
            }
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please Provide Proper Informaion';
            header("location:visitor_report");
        }


    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
//reffer_by view repport
if(isset($_POST['view_refer_by_log'])){
    $emp_code = $_POST['Emp_code'];
    $from_date = $_POST['fm_date'];
    $to_date=$_POST['to_date'];
    try{
        if($emp_code!="" && $from_date!="" && $to_date!=""){
            if(strtotime($from_date)<= strtotime($to_date)){
                $from_date = date("Y-m-d", strtotime($from_date)) ;
                $to_date =  date("Y-m-d", strtotime($to_date));
                if($emp_code == 'ALL'){
                    $sql_for_reffer = "select * from `meeting_referrable` where `refer_date` between '$from_date' and '$to_date'";
                    
                }else{
                    $full=explode(' ', $emp_code);
                    $emp_code_id=$full[0];
                    

                    $sql_for_reffer = "select * from `meeting_referrable` where `refer_by`='$emp_code_id' and `refer_date` between '$from_date' and '$to_date'";

                }
                header("location:visit_report_print.php?reffer_data=".base64_encode($sql_for_reffer));
             

            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']='To Date should be greter then From date';
                header("location:visitor_report");
            }
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please Provide Proper Informaion';
            header("location:visitor_report");
        }


    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
//reffer_to_detais repport
if(isset($_POST['details_refer_to_log'])){
    $emp_code = $_POST['Emp_code'];
    $from_date = $_POST['fm_date'];
    $to_date=$_POST['to_date'];
    try{
        if($emp_code!="" && $from_date!="" && $to_date!=""){
            if(strtotime($from_date)<= strtotime($to_date)){
                $from_date = date("Y-m-d", strtotime($from_date)) ;
                $to_date =  date("Y-m-d", strtotime($to_date));
                if($emp_code == 'ALL'){
                    $sql_for_reffer = "select * from `meeting_referrable` where `refer_date` between '$from_date' and '$to_date'";
                    
                }else{
                    $full=explode(' ', $emp_code);
                    $emp_code_id=$full[0];
                    
                    $sql_for_reffer = "select * from `meeting_referrable` where `refer_to`='$emp_code_id' and `refer_date` between '$from_date' and '$to_date'";

                }
                $sql_data = mysqli_query($conn, $sql_for_reffer);
                referal_excel($sql_data);

            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']='To Date should be greter then From date';
                header("location:visitor_report");
            }
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please Provide Proper Informaion';
            header("location:visitor_report");
        }


    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
//reffer_by view repport
if(isset($_POST['view_refer_to_log'])){
    $emp_code = $_POST['Emp_code'];
    $from_date = $_POST['fm_date'];
    $to_date=$_POST['to_date'];
    try{
        if($emp_code!="" && $from_date!="" && $to_date!=""){
            if(strtotime($from_date)<= strtotime($to_date)){
                $from_date = date("Y-m-d", strtotime($from_date)) ;
                $to_date =  date("Y-m-d", strtotime($to_date));
                if($emp_code == 'ALL'){
                    $sql_for_reffer = "select * from `meeting_referrable` where `refer_date` between '$from_date' and '$to_date'";
                    
                }else{
                    $full=explode(' ', $emp_code);
                    $emp_code_id=$full[0];
                   

                    $sql_for_reffer = "select * from `meeting_referrable` where `refer_to`='$emp_code_id' and `refer_date` between '$from_date' and '$to_date'";

                }
                header("location:visit_report_print.php?reffer_data=".base64_encode($sql_for_reffer));
             

            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']='To Date should be greter then From date';
                header("location:visitor_report");
            }
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Please Provide Proper Informaion';
            header("location:visitor_report");
        }


    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
?>