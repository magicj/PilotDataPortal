<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 

require_once('pgc_access_save_appname.php'); 
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
require_once('pgc_access_app_check.php');
/* END - PAGE ACCESS CHECKING LOGIC - END */
?>
<?php
$session_pilotname = $_SESSION['MM_PilotName'];
$session_email = $_SESSION['MM_Username']; 

mysql_select_db($database_PGC, $PGC);
$runSQL = "UPDATE pgc_calendar SET DateExpired = 'Y'"; 
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
$runSQL = "UPDATE pgc_calendar SET DateExpired = 'N' WHERE EventDate >= curdate()"; 
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

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

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT EventID, EventDate, EventTitle, EventOrder, DateExpired FROM pgc_calendar ORDER BY DateExpired ASC,  EventDate ASC, EventOrder ASC";
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
 if (!isset($_SESSION)) {
  session_start();
}
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
<title>PGC Data Portal - Calendar Edit</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
body {
	background-color: #304078;
	background-image: url(../images/Buttons/PGC%20copy.png);
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style11 {font-size: 16px; font-weight: bold; }
.style16 {color: #CCCCCC; }
a:link {
	color: #FFCC00;
}
a:visited {
	color: #33CC33;
}
.style23 {color: #FFFFFF}
.style24 {color: #FFFFFF; font-weight: bold; }
.style25 {
	color: #8CA6D8;
	font-weight: bold;
}
.style26 {color: #8CA6D8}
.style27 {
	color: #FF0000;
	font-weight: bold;
}
.style28 {color: #FF0000}
-->
</style></head>

<body>
<table width="1000" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#51547B">
  <tr>
    <td><div align="center"><span class="style1">PGC DATA PORTAL - CALENDAR</span> </div></td>
  </tr>
  <tr>
    <td height="514" valign="top" bgcolor="#666666"><table width="92%" height="440" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#414567">
      
      <tr>
        <td height="373" bgcolor="#4F5359" class="style24"><table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
                <tr>
                  <td height="38" colspan="4" bgcolor="#3D4461" class="style23"><div align="center">
                    <table width="90%" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><div align="center">The records in <span class="style28">RED</span> are expired - and do not show on the main page calendar.</div></td>
                      </tr>
                      <tr>
                        <td><div align="center">Edit these expired records to create a new event ... change the date and description to reuse.</div></td>
                      </tr>
                    </table>
                  </div></td>
                </tr>
                <tr>
                  <td height="21" bgcolor="#3D4461" class="style23"><div align="center" class="style25">Record</div></td>
                    <td bgcolor="#3D4461"><div align="center" class="style25">Event Date</div></td>
                    <td bgcolor="#3D4461"><div align="center" class="style25">Event Title</div></td>
                    <td bgcolor="#3D4461" class="style24"><div align="center" class="style26">Interday Order</div></td>
                </tr>
                <?php do { ?>
                    <tr>
                      <td width="10" height="25" align="center" valign="top" bgcolor="#3D4461"><div align="center"><a href="pgc_calendar_edit.php?recordID=<?php echo $row_Recordset1['EventID']; ?>"><span class="style16"><?php echo 'EDIT'; ?></span></div></td>
                      <td width="80" align="center" valign="top" bgcolor="#3D4461">
					  <div align="center" class="style24">
					  <?php if ($row_Recordset1['EventDate'] < date('Y-m-d')) {
					  ?> <div align="center" class="style27"> <?php
					  }
					  ?>
					  <?php echo $row_Recordset1['EventDate']; ?></div></td>
                        <td align="left" valign="top" bgcolor="#3D4461"><div align="left"><?php echo $row_Recordset1['EventTitle']; ?></div></td>
                        <td width="20" align="center" valign="top" bgcolor="#3D4461"><div align="center"><?php echo $row_Recordset1['EventOrder']; ?></div></td>
                    </tr>
                    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
            <p>
            <table width="50%" border="0" align="center" bgcolor="#AAAAAA">
                <tr>
                    <td width="23%" align="center"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="First.gif" border=0></a>
                                <?php } // Show if not first page ?>                    </td>
                    <td width="31%" align="center"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="Previous.gif" border=0></a>
                                <?php } // Show if not first page ?>                    </td>
                    <td width="23%" align="center"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="Next.gif" border=0></a>
                                <?php } // Show if not last page ?>                    </td>
                    <td width="23%" align="center"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="Last.gif" border=0></a>
                                <?php } // Show if not last page ?>                    </td>
                </tr>
            </table>          </td>
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
mysql_free_result($Recordset1);
?>
 