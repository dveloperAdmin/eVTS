<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Page Load Grade";
$rem="Grade";
$head = "Grade SetUp";
include '../include/_audi_log.php';
$sql_check_data = mysqli_query($conn,"select * from `grade` order by `sl_no` desc");
$e= false;
$grade= "";
if(isset($_POST['grade_edit'])){
    $id = $_POST['edit_id'];
    $e= true;
    $check_sql = mysqli_fetch_assoc(mysqli_query($conn,"select * from `grade` where `grade_code`='$id'"));
    $grade = $check_sql['grade'];

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
                                                        <h5>Grade Details</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <form action="process" method="post">
                                                        <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" style="padding-right: 0;">Grade</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" placeholder="Enter Grade" name="grade_in" required>
                                                                </div>
                                                            </div>
                                                          
                                                            <div class="user-entry">

                                                                <button type="reset" class="btn waves-effect waves-light btn-inverse btn-outline-inverse"style="padding: 7px 20px;"><i class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;" name="grade_sub"><i class="fa fa-plus" style="    font-size: 20px;margin-right: 10px;"></i>Add Grade</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                          <?php }
                                                if($e == true){?>
                                            <div class="col-md-6">
                                                <div class="card" style="margin-bottom: 8px;">
                                                    <div class="card-header"  style="padding-bottom:8px;padding-top:8px;">
                                                        <h5 style="width:80%"> Update Grade Details</h5>
                                                        <a href="grade">
                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;" ><i class="fa fa-arrow-right" style="    font-size: 20px;margin-right: 10px;"></i>Back</button>
                                                        </a>
                                                    </div>
                                                    <div class="card-block">
                                                        <form action="process" method="post">
                                                        <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" style="padding-right: 0;">Grade</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" placeholder="Enter Grade" name="Upgrade_in" required value="<?php echo $grade;?>">
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="edit_id" value="<?php echo $id;?>">
                                                          
                                                            <div class="user-entry">

                                                                <button type="reset" class="btn waves-effect waves-light btn-inverse btn-outline-inverse"style="padding: 7px 20px;"><i class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;" name="UPgrade_sub"><i class="fa fa-arrow-up" style="    font-size: 20px;margin-right: 10px;"></i>Update Grade</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                            <?php }?>
                                            
                                            <div class="col-md-6">
                                              
                                                    <div class="card text-center order-visitor-card" id="total-grade" style="margin-bottom:8px">
                                                        <div class="card-block dsh-card signle-dash" >
                                                            <i class="fa fa-line-chart m-r-15 text-c-black"></i>
                                                            <div class="card-text">
                                                                <h6 class="m-b-0"style="font-size:20px;">Total No Of Grade</h6>
                                                                <h4 class="m-t-15 m-b-15" style="font-size:40px;"><?php echo mysqli_num_rows($sql_check_data);?></h4>
                                                                <p class="m-b-0" style="font-weight: bold;    font-size: 15px;"></p>
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
                                                <div class="table-responsive table-short" style="height:330px;">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 5rem;">Sl No.</th>
                                                                <th>Grade</th>
                                                                
                                                                <th colspan=2 style="  width: 30%;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $i=0; while($grade_data = mysqli_fetch_assoc($sql_check_data)){$i++?>
                                                            <tr>
                                                                <th scope="row" style="padding:.3rem"><?php echo $i;?></th>
                                                                <td style="padding:.3rem"><?php echo $grade_data['grade'];?></td>
                                                                
                                                                
                                                                <td class="th_width" style="padding:.3rem">
                                                                    <form action="" method="post">
                                                                        <input type="hidden" name="edit_id" value="<?php echo $grade_data['grade_code'];?>">
                                                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary" name="grade_edit" style="padding:3px 13px;"><i class="icofont icofont-ui-edit"></i>Edit</button>
                                                                    </form>
                                                                    
                                                                </td>
                                                                <td class="th_width" style="padding:.3rem">
                                                                    <a href="process?gr_id=<?php echo $grade_data['grade_code'];?>" class="delt_href">
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
