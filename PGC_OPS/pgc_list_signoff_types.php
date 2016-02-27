<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
session_start();
/* require_once('pgc_check_login_admin.php'); */
$_SESSION['last_signoff_query'] = $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'];
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_rs_SignoffTypes = 10;
$pageNum_rs_SignoffTypes = 0;
if (isset($_GET['pageNum_rs_SignoffTypes'])) {
  $pageNum_rs_SignoffTypes = $_GET['pageNum_rs_SignoffTypes'];
}
$startRow_rs_SignoffTypes = $pageNum_rs_SignoffTypes * $maxRows_rs_SignoffTypes;

mysql_select_db($database_PGC, $PGC);
$query_rs_SignoffTypes = "SELECT * FROM pgc_signoff_types ORDER BY sort_order ASC";
$query_limit_rs_SignoffTypes = sprintf("%s LIMIT %d, %d", $query_rs_SignoffTypes, $startRow_rs_SignoffTypes, $maxRows_rs_SignoffTypes);
$rs_SignoffTypes = mysql_query($query_limit_rs_SignoffTypes, $PGC) or die(mysql_error());
$row_rs_SignoffTypes = mysql_fetch_assoc($rs_SignoffTypes);

if (isset($_GET['totalRows_rs_SignoffTypes'])) {
  $totalRows_rs_SignoffTypes = $_GET['totalRows_rs_SignoffTypes'];
} else {
  $all_rs_SignoffTypes = mysql_query($query_rs_SignoffTypes);
  $totalRows_rs_SignoffTypes = mysql_num_rows($all_rs_SignoffTypes);
}
$totalPages_rs_SignoffTypes = ceil($totalRows_rs_SignoffTypes/$maxRows_rs_SignoffTypes)-1;

$queryString_rs_SignoffTypes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_SignoffTypes") == false && 
        stristr($param, "totalRows_rs_SignoffTypes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_SignoffTypes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_SignoffTypes = sprintf("&totalRows_rs_SignoffTypes=%d%s", $totalRows_rs_SignoffTypes, $queryString_rs_SignoffTypes);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pilot Data Portal - Signoff Status</title>
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
.style16 {color: #CCCCCC; }
a:link {
	color: #FFFF99;
}
a:visited {
	color: #FFCC99;
}
-->
</style></head>

<body>

<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PILOT DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="515"><table width="92%" height="527" align="center" cellpadding="2" cellspacing="3" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36" bgcolor="#2C364E"><div align="center"><span class="style11">LIST &amp; MODIFY SIGNOFF TYPES </span></div></td>
      </tr>
      
      <tr>
        <td height="418" align="center" valign="top" bgcolor="#2C364E"><p>&nbsp;</p>
          <table width="98%" align="center" cellpadding="2" cellspacing="3" bgcolor="#666666">
            <tr>
              <td width="5" bgcolor="#1D3D6B"><div align="center"><em><strong>ID</strong></em></div></td>
              <td bgcolor="#1D3D6B"><div align="center"><em><strong>DESCRIPTION</strong></em></div></td>
              <td bgcolor="#1D3D6B"><div align="center"><em><strong>TARGET GROUP </strong></em></div></td>
              <td bgcolor="#1D3D6B"><div align="center"><em><strong>EXPIRES </strong></em></div></td>
              <td bgcolor="#1D3D6B"><div align="center"><em><strong> DAYS</strong></em></div></td>
              <td bgcolor="#1D3D6B"><div align="center"><em><strong>EOM EXPIRE </strong></em></div></td>
              <td bgcolor="#1D3D6B"><em><strong>MEMBER UPDATE</strong></em></td>
              <td bgcolor="#1D3D6B"><em><strong>YEARLY RESET </strong></em></td>
              <td bgcolor="#1D3D6B"><div align="center"><em><strong>NOFLY LEVEL </strong></em></div></td>
              <td bgcolor="#1D3D6B"><div align="center"><em><strong>DEFAULT SIGNOFF </strong></em></div></td>
              <td bgcolor="#1D3D6B"><div align="center"><em><strong>DEFAULT EXPIRE </strong></em></div></td>
              <td bgcolor="#1D3D6B"><div align="center"><em><strong>CALC EXPIRE </strong></em></div></td>
              <td bgcolor="#1D3D6B"><div align="center"><em><strong>DD Sort </strong></em></div></td>
              </tr>
            <?php do { ?>
              <tr>
                <td bgcolor="#0F4E55"><div align="center"><a href="pgc_list_signoff_types_detail.php?signoffID=<?php echo $row_rs_SignoffTypes['signoffID']; ?>"><?php echo $row_rs_SignoffTypes['signoffID']; ?></a></div></td>
                <td bgcolor="#0F4E55"><?php echo $row_rs_SignoffTypes['description']; ?></td>
                <td bgcolor="#0F4E55"><div align="center"><?php echo $row_rs_SignoffTypes['target_group']; ?></div></td>
                <td bgcolor="#0F4E55"><div align="center"><?php echo $row_rs_SignoffTypes['expires']; ?></div></td>
                <td bgcolor="#0F4E55"><div align="center"><?php echo $row_rs_SignoffTypes['duration_days']; ?></div></td>
                <td bgcolor="#0F4E55"><div align="center"><?php echo $row_rs_SignoffTypes['eom_expiry']; ?></div></td>
                <td bgcolor="#0F4E55"><div align="center"><?php echo $row_rs_SignoffTypes['member_updates']; ?></div></td>
                <td bgcolor="#0F4E55"><div align="center"><?php echo $row_rs_SignoffTypes['yearly_reset']; ?></div></td>
                <td bgcolor="#0F4E55"><div align="center"><?php echo $row_rs_SignoffTypes['group_id']; ?></div></td>
                <td bgcolor="#0F4E55"><div align="center"><?php echo $row_rs_SignoffTypes['default_signoff_date']; ?></div></td>
                <td bgcolor="#0F4E55"><div align="center"><?php echo $row_rs_SignoffTypes['default_expire_date']; ?></div></td>
                <td bgcolor="#0F4E55"><div align="center"><?php echo $row_rs_SignoffTypes['calc_expire_date']; ?></div></td>
                <td bgcolor="#0F4E55"><div align="center"><?php echo $row_rs_SignoffTypes['sort_order']; ?> </div></td>
                </tr>
              <?php } while ($row_rs_SignoffTypes = mysql_fetch_assoc($rs_SignoffTypes)); ?>
          </table>
          <p>
          <table border="0" width="50%" align="center">
            <tr>
              <td width="23%" align="center"><?php if ($pageNum_rs_SignoffTypes > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rs_SignoffTypes=%d%s", $currentPage, 0, $queryString_rs_SignoffTypes); ?>">First</a>
                    <?php } // Show if not first page ?>
              </td>
              <td width="31%" align="center"><?php if ($pageNum_rs_SignoffTypes > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rs_SignoffTypes=%d%s", $currentPage, max(0, $pageNum_rs_SignoffTypes - 1), $queryString_rs_SignoffTypes); ?>">Previous</a>
                    <?php } // Show if not first page ?>
              </td>
              <td width="23%" align="center"><?php if ($pageNum_rs_SignoffTypes < $totalPages_rs_SignoffTypes) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rs_SignoffTypes=%d%s", $currentPage, min($totalPages_rs_SignoffTypes, $pageNum_rs_SignoffTypes + 1), $queryString_rs_SignoffTypes); ?>">Next</a>
                    <?php } // Show if not last page ?>
              </td>
              <td width="23%" align="center"><?php if ($pageNum_rs_SignoffTypes < $totalPages_rs_SignoffTypes) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rs_SignoffTypes=%d%s", $currentPage, $totalPages_rs_SignoffTypes, $queryString_rs_SignoffTypes); ?>">Last</a>
                    <?php } // Show if not last page ?>
              </td>
            </tr>
          </table>
          </p>
<p><em><strong>Click on ID to Edit or Delete a signoff record. </strong></em></p></td>
      </tr>
      <tr>
        <td height="25" align="center" valign="top"><strong class="style11"><a href="../PGC_OPS/pgc_portal_menu.php" class="style16">BACK TO MAIN</a> </strong></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rs_SignoffTypes);
?>
