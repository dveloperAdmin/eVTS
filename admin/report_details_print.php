<?php
function details_excel($sql_query){
    include '../include/_dbconnect.php';
    $datatable='<table border="1">
                    <tbody>
                        <tr>
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
              


                $datatable.='<tr style="height:110px;width: 125px;">
                <td style="text-align: center;">'.$i.'</td>
                <td style="text-align: center;">'.$log_data['visit_uid'].'</td>
                <td style="text-align: center;">'.$v_id.'</td>
                <td style="text-align: center;">'.$v_name.'</td>
                <td style="text-align: center;">'.$gv_type.'</td>
                <td style="text-align: center;">'.$gv_no.'</td>
                <td style="text-align: center;">'. $v_comname.'</td>
                <td style="text-align: center;">'. $v_desig .'</td>
                <td style="text-align: center;">'. $v_mob .'</td>
                <td style="text-align: center;">'. $v_email .'</td>
                <td style="text-align: center;">'. $add .'</td>
                <td style="text-align: center;">'. $log_data['id_card_no'] .'</td>
                <td style="text-align: center;">'. $v_type .'</td>
                <td style="text-align: center;">'. $v_purpose .'</td>
                <td style="text-align: center;">'. $log_data['things_brought'] .'</td>
                <td style="text-align: center;">'. $log_data['vehical_type'] .'</td>
                <td style="text-align: center;">'. $log_data['vahical_num'] .'</td>
                <td style="text-align: center;">'. $emp_code .'</td>
                <td style="text-align: center;">'. $emp_name .'</td>
                <td style="text-align: center;">'. $emp_deprt .'</td>
                <td style="text-align: center;">'. $emp_desig .'</td>
                <td style="text-align: center;">'. $log_data['check_status'] .'</td>
                <td style="text-align: center;">'. $log_data['checkin_date'].' '.$log_data['checkin_time'] .'</td>
                <td style="text-align: center;">'. $log_data['checkout_date'].' '.$log_data['checkout_time'] .'</td>
                <td style="text-align: center;">'. $log_data['meeting_status'] .'</td>
                <td style="text-align: center;">'. $log_data['meeting_end_date'].' '.$log_data['meeting_end_time'] .'</td>
                <td style="text-align: center;">'. $log_data['Emp_approve'] .'</td>
                <td style="text-align: center;">'. $log_data['security_approval'] .'</td>
                <td style="align-content: center;"><img src="http://localhost/vms/upload/'.$log_data['visit_uid'].'.png" width="85" height="85"/></td>
                </tr>';
                
            }       
        }
        $datatable.='</tbody></table>';
        // echo $datatable;
               echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
                <a href="visitor_report.php"><button class="btn-primary" >Back</button></a>';
        echo '<div class="print_container" style="">'.$datatable.'</div>';

}
?>