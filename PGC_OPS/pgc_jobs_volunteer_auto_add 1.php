<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
}

  $insertSQL = sprintf("INSERT IGNORE INTO pgc_job_volunteers (volunteer_key, job_id, post_date, post_id, job_volunteer_name, job_volunteer_id, dup_check_key) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['volunteer_key'], "int"),
                       GetSQLValueString($_GET['job_id'], "int"),
                       GetSQLValueString($_POST['post_date'], "date"),
                       GetSQLValueString($_POST['post_id'], "text"),
                       GetSQLValueString($_SESSION['MM_PilotName'], "text"),
                       GetSQLValueString($_SESSION['MM_Username'], "text"),
					   GetSQLValueString($_GET['job_id'] . $_SESSION['MM_PilotName'], "text")				   					   );

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
    
  if($Result1){
  /* Get Info for Email */
  mysql_select_db($database_PGC, $PGC);
  $query_RecordsetJobs = sprintf( "SELECT * FROM pgc_jobs WHERE job_key=%s", GetSQLValueString($_GET['job_id'], "text"));
  $RecordsetJobs = mysql_query($query_RecordsetJobs, $PGC) or die(mysql_error());
  $row_RecordsetJobs = mysql_fetch_assoc($RecordsetJobs);
  $totalRows_RecordsetJobs = mysql_num_rows($RecordsetJobs);
  $JobMemberName = $_SESSION['MM_PilotName'];
  $JobMemberEmail = $_SESSION['MM_Username'];
  $JobName = $row_RecordsetJobs['job_name'];
  $JobLeader  = $row_RecordsetJobs['job_leader'];
  $JobLeaderEmail  = $row_RecordsetJobs['job_leader_email'];
  $JobSponsor = $row_RecordsetJobs['job_sponsor'];
  $JobSponsorEmail = $row_RecordsetJobs['job_sponsor_email'];

  require_once('pgc_jobs_volunteer_email.php'); 
  }
  
  $insertGoTo = "pgc_jobs_member.php";
  header(sprintf("Location: %s", $insertGoTo));

mysql_free_result($Recordset1);
?>
