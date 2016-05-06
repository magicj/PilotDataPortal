<?php //require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' 
	
 $to = "support@pgcsoaring.org";
 $subject = "Test E-mail Include";
 $from = "PGC-DataPortal-Expiry@noreply.com";
 $from = "support@pgcsoaring.org";
 $headers = "From: $from";
 $emaillog = date("Y-m-d");
 mail($to,$subject,$emaillog,$headers); 
?>