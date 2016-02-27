<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
  
/* Do Updates - Make this a function */
mysql_select_db($database_PGC, $PGC);

/* Purge Deletions */
$deleteSQL = "DELETE FROM pgc_signoff_nofly WHERE 1 = 1";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());

/* Purge Deletions */
$deleteSQL = "INSERT IGNORE INTO pgc_signoff_nofly(pilot_name) Select pilot_name FROM pgc_pilot_signoffs";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());


/* Set both dates to 0000-00-00 */
$runSQL = "UPDATE pgc_signoff_nofly SET pgc_invalid_signoffs = (SELECT GROUP_CONCAT(DISTINCT signoff_type SEPARATOR ',   ') FROM pgc_pilot_signoffs WHERE pgc_signoff_nofly.pilot_name = pgc_pilot_signoffs.pilot_name AND pgc_pilot_signoffs.status = 'Expired-A' GROUP BY pilot_name)";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

 /* Purge Deletions */
$deleteSQL = "DELETE FROM pgc_signoff_nofly WHERE pgc_invalid_signoffs IS Null";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());

 /* Purge Inactive ================ */
$deleteSQL = "UPDATE pgc_signoff_nofly SET pgc_status = 'NO'";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());

$deleteSQL = "UPDATE pgc_signoff_nofly A, pgc_members B SET A.pgc_status = 'YES' WHERE A.pilot_name = B.NAME AND B.active <> 'NO'";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());

$deleteSQL = "DELETE FROM pgc_signoff_nofly WHERE pgc_status = 'NO'";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());
?>
 
<?php
$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_signoff_nofly ORDER BY pilot_name ASC";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

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
<title>PGC Data Portal - List Expired Signoffs</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style11 {font-size: 16px; font-weight: bold; }
a {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFCC;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #FFFFCC;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
.style19 {font-size: 16px; font-style: italic; font-weight: bold; }
.style21 {
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
-->
</style></head>

<body>
<p>&nbsp;</p>
<table border="1" align="center" cellpadding="3" cellspacing="3" bordercolor="#000000">
    <tr>
        <td colspan="2"><div align="center"><span class="style11">LIST PILOT EXPIRED SIGNOFFS</span></div></td>
    </tr>
    <tr>
        <td width="200"><div align="center" class="style19">MEMBER NAME </div></td>
        <td width="400"><div align="center" class="style19">EXPIRED CRITICAL SIGNOFFS</div></td>
    </tr>
    <?php do { ?>
    <tr>
        <td><div align="left" class="style21"><?php echo $row_Recordset1['pilot_name']; ?></div></td>
        <td><div align="left" class="style21"><?php echo $row_Recordset1['pgc_invalid_signoffs']; ?></div></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
