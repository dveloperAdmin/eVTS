<?php
include '../include/_dbconnect.php';

include '../include/_session.php';
include '../include/_lic_check.php';
$des = "Page Load Employe View";
$rem = "Employe View";
$head = "Employe Info";
include '../include/_audi_log.php';
include '../include/_function.php';

$user_emp_id = $emp_id;
$printNoBlank = "";
$printCountEmp="";
// echo $user_role;
if (in_array($user_role, array("Developer", "Super Admin"))) {
  $serach_emp = mysqli_query($conn, "select * from `eomploye_details` order by `EmployeeId` desc");
  $sql_empdetails = mysqli_query($conn, "select * from eomploye_details order by case when EmployeeId = '$emp_id' then 1 else 0 end, EmployeeId;");
  $sql_no_of_working_emp = mysqli_num_rows(mysqli_query($conn, "select * from `eomploye_details` where `Status`='Working'"));
  $sql_no_of_resign_emp = mysqli_num_rows(mysqli_query($conn, "select * from `eomploye_details` where `Status`='Resign'"));
  $numOfBlankMailId = mysqli_fetch_assoc(mysqli_query($conn, "select count(*) as num_row from eomploye_details where email_id in ('nomail@gmail.com', '', NULL);"));

  $countSql = mysqli_query($conn, "select * from `eomploye_details`");
} else {
  $serach_emp = mysqli_query($conn, "select * from `eomploye_details` where `BranchId`='$branch_id' order by `EmployeeId` desc");
  $sql_empdetails = mysqli_query($conn, "select * from eomploye_details where BranchId='$branch_id'order by case when EmployeeId = '$emp_id' then 1 else 0 end, EmployeeId");
  ;
  $sql_no_of_working_emp = mysqli_num_rows(mysqli_query($conn, "select * from `eomploye_details` where `BranchId`='$branch_id' and `Status`='Working'"));
  $sql_no_of_resign_emp = mysqli_num_rows(mysqli_query($conn, "select * from `eomploye_details` where `BranchId`='$branch_id' and `Status`='Resign'"));

  $numOfBlankMailId = mysqli_fetch_assoc(mysqli_query($conn, "select count(*) as num_row from eomploye_details where `BranchId`='$branch_id' and email_id in ('nomail@gmail.com', '', NULL);"));
  $countSql = mysqli_query($conn, "select * from `eomploye_details` where `BranchId`='$branch_id'");
}

if ($numOfBlankMailId['num_row'] >= 1) {
  $printNoBlank = "NO Mail Id :- &nbsp;" . $numOfBlankMailId['num_row'];
}

if ($count = mysqli_num_rows($countSql)) {
  $printCountEmp = "Number of Employees :- &nbsp;" . $count;
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
                      <div class="row">


                        <div class="col-md-6">
                          <div class="form-group row" style="margin:5px;">
                            <label class="col-sm-3 col-form-label" style="padding-right: 0;flex:0 0 10%;">Search</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" placeholder="Search" id="searchInput"
                                style="width:60%">

                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row" style="margin:5px; justify-content: end;">
                            <label class="col-sm-3 col-form-label"
                              style="flex:0 0 38%; max-width:38%;text-align:right;    font-style: italic;font-weight: 700;"><?= $printNoBlank ?></label>
                            <label class="col-sm-3 col-form-label"
                              style="flex:0 0 38%; max-width:38%;text-align:right;    font-style: italic;font-weight: 700;"><?= $printCountEmp ?></label>

                          </div>
                        </div>
                      </div>
                      <div class="card-block table-border-style" style="padding-top:7px;">
                        <div class="table-responsive table-short" style="height: 385px;">
                          <table class="table" id="dataTable">
                            <thead>
                              <tr>
                                <th style="width: 5rem;">Sl No.</th>
                                <th>Employee Code</th>
                                <th>Employee Name</th>
                                <th>Branch</th>
                                <th>Department</th>
                                <th>Location</th>
                                <th>Employee Type</th>
                                <th>Status</th>
                                <th colspan=2 style="  width: 18%;">Action</th>
                              </tr>
                            </thead>
                            <tbody>

                              <?php $i = 0;
                              while ($emp_data = mysqli_fetch_assoc($sql_empdetails)) {
                                $i++;




                                $department = $emp_data['DepartmentId'];
                                $department_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `department` where `department_code` ='$department'"));
                                if ($department_details != "") {
                                  $department = $department_details['department_name'];
                                } else {
                                  $department = "";
                                }
                                $emp_role = "";
                                $emp_id = $emp_data['EmployeeId'];
                                $user_data_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `EmployeeId`='$emp_id'"));
                                if ($user_data_sql != "") {
                                  $emp_role = $user_data_sql['user_role'];
                                }

                                // echo $emp_id;
                                // if($emp_role == 'Super Admin' && $user_role!='Developer'){
                                //     continue;
                                // }
                                if (in_array($emp_data['email_id'], array('nomail@gmail.com', "", null))) {
                                  $bgcolor = "#ff000024";
                                } else {
                                  $bgcolor = "#ffffff";
                                }
                                ?>
                                <tr style="background-color:<?= $bgcolor ?>">
                                  <th scope="row" style="padding: .25rem;">
                                    <?php echo $i; ?>
                                  </th>
                                  <td style="padding: .25rem;">
                                    <?php echo $emp_data['Emp_code']; ?>
                                  </td>
                                  <td style="padding: .25rem;">
                                    <?php echo ucfirst($emp_data['EmployeeName']); ?>
                                  </td>
                                  <td style="padding: .25rem;"><?= findBranch($conn, $emp_data['BranchId']) ?>
                                  </td>
                                  <td style="padding: .25rem;"><?php echo $department; ?>
                                  </td>
                                  <td style="padding: .25rem;">
                                    <?php echo $emp_data['Location']; ?>
                                  </td>
                                  <td style="padding: .25rem;">
                                    <?php echo $emp_data['EmployeType']; ?>
                                  </td>
                                  <td style="padding: .25rem;">
                                    <?php echo ucfirst($emp_data['Status']); ?>
                                  </td>
                                  <?php if ($emp_data['EmployeeId'] == $user_emp_id) { ?>
                                    <td style="padding: .25rem;" colspan="2">
                                      <form action="new-employe" method="post">
                                        <input type="hidden" name="emp_id" value="<?php echo $emp_data['EmployeeId']; ?>">
                                        <input type="hidden" name="view" value="true">
                                        <button class="btn waves-effect waves-light btn-success btn-outline-success"
                                          name="emp_edit" style="padding: 5px 13px; width:90%"><i
                                            class="icofont icofont-eye-alt"></i>View</button>
                                      </form>

                                    </td>

                                  <?php } else { ?>
                                    <td style="padding: .25rem;">
                                      <form action="new-employe" method="post">
                                        <input type="hidden" name="emp_id" value="<?php echo $emp_data['EmployeeId']; ?>">
                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                          name="emp_edit" style="padding: 5px 13px;"><i
                                            class="icofont icofont-ui-edit"></i>Edit</button>
                                      </form>

                                    </td>
                                    <td style="padding: .25rem;">
                                      <?php
                                      $userDetails = userDetails($conn, $emp_data['EmployeeId']);
                                      if ($userDetails != null && in_array($userDetails['user_role'], array("Developer", "Super Admin", "Admin"))) {
                                        $disbale = "disabled";
                                      } else {
                                        $disbale = "";
                                      }

                                      ?>

                                      <a href="emp_process?del_id=<?php echo $emp_data['EmployeeId']; ?> "
                                        class="delt_href">
                                        <button class="btn waves-effect waves-light btn-danger btn-outline-danger"
                                          style="padding: 5px 13px;" <?= $disbale ?>><i
                                            class="icofont icofont-delete-alt"></i>Delete</button>
                                      </a>
                                    </td>
                                  <?php } ?>
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
  $("#searchInput").keyup(function () {
    var searchText = $(this).val().toLowerCase();

    $("#dataTable tbody tr").each(function () {
      var rowData = $(this).text().toLowerCase();
      if (rowData.indexOf(searchText) === -1) {
        $(this).hide();
      } else {
        $(this).show();
      }
    });
  });

  $('.delt_href').on('click', function (e) {
    e.preventDefault();
    // console.log(e);
    var href = $(this).attr('href')


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

      } else {

      }
    })
    $(':focus').blur();
  })
</script>

</html>