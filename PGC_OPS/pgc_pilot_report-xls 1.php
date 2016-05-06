<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
//require_once('pgc_check_login_admin.php'); 

 /* Do Updates - Make this a function */
mysql_select_db($database_PGC, $PGC);

/* Purge Deletions */
$deleteSQL = "DELETE FROM pgc_signoff_nofly WHERE 1 = 1";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());

/* Purge Deletions */
$deleteSQL = "INSERT IGNORE INTO pgc_signoff_nofly(pilot_name) Select pilot_name FROM pgc_pilot_signoffs";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());


/* Set both dates to 0000-00-00 */
$runSQL = "UPDATE pgc_signoff_nofly SET pgc_invalid_signoffs = (SELECT GROUP_CONCAT(DISTINCT signoff_type SEPARATOR ',   ') FROM pgc_pilot_signoffs WHERE pgc_signoff_nofly.pilot_name = pgc_pilot_signoffs.pilot_name AND pgc_pilot_signoffs.status = 'Expired-A' GROUP BY pilot_name)";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

 /* Purge Deletions */
$deleteSQL = "DELETE FROM pgc_signoff_nofly WHERE pgc_invalid_signoffs IS Null";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());

 /* Purge Inactive ================ */
$deleteSQL = "UPDATE pgc_signoff_nofly A, pgc_members B SET A.pgc_status = 'NO' WHERE A.pilot_name = B.NAME AND B.active = 'NO'";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());

$deleteSQL = "DELETE FROM pgc_signoff_nofly WHERE pgc_status = 'NO'";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());


 /* Create XLS  ================ */ 
 
mysql_select_db($database_PGC, $PGC);

 
$query  = "SELECT pilot_name, fly_status, pgc_ratings FROM pgc_pilots";
$query  = "SELECT * FROM pgc_pilot_signoffs WHERE status = 'Expired-A' ORDER BY pilot_name ASC, status ASC";
$query  = "SELECT pilot_name, pgc_invalid_signoffs FROM pgc_signoff_nofly ORDER BY pilot_name ASC";

$query  = "SELECT b. USER_ID, a.pilot_name, a.pgc_status, a.pgc_invalid_signoffs FROM pgc_signoff_nofly a, pgc_members b WHERE a.pilot_name = b.NAME";

$result = mysql_query($query) or die('Error, query failed');

$tsv  = array();
$html = array();

while($row = mysql_fetch_array($result, MYSQL_NUM))
{
   $tsv[]  = implode("\t", $row);
   $html[] = "<tr><td>" .implode("</td><td>", $row) .              "</td></tr>";
}

$tsv = implode("\r\n", $tsv);
$html = "<table>" . implode("\r\n", $html) . "</table>";

$fileName = 'PGC-PILOT-NOFLY-REPORT.xls';
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$fileName");

echo $tsv;
//echo $html;

//include 'library/closedb.php';
?>
