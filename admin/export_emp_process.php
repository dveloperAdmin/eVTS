<head>

<title>eVTS</title>
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
</style>

</head>

<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';

$des="Page load Export_emp_process";
$rem="Employee Details Export";
include "../include/_audi_log.php";



function emp_table_excel($data){
    include '../include/_dbconnect.php';
    include "../include/xlsxgen.php";
      
      $table_formate =[
            ['<b>Sl_NO','<b>Employee_Code','<b>Employee_Name','<b>Company_Name','<b>Branch','<b>Department','<b>Sub_Department','<b>Designation','<b>Grade','<b>Location','<b>Employee_Type','<b>Category','<b>Contact','<b>Status']
    
      ];        // $datatable = emp_table();
      
  
    $com_name = "";
    $branch_name = "";
    $deprt_name = "";
    $sub_dept_name = "";
    $desig= "";
    $grade = "";
    $category = "";
    $i=0;

    while($res = mysqli_fetch_assoc($data)){
       
        $com_id = $res['CompanyId'];
        $com_res  = mysqli_fetch_assoc(mysqli_query($conn,"select * from `company_details` where `company_id`='$com_id'"));
        if($com_res!=""){
            $com_name = $com_res['companyFname'];
        }

        $bran_id = $res['BranchId'];
        $bran_res  = mysqli_fetch_assoc(mysqli_query($conn,"select * from `branch` where `branch_code`='$bran_id'"));
        if($bran_res!=""){
            $branch_name = $bran_res['branch_name'];
        }

        $dept_id = $res['DepartmentId'];
        $dept_res  = mysqli_fetch_assoc(mysqli_query($conn,"select * from `department` where `department_code`='$dept_id'"));
        if($dept_res!=""){
            $deprt_name = $dept_res['department_name'];
        }

        $sub_dept_id = $res['Sub_DepartmentId'];
        $sub_dept_res  = mysqli_fetch_assoc(mysqli_query($conn,"select * from `subdepartment`where `subdepartment_code`='$sub_dept_id'"));
        if($sub_dept_res!=""){
            $sub_dept_name = $sub_dept_res['subdepartment_name'];
        }

        $desig_id = $res['DesignationId'];
        $desig_res  = mysqli_fetch_assoc(mysqli_query($conn,"select * from `designation`where `designation_code`='$desig_id'"));
        if($desig_res!=""){
            $desig = $desig_res['designation'];
        }

        $grade_id = $res['GradeId'];
        $grade_res  = mysqli_fetch_assoc(mysqli_query($conn,"select * from `grade` where `grade_code`='$grade_id'"));
        if($grade_res!=""){
            $grade = $grade_res['grade'];
        }

        $cat_id = $res['CategoryId'];
        $cate_res  = mysqli_fetch_assoc(mysqli_query($conn,"select * from `empcategory` where `empcat_code`='$cat_id'"));
        if($cate_res!=""){
            $category = $cate_res['empcat'];
        }
        
        

        $q[0]= ++$i;
        $q[1]= $res['Emp_code'];
        $q[2]= $res['EmployeeName'];
        $q[3]= $com_name;
        $q[4]= $branch_name;
        $q[5]= $deprt_name;
        $q[6]= $sub_dept_name;
        $q[7]= $desig;
        $q[8]= $grade;
        $q[9]= $res['Location'];
        $q[10]= $res['EmployeType'];
        $q[11]= $category;
        $q[12]= $res['ContactNo'];
        $q[13]= $res['Status'];


      
        for($j= 0; $j< count($q); $j++){
            $table_formate[$i][$j] = $q[$j];
        }
      
      
        
    }
    $xlsx = SimpleXLSXGen::fromArray($table_formate);
    $xlsx->downloadAs('Employee_details.xlsx');
//  return($datatable);

}
function emp_table($data){
    include '../include/_dbconnect.php';
    $datatable= "<tr>
                    <th>Sl NO</th>
                    <th>Employee Code</th>
                    <th>Employee Name</th>
                    <th>Company Name</th>
                    <th>Branch</th>
                    <th>Department</th>
                    <th>Sub-Department</th>
                    <th>Designation</th>
                    <th>Garde</th>
                    <th>Location</th>
                    <th>Employee Type </th>
                    <th>Category</th>
                    <th>Contact No</th>
                    <th>Status</th>
                </tr>";

    $com_name = "";
    $branch_name = "";
    $deprt_name = "";
    $sub_dept_name = "";
    $desig= "";
    $grade = "";
    $category = "";
    $i=0;

    while($res = mysqli_fetch_assoc($data)){
       
        $com_id = $res['CompanyId'];
        $com_res  = mysqli_fetch_assoc(mysqli_query($conn,"select * from `company_details` where `company_id`='$com_id'"));
        if($com_res!=""){
            $com_name = $com_res['companyFname'];
        }

        $bran_id = $res['BranchId'];
        $bran_res  = mysqli_fetch_assoc(mysqli_query($conn,"select * from `branch` where `branch_code`='$bran_id'"));
        if($bran_res!=""){
            $branch_name = $bran_res['branch_name'];
        }

        $dept_id = $res['DepartmentId'];
        $dept_res  = mysqli_fetch_assoc(mysqli_query($conn,"select * from `department` where `department_code`='$dept_id'"));
        if($dept_res!=""){
            $deprt_name = $dept_res['department_name'];
        }

        $sub_dept_id = $res['Sub_DepartmentId'];
        $sub_dept_res  = mysqli_fetch_assoc(mysqli_query($conn,"select * from `subdepartment`where `subdepartment_code`='$sub_dept_id'"));
        if($sub_dept_res!=""){
            $sub_dept_name = $sub_dept_res['subdepartment_name'];
        }

        $desig_id = $res['DesignationId'];
        $desig_res  = mysqli_fetch_assoc(mysqli_query($conn,"select * from `designation`where `designation_code`='$desig_id'"));
        if($desig_res!=""){
            $desig = $desig_res['designation'];
        }

        $grade_id = $res['GradeId'];
        $grade_res  = mysqli_fetch_assoc(mysqli_query($conn,"select * from `grade` where `grade_code`='$grade_id'"));
        if($grade_res!=""){
            $grade = $grade_res['grade'];
        }

        $cat_id = $res['CategoryId'];
        $cate_res  = mysqli_fetch_assoc(mysqli_query($conn,"select * from `empcategory` where `empcat_code`='$cat_id'"));
        if($cate_res!=""){
            $category = $cate_res['empcat'];
        }
       
        $datatable.= "<tr>
                    <td>". ++$i."</td>
                    <td>".$res['Emp_code']."</td>
                    <td>".$res['EmployeeName']."</td>
                    <td>".$com_name."</td>
                    <td>".$branch_name."</td>
                    <td>".$deprt_name."</td>
                    <td>".$sub_dept_name."</td>
                    <td>".$desig."</td>
                    <td>".$grade."</td>
                    <td>".$res['Location']."</td>
                    <td>".$res['EmployeType'] ."</td>
                    <td>". $category."</td>
                    <td>".$res['ContactNo']."</td>
                    <td>".$res['Status']."</td>
                </tr>";

    }
 return($datatable);

}


//emp search by mobile no start xls
if(isset($_POST['emp_mob_xls'])){
    $mobile_no  = $_POST['mob_report'];
    echo $user_role;
    if($mobile_no!=""){
        if(in_array($user_role, array("Developer", "Super Admin"))){
            $search_emp_mob_no = mysqli_query($conn,"select * from `eomploye_details` where `ContactNo` = '$mobile_no'");
            
        }else{
            $search_emp_mob_no = mysqli_query($conn,"select * from `eomploye_details` where `BranchId`='$branch_id' and `ContactNo` = '$mobile_no'");

        }
        if($search_emp_mob_no!=""){
        
            emp_table_excel($search_emp_mob_no);
           
            $des="Employee Details Export";
            $rem="Employee Details Export";
            include "../include/_audi_log.php";

            exit;
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Employee Data Not Found';
            header("location:export_emp");
        }

    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']='Data Not Found';
        header("location:export_emp");
    }
}
//emp search by mobile no end xls
//emp search by mobile no start pdf
if(isset($_POST['emp_mob_pdf'])){
    $mobile_no  = $_POST['mob_report'];

    if($mobile_no!=""){
        if(in_array($user_role, array("Developer", "Super Admin"))){

            $search_emp_mob_no = mysqli_query($conn,"select * from `eomploye_details` where `ContactNo` = '$mobile_no'");
        }else{
            $search_emp_mob_no = mysqli_query($conn,"select * from `eomploye_details` where `BranchId`='$branch_id' and `ContactNo` = '$mobile_no'");

        }
        if($search_emp_mob_no!=""){
            $datatable="<table border='1' style='text-align:center;'>
                            <tr>
                                <th colspan='14'>
                                    Employee Details
                                </th>
                            </tr>
                            ";
            $datatable.=emp_table($search_emp_mob_no);
            $datatable.="</table>";
                 echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
                            <a href="export_emp"><button class="btn-primary" >Back</button></a>';
                echo '<div class="print_container" style="">'.$datatable.'</div>';
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Employee Data Not Found';
            header("location:export_emp");
        }

    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']='Data Not Found';
        header("location:export_emp");
    }
}
//emp search by mobile no end pdf

//emp search by emp name start xls
if(isset($_POST['emp_name_xls'])){

    $emp_name  = $_POST['emp_nam'];

    if($emp_name!=""){
        if(in_array($user_role, array("Developer", "Super Admin"))){

            $search_emp_name = mysqli_query($conn,"select * from `eomploye_details` where `EmployeeName` like '%$emp_name'");
        }else{
            $search_emp_name = mysqli_query($conn,"select * from `eomploye_details` where `BranchId`='$branch_id' and `EmployeeName` like '%$emp_name'");

        }
        if($search_emp_name!=""){
           
            emp_table_excel($search_emp_name);
           

            $des="canteen report download";
            $rem="canteen Report";
            include "../include/_audi_log.php";

            exit;
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Employee Data Not Found';
            header("location:export_emp");
        }

    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']='Data Not Found';
        header("location:export_emp");
    }
}
//emp search by emp name end xls

//emp search by emp name start pdf
if(isset($_POST['emp_name_pdf'])){

    $emp_name  = $_POST['emp_nam'];

    if($emp_name!=""){
        if(in_array($user_role, array("Developer", "Super Admin"))){

            $search_emp_name = mysqli_query($conn,"select * from `eomploye_details` where `EmployeeName` like '%$emp_name'");
        }else{
            $search_emp_name = mysqli_query($conn,"select * from `eomploye_details` where `BranchId`='$branch_id' and `EmployeeName` like '%$emp_name'");

        }
        if($search_emp_name!=""){
            $datatable="<table border='1' style='text-align:center;'>
                            <tr>
                                <th colspan='14'>
                                    Employee Details
                                </th>
                            </tr>
                            ";
            $datatable.=emp_table($search_emp_name);
            $datatable.="</table>";
                 echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
                            <a href="export_emp"><button class="btn-primary" >Back</button></a>';
                echo '<div class="print_container" style="">'.$datatable.'</div>';
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Employee Data Not Found';
            header("location:export_emp");
        }

    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']='Data Not Found';
        header("location:export_emp");
    }
}
//emp search by emp name end pdf


//emp search by Com branch Dept start xls
if(isset($_POST['com_emp_xls'])){

    $com_id  = $_POST['com_id'];
    $branch_id  = $_POST['branch_id'];
    $department_id  = $_POST['dept_id'];

    if($com_id!="" && $branch_id!="" && $department_id!=""){
        $sql="";
        if($com_id == 1){
            if($branch_id == 1){
                if($department_id == 1){
                    $sql = "select * from `eomploye_details`";
                }else{
                    $sql = "select * from `eomploye_details` where `DepartmentId` = '$department_id'";
                }

            }else{
                if($department_id == 1){
                    $sql = "select * from `eomploye_details` where `BranchId`='$branch_id'";
                }else{
                    $sql = "select * from `eomploye_details` where `BranchId`='$branch_id' and `DepartmentId` = '$department_id'";
                }
            }

        }else{
            if($branch_id == 1){
                if($department_id == 1){
                    $sql = "select * from `eomploye_details` where `CompanyId`='$com_id'";
                }else{
                    $sql = "select * from `eomploye_details` where `CompanyId`='$com_id' and `DepartmentId` = '$department_id'";
                }

            }else{
                if($department_id == 1){
                    $sql = "select * from `eomploye_details` where `CompanyId`='$com_id' and `BranchId`='$branch_id'";
                }else{
                    $sql = "select * from `eomploye_details` where `CompanyId`='$com_id' and `BranchId`='$branch_id' and `DepartmentId` = '$department_id'";
                }
            }
        }

        $search_emp_name = mysqli_query($conn,$sql);
        if($search_emp_name!=""){
            emp_table_excel($search_emp_name);
            
            echo $datatable;

            $des="canteen report download";
            $rem="canteen Report";
            include "../include/_audi_log.php";

            exit;
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Employee Data Not Found';
            header("location:export_emp");
        }

    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']='Data Not Found';
        header("location:export_emp");
    }
}
//emp search by Com branch Dept  end xls
//emp search by Com branch Dept start pdf
if(isset($_POST['com_emp_pdf'])){

    $com_id  = $_POST['com_id'];
    $branch_id  = $_POST['branch_id'];
    $department_id  = $_POST['dept_id'];

    if($com_id!="" && $branch_id!="" && $department_id!=""){
        $sql="";
        if($com_id == 1){
            if($branch_id == 1){
                if($department_id == 1){
                    $sql = "select * from `eomploye_details`";
                }else{
                    $sql = "select * from `eomploye_details` where `DepartmentId` = '$department_id'";
                }

            }else{
                if($department_id == 1){
                    $sql = "select * from `eomploye_details` where `BranchId`='$branch_id'";
                }else{
                    $sql = "select * from `eomploye_details` where `BranchId`='$branch_id' and `DepartmentId` = '$department_id'";
                }
            }

        }else{
            if($branch_id == 1){
                if($department_id == 1){
                    $sql = "select * from `eomploye_details` where `CompanyId`='$com_id'";
                }else{
                    $sql = "select * from `eomploye_details` where `CompanyId`='$com_id' and `DepartmentId` = '$department_id'";
                }

            }else{
                if($department_id == 1){
                    $sql = "select * from `eomploye_details` where `CompanyId`='$com_id' and `BranchId`='$branch_id'";
                }else{
                    $sql = "select * from `eomploye_details` where `CompanyId`='$com_id' and `BranchId`='$branch_id' and `DepartmentId` = '$department_id'";
                }
            }
        }

        $search_emp_name = mysqli_query($conn,$sql);
        if($search_emp_name!=""){
            $datatable="<table border='1' style='text-align:center;'>
                            <tr>
                                <th colspan='14'>
                                    Employee Details
                                </th>
                            </tr>
                            ";
            $datatable.=emp_table($search_emp_name);
            $datatable.="</table>";
                 echo'  <button class="btn-primary"  onclick="window.print()">Print</button>
                            <a href="export_emp"><button class="btn-primary" >Back</button></a>';
                echo '<div class="print_container" style="">'.$datatable.'</div>';
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']='Employee Data Not Found';
            header("location:export_emp");
        }

    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']='Data Not Found';
        header("location:export_emp");
    }
}
//emp search by Com branch Dept  end pdf
?>