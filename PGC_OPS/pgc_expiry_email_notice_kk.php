<?php //require_once('../Connections/PGC.php'); 
	
 $to = "kilokilo@verizon.net";
 $subject = "Test E-mail Include";
 $from = "PGC-DataPortal-Expiry@noreply.com";
 $from = "kilokilo@verizon.net";
 $headers = "From: $from";
 $emaillog = date("Y-m-d");
 mail($to,$subject,$emaillog,$headers); 
?>