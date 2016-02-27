<?php require_once('../Connections/PGC.php'); ?>
<?php 
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
$member_id = $_SESSION['MM_Username'];
$member_name = $_SESSION['MM_PilotName'];
/* Return to Login Page if not logged in  */
$MM_restrictGoTo = "../07_members_login.php";
if (!isset($_SESSION['MM_Username']) OR !isset($_SESSION['MM_PilotName'])) {   
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
 /* Check to see if they have access to this page */
$app_name = basename($_SERVER['PHP_SELF']);
$colname_1 = "-1";
if (isset($app_name)) {
  $colname_1 = (get_magic_quotes_gpc()) ? $app_name : addslashes($app_name);
  $colname_2 = (get_magic_quotes_gpc()) ? $member_name : addslashes($member_name);
}

 /* If app has open or no access restrictions - let them use it ...*/
 
$MM_restrictGoTo = "../07_members_only_pw.php";
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT rec_key FROM pgc_access_app_groups WHERE app_name = '%s' AND (allowed_group = 'ALL' OR allowed_group IS NULL)", $colname_1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$access_count_all = mysql_num_rows($Recordset1);

/*-----*/
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT rec_key FROM pgc_access_app_groups WHERE app_name = '%s'", $colname_1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$access_count_exists = mysql_num_rows($Recordset1);
 
 
 /* If record exists ... but there is no general access - check to see if they have specific access to this page */
if ($access_count_exists <> 0 AND $access_count_all == 0) { 
	$MM_restrictGoTo = "../07_members_only_pw.php";
	mysql_select_db($database_PGC, $PGC);
	$query_Recordset1 = sprintf("SELECT A.rec_key FROM pgc_access_app_groups A, pgc_access_member_groups B WHERE A.allowed_group = B.assigned_group AND A.app_name = '%s' AND B.member_name = '%s'", $colname_1, $colname_2);
	$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	$access_count_rows = mysql_num_rows($Recordset1);
	if ($access_count_rows == 0) {   
	  header("Location: ". $MM_restrictGoTo); 
	  exit;
	}
}
?>
