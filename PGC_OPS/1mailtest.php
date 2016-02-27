<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<?php
 $to = "kilokilo@verizon.net";
 $subject = "Expiring PGC Signoffs Job - Report Run Notification";
 $from = "PGCPDP@noreply.com";
$headers = "From: $from";
 $emaillog = date("Y-m-d");
 mail($to,$subject,$emaillog,$headers); 
 

?>
<body>
</body>
</html>