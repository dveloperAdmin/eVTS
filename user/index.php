<?php 
include "../include/_session.php";
include "../include/_dbconnect.php";
$des="Page Load Index";
$rem="Index";
$head = "Home";
include "../include/_audi_log.php";



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
                  <!-- Page-body start -->
                  <div class="page-body">

                    <div class="card" style="padding:.5rem;    margin-bottom: 0.8rem;">
                      <div class="card-header" style="padding: 0;">
                        <div class="col-md-3">
                          <h5 id="bio_sync" style="margin: 0;">Visitor Info</h5>
                        </div>
                      </div>
                    </div>
                    <div class="row" id="timegap">
                      <!-- dashbord start -->
                      <?php include "include/visitor_info.php";?>

                      <!-- dashbord end -->
                    </div>
                    <!--  -->

                    <?php include "include/notification.php";?>

                    <!-- </div> -->
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

</html>
<?php if (isset($_SESSION['status_ad']) && $_SESSION['status_ad'] != '') { ?>
<script>
Swal.fire({
  icon: '<?php echo $_SESSION['icon_ad'] ?>',
  title: '<?php echo $_SESSION['status_ad'] ?>',
  showCloseButton: true,
  confirmButton: true,

})
</script>
<?php
    unset($_SESSION['status_ad']);
    unset($_SESSION['status_ad']);
} ?>