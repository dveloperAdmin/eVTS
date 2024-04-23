<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Device Command";
$rem="page Load add_employee_command";
$head = "Device Command";
include '../include/_audi_log.php';

$sql_empdetails =  mysqli_query($conn,"select * from `eomploye_details`  where `Status`='Working'");
$sql_no_of_working_emp = mysqli_num_rows(mysqli_query($conn,"select * from `eomploye_details` where `Status`='Working'"));
$sql_no_of_resign_emp = mysqli_num_rows(mysqli_query($conn,"select * from `eomploye_details` where `Status`='Resign'"));
$device_id = "";
$device_name = "";
$device_sl_no = "";
if(isset($_GET['divi'])){
    $device_id = $_GET['divi'];
    $device_sl_no_sql = mysqli_fetch_assoc(mysqli_query($conn_bio,"select * from `devices` where `DeviceId`='$device_id'"));
    if($device_sl_no_sql != ""){
        $device_sl_no= $device_sl_no_sql['SerialNumber'];
        $device_name = $device_sl_no_sql['DeviceFName'];
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
                                                <div class="card" style="margin-bottom:0px;">
                                                    <div class="card-header" style="padding-bottom:8px;padding-top:8px;margin-bottom:.2rem;">
                                                        <h5>Employe Info</h5>
                                                        <h5 style="float:right;">Device Name:- &nbsp; <?php echo $device_name;?></h5>
                                                        <h5 style="float:right;margin-right: 4rem;">Device Serial NO:- &nbsp; <?php echo $device_sl_no;?></h5>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row" style="margin:5px;">
                                                            <label class="col-sm-3 col-form-label" style="padding-right: 0;">Search By Name</label>
                                                            <div class="col-sm-9">
                                                                <input list="emp_name" type="text" class="form-control" placeholder="Search By Name" id="myInput" onkeyup="quickSearch()">
                                                                <datalist id="emp_name">
                                                                    <?php $serach_emp= mysqli_query($conn,"select * from `eomploye_details` order by `EmployeeId` desc");
                                                                    while($emp_data= mysqli_fetch_assoc($serach_emp)){?>
                                                                        <option value="<?php echo ucfirst($emp_data['EmployeeName']) ?>"></option>
                                                                    <?php }  ?>
                                                                </datalist>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <div class="card-header" style="padding-bottom:8px;padding-top:8px;margin-bottom:.2rem;">
                                                        <span></span>
                                                        <!-- <span></span> -->
                                                    </div>
                                                    </div>
                                                    </div>
                                                <div class="card-block table-border-style" style="padding-top:5px">
                                                    <div class="table-responsive table-short" style="height: 330px">
                                                        <table class="table" id="myTable">
                                                            <thead style="top: -1px;">
                                                                <tr>
                                                                    <th style="width: 5rem;">Sl No.</th>
                                                                    <th>Employee Code</th>
                                                                    <th>Employee Name</th>
                                                                    <th>Company</th>
                                                                    <th>Status</th>
                                                                    <th colspan=2 style="  width: 10%;">Action</th>
                                                                </tr>
                                                            </thead>
                                            <form action="add_device_comand_process" method="post">
                                                            <tbody>
                                                                <?php $i=0; while($emp_data = mysqli_fetch_assoc($sql_empdetails)){$i++;
                                                                    $com_name = "";
                                                                    $com_id = $emp_data['CompanyId'];
                                                                    $company_name = mysqli_fetch_assoc(mysqli_query($conn,"select * from `company_details` where `company_id`='$com_id'"));
                                                                    if($company_name!=""){
                                                                        $com_name = $company_name['companyFname'];
                                                                    }
                                                                    ?> 
                                                                <tr>
                                                                    <td scope="row" style="padding:.4rem 1px"><?php echo $i;?></td>
                                                                    <td style="padding:.4rem 1px"><?php echo $emp_data['Emp_code'];?></td>
                                                                    <td style="padding:.4rem 1px"><?php echo ucfirst($emp_data['EmployeeName']);?></td>
                                                                    <td style="padding:.4rem 1px"><?php echo $com_name;?></td>
                                                                    <td style="padding:.4rem 1px"><?php echo ucfirst($emp_data['Status']);?></td>
                                                                    <td style="padding:.4rem 1px"><input type="checkbox" name="emp_id[]" value="<?php echo $emp_data['EmployeeId'];?>"></td>
                                                                    <input type="hidden" name="div_sl_no" value="<?php echo $device_sl_no;?>">
                                                            
                                                                </tr>
                                                                <?php }?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                        <div class="user-entry" style="padding-bottom:1rem;">
                                                            <button class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;float: right;margin-right:1rem;height: 2.8rem;" name="delete_emp"><i class="icofont icofont-bin" style="     font-size: 20px;margin-right: 10px;"></i>Delete Employee From Device</button>
                                                            <button class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;float: right; margin-right:1rem;height: 2.8rem;" name="add_emp"><i class="icofont icofont-user" style="     font-size: 20px;margin-right: 10px;"></i>Add Employee To Device</button>
                                                        </form>
                                                       <a href="add_device_command"> <button class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;margin-left:1rem;height: 2.8rem;" name="items_r_pdf"><i class="icofont icofont-arrow-left" style="     font-size: 20px;margin-right: 10px;"></i>Back</button></a>
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
function quickSearch() {
  var input, filter, table, tr, td, i, txtValue;
 
  input = document.getElementById("myInput");
  filter = input.value;
  console.log(filter);
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
   
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
$(':focus').blur();
})
</script>
</html>
