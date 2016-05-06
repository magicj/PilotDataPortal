<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
if (isset($_POST[select])) {
  $_SESSION['sq_equipment'] = $_POST[select];
}

mysql_select_db($database_PGC, $PGC);
$updateSQL = "UPDATE pgc_inventory_used SET total_cost = unit_cost * inv_used_units";
$ResultC = mysql_query($updateSQL, $PGC) or die(mysql_error()); 

mysql_select_db($database_PGC, $PGC);
$query_Recordset4 = "SELECT Distinct sq_equipment FROM pgc_squawk";
$Recordset4 = mysql_query($query_Recordset4, $PGC) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$maxRows_Recordset2 = 10;
$pageNum_Recordset2 = 0;
if (isset($_GET['pageNum_Recordset2'])) {
  $pageNum_Recordset2 = $_GET['pageNum_Recordset2'];
}
$startRow_Recordset2 = $pageNum_Recordset2 * $maxRows_Recordset2;

$colname_Recordset2 = "-1";
if (isset($_SESSION['sq_equipment'])) {
  $colname_Recordset2 = (get_magic_quotes_gpc()) ? $_SESSION['sq_equipment'] : addslashes($_SESSION['sq_equipment']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = sprintf("SELECT * FROM pgc_inventory_used A, pgc_squawk B WHERE A.sq_key = B.sq_key AND B.sq_equipment = '%s' AND A.rec_deleted = 'N' ORDER BY A.inv_used_date DESC", $colname_Recordset2);
$query_limit_Recordset2 = sprintf("%s LIMIT %d, %d", $query_Recordset2, $startRow_Recordset2, $maxRows_Recordset2);
$Recordset2 = mysql_query($query_limit_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);

if (isset($_GET['totalRows_Recordset2'])) {
  $totalRows_Recordset2 = $_GET['totalRows_Recordset2'];
} else {
  $all_Recordset2 = mysql_query($query_Recordset2);
  $totalRows_Recordset2 = mysql_num_rows($all_Recordset2);
}
$totalPages_Recordset2 = ceil($totalRows_Recordset2/$maxRows_Recordset2)-1;

$queryString_Recordset2 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset2") == false && 
        stristr($param, "totalRows_Recordset2") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset2 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset2 = sprintf("&totalRows_Recordset2=%d%s", $totalRows_Recordset2, $queryString_Recordset2);


$currentPage = $_SERVER["PHP_SELF"];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC EQUIPMENT WORK VIEW</title>
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
	color: #CCCCCC;
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
.style56 {font-size: 14px; font-weight: bold; font-style: italic; color: #E2E2E2; }
.style57 {color: #FFFFFF; font-weight: bold; }
.style42 {	font-size: 16px;
	font-weight: bold;
	font-style: italic;
	color: #E2E2E2;
}
.style54 {font-size: 14px;
	font-weight: bold;
	color: #FF6600;
}
.style58 {color: #CCCCCC; font-weight: bold; }
.style59 {
	color: #F0F0F0;
	font-weight: bold;
}
.style60 {color: #F0F0F0}
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
                                                                        <td width="51%"><div align="left"><a href="pgc_squawk_metrics.php"><img src="Graphics/SquawMetrics copy.png" alt="Metrics" width="130" height="30" border="0" /></a></div></td>
                                                                </tr>
                                                </table></td>
                                                <td width="30%"><div align="center"><span class="style42">STOCK  HISTORY   </span></div></td>
                                                <td width="35%"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                  <td width="49%" class="style54"><div align="right"><a href="pgc_squawk_view.php"><img src="Graphics/SquawkList copy.png" alt="SquawkList" width="130" height="30" border="0" /></a></div></td>
                                                                        <td width="6%">&nbsp;</td>
                                                                        <td width="45%"><div align="left"><a href="pgc_stock_used_view.php"></a><a href="pgc_squawk_admin_entry.php"></a><a href="pgc_work_view.php"><img src="Graphics/WorkHistory.png" alt="SquawkList" width="130" height="30" border="0" /></a></div></td>
                                                                </tr>
                                                </table></td>
                                        </tr>
                                </table></td>
                        </tr>
                        <tr>
                          <td height="464" align="center" valign="top" bgcolor="#005B5B"><form id="form1" name="form1" method="post" action="">
                                  <table width="95%" border="0" cellspacing="2" cellpadding="2">
                                          <tr>
                                                  <td width="501">&nbsp;</td>
                                                  <td width="92" height="49"><div align="left"><span class="style56">EQUIPMENT: </span></div></td>
                                                  <td width="199"><div align="left">
                                                                  <select name="select" id="select">
                                                                          <?php
do {  
?>
                                                                          <option value="<?php echo $row_Recordset4['sq_equipment']?>"<?php if (!(strcmp($row_Recordset4['sq_equipment'], $_SESSION['sq_equipment']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset4['sq_equipment']?></option>
                                                                          <?php
} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
  $rows = mysql_num_rows($Recordset4);
  if($rows > 0) {
      mysql_data_seek($Recordset4, 0);
	  $row_Recordset4 = mysql_fetch_assoc($Recordset4);
  }
?>
                                                    </select>
                                                  </div></td>
                                                  <td width="70"><div align="right">
                                                                  <input type="image" name="Submit" value="Submit" src="Graphics/Filter.png" style="border:0;" />
                                                  </div></td>
                                          </tr>
                                  </table>
                                  
                                  <table width="95%" cellpadding="4" cellspacing="3" bgcolor="#A2B3B3">
                                          <tr>
                                                  <td bgcolor="#35415B" class="style57"><div align="center">EQUIPMENT</div></td>
                                                  <td bgcolor="#35415B" class="style57"><div align="center">SQUAWK ID </div></td>
                                                  <td bgcolor="#35415B" class="style57"><div align="center">INVENTORY KEY </div></td>
                                                  <td bgcolor="#35415B" class="style57"><div align="center">DATE USED </div></td>
                                                  <td bgcolor="#35415B" class="style57"><div align="center">CATEGORY</div></td>
                                                  <td bgcolor="#35415B" class="style57"><div align="center">DESCRIPTION</div></td>
                                                  <td bgcolor="#35415B" class="style57"><div align="center">UNITS USED</div></td>
                                                  <td bgcolor="#35415B" class="style57"><div align="center">UNIT COST</div></td>
                                                  <td bgcolor="#35415B" class="style57"><div align="center">TOTAL COST</div></td>
                                                  <td bgcolor="#35415B" class="style57"><div align="center">VENDOR</div></td>
                                    </tr>
                                          <?php do { ?>
                                                  <tr>
                                                          <td bgcolor="#48597B" class="style16"><div align="center" class="style59"><?php echo $row_Recordset2['sq_equipment']; ?></div></td>
                                                          <td bgcolor="#48597B" class="style58"><div align="center" class="style60"><a href="pgc_squawk_work.php?sq_id=<?php echo $row_Recordset2['sq_key'];?>"><?php echo $row_Recordset2['sq_key']; ?></a></div></td>
                                                          <td bgcolor="#48597B" class="style58"><div align="center" class="style60"><?php echo $row_Recordset2['inv_key']; ?></div></td>
                                                          <td bgcolor="#48597B" class="style58"><div align="center" class="style60"><?php echo $row_Recordset2['inv_used_date']; ?></div></td>
                                                          <td bgcolor="#48597B" class="style58"><div align="center" class="style60"><?php echo $row_Recordset2['inv_category']; ?></div></td>
                                                          <td bgcolor="#48597B" class="style58"><div align="center" class="style60"><?php echo $row_Recordset2['inv_desc']; ?></div></td>
                                                          <td bgcolor="#48597B" class="style58"><div align="center" class="style60"><?php echo $row_Recordset2['inv_used_units']; ?></div></td>
                                                          <td bgcolor="#48597B" class="style58"><div align="center" class="style60"><?php echo $row_Recordset2['unit_cost']; ?></div></td>
                                                          <td bgcolor="#48597B" class="style58"><span class="style60"><?php echo $row_Recordset2['total_cost']; ?></span></td>
                                                          <td bgcolor="#48597B" class="style58"><div align="center" class="style60"><?php echo $row_Recordset2['inv_vendor']; ?></div></td>
                                          </tr>
                                                  <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
                                  </table>
                                  <p>
                                  
                                  <table border="0" width="50%" align="center">
                                          <tr>
                                                  <td width="23%" align="center"><?php if ($pageNum_Recordset2 > 0) { // Show if not first page ?>
                                                                          <a href="<?php printf("%s?pageNum_Recordset2=%d%s", $currentPage, 0, $queryString_Recordset2); ?>">First</a>
                                                                          <?php } // Show if not first page ?>
                                                  </td>
                                                  <td width="31%" align="center"><?php if ($pageNum_Recordset2 > 0) { // Show if not first page ?>
                                                                          <a href="<?php printf("%s?pageNum_Recordset2=%d%s", $currentPage, max(0, $pageNum_Recordset2 - 1), $queryString_Recordset2); ?>">Previous</a>
                                                                          <?php } // Show if not first page ?>
                                                  </td>
                                                  <td width="23%" align="center"><?php if ($pageNum_Recordset2 < $totalPages_Recordset2) { // Show if not last page ?>
                                                                          <a href="<?php printf("%s?pageNum_Recordset2=%d%s", $currentPage, min($totalPages_Recordset2, $pageNum_Recordset2 + 1), $queryString_Recordset2); ?>">Next</a>
                                                                          <?php } // Show if not last page ?>
                                                  </td>
                                                  <td width="23%" align="center"><?php if ($pageNum_Recordset2 < $totalPages_Recordset2) { // Show if not last page ?>
                                                                          <a href="<?php printf("%s?pageNum_Recordset2=%d%s", $currentPage, $totalPages_Recordset2, $queryString_Recordset2); ?>">Last</a>
                                                                          <?php } // Show if not last page ?>
                                                  </td>
                                          </tr>
                                  </table>
                                  </p>
                          </form>                                  <p> 
                          </p></td>
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
mysql_free_result($Recordset4);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>