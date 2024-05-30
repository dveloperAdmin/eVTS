<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';

$des = "Page Load User View";
$rem = "User View";
$head = "User Info";
include '../include/_audi_log.php';
include '../include/_function.php';


if (isset($_GET['id'])) {
  $uid = $_GET['id'];
  if ($uid == $_SESSION['user_id']) {
    $_SESSION['icon'] = 'error';
    $_SESSION['status'] = 'User Allready Loged In...';

    $des = "Click Delete to delet User details";
    $rem = "Delete UnSuccess";
    include '../include/_audi_log.php';

  } else {
    $check_admin_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `uid`='$uid'"));
    $user_role = $check_admin_sql['user_role'];
    if ($user_role != 'Admin') {
      $sql_delete = mysqli_query($conn, "delete from `user` where `uid`='$uid' and `user_role`!='Admin'");
      if ($sql_delete) {
        $_SESSION['icon'] = 'success';
        $_SESSION['status'] = 'User Details Deletation Success...';

        $des = "Click Delete to delet users details";
        $rem = "Delete Success";
        include '../include/_audi_log.php';
      } else {
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'User Deletion not Possible..';

        $des = "Click Delete to delet users details";
        $rem = "Delete UnSuccess";
        include '../include/_audi_log.php';

      }
    } else {
      $_SESSION['icon'] = 'error';
      $_SESSION['status'] = 'You Can not Delete Admin ';
      $des = "Click Delete to delet Admin details";
      $rem = "Delete Success";
      include '../include/_audi_log.php';
    }
  }
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
                      <div class="card-block table-border-style">
                        <div class="table-responsive" style="height:390px;">
                          <table class="table">
                            <thead>
                              <tr>
                                <th style="width: 5rem;">Sl No.</th>
                                <th>Emp Code</th>
                                <th>Emp Login Id</th>
                                <th>Name</th>
                                <th>Branch</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th colspan=3 style="">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $i = 0;
                              if (in_array($user_role, array("Developer", "Super Admin"))) {
                                $sql_query_users = mysqli_query($conn, "select * from `user` where `user_role`!='Developer' order by case when `uid` = '$user_id' then 1 else 0 end, `uid` desc");

                              } else {

                                $sql_query_users = mysqli_query($conn, "select * from `user` where `BranchId` = '$branch_id' and `user_role` not in ('Developer' 'Super Admin')order by case when `uid` = '$user_id' then 1 else 0 end, `uid` desc");
                              }
                              while ($user_data = mysqli_fetch_assoc($sql_query_users)) {
                                $i++;
                                $emp_id = $user_data['EmployeeId'];

                                $sql_emp_data = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` where `EmployeeId`='$emp_id'"));
                                $branch_details_id = $sql_emp_data['BranchId'];
                                $branch_details_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `branch` where `branch_code` = '$branch_details_id'"));
                                if ($branch_details_sql != "") {
                                  $branch_name = $branch_details_sql['branch_name'];
                                } else {
                                  $branch_name = '';
                                }

                                ?>



                                <tr>
                                  <th scope="row" style="padding:.25rem;">
                                    <?php echo $i; ?>
                                  </th>
                                  <td style="padding:.25rem;"><?php if ($sql_emp_data != "") {
                                    echo $sql_emp_data['Emp_code'];
                                  } ?>
                                  </td>
                                  <td style="padding:.25rem;">
                                    <?php echo $user_data['user_name']; ?>
                                  </td>
                                  <td style="padding:.25rem;">
                                    <?php echo $user_data['name']; ?>
                                  </td>
                                  <td style="padding:.25rem;"><?php echo $branch_name; ?>
                                  </td>
                                  <td style="padding:.25rem;"><?= findDepartment($conn, $sql_emp_data['DepartmentId']) ?>
                                  </td>
                                  <td style="padding:.25rem;">
                                    <?php echo $user_data['user_role']; ?>
                                  </td>
                                  <td style="padding:.25rem;">
                                    <?php echo $user_data['user_sts']; ?>
                                  </td>
                                  <td style="padding:.25rem;">
                                    <form action="user_view_more.php" method="post">
                                      <input type="hidden" name="view_id" value="<?php echo $user_data['uid']; ?>">
                                      <button class="btn waves-effect waves-light btn-success btn-outline-success"
                                        name="view" style="padding: 5px 13px;"><i
                                          class="icofont icofont-eye-alt"></i>View</button>

                                    </form>


                                  </td>
                                  <?php if ($user_data['uid'] != $user_id) { ?>
                                    <td style="padding:.25rem;">
                                      <form action="user_edit.php" method="post">
                                        <input type="hidden" name="edit_id" value="<?php echo $user_data['uid']; ?>">
                                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                          name="edit" style="padding: 5px 13px;"><i
                                            class="icofont icofont-ui-edit"></i>Edit</button>
                                      </form>
                                    </td>
                                    <td style="padding:.25rem;">
                                      <?php
                                      if (in_array($user_data['user_role'], array("Developer", "Super Admin", "Admin"))) {
                                        $disbale = "disabled";
                                      } else {
                                        $disbale = "";
                                      }
                                      ?>
                                      <a href="user_view.php?id=<?php echo $user_data['uid']; ?>" class="delt_href">
                                        <button class="btn waves-effect waves-light btn-danger btn-outline-danger btn"
                                          name="delete"
                                          style="outline: none;box-shadow: none; padding: 5px 13px;background-color:none"
                                          <?= $disbale ?>><i class="icofont icofont-delete-alt"></i>Delete</button>
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

</html>
<script>
  $('.delt_href').on('click', function (e) {
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

      } else {

      }
    })
    $(':focus').blur();
  })
</script>