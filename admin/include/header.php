<?php
include '../include/_dbconnect.php';
$user_id = $_SESSION['user_id'];
$login = "";
$logout = "";
$user_data_sql = mysqli_fetch_assoc(mysqli_query($conn,"select * from `user` where `uid`='$user_id'"));
$total_last_log = mysqli_query($conn,"select * from `log_book` where `user_id`='$user_id' order by `sl_no` desc");
$no_of_toal_log  = mysqli_num_rows($total_last_log);

if($no_of_toal_log>1){

    for($i =($no_of_toal_log-2); $i<$no_of_toal_log; $i++){
        $last_log = mysqli_fetch_assoc($total_last_log);
        $login = $last_log['login_date'].' - '.$last_log['login_time'];
        $logout = $last_log['logout_date'].' - '.$last_log['logout_time'];
    }
}else{
    $login = " - ";
    $logout = " - ";
}


?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10"><?php echo $head;?></h5>
                    <p class="m-b-0">Welcome  <?php echo $user_data_sql['name'];?> </p>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="">Last Log Details  </a>
                    </li>
                    <li class="breadcrumb-item">
                    <i class="fa fa-sign-in" aria-hidden="true"> <?php echo $login;?> </i> <br><i class="fa fa-sign-out" aria-hidden="true" style="padding-left: 1.3rem;"> <?php echo $logout;?> </i>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>