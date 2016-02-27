<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
$app_name = basename($_SERVER['PHP_SELF']);
require_once('pgc_access_check.php')
/* END - PAGE ACCESS CHECKING LOGIC - END */
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
  $updateSQL = sprintf("UPDATE pgc_instructors SET rec_active=%s WHERE instructorID=%s",
                       GetSQLValueString($_POST['rec_active'], "text"),
                       GetSQLValueString($_POST['instructorID'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "pgc_cfig_list_cfigs.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT NAME FROM pgc_members WHERE NAME <> '''' ORDER BY NAME ASC";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT  IGNORE INTO pgc_instructors (instructorID, Name, cfig, rec_active) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['instructorID'], "int"),
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString('Y', "text"),
                       GetSQLValueString('Y', "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

  $insertGoTo = "pgc_cfig_list_cfigs.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Flightlog</title>
<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
	color: #999999;
}
body {
	background-color: #333333;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
.style26 {
	color: #CCCCCC;
	font-size: 16px;
	font-weight: bold;
}
.style29 {color: #CCCCCC; font-size: 14px; font-weight: bold; }
-->
</style>
</head>

<script language="javascript" src="../calendar/calendar.js"></script>




<body>
<p>&nbsp;</p>
<table width="800" align="center" cellpadding="4" cellspacing="3" bordercolor="#000033" bgcolor="#525E7A">
  <tr>
    <td bgcolor="#422877"><div align="center"><span class="style1">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="481" valign="top" bgcolor="#212E4B"><p align="center"><span class="style26">PGC CFIG LIST - NEW CFIG RECORD</span> </p>
            <table width="92%" height="407" align="center" cellpadding="2" cellspacing="3" bgcolor="#666666">
      
      <tr>
        <td height="373" bgcolor="#182238"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table align="center">
                                
                                <tr valign="baseline">
                                        <td width="66" align="right" nowrap>Name:</td>
                                        <td width="306"><select name="Name" id="Name">
                                                        <?php
do {  
?>
                                                        <option value="<?php echo $row_Recordset1['NAME']?>"<?php if (!(strcmp($row_Recordset1['NAME'], $row_Recordset1['NAME']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['NAME']?></option>
                                                        <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                                                </select></td>
                                </tr>
                                
                                <tr valign="baseline">
                                        <td nowrap align="right">Rec_active:</td>
                                        <td><input type="text" name="rec_active" value="Y" size="32"></td>
                                </tr>
                                <tr valign="baseline">
                                        <td nowrap align="right">&nbsp;</td>
                                        <td><input type="submit" value="Insert record"></td>
                                </tr>
                        </table>
                        <input type="hidden" name="MM_insert" value="form2">
                </form>
                <p>&nbsp;</p></td>
      </tr>
    </table>
    <p align="center"><span class="style29"><a href="pgc_cfig_list_cfigs.php">RETURN TO CFIG LIST</a></span></p></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
