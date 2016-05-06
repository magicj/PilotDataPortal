<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
 /* Select Records in Date Range - that have not been emailed  */
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_pilot_signoffs A, pgc_members B WHERE (A.days_to_expiry < 0 AND A.days_to_expiry >= -60) AND A.30_day_email > CURDATE() AND A.pilot_name = B.NAME AND B.active <> 'NO'";
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
 $emaillog .= "    THE FOLLOWING PDP SIGNOFF HAS EXPIRED" . "\n"; 
 $emaillog .= "\n"; 
 $emaillog .= "=====================================================" . "\n"; 
 $emaillog .= "\n";
 $emaillog .= "Signoff Type:      " . $row['signoff_type'] . "\n"; 
 $emaillog .= "Signoff Date:      " . $row['signoff_date'] . "\n"; 
 $emaillog .= "Expire Date:       " . $row['expire_date'] . "\n"; 
 $emaillog .= "Days Since Expiry: " . $row['days_to_expiry'] . "\n"; 
 $emaillog .= "\n";
 $emaillog .= "=====================================================". "\n"; 
 $emaillog .= "\n";
 $emaillog .= "     This message is advisory - check your records    ". "\n"; 
 $emaillog .= "  to determine if you are compliant with FAA and PGC ". "\n"; 
 $emaillog .= "    regulations.  Advise a PGC CFIG or Karl Franz  ". "\n"; 
 $emaillog .= "  (klfranz13@comcast.net)if you think the PDP signoff ". "\n"; 
 $emaillog .= "              information is incorrect.              ". "\n"; 
 
 
 
 echo $emaillog;
 
/* $to = $member_email . ", klfranz13@comcast.net, kilokilo@verizon.net"; */
 $to = "klfranz13@comcast.net, support@pgcsoaring.org";
//   $to = "kilokilo@verizon.net";
 
 $subject = "Expired PGC Signoffs - TEST TEST";
 // Always set content-type when sending HTML email
 /*$headers = "MIME-Version: 1.0" . "\r\n";
 $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n"; */
  
 //$headers = "From: PGC-DataPortal-Expiry@noreply.com";
 $headers = "From: noreply@pgcsoaring";
 mail($to,$subject,$emaillog,$headers); 
 }

 /* Flag Email Sent */
/*?>mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = "UPDATE pgc_pilot_signoffs A, pgc_members B SET A.30_day_email = CURDATE() WHERE (A.days_to_expiry <> 0 AND A.days_to_expiry < 60) AND A.30_day_email > CURDATE() AND A.pilot_name = B.NAME AND B.active <> 'NO'";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());<?php */
?>
<?php
mysql_close($PGC);

mysql_free_result($Recordset1);
?>
