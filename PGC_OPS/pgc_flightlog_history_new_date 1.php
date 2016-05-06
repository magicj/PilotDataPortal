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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pgc_flightsheet (`Date`) VALUES (%s)",
                       GetSQLValueString($_POST['Date'], "date"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

  $insertGoTo = "pgc_flightlog_edit_history.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
 if (!isset($_SESSION)) {
  session_start();
}
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
.style11 {font-size: 16px; font-weight: bold; }
a:link {
	color: #CCCCCC;
}
a:visited {
	color: #CCCCCC;
}
.style16 {color: #CCCCCC; }
.style44 {color: #FF0000;
	font-weight: bold;
}
-->
</style></head>

<body>
<table width="800" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="314" valign="top" bgcolor="#535353"><table width="92%" height="302" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
            <tr>
                    <td height="23" valign="top"><div align="center"><span class="style11"> FLIGHTLOG HISTORY - ADD A NEW DATE</span></div></td>
            </tr>
            <tr>
                    <td height="271" valign="top" bgcolor="#413F69"><form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                                    <p>&nbsp;</p>
                            <table width="372" align="center" cellpadding="2" cellspacing="2" bgcolor="#999999">
                                            <tr valign="baseline">
                                                    <td width="107" height="38" align="right" valign="middle" nowrap bgcolor="#585775"><div align="center"><strong>NEW DATE:</strong> </div></td>
                                                    <td width="249" valign="middle" bgcolor="#585775">
                                                                    <div align="center">
                                                                            <input name="Date" type="text" value="" size="10" maxlength="10" />
                                                                        <a href="#"
					   name="anchor2" class="style44" id="anchor2" onclick="cal.select(document.forms['form1'].Date,'anchor2','yyyy-MM-dd'); return false">Select From Calendar</a></div></td>
                                            </tr>
                                            <tr valign="baseline">
                                                    <td colspan="2" align="right" nowrap bgcolor="#585775"><div align="left"></div>
                                                                    <div align="center">
                                                                            <input name="submit" type="submit" value="Insert record" />
                                                            </div></td>
                                            </tr>
                                    </table>
                            <input type="hidden" name="MM_insert" value="form1" />
                            </form>
                                    <p>&nbsp;</p>
                            <p align="center">&nbsp;</p>
                            <p align="center"><strong class="style11"><a href="../PGC_OPS/pgc_flightlog_edit_history.php" class="style16">BACK TO HISTORY DATE SELECTOR</a></strong></p></td>
            </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

