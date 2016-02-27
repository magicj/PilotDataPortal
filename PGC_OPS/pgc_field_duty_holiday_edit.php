<?php require_once('../Connections/PGC.php');?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pgc_field_duty_holidays SET holiday_date=%s, holiday_active=%s WHERE holiday_name=%s",
                       GetSQLValueString($_POST['holiday_date'], "date"),
                       GetSQLValueString($_POST['holiday_active'], "text"),
                       GetSQLValueString($_POST['holiday_name'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "pgc_field_duty_control_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_PGC, $PGC);
$query_fd_holidays = "SELECT holiday_name, holiday_date, holiday_active FROM pgc_field_duty_holidays";
$fd_holidays = mysql_query($query_fd_holidays, $PGC) or die(mysql_error());
$row_fd_holidays = mysql_fetch_assoc($fd_holidays);
$totalRows_fd_holidays = mysql_num_rows($fd_holidays);$colname_fd_holidays = "-1";
if (isset($_GET['holiday_name'])) {
  $colname_fd_holidays = $_GET['holiday_name'];
}
mysql_select_db($database_PGC, $PGC);
$query_fd_holidays = sprintf("SELECT holiday_name, holiday_date, holiday_active FROM pgc_field_duty_holidays WHERE holiday_name = %s", GetSQLValueString($colname_fd_holidays, "text"));
$fd_holidays = mysql_query($query_fd_holidays, $PGC) or die(mysql_error());
$row_fd_holidays = mysql_fetch_assoc($fd_holidays);
$totalRows_fd_holidays = mysql_num_rows($fd_holidays);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script src="../java/javascripts.js" type="text/javascript"></script>
<script src="../java/CalendarPopup.js" type="text/javascript"></script>
<script src="../java/zxml.js" type="text/javascript"></script>
<script src="../java/workingjs.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript" ID="js1">
		var cal = new CalendarPopup();
</SCRIPT>
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
	background-color: #333333;
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
.style20 {	font-size: 16px;
	font-weight: bold;
	color: #FFCCCC;
}
.style24 {font-size: 16px; font-weight: bold; color: #CCCCCC; }
.style28 {font-size: 12px}
.style23 {font-size: 16px; font-weight: bold; color: #FFCCCC; font-style: italic; }
.style44 {color: #999999;
	font-weight: bold;
}
-->
</style></head>

<body>
<table width="800" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td width="1002"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="190" bgcolor="#3E3E5E"><table width="99%" height="186" border="0" align="center" cellpadding="5" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="25"><div align="center">
            <table width="99%" border="0" cellspacing="2" cellpadding="2">
                <tr>
                      <td bgcolor="#333366"><div align="center"><span class="style24">FIELD DUTY HOLIDAY EDIT</span></div></td>
                </tr>
                </table>
            </div></td>
      </tr>
      
      <tr>
        <td height="108" align="center" valign="top">&nbsp;
              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                    <table align="center">
                          <tr valign="baseline">
                                <td width="83" align="right" nowrap="nowrap">Holiday_name:</td>
                                <td width="294"><?php echo $row_fd_holidays['holiday_name']; ?></td>
                          </tr>
                          <tr valign="baseline">
                                <td nowrap="nowrap" align="right">Holiday_date:</td>
                                <td><input name="holiday_date" type="text" id="holiday_date" value="<?php echo $row_fd_holidays['holiday_date']; ?>" size="10" />
                                      <a href="#"
					   name="anchor2" class="style44" id="anchor2" onclick="cal.select(document.forms['form1'].holiday_date,'anchor2','yyyy-MM-dd'); return false">Select From Calendar</a></td>
                          </tr>
                          <tr valign="baseline">
                                <td nowrap="nowrap" align="right">Holiday_active:</td>
                                <td><select name="holiday_active" id="holiday_active">
                                      <option value="Y" <?php if (!(strcmp("Y", $row_fd_holidays['holiday_active']))) {echo "selected=\"selected\"";} ?>>Y</option>
                                      <option value="N" <?php if (!(strcmp("N", $row_fd_holidays['holiday_active']))) {echo "selected=\"selected\"";} ?>>N</option>
                                </select></td>
                          </tr>
                          <tr valign="baseline">
                                <td nowrap="nowrap" align="right">&nbsp;</td>
                                <td><input type="submit" value="Update record" /></td>
                          </tr>
                    </table>
                    <input type="hidden" name="MM_update" value="form1" />
                    <input type="hidden" name="holiday_name" value="<?php echo $row_fd_holidays['holiday_name']; ?>" />
              </form>
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
mysql_free_result($fd_holidays);
?>
