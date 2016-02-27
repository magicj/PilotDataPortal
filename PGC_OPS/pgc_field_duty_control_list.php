<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
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

// Cascade End Dates 
mysql_select_db($database_PGC, $PGC);
$updateSQL =  "SELECT session_end_date FROM pgc_field_duty_control WHERE fd_session='1'";
$FDendDate = mysql_query($updateSQL, $PGC) or die(mysql_error());
$row_FDendDate = mysql_fetch_assoc($FDendDate);
$FDEndDate = $row_FDendDate['session_end_date'];
$EndDate = date('Y-m-d',(strtotime ( '+1 day' , strtotime ( $FDEndDate) ) ));
 

$updateSQL = sprintf("UPDATE pgc_field_duty_control SET session_start_date=%s WHERE fd_session='2'",
                       GetSQLValueString($EndDate, "date"));
mysql_select_db($database_PGC, $PGC);
$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
$updateSQL =  "SELECT session_end_date FROM pgc_field_duty_control WHERE fd_session='2'";
$FDendDate = mysql_query($updateSQL, $PGC) or die(mysql_error());
$row_FDendDate = mysql_fetch_assoc($FDendDate);
$FDEndDate = $row_FDendDate['session_end_date'];
$EndDate = date('Y-m-d',(strtotime ( '+1 day' , strtotime ( $FDEndDate) ) ));
 

$updateSQL = sprintf("UPDATE pgc_field_duty_control SET session_start_date=%s WHERE fd_session='3'",
                       GetSQLValueString($EndDate, "date"));
mysql_select_db($database_PGC, $PGC);
$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  
// SELECTS  
  
mysql_select_db($database_PGC, $PGC);
$query_FDsessions = "SELECT fd_session, session_start_date, session_end_date, session_active, modified_by, modified_date FROM pgc_field_duty_control ORDER BY fd_session ASC";
$FDsessions = mysql_query($query_FDsessions, $PGC) or die(mysql_error());
$row_FDsessions = mysql_fetch_assoc($FDsessions);
$totalRows_FDsessions = mysql_num_rows($FDsessions);

mysql_select_db($database_PGC, $PGC);
$query_fd_holidays = "SELECT holiday_name, holiday_date, holiday_active FROM pgc_field_duty_holidays";
$fd_holidays = mysql_query($query_fd_holidays, $PGC) or die(mysql_error());
$row_fd_holidays = mysql_fetch_assoc($fd_holidays);
$totalRows_fd_holidays = mysql_num_rows($fd_holidays);

mysql_select_db($database_PGC, $PGC);
$query_session_counts = "SELECT `session`, count(`session`) FROM pgc_field_duty GROUP BY `session`";
$session_counts = mysql_query($query_session_counts, $PGC) or die(mysql_error());
$row_session_counts = mysql_fetch_assoc($session_counts);
$totalRows_session_counts = mysql_num_rows($session_counts);

mysql_select_db($database_PGC, $PGC);
$query_session_total = "SELECT count(`session`) FROM pgc_field_duty ";
$session_total = mysql_query($query_session_total, $PGC) or die(mysql_error());
$row_session_total = mysql_fetch_assoc($session_total);
$totalRows_session_total = mysql_num_rows($session_total);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
body {
	background-color: #283664;
	background-image: url(../images/Buttons/PGC%20copy.png);
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style16 {
	color: #CCCCCC;
	font-size: 14px;
}
a:link {
	color: #E6E3DF;
}
a:visited {
	color: #E6E3DF;
}
a:active {
	color: #FFFFCC;
}
.style19 {color: #CCCCCC; font-style: italic; font-weight: bold; }
.style20 {
	font-size: 12px;
	color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
}
.style24 {font-size: 16px; font-weight: bold; color: #CCCCCC; }
.style28 {font-size: 12px}
.style23 {font-size: 16px; font-weight: bold; color: #FFCCCC; font-style: italic; }
-->
</style></head>

<body>
<table width="900" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td width="1002"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="190" bgcolor="#3E3E5E"><table width="99%" height="740" border="0" align="center" cellpadding="5" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="25"><div align="center">
            <table width="99%" border="0" cellspacing="2" cellpadding="2">
                <tr>
                      <td bgcolor="#333366"><div align="center"><span class="style24">FIELD DUTY - SEASON DATE CONTROL</span></div></td>
                </tr>
                </table>
            </div></td>
      </tr>
      
      <tr>
        <td width="400" align="center" valign="top"><p>&nbsp;</p>
              <table width="500" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                          <td width="152" align="center" valign="middle" bgcolor="#333366">Holiday Name</td>
                          <td width="144" align="center" valign="middle" bgcolor="#333366">Holiday Date</td>
                          <td width="197" align="center" valign="middle" bgcolor="#333366">Holiday Active</td>
                    </tr>
                    <?php do { ?>
                          <tr>
                                <td align="left" valign="middle" bgcolor="#00366C"><a href="pgc_field_duty_holiday_edit.php?holiday_name=<?php echo $row_fd_holidays['holiday_name']; ?>"><?php echo $row_fd_holidays['holiday_name']; ?></a></td>
                                <td align="center" valign="middle" bgcolor="#00366C"><?php echo $row_fd_holidays['holiday_date']; ?></td>
                                <td align="center" valign="middle" bgcolor="#00366C"><?php echo $row_fd_holidays['holiday_active']; ?></td>
                          </tr>
                          <?php } while ($row_fd_holidays = mysql_fetch_assoc($fd_holidays)); ?>
        </table>
              <table width="54%" cellspacing="1" cellpadding="5">
                    <tr>
                          <td align="center" class="style20">&nbsp;</td>
                    </tr>
                    <tr>
                          <td align="center" bgcolor="#434983" class="style20">A holiday should be active if it falls on a weekday and if PGC will operate.</td>
                    </tr>
                    <tr>
                          <td align="center" class="style20">&nbsp;</td>
                    </tr>
              </table>
              <table width="500" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                          <td align="center" valign="middle" bgcolor="#333366">Session</td>
                          <td align="center" valign="middle" bgcolor="#333366">Session Start</td>
                          <td align="center" valign="middle" bgcolor="#333366">Session End</td>
                          <td align="center" valign="middle" bgcolor="#333366">Session Active</td>
                          <td align="center" valign="middle" bgcolor="#333366">Modified By</td>
                          <td align="center" valign="middle" bgcolor="#333366">Modified Date</td>
                    </tr>
                    <?php do { ?>
                          <tr>
                                <td align="center" valign="middle" bgcolor="#00366C"><a href="pgc_field_duty_control.php?fd_session=<?php echo $row_FDsessions['fd_session']; ?>"><?php echo $row_FDsessions['fd_session']; ?></a></td>
                                <td align="center" valign="middle" bgcolor="#00366C"><?php echo $row_FDsessions['session_start_date']; ?></td>
                                <td align="center" valign="middle" bgcolor="#00366C"><?php echo $row_FDsessions['session_end_date']; ?></td>
                                <td align="center" valign="middle" bgcolor="#00366C"><?php echo $row_FDsessions['session_active']; ?></td>
                                <td align="center" valign="middle" bgcolor="#00366C"><?php echo $row_FDsessions['modified_by']; ?></td>
                                <td align="center" valign="middle" bgcolor="#00366C"><?php echo $row_FDsessions['modified_date']; ?></td>
                          </tr>
                          <?php } while ($row_FDsessions = mysql_fetch_assoc($FDsessions)); ?>
  </table>
              <table width="95%" cellspacing="1" cellpadding="5">
                    <tr>
                          <td align="center" class="style20">&nbsp;</td>
                    </tr>
                    <tr>
                          <td align="center" bgcolor="#434983" class="style20"><p>When you  setup or change session start or end dates - you have to run <a href="http://pgcsoaring.org/PGC_OPS/pgc_fd_insert_date_range.php">ADMIN - GENERATE WEEKEND FD DATES IN MASTER TABLE</a> .... this updates the PGC_FIELD_DUTY Table by adjusting the date session assignment - and it will add dates if the season is extended. It will not delete dates - that has to be done by the DBA until an app is developed.</p>
                                <p>Setting the Session to Active = Y allows members to select duty dates ... do not set Session Active = Y until all the session start and end dates are finalized. Changing the session start and end dates once  members have selected duty dates -  may mess up the schedule and require manual table cleanup. </p></td>
                    </tr>
                    <tr>
                          <td align="center" class="style20">&nbsp;</td>
                    </tr>
              </table>
              <table width="500" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                          <td width="290" align="center" valign="middle" bgcolor="#333366">Session Counts in PGC_FIELD_DUTY Table</td>
                          <td width="136" align="center" valign="middle" bgcolor="#333366"> Days In Session</td>
                    </tr>
                    <?php do { ?>
                          <tr>
                                <td align="center" valign="middle" bgcolor="#00366C"><?php echo $row_session_counts['session']; ?></td>
                                <td align="center" valign="middle" bgcolor="#00366C"><?php echo $row_session_counts['count(`session`)']; ?></td>
                          </tr>
                          <?php } while ($row_session_counts = mysql_fetch_assoc($session_counts)); ?>
  </table>
              <table width="500" border="0" cellpadding="2" cellspacing="2">
                    <?php do { ?>
                    <tr>
                          <td width="290" align="center" valign="middle" bgcolor="#00366C"> Total</td>
                          <td width="134" align="center" valign="middle" bgcolor="#00366C"><?php echo $row_session_total['count(`session`)']; ?></td>
                    </tr>
                    <?php } while ($row_session_counts = mysql_fetch_assoc($session_counts)); ?>
              </table>
              <table width="80%" cellspacing="1" cellpadding="5">
                    <tr>
                          <td align="center" class="style20">&nbsp;</td>
                    </tr>
                    <tr>
                          <td align="center" bgcolor="#434983" class="style20"><p>The counts in the table above show the actual session allocation after  running ...<a href="http://pgcsoaring.org/PGC_OPS/pgc_fd_insert_date_range.php"> ADMIN - GENERATE WEEKEND FD DATES IN MASTER TABLE</a>.</p></td>
                    </tr>
              </table>
              <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td height="33"><div align="center" class="style20">
            <p><a href="pgc_fd_menu.php" class="style16">BACK TO FD MENU</a></p>
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($FDsessions);

mysql_free_result($fd_holidays);

mysql_free_result($session_counts);

mysql_free_result($session_total);
?>
