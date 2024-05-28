<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_function.php';
$des = "";
include '../include/_audi_log.php';
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    if (in_array($user_role, array("Developer", "Super Admin"))) {
        $sql_emp_data = mysqli_fetch_assoc(mysqli_query($conn, "select eomploye_details.* from eomploye_details join user on eomploye_details.EmployeeId = user.EmployeeId where user.user_role != 'Security' and eomploye_details.`Emp_code`='$id'"));
    } else {
        $sql_emp_data = mysqli_fetch_assoc(mysqli_query($conn, "select eomploye_details.* from eomploye_details join user on eomploye_details.EmployeeId = user.EmployeeId where user.user_role != 'Security' and eomploye_details.`BranchId`= '$branch_id' and eomploye_details.`Emp_code`='$id'"));

    }
    $Employe_code = "Not Found";
    $Employe_name = "Not Found";

    $Employe_branch = "Not Found";
    $Employe_depart = "Not Found";

    $company_name = "Not Found";
    $department = "Not Found";
    $designation = "Not Found";
    $branch = "Not Found";
    $Employe_sts = "Not Found";

    if ($sql_emp_data != "") {
        $Employe_code = $sql_emp_data['Emp_code'];
        $Employe_name = $sql_emp_data['EmployeeName'];
        $Employe_con = $sql_emp_data['ContactNo'];
        $Employe_type = $sql_emp_data['EmployeType'];
        $Employe_sts = $sql_emp_data['Status'];
        $company_name = findCom($conn, $sql_emp_data['CompanyId']);
        $department = findDepartment($conn, $sql_emp_data['DepartmentId']);
        $designation = findDesig($conn, $sql_emp_data['DesignationId']);
        $branch = findBranch($conn, $sql_emp_data['BranchId']);

    }






    echo '   
        <div class="card-header">
            <h5>Employee Details</h5>
            </div>

            
            <div class="card-block table-border-style">
            <div class="table-responsive" style="height:auto">
                <table class="table" style="color:black; font-weight:600;"border="0">
                    
                    <tbody>
                       
                        <tr style="">
                            
                            <td style="padding:.55rem; text-align:left; width:11rem;font-size:1.3rem; font-family:emoji;">Employee Name </td>
                            <td style="width:1rem;">:-</td>
                            <td style="color:#2b9b01;padding:.55rem; text-align:left;font-size:1.3rem; font-family:emoji;">' . ucfirst($Employe_name) . '</td>
                            
                        </tr>
                        <tr style="">
                            
                            <td style="padding:.55rem; text-align:left; width:11rem;font-size:1.3rem; font-family:emoji;">Company Name </td>
                            <td style="width:1rem;">:-</td>
                            <td style="color:#2b9b01;padding:.55rem; text-align:left;font-size:1.3rem; font-family:emoji;">' . ucfirst($company_name) . '</td>
                            
                        <tr style="">
                            
                            <td style="padding:.55rem; text-align:left; width:11rem;font-size:1.3rem; font-family:emoji;">Branch </td>
                            <td style="width:1rem;">:-</td>
                            <td style="color:#2b9b01;padding:.55rem; text-align:left;font-size:1.3rem; font-family:emoji;">' . ucfirst($branch) . '</td>
                            
                        </tr>
                        <tr style="">
                            
                            <td style="padding:.55rem; text-align:left; width:11rem;font-size:1.3rem; font-family:emoji;">Department  </td>
                            <td style="width:1rem;">:-</td>
                            <td style="color:#2b9b01;padding:.55rem; text-align:left;font-size:1.3rem; font-family:emoji;">' . ucfirst($department) . '</td>
                            
                        </tr>
                        
                        <tr style="">
                            
                            <td style="padding:.55rem; text-align:left; width:11rem;font-size:1.3rem; font-family:emoji;">Designation </td>
                            <td style="width:1rem;">:-</td>
                            <td style="color:#2b9b01;padding:.55rem; text-align:left;font-size:1.3rem; font-family:emoji;">' . ucfirst($designation) . '</td>
                            
                        </tr>
                       
                        <tr style="">
                            
                            <td style="padding:.55rem; text-align:left; width:11rem;font-size:1.3rem; font-family:emoji;">Employee Status  </td>
                            <td style="width:1rem;">:-</td>
                            <td style="color:#2b9b01;padding:.55rem; text-align:left;font-size:1.3rem; font-family:emoji;">' . ucfirst($Employe_sts) . '</td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        
    ';



}

if (isset($_POST['id_no'])) {
    $id = $_POST['id_no'];
    $id_type = $_POST['type'];

    $v_salu = "";
    $v_name = "";
    $v_com = "";
    $v_desig = "";
    $v_add = "";
    $v_gmail = "";
    $v_contact = "";


    $sql_visitor_info = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_info` where `govt_id_type` = '$id_type' and `govt_id_no`='$id'"));
    if ($sql_visitor_info != "") {
        $v_salu = $sql_visitor_info['salutation'];
        $v_name = $sql_visitor_info['name'];
        $v_com = $sql_visitor_info['com_name'];
        $v_desig = $sql_visitor_info['designation'];
        $v_add = $sql_visitor_info['address'];
        $v_gmail = $sql_visitor_info['mail_id'];
        $v_contact = $sql_visitor_info['contact_no'];
    }



    $array = array($v_salu, $v_name, $v_com, $v_desig, $v_add, $v_gmail, $v_contact);
    echo json_encode($array);
    exit();
}

if (isset($_POST['V_log'])) {
    $company_name = "Not Found";
    $v_name = "Not Found";
    $v_c_name = "Not Found";
    $v_c_no = "Not Found";
    $v_g_no = "Not Found";
    $v_p = "Not Found";
    $v_type = "Not Found";
    $v_e_code = "Not Found";
    $v_e_name = "Not Found";
    $v_time = "Not Found";
    $v_date = "Not Found";
    $v_sts = "Not Found";
    $v_desig = "Not Found";
    $v_address = "Not Found";
    $v_email = "Not Found";
    $v_mobile = "Not Found";
    $v_govt_id = "Not Found";
    $v_mertial = "Not Found";
    $v_vehicle_type = "Not Found";
    $v_vehicle_no = "Not Found";
    $v_e_depart = "Not Found";
    $v_e_desig = "Not Found";
    $approval_sts = "Panding";
    $v_time_p = "Not Found";
    $id = $_POST['V_log'];
    $vlog_id = "VSL-" . $id;
    $dami_img = "'../src/error.png'";
    if (in_array($user_role, array("Developer", "Super Admin"))) {
        $visit_data = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_log` where `visit_uid`='$vlog_id'"));

    } else {
        // echo $branch_id;
        $visit_data = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_log` where `branch_id`='$branch_id ' and `visit_uid`='$vlog_id'"));

    }
    if ($visit_data != "") {
        $sequri_sts = $visit_data['security_approval'];
        $emp_visit_status = $visit_data['Emp_approve'];
        if ($sequri_sts == "Approve" && $emp_visit_status == "Approve") {
            $approval_sts = "Approve";
        } else if ($sequri_sts == "Reject" || $emp_visit_status == "Reject") {
            $approval_sts = "Reject";
        }

        $v_c_no = $visit_data['id_card_no'];
        $v_g_no = $visit_data['gate_no'];
        $v_time = $visit_data['checkin_time'];
        $v_time_p = date("h:i:s A", strtotime($v_time));
        $v_date = $visit_data['checkin_date'];
        $v_date = date("d-M-Y", strtotime($v_date));
        $v_sts = ucfirst($visit_data['check_status']);
        $v_mertial = $visit_data['things_brought'];
        $v_vehicle_type = $visit_data['vehical_type'];
        $v_vehicle_no = $visit_data['vahical_num'];
        $arrival_date_time = $visit_data['Arrival_time_stamp'];
        $prereg = $visit_data['pre_schedule_date'];
        if ($arrival_date_time == '0000-00-00 00:00:00') {
            $v_time_p = "00:00:00";
            $v_date = date("d-M-Y", strtotime($prereg));
        } else if ($v_time == '00:00:00' && $arrival_date_time != '0000-00-00 00:00:00') {
            $v_time_p = date("h:i:s A", strtotime($arrival_date_time));
            $v_date = date("d-M-Y", strtotime($arrival_date_time));
        }

        $v_p = $visit_data['visit_purpose'];
        $visito_purpse_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visit_purpose` where `purpose_id` = '$v_p'"));
        if ($visito_purpse_sql != "") {

            $v_p = $visito_purpse_sql['purpose'];
        } else {
            $v_p = "";
        }

        $v_type = $visit_data['visitor_type'];
        $visit_type_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `vsitor_type` where `type_id` = '$v_type'"));
        if ($visit_type_sql != "") {
            $v_type = $visit_type_sql['type_name'];

        } else {
            $v_type = "";
        }


        $v_e_code = $visit_data['emp_id'];
        $emp_details = mysqli_fetch_assoc(mysqli_query($conn, "select *from `eomploye_details` where `Emp_code`='$v_e_code'"));
        if ($emp_details) {
            $v_e_name = $emp_details['EmployeeName'];
            $v_e_depart = $emp_details['DepartmentId'];
            $v_department_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `department` where `department_code`='$v_e_depart'"));
            if ($v_department_sql != "") {
                $v_e_depart = $v_department_sql['department_name'];

            } else {
                $v_e_depart = "";
            }
            $v_e_desig = $emp_details['DesignationId'];
            $v_desig_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `designation` where `designation_code`='$v_e_desig'"));
            if ($v_desig_sql != "") {
                $v_e_desig = $v_desig_sql['designation'];
            } else {
                $v_e_desig = "";
            }

            $com_id = $emp_details['CompanyId'];

            $company_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `company_details` where `company_id` = '$com_id'"));
            if ($company_sql != "") {
                $company_name = $company_sql['companyFname'];
            }

        }


        $visitor_details_id = $visit_data['visitor_id'];
        $visitor_details_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_info` where `visitor_id` = '$visitor_details_id'"));
        if ($visitor_details_sql != "") {
            $v_name = $visitor_details_sql['name'];
            $v_c_name = $visitor_details_sql['com_name'];
            $v_desig = $visitor_details_sql['designation'];
            $v_address = $visitor_details_sql['address'];
            $v_email = $visitor_details_sql['mail_id'];
            $v_mobile = $visitor_details_sql['contact_no'];
            $v_govt_id = $visitor_details_sql['govt_id_no'];
            // $v_govt_id = $masked =  str_pad(substr($v_govt_id, -4), strlen($v_govt_id), '*', STR_PAD_LEFT);
        }
    }

    echo '<section class="animate pop">
	<div class="container" style="padding:1rem;">
		<div class="admit-card">
			<div class="BoxA border- padding mar-bot"> 
				<div class="row" >
					<div class="col-sm-4" style="flex:0 0 33%">
						<h5 style="font-size:15px;">Date :- ' . $v_date . '</h5>
						<p style="margin-bottom:.5rem;">Intime: - ' . $v_time_p . '</p>
					</div>
					<div class="col-sm-4 txt-center" style="flex:0 0 30%; max-width:50%">
						
					</div>
					<div class="col-sm-4"style="flex:0 0 33%">
                        <div style="display:grid; justify-content:end;">
                            <h5 style="font-size:15px;">UID:- ' . $id . '</h5>
                            <p style="margin-bottom:.5rem;">Approval Sts.: - ' . $approval_sts . ' </p>
                        </div>
					</div>
				</div>
			</div>
			
			<div class="BoxD mar-bot">
				<div class="row">
					<div class="col-sm-10" style=" max-width: 100%; flex: 0 0 100%;" >
						<table class="table" style="margin-bottom:0px">
						  <tbody>
							<tr ><td colspan="3" style="font-size:19px; padding:0rem;font-weight:700;border-bottom:2px solid #000;text-align:left;font-family: ' . "El Messiri" . ', sans-serif; font-style:italic;"> Visitor Info</td></tr>
							<tr>
							  <td id="tb" style="padding:0; height:2rem;text-align:left; width:45%;"><b>Visitor Name:- </b>' . $v_name . ' </td>
							  <td style="padding:0; height:2rem;text-align:left;"><b>Govt. Id:- </b>' . $v_govt_id . ' </td>
							  <th rowspan="4" scope="row txt-center" style="width:8rem;"><img src="../upload/' . $vlog_id . '.png" width="123px" height="130px" onerror="this.src=' . $dami_img . '" /></th>
							
							</tr>
							<tr>
							  <td id="tb" style="padding:0; height:2rem;text-align:left; width:45%;"><b>Comopany:- </b>' . $v_c_name . '</td>
							  <td style="padding:0; height:2rem;text-align:left;"><b>Mobile No :- </b>' . $v_mobile . '</td>
							  
							</tr>
							<tr>
							  <td id="tb" style="padding:0; height:2rem;text-align:left; width:45%;"><b>Designation:- </b>' . $v_desig . '</td>
							  <td style="padding:0; height:2rem;text-align:left;"><b>Email:- </b>' . $v_email . '</td>
							  
							</tr>
							<tr>
							  <td id="tb" style="padding:0; height:2rem;text-align:left; width:45%;"><b>Address:- </b>' . $v_address . '</td>
							  <td style="padding:0; height:2rem;text-align:left;"><b>Issued Id No:- </b>' . $v_c_no . '</td>
							  
							</tr>
							<tr>
							  <td id="tb" style="padding:0; height:2rem;text-align:left; width:45%;"><b>Visitor Type:- </b>' . $v_type . '</td>
							  <td style="padding:0; height:2rem;text-align:left;"><b>Purpose: </b>' . $v_p . '</td>
							  <td style="padding:0; height:2rem;text-align:left;"><b>Gate No:- </b>' . $v_g_no . '</td>
							</tr>
							<tr>
							  <td id="tb" style="padding:0; height:2rem;text-align:left; width:45%;"><b>Mterials Carried:- </b><span style="word-break: break-all;">' . $v_mertial . '</span></td>
							  <td style="padding:0; height:2rem;text-align:left;"><b>Vehicle Type(With No): </b>' . $v_vehicle_type . '</td>
							  <td style="padding:0; height:2rem;text-align:left;">' . $v_vehicle_no . '</td>
							</tr>
							
						  </tbody>
						</table>
					</div>
					
				</div>
			</div>
			<div class="row" >
				<div class="col-sm-10" style="max-width: 100%; flex: 0 0 100%;">
						<table class="table">
							  <tbody>
							  <tr ><td colspan="2" style="font-size:19px; padding:0rem;font-weight:700;border-bottom:2px solid #000;text-align:left;font-family: ' . "El Messiri" . ', sans-serif; font-style:italic;"> TO Meet</td></tr>
								<tr>
									<td id="tb" style="padding:0; height:2rem;text-align:left;"><b>Employe Code:- </b>' . $v_e_code . '</td>
									<td style="padding:0; height:2rem;text-align:left;"><b>Employe Name:- </b>' . $v_e_name . '</td>
									<!-- <td><b>DOB: </b>02 Jul 2019</td> -->
								</tr>
								<tr>
									<td id="tb" style="padding:0; height:2rem;text-align:left;"><b>Department:- </b>' . $v_e_depart . '</td>
									<td style="padding:0; height:2rem;text-align:left;"><b>Designation:- </b>' . $v_e_desig . '</td>
									<!-- <td><b>DOB: </b>02 Jul 2019</td> -->
								</tr>
						  </tbody>
						</table>
				</div>
			<!-- <!-- <div class="BoxA border- padding mar-bot">  -->
			</div> 
			
			
			
			
		</div>
	</div>
	
</section>';
}

if (isset($_POST['branchValueemp'])) {
    $branchCode = $_POST['branchValueemp'];
    $data = array();
    if ($branchCode == 'All') {
        $data[] = ['Emp_code' => 'All', 'EmployeeName' => 'All',];
    } else {
        $data[] = ['Emp_code' => 'All', 'EmployeeName' => 'All',];
        $sql_emp_data = mysqli_query($conn, "select Emp_code , EmployeeName from `eomploye_details` where `BranchId`='$branchCode'");
        while ($emp_data = mysqli_fetch_assoc($sql_emp_data)) {
            $data[] = $emp_data;
        }
    }
    echo json_encode($data);
}
?>