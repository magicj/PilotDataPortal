<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
$currentPage = $_SERVER["PHP_SELF"];
?>
<?php 
$maxRows_Inventory = 30;
$pageNum_Inventory = 0;
if (isset($_GET['pageNum_Inventory'])) {
  $pageNum_Inventory = $_GET['pageNum_Inventory'];
}
$startRow_Inventory = $pageNum_Inventory * $maxRows_Inventory;

mysql_select_db($database_PGC, $PGC);
$query_Inventory = "SELECT * FROM pgc_inventory_used ORDER BY inv_category ASC";
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
 error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC INVENTORY LIST</title>
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
.style55 {color: #FFFFFF}
.style57 {font-size: 14px; font-weight: bold; font-style: italic; color: #E2E2E2; }
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
                                  <td width="52%" class="style54"><div align="center"><span class="style57"><a href="pgc_maintenance_menu.php">TEST MENU </a></span></div></td>
                                  <td width="5%">&nbsp;</td>
                                  <td width="43%">&nbsp;</td>
                                </tr>
                              </table></td>
                              <td width="30%"><div align="center"><span class="style42">HARDWARE INVENTORY USED </span></div></td>
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
                            <table cellpadding="4" cellspacing="3" bgcolor="#A2B3B3">
                              <tr>
                                <td bgcolor="#35415B" class="style16"><div align="center"><strong><em>SQUAWK</em></strong></div></td>
                                <td bgcolor="#35415B" class="style16"><div align="center"><strong><em>STOCK</em></strong></div></td>
                                <td bgcolor="#35415B" class="style16"><div align="center"><strong><em>CATEGORY</em></strong></div></td>
                                <td bgcolor="#35415B" class="style16"><div align="center"><strong><em>DESCRIPTION</em></strong></div></td>
                                <td bgcolor="#35415B" class="style16"><div align="center"><strong><em>INITIAL UNITS</em></strong> </div></td>
                                <td bgcolor="#35415B" class="style16"><div align="center"><strong><em>CURRENT</em></strong></div></td>
                                <td bgcolor="#35415B" class="style16"><div align="center"><strong><em>UNIT COST </em></strong></div></td>
                                <td bgcolor="#35415B" class="style16"><div align="center"><strong><em>VENDOR</em></strong></div></td>
                                <td bgcolor="#35415B" class="style16"><div align="center"><strong><em>LAST RESTOCK </em></strong></div></td>
                                <td bgcolor="#35415B" class="style16"><div align="center"><strong><em>STATUS</em></strong></div></td>
                              </tr>
                              <?php do { ?>
                                <tr>
                                  <td bgcolor="#48597B"><span class="style55"><a href="pgc_squawk_work.php?sq_id=<?php echo $row_Inventory['sq_key']?>"><?php echo $row_Inventory['sq_key']; ?></a></span></td>
                                  <td bgcolor="#48597B"><a href="pgc_inventory_edit.php?inv_key=<?php echo $row_Inventory['inv_key']?>"><?php echo $row_Inventory['inv_key']; ?></a></td>
                                  <td bgcolor="#48597B"><div align="left"><span class="style55"><?php echo $row_Inventory['inv_category']; ?></span></div></td>
                                  <td bgcolor="#48597B"><div align="left"><span class="style55"><?php echo $row_Inventory['inv_desc']; ?></span></div></td>
                                  <td bgcolor="#48597B"><span class="style55"><?php echo $row_Inventory['inv_units_initial']; ?></span></td>
                                  <td bgcolor="#48597B"><span class="style55"><?php echo $row_Inventory['inv_units_current']; ?></span></td>
                                  <td bgcolor="#48597B"><span class="style55"><?php echo $row_Inventory['unit_cost']; ?></span></td>
                                  <td bgcolor="#48597B"><span class="style55"><?php echo $row_Inventory['inv_vendor']; ?></span></td>
                                  <td bgcolor="#48597B"><span class="style55"><?php echo $row_Inventory['last_restock_date']; ?></span></td>
                                  <td bgcolor="#48597B"><span class="style55"><?php echo $row_Inventory['stock_status']; ?></span></td>
                                </tr>
                                <?php } while ($row_Inventory = mysql_fetch_assoc($Inventory)); ?>
                            </table>
                            <table border="0" width="50%" align="center">
                              <tr>
                                <td width="23%" align="center"><?php if ($pageNum_Inventory > 0) { // Show if not first page ?>
                                      <a href="<?php printf("%s?pageNum_Inventory=%d%s", $currentPage, 0, $queryString_Inventory); ?>">First</a>
                                      <?php } // Show if not first page ?>
                                </td>
                                <td width="31%" align="center"><?php if ($pageNum_Inventory > 0) { // Show if not first page ?>
                                      <a href="<?php printf("%s?pageNum_Inventory=%d%s", $currentPage, max(0, $pageNum_Inventory - 1), $queryString_Inventory); ?>">Previous</a>
                                      <?php } // Show if not first page ?>
                                </td>
                                <td width="23%" align="center"><?php if ($pageNum_Inventory < $totalPages_Inventory) { // Show if not last page ?>
                                      <a href="<?php printf("%s?pageNum_Inventory=%d%s", $currentPage, min($totalPages_Inventory, $pageNum_Inventory + 1), $queryString_Inventory); ?>">Next</a>
                                      <?php } // Show if not last page ?>
                                </td>
                                <td width="23%" align="center"><?php if ($pageNum_Inventory < $totalPages_Inventory) { // Show if not last page ?>
                                      <a href="<?php printf("%s?pageNum_Inventory=%d%s", $currentPage, $totalPages_Inventory, $queryString_Inventory); ?>">Last</a>
                                      <?php } // Show if not last page ?>
                                </td>
                              </tr>
                            </table></td>
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
