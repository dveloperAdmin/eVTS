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
$des="Page Load visitor_info_report_process";
$rem="Visitor Info Report Process";
include '../include/_audi_log.php';

function column(){

    $sl_no = '<html><b>Sl No <b></html>';
    $visitor_id = '<html><b>Visitor Id <b></html>';
    $gvt_id_type= '<html><b>Govt. Id Type <b></html>';
    $gvt_id_no= '<html><b>Govt. Id No <b></html>';
    $visitor_name = '<html><b>Visitor Name <b></html>';
    $com_name = '<html><b>Comapny Name <b></html>';
    $desig = '<html><b>Designation <b></html>';
    $email = '<html><b>Email ID <b></html>';
    $mobile_no = '<html><b>Mobile No <b></html>';
    $address = '<html><b>Address <b></html>';
    $reg_by = '<html><b>Register By<b></html>';
    $reg_time = '<html><b>Register Time<b></html>';
    $visit_count = '<html><b>Visit Count<b></html>';

    $columns = array($sl_no,$visitor_id, $gvt_id_type, $gvt_id_no, $visitor_name, $com_name, $desig, $email, $mobile_no, $address, $reg_by, $reg_time, $visit_count); 
    return($columns);
 
}

function info_excel($sql_data, $file_name){
    include "../include/xlsxgen.php";
    include '../include/_dbconnect.php';

    $colum_name = array('$i','visitor_id','govt_id_type','govt_id_no','name','com_name','designation','mail_id','contact_no','address','register_by','register_date','visitor_id');
    $table_formate =array(column(),);
    for($i=1; $i<=mysqli_num_rows($sql_data);$i++){
        $info_report = mysqli_fetch_assoc($sql_data);
        for($j=0; $j<count($colum_name); $j++){
            if($j==0){
                $table_formate[$i][$j] = $i;
            }else if((in_array($j, range(10,12)))){
                switch($j){
                    case 10:
                        $user_code_id="";
                        $emp_code_id="";
                        $user_code_id=$info_report[$colum_name[$j]];
                        if($user_code_id!=""){
                            include '../include/_emp_details.php';
                            $table_formate[$i][$j] = $emp_name."( ".$emp_code_user_id." )";

                        }else{
                            $table_formate[$i][$j] ="";
                        }
                        break;
                    case 11:
                        $table_formate[$i][$j] = date("d-m-Y H:i:s" , strtotime($info_report[$colum_name[$j]]));
                        break;
                    case 12:
                        $v_id = $info_report[$colum_name[$j]];	
                        $table_formate[$i][$j] = mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `visitor_id` = '$v_id'"));
                }
            }else{
                $table_formate[$i][$j] = $info_report[$colum_name[$j]];
            }
        }
    }
    $xlsx = SimpleXLSXGen::fromArray($table_formate);
    $xlsx->downloadAs($file_name.'.xlsx');
}

function v_info_view($sql_data){
    include '../include/_dbconnect.php';

    $datatable='<table border="1">
                    <tbody>
                        <tr style="text-align:center;">
                            <td><b>Sl no</b></td>
                            <td><b>Visitor Id <b></td>
                            <td><b>Govt. Id Type <b></td>
                            <td><b>Govt. Id No <b></td>
                            <td><b>Visitor Name <b></td>
                            <td><b>Comapny Name <b></td>
                            <td><b>Designation <b></td>
                            <td><b>Email ID <b></td>
                            <td><b>Mobile No <b></td>
                            <td><b>Address <b></td>
                            <td><b>Register By<b></td>
                            <td><b>Register Time<b></td>
                            <td><b>Visit Count<b></td>
                       </tr>
                ';
    for($i=1; $i<=mysqli_num_rows($sql_data);$i++){
        $info_report = mysqli_fetch_assoc($sql_data);
        $user_code_id="";
        $emp_code_id="";
        $emp_formate="";
        $user_code_id=$info_report['register_by'];
        if($user_code_id!=""){
            include '../include/_emp_details.php';
            $emp_formate = $emp_name."( ".$emp_code_user_id." )";

        }else{
            $emp_formate ="";
        }
        $v_id = $info_report['visitor_id'];	
        $count= mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `visitor_id` = '$v_id'"));

    $datatable.=' <tr style="text-align:center;">
                    <td>'.$i.'</td>
                    <td>'.$info_report['visitor_id'].'</td>
                    <td>'.$info_report['govt_id_type'].'</td>
                    <td>'.$info_report['govt_id_no'].'</td>
                    <td>'.ucfirst($info_report['name']).'</td>
                    <td>'.ucfirst($info_report['com_name']).'</td>
                    <td>'.$info_report['designation'].'</td>
                    <td>'.$info_report['mail_id'].'</td>
                    <td>'.$info_report['contact_no'].'</td>
                    <td>'.$info_report['address'].'</td>
                    <td>'.ucfirst($emp_formate).'</td>
                    <td>'.date("d-m-Y H:i:s" , strtotime($info_report['register_date'])).'</td>
                    <td>'.$count.'</td>
                </tr>';
    
    }

    $datatable.='</tbody></table>';
    // echo $datatable;
           echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
            <a href="visitor_info_report"><button class="btn-primary" >Back</button></a>';
    echo '<div class="print_container" style="">'.$datatable.'</div>';


}











// details report from visitor
if(isset($_POST['v_info_monthly'])){
    $from_date = $_POST['from_date'];
    $to_date  = $_POST['to_date'];
    try{
        if($month!="" && $year!=""){
            $from_date = date("Y-m-d H:i:s", strtotime($from_date."00:00:01"));
            $to_date =  date("Y-m-d H:i:s", strtotime($to_date."23:59:59"));

            $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `register_date` between '$from_date' and '$to_date'");
            $file_name = "Visitor_Informaton";
            info_excel($sql_v_info, $file_name);
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Provide correct Info';
            header("location:visitor_info_report");
        } 
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
// details report from visitor
if(isset($_POST['view_log_monthly'])){
    $from_date = $_POST['from_date'];
    $to_date  = $_POST['to_date'];
    try{
        if($month!="" && $year!=""){
            $from_date = date("Y-m-d H:i:s", strtotime($from_date."00:00:01"));
            $to_date =  date("Y-m-d H:i:s", strtotime($to_date."23:59:59"));
            $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `register_date` between '$from_date' and '$to_date'");
            v_info_view($sql_v_info);
        } else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Provide correct Info';
            header("location:visitor_info_report");
        }

    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}

// details report from visitor name
if(isset($_POST['v_name_report'])){
    $v_name = $_POST['v_name'];
    try{
        if($v_name!=""){
            $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `name` like '%$v_name%'");
            $file_name = "Visitor_Informaton";
            info_excel($sql_v_info, $file_name);
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Provide correct Info';
            header("location:visitor_info_report");
        } 
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
// details report from visitor
if(isset($_POST['view_v_name_report'])){
    $v_name = $_POST['v_name'];
    try{
        if($v_name!=""){
            $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `name` like '%$v_name%'");
            v_info_view($sql_v_info);
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Provide correct Info';
            header("location:visitor_info_report");
        } 
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}

// details report from visitor mobile no
if(isset($_POST['details_mobile_report'])){
    $mobile_no = $_POST['mob_no'];
    try{
        if($mobile_no!=""){
            if(strlen($mobile_no)==10){
                $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `contact_no` = '$mobile_no'");
                $file_name = "Visitor_Informaton";
                info_excel($sql_v_info, $file_name);

            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']='Please Entere 10 Digit Mobile no';
                header("location:visitor_info_report");
            }
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Provide correct Info';
            header("location:visitor_info_report");
        } 
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
// details report from visitor mobile no
if(isset($_POST['view_details_mobile_report'])){
    $mobile_no = $_POST['mob_no'];
    try{
        if($mobile_no!=""){
            if(strlen($mobile_no)==10){
                $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `contact_no` = '$mobile_no'");
                v_info_view($sql_v_info);
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']='Please Entere 10 Digit Mobile no';
                header("location:visitor_info_report");
            }
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Provide correct Info';
            header("location:visitor_info_report");
        } 
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
// details report according govt id
if(isset($_POST['details_gvt_id'])){
    $govt_id_type = $_POST['govt_type'];
    $govt_id = $_POST['gvt_no'];
    try{
        if($govt_id_type!="" && $govt_id!=""){
                $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `govt_id_type` = '$govt_id_type' and `govt_id_no` = '$govt_id'");
                $file_name = "Visitor_Informaton";
                info_excel($sql_v_info, $file_name);
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Provide correct Info';
            header("location:visitor_info_report");
        } 
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
// details report view according govt id
if(isset($_POST['view_details_gvt_id'])){
    $govt_id_type = $_POST['govt_type'];
    $govt_id = $_POST['gvt_no'];
    try{
        if($govt_id_type!="" && $govt_id!=""){
                $sql_v_info = mysqli_query($conn, "select * from `visitor_info` where `govt_id_type` = '$govt_id_type' and `govt_id_no` = '$govt_id'");
                v_info_view($sql_v_info);
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Provide correct Info';
            header("location:visitor_info_report");
        } 
    }catch(Exception $e){
        $_SESSION['icon']='info';
        $_SESSION['status']='Please try again leter';
        header("location:visitor_report");
    }
}
?>