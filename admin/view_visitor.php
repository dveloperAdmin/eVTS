<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des = "Page Load View visitor Log";
$rem = "View visitor Log";
$head = "Visitor Info";
include '../include/_audi_log.php';
include '../include/_function.php';
$emp_code = $_SESSION['emp_code'];
$serach_visit = "";
$sql_vistor = "";
if (isset($_GET['id'])) {
  $form_action = "visitor_app_rej_details.php";
  $sql_udate = "";
  $sql_vistor = mysqli_query($conn, "select * from `visitor_log` where `emp_id`='$emp_code' and `Emp_approve`='Pending' order by `sl_no` desc");
  $serach_visit = mysqli_query($conn, "select  distinct `visitor_id` from `visitor_log` where `emp_id`='$emp_code' and `Emp_approve`='Pending' order by `sl_no` desc");
  if (isset($_POST['v_app'])) {
    $v_id = $_POST['vid'];
    $v_permit = $_POST['action'];
    // $e_remark = $_POST['remark'];
    // if ($v_permit == 'Reject') {
    //   $sql_udate = mysqli_query($conn, "update `visitor_log` set `Emp_approve`='$v_permit',security_approval = '$v_permit',check_status = 'OUT' where `visit_uid`='$v_id'");

    // } else {
    $sql_udate = mysqli_query($conn, "update `visitor_log` set `Emp_approve`='$v_permit' where `visit_uid`='$v_id'");
    // }
    if ($sql_udate != "") {
      $_SESSION['icon'] = 'success';
      $_SESSION['status'] = 'Your action updated.....';
      header('location: view_visitor.php?id=1');

    } else {
      $_SESSION['icon'] = 'error';
      $_SESSION['status'] = 'Your action not updated.....';
      header('location: view_visitor.php?id=1');
    }
  }

} else {
  $form_action = "Visitor_details.php";
  if (in_array($user_role, array("Developer", "Super Admin"))) {
    $sqlVisitor = "SELECT * from visitor_log vl join visitor_info vi on vl.visitor_id = vi.visitor_id order by vl.sl_no
  desc";
  } else {
    $sqlVisitor = "SELECT * from visitor_log vl join visitor_info vi on vl.visitor_id = vi.visitor_id where vl.branch_id =
  '$branch_id' order by vl.sl_no desc";

  }
  $sql_vistor = mysqli_query($conn, $sqlVisitor);
}





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
                      <div class="col-md-6" style=" padding-top: .3rem;">
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
                                <th style="padding-bottom:2px;padding-top:2px;">
                                  Sl No.</th>
                                <th style="padding-bottom:2px;padding-top:2px;">Visit Id
                                </th>
                                <th style="padding-bottom:2px;padding-top:2px;">
                                  Visitor Name</th>
                                <th style="padding-bottom:2px;padding-top:2px;">Comapny
                                  Name</th>
                                <th style="padding:2px 5px;">Visitor Type</th>
                                <th style="padding:2px 5px;">Purpose</th>
                                <th style="padding:2px 5px;">Visted Branch</th>
                                <th style="padding:2px 5px;">Visit To Wish</th>
                                <th style="padding-bottom:2px;padding-top:2px;">Register
                                  Type</th>

                                <th style="padding:2px 5px;">Emp. Permit</th>
                                <th style="padding:2px 5px;">Sec. Permit</th>
                                <th style="padding:2px 5px;">Status</th>
                                <th style="  width: 10%;padding-bottom:2px;padding-top:2px;">
                                  Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $i = 0;
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
                              <tr>
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
                                <td><?= findVisitortype($conn, $visitor_data['visitor_type']) ?></td>
                                <td><?= findVisitorPurpose($conn, $visitor_data['visit_purpose']) ?></td>
                                <td><?= findBranch($conn, $visitor_data['branch_id']) ?></td>
                                <td>
                                  <?php
                                      $empData = findEmp($conn, $visitor_data['emp_id']);
                                      if ($empData != null) {
                                        echo $empData['EmployeeName'];
                                      } else {
                                        echo "Not Exist";
                                      }

                                      ?>
                                </td>
                                <td style="padding:1px;">
                                  <?php echo $visitor_data['register_type']; ?>
                                </td>

                                <td style="padding:1px;"><?php
                                  if ($visitor_data['Emp_approve'] == 'Pending') {
                                    echo '<i class="icofont icofont-history" style="color:blue; font-size:2rem; font-weight:900"></i>';
                                  } else if ($visitor_data['Emp_approve'] == 'Approve') {
                                    echo '<i class="icofont icofont-tick-mark" style="color:green; font-size:2rem;"></i>';
                                  } else {
                                    echo '<i class="icofont icofont-not-allowed" style="color:red; font-size:2rem; font-weight:900"></i>';
                                  }
                                  ?></td>
                                <td style="padding:1px;"><?php
                                  if ($visitor_data['security_approval'] == 'Pending') {
                                    echo '<i class="icofont icofont-history" style="color:blue; font-size:2rem; font-weight:900"></i>';
                                  } else if ($visitor_data['security_approval'] == 'Approve') {
                                    echo '<i class="icofont icofont-tick-mark" style="color:green; font-size:2rem;"></i>';
                                    ;
                                  } else {
                                    echo '<i class="icofont icofont-not-allowed" style="color:red; font-size:2rem; font-weight:900"></i>';
                                  }
                                  ?></td>
                                <td style="padding: 0; text-align:center;">
                                  <?php
                                    if ($visitor_data['check_status'] == 'OUT') {
                                      echo '<i class="icofont icofont-arrow-right" style="color:red; font-size:2.2rem; "></i>';
                                    } else if ($visitor_data['check_status'] == 'IN') {
                                      echo '<i class="icofont icofont-arrow-left" style="color:green; font-size:2.2rem;"></i>';
                                      ;
                                    } else {
                                      echo '<i class="icofont icofont-history" style="color:blue; font-size:2rem; font-weight:900"></i>';

                                    }
                                    ?>
                                </td>

                                <td style="padding:4px;">
                                  <form action="<?php echo $form_action; ?>" method="post">
                                    <input type="hidden" name="v_id" value="<?php echo $visitor_data['visit_uid']; ?>">
                                    <button class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                      name="view_v" style="padding: 4px 11px 4px 11px;"><i
                                        class="icofont icofont-eye-alt"></i>View</button>
                                  </form>

                                </td>


                              </tr>
                              <?php } ?>
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