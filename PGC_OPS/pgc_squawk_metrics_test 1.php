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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE pgc_squawk_metrics SET ship_captain=%s, `new`=%s, `open`=%s, pending=%s, completed=%s, total_$=%s, total_hrs=%s, metrics_status=%s WHERE metrics_equipment=%s",
                       GetSQLValueString($_POST['ship_captain'], "text"),
                       GetSQLValueString($_POST['new'], "int"),
                       GetSQLValueString($_POST['open'], "int"),
                       GetSQLValueString($_POST['pending'], "int"),
                       GetSQLValueString($_POST['completed'], "int"),
                       GetSQLValueString($_POST['total_'], "double"),
                       GetSQLValueString($_POST['total_hrs'], "double"),
                       GetSQLValueString($_POST['metrics_status'], "text"),
                       GetSQLValueString($_POST['metrics_equipment'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
}

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_squawk_metrics";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
<title>PGC SQUAWK METRICS</title>
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
.style45 {color: #FFFFFF}
.style47 {color: #C5C2D6; font-size: 14px; font-weight: bold; font-style: italic; }
.style48 {color: #92DADA; font-size: 14px; font-weight: bold; font-style: italic; }
.style50 {color: #FFFFFF; font-weight: bold; }
.style53 {font-size: 16px}
-->
</style>
</head>
<body>
<table width="1200" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
      <tr>
            <td align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="398" bgcolor="#666666"><table width="95%" height="344" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#005B5B">
                        <tr>
                          <td width="1562" height="23" valign="top" bgcolor="#0A335C"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="15%"><a href="pgc_squawk_view.php"><img src="Graphics/SquawkList copy.png" alt="SquawkList" width="130" height="30" border="0" /></a></td>
                              <td width="7%">&nbsp;</td>
                              <td width="56%" class="style47"><div align="center" class="style53">ADMIN - SQUAWK SUMMARY METRICS (In Development) </div></td>
                              <td width="16%">&nbsp;</td>
                              <td width="6%">&nbsp;</td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="277" align="center" valign="top" bgcolor="#0A335C"><form id="form1" name="form1" method="post" action="">
                          </form>
                          <p>&nbsp;</p>
                                  
                            
                          <form method="post" name="form2" action="<?php echo $editFormAction; ?>">
                            <table align="center">
                              <tr valign="baseline">
                                <td nowrap align="right">Metrics_equipment:</td>
                                <td><?php echo $row_Recordset1['metrics_equipment']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Ship_captain:</td>
                                <td><input type="text" name="ship_captain" value="<?php echo $row_Recordset1['ship_captain']; ?>" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">New:</td>
                                <td><input type="text" name="new" value="<?php echo $row_Recordset1['new']; ?>" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Open:</td>
                                <td><input type="text" name="open" value="<?php echo $row_Recordset1['open']; ?>" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Pending:</td>
                                <td><input type="text" name="pending" value="<?php echo $row_Recordset1['pending']; ?>" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Completed:</td>
                                <td><input type="text" name="completed" value="<?php echo $row_Recordset1['completed']; ?>" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Total_$:</td>
                                <td><input type="text" name="total_" value="<?php echo $row_Recordset1['total_$']; ?>" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Total_hrs:</td>
                                <td><input type="text" name="total_hrs" value="<?php echo $row_Recordset1['total_hrs']; ?>" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Metrics_status:</td>
                                <td><input type="text" name="metrics_status" value="<?php echo $row_Recordset1['metrics_status']; ?>" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Update record"></td>
                              </tr>
                            </table>
                            <input type="hidden" name="MM_update" value="form2">
                            <input type="hidden" name="metrics_equipment" value="<?php echo $row_Recordset1['metrics_equipment']; ?>">
                          </form>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          </p></td>
                        </tr>
                        <tr>
                              <td height="30" bgcolor="#4F5359" class="style16"><div align="center"></div></td>
                        </tr>
                  </table></td>
      </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>