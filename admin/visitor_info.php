<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Page Load visitor info";
$rem="View visitor info";
$head = "Visitor Info";
include '../include/_audi_log.php';


$sql_v_info = mysqli_query($conn, "select * from `visitor_info`");





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
                                  
                                         
                                                <div class="card">
                                                    <div class="col-md-6" style="    padding-top: 1rem;">
                                                        <div class="form-group row" style="margin:5px;">
                                                            <label class="col-sm-3 col-form-label" style="padding-right: 0;">Search By Name </label>
                                                            <div class="col-sm-9">
                                                                <input list="emp_name" type="text" class="form-control" placeholder="Search By Visitor Name" id="myInput" onkeyup="quickSearch()">
                                                                <!-- <datalist id="emp_name">
                                                                    <?php 
                                                                    //while($visit_data= mysqli_fetch_assoc($serach_visit)){?>
                                                                        <option value="<?php   //$v_nam= "";if($visit_data!=""){$visitor_id  =  $visit_data['visitor_id'];
                                                                    //                     $visitor_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `visitor_info` where `visitor_id` = '$visitor_id' "));
                                                                    //                     if($visitor_details!=""){
                                                                    //                         $v_nam= $visitor_details['name'];
                                                                                           
                                                                    //                     }} echo  ucfirst($v_nam);?>">
                                                                    // </option>
                                                                    <?php //}  ?>
                                                                </datalist> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div class="card-block table-border-style">
                                                <div class="table-responsive table-short" style="height: 376px;" >
                                                    <table class="table" id="myTable">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 4rem;padding-bottom:2px;padding-top:2px;">Sl No.</th>
                                                                <th style="padding-bottom:2px;padding-top:2px;">Visitor Id</th>
                                                                <th style="  width: 20%;padding-bottom:2px;padding-top:2px;">Govt. ID</th>
                                                                <th style="padding-bottom:2px;padding-top:2px;">Visitor Name</th>
                                                                <th style="padding-bottom:2px;padding-top:2px;">Comapny Name</th>
                                                                <th style="padding-bottom:2px;padding-top:2px;">contact NO</th>
                                                                
                                                                <th style="padding-bottom:2px;padding-top:2px;">Register By</th>
                                                                <th style="padding-bottom:2px;padding-top:2px;">Register Time</th>
                                                                <th style="padding-bottom:2px;padding-top:2px;">Update Time</th>
                                                                <th style="padding-bottom:2px;padding-top:2px;">Visit count</th>
                                                                <!-- <th style="  width: 10%;padding-bottom:2px;padding-top:2px;">Action</th> -->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php for($i=1; $i<=mysqli_num_rows($sql_v_info);$i++){
                                                                    $info_report = mysqli_fetch_assoc($sql_v_info);
                                                                    $user_code_id="";
                                                                    $emp_code_id="";
                                                                    $emp_formate="";
                                                                    $user_code_id=$info_report['register_by'];
                                                                    if($user_code_id!=""){
                                                                        include '../include/_emp_details.php';
                                                                        $emp_formate = $emp_name."( ".$emp_code_user_id." )";

                                                                    }else{
                                                                        $emp_formate ="";
                                                                    }
                                                                    $v_id = $info_report['visitor_id'];	
                                                                    $count= mysqli_num_rows(mysqli_query($conn,"select * from `visitor_log` where `visitor_id` = '$v_id'"));

                                                                
                                                                ?> 
                                                            <tr>
                                                                <th scope="row" style="padding:1px;"><?php echo $i;?></th>
                                                                <td style="padding:1px;"><?php echo $info_report['visitor_id']?></td>
                                                                <td style="padding:1px;"><?php echo $info_report['govt_id_no']."( ".$info_report['govt_id_type']." )";?></td>
                                                                <td style="padding:1px;"><?php echo ucfirst($info_report['name']);?></td>
                                                                <td style="padding:1px;"><?php echo ucfirst($info_report['com_name']);?></td>
                                                                <td style="padding:1px;"><?php echo $info_report['contact_no'];?></td>
                                                                <td style="padding:1px;"><?php echo $emp_formate;?></td>
                                                                <td style="padding:1px;"><?php echo date("d-m-Y H:i:s" , strtotime($info_report['register_date']));?></td>
                                                                <td style="padding:1px;"><?php echo date("d-m-Y H:i:s" , strtotime($info_report['Update_date']));?></td>
                                                                <td style="padding:1px;"><?php echo $count;?></td>
                                                        
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
   


</script>
</html>
