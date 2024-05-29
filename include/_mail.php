<?php
// $url = "";

// if ($url == "") {
// 	$url_host = gethostname();
// } else {
// 	$url_host = $url;
// }
// $ipaddress_server = gethostbynamel($url_host);
// $localhost = end($ipaddress_server) . ":" . $_SERVER['SERVER_PORT'];
$mail_id = $destination_mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
// $mail->Username = 'anibanpal20d@gmail.com';
// $mail->Password = 'zzzeunvdidndirhg';
$mail->Username = 'vmsbiotech@gmail.com';
$mail->Password = 'ejriaslfthootojd';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->setFrom('vmsbiotech@gmail.com', 'VMS');
$mail->addAddress($mail_id);
if ($attechment != "") {
	$mail->addAttachment($attechment);

}


$mail->isHTML(true);

$mail->Subject = "Visitor Verification - " . $visit_code;
$mail->Body =
	'
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Colorful Designer Email</title>
        <!-- Include Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: "Roboto", Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
                color: #102265;
								text-align: left;
            }
            .email-container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .header {
                background-color:f6ff005c;
                background-size: cover;
                background-position: center;
                color: #102265;
                text-align: center;
                padding: 40px 20px;
                font-family: "Roboto", Arial, sans-serif;
            }
            .header h1 {
                margin: 0;
                font-size: 36px;
                font-weight: 700;
            }
            .content {
                padding: 20px;
                text-align: left;
            }
            .content p {
                line-height: 1.6;
                margin: 20px 0;
            }
            .button-container {
                margin: 20px 0;
            }
            .button {
                background-color: #6a1b9a;
                color: #ffffff;
                padding: 15px 30px;
                text-decoration: none;
                border-radius: 5px;
                font-size: 16px;
                display: inline-block;
            }
            .footer {
                background-color: #eeeeee;
                color: #777777;
                text-align: left;
                padding: 10px;
                font-size: 14px;
            }
            .table-container {
                margin: 20px 0;
                text-align: left;
                width: 100%;
                border-collapse: collapse;
            }
            .table-container th, .table-container td {
                border: 1px solid #dddddd;
                padding: 8px;
                text-align: left;
            }
            .table-container th {
                background-color: #f2f2f2;
                font-weight: 700;
            }
            .table-container tr:nth-child(even) {
                background-color: #f9f9f9;
            }
            .table-container tr:hover {
                background-color: #f1f1f1;
            }
        </style>
    </head>
    <body>
        <div class="email-container">
            <div class="header">
                <h1>Welcome to eVTS Service!</h1>
            </div>
            <div class="content">
                <p>Hi &nbsp;' . $employeName . ',</p>
                <p>' . $emp_name_mail . '&nbsp; came to visit with you please check out the details of the visitor given bellow. 
								<p>Please verify the visitor and approve or reject to visit with this visitor.<p>
								<p>This is auto generated mail, please do not reply on that mail. If anything required, please contact with us.</p>
								<p>Thank, you.</p> </p>
                
                <p>Here is the Visitor information:</p>
                <table class="table-container">
                    <tbody>
                        ' . $html . '
                    </tbody>
                </table>
               
            </div>
            <div class="footer">
               ' . $button . '
            </div>
        </div>
    </body>
    </html>
    ';
$mail->send();



?>