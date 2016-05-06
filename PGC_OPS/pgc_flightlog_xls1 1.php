<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsFlightlog = 10;
$pageNum_rsFlightlog = 0;
if (isset($_GET['pageNum_rsFlightlog'])) {
  $pageNum_rsFlightlog = $_GET['pageNum_rsFlightlog'];
}
$startRow_rsFlightlog = $pageNum_rsFlightlog * $maxRows_rsFlightlog;

mysql_select_db($database_PGC, $PGC);
$query_rsFlightlog = "SELECT DISTINCT `Date` FROM pgc_flightsheet ORDER BY `Date` DESC";
$query_limit_rsFlightlog = sprintf("%s LIMIT %d, %d", $query_rsFlightlog, $startRow_rsFlightlog, $maxRows_rsFlightlog);
$rsFlightlog = mysql_query($query_limit_rsFlightlog, $PGC) or die(mysql_error());
$row_rsFlightlog = mysql_fetch_assoc($rsFlightlog);

if (isset($_GET['totalRows_rsFlightlog'])) {
  $totalRows_rsFlightlog = $_GET['totalRows_rsFlightlog'];
} else {
  $all_rsFlightlog = mysql_query($query_rsFlightlog);
  $totalRows_rsFlightlog = mysql_num_rows($all_rsFlightlog);
}
$totalPages_rsFlightlog = ceil($totalRows_rsFlightlog/$maxRows_rsFlightlog)-1;

$queryString_rsFlightlog = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsFlightlog") == false && 
        stristr($param, "totalRows_rsFlightlog") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsFlightlog = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsFlightlog = sprintf("&totalRows_rsFlightlog=%d%s", $totalRows_rsFlightlog, $queryString_rsFlightlog);
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Klaus Updates</title>
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
.style18 {
	color: #FFFFCC;
	font-weight: bold;
	font-style: italic;
}
a:link {
	color: #FFCC00;
}
a:visited {
	color: #33CC33;
}
.style22 {color: #FFFFFF; font-size: 16px; }
.style23 {color: #FFFFFF}
-->
</style></head>

<body>
<table width="800" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#51547B">
  <tr>
    <td><div align="center"><span class="style1">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="514" bgcolor="#666666"><table width="92%" height="440" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#414567">
      <tr>
        <td height="36"><div align="center"><span class="style11">PGC Flightlog XLS Extract </span></div></td>
      </tr>
      <tr>
        <td height="373" bgcolor="#4F5359"><p align="center" class="style18">
            <table width="177" align="center" cellpadding="2" cellspacing="2" bgcolor="#6F39C6">
                <tr>
                    <td width="167" bgcolor="#6699FF" class="style18"><div align="center" class="style22">Available Logs </div></td>
                </tr>
                <?php do { ?>
                    <tr>
                        <td bgcolor="#6633FF"><div align="center" class="style11"><span class="style23"><a href="pgc_flightsheet-xls-date.php?recordID=<?php echo $row_rsFlightlog['Date']; ?>"><?php echo $row_rsFlightlog['Date']; ?></a></span></div></td>
                    </tr>
                    <?php } while ($row_rsFlightlog = mysql_fetch_assoc($rsFlightlog)); ?>
            </table>
            <br>
            <table border="0" width="50%" align="center">
                <tr>
                    <td width="23%" align="center"><?php if ($pageNum_rsFlightlog > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_rsFlightlog=%d%s", $currentPage, 0, $queryString_rsFlightlog); ?>">First</a>
                                <?php } // Show if not first page ?>
                    </td>
                    <td width="31%" align="center"><?php if ($pageNum_rsFlightlog > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_rsFlightlog=%d%s", $currentPage, max(0, $pageNum_rsFlightlog - 1), $queryString_rsFlightlog); ?>">Previous</a>
                                <?php } // Show if not first page ?>
                    </td>
                    <td width="23%" align="center"><?php if ($pageNum_rsFlightlog < $totalPages_rsFlightlog) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_rsFlightlog=%d%s", $currentPage, min($totalPages_rsFlightlog, $pageNum_rsFlightlog + 1), $queryString_rsFlightlog); ?>">Next</a>
                                <?php } // Show if not last page ?>
                    </td>
                    <td width="23%" align="center"><?php if ($pageNum_rsFlightlog < $totalPages_rsFlightlog) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_rsFlightlog=%d%s", $currentPage, $totalPages_rsFlightlog, $queryString_rsFlightlog); ?>">Last</a>
                                <?php } // Show if not last page ?>
                    </td>
                </tr>
            </table>
             <p>&nbsp;</p>
          <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td height="21"><div align="center"><strong class="style11"><a href="../PGC_OPS/pgc_portal_menu.php" class="style16">BACK TO MAIN</a></strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsFlightlog);
?>
 