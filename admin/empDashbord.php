<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_function.php';
include '../include/_lic_check.php';
$des = "Page Load Employe View";
$rem = "Employe View";
$head = "Employe Info";
include '../include/_audi_log.php';

$user_emp_id = $emp_id;
// echo $user_role;
if (in_array($user_role, array("Developer", "Super Admin"))) {
  $serach_emp = mysqli_query($conn, "select * from `eomploye_details` order by `EmployeeId` desc");
  $sql_empdetails = mysqli_query($conn, "select * from `eomploye_details` order by `EmployeeId` desc");
  $sql_no_of_working_emp = mysqli_num_rows(mysqli_query($conn, "select * from `eomploye_details` where `Status`='Working'"));
  $sql_no_of_resign_emp = mysqli_num_rows(mysqli_query($conn, "select * from `eomploye_details` where `Status`='Resign'"));
} else {
  $serach_emp = mysqli_query($conn, "select * from `eomploye_details` where `BranchId`='$branch_id' order by `EmployeeId` desc");
  $sql_empdetails = mysqli_query($conn, "select * from `eomploye_details` where `BranchId`='$branch_id' order by `EmployeeId` desc");
  $sql_no_of_working_emp = mysqli_num_rows(mysqli_query($conn, "select * from `eomploye_details` where `BranchId`='$branch_id' and `Status`='Working'"));
  $sql_no_of_resign_emp = mysqli_num_rows(mysqli_query($conn, "select * from `eomploye_details` where `BranchId`='$branch_id' and `Status`='Resign'"));

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

                  <?php if (in_array($user_role, array("Developer", "Super Admin"))) {
                    include "include/branchEmpDashbord.php";
                  } else { ?>
                    <div class="page-body">
                      <!-- Page body start -->
                      <div class="row">
                        <div class="col-md-6">
                          <a href="employe-view" style="text-decoration:none;">

                            <div class="card text-center order-visitor-card" id="total-emp-emp" style="margin-bottom:8px">
                              <div class="card-block dsh-card signle-dash" style="padding:5px">
                                <i class="icofont icofont-street-view" style="font-size:8rem;"></i>
                                <div class="card-text">
                                  <h6 class="m-b-0">TOTAL Employee</h6>
                                  <h4 class="m-t-15 m-b-15">
                                    <?php echo mysqli_num_rows($sql_empdetails); ?>
                                  </h4>
                                  <p class="m-b-0"></p>
                                </div>
                                <i class="icofont icofont-architecture"
                                  style=" font-size:8rem;margin-right: 0; margin-left: 5rem;"></i>
                              </div>
                            </div>
                          </a>
                        </div>


                        <div class="col-md-6">

                          <!-- </div> -->
                          <div class="row">
                            <div class="col-md-6">
                              <div class="card text-center order-visitor-card" id="total-emp-work"
                                style="margin-bottom:8px;">
                                <div class="card-block dsh-card signle-dash">
                                  <i class="icofont icofont-live-support" style="font-size:6rem; margin-right:1rem;"></i>
                                  <div class="card-text">
                                    <h6 class="m-b-0">Working Employee</h6>
                                    <h4 class="m-t-15 m-b-15">
                                      <?php echo $sql_no_of_working_emp; ?>
                                    </h4>
                                    <p class="m-b-0"></p>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="card text-center order-visitor-card" id="total-emp-reg"
                                style="margin-bottom:8px;">
                                <div class="card-block dsh-card signle-dash">
                                  <i class="icofont icofont-wheelchair" style="font-size:6rem; margin-right:1rem;"></i>
                                  <div class="card-text">
                                    <h6 class="m-b-0">Resigned Employee</h6>
                                    <h4 class="m-t-15 m-b-15">
                                      <?php echo $sql_no_of_resign_emp; ?>
                                    </h4>
                                    <p class="m-b-0"></p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>


                    </div>

                  </div>
                </div>
              </div>
            <?php } ?>
            <!-- Page-body end -->
          </div>

        </div>
      </div>
    </div>
  </div>


  <!-- Required Jquery -->
  <?php include "include/footer.php"; ?>
</body>
<script>
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