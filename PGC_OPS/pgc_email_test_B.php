<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
 
$Date = date("l jS \of F Y h:i:s A");
$message = "TESTING E-EMAIL CALLED FROM ANOTHER PHP APP" . $Date;
$to = "kilokilo@verizon.net, ";
$subject = "PGC EMAIL TEST";
$email = $_REQUEST['email'];
$headers = "From: PGC-PDP-TEST@NoReply.com";

$sent = mail($to, $subject, $message, $headers) ;

if($sent)
{print "Your mail was sent successfully " . $Date; }
else
{print "We encountered an error sending your mail"; }

?>
