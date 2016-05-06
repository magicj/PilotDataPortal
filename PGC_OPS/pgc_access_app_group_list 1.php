<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
/* ==========================================================*/
require_once('pgc_access_save_appname.php'); 
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
require_once('pgc_access_check.php');
/* END - PAGE ACCESS CHECKING LOGIC - END */
/* ==========================================================*/
?>
<?php
$_SESSION['last_app_group_list_page'] = $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'];
if (isset($_POST[select])) {
  $_SESSION['app_name'] = $_POST[select];
}
if (isset($_POST[select2])) {
  $_SESSION['app_group'] = $_POST[select2];
}


// Clean Up Deletions 
$deleteSQL = "DELETE FROM pgc_access_app_groups WHERE rec_active = 'D'";
mysql_select_db($database_PGC, $PGC);
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());
  
/* - REFRESH */
$Refresh_SQL = "INSERT IGNORE INTO pgc_access_app_groups (app_name, allowed_group) SELECT app_name,'SYSADMIN' FROM pgc_access_apps";

$maxRows_Recordset1 = 20;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_SESSION['app_name'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION['app_name'] : addslashes($_SESSION['app_name']);
}
$colname_Recordset2 = "-1";
if (isset($_SESSION['app_group'])) {
  $colname_Recordset2 = (get_magic_quotes_gpc()) ? $_SESSION['app_group'] : addslashes($_SESSION['app_group']);
}

mysql_select_db($database_PGC, $PGC);

if ($_SESSION['app_name'] <> 'ALL' AND $_SESSION['app_group'] <> 'ALL') {
	$query_Recordset1 = sprintf("SELECT * FROM pgc_access_app_groups WHERE app_name = '%s' AND allowed_group = '%s' ORDER BY app_name ASC", $colname_Recordset1, $colname_Recordset2);
}
if ($_SESSION['app_name'] == 'ALL' AND $_SESSION['app_group'] == 'ALL') {
	$query_Recordset1 = sprintf("SELECT * FROM pgc_access_app_groups ORDER BY app_name ASC", $colname_Recordset1, $colname_Recordset2);
}

if ($_SESSION['app_name'] <> 'ALL' AND $_SESSION['app_group'] == 'ALL') {
	$query_Recordset1 = sprintf("SELECT * FROM pgc_access_app_groups WHERE app_name = '%s' ORDER BY app_name ASC", $colname_Recordset1);
}

if ($_SESSION['app_name'] == 'ALL' AND $_SESSION['app_group'] <> 'ALL') {
	$query_Recordset1 = sprintf("SELECT * FROM pgc_access_app_groups WHERE allowed_group = '%s' ORDER BY app_name ASC", $colname_Recordset2);
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

mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = "SELECT DISTINCT app_name FROM pgc_access_app_groups";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_PGC, $PGC);
$query_Recordset3 = "SELECT DISTINCT allowed_group FROM pgc_access_app_groups";
$Recordset3 = mysql_query($query_Recordset3, $PGC) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>APP ALLOWED ACCESS FROUPS</title>
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
.style17 {
	color: #CCCCCC;
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
.style57 {color: #FFFFFF; font-weight: bold; }
.style59 {
	color: #FFFFFF;
	font-weight: bold;
	font-style: italic;
	font-size: 16px;
}
.style64 {color: #999999; font-size: 14px; }
-->
</style>
</head>
<body>
<table width="900" height="95%" align="center" cellpadding="2" cellspacing="2"  bordercolor="#000033" bgcolor="#595E80">
      <tr>
            <td height="25" align="center"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td valign="top"><table width="95%" height="95%" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#414967">
                        <tr>
                                <td width="1562" height="26" valign="middle" class="style57"><div align="center" class="style59">  APPLICATION ASSIGNED GROUPS</div></td>
                        </tr>
                        <tr>
                          <td align="center" valign="top"><form id="form1" name="form1" method="post" action="">
                                                                                                      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                              <tr>
                                                                                                                      <td width="12%" height="44">&nbsp;</td>
                                                                                                                      <td width="40%">&nbsp;</td>
                                                                                                                      <td width="24%"><div align="center">
                                                                                                                              <select name="select2" id="select2">
                                                                                                                                      <option value="ALL" <?php if (!(strcmp("ALL", $_SESSION['app_group']))) {echo "selected=\"selected\"";} ?>>ALL</option>
                                                                                                                                      <?php
do {  
?><option value="<?php echo $row_Recordset3['allowed_group']?>"<?php if (!(strcmp($row_Recordset3['allowed_group'],$_SESSION['app_group']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset3['allowed_group']?></option>
                                                                                                                                      <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
                                                                                                                              </select>
                                                                                                                      </div></td>
                                                                                                                      <td width="15%"><div align="center">
                                                                                                                                      <select name="select" id="select">
                                                                                                                                              <option value="ALL" <?php if (!(strcmp("ALL", $_SESSION['app_name']))) {echo "selected=\"selected\"";} ?>>ALL</option><?php
do {  
?><option value="<?php echo $row_Recordset2['app_name']?>"<?php if (!(strcmp($row_Recordset2['app_name'], $_SESSION['app_name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['app_name']?></option>
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
                                                                                                      <table width="90%" cellpadding="3" cellspacing="2" bgcolor="#666666">
                                                                                                              <tr>
                                                                                                                      <td bgcolor="#1A2740" class="style57"><div align="center" class="style64">EDIT</div></td>
                                                                                                                      <td bgcolor="#1A2740" class="style57"><div align="center" class="style64">APP (Add Group) </div></td>
                                                                                                                      <td bgcolor="#1A2740" class="style57"><div align="center" class="style64">ALLOWED GROUPS </div></td>
                                                                                                                      <td bgcolor="#1A2740" class="style57"><div align="center" class="style64">ACTIVE</div></td>
                                                                                                              </tr>
                                                                                                              <?php do { ?>
                                                                                                                      <tr>
                                                                                                                              <td bgcolor="#283D62" class="style17"><div align="center"><a href="pgc_access_app_group_edit.php?rec_key=<?php echo $row_Recordset1['rec_key']; ?>"><?php echo $row_Recordset1['rec_key']; ?></a></div></td>
                                                                                                                              <td width="275" bgcolor="#283D62" class="style17"><a href="pgc_access_app_group_add.php?app_name=<?php echo $row_Recordset1['app_name']; ?>"><?php echo $row_Recordset1['app_name']; ?></a></td>
                                                                                                                              <td bgcolor="#283D62" class="style17"><div align="center"><?php echo $row_Recordset1['allowed_group']; ?></div></td>
                                                                                                                              <td bgcolor="#283D62" class="style17"><div align="center"><?php echo $row_Recordset1['rec_active']; ?></div></td>
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
                                                                                                      <p>&nbsp;</p>
                          </form>                                                <p>&nbsp;</p></td>
                        </tr>
                        <tr>
                          <td height="24" class="style16"><div align="center"><a href="pgc_access_menu.php" class="style17">BACK TO ACCESS MENU </a><a href="../07_members_only_pw.php" class="style17"></a></div></td>
                        </tr>
        </table></td>
      </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
