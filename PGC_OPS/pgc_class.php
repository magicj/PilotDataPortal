<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO pgc_class (member_name, event_date, event_name, primary_instructor, event_notes, entered_by, entry_ip) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['member_name'], "text"),
                       GetSQLValueString($_POST['event_date'], "date"),
                       GetSQLValueString($_POST['event_name'], "text"),
                       GetSQLValueString($_POST['primary_instructor'], "text"),
					   GetSQLValueString($_POST['event_notes'], "text"),
                       GetSQLValueString('System', "text"),
                       GetSQLValueString('System', "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

  $insertGoTo = "../07_members_only_pw.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
 
error_reporting(0);
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
<title>PGC CLASS</title>
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
.style47 {color: #C5C2D6; font-size: 14px; font-weight: bold; font-style: italic; }
.style50 {color: #FFFFFF; font-weight: bold; }
.style53 {font-size: 16px}
.style44 {color: #FF0000;
	font-weight: bold;
}
.style17 {	color: #CCCCCC;
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
-->
</style>
</head>
<body>
<table width="800" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
      <tr>
            <td align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="398" bgcolor="#666666"><table width="95%" height="344" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#005B5B">
                        <tr>
                          <td width="1562" height="23" valign="top" bgcolor="#0A335C"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="15%"><a href="pgc_squawk_view.php"></a></td>
                              <td width="7%">&nbsp;</td>
                              <td width="56%" class="style47"><div align="center" class="style53">PGC CLASS ENTRY</div></td>
                              <td width="16%">&nbsp;</td>
                              <td width="6%">&nbsp;</td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="277" align="center" valign="top" bgcolor="#0A335C"><p> </p>
                                  </p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                                          <table align="center" cellpadding="4" cellspacing="3" bgcolor="#A2B3B3">
                                                  <tr valign="baseline">
                                                          <td align="right" valign="middle" nowrap bgcolor="#35415B" class="style50"><div align="left" class="style16">
                                                                  <div align="left">MEMBER NAME </div>
                                                          </div></td>
                                                          <td valign="middle" bgcolor="#35415B"><input type="text" name="member_name" value="" size="32"></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                          <td align="right" valign="middle" nowrap bgcolor="#35415B" class="style50"><div align="left" class="style16">
                                                                  <div align="left">DATE</div>
                                                          </div></td>
                                                          <td valign="middle" bgcolor="#35415B"><input name="event_date" type="text" size="10" maxlength="10">
                                                                  <a href="#"
					   name="anchor2" class="style44" id="anchor2" onclick="cal.select(document.forms['form2'].event_date,'anchor2','yyyy-MM-dd'); return false">Select From Calendar</a></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                          <td align="right" valign="middle" nowrap bgcolor="#35415B" class="style50"><div align="left" class="style16">
                                                                  <div align="left">ACHIEVEMENT</div>
                                                          </div></td>
                                                          <td valign="middle" bgcolor="#35415B"><select name="event_name" id="event_name">
                                                                          <option value="FIRST SOLO" selected="selected">FIRST SOLO</option>
                                                                          <option value="CERTIFICATE">CERTIFICATE</option>
                                                                          <option value="PVT GLIDER RATING"> PVT GLIDER RATING</option>
                                                                          <option value="COMMERCIAL">COMMERCIAL</option>
                                                                          <option value="CFIG">CFIG</option>
                                                                          <option value="FIRST SOLO XC">FIRST SOLO XC</option>
                                                                          <option value="FIRST CONTEST">FIRST CONTEST </option>
                                                                          <option value="BRONZE BADGE">BRONZE BADGE</option>
                                                                          <option value="SILVER ALTITUDE">SILVER ALTITUDE</option>
                                                                          <option value="SILVER DISTANCE">SILVER DISTANCE</option>
                                                                          <option value="SILVER DURATION">SILVER DURATION</option>
                                                                          <option value="GOLD ALTITUDE">GOLD ALTITUDE</option>
                                                                          <option value="GOLD DISTANCE">GOLD DISTANCE</option>
                                                                          <option value="DIAMOND ALTITUDE">DIAMOND ALTITUDE</option>
                                                                          <option value="DIAMOND DISTANCE">DIAMOND DISTANCE</option>
                                                                          <option value="DIAMOND GOAL">DIAMOND GOAL</option>
                                                                          <option value="1000 K DIPLOMA">1000 K DIPLOMA</option>
                                                                  </select></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                          <td align="right" valign="middle" nowrap bgcolor="#35415B" class="style50"><div align="left" class="style16">
                                                                  <div align="left">PRIMARY INSTRUCTOR </div>
                                                          </div></td>
                                                          <td valign="middle" bgcolor="#35415B"><input type="text" name="primary_instructor" value="" size="32"></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                          <td align="right" valign="middle" nowrap bgcolor="#35415B" class="style50"><div align="left"><span class="style16">EVENT COMMENTS</span></div></td>
                                                          <td valign="middle" bgcolor="#35415B"><textarea name="event_notes" cols="50" rows="5" id="event_notes"></textarea></td>
                                                  </tr>

                                                  <tr valign="baseline">
                                                          <td colspan="2" align="right" nowrap bgcolor="#35415B"><div align="center">
                                                                  <input type="submit" value="Insert record">
                                                          </div></td>
                                                          </tr>
                                          </table>
                                          <input type="hidden" name="MM_insert" value="form2">
                                  </form>
                                  <p>&nbsp;</p></td>
                        </tr>
                        <tr>
                              <td height="30" bgcolor="#4F5359" class="style16"><div align="center"><a href="../07_members_only_pw.php" class="style17">BACK TO MEMBER'S PAGE </a></div></td>
                        </tr>
                  </table></td>
      </tr>
</table>
</body>
</html>


