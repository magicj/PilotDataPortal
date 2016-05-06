<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
/* require_once('pgc_check_login_admin.php'); */
$maxRows_PilotRatings = 20;
$pageNum_PilotRatings = 0;
if (isset($_GET['pageNum_PilotRatings'])) {
  $pageNum_PilotRatings = $_GET['pageNum_PilotRatings'];
}
$startRow_PilotRatings = $pageNum_PilotRatings * $maxRows_PilotRatings;

mysql_select_db($database_PGC, $PGC);
$query_PilotRatings = "SELECT * FROM pgc_pilot_ratings ORDER BY pgc_rating ASC";
$query_limit_PilotRatings = sprintf("%s LIMIT %d, %d", $query_PilotRatings, $startRow_PilotRatings, $maxRows_PilotRatings);
$PilotRatings = mysql_query($query_limit_PilotRatings, $PGC) or die(mysql_error());
$row_PilotRatings = mysql_fetch_assoc($PilotRatings);

if (isset($_GET['totalRows_PilotRatings'])) {
  $totalRows_PilotRatings = $_GET['totalRows_PilotRatings'];
} else {
  $all_PilotRatings = mysql_query($query_PilotRatings);
  $totalRows_PilotRatings = mysql_num_rows($all_PilotRatings);
}
$totalPages_PilotRatings = ceil($totalRows_PilotRatings/$maxRows_PilotRatings)-1;

$currentPage = $_SERVER["PHP_SELF"];
?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
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
  $insertSQL = sprintf("INSERT INTO pgc_pilot_ratings (pilot_name, pgc_rating) VALUES (%s, %s)",
                       GetSQLValueString($_POST['pilot_name'], "text"),
                       GetSQLValueString($_POST['pgc_rating'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
}

$queryString_PilotRatings = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_PilotRatings") == false && 
        stristr($param, "totalRows_PilotRatings") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_PilotRatings = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_PilotRatings = sprintf("&totalRows_PilotRatings=%d%s", $totalRows_PilotRatings, $queryString_PilotRatings);

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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Add Pilot Rating</title>
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
.style14 {font-size: 14px; font-weight: bold; }
.style17 {color: #FFFFFF}
-->
</style></head>

<body>
<table width="805" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td width="793"><div align="center"><span class="style1">PILOT DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="514"><table width="92%" height="440" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36" bgcolor="#212F4E"><div align="center"><span class="style11">LIST PILOT RATINGS </span></div></td>
      </tr>
      <tr>
        <td height="373" bgcolor="#212F4E">&nbsp;
          <table width="403" align="center" cellpadding="2" cellspacing="1" bordercolor="#4A0000" bgcolor="#666666">
            <tr>
              <td width="182" bgcolor="#0C3E43"><div align="center"><span class="style14">Pilot Name </span></div></td>
              <td width="145" bgcolor="#0C3E43"><div align="center"><span class="style14">PGC Rating </span></div></td>
            </tr>
            <?php do { ?>
              <tr>
                <td bgcolor="#0C3E43"><?php echo $row_PilotRatings['pilot_name']; ?></td>
                <td bgcolor="#0C3E43"><?php echo $row_PilotRatings['pgc_rating']; ?></td>
              </tr>
              <?php } while ($row_PilotRatings = mysql_fetch_assoc($PilotRatings)); ?>
          </table>
          
          <p> 
          <table border="0" width="50%" align="center">
            <tr>
              <td width="23%" align="center"><?php if ($pageNum_PilotRatings > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_PilotRatings=%d%s", $currentPage, 0, $queryString_PilotRatings); ?>" class="style17">First</a>
                    <?php } // Show if not first page ?>
              </td>
              <td width="31%" align="center"><?php if ($pageNum_PilotRatings > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_PilotRatings=%d%s", $currentPage, max(0, $pageNum_PilotRatings - 1), $queryString_PilotRatings); ?>" class="style17">Previous</a>
                    <?php } // Show if not first page ?>
              </td>
              <td width="23%" align="center"><?php if ($pageNum_PilotRatings < $totalPages_PilotRatings) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_PilotRatings=%d%s", $currentPage, min($totalPages_PilotRatings, $pageNum_PilotRatings + 1), $queryString_PilotRatings); ?>" class="style17">Next</a>
                    <?php } // Show if not last page ?>
              </td>
              <td width="23%" align="center"><?php if ($pageNum_PilotRatings < $totalPages_PilotRatings) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_PilotRatings=%d%s", $currentPage, $totalPages_PilotRatings, $queryString_PilotRatings); ?>" class="style17">Last</a>
                    <?php } // Show if not last page ?>
              </td>
            </tr>
          </table></td>
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
mysql_free_result($PilotRatings);


?>