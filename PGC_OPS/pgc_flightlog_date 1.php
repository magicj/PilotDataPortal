<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?><?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php'?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT IGNORE INTO pgc_flightsheet_date (`date`) VALUES (%s)",
                       GetSQLValueString($_POST['date'], "date"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

  $insertGoTo = "pgc_flightlog_list_edit.php";
  $updateGoTo = 'http://' . $_SERVER['HTTP_HOST']  .$_SESSION[last_query];
  if (isset($_SERVER['xQUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_flightsheet_date ORDER BY `Date` DESC";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
	background-color: #333333;
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style11 {font-size: 16px; font-weight: bold; }
a:link {
	color: #CCCCCC;
}
a:visited {
	color: #CCCCCC;
}
.style16 {color: #CCCCCC; }
-->
</style></head>

<body>
<table width="800" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="514"><table width="92%" height="417" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36"><div align="center"><span class="style11"> OVERRIDE - SELECT FLIGHT SHEET DATE </span></div></td>
      </tr>
      <tr>
        <td height="373"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
          <table width="207" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#333333" bgcolor="#333333">
            <tr valign="baseline">
              <td height="32" align="right" valign="middle" nowrap="nowrap" bgcolor="#2B5555"><div align="left"><em><strong>DATE:</strong></em></div></td>
              <td valign="middle" bgcolor="#2B5555"><input name="date" type="text" value="<?php echo $row_Recordset1['date']; ?>" size="10" maxlength="10" /></td>
            </tr>
            
            <tr valign="baseline">
              <td height="32" align="right" valign="middle" nowrap="nowrap" bgcolor="#2B5555"><label></label></td>
              <td valign="middle" bgcolor="#2B5555"><div align="center">
                  <input name="submit" type="submit" value="Insert record" />
              </div></td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1" />
        </form>
          <p>&nbsp;</p>
          <p align="center">&nbsp;</p>
          
          <p align="center"><strong class="style11"><a href="../PGC_OPS/pgc_fd_menu.php" class="style16">BACK TO FD MENU</a></strong></p></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
