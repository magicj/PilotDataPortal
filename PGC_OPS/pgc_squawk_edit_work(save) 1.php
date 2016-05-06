<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
} 
if (isset($_GET['sq_id'])) {
  $_SESSION['current_sq'] = $_GET['sq_id'];
}
$colname_Squawks = "-1";
if (isset($_SESSION['current_sq'])) {
  $colname_Squawks = (get_magic_quotes_gpc()) ? $_SESSION['current_sq'] : addslashes($_SESSION['current_sq']);
}
mysql_select_db($database_PGC, $PGC);
$query_Squawks = sprintf("SELECT * FROM pgc_squawk WHERE sq_key = %s", $colname_Squawks);
$Squawks = mysql_query($query_Squawks, $PGC) or die(mysql_error());
$row_Squawks = mysql_fetch_assoc($Squawks);
$totalRows_Squawks = mysql_num_rows($Squawks);

$colname_Squawk_work = "-1";
if (isset($_GET['sq_work_id'])) {
  $colname_Squawk_work = (get_magic_quotes_gpc()) ? $_GET['sq_work_id'] : addslashes($_GET['sq_work_id']);
}
mysql_select_db($database_PGC, $PGC);
$query_Squawk_work = sprintf("SELECT * FROM pgc_squawk_work WHERE sq_work_key = %s", $colname_Squawk_work);
$Squawk_work = mysql_query($query_Squawk_work, $PGC) or die(mysql_error());
$row_Squawk_work = mysql_fetch_assoc($Squawk_work);
$totalRows_Squawk_work = mysql_num_rows($Squawk_work);
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
  $updateSQL = sprintf("UPDATE pgc_squawk_work SET sq_key=%s, work_date=%s, worker=%s, work_hours=%s, work_desc=%s, rec_deleted=%s, entered_by=%s, entered_date=%s WHERE sq_work_key=%s",
                       GetSQLValueString($_POST['sq_key'], "int"),
                       GetSQLValueString($_POST['work_date'], "date"),
                       GetSQLValueString($_POST['worker'], "text"),
                       GetSQLValueString($_POST['work_hours'], "double"),
                       GetSQLValueString($_POST['work_desc'], "text"),
                       GetSQLValueString($_POST['rec_deleted'], "text"),
                       GetSQLValueString($_POST['entered_by'], "text"),
                       GetSQLValueString($_POST['entered_date'], "date"),
                       GetSQLValueString($_POST['sq_work_key'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "pgc_squawk_work.php?sq_id=".$_SESSION['current_sq'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
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
<title>PGC EQUIPMENT SQUAWK VIEW</title>
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
	color: #999999;
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
.style42 {
	font-size: 16px;
	font-weight: bold;
	font-style: italic;
	color: #E2E2E2;
}
.style54 {
	font-size: 14px;
	font-weight: bold;
	color: #FF6600;
}
.style55 {
	color: #CCCCCC;
	font-style: italic;
	font-weight: bold;
}
.style49 {color: #FFFFFF}
.style44 {	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<table width="1200" height="95%" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
      <tr>
            <td align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="521" bgcolor="#666666"><table width="95%" height="95%" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#003648">
                        <tr>
                          <td width="1562" height="26" valign="middle" bgcolor="#005B5B"><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="35%">&nbsp;</td>
                              <td width="30%"><div align="center"><span class="style42">SQUAWK EDIT WORK or STATUS </span></div></td>
                              <td width="35%"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="52%" class="style54"><div align="center"></div></td>
                                  <td width="5%">&nbsp;</td>
                                  <td width="43%">&nbsp;</td>
                                </tr>
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="464" align="center" valign="top" bgcolor="#005B5B"><table width="95%" cellpadding="4" cellspacing="3" bgcolor="#A2B3B3">
                            <tr>
                              <td width="20" bgcolor="#35415B"><div align="center" class="style16"><em><strong>KEY</strong></em></div></td>
                              <td width="120" bgcolor="#35415B"><div align="center" class="style16"><em><strong>ENTERED</strong></em></div></td>
                              <td width="100" bgcolor="#35415B"><div align="center" class="style16"><em><strong>MEMBER</strong></em></div></td>
                              <td width="80" bgcolor="#35415B"><div align="center" class="style16"><em><strong>OCCURED</strong></em></div></td>
                              <td bgcolor="#35415B"><div align="center" class="style16"><em><strong>EQUIPMENT</strong></em></div></td>
                              <td bgcolor="#35415B"><div align="center" class="style16"><em><strong>PROBLEM</strong></em></div></td>
                              <td width="50" bgcolor="#35415B"><div align="center" class="style16"><em><strong>STATUS</strong></em></div></td>
                            </tr>
                            <?php do { ?>
                            <tr>
                              <td bgcolor="#48597B"><div align="center"><span class="style49"><?php echo $row_Squawks['sq_key']; ?></span></div></td>
                              <td bgcolor="#48597B"><span class="style49"><?php echo $row_Squawks['date_entered']; ?></span></td>
                              <td bgcolor="#48597B"><span class="style49"><?php echo $row_Squawks['id_name']; ?></span></td>
                              <td bgcolor="#48597B"><div align="center"><span class="style49"><?php echo $row_Squawks['sq_date']; ?></span></div></td>
                              <td width="130" bgcolor="#48597B"><div align="left"><span class="style49"><?php echo $row_Squawks['sq_equipment']; ?></span></div></td>
                              <td bgcolor="#48597B"><div align="left"><span class="style49"><?php echo $row_Squawks['sq_issue']; ?></span></div></td>
                              <td bgcolor="#48597B"><div align="center"><span class="style49"><?php echo $row_Squawks['sq_status']; ?></span></div></td>
                            </tr>
                            <?php } while ($row_Squawks = mysql_fetch_assoc($Squawks)); ?>
                          </table>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                            </form>
                          <p>&nbsp;</p>
                          <form method="post" name="form2" action="<?php echo $editFormAction; ?>">
                            <table align="center">
                              <tr valign="baseline">
                                <td nowrap align="right">Sq_work_key:</td>
                                <td><?php echo $row_Squawk_work['sq_work_key']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Sq_key:</td>
                                <td><input type="text" name="sq_key" value="<?php echo $row_Squawk_work['sq_key']; ?>" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Work_date:</td>
                                <td><input type="text" name="work_date" value="<?php echo $row_Squawk_work['work_date']; ?>" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Worker:</td>
                                <td><input type="text" name="worker" value="<?php echo $row_Squawk_work['worker']; ?>" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Work_hours:</td>
                                <td><input type="text" name="work_hours" value="<?php echo $row_Squawk_work['work_hours']; ?>" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Work_desc:</td>
                                <td><input type="text" name="work_desc" value="<?php echo $row_Squawk_work['work_desc']; ?>" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Rec_deleted:</td>
                                <td><input type="text" name="rec_deleted" value="<?php echo $row_Squawk_work['rec_deleted']; ?>" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Entered_by:</td>
                                <td><input type="text" name="entered_by" value="<?php echo $row_Squawk_work['entered_by']; ?>" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Entered_date:</td>
                                <td><input type="text" name="entered_date" value="<?php echo $row_Squawk_work['entered_date']; ?>" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Update record"></td>
                              </tr>
                            </table>
                            <input type="hidden" name="MM_update" value="form2">
                            <input type="hidden" name="sq_work_key" value="<?php echo $row_Squawk_work['sq_work_key']; ?>">
                          </form>
                          <p>&nbsp;</p></td>
                        </tr>
                        <tr>
                          <td height="24" bgcolor="#005B5B" class="style16"><div align="center"><a href="../07_members_only_pw.php" class="style17">BACK TO MEMBER'S PAGE </a></div></td>
                        </tr>
        </table></td>
      </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Squawks);

mysql_free_result($Squawk_work);
?>
