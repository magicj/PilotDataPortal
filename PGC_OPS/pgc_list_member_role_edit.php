<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_access_save_appname.php'); 
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
require_once('pgc_access_app_check.php');
/* END - PAGE ACCESS CHECKING LOGIC - END */

require_once('pgc_check_login.php'); 
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
  $updateSQL = sprintf("UPDATE pgc_members SET ROLE=%s WHERE USER_ID=%s",
                        GetSQLValueString($_POST['adminrole'], "text"),
                       GetSQLValueString($_POST['USER_ID'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  //$updateGoTo = "pgc_list_member_status.php";
  $updateGoTo = 'http://' . $_SERVER['HTTP_HOST']  .$_SESSION[last_query];
  if (isset($_SERVER['xQUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['USER_ID'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['USER_ID'] : addslashes($_GET['USER_ID']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_members WHERE USER_ID = '%s'", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php require_once('../Connections/PGC.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal </title>
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
.style11 {font-size: 16px; font-weight: bold; }
.style16 {color: #CCCCCC; }
a {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFCC;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #FFFFCC;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
.style17 {
	font-size: 14px;
	font-style: italic;
	font-weight: bold;
}
.style20 {color: #8CA6D8; font-style: italic; font-weight: bold; font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style></head>

<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
  <tr>
    <td><div align="center"><span class="style1">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="514"><table width="92%" height="440" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#464E62">
      <tr>
        <td height="36"><div align="center"><span class="style11">MODIFY MEMBER ADMIN ROLE</span></div></td>
      </tr>
      <tr>
        <td height="373">&nbsp;
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
            <table width="426" align="center" cellpadding="3" cellspacing="3" >
              <tr valign="baseline">
                <td width="126" height="18" align="right" nowrap bgcolor="#274669"><div align="left">E-MAIL:</div></td>
                <td width="277" bgcolor="#274669"><?php echo $row_Recordset1['USER_ID']; ?></td>
              </tr>
              <tr valign="baseline">
                    <td align="right" nowrap bgcolor="#274669"><div align="left">MEMBER NAME:</div></td>
                    <td bgcolor="#274669"><?php echo $row_Recordset1['NAME']; ?></td>
              </tr>
              <tr valign="baseline">
                    <td align="right" nowrap="nowrap" bgcolor="#274669"><div align="left">ADMIN ROLE:</div></td>
                    <td bgcolor="#274669"><p>
                          <select name="adminrole" id="adminrole">
                                <option value="" <?php if (!(strcmp("", $row_Recordset1['ROLE']))) {echo "selected=\"selected\"";} ?>></option>
                                <option value="ADMIN0" <?php if (!(strcmp("ADMIN0", $row_Recordset1['ROLE']))) {echo "selected=\"selected\"";} ?>>ADMIN0</option>
                                <option value="ADMIN1" <?php if (!(strcmp("ADMIN1", $row_Recordset1['ROLE']))) {echo "selected=\"selected\"";} ?>>ADMIN1</option>
                                <option value="ADMIN2" <?php if (!(strcmp("ADMIN2", $row_Recordset1['ROLE']))) {echo "selected=\"selected\"";} ?>>ADMIN2</option>
                                <option value="ADMIN3" <?php if (!(strcmp("ADMIN3", $row_Recordset1['ROLE']))) {echo "selected=\"selected\"";} ?>>ADMIN3</option>
                                <option value="DUMMY" <?php if (!(strcmp("DUMMY", $row_Recordset1['ROLE']))) {echo "selected=\"selected\"";} ?>>DUMMY</option>
                                </select>
                          </p></td>
              </tr>
              <tr valign="baseline">
                    <td height="30" colspan="2" align="right" valign="middle" nowrap bgcolor="#274669">
                          <div align="center">
                                <input type="submit" value="Update record">
                                </div></td>
              </tr>
            </table>
            <input type="hidden" name="MM_update" value="form1">
            <input type="hidden" name="USER_ID" value="<?php echo $row_Recordset1['USER_ID']; ?>">
          </form>
          <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td height="21"><div align="center"><strong class="style11"><a href="pgc_access_menu.php" class="style20">BACK TO ACCESS CONTROL  MENU</a><a href="../PGC_OPS/pgc_access_menu.php" class="style16"></a></strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>

		
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
