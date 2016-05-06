<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
/* Batch Updates */
mysql_select_db($database_PGC, $PGC);
$insertSQL = "TRUNCATE TABLE pgc_squawk_metrics";
$ResultA = mysql_query($insertSQL, $PGC) or die(mysql_error());

$insertSQL = "INSERT IGNORE INTO pgc_squawk_metrics (metrics_equipment, metrics_status) SELECT DISTINCT equip_name, 'In Service' FROM pgc_equipment";
$ResultA = mysql_query($insertSQL, $PGC) or die(mysql_error());
  
$updateSQL = "UPDATE pgc_squawk_metrics SET new = (SELECT Count(*) FROM pgc_squawk WHERE pgc_squawk_metrics.metrics_equipment = pgc_squawk.sq_equipment and pgc_squawk.sq_status = 'NEW')";
$ResultB = mysql_query($updateSQL, $PGC) or die(mysql_error()); 
?>