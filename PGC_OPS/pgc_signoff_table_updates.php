<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
 
/* Also in pgc_modify_signoff_detail.php

/* Do Updates - Make this a function */
mysql_select_db($database_PGC, $PGC);

/* Purge Deletions */
$deleteSQL = "DELETE FROM pgc_pilot_signoffs WHERE delete_record = 'YES'";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());

/* Set both dates to 0000-00-00 */
$runSQL = "UPDATE pgc_pilot_signoffs SET expire_date = '0000-00-00'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Set Expired to OK */
$runSQL = "UPDATE pgc_pilot_signoffs SET status = 'OK'";  
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Set Expired to NG */
$runSQL = "UPDATE pgc_pilot_signoffs SET status = 'Expired-C' WHERE signoff_date ='0000-00-00' OR signoff_date = NULL";  
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Calc 90 Exact Day Expiry */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 90 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 90 AND B.expires = 'YES'AND B.eom_expiry = 'NO' AND A.signoff_date <> '0000-00-00'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Calc 730 Exact Day Expiry */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 730 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 730 AND B.expires = 'YES'AND B.eom_expiry = 'NO' AND A.signoff_date <> '0000-00-00'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Calc 365 Exact Day Expiry */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 365 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 365 AND B.expires = 'YES'AND B.eom_expiry = 'NO' AND A.signoff_date <> '0000-00-00'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Calc 730 Month End Expiry */ 
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = LAST_DAY(DATE_ADD(A.signoff_date, INTERVAL 730 DAY)) WHERE A.signoff_type = B.description AND B.duration_days = 730 AND B.expires = 'YES' AND B.eom_expiry = 'YES' AND A.signoff_date <> '0000-00-00'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

 
/* Calc 365 Month End Expiry */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = LAST_DAY(DATE_ADD(A.signoff_date, INTERVAL 365 DAY)) WHERE A.signoff_type = B.description AND B.duration_days = 365 AND B.expires = 'YES' AND B.eom_expiry = 'YES' AND A.signoff_date <> '0000-00-00'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Set Expired to NG */
$runSQL = "UPDATE pgc_pilot_signoffs SET status = 'Not Valid' WHERE signoff_date ='0000-00-00' OR signoff_date = NULL";  
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Set Expired to NG */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'Expired-A' WHERE (A.expire_date < CURDATE()) AND B.expires = 'YES' AND B.group_id = 'A' AND A.signoff_type = B.description";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'Expired-B' WHERE A.expire_date < CURDATE() AND B.expires = 'YES' AND B.group_id = 'B' AND A.signoff_type = B.description";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'Expired-C' WHERE A.expire_date < CURDATE() AND B.expires = 'YES' AND B.group_id = 'C' AND A.signoff_type = B.description";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* NULL Non Expiring  */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = NULL WHERE A.signoff_type = B.description AND B.expires ='NO'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());


/* UPDATE Pilot Ratings */
$runSQL = "UPDATE pgc_pilots SET pgc_ratings = ''";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

$runSQL = "UPDATE pgc_pilots SET pgc_ratings = (SELECT GROUP_CONCAT(DISTINCT pgc_rating SEPARATOR ', ') FROM pgc_pilot_ratings WHERE pgc_pilots.pilot_name = pgc_pilot_ratings.pilot_name GROUP BY pilot_name)";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
?>

