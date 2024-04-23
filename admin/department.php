<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des = "Page Load Department";
$rem = "Department";
$head = "Deparment setUp";
include '../include/_audi_log.php';

$sql_fetch_department_data = mysqli_query($conn, "select * from `department` order by `sl_no` desc");
$e = false;
$dp_name = "";
if (isset($_POST['sub_edit_dp'])) {
    $edit_id = $_POST['edit_dp'];
    $sql_check = mysqli_query($conn, "select * from `department` where `department_code`='$edit_id'");
    if (mysqli_num_rows($sql_check) == 1) {
        $e = true;
        $fetch_dp_data = mysqli_fetch_assoc($sql_check);
        $dp_name = $fetch_dp_data['department_name'];


    } else {
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'You Can not Edit Deparment Details';
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
                    <div class="row">
                      <div class="col-md-6">

                        <?php if ($e != true) { ?>
                        <div class="card" style="margin-bottom: 8px;">
                          <div class="card-header" style="padding-bottom:8px;padding-top:8px;">
                            <h5>Department Details</h5>
                          </div>
                          <div class="card-block">
                            <form action="process" method="post">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label" style="padding-right: 0;">Department Name</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" placeholder="Enter Department"
                                    name="dept_name" required>
                                </div>
                              </div>




                              <div class="user-entry">

                                <a href="department"><button type="button"
                                    class="btn waves-effect waves-light btn-inverse btn-outline-inverse"
                                    style="padding: 7px 20px;"><i
                                      class="icofont icofont-exchange"></i>Cancel</button></a>
                                <button type="submit"
                                  class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                  style="padding: 7px 20px;" name="dept_insrt"><i class="fa fa-plus"
                                    style="    font-size: 20px;margin-right: 10px;"></i>Add
                                  Department</button>
                              </div>
                            </form>
                          </div>
                        </div>
                        <?php } else if ($e == true) { ?>
                        <div class="card" style="margin-bottom: 8px;">
                          <div class="card-header" style="padding-bottom:8px;padding-top:8px;">
                            <h5 style="width:80%">Update Department Details</h5>
                            <a href="department">
                              <button class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                style="padding: 7px 20px;" name="dept_update"><i class="fa fa-arrow-right"
                                  style="font-size: 20px;margin-right: 10px;"></i>Back</button>

                            </a>
                          </div>
                          <div class="card-block">
                            <form action="process" method="post">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label" style="padding-right: 0;">Department Name</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" placeholder="Enter Designation"
                                    name="updept_name" required value="<?php echo $dp_name; ?>">
                                </div>
                              </div>
                              <input type="hidden" name="edit_dp_id" value="<?php echo $edit_id; ?>">
                              <div class="user-entry">

                                <a href="department"><button type="button"
                                    class="btn waves-effect waves-light btn-inverse btn-outline-inverse"
                                    style="padding: 7px 20px;"><i
                                      class="icofont icofont-exchange"></i>Cancel</button></a>
                                <button type="submit"
                                  class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                  style="padding: 7px 20px;" name="dept_update"><i class="fa fa-arrow-up"
                                    style="font-size: 20px;margin-right: 10px;"></i>Update
                                  Department</button>
                              </div>
                            </form>
                          </div>
                        </div>
                        <?php } ?>

                      </div>

                      <div class="col-md-6">
                        <div class="card text-center order-visitor-card" id="total-dept" style="margin-bottom:8px">
                          <div class="card-block dsh-card signle-dash">
                            <i class="fa fa-linode m-r-15 text-c-black"></i>
                            <div class="card-text">
                              <h6 class="m-b-0" style="font-size: 20px">Total Department
                              </h6>
                              <h4 class="m-t-15 m-b-15" style="font-size: 40px">
                                <?php $total_dept = mysqli_num_rows($sql_fetch_department_data);
                                                                echo $total_dept; ?>
                              </h4>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-block table-border-style">
                        <div class="table-responsive table-short" style="height:200px;">
                          <table class="table">
                            <thead>
                              <tr>
                                <th style="width: 5rem;">Sl No.</th>
                                <th>Depertment Name</th>

                                <th colspan=2 style="  width: 30%;">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $i = 0;
                                                            while ($dept_fetch = mysqli_fetch_assoc($sql_fetch_department_data)) {
                                                                $i++; ?>
                              <tr>
                                <th scope="row" style="    padding: 0.35rem;">
                                  <?php echo $i; ?>
                                </th>
                                <td style="    padding: 0.35rem;">
                                  <?php echo ucfirst($dept_fetch['department_name']); ?>
                                </td>


                                <td class="th_width" style="    padding: 0.35rem;">
                                  <form action="department" method="post">
                                    <input type="hidden" name="edit_dp"
                                      value="<?php echo $dept_fetch['department_code']; ?> ">
                                    <button class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                      name="sub_edit_dp" style="    padding: 4px 13px;"><i
                                        class="icofont icofont-ui-edit"></i>Edit</button>

                                  </form>

                                </td>
                                <td class="th_width" style="    padding: 0.35rem;">
                                  <a href="process?did=<?php echo $dept_fetch['department_code']; ?>" class="delt_href">
                                    <button class="btn waves-effect waves-light btn-danger btn-outline-danger"
                                      style="    padding: 4px 13px;"><i
                                        class="icofont icofont-delete-alt"></i>Delete</button>
                                  </a>
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

          </div>
        </div>
      </div>
      <!-- Page-body end -->
    </div>




    <!-- Required Jquery -->
    <?php include "include/footer.php"; ?>
</body>
<script>
$('.delt_href').on('click', function(e) {
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

})
</script>

</html>