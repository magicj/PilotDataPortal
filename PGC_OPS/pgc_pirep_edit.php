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


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pgc_pirep SET pirep_date=%s, pirep_desc=%s, rec_deleted=%s WHERE pirep_key=%s",
                       GetSQLValueString($_POST['pirep_date'], "date"),
                       GetSQLValueString($_POST['pirep_desc'], "text"),
                       GetSQLValueString($_POST['rec_deleted'], "text"),
                       GetSQLValueString($_POST['pirep_key'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "pgc_pirep_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_pirep";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);$colname_Recordset1 = "-1";
if (isset($_GET['pirep_key'])) {
  $colname_Recordset1 = $_GET['pirep_key'];
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_pirep WHERE pirep_key = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

/* EXIT */
 if (($_SESSION['MM_PilotName'] <> $row_Recordset1['id_name']) ) {
 
     $updateGoTo = "pgc_pirep_list.php";
     $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
     $updateGoTo .= $_SERVER['QUERY_STRING'];
 
  header(sprintf("Location: %s", $updateGoTo));
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
            <td height="398" bgcolor="#666666"><table width="900" height="623" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#005B5B">
                        <tr>
                              <td width="1562" height="63" valign="top" bgcolor="#0A335C"><div align="center">
                                      <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                      <td height="16" valign="top"><div align="center">
                                                            <table width="90%" cellspacing="0" cellpadding="0">
                                                                  <tr>
                                                                        <td height="35" align="center"><span class="style42">PGC PIREPS Plus</span></td>
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
                                <td height="515" align="center" valign="top" bgcolor="#0A335C">&nbsp;
                                      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                                            <table width="586" height="454" align="center">
                                                  <tr valign="baseline">
                                                        <td bgcolor="#666666"><span class="style41"><?php echo $_SESSION['MM_PilotName']; ?> &nbsp;</span></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td>&nbsp;</td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td><table width="479" height="31" cellpadding="0" cellspacing="0">
                                                                  <tr>
                                                                        <td width="165" align="left"><span class="style44">Edit PIREP Record:</span></td>
                                                                          <td width="312" align="left" bgcolor="#0A335C" class="style44"><?php echo $row_Recordset1['pirep_key']; ?></td>
                                                                  </tr>
                                                        </table></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td>&nbsp;</td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td><span class="style44">Flight Date:</span></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td><input type="text" name="pirep_date" value="<?php echo htmlentities($row_Recordset1['pirep_date'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
                                                        <a href="#"
					   name="anchor2" class="style44" id="anchor2" onclick="cal.select(document.forms['form1'].pirep_date,'anchor2','yyyy-MM-dd'); return false">Select From Calendar</a></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td>&nbsp;</td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td><span class="style44">PIREP - 700 characters maximum</span></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td><textarea name="pirep_desc" cols="75" rows="10"><?php echo htmlentities($row_Recordset1['pirep_desc'], ENT_COMPAT, 'iso-8859-1'); ?></textarea></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td>&nbsp;</td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td><table width="317" cellpadding="0" cellspacing="0" class="style44">
                                                                  <tr>
                                                                          <td width="212" class="style44">DELETE ENTIRE PIREP ?:</td>
                                                                        <td width="103" align="center"><select name="rec_deleted" id="rec_deleted">
                                                                                    <option value="N" <?php if (!(strcmp("N", htmlentities($row_Recordset1['rec_deleted'], ENT_COMPAT, 'iso-8859-1')))) {echo "selected=\"selected\"";} ?>>N</option>
                                                                                    <option value="Y" <?php if (!(strcmp("Y", htmlentities($row_Recordset1['rec_deleted'], ENT_COMPAT, 'iso-8859-1')))) {echo "selected=\"selected\"";} ?>>Y</option>
                                                                        </select></td>
                                                                    </tr>
                                                        </table></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td>&nbsp;</td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                        <td height="26"><input type="submit" value="SAVE PIREP UPDATES" /></td>
                                                  </tr>
                                            </table>
                                            <p>
                                                  <input type="hidden" name="MM_update" value="form1" />
                                                  <input type="hidden" name="pirep_key" value="<?php echo $row_Recordset1['pirep_key']; ?>" />
                                            </p>
                                      </form></td>
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
