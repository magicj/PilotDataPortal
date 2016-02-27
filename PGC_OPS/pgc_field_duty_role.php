<?php require_once('../Connections/PGC.php');?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
$_SESSION[last_query] = $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'];

if (isset($_POST['fd_role_sort'])) {
$_SESSION['fd_role_sort'] = $_POST['fd_role_sort'];
} ELSE {
//$_SESSION['fd_role_sort'] = "MemSort";
}

?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_duty_roles = 20;
$pageNum_duty_roles = 0;
if (isset($_GET['pageNum_duty_roles'])) {
  $pageNum_duty_roles = $_GET['pageNum_duty_roles'];
}
$startRow_duty_roles = $pageNum_duty_roles * $maxRows_duty_roles;

mysql_select_db($database_PGC, $PGC);
If ($_SESSION['fd_role_sort'] == 'SortMem') {
$query_duty_roles = "SELECT USER_ID, NAME, PGC_STATUS, active, duty_role, DATE_FORMAT(dt_added,'%M %D, %Y') AS fdate FROM pgc_members WHERE active = 'YES' ORDER BY NAME ASC";
} ELSE {
$query_duty_roles = "SELECT USER_ID, NAME, PGC_STATUS, active, duty_role, DATE_FORMAT(dt_added,'%M %D, %Y') AS fdate FROM pgc_members WHERE active = 'YES' ORDER BY duty_role ASC, NAME ASC";
}
$query_limit_duty_roles = sprintf("%s LIMIT %d, %d", $query_duty_roles, $startRow_duty_roles, $maxRows_duty_roles);
$duty_roles = mysql_query($query_limit_duty_roles, $PGC) or die(mysql_error());
$row_duty_roles = mysql_fetch_assoc($duty_roles);

if (isset($_GET['totalRows_duty_roles'])) {
  $totalRows_duty_roles = $_GET['totalRows_duty_roles'];
} else {
  $all_duty_roles = mysql_query($query_duty_roles);
  $totalRows_duty_roles = mysql_num_rows($all_duty_roles);
}
$totalPages_duty_roles = ceil($totalRows_duty_roles/$maxRows_duty_roles)-1;

mysql_select_db($database_PGC, $PGC);
$query_duty_totals = "SELECT DISTINCT COUNT(*), duty_role FROM pgc_members WHERE active = 'YES' GROUP BY duty_role  ";
$duty_totals = mysql_query($query_duty_totals, $PGC) or die(mysql_error());
$row_duty_totals = mysql_fetch_assoc($duty_totals);
$totalRows_duty_totals = mysql_num_rows($duty_totals);

mysql_select_db($database_PGC, $PGC);
$query_member_total = "SELECT DISTINCT COUNT(*) FROM pgc_members WHERE active = 'YES'";
$member_total = mysql_query($query_member_total, $PGC) or die(mysql_error());
$row_member_total = mysql_fetch_assoc($member_total);
$totalRows_member_total = mysql_num_rows($member_total);
$pageNum_duty_roles = 0;
if (isset($_GET['pageNum_duty_roles'])) {
  $pageNum_duty_roles = $_GET['pageNum_duty_roles'];
}
$startRow_duty_roles = $pageNum_duty_roles * $maxRows_duty_roles;

$queryString_duty_roles = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_duty_roles") == false && 
        stristr($param, "totalRows_duty_roles") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_duty_roles = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_duty_roles = sprintf("&totalRows_duty_roles=%d%s", $totalRows_duty_roles, $queryString_duty_roles);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal</title>
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
.style16 {
	color: #CCCCCC;
	font-size: 14px;
}
a:link {
	color: #E6E3DF;
}
a:visited {
	color: #E6E3DF;
}
a:active {
	color: #FFFFCC;
}
.style19 {color: #CCCCCC; font-style: italic; font-weight: bold; }
.style20 {	font-size: 16px;
	font-weight: bold;
	color: #FFCCCC;
}
.style24 {font-size: 16px; font-weight: bold; color: #CCCCCC; }
.style28 {
	font-size: 14px;
	font-weight: bold;
	text-align: center;
}
.style23 {font-size: 16px; font-weight: bold; color: #FFCCCC; font-style: italic; }
.TotalCount
{
	font-size: 10px;
}
.style32 {	font-weight: bold;
	color: #FFFFFF;
	font-size: 14px;
}
-->
</style></head>

<body>
<table width="800" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
  <tr>
    <td width="1002"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="260" bgcolor="#3E3E5E"><table width="99%" height="186" border="0" align="center" cellpadding="5" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="25"><div align="center">
            <table width="99%" border="0" cellspacing="2" cellpadding="2">
                <tr>
                      <td bgcolor="#333366"><div align="center"><span class="style24">ASSIGN FIELD DUTY ROLES (ACTIVE MEMBERS)</span></div></td>
                </tr>
                </table>
            </div></td>
      </tr>
      
      <tr>
        <td height="108" align="center" valign="top"><table width="100%" cellspacing="0" cellpadding="2">
              <tr>
                    <td align="center"><table width="84%" cellspacing="0" cellpadding="2">
                          <tr>
                                      <td width="30%" height="75"><table width="148" height="20" cellpadding="2" cellspacing="0">
                                            <tr>
                                                  <td bgcolor="#00366C" class="style28"><a href="pgc_field_duty_role_excel_report.php">EXCEL REPORT</a></td>
                                            </tr>
                                      </table></td>
                                      <td width="52%" align="center"><table border="0" cellpadding="2">
                                            <tr>
                                                  <td width="141" align="center" valign="middle" bgcolor="#333366"><span class="TotalCount">FIELD DUTY ROLE</span></td>
                                                  <td width="111" align="center" valign="middle" bgcolor="#333366"><span class="TotalCount">COUNT</span></td>
                                            </tr>
                                            <?php do { ?>
                                                  <tr>
                                                        <td align="center" valign="middle" bgcolor="#00366C"><span class="TotalCount"><?php echo $row_duty_totals['duty_role']; ?></span></td>
                                                        <td align="center" valign="middle" bgcolor="#00366C"><span class="TotalCount"><?php echo $row_duty_totals['COUNT(*)']; ?></span></td>
                                                  </tr>
                                                  <?php } while ($row_duty_totals = mysql_fetch_assoc($duty_totals)); ?>
                                      </table>
                                            <table border="0" cellpadding="2">
                                                  <?php do { ?>
                                                        <tr>
                                                              <td width="141" align="center" valign="middle" bgcolor="#00366C"><span class="TotalCount">Active Member Total</span></td>
                                                              <td width="111" align="center" valign="middle" bgcolor="#00366C"><span class="TotalCount"><?php echo $row_member_total['COUNT(*)']; ?></span></td>
                                                        </tr>
                                                        <?php } while ($row_duty_totals = mysql_fetch_assoc($duty_totals)); ?>
                                            </table></td>
                                      <td width="30%"><form id="form1" name="form1" method="post" action="pgc_field_duty_role.php">
                                            <table width="100" align="center" cellpadding="2" cellspacing="0">
                                                  <tr>
                                                        <td width="80" height="44" class="style32"><select name="fd_role_sort" id="fd_role_sort">
                                                              <option value="SortRole" <?php if (!(strcmp("SortRole", $_SESSION['fd_role_sort']))) {echo "selected=\"selected\"";} ?>>Sort By Member Role</option>
                                                              <option value="SortMem" <?php if (!(strcmp("SortMem", $_SESSION['fd_role_sort']))) {echo "selected=\"selected\"";} ?>>Sort By Member Name</option>
</select></td>
                                                        </tr>
                                                  <tr>
                                                        <td height="44"><input type="submit" name="Submit" value="Sort" /></td>
                                                        </tr>
                                            </table>
                                      </form></td>
                                </tr>
                    </table></td>
              </tr>
              <tr>
                    <td align="center"><table width="782" border="0" cellpadding="2" cellspacing="2">
                          <tr>
                                <td width="207" align="center" bgcolor="#333366">MEMBER</td>
                                <td width="208" align="center" bgcolor="#333366">EMAIL</td>
                                <td width="118" align="center" bgcolor="#333366">JOINED</td>
                                <td width="118" align="center" bgcolor="#333366">FIELD DUTY ROLE</td>
                          </tr>
                          <?php do { ?>
                                <tr>
                                      <td bgcolor="#00366C"><a href="pgc_field_duty_role_select.php?USER_ID=<?php echo $row_duty_roles['USER_ID']; ?>"> <?php echo $row_duty_roles['NAME']; ?></a></td>
                                      <td bgcolor="#00366C"><?php echo $row_duty_roles['USER_ID']; ?></td>
                                      <td align="center" bgcolor="#00366C"><?php echo $row_duty_roles['fdate'];?></td>
                                      <td align="center" bgcolor="#00366C"><?php echo $row_duty_roles['duty_role']; ?></td>
                                </tr>
                                <?php } while ($row_duty_roles = mysql_fetch_assoc($duty_roles)); ?>
                    </table></td>
              </tr>
              <tr>
                    <td align="center"><table width="28%" border="0">
                          <tr>
                                <td width="25%" bgcolor="#333333"><?php if ($pageNum_duty_roles > 0) { // Show if not first page ?>
                                            <a href="<?php printf("%s?pageNum_duty_roles=%d%s", $currentPage, 0, $queryString_duty_roles); ?>"><img src="First.gif" /></a>
                                            <?php } // Show if not first page ?></td>
                                <td width="25%" bgcolor="#333333"><?php if ($pageNum_duty_roles > 0) { // Show if not first page ?>
                                            <a href="<?php printf("%s?pageNum_duty_roles=%d%s", $currentPage, max(0, $pageNum_duty_roles - 1), $queryString_duty_roles); ?>"><img src="Previous.gif" /></a>
                                            <?php } // Show if not first page ?></td>
                                <td width="25%" bgcolor="#333333"><?php if ($pageNum_duty_roles < $totalPages_duty_roles) { // Show if not last page ?>
                                            <a href="<?php printf("%s?pageNum_duty_roles=%d%s", $currentPage, min($totalPages_duty_roles, $pageNum_duty_roles + 1), $queryString_duty_roles); ?>"><img src="Next.gif" /></a>
                                            <?php } // Show if not last page ?></td>
                                <td width="25%" bgcolor="#333333"><?php if ($pageNum_duty_roles < $totalPages_duty_roles) { // Show if not last page ?>
                                            <a href="<?php printf("%s?pageNum_duty_roles=%d%s", $currentPage, $totalPages_duty_roles, $queryString_duty_roles); ?>"><img src="Last.gif" /></a>
                                            <?php } // Show if not last page ?></td>
                          </tr>
                    </table></td>
              </tr>
        </table>
              </p></td>
      </tr>
      <tr>
        <td height="33"><div align="center" class="style20">
            <p><a href="pgc_fd_menu.php" class="style16">BACK TO FD MENU</a><a href="../07_members_only_pw.php" class="style16"></a></p>
</div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($duty_roles);

mysql_free_result($duty_totals);

mysql_free_result($member_total);
?>
