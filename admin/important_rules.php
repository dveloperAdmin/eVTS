<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des = "Page Load Important_rules ";
$rem = "Rules";
$head = "Rules SetUp";
include '../include/_audi_log.php';

$sql_rule_details = mysqli_query($conn, "select * from `rules` order by `id` desc");
//edit data fetch start
$q = false;
$rule_name = "";
$rule_code = "";
if (isset($_GET['id'])) {
    $q = true;
    $rule_code = $_GET['id'];
    $get_rule_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `rules` where `id`='$rule_code'"));
    $rule_name = $get_rule_details['rules'];
}
//edit data fetch end



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
                      <?php if ($q != true) { ?>
                      <div class="col-md-6">
                        <div class="card" style="margin-bottom: 8px;">
                          <div class="card-header" style="padding-bottom:8px;padding-top:8px;">
                            <h5>Importent Rules Details</h5>
                          </div>
                          <div class="card-block">
                            <form action="process" method="post">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label" style="padding-right: 0;">Rules</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" placeholder="EnterImportant Rules"
                                    name="rules" required>
                                </div>
                              </div>

                              <div class="user-entry">

                                <a href="important_rules"><button type="button"
                                    class="btn waves-effect waves-light btn-inverse btn-outline-inverse"
                                    style="padding: 7px 20px;"><i class="icofont icofont-exchange"></i>Cancel</button>
                                </a>
                                <button type="submit"
                                  class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                  style="padding: 7px 20px;" name="rules_sub"><i class="fa fa-plus"
                                    style="    font-size: 20px;margin-right: 10px;"></i>
                                  Add Rules</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <?php } ?>





                      <?php if ($q == true) { ?>

                      <div class="col-md-6">
                        <div class="card" style="margin-bottom: 8px;">
                          <div class="card-header" style="padding-bottom:8px;padding-top:8px;">
                            <h5 style="width: 81%;"> Update Rules </h5>

                          </div>
                          <div class="card-block">
                            <form action="process" method="post">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label" style="padding-right: 0;">Rules</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" placeholder="Enter Important Rule"
                                    name="rules" required value="<?php echo $rule_name; ?>">
                                </div>
                              </div>
                              <input type="hidden" name="rule_sl" value="<?php echo $rule_code; ?>">

                              <div class="user-entry">

                                <a href="important_rules"><button type="button"
                                    class="btn waves-effect waves-light btn-inverse btn-outline-inverse"
                                    style="padding: 7px 20px;"><i class="icofont icofont-exchange"></i>Cancel</button>
                                </a>
                                <button type="submit"
                                  class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                  style="padding: 7px 20px;" name="up_rule"><i class="fa fa-upload"
                                    style="    font-size: 20px;margin-right: 10px;"></i>Update
                                  Rules</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                      <div class="col-md-6">

                        <div class="card text-center order-visitor-card" id="total-subdept" style="margin-bottom:8px">
                          <div class="card-block dsh-card signle-dash">
                            <i class="fa fa-institution m-r-15 text-c-black" id="rotate"></i>
                            <div class="card-text">
                              <h6 class="m-b-0">TOTAL RULES</h6>
                              <h4 class="m-t-15 m-b-15"><?php $total_rule = mysqli_num_rows($sql_rule_details);
                                                            echo $total_rule . " / 10"; ?> </h4>
                              <p class="m-b-0" style="font-weight: bold;    font-size: 15px;"> </p>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                    <div class="card">
                      <div class="card-block table-border-style">
                        <div class="table-responsive table-short">
                          <table class="table">
                            <thead>
                              <tr>
                                <th style="width: 5rem;">Sl No.</th>
                                <th>Rules</th>

                                <th colspan=2 style="  width: 30%;">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $i = 0;
                                                            while ($rule_data = mysqli_fetch_assoc($sql_rule_details)) {
                                                                $i++ ?>
                              <tr>
                                <th scope="row"><?php echo $i; ?></th>
                                <td style="font-weight:700; color:green;">
                                  <?php echo ucfirst($rule_data['rules']); ?>
                                </td>


                                <td class="th_width">
                                  <a href="important_rules?id=<?php echo $rule_data['id']; ?> ">
                                    <button class="btn waves-effect waves-light btn-primary btn-outline-primary"><i
                                        class="icofont icofont-ui-edit"></i>Edit</button>
                                  </a>
                                </td>
                                <td class="th_width">
                                  <a href="process?rulid=<?php echo $rule_data['id']; ?> " class="delt_href">
                                    <button class="btn waves-effect waves-light btn-danger btn-outline-danger"><i
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