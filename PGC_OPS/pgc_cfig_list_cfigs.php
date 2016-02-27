<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
$app_name = basename($_SERVER['PHP_SELF']);
require_once('pgc_access_check.php')
/* END - PAGE ACCESS CHECKING LOGIC - END */
?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pgc_instructors SET Name=%s, cfig=%s, rec_active=%s WHERE instructorID=%s",
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString($_POST['cfig'], "text"),
                       GetSQLValueString($_POST['rec_active'], "text"),
                       GetSQLValueString($_POST['instructorID'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "xxxxxxxxxxx";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_Recordset1 = 15;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT instructorID, Name, cfig, rec_active FROM pgc_instructors WHERE Name <> '' and CFIG = 'Y' ORDER BY Name ASC";
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Flightlog</title>
<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
	color: #CCCCCC;
}
body {
	background-color: #283664;
	background-image: url(../images/Buttons/PGC%20copy.png);
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
.style26 {
	color: #CCCCCC;
	font-size: 16px;
	font-weight: bold;
}
.style29 {color: #CCCCCC; font-size: 14px; font-weight: bold; }
.style30 {font-size: 14px}
.style31 {font-size: 14px; color: #999999; }
.style32 {
	color: #FFFFFF;
	font-size: 14px;
	font-weight: bold;
}
a:link {
	color: #FFFFFF;
}
a:visited {
	color: #FFFFFF;
}
a:active {
	color: #FFFFFF;
}
a:hover {
	color: #FFFFFF;
}
.style33 {
	color: #FF0000;
	font-weight: bold;
	font-style: italic;
}
-->
</style>
</head>

<script language="javascript" src="../calendar/calendar.js"></script>




<body>
<p>&nbsp;</p>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
  <tr>
    <td><div align="center"><span class="style29">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="481" valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                            <td width="6%">&nbsp;</td>
                            <td width="18%">&nbsp;</td>
                            <td width="53%"><div align="center"><span class="style26">FLIGHTSHEET - CFIG LIST</span></div></td>
                            <td width="20%"><div align="center" class="style33"><a href="pgc_cfig_list_new_enter.php" class="style29"><span class="style32">ADD NEW CFIG</span></a> </div></td>
                            <td width="3%">&nbsp;</td>
                    </tr>
            </table>
            <table width="92%" height="407" align="center" cellpadding="2" cellspacing="3" bgcolor="#666666">
      
      <tr>
        <td height="373" valign="top">&nbsp;
                <form id="form1" name="form1" method="post" action="">
                        <table width="80%" align="center" cellpadding="1" cellspacing="2">
                                <tr>
                                        <td valign="middle" bgcolor="#324267" class="style26 style30"><div align="center">ID</div></td>
                                        <td valign="middle" bgcolor="#324267" class="style29"><div align="center">CFIG NAME</div></td>
                                        <td width="65" valign="middle" bgcolor="#324267" class="style29"><div align="center">ACTIVE</div></td>
                                        </tr>
                                <?php do { ?>
                                        <tr>
                                                <td valign="middle" bgcolor="#324267" ><div align="center"><a href="pgc_cfig_list_update.php?instructorID=<?php echo $row_Recordset1['instructorID']; ?>" ><?php echo $row_Recordset1['instructorID']; ?></a></div></td>
                                                <td valign="middle" bgcolor="#324267" class="style32"><?php echo $row_Recordset1['Name']; ?></td>
                                                <td valign="middle" bgcolor="#324267" class="style29"><div align="center" class="style31"><?php echo $row_Recordset1['rec_active']; ?></div></td>
                                                </tr>
                                        <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                        </table>
                        <table border="0" width="50%" align="center">
                                <tr>
                                        <td width="23%" align="center" class="style26"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                                                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">First</a>
                                                                <?php } // Show if not first page ?>                                        </td>
                                        <td width="31%" align="center" class="style26"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                                                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Previous</a>
                                                                <?php } // Show if not first page ?>                                        </td>
                                        <td width="23%" align="center" class="style26"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                                                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Next</a>
                                                                <?php } // Show if not last page ?>                                        </td>
                                        <td width="23%" align="center" class="style26"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                                                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">Last</a>
                                                                <?php } // Show if not last page ?>                                        </td>
                                </tr>
                        </table>
                        </p>
                </form>
                </td>
      </tr>
    </table>
    <p align="center"><span class="style29"><a href="pgc_portal_menu.php">RETURN TO MAINTENANCE MENU</a></span></p></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
