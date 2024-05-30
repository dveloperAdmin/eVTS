<?php
include "include/_dbconnect.php";

date_default_timezone_set("Asia/Calcutta");
$current_date = date("d-M-Y");
$current_time = date("H:i:s");
$current_month = date("M");
$current_Year = date("Y");
$current_date_time = $current_date . " - " . $current_time;

function mac_id()
{
  ob_start();

  //Getting configuration details 
  system('ipconfig /all');

  //Storing output in a variable 
  $configdata = ob_get_contents();

  // Clear the buffer  
  ob_clean();

  //Extract only the physical address or Mac address from the output
  $mac = "Physical";
  $pmac = strpos($configdata, $mac);

  // Get Physical Address  
  $macaddr = substr($configdata, ($pmac + 36), 17);

  //Display Mac Address  
  return ($macaddr);
}



if (isset($_POST['log_submit'])) {

  try {



    if (file_get_contents('src/license.lic') != "") {

      $myFile = fopen("src/license.lic", 'r');
      $id = "";
      for ($i = 1; $i <= 29; $i++) {
        $id .= fgetc($myFile);
      }
      fclose($myFile);

      $theData = file("src/license.lic");
      $id_key = "";
      if ($theData[1] != "") {
        $id_key = $theData[1];

      }

      $db_id = "";
      $active_key = mysqli_fetch_assoc(mysqli_query($conn, "select * from `activation_key` where `key_id`='$id_key'"));
      if ($active_key != "") {
        $db_id = $active_key['activation_key'];
      }

      // if($db_id!=""){

      if (password_verify($id, $db_id)) {

        $ac_co = substr($id, 0, 2);
        $mac_id = substr($id, 2, 2) . "-" . substr($id, 10, 2) . "-" . substr($id, 18, 2) . "-" . substr($id, 22, 2) . "-" . substr($id, 14, 2) . "-" . substr($id, 6, 2);




        $ac_date = substr($id, 4, 2) . substr($id, 8, 2) . substr($id, 12, 2) . substr($id, 26, 3);
        ;
        $m_date = ($ac_date / 7);
        $date = substr($m_date, 0, 4) . "-" . substr($m_date, 4, 2) . "-" . substr($m_date, 6, 2);


        if (date("Y-m-d") <= $date) {
          $ac_user = substr($id, 16, 2) . substr($id, 20, 2) . substr($id, 24, 2);
          $users = (($ac_user / 12) - 57);
          $nunber_of_emp = mysqli_num_rows(mysqli_query($conn, "select * from `eomploye_details`"));



          $run = mysqli_query($conn, "update `activation_key` set `date_expire`='$date', `no_of_user`='$users' where `key_id`='$id_key' ");



          $u_name = $_POST['u_name'];
          $pass = $_POST['u_pass'];
          $exists_sql = mysqli_query($conn, "select * from `user` where `user_name`='$u_name'");
          $no_of_data = mysqli_num_rows($exists_sql);
          $user_data = mysqli_fetch_assoc($exists_sql);
          if ($no_of_data == 1) {
            $db_pass = $user_data['password'];
            $user_id = $user_data['uid'];

            if (password_verify($pass, $db_pass)) {
              $user_sts = $user_data['user_sts'];

              if ($user_sts == 'Active') {
                $user_role = $user_data['user_role'];

                $mac = mac_id();
                // if($mac == $mac_id){ 
                if (in_array($user_role, array("Developer", "Super Admin", "Admin"))) {

                  session_start();
                  $_SESSION['user_name'] = $user_data['user_name'];
                  // $_SESSION['name'] = $user_data['name'];
                  $_SESSION['user_id'] = $user_id;
                  $_SESSION['loged_in'] = true;
                  $_SESSION['no_of_users'] = $users;

                  //insert into log table
                  $no_of_logs = mysqli_num_rows(mysqli_query($conn, "select * from `log_book`"));
                  $log_uid = "LOG-" . ($no_of_logs + 1) . '-' . date('mysh');
                  $log_sql = mysqli_query($conn, "insert into `log_book`(`uid`, `user_id`, `login_date`, `login_time`, `log_month`, `log_year`) values ('$log_uid','$user_id','$current_date ','$current_time','$current_month','$current_Year')");
                  $today = new DateTime(date("Y-m-d"));
                  $expiryDay = new DateTime($date);
                  if (($expiryDay->diff($today))->format("%a") <= 15) {
                    $valid = $today;

                    $_SESSION['icon_ad'] = 'warning';
                    $_SESSION['status_ad'] = 'Your license will be expire soon...';
                  }

                  //employe Check with activation key users
                  if ($nunber_of_emp <= $users) {
                    header("location:admin");
                    $_SESSION['log_id'] = $log_uid;

                  } else {
                    header("location:admin/about_license.php");
                  }





                } else if ($user_role == 'Security') {
                  $emp_check_id = $user_data['EmployeeId'];

                  $sql_emp_check = mysqli_num_rows(mysqli_query($conn, "select * from `eomploye_details` where `EmployeeId`='$emp_check_id'"));
                  if ($sql_emp_check == 1) {
                    // if($nunber_of_emp<=$users){


                    session_start();
                    $_SESSION['user_name'] = $user_data['user_name'];
                    // $_SESSION['name'] = $user_data['name'];
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['loged_in'] = true;

                    //insert into log table
                    $no_of_logs = mysqli_num_rows(mysqli_query($conn, "select * from `log_book`"));
                    $log_uid = "LOG-" . ($no_of_logs + 1) . '-' . date('mysh');
                    $log_sql = mysqli_query($conn, "insert into `log_book`(`uid`, `user_id`, `login_date`, `login_time`, `log_month`, `log_year`) values ('$log_uid','$user_id','$current_date ','$current_time','$current_month','$current_Year')");
                    $today = new DateTime(date("Y-m-d"));
                    $expiryDay = new DateTime($date);
                    if (($expiryDay->diff($today))->format("%a") <= 15) {
                      $valid = $today;

                      $_SESSION['icon_ad'] = 'warning';
                      $_SESSION['status_ad'] = 'Your license will be expire soon...';
                    }
                    if ($log_sql) {
                      $_SESSION['log_id'] = $log_uid;
                      header("location:Security");


                    } else {
                      header("location:include/_logout.php");
                    }
                    // }else{
                    //   session_start();
                    //   $_SESSION['icon'] = 'warning';
                    //   $_SESSION['status']='User Overloaded....';
                    // }
                  } else {
                    session_start();
                    $_SESSION['icon'] = 'info';
                    $_SESSION['status'] = 'Employee Not Exist';
                  }
                } else if ($user_role == 'User') {
                  $emp_check_id = $user_data['EmployeeId'];

                  $sql_emp_check = mysqli_num_rows(mysqli_query($conn, "select * from `eomploye_details` where `EmployeeId`='$emp_check_id'"));
                  if ($sql_emp_check == 1) {
                    // if($nunber_of_emp<=$users){


                    session_start();
                    $_SESSION['user_name'] = $user_data['user_name'];
                    // $_SESSION['name'] = $user_data['name'];
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['loged_in'] = true;

                    //insert into log table
                    $no_of_logs = mysqli_num_rows(mysqli_query($conn, "select * from `log_book`"));
                    $log_uid = "LOG-" . ($no_of_logs + 1) . '-' . date('mysh');
                    $log_sql = mysqli_query($conn, "insert into `log_book`(`uid`, `user_id`, `login_date`, `login_time`, `log_month`, `log_year`) values ('$log_uid','$user_id','$current_date ','$current_time','$current_month','$current_Year')");
                    $today = new DateTime(date("Y-m-d"));
                    $expiryDay = new DateTime($date);
                    if (($expiryDay->diff($today))->format("%a") <= 15) {
                      $valid = $today;

                      $_SESSION['icon_ad'] = 'warning';
                      $_SESSION['status_ad'] = 'Your license will be expire soon...';
                    }
                    if ($log_sql) {
                      $_SESSION['log_id'] = $log_uid;
                      header("location:user");


                    } else {
                      header("location:include/_logout.php");
                    }
                    // }else{
                    //   session_start();
                    //   $_SESSION['icon'] = 'warning';
                    //   $_SESSION['status']='User Overloaded....';
                    // }
                  } else {
                    session_start();
                    $_SESSION['icon'] = 'info';
                    $_SESSION['status'] = 'Employee Not Exist';
                  }
                }
                // }else{
                //   session_start();
                //   $_SESSION['icon'] = 'warning';
                //   $_SESSION['status']='Mac ID Miss Match'; 
                // }
              } else {
                session_start();
                $_SESSION['icon'] = 'info';
                $_SESSION['status'] = 'De-Active Account';
              }
            } else {
              session_start();
              $_SESSION['icon'] = 'error';
              $_SESSION['status'] = 'Invalid Password';
            }

          } else {
            session_start();
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Invalid Login Cradential';
          }
        } else {
          session_start();
          $_SESSION['icon'] = 'warning';
          $_SESSION['status'] = 'Activation Key Expired';
        }


      } else {
        session_start();
        $_SESSION['icon'] = 'warning';
        $_SESSION['status'] = 'Invalid The Activation Key';
      }
      // }else{
      //   session_start();
      //   $_SESSION['icon'] = 'warning';
      //   $_SESSION['status']='Activation Key Unavailable....';
      // }
    } else {
      session_start();
      $_SESSION['icon'] = 'warning';
      $_SESSION['status'] = 'No Activation Key Contact To Your Supplier.. ';

    }
  } catch (Exception $e) {
    session_start();
    $_SESSION['icon'] = 'warning';
    $_SESSION['status'] = $e;
  }

}







?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Aboreto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="log/fonts/icomoon/style.css">

  <link rel="stylesheet" href="log/css/owl.carousel.min.css">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="log/css/bootstrap.min.css">

  <!-- Style -->
  <link rel="stylesheet" href="log/css/style1.css">
  <script src="js/sweetalert2.js"></script>

  <title>eVTS</title>
  <link rel="icon" href="admin/assets/images/favicon.png" type="image/x-icon">
</head>

<body>



  <div class="mb-4" style="text-align:center; padding-top: 2rem; padding-bottom:3rem;">
    <h3 id="log">Easy Visitor Tracking System </h3>
    <p class="mb-4"></p>
  </div>
  <div class="content" style="padding:0;">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="log/images/undraw_remotely_2j6y.svg" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
            </div>
            <div class="col-md-8">
              <div class="mb-4">
                <h3 id="log">Sign In</h3>
                <p class="mb-4"></p>
              </div>
              <form action="" method="post">
                <div class="form-group first">
                  <label for="username">Username</label>
                  <input type="text" class="form-control" name="u_name" autocomplete="off"
                    oninput="this.value = this.value.toUpperCase()" autofocus required>

                </div>
                <div class="form-group last mb-4">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" name="u_pass" autocomplete="off" required>

                </div>

                <div class="d-flex mb-5 align-items-center">
                  <label class="control control--checkbox mb-0" style="padding:0"><a href="supplier.php"><span
                        class="caption">Suppler Details</span></a></label>
                  <span class="ml-auto"><a href="src/srcindex.php" class="forgot-pass"> System
                      Activation</a></span>
                </div>

                <input type="submit" value="Log In" class="btn btn-block btn-primary" name="log_submit"
                  style="margin-bottom:1rem;">
              </form>
            </div>
          </div>
          <span class="ml-auto"
            style="display: grid; place-content: center;font-size: 15px; padding-left: .6rem;    margin-top: 1rem;color: #7a7070;">
            A Compelete Solution of Visitor Tracking System </span>
        </div>
      </div>
    </div>
  </div>
  </div>


  <?php

  if (isset($_GET['i'])) {
    if ($_GET['i'] == 'y') { ?>
      <script>
        Swal.fire({
          icon: 'success',
          title: 'System Activated',
          showCloseButton: true,
          confirmButton: true,

        })
      </script>
    <?php } elseif ($_GET['i'] == 1) { ?>
      <script>
        Swal.fire({
          icon: 'error',
          title: 'User Overloaded....',
          showCloseButton: true,
          confirmButton: true,

        })
      </script>
    <?php } elseif ($_GET['i'] == 2) { ?>
      <script>
        Swal.fire({
          icon: 'error',
          title: 'License Expired....',
          showCloseButton: true,
          confirmButton: true,

        })
      </script>
    <?php } elseif ($_GET['i'] == 3) { ?>
      <script>
        Swal.fire({
          icon: 'error',
          title: 'Invalid License',
          showCloseButton: true,
          confirmButton: true,

        })
      </script>
      </script>
    <?php } elseif ($_GET['i'] == 'n') { ?>
      <script>
        Swal.fire({
          icon: 'error',
          title: 'System Not Activated',
          showCloseButton: true,
          confirmButton: true,

        })
      </script>

    <?php } else { ?>
      <script>
        Swal.fire({
          icon: 'error',
          title: 'Database Not Connect Properly..',
          showCloseButton: true,
          confirmButton: true,

        })
      </script>
      <?php
    }
  }
  ?>




  <?php
  if (isset($_SESSION['status']) && $_SESSION['status'] != '') { ?>
    <script>
      Swal.fire({
        icon: '<?php echo $_SESSION['icon'] ?>',
        title: '<?php echo $_SESSION['status'] ?>',
        showCloseButton: true,
        confirmButton: true,

      })
    </script>
    <?php
    unset($_SESSION['status']);
    unset($_SESSION['icon']);
    // session_destroy();
  } ?>
  <script src="log/js/jquery-3.3.1.min.js"></script>
  <script src="log/js/popper.min.js"></script>
  <script src="log/js/bootstrap.min.js"></script>
  <script src="log/js/main.js"></script>
</body>

</html>