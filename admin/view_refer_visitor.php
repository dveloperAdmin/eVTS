<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des = "Page Load View visitor Log";
$rem = "View visitor Log";
$head = "Visitor Info";
include '../include/_audi_log.php';
$emp_code_id="";
$EmpCode = $_SESSION['user_id'];
$user_code_id = $EmpCode;
include '../include/_emp_details.php';
$empCode = $emp_code_user_id;


$sql_refer_vistor = mysqli_query($conn, "select * from `meeting_referrable` where `refer_to`='$empCode' and `reffer_status` in ('Reffer', 'Reffer End') and `visitor_enetry`!= 'Register' order by `sl_no` desc");
$serach_refer_visit = mysqli_query($conn, "select distinct `visitor_id` from `meeting_referrable` join `visitor_log` on `visitor_log`.`visit_uid` = `meeting_referrable`.`refer_visitor` where `meeting_referrable`.`refer_to` = '$user_id' and `meeting_referrable`.`reffer_status` in ('Reffer', 'Reffer End') and `meeting_referrable`.`visitor_enetry`!= 'Register';");






?>

<!DOCTYPE html>
<html lang="en">

<?php include "include/head.php"; ?>

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
            <?php include "include/header.php" ?>
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
                          <label class="col-sm-3 col-form-label" style="padding-right: 0;flex:0 0 10%;">Search</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Search" id="searchInput"
                              style="width:60%">
                          </div>
                        </div>
                      </div>


                      <div class="card-block table-border-style">
                        <div class="table-responsive table-short" style="height: 376px;">
                          <table class="table" id="dataTable">
                            <thead>
                              <tr>
                                <th style="width: 4rem;padding-bottom:2px;padding-top:2px;">
                                  Sl No.</th>
                                <th style="padding-bottom:2px;padding-top:2px;">Visit Id
                                </th>
                                <th style="  width: 20%;padding-bottom:2px;padding-top:2px;">
                                  Visitor Name</th>
                                <th style="padding-bottom:2px;padding-top:2px;">Comapny
                                  Name</th>
                                <th style="padding-bottom:2px;padding-top:2px;">Register
                                  Type</th>

                                <th style="padding-bottom:2px;padding-top:2px;">Reffer
                                  By</th>
                                <!-- <th style="padding-bottom:2px;padding-top:2px;">Secqu. Permission</th> -->
                                <th style="padding-bottom:2px;padding-top:2px;">Entry
                                  Status</th>
                                <th style="  width: 10%;padding-bottom:2px;padding-top:2px;">
                                  Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $i = 0;
                                                            while ($reffre_details = mysqli_fetch_assoc($sql_refer_vistor)) {
                                                                $v_log_id = $reffre_details['refer_visitor'];
                                                                $reffer_sts = $reffre_details['reffer_status'];
                                                                $refer_by = $reffre_details['refer_by'];
                                                                $usre_dtails = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `uid`= '$refer_by' "));
                                                                if ($usre_dtails != "") {
                                                                    $emp_id = $usre_dtails['EmployeeId'];
                                                                    $emp_detauls = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` where `EmployeeId` = '$emp_id'"));
                                                                    if ($emp_detauls != "") {
                                                                        $emp_name = $emp_detauls['EmployeeName'];
                                                                    } else {
                                                                        $emp_name = "";
                                                                    }
                                                                }
                                                                $sql_vistor = mysqli_query($conn, "select * from `visitor_log` where `visit_uid` = '$v_log_id'");
                                                                while ($visitor_data = mysqli_fetch_assoc($sql_vistor)) {
                                                                    $v_nam = "";
                                                                    $v_com = "";
                                                                    $e_name = "";
                                                                    $visitor_id = $visitor_data['visitor_id'];
                                                                    $visitor_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_info` where `visitor_id` = '$visitor_id' "));
                                                                    if ($visitor_details != "") {
                                                                        $v_nam = $visitor_details['name'];
                                                                        $v_com = $visitor_details['com_name'];
                                                                    }

                                                                    $emp_id = $visitor_data['emp_id'];
                                                                    $emp_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` where `Emp_code`= '$emp_id'"));
                                                                    if ($emp_details != "") {
                                                                        $e_name = $emp_details['EmployeeName'];
                                                                    }

                                                                    $i++;


                                                                    ?>
                              <tr <?php if ($reffer_sts == 'Reffer') {
                                                                        echo 'style="background: yellow;color: red;font-weight: 700;"';
                                                                    } ?>>
                                <th scope="row" style="padding:1px;"><?php echo $i; ?>
                                </th>
                                <td style="padding:1px;">
                                  <?php $id = explode("-", rtrim($visitor_data['visit_uid']));
                                                                            if ($id != "") {
                                                                                echo $id[1];
                                                                            } ?>
                                </td>
                                <td style="padding:1px;"><?php echo ucfirst($v_nam); ?>
                                </td>
                                <td style="padding:1px;"><?php echo ucfirst($v_com); ?>
                                </td>
                                <td style="padding:1px;"><?php echo $reffer_sts; ?></td>

                                <td style="padding:1px;"><?php echo $emp_name; ?></td>


                                <td <?php
                                                                        if ($visitor_data['check_status'] == "OUT") {
                                                                            echo 'style="font-weight:700; color:red; padding:1px;"';
                                                                        } else if ($visitor_data['check_status'] == "IN") {
                                                                            echo 'style="font-weight:700; color:green;padding:1px;"';
                                                                        } else {
                                                                            echo 'style="font-weight:700; color:blue;padding:1px;"';
                                                                        } ?>>
                                  <?php echo ucfirst($visitor_data['check_status']); ?>
                                </td>

                                <td style="padding:1px;">
                                  <form action="Visitor_details.php" method="post">
                                    <input type="hidden" name="reffer_page">
                                    <input type="hidden" name="v_id" value="<?php echo $visitor_data['visit_uid']; ?>">
                                    <button class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                      name="view_v" style="padding: 4px 11px 4px 11px;"><i
                                        class="icofont icofont-eye-alt"></i>View</button>
                                  </form>

                                </td>


                              </tr>
                              <?php }
                                                            } ?>
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
  <?php include "include/footer.php"; ?>
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
    td = tr[i].getElementsByTagName("td")[1];
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