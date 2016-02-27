<?php
	     
   
       /*
	  $message = "EMAIL TEST";
		  
 		$to = "kilokilo@verizon.net";
				    
		$subject = "PGC EMAIL TEST";
				
	    $headers = "From: kilokilo@verizon.net";
		
		 $from = "PGC-DataPortal-Expiry@noreply.com";
         $headers = "From: $from";

		
		$sent = mail($to, $subject, $message, $headers) ; 
		
		*/

//$dt = new DateTime("now", new DateTimeZone('America/New York'));
//echo $dt->format('m/d/Y, H:i:s');
 
define('EST_OFFSET',5*3600);
$Landtime = date("h:i:s",TIME()-EST_OFFSET);
echo $Landtime;
echo "   ";
echo date("h:i:s",TIME());

//$date = new DateTime("now", new DateTimeZone('America/New_York') );
//echo $date->format('Y-m-d H:i:s')+ "\n\n ";

 //date_default_timezone_set('America/New_York');
// $date= date('m-d-Y h:i:s') ;
 //echo $date->format('Y-m-d H:i:s')+ "\n\n ";
		
//mail("kilokilo@verizon.net", "Test subject", "Test Message III", "From: kilokilo@verizon.net"); 
?>

