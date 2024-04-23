<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Page Load Employe";
$rem="Employe Category";
$head = "Employe Category SetUp";
include '../include/_audi_log.php';

$sql_check_empcat = mysqli_query($conn, "select * from `empcategory` order by `sl_no` desc");

$e= false;
$emp_cat_data = "";
if(isset($_POST['emp_cat_edit_btn'])){
    $empid = $_POST['emp_cat_edit_id'];
    $e= true;
    
    $check_sql = mysqli_fetch_assoc(mysqli_query($conn,"select * from `empcategory` where `empcat_code`='$empid'"));
    $emp_cat_data = $check_sql['empcat'];

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
                                        <?php if($e!= true){?>
                                            <div class="col-md-6">
                                                <div class="card" style="margin-bottom: 8px;">
                                                    <div class="card-header"  style="padding-bottom:8px;padding-top:8px;">
                                                        <h5>Employe Catagory Details</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <form action="process" method="post">
                                                        <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" style="padding-right: 0;">Employe Catagory</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" placeholder="Enter Employe Catagory" name="emp_cat_in" required>
                                                                </div>
                                                            </div>
                                                          
                                                            <div class="user-entry">

                                                                <button type="reset" class="btn waves-effect waves-light btn-inverse btn-outline-inverse"style="padding: 7px 20px;"><i class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;" name="emp_cate_sub"><i class="fa fa-plus" style="    font-size: 20px;margin-right: 10px;"></i> Add Emp. Catagory</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                          <?php }
                                                if($e == true){
                                             ?>
                                            <div class="col-md-6">
                                                <div class="card" style="margin-bottom: 8px;">
                                                    <div class="card-header"  style="padding-bottom:8px;padding-top:8px;">
                                                        <h5 style="width:82%"> Update Employe Catagory Details</h5>
                                                        <a href="emp-cat">
                                                        <button type="reset" class="btn waves-effect waves-light btn-inverse btn-outline-inverse"style="padding: 7px 20px;"><i class="fa fa-arrow-right"></i>Back</button>
                                                        </a>
                                                    </div>
                                                    <div class="card-block">
                                                        <form action="process" method="post">
                                                        <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" style="padding-right: 0;">Employe Catagory</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" placeholder="Enter Employe Catagory" name="upemp_cat_in" required value="<?php echo $emp_cat_data;?>">
                                                                </div>
                                                            </div>
                                                          <input type="hidden" name="emp_cat_id" value="<?php echo $id;?>">
                                                            <div class="user-entry">

                                                                <button type="reset" class="btn waves-effect waves-light btn-inverse btn-outline-inverse"style="padding: 7px 20px;"><i class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;" name="upemp_cate_sub"><i class="fa fa-arrow-up" style="    font-size: 20px;margin-right: 10px;"></i> Update Emp. Catagory</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                            <?php    }?>
                                            
                                            <div class="col-md-6">
                                              
                                                    <div class="card text-center order-visitor-card" id="total-emp-cat" style="margin-bottom:8px">
                                                        <div class="card-block dsh-card signle-dash" >
                                                            <i class="icofont icofont-engineer" style="font-size:8rem; margin-right:5rem"></i>
                                                            <div class="card-text">
                                                                <h6 class="m-b-0"style="font-size:20px;"> Total Catagory of Emplye</h6>
                                                                <h4 class="m-t-15 m-b-15"style="font-size:40px;"><?php echo mysqli_num_rows($sql_check_empcat);?></h4>
                                                                <p class="m-b-0" style="font-weight: bold;    font-size: 15px;"> </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                </div>
                                        </div>
                                         
                                                <div class="card">
                                                <div class="card-block table-border-style">
                                                <div class="table-responsive table-short" style="height:330px;">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 5rem;">Sl No.</th>
                                                                <th>Catagory Of Employe</th>
                                                                
                                                                <th colspan=2 style="  width: 30%;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i=0; while($emp_cat = mysqli_fetch_assoc($sql_check_empcat)){ $i++;?>
                                                            <tr>
                                                                <th scope="row" style="padding:.3rem;"><?php echo $i;?></th>
                                                                <td style="padding:.3rem;"><?php echo ucfirst($emp_cat['empcat']);?></td>
                                                                
                                                                
                                                                <td class="th_width" style="padding:.3rem;">
                                                                <form action="" method="post">
                                                                        <input type="hidden" name="emp_cat_edit_id" value="<?php echo $emp_cat['empcat_code'];?> ">
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary" name="emp_cat_edit_btn" style="padding:3px 13px;"><i class="icofont icofont-ui-edit"></i>Edit</button>
                                                                        </form>
                                                                </td>
                                                                <td class="th_width" style="padding:.3rem;">
                                                                    <a href="process?emp_cat=<?php echo $emp_cat['empcat_code'];?>" class="delt_href">
                                                                        <button class="btn waves-effect waves-light btn-danger btn-outline-danger" style="padding:3px 13px;"><i class="icofont icofont-delete-alt"></i>Delete</button>
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
