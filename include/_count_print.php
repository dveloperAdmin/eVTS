<?php
    $print_time = date("H:i:s");
    $print_date = date("Y-m-d");
    $print_by = $_SESSION['user_id'];
    
    // $user_data_sql = mysqli_fetch_assoc(mysqli_query($conn,"select * from `user` where `uid`='$user_id'"));

    mysqli_query($conn, "insert into `print_count`(`print_of`, `print_by`, `print_type`, `print_date`, `print_time`) values ('$print_of','$print_by','$print_type','$print_date','$print_time')");



?>