<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_access_save_appname.php'); 
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
require_once('pgc_access_app_check.php');
/* END - PAGE ACCESS CHECKING LOGIC - END */
?>
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

if ( (isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && ($_SESSION['MM_PilotName'] <> "") ) {
  $insertSQL = sprintf("INSERT INTO pgc_pirep (id_entered, id_name, pirep_date, pirep_desc) VALUES ( %s, %s, %s, %s) ",
                       GetSQLValueString($_SESSION['MM_Username'], "text"),
                       GetSQLValueString($_SESSION['MM_PilotName'], "text"),
                       GetSQLValueString($_POST['pirep_date'], "date"),
                       GetSQLValueString($_POST['pirep_desc'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

  $insertGoTo = "pgc_pirep_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_pirep";
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
<title>PGC PIREP</title>
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
	color: #000000;
	font-size: 16px;
	font-weight: bold;
	font-style: italic;
	font-family: Arial, Helvetica, sans-serif;
}
.style35 {color: #FFFFFF; font-size: 14px; font-weight: bold; font-style: italic; }
.style37 {color: #EBEBEB; font-size: 14px; font-weight: bold; font-style: italic; }
.style38 {color: #EBEBEB; }
.style40 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 12px;
}
.style41 {
	font-size: 18px;
	color: #FFFFFF;
}
.style42 {
	font-size: 18px;
	font-weight: bold;
	font-style: italic;
	color: #FFFFFF;
}
.style43 {
	font-size: 12px;
	color: #000;
	text-align: left;
}
.style44 {
	color: #CCCCCC;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
}
-->
</style>
</head>
<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
      <tr>
            <td height="398" bgcolor="#666666"><table width="900" height="519" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#005B5B">
                        <tr>
                              <td width="1562" height="29" valign="top" bgcolor="#0A335C"><div align="center">
                                      <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                      <td height="16" valign="top"><div align="center">
                                                            <table width="90%" cellspacing="0" cellpadding="0">
                                                                  <tr>
                                                                        <td align="center"><span class="style42">PGC PIREPS Plus</span></td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td align="center"><span class="style35">Share your solo, flight-test, cross-country, WX or  other soaring  experiences and insights with PGC members</span></td>
                                                                  </tr>
                                                            </table>
                                                      </div></td>
                                              </tr>
                                          </table>
                              </div></td>
                        </tr>
                        <tr>
                                <td height="446" align="center" valign="top" bgcolor="#0A335C">&nbsp;
                                      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                                            <table width="632" align="center" cellpadding="5">
                                                  <tr valign="baseline" bgcolor="#999999">
                                                        <td width="616" height="33" valign="middle"><div align="left" class="style41"><?php echo $_SESSION['MM_PilotName']; ?> &nbsp;</div></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td height="2" class="style44">&nbsp;</td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td height="25" class="style44">Flight Date:</td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td height="60"><input name="pirep_date" type="text" id="pirep_date" value="<?php echo date("Y-m-d")?>" size="10" />
                                                        <a href="#"
					   name="anchor2" class="style44" id="anchor2" onclick="cal.select(document.forms['form1'].pirep_date,'anchor2','yyyy-MM-dd'); return false">Select From Calendar</a></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td><p class="style44">PIREP - 700 characters maximum</p>
                                                              <p>
                                                                    <textarea name="pirep_desc" cols="75" rows="10"></textarea>
                                                        </p></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td><input type="submit" value="Save Pirep" /></td>
                                                  </tr>
                                            </table>
                                            <input type="hidden" name="MM_insert" value="form1" />
                                      </form>
                                <p>&nbsp;</p></td>
                        </tr>
                        <tr>
                              <td height="30" bgcolor="#4F5359" class="style16"><div align="center">
                                    <table width="389" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td width="157" height="27" align="center" bgcolor="#234747"><a href="../07_members_only_pw.php" class="style17">MEMBER'S PAGE </a></td>
                                                <td width="73">&nbsp;</td>
                                                <td width="157" align="center" bgcolor="#234747"><a href="pgc_pirep_list.php" class="style17">PIREP LIST</a></td>
                                          </tr>
                                    </table>
                              <a href="../07_members_only_pw.php" class="style17"></a></div></td>
                        </tr>
            </table></td>
      </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
