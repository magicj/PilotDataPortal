<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
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
  $updateSQL = sprintf("UPDATE pgc_access_member_groups SET   rec_active=%s WHERE rec_key=%s",
                       GetSQLValueString($_POST['rec_active'], "text"),
                       GetSQLValueString($_POST['rec_key'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "pgc_access_member_group_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['rec_key'])) {
  $colname_Recordset1 = $_GET['rec_key'];
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT rec_key, member_name, assigned_group, rec_active FROM pgc_access_member_groups WHERE rec_key = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC EQUIPMENT WORK VIEW</title>
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
.style16 {color: #CCCCCC; }
a:link {
	color: #CCCCCC;
}
a:visited {
	color: #CCCCCC;
}
.style17 {
	color: #CCCCCC;
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
.style57 {color: #FFFFFF; font-weight: bold; }
.style59 {
	color: #999999;
	font-weight: bold;
	font-style: italic;
	font-size: 14px;
}
-->
</style>
</head>
<body>
<table width="900" height="95%" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
      <tr>
            <td align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="521" bgcolor="#666666"><table width="95%" height="95%" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#003648">
                        <tr>
                                <td width="1562" height="26" valign="middle" bgcolor="#005B5B" class="style57"><div align="center" class="style59">  MEMBER ASSIGNED ACCESS GROUP EDIT</div></td>
                        </tr>
                        <tr>
                          <td height="464" align="center" valign="top" bgcolor="#005B5B"><p>&nbsp;</p>
                              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                                  <table align="center">
                                      <tr valign="baseline">
                                          <td nowrap="nowrap" align="right">Rec_key:</td>
                                          <td><?php echo $row_Recordset1['rec_key']; ?></td>
                                      </tr>
                                      <tr valign="baseline">
                                          <td nowrap="nowrap" align="right">Member_name:</td>
                                          <td><input type="text" name="member_name" value="<?php echo htmlentities($row_Recordset1['member_name'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                      </tr>
                                      <tr valign="baseline">
                                          <td nowrap="nowrap" align="right">Assigned_group:</td>
                                          <td><input type="text" name="assigned_group" value="<?php echo htmlentities($row_Recordset1['assigned_group'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                      </tr>
                                      <tr valign="baseline">
                                          <td nowrap="nowrap" align="right">Rec_active:</td>
                                          <td><select name="rec_active" id="rec_active">
                                              <option value="Y" selected="selected" <?php if (!(strcmp("Y", $row_Recordset1['rec_active']))) {echo "selected=\"selected\"";} ?>>Y</option>
                                              <option value="N" <?php if (!(strcmp("N", $row_Recordset1['rec_active']))) {echo "selected=\"selected\"";} ?>>N</option>
                                              <option value="D" <?php if (!(strcmp("D", $row_Recordset1['rec_active']))) {echo "selected=\"selected\"";} ?>>D</option>
                                          </select></td>
                                      </tr>
                                      <tr valign="baseline">
                                          <td nowrap="nowrap" align="right">&nbsp;</td>
                                          <td><input type="submit" value="Update record" /></td>
                                      </tr>
                                  </table>
                                  <input type="hidden" name="MM_update" value="form1" />
                                  <input type="hidden" name="rec_key" value="<?php echo $row_Recordset1['rec_key']; ?>" />
                              </form>
                            <p>&nbsp;</p></td>
                        </tr>
                        <tr>
                          <td height="24" bgcolor="#005B5B" class="style16"><div align="center"><a href="pgc_access_menu.php" class="style17">BACK TO ACCESS MENU </a><a href="../07_members_only_pw.php" class="style17"></a></div></td>
                        </tr>
        </table></td>
      </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
