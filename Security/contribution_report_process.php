<head>
<title>CMS</title>
<link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
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
</style>
</head>


<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
$user_name= $_SESSION['user_name'];
$user_id = mysqli_fetch_assoc(mysqli_query($conn,"select * from `user` where `user_name` = '$user_name' "));
if($user_id!=""){

    $usre_id = $user_id['EmployeeId'];

    $emp_id = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where `EmployeeId` = $usre_id"));
    $emp_code = $emp_id['Emp_code'];

}




// if(date("m")<10){
//     $m_1 = substr(date("m"), -1);
//     $today_table_name="canteenreport_".$m_1.'_'.date("Y");
// }else{

//     $today_table_name="canteenreport_".date("m").'_'.date("Y");
// }

$total_item_count = 0;
$all_emp_contribution = 0;
$all_emper_contribution = 0;
$total_Amout = 0;
// date modifier funcation
function date_edit_1($input_date){
    $temp_expire_date=$input_date;   //gate row date from date picker
    $t_1 = substr($temp_expire_date, 8, 2);    //days
    $t_2 = substr($temp_expire_date, 5, 2); //month
    $t_3 = substr($temp_expire_date, 0, 4); //year
    $temp_apply_date_arrange=$t_1."-".$t_2."-".$t_3;  //date arrange
    $get_apply_date= date("d-M-Y",strtotime($temp_apply_date_arrange));

    return($get_apply_date);
}

//table name creat function
function name_table($date_f_in, $date_t_in){
    $month_f = substr($date_f_in, 5, 2);
    $month_t = substr($date_t_in, 5, 2);
    $year_f = substr($date_f_in, 0 ,4);
    $year_t = substr($date_t_in, 0 ,4);
    $day_f = substr($date_f_in, 8, 2);
    $day_t = substr($date_t_in, 8, 2);

    if($month_f ==$month_t && $year_f==$year_t && $day_f<=$day_t){
        if($month_f<10 && $month_t<10){
            $month_f = substr($month_f,-1);
            $month_t = substr($month_t,-1);
        }

        $table_name = "canteenreport_".$month_f.'_'.$year_f;

        return($table_name);


    }else{
        $_SESSION['icon']='warning';
        $_SESSION['status'] = 'Data Not Found Between This Date Range';
        header("location:contribution_report");
        exit;
    }
}

//report table function
function table_data($data){
    include '../include/_dbconnect.php';

    $datatable= "<tr>
                    <th>Sl NO</th>
                    <th>User Code</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Item</th>
                    <th>Employee Contribution</th>
                    <th>Employer Contribution</th>
                    <th>Total Contribution</th>
                    
                </tr>";

        $setdata = "";
        $i=0;

while($rec = mysqli_fetch_assoc($data)){
    $i++;
    $item_code = $rec['Item_id'];
    $sql_item_data = mysqli_fetch_assoc(mysqli_query($conn,"select * from `canteen_item` where `itm_code` = '$item_code'"));
    if($sql_item_data!=""){
        $emp_contri = $sql_item_data['employee_contribution'];
        $emper_contri = $sql_item_data['employeer_contribution'];
    }else{
        $emp_contri = 0;
        $emper_contri = 0;
    }
    $total_contribution = ($emp_contri+$emper_contri);


$datatable.="<tr>
        <td>".$i."</td>
        <td>".$rec['UserId']."</td>
        <td>".$rec['LogDate']."</td>
        <td>".$rec['LogTime']."</td>
        <td>".$rec['Items']."</td>
        <td>".$emp_contri."</td>
        <td>".$emper_contri."</td>
        <td>".$total_contribution."</td>
    </tr>
    ";

}

 return($datatable);
}



// // Employee wise cnteen report xls

// if(isset($_POST['can_emp_r_xls'])){

//     $emp_input = $_POST['emp_w_input'];
//     $emp_id = substr($emp_input ,0, strpos($emp_input, ' '));
//     $today_date = date("Y-m-d");
    
//     $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$today_table_name'"));
//     if($sql_check_table >0){

//         if($emp_id!=""){
//             if($emp_id == 0){
//                 $sql_canteen_report = mysqli_query($conn,"select * from `$today_table_name` where `LogDate`='$today_date'");
//                 $emp_code = "All";     
//             }else{         
//                 $sql_emp_code = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where `EmployeeId`='$emp_id'"));
//                 if($sql_emp_code!=""){
//                     $emp_code = $sql_emp_code['Emp_code'];
//                     $sql_canteen_report = mysqli_query($conn,"select * from `$today_table_name` where `LogDate`='$today_date' and `UserId`='$emp_code'");  
//                 }
//             }
//             if($sql_canteen_report!=""){
    
//                 $datatable="<table border='1' style='text-align:center;'>
//                                 <tr>
//                                     <th colspan='8'>
//                                         User Code:- &nbsp; $emp_code
//                                     </th>
//                                 </tr>
//                                 <tr>
//                                     <td colspan='8'style='padding:.2rem;text-align:center;'> From Date :- &nbsp;".date_edit_1($today_date)." &nbsp;&nbsp;&nbsp;&nbsp; To Date :- &nbsp;".date_edit_1($today_date)."</td>
                                    
//                                 </tr>";
//                 $datatable.=table_data($sql_canteen_report);
//                 $datatable.="<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
//                 $datatable.="</table>";

//                 $datatable.="<table border='1' style=''>";
//                 $datatable.= "<tr>
//                                 <th>Item Name</th>
//                                 <th>Item Count</th>
//                                 <th>Employee Contribution</th>
//                                 <th>Employer Contribution</th>
//                                 <th>Total Contribution</th>
                                
//                             </tr>";


//                 $item_details = mysqli_query($conn,"select * from `canteen_item`");
//                 if($emp_id == 0){
//                     while($items_data = mysqli_fetch_assoc($item_details)){
//                         $item_id = $items_data['itm_code'];
//                         $item_name = $items_data['Item_name'];
//                         $emp_contribution = $items_data['employee_contribution'];
//                         $emper_contribution = $items_data['employeer_contribution'];

//                         $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$today_table_name` where `LogDate`='$today_date' and `Item_id`='$item_id'"));
                        
//                         // contribution calculation
//                         $total_emp_contribut = ($sql_report_data*$emp_contribution);
//                         $total_emper_contribut = ($sql_report_data*$emper_contribution);
//                         $total_contri = ($total_emp_contribut+$total_emper_contribut);

//                         $datatable.="<tr>
//                                         <td>$item_name</td>
//                                         <td>$sql_report_data</td>
//                                         <td>$total_emp_contribut</td>
//                                         <td>$total_emper_contribut</td>
//                                         <td>$total_contri</td>
//                                     </tr>";
//                         $total_item_count += $sql_report_data;
//                         $all_emp_contribution += $total_emp_contribut;
//                         $all_emper_contribution += $total_emper_contribut;
//                         $total_Amout += $total_contri;          
//                     }
                    
//                 }else{
//                     while($items_data = mysqli_fetch_assoc($item_details)){
//                         $item_id = $items_data['itm_code'];
//                         $item_name = $items_data['Item_name'];
//                         $emp_contribution = $items_data['employee_contribution'];
//                         $emper_contribution = $items_data['employeer_contribution'];

//                         $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$today_table_name` where `LogDate`='$today_date' and `Item_id`='$item_id'"));
                        
//                         // contribution calculation
//                         $total_emp_contribut = ($sql_report_data*$emp_contribution);
//                         $total_emper_contribut = ($sql_report_data*$emper_contribution);
//                         $total_contri = ($total_emp_contribut+$total_emper_contribut);

//                         $datatable.="<tr>
//                                         <td>$item_name</td>
//                                         <td>$sql_report_data</td>
//                                         <td>$total_emp_contribut</td>
//                                         <td>$total_emper_contribut</td>
//                                         <td>$total_contri</td>
//                                     </tr>";
//                         $total_item_count += $sql_report_data;
//                         $all_emp_contribution += $total_emp_contribut;
//                         $all_emper_contribution += $total_emper_contribut;
//                         $total_Amout += $total_contri;             
//                     }
//                 }
//                 $datatable.="<tr>
//                                 <th>Total</th>
//                                 <th>".$total_item_count."</th>
//                                 <th>".$all_emp_contribution."</th>
//                                 <th>".$all_emper_contribution."</th>
//                                 <th>".$total_Amout."</th>
//                             <tr>";
//                 $datatable.="</table>";


//                 $fname = "Employee_Contribution_report.xls";
//                 header('Content-Type:application/octet-stream');
//                 header('Content-Disposition:attachment; filename='.$fname);
    
//                 echo $datatable;
    
//                 $des="Contribution report download";
//                 $rem="canteen Report";
//                 include "../include/_audi_log.php";
    
//                 exit;
//             }else{
//                 $_SESSION['icon']='error';
//                 $_SESSION['status']='Data Not Found';
//                 header("location:contribution_report");
//             } 
    
//         }else{
//             $_SESSION['icon']='error';
//             $_SESSION['status']='Data Not Found';
//             header("location:contribution_report");
//         }
//     }else{
//         $_SESSION['icon']='error';
//         $_SESSION['status']='Please Process Report At Fast Data Not Found';
//         header("location:contribution_report");
//     }

// }
// // End Employee wise cnteen report xls

// // Employee wise cnteen report Pdf

// if(isset($_POST['can_emp_r_pdf'])){

//     $emp_input = $_POST['emp_w_input'];
//     $emp_id = substr($emp_input ,0, strpos($emp_input, ' '));
//     $today_date = date("Y-m-d");
    
//     $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$today_table_name'"));
//     if($sql_check_table >0){

//         if($emp_id!=""){
//             if($emp_id == 0){
//                 $sql_canteen_report = mysqli_query($conn,"select * from `$today_table_name` where `LogDate`='$today_date'");
//                 $emp_code = "All";     
//             }else{         
//                 $sql_emp_code = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where `EmployeeId`='$emp_id'"));
//                 if($sql_emp_code!=""){
//                     $emp_code = $sql_emp_code['Emp_code'];
//                     $sql_canteen_report = mysqli_query($conn,"select * from `$today_table_name` where `LogDate`='$today_date' and `UserId`='$emp_code'");  
//                 }
//             }
//             if($sql_canteen_report!=""){
    
//                 $datatable="<table border='1' style='text-align:center;'>
//                                 <tr>
//                                     <th colspan='8'>
//                                         User Code:- &nbsp; $emp_code
//                                     </th>
//                                 </tr>
//                                 <tr>
//                                     <td colspan='8'style='padding:.2rem;'> From Date :- &nbsp;".date_edit_1($today_date)." &nbsp;&nbsp;&nbsp;&nbsp; To Date :- &nbsp;".date_edit_1($today_date)."</td>
                                    
//                                 </tr>";
//                 $datatable.=table_data($sql_canteen_report);
//                 $datatable.="<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
//                 $datatable.="</table>";

//                 $datatable.="<table border='1' style='text-align:center;'>";
//                 $datatable.= "<tr>
//                                 <th>Item Name</th>
//                                 <th>Item Count</th>
//                                 <th>Employee Contribution</th>
//                                 <th>Employer Contribution</th>
//                                 <th>Total Contribution</th>
                                
//                             </tr>";


//                 $item_details = mysqli_query($conn,"select * from `canteen_item`");
//                 if($emp_id == 0){
//                     while($items_data = mysqli_fetch_assoc($item_details)){
//                         $item_id = $items_data['itm_code'];
//                         $item_name = $items_data['Item_name'];
//                         $emp_contribution = $items_data['employee_contribution'];
//                         $emper_contribution = $items_data['employeer_contribution'];

//                         $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$today_table_name` where `LogDate`='$today_date' and `Item_id`='$item_id'"));
                        
//                         // contribution calculation
//                         $total_emp_contribut = ($sql_report_data*$emp_contribution);
//                         $total_emper_contribut = ($sql_report_data*$emper_contribution);
//                         $total_contri = ($total_emp_contribut+$total_emper_contribut);

//                         $datatable.="<tr>
//                                         <td>$item_name</td>
//                                         <td>$sql_report_data</td>
//                                         <td>$total_emp_contribut</td>
//                                         <td>$total_emper_contribut</td>
//                                         <td>$total_contri</td>
//                                     </tr>";
//                         $total_item_count += $sql_report_data;
//                         $all_emp_contribution += $total_emp_contribut;
//                         $all_emper_contribution += $total_emper_contribut;
//                         $total_Amout += $total_contri;          
//                     }
                    
//                 }else{
//                     while($items_data = mysqli_fetch_assoc($item_details)){
//                         $item_id = $items_data['itm_code'];
//                         $item_name = $items_data['Item_name'];
//                         $emp_contribution = $items_data['employee_contribution'];
//                         $emper_contribution = $items_data['employeer_contribution'];

//                         $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$today_table_name` where `LogDate`='$today_date' and `Item_id`='$item_id'"));
                        
//                         // contribution calculation
//                         $total_emp_contribut = ($sql_report_data*$emp_contribution);
//                         $total_emper_contribut = ($sql_report_data*$emper_contribution);
//                         $total_contri = ($total_emp_contribut+$total_emper_contribut);

//                         $datatable.="<tr>
//                                         <td>$item_name</td>
//                                         <td>$sql_report_data</td>
//                                         <td>$total_emp_contribut</td>
//                                         <td>$total_emper_contribut</td>
//                                         <td>$total_contri</td>
//                                     </tr>";
//                         $total_item_count += $sql_report_data;
//                         $all_emp_contribution += $total_emp_contribut;
//                         $all_emper_contribution += $total_emper_contribut;
//                         $total_Amout += $total_contri;             
//                     }
//                 }
//                 $datatable.="<tr>
//                                 <th>Total</th>
//                                 <th>".$total_item_count."</th>
//                                 <th>".$all_emp_contribution."</th>
//                                 <th>".$all_emper_contribution."</th>
//                                 <th>".$total_Amout."</th>
//                             <tr>";
//                 $datatable.="</table>";
//                  echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
//                             <a href="contribution_report"><button class="btn-primary" >Back</button></a>';
//                 echo '<div class="print_container" style="">'.$datatable.'</div>';
    
//             }else{
//                 $_SESSION['icon']='error';
//                 $_SESSION['status']='Data Not Found';
//                 header("location:contribution_report");
//             } 
    
//         }else{
//             $_SESSION['icon']='error';
//             $_SESSION['status']='Data Not Found';
//             header("location:contribution_report");
//         }
//     }else{
//         $_SESSION['icon']='error';
//         $_SESSION['status']='Please Process Report At Fast Data Not Found';
//         header("location:contribution_report");
//     }

// }
// // End Employee wise cnteen report Pdf

// // Item wise cnteen report xls

// if(isset($_POST['items_r_xls'])){

//     $item_input = $_POST['item_w_input'];
    
//     $today_date = date("Y-m-d");


//     $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$today_table_name'"));
//     if($sql_check_table >0){
    
//         if($item_input!=""){
//             $sql_item_name = mysqli_fetch_assoc(mysqli_query($conn,"select * from `canteen_item` where `itm_code`='$item_input'"));
              
//             $sql_canteen_report = mysqli_query($conn,"select * from `$today_table_name` where `LogDate`='$today_date' and `Item_id`='$item_input'");
               
//             if($sql_canteen_report!=""){
    
//                 $datatable="<table border='1' style='text-align:center;'>
//                                 <tr>
//                                     <th colspan='8'>
//                                         Iteam :- &nbsp; ".strtoupper($sql_item_name['Item_name'])."
//                                     </th>
//                                 </tr>
//                                 <tr >
//                                     <td colspan='8'style='padding:.2rem;text-align:center;'> From Date :- &nbsp;".date_edit_1($today_date)." &nbsp;&nbsp;&nbsp;&nbsp; To Date :- &nbsp;".date_edit_1($today_date)."</td>
                                    
//                                 </tr>";
//                 $datatable.=table_data($sql_canteen_report);
//                 $datatable.="<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
//                 $datatable.="</table>";

//                 $datatable.="<table border='1' style='text-align:center;'>";
//                 $datatable.= "<tr>
//                                 <th>Item Name</th>
//                                 <th>Item Count</th>
//                                 <th>Employee Contribution</th>
//                                 <th>Employer Contribution</th>
//                                 <th>Total Contribution</th>
                                
//                             </tr>";


//                 $item_details = mysqli_query($conn,"select * from `canteen_item`");
                
//                     while($items_data = mysqli_fetch_assoc($item_details)){
//                         $item_id = $items_data['itm_code'];
//                         $item_name = $items_data['Item_name'];
//                         $emp_contribution = $items_data['employee_contribution'];
//                         $emper_contribution = $items_data['employeer_contribution'];
                        
//                         if($item_input == $item_id){
//                             $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$today_table_name` where `LogDate`='$today_date' and `Item_id`='$item_id'"));

//                         }else{
//                             $sql_report_data=0;
//                         }
                        
//                         // contribution calculation
//                         $total_emp_contribut = ($sql_report_data*$emp_contribution);
//                         $total_emper_contribut = ($sql_report_data*$emper_contribution);
//                         $total_contri = ($total_emp_contribut+$total_emper_contribut);

//                         $datatable.="<tr>
//                                         <td>$item_name</td>
//                                         <td>$sql_report_data</td>
//                                         <td>$total_emp_contribut</td>
//                                         <td>$total_emper_contribut</td>
//                                         <td>$total_contri</td>
//                                     </tr>";
//                         $total_item_count += $sql_report_data;
//                         $all_emp_contribution += $total_emp_contribut;
//                         $all_emper_contribution += $total_emper_contribut;
//                         $total_Amout += $total_contri;          
//                     }
//                 $datatable.="<tr>
//                                 <th>Total</th>
//                                 <th>".$total_item_count."</th>
//                                 <th>".$all_emp_contribution."</th>
//                                 <th>".$all_emper_contribution."</th>
//                                 <th>".$total_Amout."</th>
//                             <tr>";
//                 $datatable.="</table>";

//                 $fname = "Item_Contribution_report.xls";
//                 header('Content-Type:application/octet-stream');
//                 header('Content-Disposition:attachment; filename='.$fname);
    
//                 echo $datatable;
    
//                 $des="Contribution report download";
//                 $rem="canteen Report";
//                 include "../include/_audi_log.php";
    
//                 exit;
    
//             }else{
//                 $_SESSION['icon']='error';
//                 $_SESSION['status']='Data Not Found';
//                 header("location:contribution_report");
//             } 
    
//         }else{
//             $_SESSION['icon']='error';
//             $_SESSION['status']='Data Not Found';
//             header("location:contribution_report");
//         }
//     }else{
//         $_SESSION['icon']='error';
//         $_SESSION['status']='Please Process Report At Fast Data Not Found';
//         header("location:contribution_report");
//     }

// }
// // End Item wise cnteen report xls


// // Item wise cnteen report Pdf

// if(isset($_POST['items_r_pdf'])){

//     $item_input = $_POST['item_w_input'];
    
//     $today_date = date("Y-m-d");


//     $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$today_table_name'"));
//     if($sql_check_table >0){
    
//         if($item_input!=""){
//             $sql_item_name = mysqli_fetch_assoc(mysqli_query($conn,"select * from `canteen_item` where `itm_code`='$item_input'"));
              
//             $sql_canteen_report = mysqli_query($conn,"select * from `$today_table_name` where `LogDate`='$today_date' and `Item_id`='$item_input'");
               
//             if($sql_canteen_report!=""){
    
//                 $datatable="<table border='1' style='text-align:center;'>
//                                 <tr>
//                                     <th colspan='8'>
//                                         Iteam :- &nbsp; ".strtoupper($sql_item_name['Item_name'])."
//                                     </th>
//                                 </tr>
//                                 <tr>
//                                     <td colspan='8'style='padding:.2rem;text-align:center;'> From Date :- &nbsp;".date_edit_1($today_date)." &nbsp;&nbsp;&nbsp;&nbsp; To Date :- &nbsp;".date_edit_1($today_date)."</td>
                                    
//                                 </tr>";
//                 $datatable.=table_data($sql_canteen_report);
//                 $datatable.="<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
//                 $datatable.="</table>";

//                 $datatable.="<table border='1' style='text-align:center;'>";
//                 $datatable.= "<tr>
//                                 <th>Item Name</th>
//                                 <th>Item Count</th>
//                                 <th>Employee Contribution</th>
//                                 <th>Employer Contribution</th>
//                                 <th>Total Contribution</th>
                                
//                             </tr>";


//                 $item_details = mysqli_query($conn,"select * from `canteen_item`");
                
//                     while($items_data = mysqli_fetch_assoc($item_details)){
//                         $item_id = $items_data['itm_code'];
//                         $item_name = $items_data['Item_name'];
//                         $emp_contribution = $items_data['employee_contribution'];
//                         $emper_contribution = $items_data['employeer_contribution'];
                        
//                         if($item_input == $item_id){
//                             $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$today_table_name` where `LogDate`='$today_date' and `Item_id`='$item_id'"));

//                         }else{
//                             $sql_report_data=0;
//                         }
                        
//                         // contribution calculation
//                         $total_emp_contribut = ($sql_report_data*$emp_contribution);
//                         $total_emper_contribut = ($sql_report_data*$emper_contribution);
//                         $total_contri = ($total_emp_contribut+$total_emper_contribut);

//                         $datatable.="<tr>
//                                         <td>$item_name</td>
//                                         <td>$sql_report_data</td>
//                                         <td>$total_emp_contribut</td>
//                                         <td>$total_emper_contribut</td>
//                                         <td>$total_contri</td>
//                                     </tr>";
//                         $total_item_count += $sql_report_data;
//                         $all_emp_contribution += $total_emp_contribut;
//                         $all_emper_contribution += $total_emper_contribut;
//                         $total_Amout += $total_contri;          
//                     }
//                 $datatable.="<tr>
//                                 <th>Total</th>
//                                 <th>".$total_item_count."</th>
//                                 <th>".$all_emp_contribution."</th>
//                                 <th>".$all_emper_contribution."</th>
//                                 <th>".$total_Amout."</th>
//                             <tr>";
//                 $datatable.="</table>";
//                  echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
//                             <a href="contribution_report"><button class="btn-primary" >Back</button></a>';
//                 echo '<div class="print_container" style="">'.$datatable.'</div>';
    
//             }else{
//                 $_SESSION['icon']='error';
//                 $_SESSION['status']='Data Not Found';
//                 header("location:contribution_report");
//             } 
    
//         }else{
//             $_SESSION['icon']='error';
//             $_SESSION['status']='Data Not Found';
//             header("location:contribution_report");
//         }
//     }else{
//         $_SESSION['icon']='error';
//         $_SESSION['status']='Please Process Report At Fast Data Not Found';
//         header("location:contribution_report");
//     }

// }
// // End Item wise cnteen report Pdf


// // Employee & DateRange wise cnteen report xls

// if(isset($_POST['emp_D_r_xls'])){
//     $emp_in = $_POST['emp_w_input'];
//     $date_f_in = $_POST['date_f_input'];
//     $date_t_in = $_POST['date_t_input'];
//     $emp_in = substr($emp_in ,0, strpos($emp_in, ' '));
    


//     if($emp_in!="" && $date_f_in!="" && $date_t_in!=""){
//         if($date_f_in<=$date_t_in){

//             $table_name = name_table($date_f_in,$date_t_in);
//             $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
//             if($sql_check_table >0){
//                 if($emp_in == 0){
//                     $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `LogDate` between '$date_f_in' and '$date_t_in'");
//                     $emp_code = "All";  
//                 }else{  
//                     $sql_emp_code = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where `EmployeeId`='$emp_in'"));
//                     if($sql_emp_code!=""){
//                         $emp_code = $sql_emp_code['Emp_code'];
//                         $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `UserId`='$emp_code' and `LogDate` between '$date_f_in' and '$date_t_in'");
//                     }
//                 }
//                 if($sql_canteen_report!=""){
//                     $datatable="<table border='1' style='text-align:center;'>
//                                    <tr>
//                                         <th colspan='8'>
//                                             Employee Code :- &nbsp; ".strtoupper($emp_code)."
//                                         </th>
//                                    </tr>
//                                     <tr>
//                                         <td colspan='8'style='padding:.2rem;text-align:center;'> From Date :- &nbsp;".date_edit_1($date_f_in)." &nbsp;&nbsp;&nbsp;&nbsp; To Date :- &nbsp;".date_edit_1($date_t_in)."</td>
                                        
//                                     </tr>";
//                     $datatable.=table_data($sql_canteen_report);
//                     $datatable.="<tr><td></td><td></td></td><td></td></td><td></td></td><td></td><td></td><td></td><td></td></tr>";
//                     $datatable.="</table>";

//                     $datatable.="<table border='1' style='text-align:center;'>";
//                     $datatable.= "<tr>
//                                     <th>Item Name</th>
//                                     <th>Item Count</th>
//                                     <th>Employee Contribution</th>
//                                     <th>Employer Contribution</th>
//                                     <th>Total Contribution</th>
                                    
//                                 </tr>";
                   
//                     $item_details = mysqli_query($conn,"select * from `canteen_item`");
                       
                        
//                     if($emp_in == 0){
//                         while($items_data = mysqli_fetch_assoc($item_details)){
//                             $item_id = $items_data['itm_code'];
//                             $item_name = $items_data['Item_name'];
//                             $emp_contribution = $items_data['employee_contribution'];
//                             $emper_contribution = $items_data['employeer_contribution'];
//                             $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_id' and `LogDate` between'$date_f_in'and'$date_t_in'"));
                            
//                             // contribution calculation
//                             $total_emp_contribut = ($sql_report_data*$emp_contribution);
//                             $total_emper_contribut = ($sql_report_data*$emper_contribution);
//                             $total_contri = ($total_emp_contribut+$total_emper_contribut);

//                             $datatable.="<tr>
//                                             <td>$item_name</td>
//                                             <td>$sql_report_data</td>
//                                             <td>$total_emp_contribut</td>
//                                             <td>$total_emper_contribut</td>
//                                             <td>$total_contri</td>
//                                         </tr>";
//                             $total_item_count += $sql_report_data;
//                             $all_emp_contribution += $total_emp_contribut;
//                             $all_emper_contribution += $total_emper_contribut;
//                             $total_Amout += $total_contri;          
//                         }
                
                        
        
//                     }else{
//                         while($items_data = mysqli_fetch_assoc($item_details)){
//                             $item_id = $items_data['itm_code'];
//                             $item_name = $items_data['Item_name'];
//                             $emp_contribution = $items_data['employee_contribution'];
//                             $emper_contribution = $items_data['employeer_contribution'];
//                             $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `UserId`='$emp_code' and `Item_id`='$item_id' and `LogDate` between'$date_f_in'and'$date_t_in'"));
            
//                             // contribution calculation
//                             $total_emp_contribut = ($sql_report_data*$emp_contribution);
//                             $total_emper_contribut = ($sql_report_data*$emper_contribution);
//                             $total_contri = ($total_emp_contribut+$total_emper_contribut);

//                             $datatable.="<tr>
//                                             <td>$item_name</td>
//                                             <td>$sql_report_data</td>
//                                             <td>$total_emp_contribut</td>
//                                             <td>$total_emper_contribut</td>
//                                             <td>$total_contri</td>
//                                         </tr>";
//                             $total_item_count += $sql_report_data;
//                             $all_emp_contribution += $total_emp_contribut;
//                             $all_emper_contribution += $total_emper_contribut;
//                             $total_Amout += $total_contri;   
//                         }
//                     }
//                     $datatable.="<tr>
//                                     <th style='text-align:left'>Total</th>
//                                     <th style='text-align:right'>".$total_item_count."</th>
//                                     <th style='text-align:right'>".$all_emp_contribution."</th>
//                                     <th style='text-align:right'>".$all_emper_contribution."</th>
//                                     <th style='text-align:right'>".$total_Amout."</th>
//                                 <tr>";
//                     $datatable.="</table>";

//                     $fname = "Date_Range_Contribution_report.xls";
//                     header('Content-Type:application/octet-stream');
//                     header('Content-Disposition:attachment; filename='.$fname);
        
//                     echo $datatable;
        
//                     $des="Contribution report download";
//                     $rem="canteen Report";
//                     include "../include/_audi_log.php";
        
//                     exit;
//                 }else{
                   
//                     $_SESSION['icon']='error';
//                     $_SESSION['status']='Data Not Found';
//                     header("location:contribution_report");
//                 }
    
//             }else{
//                 $_SESSION['icon'] = 'error';
//                 $_SESSION['status'] ='Please Process Report At Fast Data Not Found';
//                 header("location:contribution_report");
//             }

//         }else{
//             $_SESSION['icon']='warning';
//             $_SESSION['status'] = 'Data Not Found Between This Date Range';
//             header("location:contribution_report");
//         }
//     }else{
//         $_SESSION['icon'] = 'error';
//         $_SESSION['status'] = 'Data Not Found ';
//         header("location:contribution_report");
//     }

// }



// // End Employee & DateRange wise cnteen report xls


// // Employee & DateRange wise cnteen report Pdf

// if(isset($_POST['emp_D_r_pdf'])){
//     $emp_in = $_POST['emp_w_input'];
//     $date_f_in = $_POST['date_f_input'];
//     $date_t_in = $_POST['date_t_input'];
//     $emp_in = substr($emp_in ,0, strpos($emp_in, ' '));
    


//     if($emp_in!="" && $date_f_in!="" && $date_t_in!=""){
//         if($date_f_in<=$date_t_in){

//             $table_name = name_table($date_f_in,$date_t_in);
//             $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
//             if($sql_check_table >0){
//                 if($emp_in == 0){
//                     $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `LogDate` between '$date_f_in' and '$date_t_in'");
//                     $emp_code = "All";  
//                 }else{  
//                     $sql_emp_code = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where `EmployeeId`='$emp_in'"));
//                     if($sql_emp_code!=""){
//                         $emp_code = $sql_emp_code['Emp_code'];
//                         $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `UserId`='$emp_code' and `LogDate` between '$date_f_in' and '$date_t_in'");
//                     }
//                 }
//                 if($sql_canteen_report!=""){
//                     $datatable="<table border='1' style='text-align:center;'>
//                                    <tr>
//                                         <th colspan='8'>
//                                             Employee Code :- &nbsp; ".strtoupper($emp_code)."
//                                         </th>
//                                    </tr>
//                                     <tr>
//                                         <td colspan='8'style='padding:.2rem;text-align:center;'> From Date :- &nbsp;".date_edit_1($date_f_in)." &nbsp;&nbsp;&nbsp;&nbsp; To Date :- &nbsp;".date_edit_1($date_t_in)."</td>
                                        
//                                     </tr>";
//                     $datatable.=table_data($sql_canteen_report);
//                     $datatable.="<tr><td></td><td></td></td><td></td></td><td></td></td><td></td><td></td><td></td><td></td></tr>";
//                     $datatable.="</table>";

//                     $datatable.="<table border='1' style='text-align:center;'>";
//                     $datatable.= "<tr>
//                                     <th>Item Name</th>
//                                     <th>Item Count</th>
//                                     <th>Employee Contribution</th>
//                                     <th>Employer Contribution</th>
//                                     <th>Total Contribution</th>
                                    
//                                 </tr>";
                   
//                     $item_details = mysqli_query($conn,"select * from `canteen_item`");
                       
                        
//                     if($emp_in == 0){
//                         while($items_data = mysqli_fetch_assoc($item_details)){
//                             $item_id = $items_data['itm_code'];
//                             $item_name = $items_data['Item_name'];
//                             $emp_contribution = $items_data['employee_contribution'];
//                             $emper_contribution = $items_data['employeer_contribution'];
//                             $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_id' and `LogDate` between'$date_f_in'and'$date_t_in'"));
                            
//                             // contribution calculation
//                             $total_emp_contribut = ($sql_report_data*$emp_contribution);
//                             $total_emper_contribut = ($sql_report_data*$emper_contribution);
//                             $total_contri = ($total_emp_contribut+$total_emper_contribut);

//                             $datatable.="<tr>
//                                             <td>$item_name</td>
//                                             <td>$sql_report_data</td>
//                                             <td>$total_emp_contribut</td>
//                                             <td>$total_emper_contribut</td>
//                                             <td>$total_contri</td>
//                                         </tr>";
//                             $total_item_count += $sql_report_data;
//                             $all_emp_contribution += $total_emp_contribut;
//                             $all_emper_contribution += $total_emper_contribut;
//                             $total_Amout += $total_contri;          
//                         }
                
                        
        
//                     }else{
//                         while($items_data = mysqli_fetch_assoc($item_details)){
//                             $item_id = $items_data['itm_code'];
//                             $item_name = $items_data['Item_name'];
//                             $emp_contribution = $items_data['employee_contribution'];
//                             $emper_contribution = $items_data['employeer_contribution'];
//                             $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `UserId`='$emp_code' and `Item_id`='$item_id' and `LogDate` between'$date_f_in'and'$date_t_in'"));
            
//                             // contribution calculation
//                             $total_emp_contribut = ($sql_report_data*$emp_contribution);
//                             $total_emper_contribut = ($sql_report_data*$emper_contribution);
//                             $total_contri = ($total_emp_contribut+$total_emper_contribut);

//                             $datatable.="<tr>
//                                             <td>$item_name</td>
//                                             <td>$sql_report_data</td>
//                                             <td>$total_emp_contribut</td>
//                                             <td>$total_emper_contribut</td>
//                                             <td>$total_contri</td>
//                                         </tr>";
//                             $total_item_count += $sql_report_data;
//                             $all_emp_contribution += $total_emp_contribut;
//                             $all_emper_contribution += $total_emper_contribut;
//                             $total_Amout += $total_contri;   
//                         }
//                     }
//                     $datatable.="<tr>
//                                     <th>Total</th>
//                                     <th>".$total_item_count."</th>
//                                     <th>".$all_emp_contribution."</th>
//                                     <th>".$all_emper_contribution."</th>
//                                     <th>".$total_Amout."</th>
//                                 <tr>";
//                     $datatable.="</table>";
                    
//                             echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
//                                     <a href="contribution_report"><button class="btn-primary" >Back</button></a>';
//                             echo '<div class="print_container" style="">'.$datatable.'</div>';
//                 }else{
                   
//                     $_SESSION['icon']='error';
//                     $_SESSION['status']='Data Not Found';
//                     header("location:contribution_report");
//                 }
    
//             }else{
//                 $_SESSION['icon'] = 'error';
//                 $_SESSION['status'] ='Please Process Report At Fast Data Not Found';
//                 header("location:contribution_report");
//             }

//         }else{
//             $_SESSION['icon']='warning';
//             $_SESSION['status'] = 'Data Not Found Between This Date Range';
//             header("location:contribution_report");
//         }
//     }else{
//         $_SESSION['icon'] = 'error';
//         $_SESSION['status'] = 'Data Not Found ';
//         header("location:contribution_report");
//     }

// }



// // End Employee & DateRange wise cnteen report Pdf


// // Employee & Month wise cnteen report xls

// if(isset($_POST['emp_m_r_xls'])){
//     $emp_in = $_POST['emp_w_input'];
//     $Month_in = $_POST['month_report'];
//     $Year_in = $_POST['year_report'];
//     $emp_in = substr($emp_in ,0, strpos($emp_in, ' '));
//     $month= date("M",mktime(0, 0, 0, $Month_in, 10));
    

//     if($emp_in!="" && $Month_in!="" && $Year_in!=""){
//         $table_name = "canteenreport_".$Month_in.'_'.$Year_in;
//         $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
//         if($sql_check_table >0){
//             if($emp_in == 0){
//                 $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `LogMonth`= '$month' and `LogYear`='$Year_in'");
//                 $emp_code = "All";  
//             }else{  
//                 $sql_emp_code = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where `EmployeeId`='$emp_in'"));
//                 if($sql_emp_code!=""){
//                     $emp_code = $sql_emp_code['Emp_code'];
//                     $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `UserId`='$emp_code' and `LogMonth`= '$month' and `LogYear`='$Year_in'");
//                 }
//             }
//                 if($sql_canteen_report!=""){
//                     $datatable="<table border='1' style='text-align:center;'>
//                                    <tr>
//                                         <th colspan='8'>
//                                             Employee Code :- &nbsp; ".strtoupper($emp_code)."
//                                         </th>
//                                    </tr>
//                                     <tr>
//                                         <td colspan='8'style='padding:.2rem;text-align:center;'> Month :- &nbsp;".ucfirst(date("F",mktime(0, 0, 0, $Month_in, 10)))." &nbsp ".$Year_in."</td>
                                        
//                                     </tr>";
//                     $datatable.=table_data($sql_canteen_report);
//                     $datatable.="<tr><td></td><td></td></td><td></td></td><td></td></td><td></td><td></td><td></td><td></td></tr>";
//                     $datatable.="</table>";

//                     $datatable.="<table border='1' style='text-align:center;'>";
//                     $datatable.= "<tr>
//                                     <th>Item Name</th>
//                                     <th>Item Count</th>
//                                     <th>Employee Contribution</th>
//                                     <th>Employer Contribution</th>
//                                     <th>Total Contribution</th>
                                    
//                                 </tr>";
                   
//                     $item_details = mysqli_query($conn,"select * from `canteen_item`");
                       
                        
//                     if($emp_in == 0){
//                         while($items_data = mysqli_fetch_assoc($item_details)){
//                             $item_id = $items_data['itm_code'];
//                             $item_name = $items_data['Item_name'];
//                             $emp_contribution = $items_data['employee_contribution'];
//                             $emper_contribution = $items_data['employeer_contribution'];
//                             $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_id' and `LogMonth`= '$month' and `LogYear`='$Year_in'"));
                            
//                             // contribution calculation
//                             $total_emp_contribut = ($sql_report_data*$emp_contribution);
//                             $total_emper_contribut = ($sql_report_data*$emper_contribution);
//                             $total_contri = ($total_emp_contribut+$total_emper_contribut);

//                             $datatable.="<tr>
//                                             <td>$item_name</td>
//                                             <td>$sql_report_data</td>
//                                             <td>$total_emp_contribut</td>
//                                             <td>$total_emper_contribut</td>
//                                             <td>$total_contri</td>
//                                         </tr>";
//                             $total_item_count += $sql_report_data;
//                             $all_emp_contribution += $total_emp_contribut;
//                             $all_emper_contribution += $total_emper_contribut;
//                             $total_Amout += $total_contri;          
//                         }
                
                        
        
//                     }else{
//                         while($items_data = mysqli_fetch_assoc($item_details)){
//                             $item_id = $items_data['itm_code'];
//                             $item_name = $items_data['Item_name'];
//                             $emp_contribution = $items_data['employee_contribution'];
//                             $emper_contribution = $items_data['employeer_contribution'];
//                             $sql_report_data  =  mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `UserId`='$emp_code' and `Item_id`='$item_id' and `LogMonth`= '$month' and `LogYear`='$Year_in'"));
            
//                             // contribution calculation
//                             $total_emp_contribut = ($sql_report_data*$emp_contribution);
//                             $total_emper_contribut = ($sql_report_data*$emper_contribution);
//                             $total_contri = ($total_emp_contribut+$total_emper_contribut);

//                             $datatable.="<tr>
//                                             <td>$item_name</td>
//                                             <td>$sql_report_data</td>
//                                             <td>$total_emp_contribut</td>
//                                             <td>$total_emper_contribut</td>
//                                             <td>$total_contri</td>
//                                         </tr>";
//                             $total_item_count += $sql_report_data;
//                             $all_emp_contribution += $total_emp_contribut;
//                             $all_emper_contribution += $total_emper_contribut;
//                             $total_Amout += $total_contri;   
//                         }
//                     }
//                     $datatable.="<tr>
//                                     <th style='text-align:left;'>Total</th>
//                                     <th style='text-align:right;'>".$total_item_count."</th>
//                                     <th style='text-align:right;'>".$all_emp_contribution."</th>
//                                     <th style='text-align:right;'>".$all_emper_contribution."</th>
//                                     <th style='text-align:right;'>".$total_Amout."</th>
//                                 <tr>";
//                     $datatable.="</table>";
                    
//                     $fname = $month."_".$Year_in."_Contribution_report.xls";
//                     header('Content-Type:application/octet-stream');
//                     header('Content-Disposition:attachment; filename='.$fname);
        
//                     echo $datatable;
        
//                     $des="Contribution report download";
//                     $rem="canteen Report";
//                     include "../include/_audi_log.php";
        
//                     exit;
//                 }else{
                   
//                     $_SESSION['icon']='error';
//                     $_SESSION['status']='Data Not Found';
//                     header("location:contribution_report");
//                 }
    
//             }else{
//                 $_SESSION['icon'] = 'error';
//                 $_SESSION['status'] ='Please Process Report At Fast Data Not Found';
//                 header("location:contribution_report");
//             }

       
//     }else{
//         $_SESSION['icon'] = 'error';
//         $_SESSION['status'] = 'Data Not Found ';
//         header("location:contribution_report");
//     }

// }



// // End Employee & Month wise cnteen report xls
// // Employee & Month wise cnteen report Pdf

// if(isset($_POST['emp_m_r_pdf'])){
//     $emp_in = $_POST['emp_w_input'];
//     $Month_in = $_POST['month_report'];
//     $Year_in = $_POST['year_report'];
//     $emp_in = substr($emp_in ,0, strpos($emp_in, ' '));
//     $month= date("M",mktime(0, 0, 0, $Month_in, 10));
    

//     if($emp_in!="" && $Month_in!="" && $Year_in!=""){
//         $table_name = "canteenreport_".$Month_in.'_'.$Year_in;
//         $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
//         if($sql_check_table >0){
//             if($emp_in == 0){
//                 $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `LogMonth`= '$month' and `LogYear`='$Year_in'");
//                 $emp_code = "All";  
//             }else{  
//                 $sql_emp_code = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where `EmployeeId`='$emp_in'"));
//                 if($sql_emp_code!=""){
//                     $emp_code = $sql_emp_code['Emp_code'];
//                     $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `UserId`='$emp_code' and `LogMonth`= '$month' and `LogYear`='$Year_in'");
//                 }
//             }
//                 if($sql_canteen_report!=""){
//                     $datatable="<table border='1' style='text-align:center;'>
//                                    <tr>
//                                         <th colspan='8'>
//                                             Employee Code :- &nbsp; ".strtoupper($emp_code)."
//                                         </th>
//                                    </tr>
//                                     <tr>
//                                         <td colspan='8'style='padding:.2rem;text-align:center;'> Month :- &nbsp;".ucfirst(date("F",mktime(0, 0, 0, $Month_in, 10)))." &nbsp ".$Year_in."</td>
                                        
//                                     </tr>";
//                     $datatable.=table_data($sql_canteen_report);
//                     $datatable.="<tr><td></td><td></td><td></td><td></td></td><td></td></td><td></td></td><td></td><td></td></tr>";
//                     $datatable.="</table>";

//                     $datatable.="<table border='1' style='text-align:center;'>";
//                     $datatable.= "<tr>
//                                     <th>Item Name</th>
//                                     <th>Item Count</th>
//                                     <th>Employee Contribution</th>
//                                     <th>Employer Contribution</th>
//                                     <th>Total Contribution</th>
                                    
//                                 </tr>";
                   
//                     $item_details = mysqli_query($conn,"select * from `canteen_item`");
                       
                        
//                     if($emp_in == 0){
//                         while($items_data = mysqli_fetch_assoc($item_details)){
//                             $item_id = $items_data['itm_code'];
//                             $item_name = $items_data['Item_name'];
//                             $emp_contribution = $items_data['employee_contribution'];
//                             $emper_contribution = $items_data['employeer_contribution'];
//                             $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_id' and `LogMonth`= '$month' and `LogYear`='$Year_in'"));
                            
//                             // contribution calculation
//                             $total_emp_contribut = ($sql_report_data*$emp_contribution);
//                             $total_emper_contribut = ($sql_report_data*$emper_contribution);
//                             $total_contri = ($total_emp_contribut+$total_emper_contribut);

//                             $datatable.="<tr>
//                                             <td>$item_name</td>
//                                             <td>$sql_report_data</td>
//                                             <td>$total_emp_contribut</td>
//                                             <td>$total_emper_contribut</td>
//                                             <td>$total_contri</td>
//                                         </tr>";
//                             $total_item_count += $sql_report_data;
//                             $all_emp_contribution += $total_emp_contribut;
//                             $all_emper_contribution += $total_emper_contribut;
//                             $total_Amout += $total_contri;          
//                         }
                
                        
        
//                     }else{
//                         while($items_data = mysqli_fetch_assoc($item_details)){
//                             $item_id = $items_data['itm_code'];
//                             $item_name = $items_data['Item_name'];
//                             $emp_contribution = $items_data['employee_contribution'];
//                             $emper_contribution = $items_data['employeer_contribution'];
//                             $sql_report_data  =  mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `UserId`='$emp_code' and `Item_id`='$item_id' and `LogMonth`= '$month' and `LogYear`='$Year_in'"));
            
//                             // contribution calculation
//                             $total_emp_contribut = ($sql_report_data*$emp_contribution);
//                             $total_emper_contribut = ($sql_report_data*$emper_contribution);
//                             $total_contri = ($total_emp_contribut+$total_emper_contribut);

//                             $datatable.="<tr>
//                                             <td>$item_name</td>
//                                             <td>$sql_report_data</td>
//                                             <td>$total_emp_contribut</td>
//                                             <td>$total_emper_contribut</td>
//                                             <td>$total_contri</td>
//                                         </tr>";
//                             $total_item_count += $sql_report_data;
//                             $all_emp_contribution += $total_emp_contribut;
//                             $all_emper_contribution += $total_emper_contribut;
//                             $total_Amout += $total_contri;   
//                         }
//                     }
//                     $datatable.="<tr>
//                                     <th>Total</th>
//                                     <th>".$total_item_count."</th>
//                                     <th>".$all_emp_contribution."</th>
//                                     <th>".$all_emper_contribution."</th>
//                                     <th>".$total_Amout."</th>
//                                 <tr>";
//                     $datatable.="</table>";
                    
//                             echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
//                                     <a href="contribution_report"><button class="btn-primary" >Back</button></a>';
//                             echo '<div class="print_container" style="">'.$datatable.'</div>';
//                 }else{
                   
//                     $_SESSION['icon']='error';
//                     $_SESSION['status']='Data Not Found';
//                     header("location:contribution_report");
//                 }
    
//             }else{
//                 $_SESSION['icon'] = 'error';
//                 $_SESSION['status'] ='Please Process Report At Fast Data Not Found';
//                 header("location:contribution_report");
//             }

       
//     }else{
//         $_SESSION['icon'] = 'error';
//         $_SESSION['status'] = 'Data Not Found ';
//         header("location:contribution_report");
//     }

// }



// End Employee & Month wise cnteen report Pdf


// Item & date range wise cnteen report xls

if(isset($_POST['Item_D_r_xls'])){
    $item_in = $_POST['item_report'];
    $date_f_in = $_POST['date_F_report'];
    $date_t_in = $_POST['date_T_report'];
    
    
    $usre_id = $emp_code;
    
    


    if($item_in!="" && $date_f_in!="" && $date_t_in!=""){
        if($date_f_in<=$date_t_in){

            $table_name = name_table($date_f_in,$date_t_in);
            $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
            if($sql_check_table >0){
                $sql_item_name = mysqli_fetch_assoc(mysqli_query($conn,"select * from `canteen_item` where `itm_code`='$item_in'"));
                    $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_in' and `UserId`='$emp_code'and`LogDate` between '$date_f_in' and '$date_t_in'");
                    
               
                if($sql_canteen_report!=""){
                    $datatable="<table border='1' style='text-align:center;'>
                                    <tr>
                                        <th colspan='8'>
                                            Iteam :- &nbsp; ".strtoupper($sql_item_name['Item_name'])."
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan='8'style='padding:.2rem;text-align:center;'> From Date :- &nbsp;".date_edit_1($date_f_in)." &nbsp;&nbsp;&nbsp;&nbsp; To Date :- &nbsp;".date_edit_1($date_t_in)."</td>
                                        
                                    </tr>";
                    $datatable.=table_data($sql_canteen_report);
                    $datatable.="<tr><td></td><td></td><td></td><td></td></td><td></td><td></td><td></td><td></td></tr>";
                    $datatable.="</table>";

                    $datatable.="<table border='1' >";
                    $datatable.= "<tr>
                                    <th>Item Name</th>
                                    <th>Item Count</th>
                                    <th>Employee Contribution</th>
                                    <th>Employer Contribution</th>
                                    <th>Total Contribution</th>
                                    
                                </tr>";
                   
                    $item_details = mysqli_query($conn,"select * from `canteen_item`");
                       
                        
                    while($items_data = mysqli_fetch_assoc($item_details)){
                        $item_id = $items_data['itm_code'];
                        $item_name = $items_data['Item_name'];
                        $emp_contribution = $items_data['employee_contribution'];
                        $emper_contribution = $items_data['employeer_contribution'];
                        if($item_in ==  $item_id){
                            $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_id' and `UserId`='$emp_code'and `LogDate` between'$date_f_in'and'$date_t_in'"));

                        }else{
                            $sql_report_data  =0;
                        }
                        // contribution calculation
                        $total_emp_contribut = ($sql_report_data*$emp_contribution);
                        $total_emper_contribut = ($sql_report_data*$emper_contribution);
                        $total_contri = ($total_emp_contribut+$total_emper_contribut);

                        $datatable.="<tr>
                                        <td style='text-align:left;'>$item_name</td>
                                        <td style='text-align:right;'>$sql_report_data</td>
                                        <td style='text-align:right;'>$total_emp_contribut</td>
                                        <td style='text-align:right;'>$total_emper_contribut</td>
                                        <td style='text-align:right;'>$total_contri</td>
                                    </tr>";
                        $total_item_count += $sql_report_data;
                        $all_emp_contribution += $total_emp_contribut;
                        $all_emper_contribution += $total_emper_contribut;
                        $total_Amout += $total_contri; 
                    }
                    $datatable.="<tr>
                                    <th>Total</th>
                                    <th>".$total_item_count."</th>
                                    <th>".$all_emp_contribution."</th>
                                    <th>".$all_emper_contribution."</th>
                                    <th>".$total_Amout."</th>
                                <tr>";
                    
                    $datatable.="</table>";
                    $fname = "Item_wise_canteen_report.xls";
                    header('Content-Type:application/octet-stream');
                    header('Content-Disposition:attachment; filename='.$fname);
        
                    echo $datatable;
        
                    $des="canteen report download";
                    $rem="canteen Report";
                    include "../include/_audi_log.php";
        
                    exit;
                }else{
                   
                    $_SESSION['icon']='error';
                    $_SESSION['status']='Data Not Found2';
                    header("location:contribution_report");
                }
    
            }else{
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] ='Please Process Report At Fast Data Not Found';
                header("location:contribution_report");
            }

        }else{
            $_SESSION['icon']='warning';
            $_SESSION['status'] = 'Date Range Should Be Within One Month';
            header("location:contribution_report");
        }
    }else{
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Data Not Found1 ';
        header("location:contribution_report");
    }

}
// End Item & date range  wise cnteen report xls

// Item & date range wise cnteen report Pdf

if(isset($_POST['Item_D_r_pdf'])){
    $item_in = $_POST['item_report'];
    $date_f_in = $_POST['date_F_report'];
    $date_t_in = $_POST['date_T_report'];
    $usre_id = $emp_code;
    


    if($item_in!="" && $date_f_in!="" && $date_t_in!=""){
        if($date_f_in<=$date_t_in){

            $table_name = name_table($date_f_in,$date_t_in);
            $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
            if($sql_check_table >0){
                $sql_item_name = mysqli_fetch_assoc(mysqli_query($conn,"select * from `canteen_item` where `itm_code`='$item_in'"));
                    $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_in' and `UserId`='$emp_code'and `LogDate` between '$date_f_in' and '$date_t_in'");
                    
               
                if($sql_canteen_report!=""){
                    $datatable="<table border='1' style='text-align:center;'>
                                    <tr>
                                        <th colspan='8'>
                                            Iteam :- &nbsp; ".strtoupper($sql_item_name['Item_name'])."
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan='8'style='padding:.2rem;'> From Date :- &nbsp;".date_edit_1($date_f_in)." &nbsp;&nbsp;&nbsp;&nbsp; To Date :- &nbsp;".date_edit_1($date_t_in)."</td>
                                        
                                    </tr>";
                    $datatable.=table_data($sql_canteen_report);
                    $datatable.="<tr><td></td><td></td><td></td><td></td></td><td></td></td><td></td></td><td></td><td></td></tr>";
                    $datatable.="</table>";

                    $datatable.="<table border='1' style='text-align:center;'>";
                    $datatable.= "<tr>
                                    <th>Item Name</th>
                                    <th>Item Count</th>
                                    <th>Employee Contribution</th>
                                    <th>Employer Contribution</th>
                                    <th>Total Contribution</th>
                                    
                                </tr>";
                   
                    $item_details = mysqli_query($conn,"select * from `canteen_item`");
                       
                        
                    while($items_data = mysqli_fetch_assoc($item_details)){
                        $item_id = $items_data['itm_code'];
                        $item_name = $items_data['Item_name'];
                        $emp_contribution = $items_data['employee_contribution'];
                        $emper_contribution = $items_data['employeer_contribution'];
                        if($item_in ==  $item_id){
                            $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_id' and `UserId`='$emp_code'and `LogDate` between'$date_f_in'and'$date_t_in'"));

                        }else{
                            $sql_report_data  =0;
                        }
                        // contribution calculation
                        $total_emp_contribut = ($sql_report_data*$emp_contribution);
                        $total_emper_contribut = ($sql_report_data*$emper_contribution);
                        $total_contri = ($total_emp_contribut+$total_emper_contribut);

                        $datatable.="<tr>
                                        <td>$item_name</td>
                                        <td>$sql_report_data</td>
                                        <td>$total_emp_contribut</td>
                                        <td>$total_emper_contribut</td>
                                        <td>$total_contri</td>
                                    </tr>";
                        $total_item_count += $sql_report_data;
                        $all_emp_contribution += $total_emp_contribut;
                        $all_emper_contribution += $total_emper_contribut;
                        $total_Amout += $total_contri; 
                    }
                    $datatable.="<tr>
                                    <th>Total</th>
                                    <th>".$total_item_count."</th>
                                    <th>".$all_emp_contribution."</th>
                                    <th>".$all_emper_contribution."</th>
                                    <th>".$total_Amout."</th>
                                <tr>";
                    
                    $datatable.="</table>";
                    
                            echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
                                    <a href="contribution_report"><button class="btn-primary" >Back</button></a>';
                        echo '<div class="print_container" style="">'.$datatable.'</div>';
                }else{
                   
                    $_SESSION['icon']='error';
                    $_SESSION['status']='Data Not Found2';
                    header("location:contribution_report");
                }
    
            }else{
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] ='Please Process Report At Fast Data Not Found';
                header("location:contribution_report");
            }

        }else{
            $_SESSION['icon']='warning';
            $_SESSION['status'] = 'Date Range Should Be Within One Month';
            header("location:contribution_report");
        }
    }else{
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Data Not Found1 ';
        header("location:contribution_report");
    }

}
// End Item & date range  wise cnteen report Pdf


// Item & Month wise cnteen report xls

if(isset($_POST['item_m_r_xls'])){
    $item_in = $_POST['item_report'];
    $Month_in = $_POST['month_report'];
    $Year_in = $_POST['year_report'];
    $usre_id = $emp_code;
    $month= date("M",mktime(0, 0, 0, $Month_in, 10));
    


    if($item_in!="" && $Month_in!="" && $Year_in!=""){
        $table_name = "canteenreport_".$Month_in.'_'.$Year_in;
        $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
        if($sql_check_table >0){
            $sql_item_name = mysqli_fetch_assoc(mysqli_query($conn,"select * from `canteen_item` where `itm_code`='$item_in'"));
            $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_in' and `UserId`='$emp_code'and `LogMonth`='$month' and `LogYear`='$Year_in'");
             
                if($sql_canteen_report!=""){
                    $datatable="<table border='1' style='text-align:center;'>
                                    <tr>
                                        <th colspan='8'>
                                            Iteam :- &nbsp; ".strtoupper($sql_item_name['Item_name'])."
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan='8'style='padding:.2rem;text-align:center;'> Month :- &nbsp;".date("F",mktime(0, 0, 0, $Month_in, 10))." &nbsp;".$Year_in."</td>
                                        
                                    </tr>";
                    $datatable.=table_data($sql_canteen_report);
                    $datatable.="<tr><td></td><td></td><td></td></td><td></td></td><td></td></td><td></td><td></td><td></td></tr>";
                    $datatable.="</table>";

                    $datatable.="<table border='1' style='text-align:center;'>";
                    $datatable.= "<tr>
                                    <th>Item Name</th>
                                    <th>Item Count</th>
                                    <th>Employee Contribution</th>
                                    <th>Employer Contribution</th>
                                    <th>Total Contribution</th>
                                    
                                </tr>";
                   
                    $item_details = mysqli_query($conn,"select * from `canteen_item`");
                       
                        
                    while($items_data = mysqli_fetch_assoc($item_details)){
                        $item_id = $items_data['itm_code'];
                        $item_name = $items_data['Item_name'];
                        $emp_contribution = $items_data['employee_contribution'];
                        $emper_contribution = $items_data['employeer_contribution'];
                        if($item_in ==  $item_id){
                            $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_id' and `UserId`='$emp_code'and `LogMonth`='$month' and `LogYear`='$Year_in'"));

                        }else{
                            $sql_report_data  =0;
                        }
                        // contribution calculation
                        $total_emp_contribut = ($sql_report_data*$emp_contribution);
                        $total_emper_contribut = ($sql_report_data*$emper_contribution);
                        $total_contri = ($total_emp_contribut+$total_emper_contribut);

                        $datatable.="<tr>
                                        <td>$item_name</td>
                                        <td>$sql_report_data</td>
                                        <td>$total_emp_contribut</td>
                                        <td>$total_emper_contribut</td>
                                        <td>$total_contri</td>
                                    </tr>";
                        $total_item_count += $sql_report_data;
                        $all_emp_contribution += $total_emp_contribut;
                        $all_emper_contribution += $total_emper_contribut;
                        $total_Amout += $total_contri; 
                    }
                    $datatable.="<tr>
                                    <th>Total</th>
                                    <th>".$total_item_count."</th>
                                    <th>".$all_emp_contribution."</th>
                                    <th>".$all_emper_contribution."</th>
                                    <th>".$total_Amout."</th>
                                <tr>";
                    
                    $datatable.="</table>";
                    $fname = "Item_wise_canteen_report.xls";
                    header('Content-Type:application/octet-stream');
                    header('Content-Disposition:attachment; filename='.$fname);
        
                    echo $datatable;
        
                    $des="canteen report download";
                    $rem="canteen Report";
                    include "../include/_audi_log.php";
        
                    exit;
                }else{
                   
                    $_SESSION['icon']='error';
                    $_SESSION['status']='Data Not Found';
                    header("location:contribution_report");
                }
    
            }else{
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] ='Please Process Report At Fast Data Not Found';
                header("location:contribution_report");
            }
    }else{
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Data Not Found ';
        header("location:contribution_report");
    }

}
// End Item & Month  wise cnteen report xls
// Item & Month wise cnteen report Pdf

if(isset($_POST['item_m_r_pdf'])){
    $item_in = $_POST['item_report'];
    $Month_in = $_POST['month_report'];
    $Year_in = $_POST['year_report'];
    $usre_id = $emp_code;
    $month= date("M",mktime(0, 0, 0, $Month_in, 10));
    


    if($item_in!="" && $Month_in!="" && $Year_in!=""){
        $table_name = "canteenreport_".$Month_in.'_'.$Year_in;
        $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
        if($sql_check_table >0){
            $sql_item_name = mysqli_fetch_assoc(mysqli_query($conn,"select * from `canteen_item` where `itm_code`='$item_in'"));
            $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_in' and `UserId`='$emp_code'and `LogMonth`='$month' and `LogYear`='$Year_in'");
             
                if($sql_canteen_report!=""){
                    $datatable="<table border='1' style='text-align:center;'>
                                    <tr>
                                        <th colspan='8'>
                                            Iteam :- &nbsp; ".strtoupper($sql_item_name['Item_name'])."
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan='8'style='padding:.2rem;'> Month :- &nbsp;".date("F",mktime(0, 0, 0, $Month_in, 10))." &nbsp;".$Year_in."</td>
                                        
                                    </tr>";
                    $datatable.=table_data($sql_canteen_report);
                    $datatable.="<tr><td></td><td></td><td></td><td></td><td></td></tr>";
                    $datatable.="</table>";

                    $datatable.="<table border='1' style='text-align:center;'>";
                    $datatable.= "<tr>
                                    <th>Item Name</th>
                                    <th>Item Count</th>
                                    <th>Employee Contribution</th>
                                    <th>Employer Contribution</th>
                                    <th>Total Contribution</th>
                                    
                                </tr>";
                   
                    $item_details = mysqli_query($conn,"select * from `canteen_item`");
                       
                        
                    while($items_data = mysqli_fetch_assoc($item_details)){
                        $item_id = $items_data['itm_code'];
                        $item_name = $items_data['Item_name'];
                        $emp_contribution = $items_data['employee_contribution'];
                        $emper_contribution = $items_data['employeer_contribution'];
                        if($item_in ==  $item_id){
                            $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_id' and `UserId`='$emp_code'and `LogMonth`='$month' and `LogYear`='$Year_in'"));

                        }else{
                            $sql_report_data  =0;
                        }
                        // contribution calculation
                        $total_emp_contribut = ($sql_report_data*$emp_contribution);
                        $total_emper_contribut = ($sql_report_data*$emper_contribution);
                        $total_contri = ($total_emp_contribut+$total_emper_contribut);

                        $datatable.="<tr>
                                        <td>$item_name</td>
                                        <td>$sql_report_data</td>
                                        <td>$total_emp_contribut</td>
                                        <td>$total_emper_contribut</td>
                                        <td>$total_contri</td>
                                    </tr>";
                        $total_item_count += $sql_report_data;
                        $all_emp_contribution += $total_emp_contribut;
                        $all_emper_contribution += $total_emper_contribut;
                        $total_Amout += $total_contri; 
                    }
                    $datatable.="<tr>
                                    <th>Total</th>
                                    <th>".$total_item_count."</th>
                                    <th>".$all_emp_contribution."</th>
                                    <th>".$all_emper_contribution."</th>
                                    <th>".$total_Amout."</th>
                                <tr>";
                    
                    $datatable.="</table>";
                    
                            echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
                                    <a href="contribution_report"><button class="btn-primary" >Back</button></a>';
                        echo '<div class="print_container" style="">'.$datatable.'</div>';
                }else{
                   
                    $_SESSION['icon']='error';
                    $_SESSION['status']='Data Not Found';
                    header("location:contribution_report");
                }
    
            }else{
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] ='Please Process Report At Fast Data Not Found';
                header("location:contribution_report");
            }
    }else{
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Data Not Found ';
        header("location:contribution_report");
    }

}
// End Item & Month  wise cnteen report Pdf

// Month wise cnteen report xls

if(isset($_POST['m_r_xls'])){
   
    $Month_in = $_POST['month_report'];
    $Year_in = $_POST['year_report'];
    $usre_id = $emp_code;
    $month= date("M",mktime(0, 0, 0, $Month_in, 10));
    


    if($Month_in!="" && $Year_in!=""){
        $table_name = "canteenreport_".$Month_in.'_'.$Year_in;
        $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
        if($sql_check_table >0){
           
            $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `UserId`='$emp_code'and `LogMonth`='$month' and `LogYear`='$Year_in'");
                 
                if($sql_canteen_report!=""){
                    $datatable="<table border='1' style='text-align:center;'>
                                    
                                    <tr>
                                        <th colspan='8'style='padding:.2rem;'> Month :- &nbsp;".date("F",mktime(0, 0, 0, $Month_in, 10))." &nbsp;".$Year_in."</th>
                                        
                                    </tr>";
                    $datatable.=table_data($sql_canteen_report);
                    $datatable.="<tr><td></td><td></td><td></td><td></td></td><td></td></td><td></td></td><td></td><td></td></tr>";
                    $datatable.="</table>";

                    $datatable.="<table border='1' style='text-align:center;'>";
                    $datatable.= "<tr>
                                    <th>Item Name</th>
                                    <th>Item Count</th>
                                    <th>Employee Contribution</th>
                                    <th>Employer Contribution</th>
                                    <th>Total Contribution</th>
                                    
                                </tr>";
                   
                    $item_details = mysqli_query($conn,"select * from `canteen_item`");
                       
                        
                    while($items_data = mysqli_fetch_assoc($item_details)){
                        $item_id = $items_data['itm_code'];
                        $item_name = $items_data['Item_name'];
                        $emp_contribution = $items_data['employee_contribution'];
                        $emper_contribution = $items_data['employeer_contribution'];
                        
                            $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_id' and `UserId`='$emp_code'and `LogMonth`='$month' and `LogYear`='$Year_in'"));

                        
                        // contribution calculation
                        $total_emp_contribut = ($sql_report_data*$emp_contribution);
                        $total_emper_contribut = ($sql_report_data*$emper_contribution);
                        $total_contri = ($total_emp_contribut+$total_emper_contribut);

                        $datatable.="<tr>
                                        <td>$item_name</td>
                                        <td>$sql_report_data</td>
                                        <td>$total_emp_contribut</td>
                                        <td>$total_emper_contribut</td>
                                        <td>$total_contri</td>
                                    </tr>";
                        $total_item_count += $sql_report_data;
                        $all_emp_contribution += $total_emp_contribut;
                        $all_emper_contribution += $total_emper_contribut;
                        $total_Amout += $total_contri; 
                    }
                    $datatable.="<tr>
                                    <th style='text-align:left;'>Total</th>
                                    <th style='text-align:right;'>".$total_item_count."</th>
                                    <th style='text-align:right;'>".$all_emp_contribution."</th>
                                    <th style='text-align:right;'>".$all_emper_contribution."</th>
                                    <th style='text-align:right;'>".$total_Amout."</th>
                                <tr>";
                    
                    $datatable.="</table>";
                    $fname = $month."_".$Year_in."_canteen_report.xls";
                    header('Content-Type:application/octet-stream');
                    header('Content-Disposition:attachment; filename='.$fname);
        
                    echo $datatable;
        
                    $des="canteen report download";
                    $rem="canteen Report";
                    include "../include/_audi_log.php";
        
                    exit;
                }else{
                   
                    $_SESSION['icon']='error';
                    $_SESSION['status']='Data Not Found';
                    header("location:contribution_report");
                }
    
            }else{
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] ='Please Process Report At Fast Data Not Found';
                header("location:contribution_report");
            }
    }else{
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Data Not Found ';
        header("location:contribution_report");
    }

}
// End  Month  wise cnteen report Xls
//Month wise cnteen report Pdf

if(isset($_POST['m_r_pdf'])){
   
    $Month_in = $_POST['month_report'];
    $Year_in = $_POST['year_report'];
    $usre_id = $emp_code;
    $month= date("M",mktime(0, 0, 0, $Month_in, 10));
    


    if($Month_in!="" && $Year_in!=""){
        $table_name = "canteenreport_".$Month_in.'_'.$Year_in;
        $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
        if($sql_check_table >0){
           
            $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `UserId`='$emp_code'and `LogMonth`='$month' and `LogYear`='$Year_in'");
                 
                if($sql_canteen_report!=""){
                    $datatable="<table border='1' style='text-align:center;'>
                                    
                                    <tr>
                                        <th colspan='8'style='padding:.2rem;'> Month :- &nbsp;".date("F",mktime(0, 0, 0, $Month_in, 10))." &nbsp;".$Year_in."</th>
                                        
                                    </tr>";
                    $datatable.=table_data($sql_canteen_report);
                    $datatable.="<tr><td></td><td></td><td></td><td></td></td><td></td></td><td></td></td><td></td><td></td></tr>";
                    $datatable.="</table>";

                    $datatable.="<table border='1' style='text-align:center;'>";
                    $datatable.= "<tr>
                                    <th>Item Name</th>
                                    <th>Item Count</th>
                                    <th>Employee Contribution</th>
                                    <th>Employer Contribution</th>
                                    <th>Total Contribution</th>
                                    
                                </tr>";
                   
                    $item_details = mysqli_query($conn,"select * from `canteen_item`");
                       
                        
                    while($items_data = mysqli_fetch_assoc($item_details)){
                        $item_id = $items_data['itm_code'];
                        $item_name = $items_data['Item_name'];
                        $emp_contribution = $items_data['employee_contribution'];
                        $emper_contribution = $items_data['employeer_contribution'];
                        
                            $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `UserId`='$emp_code'and `Item_id`='$item_id' and `LogMonth`='$month' and `LogYear`='$Year_in'"));

                        
                        // contribution calculation
                        $total_emp_contribut = ($sql_report_data*$emp_contribution);
                        $total_emper_contribut = ($sql_report_data*$emper_contribution);
                        $total_contri = ($total_emp_contribut+$total_emper_contribut);

                        $datatable.="<tr>
                                        <td>$item_name</td>
                                        <td>$sql_report_data</td>
                                        <td>$total_emp_contribut</td>
                                        <td>$total_emper_contribut</td>
                                        <td>$total_contri</td>
                                    </tr>";
                        $total_item_count += $sql_report_data;
                        $all_emp_contribution += $total_emp_contribut;
                        $all_emper_contribution += $total_emper_contribut;
                        $total_Amout += $total_contri; 
                    }
                    $datatable.="<tr>
                                    <th>Total</th>
                                    <th>".$total_item_count."</th>
                                    <th>".$all_emp_contribution."</th>
                                    <th>".$all_emper_contribution."</th>
                                    <th>".$total_Amout."</th>
                                <tr>";
                    
                    $datatable.="</table>";
                    
                            echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
                                    <a href="contribution_report"><button class="btn-primary" >Back</button></a>';
                        echo '<div class="print_container" style="">'.$datatable.'</div>';
                }else{
                   
                    $_SESSION['icon']='error';
                    $_SESSION['status']='Data Not Found';
                    header("location:contribution_report");
                }
    
            }else{
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] ='Please Process Report At Fast Data Not Found';
                header("location:contribution_report");
            }
    }else{
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Data Not Found ';
        header("location:contribution_report");
    }

}
// End  Month  wise cnteen report Pdf
?>