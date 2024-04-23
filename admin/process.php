<?php 
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';


// Start Company Setup
//company Add start

if(isset($_POST['com_sub'])){
    $cf_name = $_POST['co_f_name'];
    $cs_name = $_POST['co_s_name'];
    if($cf_name!="" && $cs_name!=""){
        $check_ful_name = mysqli_num_rows(mysqli_query($conn,"select * from `company_details` where `companyFname`='$cf_name'"));
        $check_short_name = mysqli_num_rows(mysqli_query($conn,"select * from `company_details` where `companySname`='$cs_name'"));

        if($check_ful_name <1 && $check_short_name<1){

            $c_id = 'Com-'.time();
            $com_insert_sql = mysqli_query($conn,"insert into `company_details`(`company_id`, `companyFname`, `companySname`) values ('$c_id','$cf_name','$cs_name')");
            if($com_insert_sql){
                $_SESSION['icon'] ='success';
                $_SESSION['status'] ='Company Details Added ......';
                // $sql_comapany_details = mysqli_query($conn,"select * from `company_details` order by `sl_no` desc");
    
                $des="Click On Add Comapany";
                $rem="Company Add success";
                include '../include/_audi_log.php';
                header("location:company");
    
            }else{
                $_SESSION['icon'] ='error';
                $_SESSION['status'] ='Company Details Not Added ......';
                // $sql_comapany_details = mysqli_query($conn,"select * from `company_details` order by `sl_no` desc");
    
                $des="Click On Add Comapany";
                $rem="Company Add unsuccess";
                include '../include/_audi_log.php';
                header("location:company");
    
            }
        }else{

            $_SESSION['icon'] ='error';
            $_SESSION['status'] ='Dublicate Entry Not Allowed..';
            // $sql_comapany_details = mysqli_query($conn,"select * from `company_details` order by `sl_no` desc");
    
            $des="Click On Add Comapany";
            $rem="Company Add unsuccess";
            include '../include/_audi_log.php';
            header("location:company");
        }
    }else{
            $_SESSION['icon'] ='error';
            $_SESSION['status'] ='Company Details Not Added ......';
            // $sql_comapany_details = mysqli_query($conn,"select * from `company_details` order by `sl_no` desc");

            $des="Click On Add Comapany";
            $rem="Company Add unsuccess";
            include '../include/_audi_log.php';
            header("location:company");

    }

}


//company Add start

// Company Update 
if(isset($_POST['com_update'])){
    $c_id = $_POST['c_id'];
    $cf_name = $_POST['up_co_f_name'];
    $cs_name = $_POST['up_co_s_name'];
   
    if($cf_name!="" && $cs_name!=""){
        $sql_check_data= mysqli_fetch_assoc(mysqli_query($conn,"select * from `company_details` where `company_id`='$c_id'"));
        if($sql_check_data['companyFname']!=$cf_name || $sql_check_data['companySname'] !=$cs_name ){

            $check_ful_name = mysqli_num_rows(mysqli_query($conn,"select * from `company_details` where `companyFname`='$cf_name'"));
            $check_short_name = mysqli_num_rows(mysqli_query($conn,"select * from `company_details` where `companySname`='$cs_name'"));
    
            if($check_ful_name <1){
                if($check_short_name<1){

                    $com_insert_sql = mysqli_query($conn,"update `company_details` set `companyFname`='$cf_name',`companySname`='$cs_name' where `company_id`='$c_id'");
                    if($com_insert_sql){
                        $_SESSION['icon'] ='success';
                        $_SESSION['status'] ='Company Details Updated ......';
                        // $sql_comapany_details = mysqli_query($conn,"select * from `company_details` order by `sl_no` desc");
            
                        $des="Click On update Comapany";
                        $rem="Company update success";
                        include '../include/_audi_log.php';
                        header("location:company");
                    }else{

                        $_SESSION['icon'] ='error';
                        $_SESSION['status'] ='Company Details Not Updated ......';
                        // $sql_comapany_details = mysqli_query($conn,"select * from `company_details` order by `sl_no` desc");
            
                        $des="Click On update Comapany";
                        $rem="Company update unsuccess";
                        include '../include/_audi_log.php';
                        header("location:company");
                    }
    
               
        
                }else{
        
                    $_SESSION['icon'] ='error';
                    $_SESSION['status'] ='Dublicate Entry Not Allowed..';
                    // $sql_comapany_details = mysqli_query($conn,"select * from `company_details` order by `sl_no` desc");
            
                    $des="Click On update Comapany";
                    $rem="Company update unsuccess";
                    include '../include/_audi_log.php';
                    header("location:company");
                }
            }else{
                if($check_short_name<1){

                    $com_insert_sql = mysqli_query($conn,"update `company_details` set `companySname`='$cs_name' where `company_id`='$c_id'");
                    if($com_insert_sql){
                        $_SESSION['icon'] ='success';
                        $_SESSION['status'] ='Company Details Updated ......';
                        // $sql_comapany_details = mysqli_query($conn,"select * from `company_details` order by `sl_no` desc");
            
                        $des="Click On update Comapany";
                        $rem="Company update success";
                        include '../include/_audi_log.php';
                        header("location:company");
                    }else{

                        $_SESSION['icon'] ='error';
                        $_SESSION['status'] ='Company Details Not Updated ......';
                        // $sql_comapany_details = mysqli_query($conn,"select * from `company_details` order by `sl_no` desc");
            
                        $des="Click On update Comapany";
                        $rem="Company update unsuccess";
                        include '../include/_audi_log.php';
                        header("location:company");
                    }
    
               
        
                }else{
        
                    $_SESSION['icon'] ='error';
                    $_SESSION['status'] ='Dublicate Entry Not Allowed..';
                    // $sql_comapany_details = mysqli_query($conn,"select * from `company_details` order by `sl_no` desc");
            
                    $des="Click On update Comapany";
                    $rem="Company update unsuccess";
                    include '../include/_audi_log.php';
                    header("location:company");
                }
            }
        }else{
            $_SESSION['icon'] ='info';
            $_SESSION['status'] ='Company already Exist..';
            header("location:company");
        }




    }else{
            $_SESSION['icon'] ='error';
            $_SESSION['status'] ='Company Details Not Added ......';
            // $sql_comapany_details = mysqli_query($conn,"select * from `company_details` order by `sl_no` desc");

            $des="Click On update Comapany";
            $rem="Company update unsuccess";
            include '../include/_audi_log.php';
            header("location:company");

    }

}

// company Edit end

//company Details delete
if(isset($_GET['id'])){
    $c_id = $_GET['id'];
    $check_no_of_data = mysqli_num_rows(mysqli_query($conn,"select * from `company_details` where `company_id`='$c_id'"));
    if($check_no_of_data >=1){
        $sql_delete = mysqli_query($conn,"delete from `company_details` where `company_id` ='$c_id'");
        if($sql_delete){
            $_SESSION['icon'] = 'success';
            $_SESSION['status'] = 'Company Details Deleted successfully';
            $des="Click On delete Comapany";
            $rem="Company delete success";
            include '../include/_audi_log.php';
            header("location:company");
        }else{
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Company Details Deleted Unsuccess...';
            $des="Click On Delete Comapany";
            $rem="Company delete Unsuccess";
            include '../include/_audi_log.php';
            header("location:company");
        }
    }else{
            $_SESSION['icon'] = 'info';
            $_SESSION['status'] = 'NO Data Exists....';
            $des="Click On Delete Comapany";
            $rem="Company NO Data Exists";
            include '../include/_audi_log.php';
            header("location:company");
    }
}
// company_delete end

// End Company Setup


//start branch setup

//branch Entry start

if(isset($_POST['banch_sub'])){
    $branch_name = $_POST['branch_name'];
    if($branch_name!=""){

        $check_brach_existance = mysqli_num_rows(mysqli_query($conn,"select * from `branch` where `branch_name`='$branch_name'"));
        if($check_brach_existance <1){
            $sql_total_branch = mysqli_num_rows(mysqli_query($conn, "select * from `branch`"));
            $branch_id = "B-".($sql_total_branch+1).'-'.date("hiys");

            $sql_branch_insert = mysqli_query($conn,"insert into `branch`(`branch_code`, `branch_name`) values ('$branch_id','$branch_name')");

            if($sql_branch_insert){
                $_SESSION['icon']='success';
                $_SESSION['status']= 'Branch Added';
                $des="Click Add Branch ";
                $rem="Branch Add Success";
                include '../include/_audi_log.php';
                header("location:branch");
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Branch Not Added';
                $des="Click Add Branch ";
                $rem="Branch Add UnSuccess";
                include '../include/_audi_log.php';
                header("location:branch");
            }

        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Dublicat Input';
            $des="Click Add Branch ";
            $rem="Branch Add UnSuccess Due to Dublicate Branch Input";
            include '../include/_audi_log.php';
            header("location:branch");
        }

    }else{
        $_SESSION['icon']='info';
            $_SESSION['status']= 'Enter Proper Input';
            $des="Click Add Branch ";
            $rem="Branch Add UnSuccess ";
            include '../include/_audi_log.php';
            header("location:branch");
    }
}


//branch Entry end
//branch Edit start

if(isset($_POST['upbanch_sub'])){
    $branch_name = $_POST['ebranch_name'];
    $branch_code = $_POST['branch_code'];
    if($branch_name!="" && $branch_code!=""){
        $sql_branch_data = mysqli_query($conn,"select * from `branch` where `branch_code`='$branch_code'");
        $check_brach_existance = mysqli_num_rows($sql_branch_data);
        $branch_data_fetch = mysqli_fetch_assoc($sql_branch_data);

        if($branch_data_fetch['branch_name']!=$branch_name){
            $check_branch_name = mysqli_num_rows(mysqli_query($conn,"select * from `branch` where `branch_name`='$branch_name'"));
            if($check_branch_name <1){
                
    
                $sql_branch_insert = mysqli_query($conn,"update `branch` set `branch_name`='$branch_name' where `branch_code`='$branch_code'");
    
                if($sql_branch_insert){
                    $_SESSION['icon']='success';
                    $_SESSION['status']= 'Branch Updated';
                    $des="Click Update Branch ";
                    $rem="Branch Update Success";
                    include '../include/_audi_log.php';
                    header("location:branch");
                }else{
                    $_SESSION['icon']='error';
                    $_SESSION['status']= 'Branch Not Update';
                    $des="Click Update Branch ";
                    $rem="Branch Update UnSuccess";
                    include '../include/_audi_log.php';
                    header("location:branch");
                }
       
            }else{
                $_SESSION['icon']='info';
                $_SESSION['status']= 'Dublicat Input';
                $des="Click Add Branch ";
                $rem="Branch update UnSuccess ";
                include '../include/_audi_log.php';
                header("location:branch");
            }
        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Branch Already Exist';
            $des="Click Update Branch ";
            $rem="Branch Update UnSuccess ";
            include '../include/_audi_log.php';
            header("location:branch");
        }
    }else{
        $_SESSION['icon']='info';
        $_SESSION['status']= 'Enter Input Carefully';
        $des="Click update Branch ";
        $rem="Branch Update UnSuccess ";
        include '../include/_audi_log.php';
        header("location:branch");

    }
}

//branch Edit end

// branch_delete start
if(isset($_GET['bid'])){
    $branch_id = $_GET['bid'];
    $check_branch_data = mysqli_num_rows(mysqli_query($conn, "select * from `branch` where `branch_code`='$branch_id'"));
    if($check_branch_data >=1){
        $sql_delete_b = mysqli_query($conn,"delete from `branch` where `branch_code`='$branch_id'");
        if($sql_delete_b){
            $_SESSION['icon']='success';
            $_SESSION['status']= 'Branch Details Deleted...';
            $des="Click Delete Branch ";
            $rem="Branch Delete Success ";
            include '../include/_audi_log.php';
            header("location:branch");
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']= 'Branch Details Not Deleted...';
            $des="Click Delete Branch ";
            $rem="Branch Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:branch");
        }
    }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'No Data Exist...';
            $des="Click Delete Branch ";
            $rem="Branch Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:branch");
    }
}
// branch_delete end

//end Branch Setup

// Start Department setup

// department insert start

if(isset($_POST['dept_insrt'])){
    $dept = $_POST['dept_name'];
    if($dept!=""){

        $check_bpt_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `department` where `department_name`='$dept'"));
        if($check_bpt_dublicate<1){
            $dep_id = 'D-'.time();

            $insert_depart_sql = mysqli_query($conn, "insert into `department`(`department_code`, `department_name`) values ('$dep_id','$dept')");
            if($insert_depart_sql){
                $_SESSION['icon']='success';
                $_SESSION['status']= 'Departmnet Added...';
                $des="Click Add Department ";
                $rem="Department Add Success ";
                include '../include/_audi_log.php';
                header("location:department");

            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Departmnet Not Added...';
                $des="Click Add Department ";
                $rem="Department Add UnSuccess ";
                include '../include/_audi_log.php';
                header("location:department");
            }
        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Departmnet Already Exist...';
            $des="Click Add Department ";
            $rem="Department Add UnSuccess ";
            include '../include/_audi_log.php';
            header("location:department");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click Add Department ";
        $rem="Department Add UnSuccess ";
        include '../include/_audi_log.php';
        header("location:department");
    }

}

// department insert end

// department edit start
if(isset($_POST['dept_update'])){
    $dept = $_POST['updept_name'];
    $dep_id = $_POST['edit_dp_id'];
    if($dept!="" && $dep_id!=""){
        $sql_chek_data =mysqli_query($conn, "select * from `department` where `department_code`='$dep_id'");
     
        $dp_data = mysqli_fetch_assoc($sql_chek_data);
        if($dp_data['department_name']!=$dept){
            $check_bpt_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `department` where `department_name`='$dept'"));
            if($check_bpt_dublicate  <1){
                
    
                $insert_depart_sql = mysqli_query($conn, "update `department` set `department_name`='$dept' where `department_code`='$dep_id'");
                if($insert_depart_sql){
                    $_SESSION['icon']='success';
                    $_SESSION['status']= 'Department updated...';
                    $des="Click update Department ";
                    $rem="Department update Success ";
                    include '../include/_audi_log.php';
                    header("location:department");
    
                }else{
                    $_SESSION['icon']='error';
                    $_SESSION['status']= 'Department Not updated...';
                    $des="Click update Department ";
                    $rem="Department update UnSuccess ";
                    include '../include/_audi_log.php';
                    header("location:department");
                }
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Dublicate Department not Allowed..';
                $des="Click update Department ";
                $rem="Department update UnSuccess ";
                include '../include/_audi_log.php';
                header("location:department");
            }

        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Departmnet Exist...';
            $des="Click update Department ";
            $rem="Department update UnSuccess ";
            include '../include/_audi_log.php';
            header("location:department");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click update Department ";
        $rem="Department update UnSuccess ";
        include '../include/_audi_log.php';
        header("location:department");
    }

}



// department edit end
//department delete start
if(isset($_GET['did'])){
    $dept_id = $_GET['did'];
    $check_department_data = mysqli_num_rows(mysqli_query($conn, "select * from `department` where `department_code`='$dept_id'"));
    if($check_department_data >=1){
        $sql_delete_d = mysqli_query($conn,"delete from `department` where `department_code`='$dept_id'");
        if($sql_delete_d){
            $_SESSION['icon']='success';
            $_SESSION['status']= 'Department Details Deleted...';
            $des="Click Delete Department ";
            $rem="Department Delete Success ";
            include '../include/_audi_log.php';
            header("location:department");
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']= 'Department Details Not Deleted...';
            $des="Click Delete Department ";
            $rem="Department Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:department");
        }
    }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'No Data Exist...';
            $des="Click Delete Department ";
            $rem="Department Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:department");
    }
}


//department delete start




// End Department setup

// Start SubDepartment setup

// subdepartment insert start

if(isset($_POST['sub_dept'])){
    $subdept = $_POST['subdept_name'];
    
    if($subdept!=""){

        $check_bpt_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `subdepartment` where `subdepartment_name`='$subdept'"));
        if($check_bpt_dublicate<1){
            $subdep_id = 'SD-'.time();

            $insert_subdepart_sql = mysqli_query($conn, "insert into `subdepartment`(`subdepartment_code`, `subdepartment_name`) values ('$subdep_id','$subdept')");
            if($insert_subdepart_sql){
                $_SESSION['icon']='success';
                $_SESSION['status']= 'SubDepartmnet Added...';
                $des="Click Add SubDepartment ";
                $rem="SubDepartment Add Success ";
                include '../include/_audi_log.php';
                header("location:sub-department");

            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'SubDepartmnet Not Added...';
                $des="Click Add SubDepartment ";
                $rem="SubDepartment Add UnSuccess ";
                include '../include/_audi_log.php';
                header("location:sub-department");
            }
        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'SubDepartmnet Already Exist...';
            $des="Click Add SubDepartment ";
            $rem="SubDepartment Add UnSuccess ";
            include '../include/_audi_log.php';
            header("location:sub-department");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click Add SubDepartment ";
        $rem="SubDepartment Add UnSuccess ";
        include '../include/_audi_log.php';
        header("location:sub-department");
    }

}

// subdepartment insert end

// subdepartment edit start
if(isset($_POST['upsub_dept'])){
    $subdept = $_POST['upsubdept_name'];
    $subdep_id = $_POST['edit_id'];
    if($subdept!="" && $subdep_id!=""){
        $sql_chek_data =mysqli_query($conn, "select * from `subdepartment` where `subdepartment_code`='$subdep_id'");
     
        $subdp_data = mysqli_fetch_assoc($sql_chek_data);
        if($subdp_data['subdepartment_name']!=$subdept){
            $check_subbpt_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `subdepartment` where `subdepartment_name`='$subdept'"));
            if($check_subbpt_dublicate  <1){
                
    
                $insert_depart_sql = mysqli_query($conn, "update `subdepartment` set `subdepartment_name`='$subdept' where `subdepartment_code`='$subdep_id'");
                if($insert_depart_sql){
                    $_SESSION['icon']='success';
                    $_SESSION['status']= 'SubDepartment updated...';
                    $des="Click update SubDepartment ";
                    $rem="SubDepartment update Success ";
                    include '../include/_audi_log.php';
                    header("location:sub-department");
    
                }else{
                    $_SESSION['icon']='error';
                    $_SESSION['status']= 'SubDepartment Not updated...';
                    $des="Click update SubDepartment ";
                    $rem="SubDepartment update UnSuccess ";
                    include '../include/_audi_log.php';
                    header("location:sub-department");
                }
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Dublicate SubDepartment not Allowed..';
                $des="Click update SubDepartment ";
                $rem="SubDepartment update UnSuccess ";
                include '../include/_audi_log.php';
                header("location:sub-department");
            }

        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'SubDepartmnet Exist...';
            $des="Click update SubDepartment ";
            $rem="SubDepartment update UnSuccess ";
            include '../include/_audi_log.php';
            header("location:sub-department");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click update SubDepartment ";
        $rem="SubDepartment update UnSuccess ";
        include '../include/_audi_log.php';
        header("location:sub-department");
    }

}



// subdepartment edit end
//subdepartment delete start
if(isset($_GET['sub_dp_id'])){
    $subdept_id = $_GET['sub_dp_id'];
    $check_subdepartment_data = mysqli_num_rows(mysqli_query($conn, "select * from `subdepartment` where `subdepartment_code`='$subdept_id'"));
    if($check_subdepartment_data >=1){
        $sql_delete_sd = mysqli_query($conn,"delete from `subdepartment` where `subdepartment_code`='$subdept_id'");
        if($sql_delete_sd){
            $_SESSION['icon']='success';
            $_SESSION['status']= 'SubDepartment Details Deleted...';
            $des="Click Delete SubDepartment ";
            $rem="SubDepartment Delete Success ";
            include '../include/_audi_log.php';
            header("location:sub-department");
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']= 'SubDepartment Details Not Deleted...';
            $des="Click Delete SubDepartment ";
            $rem="SubDepartment Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:sub-department");
        }
    }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'No Data Exist...';
            $des="Click Delete SubDepartment ";
            $rem="SubDepartment Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:sub-department");
    }
}


// Subdepartment delete start

// End SubDepartment setup



// Start Designation setup

// Designation insert start

if(isset($_POST['desig_sub'])){
    $designation = $_POST['degig'];
    
    if($designation!=""){

        $check_bpt_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `designation` where `designation`='$designation'"));
        if($check_bpt_dublicate<1){
            $desig_id = 'DES-'.time();

            $insert_designation_sql = mysqli_query($conn, "insert into `designation`(`designation_code`, `designation`) values ('$desig_id','$designation')");
            if($insert_designation_sql){
                $_SESSION['icon']='success';
                $_SESSION['status']= 'Designation Added...';
                $des="Click Add Designation ";
                $rem="Designation Add Success ";
                include '../include/_audi_log.php';
                header("location:designation");

            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Designation Not Added...';
                $des="Click Add Designation ";
                $rem="Designation Add UnSuccess ";
                include '../include/_audi_log.php';
                header("location:designation");
            }
        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Designation Already Exist...';
            $des="Click Add Designation ";
            $rem="SubDepartment Add UnSuccess ";
            include '../include/_audi_log.php';
            header("location:designation");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click Add Designation ";
        $rem="Designation Add UnSuccess ";
        include '../include/_audi_log.php';
        header("location:designation");
    }

}

// Designation insert end

// Designation edit start
if(isset($_POST['edesig_sub'])){
    $desig_u = $_POST['degig_ed'];
    $desig_id = $_POST['edit_id'];
    if($desig_u!="" && $desig_id!=""){
        $sql_chek_data =mysqli_query($conn, "select * from `designation` where `designation_code`='$desig_id'");
     
        $desig_data = mysqli_fetch_assoc($sql_chek_data);
        if($desig_data['designation']!=$desig_u){
            $check_desig_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `designation` where `designation`='$desig_u'"));
            if($check_desig_dublicate  <1){
                
    
                $update_depart_sql = mysqli_query($conn, "update `designation` set `designation`='$desig_u' where `designation_code`='$desig_id'");
                if($update_depart_sql){
                    $_SESSION['icon']='success';
                    $_SESSION['status']= 'Designation updated...';
                    $des="Click update Designation ";
                    $rem="Designation update Success ";
                    include '../include/_audi_log.php';
                    header("location:designation");
    
                }else{
                    $_SESSION['icon']='error';
                    $_SESSION['status']= 'Designation Not updated...';
                    $des="Click update Designation ";
                    $rem="Designation update UnSuccess ";
                    include '../include/_audi_log.php';
                    header("location:designation");
                }
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Dublicate Designation not Allowed..';
                $des="Click update Designation ";
                $rem="Designation update UnSuccess ";
                include '../include/_audi_log.php';
                header("location:designation");
            }

        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Designation Exist...';
            $des="Click update Designation ";
            $rem="Designation update UnSuccess ";
            include '../include/_audi_log.php';
            header("location:designation");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click update Designation ";
        $rem="Designation update UnSuccess ";
        include '../include/_audi_log.php';
        header("location:designation");
    }

}



// Designation edit end
//Designation delete start
if(isset($_GET['dsig_id'])){
    $design_id = $_GET['dsig_id'];
    $check_designation_data = mysqli_num_rows(mysqli_query($conn, "select * from `designation` where `designation_code`='$design_id'"));
    if($check_designation_data >=1){
        $sql_delete_sd = mysqli_query($conn,"delete from `designation` where `designation_code`='$design_id'");
        if($sql_delete_sd){
            $_SESSION['icon']='success';
            $_SESSION['status']= 'Designation Details Deleted...';
            $des="Click Delete Designation ";
            $rem="Designation Delete Success ";
            include '../include/_audi_log.php';
            header("location:designation");
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']= 'Designation Details Not Deleted...';
            $des="Click Delete Designation ";
            $rem="Designation Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:designation");
        }
    }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'No Data Exist...';
            $des="Click Delete Designation ";
            $rem="Designation Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:designation");
    }
}


// Designation delete start

// End Designation setup

// Start Gread_Setup setup

// Gread_Setup insert start

if(isset($_POST['grade_sub'])){
    $grade = $_POST['grade_in'];
    
    if($grade!=""){

        $check_bpt_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `grade` where `grade`='$grade'"));
        if($check_bpt_dublicate<1){
            $grade_id = 'GRD-'.time();

            $insert_grade_sql = mysqli_query($conn, "insert into `grade`(`grade_code`, `grade`) values ('$grade_id','$grade')");
            if($insert_grade_sql){
                $_SESSION['icon']='success';
                $_SESSION['status']= 'Grade Added...';
                $des="Click Add Grade ";
                $rem="Grade Add Success ";
                include '../include/_audi_log.php';
                header("location:grade");

            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Grade Not Added...';
                $des="Click Add Grade ";
                $rem="Grade Add UnSuccess ";
                include '../include/_audi_log.php';
                header("location:grade");
            }
        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Grade Already Exist...';
            $des="Click Add Grade ";
            $rem="SubDepartment Add UnSuccess ";
            include '../include/_audi_log.php';
            header("location:grade");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click Add Grade ";
        $rem="Grade Add UnSuccess ";
        include '../include/_audi_log.php';
        header("location:grade");
    }

}

// Gread_Setup insert end

// Gread_Setup edit start
if(isset($_POST['UPgrade_sub'])){
    $grade_u = $_POST['Upgrade_in'];
    $grade_id = $_POST['edit_id'];
    if($grade_u!="" && $grade_id!=""){
        $sql_chek_data =mysqli_query($conn, "select * from `grade` where `grade_code`='$grade_id'");
     
        $grade_data = mysqli_fetch_assoc($sql_chek_data);
        if($grade_data['grade']!=$grade_u){
            $check_grade_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `grade` where `grade`='$grade_u'"));
            if($check_grade_dublicate  <1){
                
    
                $update_grade_sql = mysqli_query($conn, "update `grade` set `grade`='$grade_u' where `grade_code`='$grade_id'");
                if($update_grade_sql){
                    $_SESSION['icon']='success';
                    $_SESSION['status']= 'Grade updated...';
                    $des="Click update Grade ";
                    $rem="Grade update Success ";
                    include '../include/_audi_log.php';
                    header("location:grade");
    
                }else{
                    $_SESSION['icon']='error';
                    $_SESSION['status']= 'Grade Not updated...';
                    $des="Click update Grade ";
                    $rem="Grade update UnSuccess ";
                    include '../include/_audi_log.php';
                    header("location:grade");
                }
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Dublicate Grade not Allowed..';
                $des="Click update Grade ";
                $rem="Grade update UnSuccess ";
                include '../include/_audi_log.php';
                header("location:grade");
            }

        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Grade Exist...';
            $des="Click update Grade ";
            $rem="Grade update UnSuccess ";
            include '../include/_audi_log.php';
            header("location:grade");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click update Grade ";
        $rem="Grade update UnSuccess ";
        include '../include/_audi_log.php';
        header("location:grade");
    }

}



// Gread_Setup edit end
//Gread_Setup delete start
if(isset($_GET['gr_id'])){
    $grade_id = $_GET['gr_id'];
    $check_grade_data = mysqli_num_rows(mysqli_query($conn, "select * from `grade` where `grade_code`='$grade_id'"));
    if($check_grade_data >=1){
        $sql_delete_gr = mysqli_query($conn,"delete from `grade` where `grade_code`='$grade_id'");
        if($sql_delete_gr){
            $_SESSION['icon']='success';
            $_SESSION['status']= 'Grade Details Deleted...';
            $des="Click Delete Grade ";
            $rem="Grade Delete Success ";
            include '../include/_audi_log.php';
            header("location:grade");
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']= 'Grade Details Not Deleted...';
            $des="Click Delete Grade ";
            $rem="Grade Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:grade");
        }
    }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'No Data Exist...';
            $des="Click Delete Grade ";
            $rem="Grade Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:grade");
    }
}


// Gread_Setup delete start
// End Gread_Setup setup

// Start location_Setup setup
// location_Setup insert start

if(isset($_POST['location_sub'])){
    $locate = $_POST['loca_in'];
    
    if($locate!=""){

        $check_loc_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `location` where `location`='$locate'"));
        if($check_loc_dublicate<1){
            $loc_id = 'LOC-'.time();

            $insert_grade_sql = mysqli_query($conn, "insert into `location`(`location_code`, `location`) values ('$loc_id','$locate')");
            if($insert_grade_sql){
                $_SESSION['icon']='success';
                $_SESSION['status']= 'Location Added...';
                $des="Click Add Location ";
                $rem="Location Add Success ";
                include '../include/_audi_log.php';
                header("location:location");

            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Location Not Added...';
                $des="Click Add Location ";
                $rem="Location Add UnSuccess ";
                include '../include/_audi_log.php';
                header("location:location");
            }
        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Location Already Exist...';
            $des="Click Add Location ";
            $rem="SubDepartment Add UnSuccess ";
            include '../include/_audi_log.php';
            header("location:location");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click Add Location ";
        $rem="Location Add UnSuccess ";
        include '../include/_audi_log.php';
        header("location:location");
    }

}

// location_Setup insert end

// location_Setup edit start
if(isset($_POST['Uplocation_sub'])){
    $locat_u = $_POST['Uploca_in'];
    $locate_id = $_POST['edit_id'];
    if($locat_u!="" && $locate_id!=""){
        $sql_locate =mysqli_query($conn, "select * from `location` where `location_code`='$locate_id'");
     
        $location_data = mysqli_fetch_assoc($sql_locate);
        if($location_data['location']!=$locat_u){
            $check_location_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `location` where `location`='$locat_u'"));
            if($check_location_dublicate  <1){
                
    
                $update_location_sql = mysqli_query($conn, "update `location` set `location`='$locat_u' where `location_code`='$locate_id'");
                if($update_location_sql){
                    $_SESSION['icon']='success';
                    $_SESSION['status']= 'Location updated...';
                    $des="Click update Location ";
                    $rem="Location update Success ";
                    include '../include/_audi_log.php';
                    header("location:location");
    
                }else{
                    $_SESSION['icon']='error';
                    $_SESSION['status']= 'Location Not updated...';
                    $des="Click update Location ";
                    $rem="Location update UnSuccess ";
                    include '../include/_audi_log.php';
                    header("location:location");
                }
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Dublicate Location not Allowed..';
                $des="Click update Location ";
                $rem="Location update UnSuccess ";
                include '../include/_audi_log.php';
                // echo $locat_u;
                header("location:location");
            }

        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Location Exist...';
            $des="Click update Location ";
            $rem="Location update UnSuccess ";
            include '../include/_audi_log.php';
            header("location:location");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click update Location ";
        $rem="Location update UnSuccess ";
        include '../include/_audi_log.php';
        header("location:location");
    }

}



// location_Setup edit end
//location_Setup delete start
if(isset($_GET['loct_id'])){
    $location_id = $_GET['loct_id'];
    $check_locat_data = mysqli_num_rows(mysqli_query($conn, "select * from `location` where `location_code`='$location_id'"));
    if($check_locat_data >=1){
        $sql_delete_lo = mysqli_query($conn,"delete from `location` where `location_code`='$location_id'");
        if($sql_delete_lo){
            $_SESSION['icon']='success';
            $_SESSION['status']= 'Location Details Deleted...';
            $des="Click Delete Location ";
            $rem="Location Delete Success ";
            include '../include/_audi_log.php';
            header("location:location");
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']= 'Location Details Not Deleted...';
            $des="Click Delete Location ";
            $rem="Location Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:location");
        }
    }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'No Data Exist...';
            $des="Click Delete Location ";
            $rem="Location Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:location");
    }
}


// location_Setup delete start

// End location_Setup setup

// Start Employe_type_Setup setup
// Employe_type_Setup insert start

if(isset($_POST['emp_type_sub'])){
    $emp_type = $_POST['emp_type_in'];
    
    if($emp_type!=""){

        $check_loc_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `employetype` where `emptype`='$emp_type'"));
        if($check_loc_dublicate<1){
            $lemp_type_id = 'EMPT-'.time();

            $insert_grade_sql = mysqli_query($conn, "insert into `employetype`(`emptype_code`, `emptype`) values ('$lemp_type_id','$emp_type')");
            if($insert_grade_sql){
                $_SESSION['icon']='success';
                $_SESSION['status']= 'Employe Type Added...';
                $des="Click Add Employe Type ";
                $rem="Employe Type Add Success ";
                include '../include/_audi_log.php';
                header("location:emp-type");

            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Employe Type Not Added...';
                $des="Click Add Employe Type ";
                $rem="Employe Type Add UnSuccess ";
                include '../include/_audi_log.php';
                header("location:emp-type");
            }
        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Employe Type Already Exist...';
            $des="Click Add Employe Type ";
            $rem="SubDepartment Add UnSuccess ";
            include '../include/_audi_log.php';
            header("location:emp-type");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click Add Employe Type ";
        $rem="Employe Type Add UnSuccess ";
        include '../include/_audi_log.php';
        header("location:emp-type");
    }

}

// Employe_type_Setup insert end

// Employe_type_Setup edit start
if(isset($_POST['upemp_type_sub'])){
    $emp_t = $_POST['upemp_type_in'];
    $emp_t_id = $_POST['emp_t_edit_id'];
    if($emp_t!="" && $emp_t_id!=""){
        $sql_locate =mysqli_query($conn, "select * from `employetype` where `emptype_code`='$emp_t_id'");
     
        $location_data = mysqli_fetch_assoc($sql_locate);
        if($location_data['emptype']!=$emp_t){
            $check_location_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `employetype` where `emptype`='$emp_t'"));
            if($check_location_dublicate  <1){
                
    
                $update_location_sql = mysqli_query($conn, "update `employetype` set `emptype`='$emp_t' where `emptype_code`='$emp_t_id'");
                if($update_location_sql){
                    $_SESSION['icon']='success';
                    $_SESSION['status']= 'Employe Type updated...';
                    $des="Click update Employe Type ";
                    $rem="Employe Type update Success ";
                    include '../include/_audi_log.php';
                    header("location:emp-type");
    
                }else{
                    $_SESSION['icon']='error';
                    $_SESSION['status']= 'Employe Type Not updated...';
                    $des="Click update Employe Type ";
                    $rem="Employe Type update UnSuccess ";
                    include '../include/_audi_log.php';
                    header("location:emp-type");
                }
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Dublicate Employe Type not Allowed..';
                $des="Click update Employe Type ";
                $rem="Employe Type update UnSuccess ";
                include '../include/_audi_log.php';
                // echo $locat_u;
                header("location:emp-type");
            }

        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Employe Type Exist...';
            $des="Click update Employe Type ";
            $rem="Employe Type update UnSuccess ";
            include '../include/_audi_log.php';
            header("location:emp-type");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click update Employe Type ";
        $rem="Employe Type update UnSuccess ";
        include '../include/_audi_log.php';
        header("location:emp-type");
    }

}



// Employe_type_Setup edit end
//Employe_type_Setup delete start
if(isset($_GET['emp_t'])){
    $emp_t_id = $_GET['emp_t'];
    $check_emp_t_data = mysqli_num_rows(mysqli_query($conn, "select * from `employetype` where `emptype_code`='$emp_t_id'"));
    if($check_emp_t_data >=1){
        $sql_delete_lo = mysqli_query($conn,"delete from `employetype` where `emptype_code`='$emp_t_id'");
        if($sql_delete_lo){
            $_SESSION['icon']='success';
            $_SESSION['status']= 'Employe Type Details Deleted...';
            $des="Click Delete Employe Type ";
            $rem="Employe Type Delete Success ";
            include '../include/_audi_log.php';
            header("location:emp-type");
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']= 'Employe Type Details Not Deleted...';
            $des="Click Delete Employe Type ";
            $rem="Employe Type Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:emp-type");
        }
    }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'No Data Exist...';
            $des="Click Delete Employe Type ";
            $rem="Employe Type Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:emp-type");
    }
}


// Employe_type_Setup delete start

// End Employe_type_Setup setup

// Start Employe_category_Setup setup
// Employe_category_Setup insert start

if(isset($_POST['emp_cate_sub'])){
    $emp_cat = $_POST['emp_cat_in'];
    
    if($emp_cat!=""){

        $check_loc_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `empcategory` where `empcat`='$emp_cat'"));
        if($check_loc_dublicate<1){
            $emp_cat_id = 'EMPC-'.time();

            $insert_grade_sql = mysqli_query($conn, "insert into `empcategory`(`empcat_code`, `empcat`) values ('$emp_cat_id','$emp_cat')");
            if($insert_grade_sql){
                $_SESSION['icon']='success';
                $_SESSION['status']= 'Employe Category Added...';
                $des="Click Add Employe Category ";
                $rem="Employe Category Add Success ";
                include '../include/_audi_log.php';
                header("location:emp-cat");

            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Employe Category Not Added...';
                $des="Click Add Employe Category ";
                $rem="Employe Category Add UnSuccess ";
                include '../include/_audi_log.php';
                header("location:emp-cat");
            }
        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Employe Category Already Exist...';
            $des="Click Add Employe Category ";
            $rem="SubDepartment Add UnSuccess ";
            include '../include/_audi_log.php';
            header("location:emp-cat");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click Add Employe Category ";
        $rem="Employe Category Add UnSuccess ";
        include '../include/_audi_log.php';
        header("location:emp-cat");
    }

}

// Employe_category_Setup insert end

// Employe_category_Setup edit start
if(isset($_POST['upemp_cate_sub'])){
    $emp_cat = $_POST['upemp_cat_in'];
    $emp_cat_id = $_POST['emp_cat_id'];
    if($emp_cat!="" && $emp_cat_id!=""){
        $sql_locate =mysqli_query($conn, "select * from `empcategory` where `empcat_code`='$emp_cat_id'");
     
        $location_data = mysqli_fetch_assoc($sql_locate);
        if($location_data['empcat']!=$emp_cat){
            $check_emp_cat_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `empcategory` where `empcat`='$emp_cat'"));
            if($check_emp_cat_dublicate  <1){
                
    
                $update_empcat_sql = mysqli_query($conn, "update `empcategory` set `empcat`='$emp_cat' where `empcat_code`='$emp_cat_id'");
                if($update_empcat_sql){
                    $_SESSION['icon']='success';
                    $_SESSION['status']= 'Employe Category updated...';
                    $des="Click update Employe Category ";
                    $rem="Employe Category update Success ";
                    include '../include/_audi_log.php';
                    header("location:emp-cat");
    
                }else{
                    $_SESSION['icon']='error';
                    $_SESSION['status']= 'Employe Category Not updated...';
                    $des="Click update Employe Category ";
                    $rem="Employe Category update UnSuccess ";
                    include '../include/_audi_log.php';
                    header("location:emp-cat");
                }
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Dublicate Employe Category not Allowed..';
                $des="Click update Employe Category ";
                $rem="Employe Category update UnSuccess ";
                include '../include/_audi_log.php';
                // echo $locat_u;
                header("location:emp-cat");
            }

        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Employe Category Exist...';
            $des="Click update Employe Category ";
            $rem="Employe Category update UnSuccess ";
            include '../include/_audi_log.php';
            header("location:emp-cat");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click update Employe Category ";
        $rem="Employe Category update UnSuccess ";
        include '../include/_audi_log.php';
        header("location:emp-cat");
    }

}



// Employe_category_Setup edit end
//Employe_category_Setup delete start
if(isset($_GET['emp_cat'])){
    $emp_cat_id = $_GET['emp_cat'];
    $check_emp_cat_data = mysqli_num_rows(mysqli_query($conn, "select * from `empcategory` where `empcat_code`='$emp_cat_id'"));
    if($check_emp_cat_data >=1){
        $sql_delete_lo = mysqli_query($conn,"delete from `empcategory` where `empcat_code`='$emp_cat_id'");
        if($sql_delete_lo){
            $_SESSION['icon']='success';
            $_SESSION['status']= 'Employe Category Details Deleted...';
            $des="Click Delete Employe Category ";
            $rem="Employe Category Delete Success ";
            include '../include/_audi_log.php';
            header("location:emp-cat");
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']= 'Employe Category Details Not Deleted...';
            $des="Click Delete Employe Category ";
            $rem="Employe Category Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:emp-cat");
        }
    }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'No Data Exist...';
            $des="Click Delete Employe Category ";
            $rem="Employe Category Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:emp-cat");
    }
}


// Employe_category_Setup delete start

// End Employe_category_Setup setup

// Start visitor Type setup
// visitor Type insert start

if(isset($_POST['visit_type_sub'])){
    $visit_type = $_POST['visit_type_in'];
    
    if($visit_type!=""){

        $check_loc_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `vsitor_type` where `type_name`='$visit_type'"));
        if($check_loc_dublicate<1){
            $visit_type_id = 'VMPC-'.time();

            $insert_type_sql = mysqli_query($conn, "insert into `vsitor_type`(`type_id`, `type_name`) values ('$visit_type_id','$visit_type')");
            if($insert_type_sql!=""){
                $_SESSION['icon']='success';
                $_SESSION['status']= 'Visitor Type Added...';
                $des="Click Add Visitor Type ";
                $rem="Visitor Type Add Success ";
                include '../include/_audi_log.php';
                header("location:visitor-type");

            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Visitor Type Not Added...';
                $des="Click Add Visitor Type ";
                $rem="Visitor Type Add UnSuccess ";
                include '../include/_audi_log.php';
                header("location:visitor-type");
            }
        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Visitor Type Already Exist...';
            $des="Click Add Visitor Type ";
            $rem="Visitor Type Add UnSuccess ";
            include '../include/_audi_log.php';
            header("location:visitor-type");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click Add Visitor Type ";
        $rem="Visitor Type Add UnSuccess ";
        include '../include/_audi_log.php';
        header("location:visitor-type");
    }

}

// Visitor Type insert end

// Visitor Type edit start
if(isset($_POST['upvisit_type_sub'])){
    $visit_type = $_POST['upvisit_type_in'];
    $visit_type_id = $_POST['visit_t_edit_id'];
    if($visit_type!="" && $visit_type_id!=""){
        $sql_locate =mysqli_query($conn, "select * from `vsitor_type` where `type_id`='$visit_type_id'");
     
        $location_data = mysqli_fetch_assoc($sql_locate);
        if($location_data['type_name']!=$visit_type){
            $check_visit_type_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `vsitor_type` where `type_name`='$visit_type'"));
            if($check_visit_type_dublicate  <1){
                
    
                $update_empcat_sql = mysqli_query($conn, "update `vsitor_type` set `type_name`='$visit_type' where `type_id`='$visit_type_id'");
                if($update_empcat_sql){
                    $_SESSION['icon']='success';
                    $_SESSION['status']= 'Visitor Type updated...';
                    $des="Click update Visitor Type ";
                    $rem="Visitor Type update Success ";
                    include '../include/_audi_log.php';
                    header("location:visitor-type");
    
                }else{
                    $_SESSION['icon']='error';
                    $_SESSION['status']= 'Visitor Type Not updated...';
                    $des="Click update Visitor Type ";
                    $rem="Visitor Type update UnSuccess ";
                    include '../include/_audi_log.php';
                    header("location:visitor-type");
                }
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Dublicate Visitor Type not Allowed..';
                $des="Click update Visitor Type ";
                $rem="Visitor Type update UnSuccess ";
                include '../include/_audi_log.php';
                // echo $locat_u;
                header("location:visitor-type");
            }

        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Visitor Type Exist...';
            $des="Click update Visitor Type ";
            $rem="Vsitor Type update UnSuccess ";
            include '../include/_audi_log.php';
            header("location:visitor-type");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click update Visitor Type ";
        $rem="Vsitor Type update UnSuccess ";
        include '../include/_audi_log.php';
        header("location:visitor-type");
    }

}



// Visitor Type edit end
//Visitor Type delete start
if(isset($_GET['visit_t'])){
    $visit_type_id = $_GET['visit_t'];
    $check_visit_type_data = mysqli_num_rows(mysqli_query($conn, "select * from `vsitor_type` where `type_id`='$visit_type_id'"));
    if($check_visit_type_data >=1){
        $sql_delete_lo = mysqli_query($conn,"delete from `vsitor_type` where `type_id`='$visit_type_id'");
        if($sql_delete_lo){
            $_SESSION['icon']='success';
            $_SESSION['status']= 'Visitor Type  Deleted...';
            $des="Click Delete Visitor Type ";
            $rem="Visitor Type Delete Success ";
            include '../include/_audi_log.php';
            header("location:visitor-type");
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']= 'Visitor Type  Not Deleted...';
            $des="Click Delete Visitor Type ";
            $rem="Visitor Type Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:visitor-type");
        }
    }else{
        $_SESSION['icon']='info';
        $_SESSION['status']= 'No Data Exist...';
        $des="Click Delete Visitor Type ";
        $rem="Visitor Type Delete UnSuccess ";
        include '../include/_audi_log.php';
        header("location:visitor-type");
    }
}


// Visitor Type delete start

// Visitor Type setup

// Start Visit Purpose setup
// Visit Purpose insert start

if(isset($_POST['visit_pur_sub'])){
    $visit_pur = $_POST['visit_pur_in'];
    
    if($visit_pur!=""){

        $check_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `visit_purpose` where `purpose`='$visit_pur'"));
        if($check_dublicate<1){
            $visit_type_id = 'VP-'.time();

            $insert_type_sql = mysqli_query($conn, "insert into `visit_purpose`(`purpose_id`, `purpose`) values ('$visit_type_id','$visit_pur')");
            if($insert_type_sql!=""){
                $_SESSION['icon']='success';
                $_SESSION['status']= 'Visit Purpose Added...';
                $des="Click Add Visit Purpose ";
                $rem="Visit Purpose Add Success ";
                include '../include/_audi_log.php';
                header("location:visitor-purpose");

            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Visit Purpose Not Added...';
                $des="Click Add Visit Purpose ";
                $rem="Visit Purpose Add UnSuccess ";
                include '../include/_audi_log.php';
                header("location:visitor-purpose");
            }
        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Visit Purpose Already Exist...';
            $des="Click Add Visit Purpose ";
            $rem="Visit Purpose Add UnSuccess ";
            include '../include/_audi_log.php';
            header("location:visitor-purpose");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click Add Visit Purpose ";
        $rem="Visit Purpose Add UnSuccess ";
        include '../include/_audi_log.php';
        header("location:visitor-purpose");
    }

}

// Visit Purpose insert end

// Visit Purpose edit start
if(isset($_POST['upvisit_pur_sub'])){
    $visit_pur = $_POST['upvisit_pur_in'];
    $visit_pur_id = $_POST['visit_p_edit_id'];
    if($visit_pur!="" && $visit_pur_id!=""){
        $sql_locate =mysqli_query($conn, "select * from `visit_purpose` where `purpose_id`='$visit_pur_id'");
     
        $location_data = mysqli_fetch_assoc($sql_locate);
        if($location_data['type_name']!=$visit_pur){
            $check_visit_type_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `visit_purpose` where `purpose`='$visit_pur'"));
            if($check_visit_type_dublicate  <1){
                
    
                $update_empcat_sql = mysqli_query($conn, "update `visit_purpose` set `purpose`='$visit_pur' where `purpose_id`='$visit_pur_id'");
                if($update_empcat_sql){
                    $_SESSION['icon']='success';
                    $_SESSION['status']= 'Visit Purpose updated...';
                    $des="Click update Visit Purpose ";
                    $rem="Visit Purpose update Success ";
                    include '../include/_audi_log.php';
                    header("location:visitor-purpose");
    
                }else{
                    $_SESSION['icon']='error';
                    $_SESSION['status']= 'Visit Purpose Not updated...';
                    $des="Click update Visit Purpose";
                    $rem="Visit Purpose update UnSuccess ";
                    include '../include/_audi_log.php';
                    header("location:visitor-purpose");
                }
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Dublicate Visit Purpose not Allowed..';
                $des="Click updateVisit Purpose ";
                $rem="Visit Purpose update UnSuccess ";
                include '../include/_audi_log.php';
                // echo $locat_u;
                header("location:visitor-purpose");
            }

        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Visit Purpose Exist...';
            $des="Click update Visit Purpose ";
            $rem="Visit Purpose update UnSuccess ";
            include '../include/_audi_log.php';
            header("location:visitor-purpose");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click update Visit Purpose ";
        $rem="Visit Purpose update UnSuccess ";
        include '../include/_audi_log.php';
        header("location:visitor-purpose");
    }

}



// Visit Purpose edit end
//Visit Purpose delete start
if(isset($_GET['visit_p'])){
    $visit_pur_id = $_GET['visit_p'];
    
    $check_visit_pur_data = mysqli_num_rows(mysqli_query($conn, "select * from `visit_purpose` where `purpose_id`='$visit_pur_id'"));
    if($check_visit_pur_data >=1){
        $sql_delete_lo = mysqli_query($conn,"delete from `visit_purpose` where `purpose_id`='$visit_pur_id'");
        if($sql_delete_lo){
            $_SESSION['icon']='success';
            $_SESSION['status']= 'Visit Purpose  Deleted...';
            $des="Click Delete Visit Purpose ";
            $rem="Visit Purpose Delete Success ";
            include '../include/_audi_log.php';
            header("location: visitor-purpose");
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']= 'Visit Purpose  Not Deleted...';
            $des="Click Delete Visit Purpose ";
            $rem="Visit Purpose Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:visitor-purpose");
        }
    }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'No Data Exist...';
            $des="Click Delete Visit Purpose ";
            $rem="Visit Purpose Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:visitor-purpose");
    }
}


// Visit Purpose delete start

// Visit Purposesetup





// Start Gate Info setup
// Gate Info insert start

if(isset($_POST['gate_sub'])){
    $gate_no = $_POST['gate_no_in'];
    $gate_info = $_POST['gate_info_in'];
    $branch_id = $_POST['branch_id'];
    
    if($gate_no!=""){

        $check_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `gate_info` where `gate_number`='$gate_no' and `Branch_id`= '$branch_id'"));
        if($check_dublicate<1){
           

            $insert_type_sql = mysqli_query($conn, "insert into `gate_info`(`Branch_id`,`gate_number`, `gate_description`) values ('$branch_id','$gate_no','$gate_info')");
            if($insert_type_sql!=""){
                $_SESSION['icon']='success';
                $_SESSION['status']= 'Gate Info Added...';
                $des="Click Add Gate Info ";
                $rem="Gate Info Add Success ";
                include '../include/_audi_log.php';
                header("location:gate_info");

            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Gate Info Not Added...';
                $des="Click Add Gate Info ";
                $rem="Gate Info Add UnSuccess ";
                include '../include/_audi_log.php';
                header("location:gate_info");
            }
        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Gate Info Already Exist...';
            $des="Click Add Gate Info ";
            $rem="Gate Info Add UnSuccess ";
            include '../include/_audi_log.php';
            header("location:gate_info");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click Add Gate Info ";
        $rem="Gate Info Add UnSuccess ";
        include '../include/_audi_log.php';
        header("location:gate_info");
    }

}

// Gate Info insert end

// Gate Info edit start
if(isset($_POST['upgate_gate_info'])){
    $gate_no = $_POST['upgate_no_in'];
    $gate_info = $_POST['upgate_info_in'];
    $gate_id = $_POST['gate_edit_id'];
    $branch_id = $_POST['branch_id'];
    if($gate_no!="" && $gate_id!=""){
        $sql_locate =mysqli_query($conn, "select * from `gate_info` where `sl_no`='$gate_id'");
     
        $location_data = mysqli_fetch_assoc($sql_locate);
        if($location_data['gate_number']!=$gate_no){
            $check_visit_type_dublicate = mysqli_num_rows(mysqli_query($conn, "select * from `gate_info` where `gate_number`='$gate_no' and `Branch_id`= '$branch_id'"));
            if($check_visit_type_dublicate  <=1){
                
    
                $update_empcat_sql = mysqli_query($conn, "update `gate_info` set `Branch_id`='$branch_id', `gate_number`='$gate_no' , `gate_description`='$gate_info' where `sl_no`='$gate_id'");
                if($update_empcat_sql){
                    $_SESSION['icon']='success';
                    $_SESSION['status']= 'Gate Info updated...';
                    $des="Click update Gate Info ";
                    $rem="Gate Info update Success ";
                    include '../include/_audi_log.php';
                    header("location:gate_info");
    
                }else{
                    $_SESSION['icon']='error';
                    $_SESSION['status']= 'Gate Info Not updated...';
                    $des="Click update Gate Info";
                    $rem="Gate Info update UnSuccess ";
                    include '../include/_audi_log.php';
                    header("location:gate_info");
                }
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Dublicate Gate Info not Allowed..';
                $des="Click update Gate Info ";
                $rem="Gate Info update UnSuccess ";
                include '../include/_audi_log.php';
                // echo $locat_u;
                header("location:gate_info");
            }

        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'Gate Info Exist...';
            $des="Click update Gate Info ";
            $rem="Gate Info update UnSuccess ";
            include '../include/_audi_log.php';
            header("location:gate_info");
        }
    }else{
        $_SESSION['icon']='error';
        $_SESSION['status']= 'Enter Input Carefully....';
        $des="Click update Gate Info ";
        $rem="Gate Info update UnSuccess ";
        include '../include/_audi_log.php';
        header("location:gate_info");
    }

}



// Gate Info edit end
// Gate Info delete start
if(isset($_GET['gate'])){
    $gate_id = $_GET['gate'];
    
    $check_visit_pur_data = mysqli_num_rows(mysqli_query($conn, "select * from `gate_info` where `sl_no`='$gate_id'"));
    if($check_visit_pur_data >=1){
        $sql_delete_lo = mysqli_query($conn,"delete from `gate_info` where `sl_no`='$gate_id'");
        if($sql_delete_lo){
            $_SESSION['icon']='success';
            $_SESSION['status']= 'Gate Info  Deleted...';
            $des="Click Delete Gate Info ";
            $rem=" Gate Info Delete Success ";
            include '../include/_audi_log.php';
            header("location: gate_info");
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']= 'Gate Info  Not Deleted...';
            $des="Click Delete Gate Info ";
            $rem="Gate Info Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:gate_info");
        }
    }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'No Data Exist...';
            $des="Click Delete Gate Info ";
            $rem="Gate Info Delete UnSuccess ";
            include '../include/_audi_log.php';
            header("location:gate_info");
    }
}


// Gate Info delete end
// Gate Info setup

// Important Rules setup
// start Entry Rules

if(isset($_POST['rules_sub'])){
    $rule = $_POST['rules'];
    $rule_details_sql = mysqli_query($conn, "select * from `rules`");
    if(mysqli_num_rows($rule_details_sql)<10 ){

        if($rule!=""){
            $insert_sql = mysqli_query($conn, "insert into `rules`(`rules`, `register_date`) values ('$rule',current_timestamp)");
            if($insert_sql){
                $_SESSION['icon']='success';
                $_SESSION['status']= 'Rule Add Successfull';
                $des="Click Add rules ";
                $rem="Add rules Success ";
                include '../include/_audi_log.php';
                header("location:important_rules");
            }else{
                $_SESSION['icon']='error';
                $_SESSION['status']= 'Rule Not Added';
                $des="Click Add rules ";
                $rem="Add rules UnSuccess ";
                include '../include/_audi_log.php';
                header("location:important_rules");
            }
            
        }else{
            $_SESSION['icon']='info';
            $_SESSION['status']= 'No Data Exist...';
            $des="Click Add rules ";
            $rem="Add rules UnSuccess ";
            include '../include/_audi_log.php';
            header("location:important_rules");
        }
    }else{
        $_SESSION['icon']='info';
        $_SESSION['status']= "Rules Limit Exit.....";
        $des="Click Add rules ";
        $rem="Add rules UnSuccess ";
        include '../include/_audi_log.php';
        header("location:important_rules");
    }
}

// End of Entry Rules
// Start of Rules Update

if(isset($_POST['up_rule'])){
    $rule = $_POST['rules'];
    $id= $_POST['rule_sl'];
    if($rule!="" && $id!=""){
        $insert_sql = mysqli_query($conn, "update `rules` set `rules`='$rule' where `id` ='$id'");
        if($insert_sql){
            $_SESSION['icon']='success';
            $_SESSION['status']= 'Rule Update Successfull';
            $des="Click update rules ";
            $rem="update rules Success ";
            include '../include/_audi_log.php';
            header("location:important_rules");
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']= 'Rule Not Updated';
            $des="Click update rules ";
            $rem="Update rules UnSuccess ";
            include '../include/_audi_log.php';
            header("location:important_rules");
        }

    }else{
        $_SESSION['icon']='info';
        $_SESSION['status']= 'No Data Exist...';
        $des="Click update rules ";
        $rem="Update rules UnSuccess ";
        include '../include/_audi_log.php';
        header("location:important_rules");
    }
}

// End of Rules Update
// Start of Rules Delete
if(isset($_GET['rulid'])){
   
    $id= $_GET['rulid'];
    if($id!=""){
        $insert_sql = mysqli_query($conn, "delete from `rules` where `id` = '$id'");
        if($insert_sql){
            $_SESSION['icon']='success';
            $_SESSION['status']= 'Rule Delete Successfull';
            $des="Click Delete rules ";
            $rem="Delete rules Success ";
            include '../include/_audi_log.php';
            header("location:important_rules");
        }else{
            $_SESSION['icon']='error';
            $_SESSION['status']= 'Rule Not Delete';
            $des="Click Delete rules ";
            $rem="Delete rules UnSuccess ";
            include '../include/_audi_log.php';
            header("location:important_rules");
        }

    }else{
        $_SESSION['icon']='info';
        $_SESSION['status']= 'No Data Exist...';
        $des="Click Delete rules ";
        $rem="Delete rules UnSuccess ";
        include '../include/_audi_log.php';
        header("location:important_rules");
    }
}




// End of Rules Delete
?>