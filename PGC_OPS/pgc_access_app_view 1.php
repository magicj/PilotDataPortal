<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_access_save_appname.php'); 
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
?>
<?php
if (isset($_POST[select])) {
  $_SESSION['app_function'] = $_POST[select];
}
$currentPage = $_SERVER["PHP_SELF"];
$_SESSION['last_app_list_page'] = $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'];
$maxRows_Recordset1 = 15;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_SESSION['app_function'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION['app_function'] : addslashes($_SESSION['app_function']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_access_apps WHERE app_function = '%s' ORDER BY app_name ASC", $colname_Recordset1);
If ($_SESSION['app_function'] == 'ALL') {
$query_Recordset1 = "SELECT * FROM pgc_access_apps ORDER BY app_name ASC";
}
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset3 = "UPDATE `pgcsoaringdb`.`pgc_access_apps` SET `app_function` = 'None' WHERE `pgc_access_apps`.`app_function` is NULL;";
$Recordset3 = mysql_query($query_Recordset3, $PGC) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = "SELECT DISTINCT app_function FROM pgc_access_apps ORDER BY app_function ASC";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC APPLICATION LIST</title>
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
.style57 {color: #FFFFFF; font-weight: bold; }
.style58 {color: #CCCCCC; font-weight: bold; }
.style61 {
	font-size: 14;
	color: #999999;
}
.style64 {color: #999999; font-weight: bold; font-size: 14; }
.style65 {color: #CCCCCC; font-weight: bold; font-size: 14; }
.style66 {font-size: 14px}
-->
</style>
</head>
<body>
<table width="900" height="95%" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
      <tr>
            <td align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="521" bgcolor="#666666"><table width="95%" height="95%" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#003648">
                        <tr>
                                <td width="1562" height="26" valign="top" bgcolor="#005B5B" class="style57"><div align="center" class="style58 style66">APPLICATION LIST VIEW - NO EDIT </div></td>
                        </tr>
                        <tr>
                          <td height="464" align="center" valign="top" bgcolor="#005B5B"><form id="form1" name="form1" method="post" action="">
                                  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                                          <tr>
                                                  <td width="12%" height="44">&nbsp;</td>
                                                  <td width="40%">&nbsp;</td>
                                                  <td width="24%">&nbsp;</td>
                                                  <td width="15%"><div align="center">
                                                                  <select name="select" id="select">
                                                                          <option value="ALL" <?php if (!(strcmp("ALL", "$_SESSION[app_function]"))) {echo "selected=\"selected\"";} ?>>ALL</option>
                                                                          <?php
do {  
?>
                                                                          <option value="<?php echo $row_Recordset2['app_function']?>"<?php if (!(strcmp($row_Recordset2['app_function'], "$_SESSION[app_function]"))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['app_function']?></option>
                                                                          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
                                                                                                                                                                                                      </select>
                                                  </div></td>
                                                  <td width="9%"><div align="right">
                                                                  <input type="submit" name="Submit" value="Submit" />
                                                  </div></td>
                                          </tr>
                                  </table>
                                  <table cellpadding="3" cellspacing="2" bgcolor="#666666">
                                          <tr>
                                                  <td bgcolor="#1A2740" class="style58 style61"><div align="center">KEY</div></td>
                                                  <td bgcolor="#1A2740" class="style64"><div align="center">APP NAME </div></td>
                                                  <td bgcolor="#1A2740" class="style64"><div align="center">APP FUNCTION</div></td>
                                                  <td bgcolor="#1A2740" class="style64"><div align="center">APP NOTES </div></td>
                                                  <td bgcolor="#1A2740" class="style64"><div align="center">ACTIVE</div></td>
                                                  <td bgcolor="#1A2740" class="style64"><div align="center">LAST USED</div></td>
                                                  <td bgcolor="#1A2740" class="style64"><div align="center">USER NAME</div></td>
                                                  <td bgcolor="#1A2740" class="style64"><div align="center">USER ID</div></td>
                                          </tr>
                                          <?php do { ?>
                                                  <tr>
                                                          <td bgcolor="#283D62" class="style65"><div align="center"><?php echo $row_Recordset1['app_key']; ?></div></td>
                                                    <td bgcolor="#283D62" class="style65"><div align="left"><?php echo $row_Recordset1['app_name']; ?></div></td>
                                                    <td bgcolor="#283D62" class="style65"><?php echo $row_Recordset1['app_function']; ?></td>
                                                    <td bgcolor="#283D62" class="style65"><div align="left"><?php echo $row_Recordset1['app_notes']; ?></div></td>
                                                    <td bgcolor="#283D62" class="style65"><div align="center"><?php echo $row_Recordset1['app_active']; ?></div></td>
                                                    <td bgcolor="#283D62" class="style65"><?php echo $row_Recordset1['app_last_used']; ?></td>
                                                    <td bgcolor="#283D62" class="style65"><?php echo $row_Recordset1['last_user_name']; ?></td>
                                                    <td bgcolor="#283D62" class="style65"><?php echo $row_Recordset1['last_user_id']; ?></td>
                                                  </tr>
                                                  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                            </table>
                                          <table border="0" width="50%" align="center">
                                                  <tr>
                                                          <td width="23%" align="center"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                                                                  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">First</a>
                                                                                  <?php } // Show if not first page ?>
                                                          </td>
                                                          <td width="31%" align="center"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                                                                  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Previous</a>
                                                                                  <?php } // Show if not first page ?>
                                                          </td>
                                                          <td width="23%" align="center"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                                                                  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Next</a>
                                                                                  <?php } // Show if not last page ?>
                                                          </td>
                                                          <td width="23%" align="center"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                                                                  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">Last</a>
                                                                                  <?php } // Show if not last page ?>
                                                          </td>
                                                  </tr>
                                          </table>
                                          </p>
                          </form>
                          </td>
                        </tr>
                        <tr>
                          <td height="24" bgcolor="#005B5B" class="style16"><div align="center"><a href="pgc_access_menu.php" class="style17">BACK TO ACCESS MENU </a><a href="../07_members_only_pw.php" class="style17"></a></div></td>
                        </tr>
        </table></td>
      </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>