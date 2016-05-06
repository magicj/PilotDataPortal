<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 

$message = " Equipment: " . $_POST[Equipment] . "\n\n Reported By: ". $_SESSION['MM_PilotName'] . "\n\n Date: " . $_POST[SQdate] .  "\n\n Problem Description: " . $_POST[Desc];

$to = "kilokilo@comcast.net, " . $_SESSION['MM_Username'] ;
$to = "Jack@nni.com, michaelclittle@gmail.com, kilokilo@comcast.net, " . $_SESSION['MM_Username'] ;


$subject = "PGC SQUAWK";

$email = $_REQUEST['email'] ;

$headers = "From: PGC-PDP-Squawk@NoReply.com";

$sent = mail($to, $subject, $message, $headers) ;

$MM_redirectMailSuccess = "../07_members_only_pw.php";
header("Location: " . $MM_redirectMailSuccess );

//if($sent)
//{print "Your mail was sent successfully"; }
//else
//{print "We encountered an error sending your mail"; }

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
 