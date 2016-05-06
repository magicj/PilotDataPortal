<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
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
  $updateSQL = sprintf("UPDATE pgc_inventory_used SET inv_used_date=%s, inv_used_units=%s, updated_by=%s, update_date=%s, rec_deleted=%s WHERE inv_used_key=%s",
                    
                       GetSQLValueString($_POST['inv_used_date'], "date"),
                       GetSQLValueString($_POST['inv_used_units'], "int"),
					   
                       
					   
                       GetSQLValueString($_POST['updated_by'], "text"),
                       GetSQLValueString($_POST['update_date'], "date"),
                       GetSQLValueString($_POST['rec_deleted'], "text"),
                       GetSQLValueString($_POST['inv_used_key'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "pgc_squawk_work.php?sq_id=".$_SESSION['current_sq'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['inv_used_key'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['inv_used_key'] : addslashes($_GET['inv_used_key']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_inventory_used WHERE inv_used_key = %s", $colname_Recordset1);
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
<title>PGC EDIT Squark inventory USED</title>
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
.style44 {color: #FF0000;
	font-weight: bold;
}
.style56 {color: #FFFFFF; font-weight: bold; }
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
                              <td width="30%"><div align="center"><span class="style42"> EDIT SQUAWK INVENTORY USED</span></div></td>
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
                          <td height="464" align="center" valign="top" bgcolor="#005B5B"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                            <p>&nbsp;</p>
                            <table align="center" cellpadding="4" cellspacing="3" bgcolor="#A2B3B3">
                              <tr valign="baseline">
                                <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Inv_used_key:</div></td>
                                <td bgcolor="#48597B"><div align="left"><?php echo $row_Recordset1['inv_used_key']; ?></div></td>
                              </tr>

                              <tr valign="baseline">
                                <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Inv_used_date:</div></td>
                                <td bgcolor="#48597B"><div align="left">
                                  <input name="inv_used_date" type="text" value="<?php echo $row_Recordset1['inv_used_date']; ?>" size="10" maxlength="10">
                                  <a href="#"
					   name="anchor2" class="style44" id="anchor2" onclick="cal.select(document.forms['form1'].inv_used_date,'anchor2','yyyy-MM-dd'); return false">Select From Calendar</a></div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Inv_used_units:</div></td>
                                <td bgcolor="#48597B"><div align="left">
                                  <input name="inv_used_units" type="text" value="<?php echo $row_Recordset1['inv_used_units']; ?>" size="4" maxlength="4">
                                </div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap="nowrap" bgcolor="#48597B" class="style17"><div align="left">Category</div></td>
                                <td bgcolor="#48597B"><div align="left" class="style56">
                                  <?php echo $row_Recordset1['inv_category']; ?>
                                </div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap="nowrap" bgcolor="#48597B" class="style17"><div align="left">Desription</div></td>
                                <td bgcolor="#48597B"><div align="left" class="style56">
                                  <?php echo $row_Recordset1['inv_desc']; ?>
                                </div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap="nowrap" bgcolor="#48597B" class="style17"><div align="left">Initial Units </div></td>
                                <td bgcolor="#48597B"><div align="left" class="style56">
                                 <?php echo $row_Recordset1['inv_units_initial']; ?>
                                </div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap="nowrap" bgcolor="#48597B" class="style17"><div align="left">Current Units </div></td>
                                <td bgcolor="#48597B"><div align="left" class="style56">
                                 <?php echo $row_Recordset1['inv_units_current']; ?>
                                </div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap="nowrap" bgcolor="#48597B" class="style17"><div align="left">Unit Cost</div></td>
                                <td bgcolor="#48597B"><div align="left" class="style56">
                                  <?php echo $row_Recordset1['unit_cost']; ?>
                                </div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap="nowrap" bgcolor="#48597B" class="style17"><div align="left">Vendor</div></td>
                                <td bgcolor="#48597B"><div align="left" class="style56">
                                 <?php echo $row_Recordset1['inv_vendor']; ?>
                                </div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap="nowrap" bgcolor="#48597B" class="style17"><div align="left">Last Restock Date</div></td>
                                <td bgcolor="#48597B"><div align="left" class="style56">
                                  <?php echo $row_Recordset1['last_restock_date']; ?>
                                </div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap="nowrap" bgcolor="#48597B" class="style17"><div align="left">Stock Status</div></td>
                                <td bgcolor="#48597B"><div align="left" class="style56">
                                 <?php echo $row_Recordset1['stock_status']; ?>
                                </div></td>
                              </tr>

                              <tr valign="baseline">
                                <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Delete Record?</div></td>
                                <td bgcolor="#48597B"><div align="left">
                               
                                  <select name="rec_deleted">
                                          <option value="N" <?php if (!(strcmp("N", $row_Recordset1['rec_deleted']))) {echo "selected=\"selected\"";} ?>>N</option>
                                          <option value="Y" <?php if (!(strcmp("Y", $row_Recordset1['rec_deleted']))) {echo "selected=\"selected\"";} ?>>Y</option>
                                  </select>
</div></td>
                              </tr>
                              <tr valign="baseline">
                                <td colspan="2" align="right" nowrap bgcolor="#48597B"><div align="left">
                                  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="41%"><div align="center">
                                        <!--<input name="submit" type="submit" value="Update record" />-->
										<input type="image" name="submit" value="Update record" src="Save.png" style="border:0;" />
                                      </div></td>
                                      <td width="10%">&nbsp;</td>
                                      <td width="49%"><div align="center"><a href="pgc_squawk_work.php?sq_id=<?php echo $_SESSION['current_sq'] ?>"><img src="Graphics/Cancel copy.png" alt="Cancel" width="130" height="30" border="0" /></a></div></td>
                                    </tr>
                                  </table>
                                </div></td>
                              </tr>
                            </table>
                            <input type="hidden" name="MM_update" value="form1">
                            <input type="hidden" name="inv_used_key" value="<?php echo $row_Recordset1['inv_used_key']; ?>">
                          </form>
                          <p>&nbsp;</p>
</td>
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
mysql_free_result($Recordset1);
?>