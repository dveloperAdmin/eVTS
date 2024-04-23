<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Page Load Gate Info";
$rem="Gate Info Type";
$head = "Gate Info ";
include '../include/_audi_log.php';

if(in_array($user_role, array("Developer", "Super Admin"))){
$sql_check_data = mysqli_query($conn,"select * from `gate_info` order by `sl_no` desc");
}else{
    $sql_check_data = mysqli_query($conn,"select * from `gate_info` where `Branch_id` = '$branch_id' order by `sl_no` desc");

}
$e= false;
$gate_no = "";
$gate_Info = "";
$branch_id = "";
$user_id  = $_SESSION['user_id'];
$user_data = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `uid` = '$user_id'")); 
if($user_data !="" ){
    $emp_id = $user_data['EmployeeId'];
    $emp_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` where `EmployeeId` = '$emp_id'"));
   
   
    if($emp_details!=""){
        $branch_id = $emp_details['BranchId'];
    }

}
if(isset($_POST['emp_t_edit'])){
    $id = $_POST['empedit_id'];
    $e= true;
    $check_sql = mysqli_fetch_assoc(mysqli_query($conn,"select * from `gate_info` where `sl_no`='$id'"));
    $gate_no = $check_sql['gate_number'];
    $gate_info = $check_sql['gate_description'];

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
                                        <?php if($e != true){?>
                                            <div class="col-md-6">
                                                <div class="card" style="margin-bottom: 8px;">
                                                    <div class="card-header"  style="padding-bottom:8px;padding-top:8px;">
                                                        <h5>Gate Info</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <form action="process" method="post">
                                                        <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" style="padding-right: 0;">Gate no</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" placeholder="Enter Gate no" name="gate_no_in" required>
                                                                  
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" style="padding-right: 0;">Gate Info</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" placeholder="Enter Gate Info" name="gate_info_in" required>
                                                                  
                                                                </div>
                                                                </div>
                                                          
                                                            <div class="user-entry">
                                                                <input type="hidden" name="branch_id" value="<?php echo $branch_id;?>">
                                                                <button type="reset" class="btn waves-effect waves-light btn-inverse btn-outline-inverse"style="padding: 7px 20px;"><i class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;" name="gate_sub"><i class="fa fa-plus" style="    font-size: 20px;margin-right: 10px;"></i> Add Gate Info</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                          <?php }
                                                if($e== true){
                                            ?>
                                            <div class="col-md-6">
                                                <div class="card" style="margin-bottom: 8px;">
                                                    <div class="card-header"  style="padding-bottom:8px;padding-top:8px;">
                                                        <h5 style="width:79%"> Update Gate Info Details</h5>
                                                        <a href="gate_info">
                                                        <button  class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;"><i class="fa fa-arrow-right" style="    font-size: 20px;margin-right: 10px;"></i> Back</button>
                                                        </a>
                                                    </div>
                                                    <div class="card-block">
                                                        <form action="process" method="post">
                                                        <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" style="padding-right: 0;">Gate No</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" placeholder="Enter Gate No" name="upgate_no_in" required value="<?php echo $gate_no;?>">
                                                                </div>
                                                            </div>
                                                        <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" style="padding-right: 0;">Gate Info</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" placeholder="Enter Gate Info" name="upgate_info_in" required value="<?php echo $gate_info;?>">
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="gate_edit_id" value="<?php echo $id;?>">      
                                                            <div class="user-entry">
                                                                <input type="hidden" name="branch_id" value="<?php echo $branch_id;?>">
                                                                
                                                                <button type="reset" class="btn waves-effect waves-light btn-inverse btn-outline-inverse"style="padding: 7px 20px;"><i class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;" name="upgate_gate_info"><i class="fa fa-arrow-up" style="    font-size: 20px;margin-right: 10px;"></i> Update Gate Info</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                            <?php    }?>
                                            
                                            <div class="col-md-6">
                                              
                                                    <div class="card text-center order-visitor-card" id="total-visit-purpose" style="margin-bottom:8px">
                                                        <div class="card-block dsh-card signle-dash" >
                                                            <i class="icofont icofont-building" style="font-size:10rem; padding-bottom:1.5rem;"></i>
                                                            <div class="card-text">
                                                                <h6 class="m-b-0"> TOTAL NO OF GATE</h6>
                                                                <h4 class="m-t-15 m-b-15"><?php echo mysqli_num_rows($sql_check_data);?></h4>
                                                                <p class="m-b-0" style="font-weight: bold;    font-size: 15px;"> </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!-- </div> -->
                                                <!-- <div class="row">
                                                <div class="col-md-6">
                                                    <div class="card text-center order-visitor-card" id="total-ca">
                                                        <div class="card-block dsh-card">
                                                            <i class="fa fa-check-square m-r-15 text-c-black"></i>
                                                            <div class="card-text">
                                                                <h6 class="m-b-0">Active Comapany</h6>
                                                                <h4 class="m-t-15 m-b-15">7652</h4>
                                                                <p class="m-b-0"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card text-center order-visitor-card" id="total-cda">
                                                        <div class="card-block dsh-card">
                                                            <i class="fa fa-window-close m-r-15 text-c-black"></i>
                                                            <div class="card-text">
                                                                <h6 class="m-b-0">De-Active Company</h6>
                                                                <h4 class="m-t-15 m-b-15">7652</h4>
                                                                <p class="m-b-0"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div> -->
                                                </div>
                                                </div>
                                         
                                                <div class="card">
                                                <div class="card-block table-border-style">
                                                <div class="table-responsive table-short" style="height:205px">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 5rem;">Sl No.</th>
                                                                <th>Gate No</th>
                                                                <th>Gate Info</th>
                                                                
                                                                <th colspan=2 style="  width: 30%;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i=0; while($gate = mysqli_fetch_assoc($sql_check_data)){ $i++?>
                                                            <tr>
                                                                <th scope="row"><?php echo $i;?></th>
                                                                <td><?php echo ucfirst($gate['gate_number']);?></td>
                                                                <td><?php echo ucfirst($gate['gate_description']);?></td>
                                                                
                                                                
                                                                <td class="th_width">
                                                                   <form action="" method="post">
                                                                       <input type="hidden" name="empedit_id" value="<?php echo$gate['sl_no'];?>" >
                                                                       <button class="btn waves-effect waves-light btn-primary btn-outline-primary" name="emp_t_edit"><i class="icofont icofont-ui-edit"></i>Edit</button>
                                                                   </form>
                                                                   
                                                                        
                                                                </td>
                                                                <td class="th_width">
                                                                    <a href="process?gate=<?php echo$gate['sl_no'];?>" class="delt_href">
                                                                        <button class="btn waves-effect waves-light btn-danger btn-outline-danger"><i class="icofont icofont-delete-alt"></i>Delete</button>
                                                                    </a>
                                                                </td>
                                                          
                                                            </tr>
                                                            <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
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
<script>
    $('.delt_href').on('click', function(e){
  e.preventDefault();
  // console.log(e);
  var href = $(this).attr('href')
  console.log(href)
   
Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
    console.log(result.value);
    document.location.href = href;
   
  }else{
    
  }
})

})
</script>
</html>
