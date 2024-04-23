<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des = "Page Load View visitor Log";
$rem = "View visitor Log";
$head = "Visitor Info";
include '../include/_audi_log.php';
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
        $sql_udate = mysqli_query($conn, "update `visitor_log` set `Emp_approve`='$v_permit' where `visit_uid`='$v_id'");
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
    $sql_vistor = mysqli_query($conn, "select * from `visitor_log` where `emp_id`='$emp_code' and `Emp_approve`!='Pending' order by `sl_no` desc");
    $serach_visit = mysqli_query($conn, "select distinct `visitor_id` from `visitor_log` where `emp_id`='$emp_code' and `Emp_approve`!='Pending' order by `sl_no` desc");
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
                      <div class="col-md-6" style="    padding-top: 1rem;">
                        <div class="form-group row" style="margin:5px;">
                          <label class="col-sm-3 col-form-label" style="padding-right: 0;">Search By Name </label>
                          <div class="col-sm-9">
                            <input list="emp_name" type="text" class="form-control" placeholder="Search By Visitor Name"
                              id="myInput" onkeyup="quickSearch()">
                            <datalist id="emp_name">
                              <?php
                                                            while ($visit_data = mysqli_fetch_assoc($serach_visit)) { ?>
                              <option value="<?php $v_nam = "";
                                                                if ($visit_data != "") {
                                                                    $visitor_id = $visit_data['visitor_id'];
                                                                    $visitor_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_info` where `visitor_id` = '$visitor_id' "));

                                                                    if ($visitor_details != "") {
                                                                        $v_nam = $visitor_details['name'];

                                                                    }
                                                                }
                                                                echo ucfirst($v_nam); ?>">
                              </option>
                              <?php } ?>
                            </datalist>
                          </div>
                        </div>
                      </div>
                      <div class="card-block table-border-style">
                        <div class="table-responsive table-short" style="height: 376px;">
                          <table class="table" id="myTable">
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

                                <th style="padding-bottom:2px;padding-top:2px;">Your
                                  Permission</th>
                                <th style="padding-bottom:2px;padding-top:2px;">Secqu.
                                  Permission</th>
                                <th style="padding-bottom:2px;padding-top:2px;">Entry
                                  Status</th>
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
                                <td style="padding:1px;">
                                  <?php echo $visitor_data['register_type']; ?></td>

                                <td style="padding:1px;"><?php
                                                                    if ($visitor_data['Emp_approve'] == 'Pending') {
                                                                        echo "<span style='color:blue; font-weight:700;'>" . $visitor_data['Emp_approve'] . "</span>";
                                                                    } else if ($visitor_data['Emp_approve'] == 'Approve') {
                                                                        echo "<span style='color:green; font-weight:700;'>" . $visitor_data['Emp_approve'] . "</span>";
                                                                    } else {
                                                                        echo "<span style='color:red; font-weight:700;'>" . $visitor_data['Emp_approve'] . "</span>";
                                                                    }
                                                                    ?></td>
                                <td style="padding:1px;"><?php
                                                                    if ($visitor_data['security_approval'] == 'Pending') {
                                                                        echo "<span style='color:blue; font-weight:700;'>" . $visitor_data['security_approval'] . "</span>";
                                                                    } else if ($visitor_data['security_approval'] == 'Approve') {
                                                                        echo "<span style='color:green; font-weight:700;'>" . $visitor_data['security_approval'] . "</span>";
                                                                    } else {
                                                                        echo "<span style='color:red; font-weight:700;'>" . $visitor_data['security_approval'] . "</span>";
                                                                    }
                                                                    ?></td>
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