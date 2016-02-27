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

$colname_Recordset1 = "-1";
if (isset($_GET['instructorID'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['instructorID'] : addslashes($_GET['instructorID']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT instructorID, Name, cfig, rec_active FROM pgc_instructors WHERE instructorID = %s", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
	background-color: #283664;
	background-image: url(../images/Buttons/PGC%20copy.png);
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
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
  <tr>
    <td><div align="center"><span class="style1">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="481" valign="top"><p align="center"><span class="style26">FLIGHTSHEET CFIG LIST - UPDATE RECORD</span> </p>
            <table width="92%" height="407" align="center" cellpadding="2" cellspacing="3" bgcolor="#666666">
      
      <tr>
        <td height="373" bgcolor="#003366">&nbsp;
                <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                        <table width="389" align="center" cellpadding="3" cellspacing="2" bgcolor="#225879">
                                <tr valign="baseline">
                                        <td width="101" align="right" valign="middle" nowrap bgcolor="#00376F" class="style29"><div align="left">RECORD:</div></td>
                                        <td width="276" valign="middle" bgcolor="#00376F" class="style29"><?php echo $row_Recordset1['instructorID']; ?></td>
                                </tr>
                                <tr valign="baseline">
                                        <td align="right" valign="middle" nowrap bgcolor="#00376F" class="style29"><div align="left">CFIG NAME </div></td>
                                        <td valign="middle" bgcolor="#00376F" class="style29"><?php echo $row_Recordset1['Name']; ?></td>
                                </tr>
                                
                                <tr valign="baseline">
                                        <td align="right" valign="middle" nowrap bgcolor="#00376F" class="style29"><div align="left">ACTIVE</div></td>
                                        <td valign="middle" bgcolor="#00376F" class="style29"><select name="rec_active" id="rec_active">
                                                        <option value="Y" <?php if (!(strcmp("Y", $row_Recordset1['rec_active']))) {echo "selected=\"selected\"";} ?>>Y</option>
                                                        <option value="N" <?php if (!(strcmp("N", $row_Recordset1['rec_active']))) {echo "selected=\"selected\"";} ?>>N</option>
                                                </select>
                                                </td>
                                </tr>
                                <tr valign="baseline">
                                        <td height="69" colspan="2" align="right" valign="middle" nowrap bgcolor="#00376F"><div align="left"></div>                                                
                                                <div align="center">
                                                        <input type="submit" value="Update record">
                                                </div></td>
                                        </tr>
                        </table>
                        <input type="hidden" name="MM_update" value="form1">
                        <input type="hidden" name="instructorID" value="<?php echo $row_Recordset1['instructorID']; ?>">
                </form>
                <p>&nbsp;</p></td>
      </tr>
    </table>
    <p align="center"><a href="pgc_cfig_list_cfigs.php" class="style26">RETURN TO CFIG LIST</a></p></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
