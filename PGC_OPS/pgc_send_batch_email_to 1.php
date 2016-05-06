<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<?php
//send to your self

$subject = "PGC Pilot Portal - Expiring Signoffs";
$bccfield ="Bcc: " ."support@pgcsoaring.org"; 



//$bccfield .= "\r\n";

// message
$message = "<html>".
"<head>".
" <title>System email</title>".
"</head>".
"<body>".


"Hi, <p> The PGC Pilot Data Portal (PDP) has identified signoffs in your records that are expired or nearing the expiry date. <p>".  

"Please log into the PDP to see details .... and contact an instructor or PGC officer to resolve. <p>" .

"Thanks," .

"<p>**** System generated e-email from the PDP ****".

"</body>".
"</html>";

 


// To send HTML mail, the Content-type header must be set
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//$headers .= $bccfield;
$headers .= 'From: PGC Pilot Data Portal' . "\r\n";

//get email list

mysql_select_db($database_PGC, $PGC);
$query="select email from pgc_batch_email";
$result=mysql_query($query) or die('Error, query failed');
$numrows=mysql_num_rows($result);

$row=0;
while($row<$numrows)
   {
   $to=mysql_result($result,$row,"email");
   mail($to, $subject, $message, $headers);

$row++;
}

?> 
<body>
</body>
</html>
