<?php
include "_dbconnect.php";


$myFile = fopen("../src/license.lic", 'r');
$id = "";
for ($i = 1; $i <= 29; $i++) {
    $id .= fgetc($myFile);
}
fclose($myFile);

$theData = file("../src/license.lic");
$id_key = $theData[1];
$db_code = "";
$active_key = mysqli_fetch_assoc(mysqli_query($conn, "select * from `activation_key` where `key_id`='$id_key'"));
if ($active_key != "") {
    $db_code = $active_key['activation_key'];
}

if (password_verify($id, $db_code)) {
    $ac_date = substr($id, 4, 2) . substr($id, 8, 2) . substr($id, 12, 2) . substr($id, 26, 3);
    ;
    $m_date = ($ac_date / 7);
    $date = substr($m_date, 0, 4) . "-" . substr($m_date, 4, 2) . "-" . substr($m_date, 6, 2);

    if (date("Y-m-d") <= $date) {
        $ac_user = substr($id, 16, 2) . substr($id, 20, 2) . substr($id, 24, 2);
        $users = (($ac_user / 12) - 57);
        $nunber_of_emp = mysqli_num_rows(mysqli_query($conn, "select * from `eomploye_details`"));

        $acivation_key_expiry = $active_key['date_expire'];
        $activation_no_of_user = $active_key['no_of_user'];
        if ($acivation_key_expiry == $date) {
            if ($activation_no_of_user == $users) {


                if ($nunber_of_emp > $users) {
                    $_SESSION['icon'] = 'info';
                    $_SESSION['status'] = 'Employee Overloaded';
                    header("location:../admin/about_license.php");

                }
            } else {
                $_SESSION['icon'] = 'warning';
                $_SESSION['status'] = 'Employee Overloaded......';
                header("location:../admin/about_license.php");
            }

        } else {
            $_SESSION['icon'] = 'warning';
            $_SESSION['status'] = 'License Date Expired....... ';
            header("location:../admin/about_license.php");
        }

    } else {
        $_SESSION['icon'] = 'Info';
        $_SESSION['status'] = 'License Date Expired';
        header("location:../admin/about_license.php");
    }
} else {

    session_unset();
    session_destroy();
    header("location:../admin/error.php?error_id=1");


}


?>