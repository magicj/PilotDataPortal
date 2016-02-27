<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
/* ==========================================================*/
require_once('pgc_access_save_appname.php'); 
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
require_once('pgc_access_check.php');
/* END - PAGE ACCESS CHECKING LOGIC - END */
/* ==========================================================*/
?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pgc_access_app_groups SET rec_active=%s WHERE rec_key=%s",
                       GetSQLValueString($_POST['rec_active'], "text"),
                       GetSQLValueString($_GET['rec_key'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = $_SESSION['last_app_group_list_page'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['rec_key'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['rec_key'] : addslashes($_GET['rec_key']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_access_app_groups WHERE rec_key = %s", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
.style65 {color: #000000}
.style67 {color: #3030C5; }
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
                                <td width="1562" height="26" valign="middle" bgcolor="#005B5B" class="style57"><div align="center" class="style59">  APPLICATION ASSIGNED ACCESS GROUP EDIT </div></td>
                        </tr>
                        <tr>
                          <td height="464" align="center" valign="top" bgcolor="#005B5B"><p>&nbsp;</p>
                                  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                                          <table align="center" cellpadding="3" cellspacing="2" bgcolor="#666666">
                                                  
                                                  <tr valign="baseline">
                                                          <td width="150" height="35" align="right" valign="middle" nowrap bgcolor="#B49AF8" class="style59"><div align="left" class="style65">APP NAME</div></td>
                                                          <td width="202" valign="middle" bgcolor="#B49AF8" class="style59"><div align="left" class="style67"><?php echo $row_Recordset1['app_name']; ?></div></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                          <td align="right" valign="middle" nowrap bgcolor="#B49AF8" class="style59"><div align="left" class="style65">ALLOWED GROUP </div></td>
                                                          <td valign="middle" bgcolor="#B49AF8" class="style59"><div align="left" class="style67"><?php echo $row_Recordset1['allowed_group']; ?></div></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                          <td align="right" valign="middle" nowrap bgcolor="#B49AF8" class="style59"><div align="left" class="style65">ACTIVE or DELETE </div></td>
                                                          <td valign="middle" bgcolor="#B49AF8" class="style59"><div align="left" class="style65">
                                                                  <select name="rec_active" id="rec_active">
                                                                          <option value="Y">Y</option>
                                                                          <option value="N">N</option>
                                                                          <option value="D">D</option>
                                                                  </select>
                                                          </div></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                          <td height="35" colspan="2" align="right" valign="middle" nowrap bgcolor="#B49AF8">
                                                                          <div align="center">
                                                                                  <input type="submit" value="Update record">
                                                                        </div></td>
                                                          </tr>
                                          </table>
                                          <input type="hidden" name="MM_update" value="form1">
                                          <input type="hidden" name="app_name" value="<?php echo $row_Recordset1['app_name']; ?>">
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

