<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php'?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_access_save_appname.php'); 
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
require_once('pgc_access_app_check.php');
/* END - PAGE ACCESS CHECKING LOGIC - END */
require_once('pgc_check_login.php'); 
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
$_SESSION[last_query] = $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'];
?>

<?php
if (isset($_GET['pageNum_rsFieldDuty'])) {
  $pageNum_rsFieldDuty = $_GET['pageNum_rsFieldDuty'];
}
$startRow_rsFieldDuty = $pageNum_rsFieldDuty * $maxRows_rsFieldDuty;
$maxRows_rsFieldDuty = 20;
$pageNum_rsFieldDuty = 0;
if (isset($_GET['pageNum_rsFieldDuty'])) {
  $pageNum_rsFieldDuty = $_GET['pageNum_rsFieldDuty'];
}
$startRow_rsFieldDuty = $pageNum_rsFieldDuty * $maxRows_rsFieldDuty;

mysql_select_db($database_PGC, $PGC);
$query_rsFieldDuty = "SELECT date, date_format(date,'%m/%d/%y') as mydate, date_format(date,'%W') as daydate, cfig, tp1, tp2, `session` FROM pgc_field_duty WHERE date >= curdate() ORDER BY `date` ASC";
$query_limit_rsFieldDuty = sprintf("%s LIMIT %d, %d", $query_rsFieldDuty, $startRow_rsFieldDuty, $maxRows_rsFieldDuty);
$rsFieldDuty = mysql_query($query_limit_rsFieldDuty, $PGC) or die(mysql_error());
$row_rsFieldDuty = mysql_fetch_assoc($rsFieldDuty);

if (isset($_GET['totalRows_rsFieldDuty'])) {
  $totalRows_rsFieldDuty = $_GET['totalRows_rsFieldDuty'];
} else {
  $all_rsFieldDuty = mysql_query($query_rsFieldDuty);
  $totalRows_rsFieldDuty = mysql_num_rows($all_rsFieldDuty);
}
$totalPages_rsFieldDuty = ceil($totalRows_rsFieldDuty/$maxRows_rsFieldDuty)-1;

$queryString_rsFieldDuty = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsFieldDuty") == false && 
        stristr($param, "totalRows_rsFieldDuty") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsFieldDuty = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsFieldDuty = sprintf("&totalRows_rsFieldDuty=%d%s", $totalRows_rsFieldDuty, $queryString_rsFieldDuty);
?>
<?php
// Add Opens where NULL
mysql_select_db($database_PGC, $PGC);
//$updateSQL = "UPDATE pgc_field_duty SET fm_sub='Open' WHERE fm_sub IS NULL";
//$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
//$updateSQL = "UPDATE pgc_field_duty SET afm1_sub='Open' WHERE afm1_sub IS NULL";
//$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
//$updateSQL = "UPDATE pgc_field_duty SET afm2_sub='Open' WHERE afm2_sub IS NULL";
//$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
//$updateSQL = "UPDATE pgc_field_duty SET afm3_sub='Open' WHERE afm3_sub IS NULL";
//$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

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
	background-color: #333333;
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style11 {font-size: 16px; font-weight: bold; }
a:link {
	color: #E6E3DF;
}
a:visited {
	color: #E6E3DF;
}
a:active {
	color: #FFFFCC;
}
.style17 {font-size: 12px; font-weight: bold; }
.style351 {color: #8CA6D8; font-style: italic; font-weight: bold; font-family: Arial, Helvetica, sans-serif; }
.style20 {color: #8CA6D8; font-style: italic; font-weight: bold; font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style></head>

<body>
<table width="900" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td width="1278"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="429"><table width="98%" height="638" border="0" align="center" cellpadding="5" cellspacing="2" bordercolor="#005B5B" bgcolor="#383A52">
      <tr>
        <td height="25" bgcolor="#545E78"><div align="center">
              <table width="95%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="31%">&nbsp;</td>
                        <td width="38%" align="center"><span class="style11">TOW PILOT  DUTY  ASSIGNMENTS</span></td>
                        <td width="31%" align="center"><a href="pgc_towpilot_duty_xls.php">Excel Report</a></td>
                  </tr>
      </table>
<p class="style17">(Click on duty date to assign members) </p>
        </div></td>
      </tr>
      
      <tr>
        <td height="570" align="center" valign="top" bgcolor="#666666"><form id="form1" name="form1" method="post" action="">
            <p>
            <label></label>
            <table width="95%" border="0" cellpadding="2" cellspacing="2" bgcolor="#666666">
                <tr>
                    <td bgcolor="#3D4461"><div align="center"><span class="style351"> DATE</span></div></td>
                    <td align="center" bgcolor="#3D4461"><span class="style351">DAY </span></td>
                    <td bgcolor="#3D4461"><div align="center" class="style351">AM TOW PILOT </div></td>
                    <td bgcolor="#3D4461"><div align="center" class="style351"> PM TOW PILOT </div></td>
                    </tr>
                <?php do { ?>
                    <tr>
                        <td bgcolor="#3D4461"><div align="center"><a href="pgc_field_duty_update_towpilot.php?dutydate=<?php echo $row_rsFieldDuty['date'] ; ?>"><?php echo $row_rsFieldDuty['mydate']; ?></a></div></td>
                        <td align="center" bgcolor="#3D4461"><a href="pgc_field_duty_update_towpilot.php?dutydate=<?php echo $row_rsFieldDuty['date'] ; ?>"><?php echo $row_rsFieldDuty['daydate']; ?></a></td>
                        <td bgcolor="#3D4461"><div align="center"><?php echo $row_rsFieldDuty['tp1']; ?></div></td>
                        <td bgcolor="#3D4461"><div align="center"><?php echo $row_rsFieldDuty['tp2']; ?></div></td>
                        </tr>
                    <?php } while ($row_rsFieldDuty = mysql_fetch_assoc($rsFieldDuty)); ?>
            </table>
            <p>
            <table border="0" width="40%" align="center">
            <tr>
              <td width="23%" align="center"><?php if ($pageNum_rsFieldDuty > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsFieldDuty=%d%s", $currentPage, 0, $queryString_rsFieldDuty); ?>"><em><strong>First</strong></em></a>
                    <?php } // Show if not first page ?>              </td>
              <td width="31%" align="center"><?php if ($pageNum_rsFieldDuty > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsFieldDuty=%d%s", $currentPage, max(0, $pageNum_rsFieldDuty - 1), $queryString_rsFieldDuty); ?>"><em><strong>Previous</strong></em></a>
                    <?php } // Show if not first page ?>              </td>
              <td width="23%" align="center"><?php if ($pageNum_rsFieldDuty < $totalPages_rsFieldDuty) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsFieldDuty=%d%s", $currentPage, min($totalPages_rsFieldDuty, $pageNum_rsFieldDuty + 1), $queryString_rsFieldDuty); ?>"><em><strong>Next</strong></em></a>
                    <?php } // Show if not last page ?>              </td>
              <td width="23%" align="center"><?php if ($pageNum_rsFieldDuty < $totalPages_rsFieldDuty) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsFieldDuty=%d%s", $currentPage, $totalPages_rsFieldDuty, $queryString_rsFieldDuty); ?>"><em><strong>Last</strong></em></a>
                    <?php } // Show if not last page ?>              </td>
            </tr>
          </table>
          </p>
        </form>        </td>
      </tr>
      <tr>
        <td height="33"><div align="center"><strong class="style11"><a href="../07_members_only_pw.php" class="style20">BACK TO MEMBERS PAGE</a></strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsFieldDuty);
?>
