<?php require_once('../Connections/PGC.php'); ?>
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
  $updateSQL = sprintf("UPDATE pgc_field_duty_selections SET choice1=%s, choice2=%s, choice3=%s WHERE key_check=%s",
                       GetSQLValueString($_POST['choice1'], "date"),
                       GetSQLValueString($_POST['choice2'], "date"),
                       GetSQLValueString($_POST['choice3'], "date"),
                       GetSQLValueString($_POST['key_check'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "xxxxxxxxxxxxxxxxx";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_MemberSelections = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_MemberSelections = $_SESSION['MM_Username'];
}
mysql_select_db($database_PGC, $PGC);
$query_MemberSelections = sprintf("SELECT key_check, member_id, member_name, fd_role, `session`, choice1, choice2, choice3, choice_status, date_selected, modified_by, modified_date, modify_ip, delete_record FROM pgc_field_duty_selections WHERE member_id = %s", GetSQLValueString($colname_MemberSelections, "text"));
$MemberSelections = mysql_query($query_MemberSelections, $PGC) or die(mysql_error());
$row_MemberSelections = mysql_fetch_assoc($MemberSelections);
$totalRows_MemberSelections = mysql_num_rows($MemberSelections);


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
.style32 {font-weight: bold; color: #000000; }
.style43 {font-size: 16px; }
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
                      <td bgcolor="#333366"><div align="center"><span class="style24">FIELD DUTY - SELECT DAYS</span></div></td>
                </tr>
                </table>
            </div></td>
      </tr>
      
      <tr>
        <td height="108" align="center" valign="top"><p>&nbsp;</p>
              <table width="400" border="1" cellpadding="2" cellspacing="2" bgcolor="#6666FF">
                    <tr>
                          <td width="381" height="30" valign="middle" bgcolor="#6666FF" class="style32"><div align="center" class="style43">SESSION: <?php echo $_SESSION['fd_active_session'] ?></div></td>
                    </tr>
  </table>
              <table width="400" border="1" cellpadding="2" cellspacing="2" bgcolor="#6666FF">
                    <tr>
                          <td width="214" height="30" valign="middle" bgcolor="#6666FF" class="style32"><div align="center" class="style43"><?php echo $_SESSION['MM_PilotName']; ?></div></td>
                          <td width="214" valign="middle" bgcolor="#6666FF" class="style32"><div align="center" class="style43"><?php echo $_SESSION['MM_Username']; ?></div></td>
                    </tr>
  </table>
              <p>&nbsp;</p>
               
              <p>&nbsp;</p>
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
            <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Choice1:</td>
                  <td><input type="text" name="choice1" value="<?php echo htmlentities($row_MemberSelections['choice1'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Choice2:</td>
                  <td><input type="text" name="choice2" value="<?php echo htmlentities($row_MemberSelections['choice2'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Choice3:</td>
                  <td><input type="text" name="choice3" value="<?php echo htmlentities($row_MemberSelections['choice3'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
                  <td nowrap="nowrap" align="right">&nbsp;</td>
                  <td><input type="submit" value="Update record" /></td>
            </tr>
      </table>
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="key_check" value="<?php echo $row_MemberSelections['key_check']; ?>" />
</form>
<p>&nbsp;</p>
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
mysql_free_result($MemberSelections);


?>
