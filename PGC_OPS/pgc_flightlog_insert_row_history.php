<?php require_once('../Connections/PGC.php'); ?>
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

if ( 1==1 ) {

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT LastPilot, TowPlane FROM pgc_flightlog_lastpilot";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$LastPilot = $row_Recordset1['LastPilot'];
$Tow_Plane = $row_Recordset1['TowPlane'];


  $insertSQL = sprintf("INSERT INTO pgc_flightsheet (`Date`, `Tow Plane`,`Tow Pilot` ) VALUES (%s,%s,%s )",
                       GetSQLValueString($_SESSION['$Logdate'], "date"),
					   GetSQLValueString($Tow_Plane, "text"),
					   GetSQLValueString($LastPilot, "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

  $insertGoTo = "pgc_flightlog_list_history_edit.php";
  $insertGoTo = $_SESSION['last_log_list_page'];
  $_GET['recordDATE'] = $_SESSION['$Logdate'];
  
  if (isset($_SERVER['xQUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
  ?>
 