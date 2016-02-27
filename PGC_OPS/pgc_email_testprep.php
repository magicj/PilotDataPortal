<?php require_once('../Connections/PGC.php'); ?>
<?php
 if (!isset($_SESSION)) {
  session_start();
}


/* Calculate Days to Expiry - A Group */
mysql_select_db($database_PGC, $PGC);
$runSQL = "UPDATE pgc_pilot_signoffs SET 30_day_email = NULL";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Set 30 day email 5 years into future  */
mysql_select_db($database_PGC, $PGC);
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.30_day_email = DATE_ADD(CURDATE(), INTERVAL 5 YEAR) WHERE A.30_day_email IS NULL";
 $Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

?>
