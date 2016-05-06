<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

//Insert Holidays
mysql_select_db($database_PGC, $PGC);
$query_session_holidays = "INSERT IGNORE INTO pgc_field_duty_selections(date)SELECT holiday_date FROM pgc_field_duty_holidays";
$session_holidays = mysql_query($query_session_holidays, $PGC) or die(mysql_error());

//Getting the From Date
mysql_select_db($database_PGC, $PGC);
$query_session_control = "SELECT fd_session, session_start_date, session_end_date, session_active FROM pgc_field_duty_control WHERE fd_session = '1'";
$session_control = mysql_query($query_session_control, $PGC) or die(mysql_error());
$row_session_control = mysql_fetch_assoc($session_control);
$from = $row_session_control['session_start_date'];


//Getting the To Date
mysql_select_db($database_PGC, $PGC);
$query_session_control = "SELECT fd_session, session_start_date, session_end_date, session_active FROM pgc_field_duty_control WHERE fd_session = '3'";
$session_control = mysql_query($query_session_control, $PGC) or die(mysql_error());
$row_session_control = mysql_fetch_assoc($session_control);
$to = $row_session_control['session_end_date'];

 
$startTime = strtotime($from); 
$endTime = strtotime($to); 

mysql_select_db($database_PGC, $PGC);

for($time = $startTime; $time <= $endTime; $time = strtotime('+1 day', $time)) 
{ 
   $thisDate = date('Y-m-d', $time); 
   $thisDateDay = date('l', $time);
   If  ($thisDateDay == "Saturday" || $thisDateDay == "Sunday" ) {
      //echo $thisDateDay;
      $query = sprintf("INSERT IGNORE INTO pgc_field_duty_selections(date) VALUES (%s)", 
      GetSQLValueString($thisDate, "date"));
      mysql_query($query) or die('Error, query failed : ' . mysql_error()); 
	

   }
} 

//Insert Sessions
mysql_select_db($database_PGC, $PGC);
$query_sessions = "UPDATE pgc_field_duty_selections SET pgc_field_duty.session = (SELECT pgc_field_duty_control.fd_session FROM pgc_field_duty_control WHERE (pgc_field_duty_selections.date >= pgc_field_duty_control.session_start_date and pgc_field_duty_selections.date <= pgc_field_duty_control.session_end_date))";
$sessions = mysql_query($query_sessions, $PGC) or die(mysql_error());

$updateGoTo = "pgc_fd_menu.php";
header(sprintf("Location: %s", $updateGoTo));
?> 


