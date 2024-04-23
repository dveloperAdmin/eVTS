<head>

<title>VMS</title>
<link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
<style>
    @media print{
	body *{
		visibility: hidden;
		background:white;
	}
	.print_container *{
		visibility: visible;
		background:white;
	}
	.print_container{
		position: absolute;
		left: 0px;
		top: 0px;
	}
}
.btn-primary{
    width: 5rem;
    height: 2.5rem;
    background-color: #fff;
	border-color: #448aff;
	color: #448aff;
	cursor: pointer;
	-webkit-transition: all ease-in 0.3s;
	transition: all ease-in 0.3s;
    font-size:1rem;
    font-weight:bold;
}
.btn-primary:hover{
    background-color: #77aaff;
	border-color: #77aaff;
    color:#fff;
}

@media print
      {
         @page {
           margin-top: 0;
           margin-bottom: 0;
         }
         body  {
           padding-top: 72px;
           padding-bottom: 72px ;
         }
      } 
</style>

</head>





<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head="Visitor Report Process";
$des="Page Load visitor_report_process";
$rem="Visitor Report Process";
include '../include/_audi_log.php';


function details_excel($sql_query){
    include '../include/_dbconnect.php';
    $datatable='<table border="1">
                    <tbody>
                        <tr style="text-align:center;">
                            <td><b>Sl no</b></td>
                            <td><b>Visitor Log Id</b></td>
                            <td><b>Visitor Id</b></td>
                            <td><b>Visitor Name</b></td>
                            <td><b>Govt. Id Type</b></td>
                            <td><b>Govt. Id No</b></td>
                            <td><b>Company Name</b></td>
                            <td><b>Designation</b></td>
                            <td><b>Mobile No</b></td>
                            <td><b>Email Id</b></td>
                            <td><b>Address</b></td>
                            <td><b>Issued Id No</b></td>
                            <td><b>Visitor Type</b></td>
                            <td><b>Purpose</b></td>
                            <td><b>Material Carried</b></td>
                            <td><b>Vehical Type</b></td>
                            <td><b>Vehical No</b></td>
                            <td><b>Visit To (Employee Code)</b></td>
                            <td><b>Employee Name</b></td>
                            <td><b>Department </b></td>
                            <td><b>Designation</b></td>
                            <td><b>Check Status</b></td>
                            <td><b>Check Intime</b></td>
                            <td><b>Check Outtime</b></td>
                            <td><b>Meeting Status</b></td>
                            <td><b>Meeting End Time</b></td>
                            <td><b>Employee Approval</b></td>
                            <td><b>Security Approval</b></td>
                            <td><b>Visitor Photo</b></td>
                        </tr>';
        $i = 1;              
        while($log_data = mysqli_fetch_assoc($sql_query)){
            if($log_data!=""){

                //visitor details
                $v_id = $log_data['visitor_id'];
                $v_name="";
                $v_comname="";
                $v_desig="";
                $v_mob="";
                $v_email="";
                $gv_type="";
                $gv_no="";
                $add="";                
                $v_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `visitor_info` where `visitor_id` =  '$v_id'"));
                if($v_details!=""){
                    $v_name = $v_details['name'];
                    $v_comname = $v_details['com_name'];
                    $v_desig = $v_details['designation'];
                    $v_mob= $v_details['contact_no'];
                    $v_email= $v_details['mail_id'];
                    $gv_type= $v_details['govt_id_type'];
                    $gv_no= $v_details['govt_id_no'];;
                    $add = $v_details['address'];
                }
                // visitor type 
                $v_type=$log_data['visitor_type'];
                $v_type_info = mysqli_fetch_assoc(mysqli_query($conn,"select * from `vsitor_type` where `type_id`='$v_type'"));
                if($v_type_info!=""){
                    $v_type=$v_type_info['type_name'];
                }else{
                    $v_type="";
                }

                // visit purpose
                $v_purpose = $log_data['visit_purpose'];
                $v_purpose_info = mysqli_fetch_assoc(mysqli_query($conn,"select * from `visit_purpose` where `purpose_id` = '$v_purpose'"));
                if($v_purpose_info!=""){
                    $v_purpose =$v_purpose_info['purpose'];
                }else{
                    $v_purpose="";
                }

                //emp details
                $emp_code= $log_data['emp_id'];
                $emp_name = "";
                $emp_deprt="";
                $emp_desig = "";
                $emp_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where `Emp_code` =  '$emp_code'"));
                if($emp_details!=""){
                    $emp_name=$emp_details['EmployeeName'];
                    $emp_deprt = $emp_details['DepartmentId'];
                    $department = mysqli_fetch_assoc(mysqli_query($conn, "select * from `department` where `department_code`= '$emp_deprt'"));
                    if($department!=""){
                        $emp_deprt = $department['department_name'];
                    }else{
                        $emp_deprt ="";
                    }
                    $emp_desig = $emp_details['DesignationId'];
                    $desig_info = mysqli_fetch_assoc(mysqli_query($conn,"select * from `designation` where `designation_code` = '$emp_desig'"));
                    if($desig_info!=""){
                        $emp_desig = $desig_info['designation'];
                    }else{
                        $emp_desig ="";
                    }
                }
              


                $datatable.='<tr style="height:90px;width: 125px;">
                <td style="text-align: center;">'.$i.'</td>
                <td style="text-align: center;">'.$log_data['visit_uid'].'</td>
                <td style="text-align: center;">'.$v_id.'</td>
                <td style="text-align: center;">'.ucfirst($v_name).'</td>
                <td style="text-align: center;">'.$gv_type.'</td>
                <td style="text-align: center;">'.$gv_no.'</td>
                <td style="text-align: center;">'. ucfirst($v_comname).'</td>
                <td style="text-align: center;">'. $v_desig .'</td>
                <td style="text-align: center;">'. $v_mob .'</td>
                <td style="text-align: center;">'. $v_email .'</td>
                <td style="text-align: center;">'. ucfirst($add) .'</td>
                <td style="text-align: center;">'. $log_data['id_card_no'] .'</td>
                <td style="text-align: center;">'. ucfirst($v_type) .'</td>
                <td style="text-align: center;">'. ucfirst($v_purpose) .'</td>
                <td style="text-align: center;">'. $log_data['things_brought'] .'</td>
                <td style="text-align: center;">'. $log_data['vehical_type'] .'</td>
                <td style="text-align: center;">'. $log_data['vahical_num'] .'</td>
                <td style="text-align: center;">'. $emp_code .'</td>
                <td style="text-align: center;">'. ucfirst($emp_name) .'</td>
                <td style="text-align: center;">'. $emp_deprt .'</td>
                <td style="text-align: center;">'. $emp_desig .'</td>
                <td style="text-align: center;">'. $log_data['check_status'] .'</td>
                <td style="text-align: center;">'. $log_data['checkin_date'].' '.$log_data['checkin_time'] .'</td>
                <td style="text-align: center;">'. $log_data['checkout_date'].' '.$log_data['checkout_time'] .'</td>
                <td style="text-align: center;">'. $log_data['meeting_status'] .'</td>
                <td style="text-align: center;">'. $log_data['meeting_end_date'].' '.$log_data['meeting_end_time'] .'</td>
                <td style="text-align: center;">'. $log_data['Emp_approve'] .'</td>
                <td style="text-align: center;">'. $log_data['security_approval'] .'</td>
                <td style="align-content: center;"><img src="../upload/'.$log_data['visit_uid'].'.png" width="85" height="85"/></td>
                </tr>';
                
            }  
            $i++;     
        }
        $datatable.='</tbody></table>';
        // echo $datatable;
               echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
                <a href="visitor_report"><button class="btn-primary" >Back</button></a>';
        echo '<div class="print_container" style="">'.$datatable.'</div>';

}

function reffer_view($sql_data){
    include '../include/_dbconnect.php';

    $datatable='<table border="1">
                    <tbody>
                        <tr style="text-align:center;">
                            <td><b>Sl no</b></td>
                            <td><b>Reffer By (Emp. Code)</b></td>
                            <td><b>Reffer By (Emp. Name)</b></td>
                            <td><b>Reffer To (Emp. Code)</b></td>
                            <td><b>Reffer To (Emp. Name)</b></td>
                            <td><b>Visit Log ID</b></td>
                            <td><b>Visitor Id</b></td>
                            <td><b>Visitor Name</b></td>
                            <td><b>Reffer Timing</b></td>
                            <td><b>Status</b></td>
                            <td><b>Visitor Photo</b></td>
                        </tr>
                ';
    for($i=1; $i<=mysqli_num_rows($sql_data); $i++){
        // $table_formate[$i][0] = $i;
        $reffer_data = mysqli_fetch_assoc($sql_data);
        $emp_code_id = "";
        $visitor_name="";
        $visitor_id="";
        $check_status = "";
        $refer_by_name="";
        $refer_to_name="";
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
        $datatable.='<tr style="height:90px;width: 125px;">
                        <td style="text-align: center;">'.$i.'</td>
                        <td style="text-align: center;">'.$refe_by.'</td>
                        <td style="text-align: center;">'.ucfirst($refer_by_name).'</td>
                        <td style="text-align: center;">'.$refe_to.'</td>
                        <td style="text-align: center;">'.ucfirst($refer_to_name).'</td>
                        <td style="text-align: center;">'.$visit_log_id.'</td>
                        <td style="text-align: center;">'.$visitor_id.'</td>
                        <td style="text-align: center;">'.ucfirst($visitor_name).'</td>
                        <td style="text-align: center;">'.date("d-m-Y H:i:s", strtotime($reffer_data['refer_date'].' '.$reffer_data['refer_time'])).'</td>
                        <td style="text-align: center;">'.$check_status.'</td>
                        <td style="text-align: center;"><img src="http://localhost/vms/upload/'.$visit_log_id.'.png" width="85" height="85"/></td>
                    </tr>
                        ';

    }
    $datatable.='</tbody></table>';
        // echo $datatable;
               echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
                <a href="visitor_report"><button class="btn-primary" >Back</button></a>';
        echo '<div class="print_container" style="">'.$datatable.'</div>';
}



if(isset($_GET['data'])){
    $sql_data = base64_decode($_GET['data']);
    // echo($sql_data);
    try{
        $sql_data = mysqli_query($conn, $sql_data);
        details_excel($sql_data);

    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
if(isset($_GET['reffer_data'])){
    $sql_data = base64_decode($_GET['reffer_data']);
    // echo($sql_data);
    try{
        $sql_data = mysqli_query($conn, $sql_data);
        reffer_view($sql_data);

    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
?>
