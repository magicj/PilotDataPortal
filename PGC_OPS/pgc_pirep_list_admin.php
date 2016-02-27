<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_access_save_appname.php'); 
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
require_once('pgc_access_app_check.php');
/* END - PAGE ACCESS CHECKING LOGIC - END */
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pgc_pirep (id_entered, id_name, pirep_date, pirep_desc) VALUES ( %s, %s, %s, %s) ",
                       GetSQLValueString($_SESSION['MM_Username'], "text"),
                       GetSQLValueString($_SESSION['MM_PilotName'], "text"),
                       GetSQLValueString($_POST['pirep_date'], "date"),
                       GetSQLValueString($_POST['pirep_desc'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

  $insertGoTo = "../07_members_only_pw.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


$maxRows_Recordset1 = 8;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT pirep_key, date_entered, id_entered, id_name, pirep_date, dayname(pirep_date) as pday, pirep_desc, rec_deleted FROM pgc_pirep WHERE rec_deleted <> 'Y' ORDER BY pirep_date DESC";
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
<script src="../java/javascripts.js" type="text/javascript"></script>
<script src="../java/CalendarPopup.js" type="text/javascript"></script>
<script src="../java/zxml.js" type="text/javascript"></script>
<script src="../java/workingjs.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript" ID="js1">
		var cal = new CalendarPopup();
</SCRIPT>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC PIREP</title>
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
	color: #FFFF99;
	font-family: Arial, Helvetica, sans-serif;
}
.style17 {
	color: #000000;
	font-size: 16px;
	font-weight: bold;
	font-style: italic;
	font-family: Arial, Helvetica, sans-serif;
}
.style35 {color: #FFFFFF; font-size: 14px; font-weight: bold; font-style: italic; }
.style37 {
	color: #EBEBEB;
	font-size: 20px;
	font-weight: bold;
	font-style: italic;
}
.style38 {color: #EBEBEB; }
.style40 {
	color: #000000;
	font-weight: bold;
	font-size: 12px;
}
.style41 {
	font-size: 18px;
	color: #FFFFFF;
}
.style42 {
	font-size: 18px;
	font-weight: bold;
	font-style: italic;
	color: #FFFFFF;
}
.style43 {
	font-size: 12px;
	color: #000;
	text-align: left;
}
.style44 {
	color: #CCCCCC;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
}
.PirepPLusTable
{
	background-color: #147;
	border: 1px solid #039;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #FFF;
	font-weight: bold;
}
.PirepTableHeader
{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #FFF;
}
-->
</style>
</head>
<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
      <tr>
            <td height="398" bgcolor="#666666"><table width="1010" height="734" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#005B5B">
                        <tr>
                              <td width="994" height="90" valign="top" bgcolor="#0A335C"><div align="center">
                                      <table width="96%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                      <td height="16" valign="top"><div align="center">
                                                            <table width="99%" cellspacing="2" cellpadding="0">
                                                                  <tr>
                                                                        <td width="12%" height="40" align="center" bgcolor="#E67300" class="style40">Click KEY to edit your PIREPs</td>
                                                                        <td width="76%" align="center" bgcolor="#660000" class="style37">PGC PIREPS Plus - ADMIN</td>
                                                                        <td width="12%" align="center" bgcolor="#005128" class="style37"><a href="pgc_pirep.php">ADD PIREP</a></td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td height="46" colspan="3" align="center" bgcolor="#475067"><span class="style37"><span class="style35">Share your first solo, FAA flight test, cross-country, WX observation or  other soaring  experiences and insights with PGC members</span></span></td>
                                                                  </tr>
                                                                  </table>
                                                      </div></td>
                                              </tr>
                                          </table>
                              </div></td>
                        </tr>
                        <tr>
                                <td height="600" align="center" valign="top" bgcolor="#09294A">&nbsp;
                                      <form id="form1" name="form1" method="post" action="">
                                            <table width="95%" border="0" align="center" cellpadding="3" cellspacing="1" class="PirepPLusTable">
                                                  <tr>
                                                        <td width="20" align="center" bgcolor="#00215E"><span class="PirepTableHeader">KEY</span></td>
                                                        <td width="100" align="center" bgcolor="#00215E"><span class="PirepTableHeader">PGC MEMBER</span></td>
                                                        <td width="100" align="center" bgcolor="#00215E"><span class="PirepTableHeader">FLIGHT DATE</span></td>
                                                        <td align="center" bgcolor="#001D51" class="PirepTableHeader">PIREP</td>
                                                  </tr>
                                                  <?php do { ?>
                                                        <tr>
                                                              <td height="42" align="center" valign="middle" bgcolor="#002F5E"><a href="pgc_pirep_edit_admin.php?pirep_key=<?php echo  $row_Recordset1['pirep_key']; ?>"><?php echo $row_Recordset1['pirep_key']; ?></a></td>
                                                              <td valign="middle" bgcolor="#002F5E"><?php echo $row_Recordset1['id_name']; ?></td>
                                                              <td align="center" valign="middle" bgcolor="#002F5E"><table width="99%" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                                <td align="center"><?php echo $row_Recordset1['pirep_date']; ?></td>
                                                                        </tr>
                                                                          <tr>
                                                                                <td align="center"><?php echo $row_Recordset1['pday']; ?></td>
                                                                          </tr>
                                                              </table></td>
                                                              <td valign="top" bgcolor="#002F5E"><?php echo $row_Recordset1['pirep_desc']; ?></td>
                                                      </tr>
                                                        <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                                            </table>
                                            <table border="0">
                                                  <tr>
                                                        <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                                                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="First.gif" /></a>
                                                                    <?php } // Show if not first page ?></td>
                                                        <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                                                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="Previous.gif" /></a>
                                                                    <?php } // Show if not first page ?></td>
                                                        <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                                                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="Next.gif" /></a>
                                                                    <?php } // Show if not last page ?></td>
                                                        <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                                                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="Last.gif" /></a>
                                                                    <?php } // Show if not last page ?></td>
                                                  </tr>
                                            </table>
                                      </form></td>
                        </tr>
                        <tr>
                              <td height="30" bgcolor="#4F5359" class="style16"><div align="center">
                                    <table width="161" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td width="157" height="27" align="center" bgcolor="#234747"><a href="../07_members_only_pw.php" class="style17">MEMBER'S PAGE </a></td>
                                                </tr>
                              </table>
                              </div></td>
                        </tr>
            </table></td>
      </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
