<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
//error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
$session_pilotname = $_SESSION['MM_PilotName'];
$session_email = $_SESSION['MM_Username']; 
require_once('pgc_check_login.php'); 
?>
<?php
// Update Duty Selection Table - this will add new members - will not update existing records ...
mysql_select_db($database_PGC, $PGC);
$query_fd_selections = "INSERT IGNORE INTO pgc_field_duty_selections (key_check, member_id, member_name, fd_role, session, modified_by)  
SELECT CONCAT(user_id,'Session1'), user_id, name, duty_role, '1', 'Admin Setup' FROM pgc_members WHERE active = 'YES'";
$fd_current_selections1 = mysql_query($query_fd_selections, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
$query_fd_selections = "INSERT IGNORE INTO pgc_field_duty_selections (key_check, member_id, member_name, fd_role, session, modified_by)  
SELECT CONCAT(user_id,'Session2'), user_id, name, duty_role, '2', 'Admin Setup' FROM pgc_members WHERE active = 'YES'";
$fd_current_selections2 = mysql_query($query_fd_selections, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
$query_fd_selections = "INSERT IGNORE INTO pgc_field_duty_selections (key_check, member_id, member_name, fd_role, session, modified_by)  
SELECT CONCAT(user_id,'Session3'), user_id, name, duty_role, '3', 'Admin Setup' FROM pgc_members WHERE active = 'YES'";
$fd_current_selections3 = mysql_query($query_fd_selections, $PGC) or die(mysql_error());

/* Refresh role */
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "UPDATE pgc_field_duty_selections t1 INNER JOIN pgc_members t2 ON t1.member_id = t2.user_id SET t1.fd_role = t2.duty_role";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());

/* Refresh  status for INACTIVE Members */
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "UPDATE pgc_field_duty_selections t1 INNER JOIN pgc_members t2 ON t1.member_id = t2.user_id SET t1.pgc_active = t2.active";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());

/* Refresh modified_date */
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 =  "UPDATE pgc_field_duty_selections SET modified_date = '2030-01-01 01:01:01' WHERE ((choice1 = '' OR choice1 IS NULL) AND (choice2 = '' OR choice2 IS NULL) AND (choice3 = '' OR choice3 IS NULL) AND (date_selected = '' OR date_selected IS NULL))"; 
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());



$updateGoTo = "pgc_fd_menu.php";
header(sprintf("Location: %s", $updateGoTo));
?>

