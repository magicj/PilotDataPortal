<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
$to = $_SESSION['MM_Username'];
$subject = "PGC Password Changed";
$email = $_REQUEST['email'] ;
$message = 'This message was sent to confirm you made a PGC Password Change. Please contact PGC if you did not initiate this change.' ;
$headers = "From: PGC Pilot Data Portal";
$sent = mail($to, $subject, $message, $headers) ;

$to = 'kilokilo@comcast.net';
$subject = "PGC Password Changed";
$email = $_REQUEST['email'] ;
$message = $_SESSION['MM_Username'];
$headers = "From: PGC Pilot Data Portal";
$sent = mail($to, $subject, $message, $headers) ;

  $updateGoTo = "../07_members_only_pw.php";
  $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
  $updateGoTo .= $_SERVER['QUERY_STRING'];
  header(sprintf("Location: %s", $updateGoTo));
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<body>
</body>
</html>

<!-- 
$to = "kilokilo@comcast.net";
$subject = "Contact Us";
$email = $_REQUEST['email'] ;
$message = $_REQUEST['message'] ;
$headers = "From: $email";
$sent = mail($to, $subject, $message, $headers) ;
if($sent)
{print "Your mail was sent successfully"; }
else
{print "We encountered an error sending your mail"; }
 -->