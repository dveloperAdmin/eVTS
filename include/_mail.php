<?php
$url="";

if($url==""){
	$url_host =  gethostname();
}else{
	$url_host = $url;
}
$ipaddress_server= gethostbynamel($url_host);
$localhost = end($ipaddress_server).":".$_SERVER['SERVER_PORT'];
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
if($attechment!=""){
	$mail->addAttachment($attechment);

}


$mail->isHTML(true);

$mail->Subject = "Visitor Verification - ".$visit_code;
$mail->Body = "<!DOCTYPE html>
<html lang='en'>

<head>
	<meta charset='utf-8'> <!-- utf-8 works for most cases -->
	<meta name='viewport' content='width=device-width'> <!-- Forcing initial-scale shouldn't be necessary -->
	<meta http-equiv='X-UA-Compatible' content='IE=edge'> <!-- Use the latest (edge) version of IE rendering engine -->
	<meta name='x-apple-disable-message-reformatting'> <!-- Disable auto-scale in iOS 10 Mail entirely -->
	<title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

	<link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet'>
	<link href='https://fonts.googleapis.com/css2?family=Philosopher&family=Ysabeau+Office:wght@500&display=swap'
		rel='stylesheet'>

	<style>
		html,
		body {
			margin: 0 auto !important;
			padding: 0 !important;
			height: 100% !important;
			width: 100% !important;
			background: #f1f1f1;
		}

		/* What it does: Stops email clients resizing small text. */
		* {
			-ms-text-size-adjust: 100%;
			-webkit-text-size-adjust: 100%;
		}

		/* What it does: Centers email on Android 4.4 */
		div[style*='margin: 16px 0'] {
			margin: 0 !important;
		}

		/* What it does: Stops Outlook from adding extra spacing to tables. */
		table,
		td {
			mso-table-lspace: 0pt !important;
			mso-table-rspace: 0pt !important;
		}

		/* What it does: Fixes webkit padding issue. */
		table {
			border-spacing: 0 !important;
			border-collapse: collapse !important;
			table-layout: fixed !important;
			margin: 0 auto !important;
		}

		/* What it does: Uses a better rendering method when resizing images in IE. */
		img {
			-ms-interpolation-mode: bicubic;
		}

		/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
		a {
			text-decoration: none;
		}

		/* What it does: A work-around for email clients meddling in triggered links. */
		*[x-apple-data-detectors],
		/* iOS */
		.unstyle-auto-detected-links *,
		.aBn {
			border-bottom: 0 !important;
			cursor: default !important;
			color: inherit !important;
			text-decoration: none !important;
			font-size: inherit !important;
			font-family: inherit !important;
			font-weight: inherit !important;
			line-height: inherit !important;
		}

		/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
		.a6S {
			display: none !important;
			opacity: 0.01 !important;
		}

		/* What it does: Prevents Gmail from changing the text color in conversation threads. */
		.im {
			color: inherit !important;
		}

		/* If the above doesn't work, add a .g-img class to any image in question. */
		img.g-img+div {
			display: none !important;
		}

		/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
		/* Create one of these media queries for each additional viewport size you'd like to fix */

		/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
		@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
			u~div .email-container {
				min-width: 320px !important;
			}
		}

		/* iPhone 6, 6S, 7, 8, and X */
		@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
			u~div .email-container {
				min-width: 375px !important;
			}
		}

		/* iPhone 6+, 7+, and 8+ */
		@media only screen and (min-device-width: 414px) {
			u~div .email-container {
				min-width: 414px !important;
			}
		}
	</style>

	<!-- CSS Reset : END -->

	<!-- Progressive Enhancements : BEGIN -->
	<style>
		.primary {
			background: #30e3ca;
		}

		.bg_white {
			background: #ffffff;
		}

		.bg_light {
			background: #fafafa;
		}

		.bg_black {
			background: #000000;
		}

		.bg_dark {
			background: rgba(0, 0, 0, .8);
		}

		.email-section {
			padding: 2.5em;
		}

		/*BUTTON*/
		.btn {
			padding: 10px 15px;
			display: inline-block;
		}

		.btn.btn-primary {
			border-radius: 5px;
			background: #30e3ca;
			color: #ffffff;
            border:none;
		}
		.btn.btn-denger {
			border-radius: 5px;
			background: #ff0303;
			color: #ffffff;
            border:none;
		}

		.btn.btn-white {
			border-radius: 5px;
			background: #ffffff;
			color: #000000;
		}

		.btn.btn-white-outline {
			border-radius: 5px;
			background: transparent;
			border: 1px solid #fff;
			color: #fff;
		}

		.btn.btn-black-outline {
			border-radius: 0px;
			background: transparent;
			border: 2px solid #000;
			color: #000;
			font-weight: 700;
		}

		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			font-family: 'Ysabeau Office', sans-serif;
			color: #000000;
			margin-top: 0;
			font-weight: 400;
		}

		body {
			font-family: 'Philosopher', sans-serif;
			font-weight: 400;
			font-size: 15px;
			line-height: 1.8;
			color: rgba(0, 0, 0, .4);
		}

		a {
			color: #30e3ca;
		}

		#user_define> table {
			width: 100%;
			max-width: 100%;
			margin-bottom: 1rem;
			background-color: transparent;
		}
		#user_define> table> thead {
			position: sticky;
			top: -1px;
			/*background: #0effc747;*/
			
		}
		#user_define> table>tr {
			padding-bottom: 20px;
		}
		.ud_th {
			text-align: center;
			color: #000;
			text-decoration: underline;
			font-size: 1.2rem;
		}
		.udata_row th,.udata_row td {
			text-align: left;
			border: 1px solid gray;
		}

		/*LOGO*/

		.logo h1 {
			margin: 0;
		}

		.logo h1 a {
			color: #30e3ca;
			font-size: 24px;
			font-weight: 700;
			font-family: 'Ysabeau Office', sans-serif;
		}

		/*HERO*/
		.hero {
			position: relative;
			z-index: 0;
		}

		.hero .text {
			color: rgba(0, 0, 0, .3);
		}

		.hero .text h2 {
			color: #000;
			font-size: 40px;
			margin-bottom: 0;
			font-weight: 400;
			line-height: 1.4;
		}

		.hero .text h3 {
			font-size: 24px;
			font-weight: 300;
		}

		.hero .text h2 span {
			font-weight: 600;
			color: #30e3ca;
		}


		/*HEADING SECTION*/
		.heading-section {}

		.heading-section h2 {
			color: #000000;
			font-size: 28px;
			margin-top: 0;
			line-height: 1.4;
			font-weight: 400;
		}

		.heading-section .subheading {
			margin-bottom: 20px !important;
			display: inline-block;
			font-size: 13px;
			text-transform: uppercase;
			letter-spacing: 2px;
			color: rgba(0, 0, 0, .4);
			position: relative;
		}

		.heading-section .subheading::after {
			position: absolute;
			left: 0;
			right: 0;
			bottom: -10px;
			content: '';
			width: 100%;
			height: 2px;
			background: #30e3ca;
			margin: 0 auto;
		}

		.heading-section-white {
			color: rgba(255, 255, 255, .8);
		}

		.heading-section-white h2 {
			font-family: 'Ysabeau Office', sans-serif;
			line-height: 1;
			padding-bottom: 0;
		}

		.heading-section-white h2 {
			color: #ffffff;
		}

		.heading-section-white .subheading {
			margin-bottom: 0;
			display: inline-block;
			font-size: 13px;
			text-transform: uppercase;
			letter-spacing: 2px;
			color: rgba(255, 255, 255, .4);
		}


		ul.social {
			padding: 0;
		}

		ul.social li {
			display: inline-block;
			margin-right: 10px;
		}

		/*FOOTER*/

		.footer {
			border-top: 1px solid rgba(0, 0, 0, .05);
			color: rgba(0, 0, 0, .5);
		}

		.footer .heading {
			color: #000;
			font-size: 20px;
		}

		.footer ul {
			margin: 0;
			padding: 0;
		}

		.footer ul li {
			list-style: none;
			margin-bottom: 10px;
		}

		.footer ul li a {
			color: rgba(0, 0, 0, 1);
		}


		@media screen and (max-width: 500px) {}
	</style>


</head>

<body width='100%' style='margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;'>
	<center style='width: 100%; background-color: #f1f1f1;'>
		<div
			style='display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: Philosopher, sans-serif;'>
			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
		</div>
		<div style='max-width: 900px; margin: 0 auto;' class='email-container'>
			<!-- BEGIN BODY -->
			<table align='center' role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'
				style='margin: auto;'>
				<tr>
					<td valign='top' class='bg_white' style='padding: 1em 2.5em 0 2.5em;'>
						<table role='presentation' border='0' cellpadding='0' cellspacing='0' width='100%'>
							<tr>
								<th class='logo' style='text-align: center;'>
									<h1 style='font-weight: bold; color: #1104ff;'>easy Visitor Management System</h1>
								</th>
							</tr>
						</table>
					</td>
				</tr><!-- end tr -->
				<tr>
					<td valign='middle' class='hero bg_white' style='padding: 2em 0em 2em 0em;' id='user_define'>
						<tr >
							<th style='height:.5rem;'>							
							</th>
						</tr>
						
					</td>
				</tr>
				<tr>
					<td valign='middle' class='hero bg_white' style='' >
						<tr>
							<th style='background:#ffffff; text-align:justify;padding: 1em ;    line-height: 1.2rem;'>
								".$emp_name_mail." came to visit with you please check out the details of the visitor given bellow. 
								Please verify the visitor and approve or reject to visit with this visitor.
								<p>This is auto generated mail, please do not reply on that mail. If anything required, please contact with us.</p>
								<p>Thank, you.</p> 
							</t>
						</tr>
					</td>
				</tr>
				<tr>
					<td valign='middle' class='hero bg_white' style='padding: 1em 0.8em 2em 0.8em;' id='user_define'>
						<table >
							
							<thead>
								
								<tr >
									<th class='ud_th' colspan='1'>
										Visitor Information
									</th>
								</tr>
							</thead>
								<tr>
									<table style='width:100%'>
										<tbody class='udata_row'>
											".$html."
										</tbody>
									</table>
								</tr>
						</table>
					</td>
				</tr><!-- end tr -->
				".$button."
				<!-- end tr -->
				
				<!-- 1 Column Text + Button : END -->
			</table>
			<table align='center' role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'
				style='margin: auto;'>
				<tr>
					<td valign='middle' class='bg_light footer email-section'>
						<table>
							<tr>
								<td valign='top' width='33.333%' style='padding-top: 20px;'>
									<table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
										<tr>
											<td style='text-align: left; padding-right: 10px;'>
												<h3 class='heading'>About</h3>
												<p>We are an authorized supplier of eSSL Products. We are doing integration of eSSL Biometric with HRMS and ERP. The successful integration HRMS Software name is - KEAK HRMS, SPINE HRMS, HR-One, Stride HRMS, LightHouse ERP, DarwinBox ERP, iPay HRMS, ZOHO HRMS, TCS iON, La Exactlly HRMS ( Exactlly HRMS ), HRMantra HRMS, Grey HR, Saral PayPack and many more.</p>

												<p>We provide the cloud space for attendance management systems and also we provide mobile app for field attendance with Live location along with the selfi photo.</p>
												
												<p>We also provide service of attendance data management systems with auto scheduler.</p>
											</td>
										</tr>
									</table>
								</td>
								<td valign='top' width='33.333%' style='padding-top: 20px;'>
									<table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
										<tr>
											<td style='text-align: left; padding-left: 5px; padding-right: 5px;'>
												<h3 class='heading'>Contact Info</h3>
												<ul>
													<li><h4>Team BioTech</h4></li>
													<li><span class='text'>Mob.: +91 08617472977</span></li>
													<li><span class='text'>eMail ID: sales_biotech@outlook.com</span></li>
												</ul>
											</td>
										</tr>
									</table>
								</td>
								
							</tr>
						</table>
					</td>
				</tr><!-- end: tr -->
				
			</table>

		</div>
	</center>
</body>

</html>";
$mail->send();



?>