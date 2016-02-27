<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
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


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT IGNORE INTO pgc_pilots (e_mail, pilot_name) VALUES (%s, %s)",
                       GetSQLValueString($_POST['USER_ID'], "text"),
                       GetSQLValueString($_POST['NAME'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());


  $insertSQL = sprintf("INSERT IGNORE INTO pgc_members (USER_ID, NAME, active, USER_PW) VALUES (%s, %s, %s, %s )",
                       GetSQLValueString($_POST['USER_ID'], "text"),
                       GetSQLValueString($_POST['NAME'], "text"),
                       GetSQLValueString('YES', "text"),
					   GetSQLValueString('pgcpassword', "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

  $insertGoTo = "pgc_enter_member_matt.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<?php
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT USER_ID, NAME, active FROM pgc_members";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
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
	background-color: #333333;
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style11 {font-size: 16px; font-weight: bold; }
.style16 {color: #CCCCCC; }
-->
</style></head>

<body>
<table width="800" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="514"><table width="92%" height="440" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36"><div align="center"><span class="style11">CHANGE EMAIL ADDRESS </span></div></td>
      </tr>
      <tr>
        <td height="373">&nbsp;
            <p>&nbsp;</p>
                    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                <table align="center">
                    <tr valign="baseline">
                        <td nowrap align="right">EMAIL ADDRESS :</td>
                        <td><input name="USER_ID" type="text" value="" size="40" maxlength="40"></td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap align="right">LASTNAME, FIRSTNAME </td>
                        <td><input name="NAME" type="text" value="" size="40" maxlength="40"></td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap align="right">&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap align="right">&nbsp;</td>
                        <td><input type="submit" value="Insert record"></td>
                    </tr>
                </table>
                <input type="hidden" name="MM_insert" value="form1">
            </form>
            <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td height="21"><div align="center"><strong class="style11"><a href="../PGC_OPS/pgc_portal_menu.php" class="style16">BACK TO PORTAL MENU</a></strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
