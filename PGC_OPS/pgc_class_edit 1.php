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
  $updateSQL = sprintf("UPDATE pgc_class SET member_name=%s, event_date=%s, event_name=%s, primary_instructor=%s, entered_by=%s, entry_ip=%s, event_notes=%s WHERE rec_index=%s",
                       GetSQLValueString($_POST['member_name'], "text"),
                       GetSQLValueString($_POST['event_date'], "date"),
                       GetSQLValueString($_POST['event_name'], "text"),
                       GetSQLValueString($_POST['primary_instructor'], "text"),
                       GetSQLValueString('System', "text"),
                       GetSQLValueString('System', "text"),
                       GetSQLValueString($_POST['event_notes'], "text"),
                       GetSQLValueString($_POST['rec_index'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "pgc_class_edit_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['rec_index'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['rec_index'] : addslashes($_GET['rec_index']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT rec_index, member_name, event_date, event_name, primary_instructor, entered_by, entry_ip, event_notes FROM pgc_class WHERE rec_index = %s", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<? error_reporting(0);
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
<title>PGC CLASS EDIT </title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
body {
	background-color: #283664;
	background-image: url(../images/Buttons/PGC%20copy.png);
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
.style11 {font-size: 16px; font-weight: bold; }
.style20 {color: #8CA6D8; font-style: italic; font-weight: bold; font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
</head>
<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80"> 
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
                              <td width="56%" class="style47"><div align="center" class="style53">PGC ACHIEVEMENTS  EDIT </div></td>
                              <td width="16%">&nbsp;</td>
                              <td width="6%">&nbsp;</td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="277" align="center" valign="middle" bgcolor="#0A335C"><form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                            <table align="center">
                                      
                                      <tr valign="baseline">
                                        <td width="132" align="right" valign="middle" nowrap="nowrap" bgcolor="#35415B" class="style50"><div align="left" class="style16">
                                            <div align="left">MEMBER NAME </div>
                                        </div></td>
                                        <td width="260"><div align="left">
                                          <input type="text" name="member_name" value="<?php echo $row_Recordset1['member_name']; ?>" size="32" />
                                        </div></td>
                                      </tr>
                                      <tr valign="baseline">
                                        <td align="right" valign="middle" nowrap="nowrap" bgcolor="#35415B" class="style50"><div align="left" class="style16">
                                            <div align="left">DATE</div>
                                        </div></td>
                                        <td><div align="left">
                                          <input name="event_date" type="text" value="<?php echo $row_Recordset1['event_date']; ?>" size="10" maxlength="10" />
                                          <a href="#"
					   name="anchor2" class="style44" id="anchor2" onclick="cal.select(document.forms['form1'].event_date,'anchor2','yyyy-MM-dd'); return false">Select From Calendar</a></div></td>
                                      </tr>
                                      <tr valign="baseline">
                                        <td align="right" valign="middle" nowrap="nowrap" bgcolor="#35415B" class="style50"><div align="left" class="style16">
                                            <div align="left">ACHIEVEMENT</div>
                                        </div></td>
                                        <td><div align="left">
                                          <select name="event_name" id="event_name">
                                              <option value="FIRST SOLO - A BADGE" selected="selected" <?php if (!(strcmp("FIRST SOLO - A BADGE", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>FIRST SOLO -  A BADGE</option>
                                              <option value="CERTIFICATE" <?php if (!(strcmp("CERTIFICATE", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>CERTIFICATE</option>
                                              <option value="PVT GLIDER RATING" <?php if (!(strcmp("PVT GLIDER RATING", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>> PVT GLIDER RATING</option>
                                              <option value="COMMERCIAL" <?php if (!(strcmp("COMMERCIAL", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>COMMERCIAL</option>
                                              <option value="CFIG" <?php if (!(strcmp("CFIG", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>CFIG</option>
                                              <option value="FIRST SOLO XC" <?php if (!(strcmp("FIRST SOLO XC", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>FIRST SOLO XC</option>
                                              <option value="FIRST CONTEST" <?php if (!(strcmp("FIRST CONTEST", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>FIRST CONTEST </option>
                                              <option value="BRONZE BADGE" <?php if (!(strcmp("BRONZE BADGE", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>BRONZE BADGE</option>
                                              <option value="SILVER ALTITUDE" <?php if (!(strcmp("SILVER ALTITUDE", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>SILVER ALTITUDE</option>
                                              <option value="SILVER DISTANCE" <?php if (!(strcmp("SILVER DISTANCE", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>SILVER DISTANCE</option>
                                              <option value="SILVER DURATION" <?php if (!(strcmp("SILVER DURATION", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>SILVER DURATION</option>
                                              <option value="GOLD ALTITUDE" <?php if (!(strcmp("GOLD ALTITUDE", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>GOLD ALTITUDE</option>
                                              <option value="GOLD DISTANCE" <?php if (!(strcmp("GOLD DISTANCE", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>GOLD DISTANCE</option>
                                              <option value="DIAMOND ALTITUDE" <?php if (!(strcmp("DIAMOND ALTITUDE", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>DIAMOND ALTITUDE</option>
                                              <option value="DIAMOND DISTANCE" <?php if (!(strcmp("DIAMOND DISTANCE", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>DIAMOND DISTANCE</option>
                                              <option value="DIAMOND GOAL" <?php if (!(strcmp("DIAMOND GOAL", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>DIAMOND GOAL</option>
                                              <option value="1000 K DIPLOMA" <?php if (!(strcmp("1000 K DIPLOMA", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>1000 K DIPLOMA</option>
                                              <option value="B BADGE" <?php if (!(strcmp("B BADGE", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>B BADGE</option>
                                              <option value="C BADGE" <?php if (!(strcmp("C BADGE", $row_Recordset1['event_name']))) {echo "selected=\"selected\"";} ?>>C BADGE</option>
                                          </select>
</div></td>
                                      </tr>
                                      <tr valign="baseline">
                                        <td align="right" valign="middle" nowrap="nowrap" bgcolor="#35415B" class="style50"><div align="left" class="style16">
                                            <div align="left">PRIMARY INSTRUCTOR </div>
                                        </div></td>
                                        <td><div align="left">
                                          <input type="text" name="primary_instructor" value="<?php echo $row_Recordset1['primary_instructor']; ?>" size="32">
                                        </div></td>
                                      </tr>

                                      <tr valign="baseline">
                                        <td align="right" valign="middle" nowrap="nowrap" bgcolor="#35415B" class="style50"><div align="left"><span class="style16">EVENT COMMENTS</span></div></td>
                                        <td><div align="left">
                                          <input type="text" name="event_notes" value="<?php echo $row_Recordset1['event_notes']; ?>" size="32">
                                        </div></td>
                                      </tr>
                                      <tr valign="baseline">
                                        <td nowrap align="right">&nbsp;</td>
                                        <td><input type="submit" value="Update record"></td>
                                      </tr>
                                    </table>
                                    <input type="hidden" name="MM_update" value="form1">
                                    <input type="hidden" name="rec_index" value="<?php echo $row_Recordset1['rec_index']; ?>">
                                  </form>
                          <p>&nbsp;</p></td>
                        </tr>
                        <tr>
                              <td height="30" bgcolor="#4F5359" class="style16"><div align="center"><a href="pgc_class_edit_list.php" class="style17">BACK TO ACHIEVEMENTS LIST</a></div></td>
                        </tr>
                  </table></td>
      </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>


