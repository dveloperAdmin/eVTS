<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Page Load Company";
$rem="Company";
$head  = "Company SetUp";
include '../include/_audi_log.php';
$c_fname = "";
$c_sname = "";
$p = false;

$sql_comapany_details = mysqli_query($conn,"select * from `company_details` order by `sl_no` desc");

if(isset($_POST['com_edit'])){
    $p = true;
    $e_id = $_POST['c_edit'];
    $sql_comapany_edit_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `company_details` where `company_id`='$e_id'"));
    $c_fname = $sql_comapany_edit_details['companyFname'];
    $c_sname = $sql_comapany_edit_details['companySname'];
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
                                            <div class="col-md-6">
                                                <?php if($p == true){?>

                                                    <div class="card" style="margin-bottom: 8px;">
                                                        <div class="card-header"  style="padding-bottom:8px;padding-top:8px;">
                                                            <h5 style="width: 80%;">Company Details Update</h5>
                                                            <a href="company">
                                                                <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;" name="com_update"><i class="fa fa-arrow-right" style="    font-size: 20px;margin-right: 10px;"></i>Back</button>

                                                            </a>
                                                        </div>
                                                        <div class="card-block">
                                                           <form action="process" method="post">
                                                            <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">CO. Full Name</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control" placeholder="Enter Company Full Name" name="up_co_f_name" required value ="<?php echo $c_fname ;?>">
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="c_id" value="<?php echo $e_id;?>">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">CO. Short Name</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control" placeholder="Enter Comapny Short Name " name="up_co_s_name" required value ="<?php echo $c_sname; ?>">
                                                                    </div>
                                                                </div>
                                                                
                                                                
                                                                <div class="user-entry">
    
                                                                    <button type="reset" class="btn waves-effect waves-light btn-inverse btn-outline-inverse"style="padding: 7px 20px;"><i class="icofont icofont-exchange"></i>Cancel</button>
                                                                    <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;" name="com_update"><i class="fa fa-pencil-square-o" style="    font-size: 20px;margin-right: 10px;"></i>UpdateCompany</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                <?php }else{?>
                                                <div class="card" style="margin-bottom: 8px;">
                                                    <div class="card-header"  style="padding-bottom:8px;padding-top:8px;">
                                                        <h5>Company Details</h5>
                                                    </div>
                                                    <div class="card-block">
                                                       <form action="process" method="post">
                                                        <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">CO. Full Name</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" placeholder="Enter Company Full Name" name="co_f_name" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">CO. Short Name</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" placeholder="Enter Comapny Short Name " name="co_s_name" required>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            <div class="user-entry">

                                                                <button type="reset" class="btn waves-effect waves-light btn-inverse btn-outline-inverse"style="padding: 7px 20px;"><i class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;" name="com_sub"><i class="fa fa-user-plus" style="    font-size: 20px;margin-right: 10px;"></i>Add Company</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            </div>
                                          
                                            
                                            <div class="col-md-6">
                                              
                                                    <div class="card text-center order-visitor-card" id="total-c" style="margin:8px">
                                                        <div class="card-block dsh-card signle-dash" style="padding: 40px;">
                                                            <i class="fa fa-building-o m-r-15 text-c-black" style="font-size: 8rem;  margin-right: 7rem;"></i>
                                                            <div class="card-text">
                                                                <h6 class="m-b-0">TOTAL COMPANY</h6>
                                                                <h4 class="m-t-15 m-b-15"><?php echo mysqli_num_rows($sql_comapany_details);?></h4>
                                                                <p class="m-b-0"></p>
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
                                         
                                                <div class="card" style="margin:0;">
                                                <div class="card-block table-border-style">
                                                <div class="table-responsive table-short">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 5rem;">Sl No.</th>
                                                                <th>Comapny Full Name</th>
                                                                <th>Comapny Short Name</th>
                                                                <!-- <th>Status</th> -->
                                                                <th colspan=2 style="  width: 20%;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i=0; while($comapny_data = mysqli_fetch_assoc($sql_comapany_details)){$i++?>

                                                            
                                                            <tr>
                                                                <th scope="row"><?php echo $i;?></th>
                                                                <td><?php echo ucfirst($comapny_data['companyFname']);?></td>
                                                                <td><?php echo $comapny_data['companySname'];?></td>
                                                                <!-- <td>Active</td> -->
                                                                <!-- <td>
                                                                    <a href="">
                                                                        <button class="btn waves-effect waves-light btn-success btn-outline-success"><i class="icofont icofont-exchange"></i>Status</button>
                                                                    </a>
                                                                </td> -->
                                                                <td class="th_width">
                                                                   <form action="" method="post">
                                                                        <input type="hidden" name="c_edit" value="<?php echo $comapny_data['company_id'];?>">
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary" name="com_edit"><i class="icofont icofont-ui-edit"></i>Edit</button>
                                                                   </form>
                                                                    
                                                                </td>
                                                                <td class="th_width">
                                                                <a href="process?id=<?php echo $comapny_data['company_id'];?>" class="delt_href">
                                                                            <button class="btn waves-effect waves-light btn-danger btn-outline-danger btn" name="delete" style="outline: none;box-shadow: none; background-color:none"  ><i class="icofont icofont-delete-alt"></i>Delete</button>
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
  var href = $(this).attr('href');
 
   
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
