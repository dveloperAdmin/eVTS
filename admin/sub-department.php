<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Page Load Sub-Department";
$rem="Sub-Department";
$head = "Supdepartment SetUp";
include '../include/_audi_log.php';
$e= false;
$sub_dp_name = "";
$sql_subdept  = mysqli_query($conn,"select * from `subdepartment` order by `sl_no` desc");
if(isset($_POST['edit_btn'])){
    $id = $_POST['sub_dpt'];
    $e= true;
    $check_sql = mysqli_fetch_assoc(mysqli_query($conn,"select * from `subdepartment` where `subdepartment_code`='$id'"));
    $sub_dp_name = $check_sql['subdepartment_name'];

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
                                                        <h5>Sub-Department Details</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <form action="process.php" method="post">
                                                        <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" style="padding-right: 0;">Sub-Dept. Name</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" placeholder="Enter Sub-Department Name" name="subdept_name" required>
                                                                </div>
                                                            </div>
                                                          
                                                            <div class="user-entry">

                                                                <button type="reset" class="btn waves-effect waves-light btn-inverse btn-outline-inverse"style="padding: 7px 20px;"><i class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;" name="sub_dept"><i class="fa fa-plus" style="    font-size: 20px;margin-right: 10px;"></i>Add Sub-Department</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                            <?php }
                                                    if($e==true){?>
                                            <div class="col-md-6">
                                                <div class="card" style="margin-bottom: 8px;">
                                                    <div class="card-header"  style="padding-bottom:8px;padding-top:8px;">
                                                        <h5> Update Sub-Department Details</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <form action="process.php" method="post">
                                                        <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" style="padding-right: 0;">Sub-Dept. Name</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" placeholder="Enter Sub-Department Name" name="upsubdept_name" required value="<?php echo $sub_dp_name;?>">
                                                                </div>
                                                            </div>
                                                          <input type="hidden" name="edit_id" value="<?php echo $id;?>">
                                                            <div class="user-entry">

                                                                <button type="reset" class="btn waves-effect waves-light btn-inverse btn-outline-inverse"style="padding: 7px 20px;"><i class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;" name="upsub_dept"><i class="fa fa-arrow-up" style="    font-size: 20px;margin-right: 10px;"></i>Update Sub-Department</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                          <?php }?>
                                            <div class="col-md-6">
                                              
                                                    <div class="card text-center order-visitor-card" id="total-subdept" style="margin-bottom:8px">
                                                        <div class="card-block dsh-card signle-dash" >
                                                            <i class="fa fa-object-ungroup m-r-15 text-c-black"></i>
                                                            <div class="card-text">
                                                                <h6 class="m-b-0"style="font-size: 20px">Total Sub-Department</h6>
                                                                <h4 class="m-t-15 m-b-15" style="font-size: 40px"><?php echo mysqli_num_rows($sql_subdept);?></h4>
                                                                <!-- <p class="m-b-0" style="font-weight: bold;    font-size: 15px;">All The SubDepartment Are Active </p> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                </div>
                                                </div>
                                         
                                                <div class="card">
                                                <div class="card-block table-border-style">
                                                <div class="table-responsive table-short">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 5rem;">Sl No.</th>
                                                                <th>Sub-Depertment Name</th>
                                                                
                                                                <th colspan=2 style="  width: 30%;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i=0; while($sub_dp_data = mysqli_fetch_assoc($sql_subdept)){$i++?>
                                                            <tr>
                                                                <th scope="row"><?php echo $i;?></th>
                                                                <td><?php echo ucfirst($sub_dp_data['subdepartment_name'])?></td>
                                                                
                                                                
                                                                <td class="th_width">
                                                                    <form action="" method="post">
                                                                        <input type="hidden" name="sub_dpt" value="<?php echo $sub_dp_data['subdepartment_code']?>">
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary" name="edit_btn"><i class="icofont icofont-ui-edit"></i>Edit</button>

                                                                    </form>
                                                                 
                                                                </td>
                                                                <td class="th_width">
                                                                    <a href="process.php?sub_dp_id=<?php echo $sub_dp_data['subdepartment_code'];?>" class="delt_href">
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
