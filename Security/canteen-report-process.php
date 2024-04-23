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
        header("location:canteen-report");
        exit;
    }
}





function table_data($data){
    include '../include/_dbconnect.php';

    $datatable= "<tr>
                    <th>Sl NO</th>
                    <th>User Code</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Item</th>
                    
                </tr>";

        $setdata = "";
        $i=0;

while($rec = mysqli_fetch_assoc($data)){
    $i++;




$datatable.="<tr>
        <td>".$i."</td>
        <td>".$rec['UserId']."</td>
        <td>".$rec['LogDate']."</td>
        <td>".$rec['LogTime']."</td>
        <td>".$rec['Items']."</td>
    </tr>
    ";

}

 return($datatable);
}




// Item & date range wise cnteen report xls

if(isset($_POST['Item_D_r_xls'])){
    $item_in = $_POST['item_report'];
    $date_f_in = $_POST['date_F_report'];
    $date_t_in = $_POST['date_T_report'];
    $emp_id = $emp_code;
    
    


    if($item_in!="" && $date_f_in!="" && $date_t_in!=""){
        if($date_f_in<=$date_t_in){

            $table_name = name_table($date_f_in,$date_t_in);
            $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
            if($sql_check_table >0){
                    $sql_item_name = mysqli_fetch_assoc(mysqli_query($conn,"select * from `canteen_item` where `itm_code`='$item_in'"));
                    
                    $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_in' and `UserId`='$emp_id' and`LogDate` between '$date_f_in' and '$date_t_in'");
                    
               
                if($sql_canteen_report!=""){
                    $datatable="<table border='1' style='text-align:center;'>
                                    <tr>
                                        <th colspan='5'>
                                            Iteam :- &nbsp; ".strtoupper($sql_item_name['Item_name'])."
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan='5'style='padding:.2rem;'> From Date :- &nbsp;".date_edit_1($date_f_in)." &nbsp;&nbsp;&nbsp;&nbsp; To Date :- &nbsp;".date_edit_1($date_t_in)."</td>
                                        
                                    </tr>";
                    $datatable.=table_data($sql_canteen_report);
                    $datatable.="<tr><td></td><td></td><td></td><td></td><td></td></tr>";
        
                   
                    $item_details = mysqli_query($conn,"select * from `canteen_item`");
                       
                        
                    while($items_data = mysqli_fetch_assoc($item_details)){
                        $item_id = $items_data['itm_code'];
                        $item_name = $items_data['Item_name'];
                        if($item_in ==  $item_id){
                            // $item_name_1 = $items_data['Item_name'];
                            $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_id' and `UserId`='$emp_id'and `LogDate` between'$date_f_in'and'$date_t_in'"));

                        }else{
                            $sql_report_data  =0;
                        }
                        
                        $datatable.="<tr>
                                        <th>$item_name</th>
                                        <td>$sql_report_data</td>
                                    </tr>";
                    }
                   
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
                    header("location:canteen-report");
                }
    
            }else{
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] ='Please Process Report At Fast Data Not Found';
                header("location:canteen-report");
            }

        }else{
            $_SESSION['icon']='warning';
            $_SESSION['status'] = 'Date Range Should Be Within One Month';
            header("location:canteen-report");
        }
    }else{
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Data Not Found1 ';
        header("location:canteen-report");
    }

}
// End Item & date range  wise cnteen report xls

// Item & date range wise cnteen report Pdf

if(isset($_POST['Item_D_r_pdf'])){
    $item_in = $_POST['item_report'];
    $date_f_in = $_POST['date_F_report'];
    $date_t_in = $_POST['date_T_report'];
    $emp_id = $emp_code;
    


    if($item_in!="" && $date_f_in!="" && $date_t_in!=""){
        if($date_f_in<=$date_t_in){

            $table_name = name_table($date_f_in,$date_t_in);
            $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
            if($sql_check_table >0){
                $sql_item_name = mysqli_fetch_assoc(mysqli_query($conn,"select * from `canteen_item` where `itm_code`='$item_in'"));
                    $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_in' and `UserId`='$emp_id'and`LogDate` between '$date_f_in' and '$date_t_in'");
                    
               
                if($sql_canteen_report!=""){
                    $datatable="<table border='1' style='text-align:center;'>
                                    <tr>
                                        <th colspan='5'>
                                            Iteam :- &nbsp; ".strtoupper($sql_item_name['Item_name'])."
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan='5'style='padding:.2rem;'> From Date :- &nbsp;".date_edit_1($date_f_in)." &nbsp;&nbsp;&nbsp;&nbsp; To Date :- &nbsp;".date_edit_1($date_t_in)."</td>
                                        
                                    </tr>";
                    $datatable.=table_data($sql_canteen_report);
                    $datatable.="<tr><td></td><td></td><td></td><td></td><td></td></tr>";
        
                   
                    $item_details = mysqli_query($conn,"select * from `canteen_item`");
                       
                        
                    while($items_data = mysqli_fetch_assoc($item_details)){
                        $item_id = $items_data['itm_code'];
                        $item_name = $items_data['Item_name'];
                        if($item_in ==  $item_id){
                            $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_id' and `UserId`='$emp_id'and`LogDate` between'$date_f_in'and'$date_t_in'"));

                        }else{
                            $sql_report_data  =0;
                        }
                        
                        $datatable.="<tr>
                                        <th>$item_name</th>
                                        <td>$sql_report_data</td>
                                    </tr>";
                    }
                    
                    $datatable.="</table>";
                    
                            echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
                                    <a href="canteen-report"><button class="btn-primary" >Back</button></a>';
                        echo '<div class="print_container" style="">'.$datatable.'</div>';
                }else{
                   
                    $_SESSION['icon']='error';
                    $_SESSION['status']='Data Not Found';
                    header("location:canteen-report");
                }
    
            }else{
                $_SESSION['icon'] = 'error';
                $_SESSION['status'] ='Please Process Report At Fast Data Not Found';
                header("location:canteen-report");
            }

        }else{
            $_SESSION['icon']='warning';
            $_SESSION['status'] = 'Date Range Should Be Within One Month';
            header("location:canteen-report");
        }
    }else{
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Data Not Found ';
        header("location:canteen-report");
    }

}
// End Item & date range  wise cnteen report Pdf



// Item & Month wise cnteen report xls

if(isset($_POST['item_m_r_xls'])){
    $item_in = $_POST['item_report'];
    $Month_in = $_POST['month_report'];
    $Year_in = $_POST['year_report'];
    $emp_id = $emp_code;
    $month= date("M",mktime(0, 0, 0, $Month_in, 10));
    


    if($item_in!="" && $Month_in!="" && $Year_in!=""){
        $table_name = "canteenreport_".$Month_in.'_'.$Year_in;
        $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
        if($sql_check_table >0){
            $sql_item_name = mysqli_fetch_assoc(mysqli_query($conn,"select * from `canteen_item` where `itm_code`='$item_in'"));
            $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_in' and `UserId`='$emp_id'and `LogMonth`='$month' and `LogYear`='$Year_in'");
                    
            if($sql_canteen_report!=""){
                $datatable="<table border='1' style='text-align:center;'>
                                <tr>
                                    <th colspan='5'>
                                        Iteam :- &nbsp; ".strtoupper($sql_item_name['Item_name'])."
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan='5'>
                                        Month :- &nbsp; ".strtoupper(date("F",mktime(0, 0, 0, $Month_in, 10)))."--".$Year_in."
                                    </th>
                                </tr>
                                ";
                $datatable.=table_data($sql_canteen_report);
                $datatable.="<tr><td></td><td></td><td></td><td></td><td></td></tr>";
    
                
                $item_details = mysqli_query($conn,"select * from `canteen_item`");
                    
                    
                while($items_data = mysqli_fetch_assoc($item_details)){
                    $item_id = $items_data['itm_code'];
                    $item_name = $items_data['Item_name'];
                    if($item_in ==  $item_id){
                        $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_id' and  `UserId`='$emp_id'and `LogMonth`='$month' and `LogYear`='$Year_in'"));

                    }else{
                        $sql_report_data  =0;
                    }
                    
                    $datatable.="<tr>
                                    <th>$item_name</th>
                                    <td>$sql_report_data</td>
                                </tr>";
                }
            
                $datatable.="</table>";
             
                    $fname = $month.'_'.$Year_in."_item_wise_canteen_report.xls";
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
                header("location:canteen-report");
            }

        }else{
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] ='Please Process Report At Fast Data Not Found';
            header("location:canteen-report");
        }

    }else{
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Data Not Found ';
        header("location:canteen-report");
    }

}
// End Item & Month wise cnteen report xls

// Item & Month wise cnteen report Pdf

if(isset($_POST['item_m_r_pdf'])){
    $item_in = $_POST['item_report'];
    $Month_in = $_POST['month_report'];
    $Year_in = $_POST['year_report'];
    $emp_id = $emp_code;
    $month= date("M",mktime(0, 0, 0, $Month_in, 10));
    


    if($item_in!="" && $Month_in!="" && $Year_in!=""){
        $table_name = "canteenreport_".$Month_in.'_'.$Year_in;
        $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
        if($sql_check_table >0){
            $sql_item_name = mysqli_fetch_assoc(mysqli_query($conn,"select * from `canteen_item` where `itm_code`='$item_in'"));
            $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_in' and `UserId`='$emp_id'and `LogMonth`='$month' and `LogYear`='$Year_in'");
             
            if($sql_canteen_report!=""){
                $datatable="<table border='1' style='text-align:center;'>
                    <tr>
                        <th colspan='5'>
                            Iteam :- &nbsp; ".strtoupper($sql_item_name['Item_name'])."
                        </th>
                    </tr>
                    <tr>
                        <th colspan='5'>
                            Month :- &nbsp; ".strtoupper(date("F",mktime(0, 0, 0, $Month_in, 10)))."--".$Year_in."
                        </th>
                    </tr>
                    ";
                $datatable.=table_data($sql_canteen_report);
                $datatable.="<tr><td></td><td></td><td></td><td></td><td></td></tr>";
    
                
                $item_details = mysqli_query($conn,"select * from `canteen_item`");
                    
                    
                while($items_data = mysqli_fetch_assoc($item_details)){
                    $item_id = $items_data['itm_code'];
                    $item_name = $items_data['Item_name'];
                    if($item_in ==  $item_id){
                        $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_id' and `UserId`='$emp_id'and `LogMonth`='$month' and `LogYear`='$Year_in'"));

                    }else{
                        $sql_report_data  =0;
                    }
                    
                    $datatable.="<tr>
                                    <th>$item_name</th>
                                    <td>$sql_report_data</td>
                                </tr>";
                }
            
                $datatable.="</table>";
                
                        echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
                                <a href="canteen-report"><button class="btn-primary" >Back</button></a>';
                    echo '<div class="print_container" style="">'.$datatable.'</div>';
            }else{
                
                $_SESSION['icon']='error';
                $_SESSION['status']='Data Not Found';
                header("location:canteen-report");
            }

        }else{
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] ='Please Process Report At Fast Data Not Found';
            header("location:canteen-report");
        }

    }else{
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Data Not Found ';
        header("location:canteen-report");
    }

}
// End Item & Month wise cnteen report Pdf

// Month wise cnteen report xls
if(isset($_POST['m_r_xls'])){
   
    $Month_in = $_POST['month_report'];
    $Year_in = $_POST['year_report'];
    $emp_id = $emp_code;
    $month= date("M",mktime(0, 0, 0, $Month_in, 10));
    


    if($Month_in!="" && $Year_in!=""){
        $table_name = "canteenreport_".$Month_in.'_'.$Year_in;
        $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
        if($sql_check_table >0){
           
            $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `UserId`='$emp_id' and `LogMonth`='$month' and `LogYear`='$Year_in'");
                    
            if($sql_canteen_report!=""){
                $datatable="<table border='1' style='text-align:center;'>
                                <tr>
                                    <th colspan='5'>
                                        Month :- &nbsp; ".strtoupper(date("F",mktime(0, 0, 0, $Month_in, 10)))."--".$Year_in."
                                    </th>
                                </tr>
                                ";
                $datatable.=table_data($sql_canteen_report);
                $datatable.="<tr><td></td><td></td><td></td><td></td><td></td></tr>";
    
                
                $item_details = mysqli_query($conn,"select * from `canteen_item`");
                    
                    
                while($items_data = mysqli_fetch_assoc($item_details)){
                    $item_id = $items_data['itm_code'];
                    $item_name = $items_data['Item_name'];
                    
                        $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_id' and `UserId`='$emp_id'and `LogMonth`='$month' and `LogYear`='$Year_in'"));

                    
                    
                    $datatable.="<tr>
                                    <th>$item_name</th>
                                    <td>$sql_report_data</td>
                                </tr>";
                }
            
                $datatable.="</table>";
                
                $fname = $month.'_'.$Year_in."_canteen_report.xls";
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
                header("location:canteen-report");
            }

        }else{
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] ='Please Process Report At Fast Data Not Found';
            header("location:canteen-report");
        }

    }else{
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Data Not Found ';
        header("location:canteen-report");
    }

}
// End Month wise cnteen report xls

// Month wise cnteen report Pdf
if(isset($_POST['m_r_pdf'])){
   
    $Month_in = $_POST['month_report'];
    $Year_in = $_POST['year_report'];
    $emp_id = $emp_code;
    $month= date("M",mktime(0, 0, 0, $Month_in, 10));
    


    if($Month_in!="" && $Year_in!=""){
        $table_name = "canteenreport_".$Month_in.'_'.$Year_in;
        $sql_check_table = mysqli_num_rows(mysqli_query($conn_bio,"select * from  information_schema.tables where table_type='base table' and table_name='$table_name'"));
        if($sql_check_table >0){
           
            $sql_canteen_report = mysqli_query($conn,"select * from `$table_name` where `UserId`='$emp_id'and `LogMonth`='$month' and `LogYear`='$Year_in'");
                    
            if($sql_canteen_report!=""){
                $datatable="<table border='1' style='text-align:center;'>
                                <tr>
                                    <th colspan='5'>
                                        Month :- &nbsp; ".strtoupper(date("F",mktime(0, 0, 0, $Month_in, 10)))."--".$Year_in."
                                    </th>
                                </tr>
                                ";
                $datatable.=table_data($sql_canteen_report);
                $datatable.="<tr><td></td><td></td><td></td><td></td><td></td></tr>";
    
                
                $item_details = mysqli_query($conn,"select * from `canteen_item`");
                    
                    
                while($items_data = mysqli_fetch_assoc($item_details)){
                    $item_id = $items_data['itm_code'];
                    $item_name = $items_data['Item_name'];
                    
                        $sql_report_data  = mysqli_num_rows(mysqli_query($conn,"select * from `$table_name` where `Item_id`='$item_id' and `UserId`='$emp_id'and `LogMonth`='$month' and `LogYear`='$Year_in'"));

                    
                    
                    $datatable.="<tr>
                                    <th>$item_name</th>
                                    <td>$sql_report_data</td>
                                </tr>";
                }
            
                $datatable.="</table>";
                
                        echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
                                <a href="canteen-report"><button class="btn-primary" >Back</button></a>';
                    echo '<div class="print_container" style="">'.$datatable.'</div>';
            }else{
                
                $_SESSION['icon']='error';
                $_SESSION['status']='Data Not Found2';
                header("location:canteen-report");
            }

        }else{
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] ='Please Process Report At Fast Data Not Found';
            header("location:canteen-report");
        }

    }else{
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Data Not Found ';
        header("location:canteen-report");
    }

}
// End Month wise cnteen report Pdf

?>