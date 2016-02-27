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
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Squawks = 10;
$pageNum_Squawks = 0;
if (isset($_GET['pageNum_Squawks'])) {
  $pageNum_Squawks = $_GET['pageNum_Squawks'];
}
$startRow_Squawks = $pageNum_Squawks * $maxRows_Squawks;

$colname_Squawks = "-1";
if (isset($_GET['sq_id'])) {
  $colname_Squawks = (get_magic_quotes_gpc()) ? $_GET['sq_id'] : addslashes($_GET['sq_id']);
}
mysql_select_db($database_PGC, $PGC);
$query_Squawks = sprintf("SELECT * FROM pgc_squawk WHERE sq_key = %s", $colname_Squawks);
$query_limit_Squawks = sprintf("%s LIMIT %d, %d", $query_Squawks, $startRow_Squawks, $maxRows_Squawks);
$Squawks = mysql_query($query_limit_Squawks, $PGC) or die(mysql_error());
$row_Squawks = mysql_fetch_assoc($Squawks);

if (isset($_GET['totalRows_Squawks'])) {
  $totalRows_Squawks = $_GET['totalRows_Squawks'];
} else {
  $all_Squawks = mysql_query($query_Squawks);
  $totalRows_Squawks = mysql_num_rows($all_Squawks);
}
$totalPages_Squawks = ceil($totalRows_Squawks/$maxRows_Squawks)-1;

$maxRows_work = 100;
$pageNum_work = 0;
if (isset($_GET['pageNum_work'])) {
  $pageNum_work = $_GET['pageNum_work'];
}
$startRow_work = $pageNum_work * $maxRows_work;


/* Purge Deletions */
mysql_select_db($database_PGC, $PGC);
$delete_query = "DELETE FROM pgc_squawk_work WHERE rec_deleted = 'Y'";
$rs_deletions = mysql_query($delete_query, $PGC) or die(mysql_error());


mysql_select_db($database_PGC, $PGC);
$query_work = "SELECT * FROM pgc_squawk_work WHERE sq_key = $colname_Squawks ORDER BY work_date DESC";
$query_limit_work = sprintf("%s LIMIT %d, %d", $query_work, $startRow_work, $maxRows_work);
$work = mysql_query($query_limit_work, $PGC) or die(mysql_error());
$row_work = mysql_fetch_assoc($work);

if (isset($_GET['totalRows_work'])) {
  $totalRows_work = $_GET['totalRows_work'];
} else {
  $all_work = mysql_query($query_work);
  $totalRows_work = mysql_num_rows($all_work);
}
$totalPages_work = ceil($totalRows_work/$maxRows_work)-1;

$maxRows_Inventory = 100;
$pageNum_Inventory = 0;
if (isset($_GET['pageNum_Inventory'])) {
  $pageNum_Inventory = $_GET['pageNum_Inventory'];
}
$startRow_Inventory = $pageNum_Inventory * $maxRows_Inventory;


/* Purge Deletions */
mysql_select_db($database_PGC, $PGC);
$delete_query = "DELETE FROM pgc_inventory_used WHERE rec_deleted = 'Y'";
$rs_deletions = mysql_query($delete_query, $PGC) or die(mysql_error());

$colname_Inventory = "-1";
if (isset($_SESSION['current_sq'])) {
  $colname_Inventory = (get_magic_quotes_gpc()) ? $_SESSION['current_sq'] : addslashes($_SESSION['current_sq']);
}
mysql_select_db($database_PGC, $PGC);
$query_Inventory = sprintf("SELECT * FROM pgc_inventory_used WHERE sq_key = %s", $colname_Inventory);
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

$queryString_Squawks = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Squawks") == false && 
        stristr($param, "totalRows_Squawks") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Squawks = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Squawks = sprintf("&totalRows_Squawks=%d%s", $totalRows_Squawks, $queryString_Squawks);

  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
.style49 {color: #FFFFFF}
.style53 {color: #CCCCCC; font-weight: bold; font-style: italic; }
.style54 {
	font-size: 14px;
	font-weight: bold;
	color: #FF6600;
}
.style57 {
	font-size: 12px;
	color: #999999;
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
                                  <td width="43%" class="style54"><div align="right"><a href="pgc_maintenance_menu.php"><img src="Graphics/TestMenu copy.png" alt="TestMenu" width="130" height="30" border="0" /></a></div></td>
                                  <td width="6%">&nbsp;</td>
                                  <td width="51%"><a href="pgc_squawk_view.php"><img src="Graphics/SquawkList copy.png" alt="SquawkList" width="130" height="30" border="0" /></a></td>
                                </tr>
                              </table></td>
                              <td width="30%"><div align="center"><span class="style42">SQUAWK WORK  DETAIL </span></div></td>
                              <td width="35%"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="52%" class="style54"><div align="right"><a href="pgc_squawk_add_work.php?sq_id=<?php echo $_SESSION['current_sq']; ?>"><img src="Graphics/AddWorkButton copy.png" alt="Add Work" width="130" height="30" border="0" /></a></div></td>
                                  <td width="5%">&nbsp;</td>
                                  <td width="43%"><div align="left"><a href="pgc_inventory_select_list.php?sq_id=<?php echo $_SESSION['current_sq']; ?>"><img src="Graphics/AddStockButton copy.png" alt="Add Stock" width="130" height="30" border="0" /></a></div></td>
                                </tr>
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="464" align="center" valign="top" bgcolor="#005B5B"><table width="95%" border="0" cellspacing="5" cellpadding="5">
                            <tr>
                              <td width="4%">&nbsp;</td>
                              <td width="45%">&nbsp;</td>
                              <td width="14%" class="style17 style57">SET STATUS TO &gt;&gt;&gt; </td>
                              <td width="11%"><div align="right"><a href="pgc_squawk_status_open.php"><img src="Graphics/Open.png" alt="Open" width="100" height="23" border="0" /></a></div></td>
                              <td width="13%"><div align="right"><a href="pgc_squawk_status_pending.php"><img src="Graphics/Pending.png" alt="Pending" width="100" height="23" border="0" /></a></div></td>
                              <td width="13%"><div align="right"><a href="pgc_squawk_status_completed.php"><img src="Graphics/Completed.png" alt="Completed" width="100" height="23" border="0" /></a></div></td>
                            </tr>
                          </table>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                            <td><table width="100%" cellpadding="4" cellspacing="3" bgcolor="#A2B3B3">
                                              <tr>
                                                <td width="80" bgcolor="#35415B"><div align="center" class="style16"><em><strong>SQUAWK ID </strong></em></div></td>
                                                <td width="100" bgcolor="#35415B"><div align="center" class="style16"><em><strong>MEMBER</strong></em></div></td>
                                                <td width="80" bgcolor="#35415B"><div align="center" class="style16"><em><strong>OCCURRED</strong></em></div></td>
                                                <td bgcolor="#35415B"><div align="center" class="style16"><em><strong>EQUIPMENT</strong></em></div></td>
                                                <td bgcolor="#35415B"><div align="center" class="style16"><em><strong>ISSUE / TASK </strong></em></div></td>
                                                <td width="50" bgcolor="#35415B"><div align="center" class="style16"><em><strong>STATUS</strong></em></div></td>
                                              </tr>
                                              <?php do { ?>
                                              <tr>
                                                <td bgcolor="#48597B"><div align="center"><span class="style49"><a href="pgc_squawk_admin_edit.php?sq_key=<?php echo $_SESSION['current_sq'];?>"><?php echo $row_Squawks['sq_key']; ?></a></span></div></td>
                                                <td bgcolor="#48597B"><span class="style49"><?php echo $row_Squawks['id_name']; ?></span></td>
                                                <td bgcolor="#48597B"><div align="center"><span class="style49"><?php echo $row_Squawks['sq_date']; ?></span></div></td>
                                                <td width="130" bgcolor="#48597B"><div align="left"><span class="style49"><?php echo $row_Squawks['sq_equipment']; ?></span></div></td>
                                                <td bgcolor="#48597B"><div align="left"><span class="style49"><?php echo $row_Squawks['sq_issue']; ?></span></div></td>
                                                <td bgcolor="#48597B"><div align="center"><span class="style49"><?php echo $row_Squawks['sq_status']; ?></span></div></td>
                                              </tr>
                                              <?php } while ($row_Squawks = mysql_fetch_assoc($Squawks)); ?>
                                            </table>
                                            <p>&nbsp;</p>
                                                    <table width="100%" cellpadding="4" cellspacing="3" bgcolor="#A2B3B3">
                                                            <tr>
                                                              <td width="80" bgcolor="#622F47" class="style53"><div align="center">WORK ID </div></td>
                                                              <td width="80" bgcolor="#622F47" class="style16"><div align="center"><span class="style53">DATE </span></div></td>
                                                                    <td width="120" bgcolor="#622F47" class="style16"><div align="center"><span class="style53">WORKER(S)</span></div></td>
                                                                    <td width="100" bgcolor="#622F47" class="style16"><div align="center"><span class="style53">WORK HRS </span></div></td>
                                                                    <td bgcolor="#622F47" class="style16"><div align="center"><span class="style53">WORK / STATUS DESCRIPTION</span></div></td>
                                                            </tr>
                                                            <?php do { ?>
                                                            <tr>
                                                                    <td bgcolor="#48597B"><div align="center"><span class="style49"><a href="pgc_squawk_edit_work.php?sq_work_id=<?php echo $row_work['sq_work_key']; ?>"><?php echo $row_work['sq_work_key']; ?></a></span></div></td>
                                                                    <td bgcolor="#48597B"><div align="center"><span class="style49"><?php echo $row_work['work_date']; ?></span></div></td>
                                                                    <td bgcolor="#48597B"><span class="style49"><?php echo $row_work['worker']; ?></span></td>
                                                                    <td bgcolor="#48597B"><div align="center"><span class="style49"><?php echo $row_work['work_hours']; ?></span></div></td>
                                                                    <td bgcolor="#48597B"><div align="left"><span class="style49"><?php echo $row_work['work_desc']; ?></span></div></td>
                                                            </tr>
                                                            <?php } while ($row_work = mysql_fetch_assoc($work)); ?>
                                              </table>
                                                    <p>&nbsp;</p>
                                                    <table width="718" align="left" cellpadding="4" cellspacing="3" bgcolor="#A2B3B3">
                                                            <tr>
                                                              <td width="80" bgcolor="#347A87" class="style53"><div align="center">KEY</div></td>
                                                              <td width="80" bgcolor="#347A87" class="style53"><div align="center">STOCK ID </div></td>
                                                              <td bgcolor="#347A87" class="style53"><div align="center"><span class="style16">DESCRIPTION</span></div></td>
                                                              <td width="90" bgcolor="#347A87" class="style53"><div align="center"><span class="style16">UNIT COST</span></div></td>
                                                              <td width="90" bgcolor="#347A87" class="style53"><div align="center"><span class="style16">DATE USED</span></div></td>
                                                              <td width="90" bgcolor="#347A87" class="style53"><div align="center"><span class="style16">UNITS USED</span></div></td>
                                                            </tr>
                                                            <?php do { ?>
                                                            <tr>
                                                              <td bgcolor="#48597B" class="style49"><div align="center"><a href="pgc_inventory_used_edit.php?inv_used_key=<?php echo $row_Inventory['inv_used_key']; ?>"><?php echo $row_Inventory['inv_used_key']; ?></a></div></td>
                                                              <td bgcolor="#48597B" class="style49"><div align="center"><?php echo $row_Inventory['inv_key']; ?></div></td>
                                                                    <td bgcolor="#48597B" class="style49"><div align="left"><?php echo $row_Inventory['inv_desc']; ?></div></td>
                                                                    <td bgcolor="#48597B" class="style49"><div align="right"><?php echo $row_Inventory['unit_cost']; ?></div></td>
                                                                    <td bgcolor="#48597B" class="style49"><div align="center"><?php echo $row_Inventory['inv_used_date']; ?></div></td>
                                                                    <td bgcolor="#48597B" class="style49"><div align="center"><?php echo $row_Inventory['inv_used_units']; ?></div></td>
                                                            </tr>
                                                            <?php } while ($row_Inventory = mysql_fetch_assoc($Inventory)); ?>
                                              </table></td>
                                    </tr>
                            </table>                            
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
mysql_free_result($Squawks);

mysql_free_result($work);

mysql_free_result($Inventory);
?>