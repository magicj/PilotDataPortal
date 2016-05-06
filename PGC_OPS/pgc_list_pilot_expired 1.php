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
/* Do Updates - Make this a function */
mysql_select_db($database_PGC, $PGC);

/* Purge Deletions */
$deleteSQL = "DELETE FROM pgc_signoff_nofly WHERE 1 = 1";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());

/* Purge Deletions */
$deleteSQL = "INSERT IGNORE INTO pgc_signoff_nofly(pilot_name) Select pilot_name FROM pgc_pilot_signoffs";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());


/* Set both dates to 0000-00-00 */
$runSQL = "UPDATE pgc_signoff_nofly SET pgc_invalid_signoffs = (SELECT GROUP_CONCAT(DISTINCT signoff_type SEPARATOR ',   ') FROM pgc_pilot_signoffs WHERE pgc_signoff_nofly.pilot_name = pgc_pilot_signoffs.pilot_name AND (pgc_pilot_signoffs.status = 'Expired-A' OR pgc_pilot_signoffs.status = 'Expired-B') GROUP BY pilot_name)";
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

$maxRows_Recordset1 = 25;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_signoff_nofly ORDER BY pilot_name ASC";
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
<title>PGC Data Portal </title>
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
.style17 {
	font-size: 14px;
	font-style: italic;
	font-weight: bold;
}
-->
</style></head>

<body>
<table width="800" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PILOT DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="514"><table width="92%" height="440" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36" bgcolor="#9D1C1C"><div align="center"><span class="style11"> ACTIVE MEMBER - EXPIRED CRITICAL SIGNOFF LIST </span></div></td>
      </tr>
      <tr>
        <td height="373" valign="top" bgcolor="#2C364E"><p align="center">
<table width="665" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
            <tr>
              <td width="155" bgcolor="#0B3A40"><div align="center" class="style17">MEMBER NAME </div></td>
              <td width="493" bgcolor="#0B3A40"><div align="center" class="style17">EXPIRED CRITICAL SIGNOFFS</div></td>
            </tr>
            <?php do { ?>
              <tr>
                <td bgcolor="#10515A"><div align="left"><?php echo $row_Recordset1['pilot_name']; ?></div></td>
                <td bgcolor="#10515A"><div align="left"><?php echo $row_Recordset1['pgc_invalid_signoffs']; ?></div></td>
              </tr>
              <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
          </table>
          <p>
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
          </p></td>
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
