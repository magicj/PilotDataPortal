<?php //require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' 

// Connection require_once would not resolve properly ... so had to include here : 
$hostname_PGC = 	"50.62.209.118:3306";
$database_PGC = "pgcsoaringdb";
$username_PGC = "pgcsoaringsql";
$password_PGC = "willow99";

$PGC = mysql_pconnect($hostname_PGC, $username_PGC, $password_PGC) or trigger_error(mysql_error(),E_USER_ERROR); 
if (!$PGC)
  {
  die('Could not connect: ');
  }
  
?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
// require_once('pgc_check_login.php'); 
/* Send Expiry E-mails ... Get Last Expiry Email Run Date */
mysql_select_db($database_PGC, $PGC);
$exrunSQL = "Select * from pgc_system";
$exResult = mysql_query($exrunSQL, $PGC) or die(mysql_error());
$exrow = mysql_fetch_array($exResult);
$expiry_email_run = $exrow['expiry_email_run'];
//echo $expiry_email_run;

If ($expiry_email_run < date("Y-m-d")) {
	
 $to = "klausall@comcast.net, jguimondjr@verizon.net, klfranz13@comcast.net, phil.klauder@verizon.net, support@pgcsoaring.org";
//  $to = "kilokilo@verizon.net";
 $subject = "Expiring PGC Signoffs Job - Report Run Notification";
 $subject = "Expiring PGC Signoffs Job - Report Run Notification - System Last Date = " . $expiry_email_run . "   Date Y M D = " . date("Y-m-d") . "  User: " . $_SESSION['MM_Username'] ;
 $from = "PGC-DataPortal-Expiry@noreply.com";
 $from = "support@pgcsoaring.org";
 $headers = "From: $from";
 $emaillog = date("Y-m-d");
 mail($to,$subject,$emaillog,$headers); 

 /* Update Run Date */
mysql_select_db($database_PGC, $PGC);
$SysSQL = "UPDATE pgc_system SET expiry_email_run =  CURDATE()";
$ResultSys = mysql_query($SysSQL, $PGC) or die(mysql_error());


/* Run pgc_email_testprep.php once to prime records */
/* Calculate Days to Expiry - A Group */
mysql_select_db($database_PGC, $PGC);
$runSQL = "UPDATE pgc_pilot_signoffs SET days_to_expiry =  999";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());


 /* Calculate Days to Expiry - B Group */
mysql_select_db($database_PGC, $PGC);
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.days_to_expiry =  DATEDIFF( A.expire_date, CURDATE()) WHERE A.signoff_type = B.description AND B.group_id = 'B'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());


 /* Select Records in Date Range - that have not been emailed  */
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_pilot_signoffs A, pgc_members B WHERE (A.days_to_expiry > 0 AND A.days_to_expiry <= 60) AND A.30_day_email > CURDATE() AND A.pilot_name = B.NAME AND B.active <> 'NO'";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
/*$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1); */
while($row = mysql_fetch_array($Recordset1))
   {
 $member_email = $row['USER_ID'];   
 $emaillog =  $row['USER_ID']   . "\n"; 
 $emaillog .= $row['pilot_name'] . "\n";
 $emaillog .= "\n";  
 $emaillog .= "=====================================================" . "\n"; 
 $emaillog .= "    THE FOLLOWING PDP SIGNOFF WILL EXPIRE SHORTLY    " . "\n"; 
 $emaillog .= "\n"; 
 $emaillog .= "       Expiration may result in a No-Fly Status      " . "\n"; 
 $emaillog .= "=====================================================" . "\n"; 
 $emaillog .= "\n";
 $emaillog .= "Signoff Type:   " . $row['signoff_type'] . "\n"; 
 $emaillog .= "Signoff Date:   " . $row['signoff_date'] . "\n"; 
 $emaillog .= "Expire Date:    " . $row['expire_date'] . "\n"; 
 $emaillog .= "Days To Expiry: " . $row['days_to_expiry'] . "\n"; 
 $emaillog .= "\n";
 $emaillog .= "=====================================================". "\n"; 
 $emaillog .= "\n";
 $emaillog .= "     This message is advisory - check your records    ". "\n"; 
 $emaillog .= "  to determine if you are compliant with FAA and PGC ". "\n"; 
 $emaillog .= "    regulations.  Advise a PGC CFIG or Karl Franz   ". "\n"; 
 $emaillog .= "  (klfranz13@comcast.net)if you think the PDP signoff ". "\n"; 
 $emaillog .= "              information is incorrect.              ". "\n"; 
   
/* echo $emaillog;  */
 
 $to = $member_email . ", klausall@comcast.net, phil.klauder@verizon.net, jguimondjr@verizon.net, klfranz13@comcast.net, support@pgcsoaring.org";
 $subject = "Expiring PGC Signoffs";
 // Always set content-type when sending HTML email
 /*$headers = "MIME-Version: 1.0" . "\r\n";
 $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n"; */
 $from = "PGC-DataPortal-Expiry@noreply.com";
 $from = "support@pgcsoaring.org";
 $headers = "From: $from";
 mail($to,$subject,$emaillog,$headers); 
 }

 /* Send Expiry Emails - Flag Email Sent */
mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = "UPDATE pgc_pilot_signoffs A, pgc_members B SET A.30_day_email = CURDATE() WHERE (A.days_to_expiry > 0 AND A.days_to_expiry <= 60) AND A.30_day_email > CURDATE() AND A.pilot_name = B.NAME AND B.active <> 'NO'";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
mysql_close($PGC);

mysql_free_result($Recordset1);
}
?>