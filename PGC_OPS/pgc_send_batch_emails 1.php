<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<?php
//send to your self
$to ="support@pgcsoaring.org";
$subject = 'PGC Pilot Portal - Expiring Signoffs';

// message
$message = "<html>".
"<head>".
" <title>System email</title>".
"</head>".
"<body>".
"Line 1 - Your message is here ".  
"Line 2 - Your message is here ".  
"</body>".
"</html>";


//get email list

mysql_select_db($database_PGC, $PGC);
$query="select email from pgc_batch_email";
$result=mysql_query($query) or die('Error, query failed');

$row=1;
$numrows=mysql_num_rows($result);
$bccfield="Bcc: ". mysql_result($result,0,"email");
while($row<$numrows)
{
$email=mysql_result($result,$row,"email");
$bccfield .= "," . $email; //seperate by comma
$row++;
}
$bccfield .= "\r\n";

// To send HTML mail, the Content-type header must be set
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= $bccfield;

$headers .= 'From: PGC Pilot Data Portal' . "\r\n";


// Mail it
mail($to, $subject, $message,$headers);
?> 
<body>
</body>
</html>
