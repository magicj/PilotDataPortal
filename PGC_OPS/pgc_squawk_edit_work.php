<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
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
  $updateSQL = sprintf("UPDATE pgc_squawk_work SET  work_date=%s, worker=%s, work_hours=%s, work_desc=%s, rec_deleted=%s, entered_by=%s, entered_date=%s WHERE sq_work_key=%s",
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
.style56 {font-size: 12px}
.style57 {color: #CCCCCC; font-style: italic; font-weight: bold; font-size: 12px; }
.style44 {color: #FF0000;
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
                              <td width="20" bgcolor="#35415B"><div align="center" class="style16"><em><strong>SQ</strong></em></div></td>
                              <td width="100" bgcolor="#35415B"><div align="center" class="style16"><em><strong>MEMBER</strong></em></div></td>
                              <td width="80" bgcolor="#35415B"><div align="center" class="style16"><em><strong>OCCURRED</strong></em></div></td>
                              <td bgcolor="#35415B"><div align="center" class="style16"><em><strong>EQUIPMENT</strong></em></div></td>
                              <td bgcolor="#35415B"><div align="center" class="style16"><em><strong>PROBLEM</strong></em></div></td>
                              <td width="50" bgcolor="#35415B"><div align="center" class="style16"><em><strong>STATUS</strong></em></div></td>
                            </tr>
                            <?php do { ?>
                            <tr>
                              <td bgcolor="#48597B"><div align="center"><span class="style49"><?php echo $row_Squawks['sq_key']; ?></span></div></td>
                              <td bgcolor="#48597B"><span class="style49"><?php echo $row_Squawks['id_name']; ?></span></td>
                              <td bgcolor="#48597B"><div align="center"><span class="style49"><?php echo $row_Squawks['sq_date']; ?></span></div></td>
                              <td width="130" bgcolor="#48597B"><div align="left"><span class="style49"><?php echo $row_Squawks['sq_equipment']; ?></span></div></td>
                              <td bgcolor="#48597B"><div align="left"><span class="style49"><?php echo $row_Squawks['sq_issue']; ?></span></div></td>
                              <td bgcolor="#48597B"><div align="center"><span class="style49"><?php echo $row_Squawks['sq_status']; ?></span></div></td>
                            </tr>
                            <?php } while ($row_Squawks = mysql_fetch_assoc($Squawks)); ?>
                          </table>
                            <p>&nbsp;</p>
                            <form method="post" name="form2" action="<?php echo $editFormAction; ?>">
                              <table align="center" cellpadding="4" cellspacing="3" bgcolor="#A2B3B3">
                              <tr valign="baseline">
                                <td align="right" nowrap bgcolor="#35415B" class="style17"><div align="left" class="style56">WORK KEY</div></td>
                                <td bgcolor="#48597B"><div align="left"><?php echo $row_Squawk_work['sq_work_key']; ?></div></td>
                              </tr>
                              
                              <tr valign="baseline">
                                <td align="right" valign="middle" nowrap="nowrap" bgcolor="#35415B" class="style17"><div align="left" class="style57">DATE</div></td>
                                <td bgcolor="#48597B"><div align="left">
                                  <input name="work_date" type="text" value="<?php echo $row_Squawk_work['work_date']; ?>" size="10" maxlength="10">
                                  <a href="#"
					   name="anchor2" class="style44" id="anchor2" onclick="cal.select(document.forms['form2'].work_date,'anchor2','yyyy-MM-dd'); return false">Select From Calendar</a></div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" valign="middle" nowrap="nowrap" bgcolor="#35415B" class="style17"><div align="left" class="style57">WORKER(S)</div></td>
                                <td bgcolor="#48597B"><div align="left">
                                  <textarea name="worker" cols="30" rows="2"><?php echo $row_Squawk_work['worker']; ?></textarea>
                                </div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" valign="middle" nowrap="nowrap" bgcolor="#35415B" class="style17"><div align="left" class="style56"><span class="style55">WORK HOURS</span> </div></td>
                                <td bgcolor="#48597B"><div align="left">
                                  <input name="work_hours" type="text" value="<?php echo $row_Squawk_work['work_hours']; ?>" size="6" maxlength="6">
                                </div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" valign="middle" nowrap="nowrap" bgcolor="#35415B" class="style17"><div align="left" class="style56"><span class="style55">WORK DESC</span></div></td>
                                <td bgcolor="#48597B"><div align="left">
                                  <textarea name="work_desc" cols="50" rows="8"><?php echo $row_Squawk_work['work_desc']; ?></textarea>
                                </div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" valign="middle" nowrap="nowrap" bgcolor="#35415B" class="style17"><div align="left" class="style57">DELETE ?</div></td>
                                <td bgcolor="#48597B"><div align="left">
                                        <select name="rec_deleted">
                                          <option value="N" selected="selected" <?php if (!(strcmp("N", $row_Squawk_work['rec_deleted']))) {echo "selected=\"selected\"";} ?>>N</option>
                                          <option value="Y" <?php if (!(strcmp("Y", $row_Squawk_work['rec_deleted']))) {echo "selected=\"selected\"";} ?>>Y</option>
                                  </select>
                                  </div></td>
                              </tr>
                              
                              <tr valign="baseline">
                                <td colspan="2" align="right" nowrap bgcolor="#35415B">
                                  <div align="center">
                                    <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="34%"><!--<input name="submit" type="submit" value="Save Changes" />-->
										<input type="image" name="submit" value="Save Changes" src="Graphics/Save.png" style="border:0;" />
										</td>
                                        <td width="24%">&nbsp;</td>
                                        <td width="42%"><div align="center"><a href="pgc_squawk_work.php?sq_id=<?php echo $_SESSION['current_sq'] ?>"><img src="Graphics/Cancel copy.png" alt="Cancel" width="130" height="30" border="0" /></a></div></td>
                                      </tr>
                                    </table>
                                  </div></td>
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
