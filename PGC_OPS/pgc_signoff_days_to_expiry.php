<?php require_once('../Connections/PGC.php'); 
if (!isset($_SESSION)) {
  session_start();
}
error_reporting(0); 
mysql_select_db($database_PGC, $PGC);

$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.30_day_email = NULL , A.days_to_expiry = NULL";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.days_to_expiry =  DATEDIFF( A.expire_date, CURDATE()) WHERE A.signoff_type = B.description AND B.group_id = 'A'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.30_day_email = CURDATE() WHERE A.days_to_expiry = 31";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());



?>

