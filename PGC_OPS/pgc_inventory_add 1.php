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
  $insertSQL = sprintf("INSERT INTO pgc_inventory (inv_key, inv_category, inv_desc, inv_units_initial, inv_units_current, unit_cost, inv_vendor, last_restock_date, stock_status, updated_by, update_date, rec_deleted) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['inv_key'], "int"),
                       GetSQLValueString($_POST['inv_category'], "text"),
                       GetSQLValueString($_POST['inv_desc'], "text"),
                       GetSQLValueString($_POST['inv_units_initial'], "int"),
                       GetSQLValueString($_POST['inv_units_current'], "int"),
                       GetSQLValueString($_POST['unit_cost'], "double"),
                       GetSQLValueString($_POST['inv_vendor'], "text"),
                       GetSQLValueString($_POST['last_restock_date'], "date"),
                       GetSQLValueString($_POST['stock_status'], "text"),
                       GetSQLValueString($_POST['updated_by'], "text"),
                       GetSQLValueString($_POST['update_date'], "date"),
                       GetSQLValueString('N', "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

  $insertGoTo = "pgc_inventory_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$currentPage = $_SERVER["PHP_SELF"];
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
} 
?>
<?php 
$maxRows_Inventory = 15;
$pageNum_Inventory = 0;
if (isset($_GET['pageNum_Inventory'])) {
  $pageNum_Inventory = $_GET['pageNum_Inventory'];
}
$startRow_Inventory = $pageNum_Inventory * $maxRows_Inventory;

mysql_select_db($database_PGC, $PGC);
$query_Inventory = "SELECT inv_key, inv_category, inv_desc, inv_units_initial, inv_units_current, unit_cost, inv_vendor, last_restock_date, stock_status, updated_by, update_date, rec_deleted FROM pgc_inventory ORDER BY inv_category ASC";
$query_limit_Inventory = sprintf("%s LIMIT %d, %d", $query_Inventory, $startRow_Inventory, $maxRows_Inventory);
$Inventory = mysql_query($query_limit_Inventory, $PGC) or die(mysql_error());
$row_Inventory = mysql_fetch_assoc($Inventory);

if (isset($_GET['totalRows_Inventory'])) {
  $totalRows_Inventory = $_GET['totalRows_Inventory'];
} else {
  $all_Inventory = mysql_query($query_Inventory);
  $totalRows_Inventory = mysql_num_rows($all_Inventory);
}
$totalPages_Inventory = ceil($totalRows_Inventory/$maxRows_Inventory)-1;

$queryString_Inventory = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Inventory") == false && 
        stristr($param, "totalRows_Inventory") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Inventory = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Inventory = sprintf("&totalRows_Inventory=%d%s", $totalRows_Inventory, $queryString_Inventory);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<script src="../java/javascripts.js" type="text/javascript"></script>
<script src="../java/CalendarPopup.js" type="text/javascript"></script>
<script src="../java/zxml.js" type="text/javascript"></script>
<script src="../java/workingjs.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript" ID="js1">
		var cal = new CalendarPopup();
	 </SCRIPT>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC INVENTORY - ADD NEW ITEM</title>
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
.style57 {font-size: 14px; font-weight: bold; font-style: italic; color: #E2E2E2; }
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
                              <td width="35%"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="52%" class="style54"><div align="center"></div></td>
                                  <td width="5%">&nbsp;</td>
                                  <td width="43%">&nbsp;</td>
                                </tr>
                              </table></td>
                              <td width="30%"><div align="center"><span class="style42">HARDWARE INVENTORY ADD </span></div></td>
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
                          <td height="464" align="center" valign="top" bgcolor="#005B5B"><p>&nbsp;</p>
                            
                                                    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                              <table align="center" cellpadding="4" cellspacing="3" bgcolor="#A2B3B3">
                                
                                <tr valign="baseline">
                                  <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Category </div></td>
                                  <td bgcolor="#48597B"><div align="left">
                                    <input name="inv_category" type="text" value="General" size="20" maxlength="20">
                                  </div></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Description</div></td>
                                  <td bgcolor="#48597B"><div align="left">
                                    <input name="inv_desc" type="text" value="" size="40" maxlength="40">
                                  </div></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Initial Units</div></td>
                                  <td bgcolor="#48597B"><div align="left">
                                    <input name="inv_units_initial" type="text" value="0" size="4" maxlength="4">
                                  </div></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Current Units</div></td>
                                  <td bgcolor="#48597B"><div align="left">
                                    <input name="inv_units_current" type="text" value="0" size="4" maxlength="4">
                                  </div></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Unit Cost</div></td>
                                  <td bgcolor="#48597B"><div align="left">
                                    <input name="unit_cost" type="text" value="0.00" size="8" maxlength="8">
                                  </div></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Vendor</div></td>
                                  <td bgcolor="#48597B"><div align="left">
                                    <textarea name="inv_vendor" cols="25" rows="4"></textarea>
                                  </div></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Last Restock Date</div></td>
                                  <td bgcolor="#48597B"><div align="left">
                                    <input name="last_restock_date" type="text" value="<?php echo date("Y-m-d")?>" size="10" maxlength="10">
                                    <a href="#"
					   name="anchor2" class="style44" id="anchor2" onclick="cal.select(document.forms['form1'].last_restock_date,'anchor2','yyyy-MM-dd'); return false">Select From Calendar</a></div></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap bgcolor="#48597B" class="style17"><div align="left">Stock Status</div></td>
                                  <td bgcolor="#48597B"><div align="left">
                                          <select name="stock_status" size="1" id="stock_status">
                                                  <option value="Good">Good</option>
                                                  <option value="Out">Out</option>
                                                  <option value="Need to Reorder">Need to Reorder</option>
                                                  <option value="Back Ordered">Back Ordered</option>
                                          </select>
                                  </div></td>
                                </tr>
                                
                                <tr valign="baseline">
                                  <td colspan="2" align="right" nowrap bgcolor="#48597B">
                                    <div align="center">
                                      <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="39%"><!--<input name="submit" type="submit" value="Insert record" />-->
										  <input type="image" name="submit" value="Insert Record" src="Graphics/Save.png" style="border:0;" />										  </td>
                                          <td width="19%">&nbsp;</td>
                                          <td width="42%"><a href="pgc_inventory_list.php"><img src="Graphics/Cancel copy.png" alt="Cancel" width="130" height="30" border="0" /></a></td>
                                        </tr>
                                      </table>
                                    </div></td>
                                </tr>
                              </table>
                              <input type="hidden" name="MM_insert" value="form1">
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
mysql_free_result($Inventory);
?>
