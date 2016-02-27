<?php require_once('../Connections/PGC.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
error_reporting(0);
$member_id = $_SESSION['MM_Username'];
$member_name = $_SESSION['MM_PilotName'];
$app_name = basename($_SERVER['PHP_SELF']);

if (isset($_SESSION['MM_Username']) AND isset($_SESSION['MM_PilotName'])) {   

	mysql_select_db($database_PGC, $PGC);
	$query_Apps = "INSERT IGNORE INTO pgc_access_apps (app_name, app_active, app_function) VALUES ('$app_name', 'Y', 'None')";
	$Apps = mysql_query($query_Apps, $PGC) or die(mysql_error());
	$row_Apps = mysql_fetch_assoc($Apps);
	$totalRows_Apps = mysql_num_rows($Apps);
	
	$current_date = date("Y-m-d");
	$query_Apps = "UPDATE pgc_access_apps SET app_last_used =  '$current_date', last_user_name = '$member_name', last_user_id = '$member_id' WHERE app_name = '$app_name'";
	$Apps = mysql_query($query_Apps, $PGC) or die(mysql_error());
	$row_Apps = mysql_fetch_assoc($Apps);
	$totalRows_Apps = mysql_num_rows($Apps);

}

?>