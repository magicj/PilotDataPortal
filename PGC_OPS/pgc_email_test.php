<?php require_once('../Connections/PGC.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
mysql_select_db($database_PGC, $PGC);
 
$result = mysql_query("SELECT * FROM pgc_pilot_signoffs LIMIT 10");
 
while($row = mysql_fetch_array($result))
   {
   	$webmaster = "kilokilo@verizon.net";
    $to = $webmaster;
	$subject = "PGC eMail Alert Test";
	$emaillog = $row['pilot_ID'] . " " . $row['pilot_name'];
	$headers = 'From: PDP@pgc.net' . "\r\n" .
    'Reply-To: kilokilo@verizon.net' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
	$sent = mail($to, $subject,  $emaillog, $headers);
    }
mysql_close($PGC);
 ?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>