<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head = "User Info";
$des="Page Load User_edit";
$rem="User Edit Page";
include '../include/_audi_log.php';









if(isset($_POST['edit'])){
    if(isset($_POST['edit_id'])){
        
        $uid =$_POST['edit_id'];
        $user_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `uid`='$uid'"));
        if($user_details!=""){
            $emp_id = $user_details['EmployeeId'];
            $sql_emp_data = mysqli_fetch_assoc(mysqli_query($conn,"select * from `eomploye_details` where `EmployeeId`='$emp_id'"));

        }
        
        // audi_log update 
        $des="Page Load to new_user for edit user details";
        $rem="Edit User details";
        include '../include/_audi_log.php'; 

    }
    
    
    
}
if(isset($_POST['uid'])){
        $uid = $_POST['uid'];
        // $emp_name_id  = $_POST['euser_name'];
        // $emp_code =  substr($emp_name_id ,0, strpos($emp_name_id, ' '));
        // $emp_name =  substr($emp_name_id, strpos($emp_name_id, ' ') , strlen($emp_name_id));
        // $u_name= strtoupper($emp_name);
        // $u_no= $_POST['euser_no'];
        
        $u_role = $_POST['euser_role'];
        $u_sts = $_POST['euser_sts'];
        // $u_mob= $_POST['mob_no'];
        
        $check_sql= mysqli_query($conn,"select * from `user` where `uid`='$uid'");
        $check_no_row = mysqli_num_rows($check_sql);
        $fetch_data = mysqli_fetch_assoc($check_sql);

       
        if($check_no_row == 1){
            $uinsert_sql =mysqli_query($conn,"update `user` set `user_role`='$u_role',`user_sts`='$u_sts' where `uid`='$uid'");
            if( $uinsert_sql){
                //  audi_log insert 
                    $des="Click Update User Button";
                    $rem="User details update";
                    include '../include/_audi_log.php';
                    // header("location:user_view");
                    $_SESSION['status']= "User Details Updated.....";
                    $_SESSION['icon'] ="success";
                    header("location:user_view");
            }else{
                    $des="Click Update User Button";
                    $rem="User details not update";
                    include '../include/_audi_log.php';
                    $_SESSION['icon']='error';
                    $_SESSION['status'] = 'User not updated';
                    header("location:user_view");
            }

            // if($emp_code==$fetch_data['EmployeeId']){
            //     if($u_mob==$fetch_data['mobile_no']){
            //         $uinsert_sql =mysqli_query($conn,"update `user` set `EmployeeId`='$emp_code', `name`='$u_name',`user_role`='$u_role',`user_sts`='$u_sts' where `uid`='$uid'");
            //         if($uinsert_sql){
                
            //             // audi_log insert 
            //             $des="Click Update User Button";
            //             $rem="User details update";
            //             include '../include/_audi_log.php';
            //             // header("location:user_view");
            //             $_SESSION['status']= "User Details Updated.....";
            //             $_SESSION['icon'] ="success";
            //             header("location:user_view");
                         
            //         }else{
            //             $des="Click Update User Button";
            //             $rem="User details not update";
            //             include '../include/_audi_log.php';
            //             $_SESSION['icon']='error';
            //             $_SESSION['status'] = 'Invalid Data';
            //             header("location:user_view");
            //         }
            //     }else{
            //         $check_dublicate_no = mysqli_num_rows(mysqli_query($conn,"select * from `user` where `mobile_no`='$u_mob'"));
            //         if($check_dublicate_no<1){
            //             $uinsert_sql =mysqli_query($conn,"update `user` set`EmployeeId`='$emp_code', `name`='$u_name',`mobile_no`='$u_mob',`user_role`='$u_role',`user_sts`='$u_sts' where `uid`='$uid'");
            //             if($uinsert_sql){
                
            //                 // audi_log insert 
            //                 $des="Click Update User Button";
            //                 $rem="User details update";
            //                 include '../include/_audi_log.php';
            //                 // header("location:user_view");
            //                 $_SESSION['status']= "User Details Updated.....";
            //                 $_SESSION['icon'] ="success";
            //                 header("location:user_view");
                             
            //             }else{
            //                 $des="Click Update User Button";
            //                 $rem="User details not update";
            //                 include '../include/_audi_log.php';
            //                 $_SESSION['icon']='error';
            //                 $_SESSION['status'] = 'Invalid Data';
            //                 header("location:user_view");
            //             }
            //         }else{
            //             $des="Click Update User Button";
            //             $rem="User details not update";
            //             include '../include/_audi_log.php';
            //             $_SESSION['icon']='info';
            //             $_SESSION['status'] = 'Dublicate Mobie no';
            //             header("location:user_view");
            //         }
    
            //     }

            // }else{
            //     $check_dublicate_no = mysqli_num_rows(mysqli_query($conn,"select * from `user` where `EmployeeId`='$emp_code'"));
            //     if($check_dublicate_no<1){
            //         if($u_mob==$fetch_data['mobile_no']){
            //             $uinsert_sql =mysqli_query($conn,"update `user` set `EmployeeId`='$emp_code', `name`='$u_name',`user_role`='$u_role',`user_sts`='$u_sts' where `uid`='$uid'");
            //             if($uinsert_sql){
                
            //                 // audi_log insert 
            //                 $des="Click Update User Button";
            //                 $rem="User details update";
            //                 include '../include/_audi_log.php';
            //                 // header("location:user_view");
            //                 $_SESSION['status']= "User Details Updated.....";
            //                 $_SESSION['icon'] ="success";
            //                 header("location:user_view");
                             
            //             }else{
            //                 $des="Click Update User Button";
            //                 $rem="User details not update";
            //                 include '../include/_audi_log.php';
            //                 $_SESSION['icon']='error';
            //                 $_SESSION['status'] = 'Invalid Data';
            //                 header("location:user_view");
            //             }
            //         }else{
            //             $check_dublicate_no = mysqli_num_rows(mysqli_query($conn,"select * from `user` where `mobile_no`='$u_mob'"));
            //             if($check_dublicate_no<1){
            //                 $uinsert_sql =mysqli_query($conn,"update `user` set `EmployeeId`='$emp_code', `name`='$u_name',`mobile_no`='$u_mob',`user_role`='$u_role',`user_sts`='$u_sts' where `uid`='$uid'");
            //                 if($uinsert_sql){
                
            //                     // audi_log insert 
            //                     $des="Click Update User Button";
            //                     $rem="User details update";
            //                     include '../include/_audi_log.php';
            //                     // header("location:user_view");
            //                     $_SESSION['status']= "User Details Updated.....";
            //                     $_SESSION['icon'] ="success";
            //                     header("location:user_view");
                                 
            //                 }else{
            //                     $des="Click Update User Button";
            //                     $rem="User details not update";
            //                     include '../include/_audi_log.php';
            //                     $_SESSION['icon']='error';
            //                     $_SESSION['status'] = 'Invalid Data';
            //                     header("location:user_view");
            //                 }
            //             }else{
            //                 $des="Click Update User Button";
            //                 $rem="User details not update";
            //                 include '../include/_audi_log.php';
            //                 $_SESSION['icon']='info';
            //                 $_SESSION['status'] = 'Dublicate Mobie no';
            //                 header("location:user_view");
            //             }
        
            //         }
            //     }else{
            //         $des="Click Update User Button";
            //         $rem="User details not update";
            //         include '../include/_audi_log.php';
            //         $_SESSION['icon']='info';
            //         $_SESSION['status'] = 'Dublicate Employee';
            //         header("location:user_view");
            //     }

            // }
            
        
          
        
        }else{
            $des="Click Update User Button";
            $rem="User details not update";
            include '../include/_audi_log.php';
            $_SESSION['icon']='info';
            $_SESSION['status'] = 'Dublicate User';
            header("location:user_view");
        }
    }
    


?>




<!DOCTYPE html>
<html lang="en">

<?php include "include/head.php";?>

<body>
    <!-- Pre-loader start -->
    <?php include "include/pre_loader.php"; ?>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <!-- navbar start -->
            <?php include "include/navbar.php"; ?>
            <!-- navbar end -->

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <!-- <?php echo $pass; ?> -->
                    <!-- Side Manu start -->
                    <?php include "include/manu.php"; ?>
                    <!-- Side Manu end -->

                    <div class="pcoded-content">

                        <!-- Page-header start -->
                        <?php include "include/header.php"?>
                        <!-- Page-header end -->

                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <!-- Page body start -->
                                    <div class="page-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                
                                                        <div class="card">
                                                    <div class="card-header">
                                                        <h5 style="width: 25.5rem;">Update User Details  </h5>
                                                            <a href="user_view.php">
                                                                <button  class="btn waves-effect waves-light btn-primary btn-outline-primary " ><i class="fa fa-arrow-right"  style="    font-size: 20px;margin-right: 10px;"></i>Back To List</button>
                                                            </a>
                                                    </div>
                                                    <div class="card-block">
                                                        <form action="" method="post">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">User Name</label>
                                                                <div class="col-sm-9">
                                                                    <label for="" class="form-control"><?php echo  $user_details['name'];?></label>
                                                                    <!-- <input list="emps" type="text" class="form-control"
                                                                        placeholder="Enter Username " name="euser_name" 
                                                                        oninput="this.value = this.value.toUpperCase()"
                                                                        required value="<?php echo  $user_details['EmployeeId'].' '. $user_details['name'];?>"
                                                                        id="editemp"> -->
                                                                </div>
                                                               
                                                            </div>
                                                            <input type="hidden" name="uid"value="<?php echo $user_details['uid']?> ">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Mobile No</label>
                                                                <div class="col-sm-9">
                                                                    <label for="" class="form-control"><?php if($sql_emp_data!=""){echo $sql_emp_data['ContactNo'];}?></label>
                                                                    <!-- <input type="text" class="form-control"
                                                                        placeholder="Enter Mobile " name="mob_no"
                                                                        maxlength="10"
                                                                        required value=""> -->
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">User Role</label>
                                                                <div class="col-sm-9">
                                                                    <select name="euser_role" id="" class="form-control">
                                                                        <option value="<?php echo $user_details['user_role'];?>" selected ><?php echo $user_details['user_role'];?></option>
                                                                        <option value="Admin">Admin</option>
                                                                        <option value="User">User</option>
                                                                        <option value="Security">Security</option>
                                                                        <?php if($user_role == "Developer"){?>
                                                                        <option value="Super Admin">Super Admin</option>
                                                                        <?php }?>
                                                                    </select>
                                                                 
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">User
                                                                    Status</label>
                                                                <div class="col-sm-9">
                                                                    <select name="euser_sts" id="" class="form-control">
                                                                        <option value="<?php echo $user_details['user_sts'];?>" selected ><?php echo $user_details['user_sts'];?></option>
                                                                        <option value="Active">Active</option>
                                                                        <option value="De-Active">De-Active</option>
                                                                    </select>
                                                                    
                                                                </div>
                                                                
                                                            </div>


                                                            <div class="user-entry">

                                                                <button type="reset"
                                                                    class="btn waves-effect waves-light btn-inverse btn-outline-inverse"><i
                                                                        class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit"
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    name="edit"><i class="fa fa-pencil-square-o"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>Update User</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                   
                                            </div>
                                            <div class="col-md-6">
                                            <div class="card" id="contact1">
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Page-body end -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Jquery -->
    <?php include "include/footer.php";?>
</body>

</html>
<script type="text/javascript">

$("#editemp").change(function()
{
let emp=$(this).val();
console.log(emp);
if(emp!=""){

    var emp_spl = emp.split(' ');
    let emp_id='id='+ emp_spl[0];
    $.ajax
    ({
    type: "POST",
    url: "ajax.php",
    data: emp_id,
    cache: false,
    success: function(cities)
    {
   
    $("#contact1").html(cities);
    } 
    });
}else{
    $("#contact1").css("display","none");
} 

});

</script>