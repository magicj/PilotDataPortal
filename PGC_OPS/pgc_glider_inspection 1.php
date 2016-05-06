<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pgc_gliders SET inspection_hours=%s, inspection_date=%s WHERE glider=%s",
                       GetSQLValueString($_POST['inspection_hours'], "double"),
                       GetSQLValueString($_POST['inspection_date'], "date"),
                       GetSQLValueString($_POST['glider'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "pgc_flightlog_metrics.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['gliderID'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['gliderID'] : addslashes($_GET['gliderID']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT glider, inspection_hours, inspection_date FROM pgc_gliders WHERE glider = '%s'", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
 if (!isset($_SESSION)) {
  session_start();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Glider Inspection</title>
<style type="text/css">
<!--
.style1 {	font-size: 18px;
	font-weight: bold;
}
body {
	background-color: #333333;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
.style3 {font-size: 16px; font-weight: bold; }
.style16 {color: #CCCCCC; }
.style17 {color: #330033}
.style25 {font-size: 18px; font-weight: bold; color: #000000; }
.style26 {
	color: #CCCCCC;
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
</head>

<script language="javascript" src="../calendar/calendar.js"></script>




<body>
<p>&nbsp;</p>
<table width="800" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#408080">
  <tr>
    <td bgcolor="#356A6A"><div align="center"><span class="style1">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="481" bgcolor="#666666"><table width="92%" height="447" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#5F495F">
      
      <tr>
        <td height="373" bgcolor="#4F5359"><p align="center" class="style26">Update Glider Inspection Log
            <!--<form action="somewhere.php" method="post">
*/</form>

<p>&nbsp;</p>
--></p>
            <p align="center" class="style26">&nbsp;</p>
          
                <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
            <table border="0" align="center" cellpadding="5" cellspacing="2" bgcolor="#666666">
              <tr valign="baseline">
                <td width="186" height="27" align="right" nowrap bgcolor="#408080"><div align="left" class="style26">GLIDER</div></td>
                <td width="128" bgcolor="#408080" class="style26"><div align="center"><?php echo $row_Recordset1['glider']; ?></div></td>
              </tr>
              <tr valign="baseline">
                <td height="32" align="right" nowrap bgcolor="#408080"><div align="left" class="style26">INSPECTED AT (HOURS): </div></td>
                <td bgcolor="#408080"><input name="inspection_hours" type="text" value="<?php echo $row_Recordset1['inspection_hours']; ?>" size="7" maxlength="7"></td>
              </tr>
              <tr valign="baseline">
                <td height="44" align="right" nowrap bgcolor="#408080"><div align="left" class="style26">INSPECTION DATE: </div></td>
                <td bgcolor="#408080"><input name="inspection_date" type="text" value="<?php echo $row_Recordset1['inspection_date']; ?>" size="10" maxlength="10"></td>
              </tr>
              <tr valign="baseline">
                <td height="41" colspan="2" align="right" valign="middle" nowrap bgcolor="#408080"><div align="center">
                  <input type="submit" value="Update record">
                </div></td>
                </tr>
            </table>
            <input type="hidden" name="MM_update" value="form1">
            <input type="hidden" name="glider" value="<?php echo $row_Recordset1['glider']; ?>">
          </form>
          <p>&nbsp;</p>
          <p align="center" class="style26">&nbsp;</p>
          <p>
              <label></label>
              <label></label>
          </p></td>
      </tr>
      <tr>
 

        <td height="28" bgcolor="#4F5359"><div align="center"><strong class="style3"><a href="pgc_flightlog_metrics.php" class="style16">BACK TO METRICS</a></strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
