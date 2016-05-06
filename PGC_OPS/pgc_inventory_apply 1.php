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

/* INSERT START   */
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pgc_inventory_used ( inv_key, sq_key, inv_category, inv_desc, inv_units_initial, inv_units_current, unit_cost, inv_vendor, last_restock_date, stock_status, inv_used_units, inv_used_date, updated_by, update_date, rec_deleted) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_GET['inv_key'], "int"),
                       GetSQLValueString($_SESSION['current_sq'], "int"),
                       GetSQLValueString($_SESSION['apply_inv_category'], "text"),
                       GetSQLValueString($_SESSION['apply_inv_desc'], "text"),
                       GetSQLValueString($_SESSION['apply_inv_units_initial'], "int"),
                       GetSQLValueString($_SESSION['apply_inv_units_current'], "int"),
                       GetSQLValueString($_SESSION['apply_unit_cost'], "double"),
                       GetSQLValueString($_SESSION['apply_inv_vendor'], "text"),
                       GetSQLValueString($_SESSION['apply_last_restock_date'], "date"),
                       GetSQLValueString($_SESSION['apply_stock_status'], "text"),
					   
                       GetSQLValueString($_POST['inv_used_units'], "int"),
                       GetSQLValueString($_POST['inv_used_date'], "date"),
					   
                       GetSQLValueString($_POST['updated_by'], "text"),
                       GetSQLValueString($_POST['update_date'], "date"),
                       GetSQLValueString($_POST['rec_deleted'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
  
  /*   Update Inventory */
  $NetUnits = $_SESSION['apply_inv_units_current'] - $_POST['inv_used_units'];
  $updateSQL = sprintf("UPDATE pgc_inventory SET inv_units_current=%s WHERE inv_key=%s",
                       GetSQLValueString($NetUnits, "int"),
                       GetSQLValueString($_GET['inv_key'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $insertGoTo = "pgc_squawk_work.php?sq_id=".$_SESSION['current_sq'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
/* INSERT END */

$colname_Recordset1 = "-1";
if (isset($_GET['inv_key'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['inv_key'] : addslashes($_GET['inv_key']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT inv_key, inv_category, inv_desc, inv_units_initial, inv_units_current, unit_cost, inv_vendor, last_restock_date, stock_status, updated_by, update_date, rec_deleted FROM pgc_inventory WHERE inv_key = %s", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Squawks = "-1";
if (isset($_SESSION['current_sq'])) {
  $colname_Squawks = (get_magic_quotes_gpc()) ? $_SESSION['current_sq'] : addslashes($_SESSION['current_sq']);
}
mysql_select_db($database_PGC, $PGC);
$query_Squawks = sprintf("SELECT * FROM pgc_squawk WHERE sq_key = %s", $colname_Squawks);
$Squawks = mysql_query($query_Squawks, $PGC) or die(mysql_error());
$row_Squawks = mysql_fetch_assoc($Squawks);
$totalRows_Squawks = mysql_num_rows($Squawks);
 
$_SESSION[apply_inv_desc] = $row_Recordset1['inv_desc'];
$_SESSION[apply_inv_category] = $row_Recordset1['inv_category'];
$_SESSION[apply_inv_units_initial] = $row_Recordset1['inv_units_initial'];
$_SESSION[apply_inv_units_current] = $row_Recordset1['inv_units_current'];
$_SESSION[apply_unit_cost] = $row_Recordset1['unit_cost'];
$_SESSION[apply_inv_vendor] = $row_Recordset1['inv_vendor'];
$_SESSION[apply_last_restock_date] = $row_Recordset1['last_restock_date'];
$_SESSION[apply_stock_status] = $row_Recordset1['stock_status'];


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
<title>PGC INVENTORY - ADD TO SQUAWK</title>
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
	color: #FFFFFF;
	font-weight: bold;
}
.style49 {color: #FFFFFF}
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
                              <td width="30%"><div align="center"><span class="style42"> INVENTORY - ADD TO SQUAWK</span></div></td>
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
                              <td width="100" bgcolor="#35415B"><em><strong>SQUAWK ID </strong></em></td>
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
                            
                                                    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                                                      <table align="center" cellpadding="4" cellspacing="3" bgcolor="#A2B3B3">
                                                        <tr valign="baseline">
                                                          <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Key</div></td>
                                                          <td bgcolor="#48597B"><div align="left" class="style55"><?php echo $row_Recordset1['inv_key']; ?></div></td>
                                                        </tr>
                                                        <tr valign="baseline">
                                                          <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Category</div></td>
                                                          <td bgcolor="#48597B"><div align="left" class="style55">
                                                          <?php echo $row_Recordset1['inv_category']; ?>
                                                          </div></td>
                                                        </tr>
                                                        <tr valign="baseline">
                                                          <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Desription</div></td>
                                                          <td bgcolor="#48597B"><div align="left" class="style55">
                                                          <?php echo $row_Recordset1['inv_desc']; ?>
                                                          </div></td>
                                                        </tr>
                                                        <tr valign="baseline">
                                                          <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Initial Units </div></td>
                                                          <td bgcolor="#48597B"><div align="left" class="style55">
                                                          <?php echo $row_Recordset1['inv_units_initial']; ?>
                                                          </div></td>
                                                        </tr>
                                                        <tr valign="baseline">
                                                          <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Current Units </div></td>
                                                          <td bgcolor="#48597B"><div align="left" class="style55">
                                                          <?php echo $row_Recordset1['inv_units_current']; ?>
                                                          </div></td>
                                                        </tr>
                                                        <tr valign="baseline">
                                                          <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Unit Cost</div></td>
                                                          <td bgcolor="#48597B"><div align="left" class="style55">
                                                           <?php echo $row_Recordset1['unit_cost']; ?> 
                                                          </div></td>
                                                        </tr>
                                                        <tr valign="baseline">
                                                          <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Vendor</div></td>
                                                          <td bgcolor="#48597B"><div align="left" class="style55">
                                                           <?php echo $row_Recordset1['inv_vendor']; ?> 
                                                          </div></td>
                                                        </tr>
                                                        <tr valign="baseline">
                                                          <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Last Restock Date</div></td>
                                                          <td bgcolor="#48597B"><div align="left" class="style55">
                                                           <?php echo $row_Recordset1['last_restock_date']; ?> 
                                                          </div></td>
                                                        </tr>
                                                        <tr valign="baseline">
                                                          <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Stock Status</div></td>
                                                          <td bgcolor="#48597B"><div align="left" class="style55">
                                                           <?php echo $row_Recordset1['stock_status']; ?> 
                                                          </div></td>
                                                        </tr>
                                                        <tr valign="baseline">
                                                          <td align="right" nowrap="nowrap" bgcolor="#48597B" class="style17"><div align="left">Units Used</div></td>
                                                          <td bgcolor="#48597B"><div align="left">
                                                              <input name="inv_used_units" type="text" value="1" size="4" maxlength="4" />
                                                          </div></td>
                                                        </tr>
                                                        <tr valign="baseline">
                                                          <td align="right" nowrap="nowrap" bgcolor="#48597B" class="style17"><div align="left">Date Used</div></td>
                                                          <td bgcolor="#48597B"><div align="left">
                                                              <input name="inv_used_date" type="text" value="<?php echo date("Y-m-d")?>" size="10" maxlength="10" />
                                                          <a href="#"
					   name="anchor2" class="style44" id="anchor2" onclick="cal.select(document.forms['form1'].inv_used_date,'anchor2','yyyy-MM-dd'); return false">Select From Calendar</a></div></td>
                                                        </tr>
                                                        

                                                        <tr valign="baseline">
                                                          <td colspan="2" align="right" nowrap bgcolor="#48597B" class="style17">
                                                            <div align="left">
                                                              <table width="97%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                  <td width="46%"><div align="center">
                                                                    <!--<input name="submit" type="submit" value="ADD TO SQUAWK" />-->
																	<input type="image" name="submit" value="ADD TO SQUAWK" src="Graphics/Save.png" style="border:0;" />
                                                                  </div></td>
                                                                  <td width="11%"><a href="pgc_squawk_work.php?sq_id=<?php echo $_SESSION['current_sq'] ?>"></a></td>
                                                                  <td width="43%"><div align="center"><a href="pgc_squawk_work.php?sq_id=<?php echo $_SESSION['current_sq'] ?>"><img src="Graphics/Cancel copy.png" alt="Cancel" width="130" height="30" border="0" /></a></div></td>
                                                                </tr>
                                                              </table>
                                                            </div>
                                                              <div align="left"></div></td></tr>
                                                      </table>
                                                      <input type="hidden" name="MM_update" value="form1">
                                                      <input type="hidden" name="inv_key" value="<?php echo $row_Recordset1['inv_key']; ?>">
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
mysql_free_result($Recordset1);

mysql_free_result($Squawks);
?>