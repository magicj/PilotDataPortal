<?php require_once('../Connections/PGC.php'); ?>
<?php error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php
// Logon Check - bounce to login screen 
$member_id = $_SESSION['MM_Username'];
$member_name = $_SESSION['MM_PilotName'];
/* Return to Login Page if not logged in  */
$MM_restrictGoTo = "../07_members_login.php";
if (!isset($_SESSION['MM_Username']) OR !isset($_SESSION['MM_PilotName'])) {   
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
$show_status = 'N';
// If user is SYSADMIM - they have access rights for all apps ... 

    $member_good = 'No';
	$member_check_name = $_SESSION['MM_PilotName'];
		
	mysql_select_db($database_PGC, $PGC);
	$query_RecordsetApp = "SELECT A.rec_key, A.member_id, A.member_name, A.assigned_group, A.rec_active FROM pgc_access_member_groups A WHERE A.member_name = '$member_check_name' AND A.assigned_group = 'SYSADMIN' AND A.rec_active = 'Y'";
	
	$RecordsetApp = mysql_query($query_RecordsetApp, $PGC) or die(mysql_error());
	$row_RecordsetApp = mysql_fetch_assoc($RecordsetApp);
	$totalRows_RecordsetApp = mysql_num_rows($RecordsetApp);
	If ($totalRows_RecordsetApp > 0 ) {
		$member_good = 'Yes';
	}
	if ($show_status == 'Y') {  
	$_SESSION['pgc_sysadmin'] = $totalRows_RecordsetApp;
	//echo '***  SysAdmin Flag :' . $_SESSION['pgc_sysadmin'] . '   ' . $member_good . '   ';
	}
 
// If app has no group assigned - all users can access ... just return
if (isset($_SESSION['MM_PilotName'])) { 

	$member_check_name = $_SESSION['MM_PilotName'];
	$app_check_name = basename($_SERVER['PHP_SELF']);
	
	mysql_select_db($database_PGC, $PGC);
	$query_RecordsetApp = "SELECT * FROM pgc_access_app_groups WHERE app_name = '$app_check_name' AND rec_active = 'Y'";
	
	$RecordsetApp = mysql_query($query_RecordsetApp, $PGC) or die(mysql_error());
	$row_RecordsetApp = mysql_fetch_assoc($RecordsetApp);
	$totalRows_RecordsetApp = mysql_num_rows($RecordsetApp);
	
	If ($totalRows_RecordsetApp < 1 ) {
	    $member_good = 'Yes';
	}
      
	if ($show_status == 'Y') {  
    $_SESSION['app_group_count'] = $totalRows_RecordsetApp;
    //echo '***  Groups Assigned To App : ' .$_SESSION['app_group_count'] . ' for ' . $app_check_name . '  ';
	}
 
}
// If app has group(s) assigned - then user has to be in that group(s) ... return to prior page if not in group.

if (isset($_SESSION['MM_PilotName'])) { 

	$member_check_name = $_SESSION['MM_PilotName'];
	$app_check_name = basename($_SERVER['PHP_SELF']);
	
	mysql_select_db($database_PGC, $PGC);
	$query_RecordsetApp = "SELECT A.rec_key, A.member_id, A.member_name, A.assigned_group, A.rec_active FROM pgc_access_member_groups A,     pgc_access_app_groups B WHERE A.member_name = '$member_check_name' AND B.app_name = '$app_check_name' AND A.assigned_group = B.allowed_group AND A.rec_active = 'Y' AND B.rec_active = 'Y'";
	
	$RecordsetApp = mysql_query($query_RecordsetApp, $PGC) or die(mysql_error());
	$row_RecordsetApp = mysql_fetch_assoc($RecordsetApp);
	$totalRows_RecordsetApp = mysql_num_rows($RecordsetApp);
	
	If ($totalRows_RecordsetApp > 0 ) {
	    $member_good = 'Yes';
	}
	
	if ($show_status == 'Y') {  
   	$_SESSION['app_mem_count'] = $totalRows_RecordsetApp;
    //echo '***  Member Group Assigned To This App Flag: ' . $_SESSION['app_mem_count'];
	}
 
   }

$MM_restrictGoTo = "../07_members_only_pw.php";
if ($member_good == 'No') {   
  header("Location: ". $MM_restrictGoTo); 
  exit;
}