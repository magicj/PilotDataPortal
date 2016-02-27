<?php require_once('../Connections/PGC.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_rsSignoffs = 10;
$pageNum_rsSignoffs = 0;
if (isset($_GET['pageNum_rsSignoffs'])) {
  $pageNum_rsSignoffs = $_GET['pageNum_rsSignoffs'];
}
$startRow_rsSignoffs = $pageNum_rsSignoffs * $maxRows_rsSignoffs;

$colname_rsSignoffs = "-1";
if (isset($_GET['pgc_pilot'])) {
  $colname_rsSignoffs = (get_magic_quotes_gpc()) ? $_GET['pgc_pilot'] : addslashes($_GET['pgc_pilot']);
}
mysql_select_db($database_PGC, $PGC);
$query_rsSignoffs = sprintf("SELECT * FROM pgc_pilot_signoffs WHERE pilot_name = '%s'", $colname_rsSignoffs);
$query_limit_rsSignoffs = sprintf("%s LIMIT %d, %d", $query_rsSignoffs, $startRow_rsSignoffs, $maxRows_rsSignoffs);
$rsSignoffs = mysql_query($query_limit_rsSignoffs, $PGC) or die(mysql_error());
$row_rsSignoffs = mysql_fetch_assoc($rsSignoffs);

if (isset($_GET['totalRows_rsSignoffs'])) {
  $totalRows_rsSignoffs = $_GET['totalRows_rsSignoffs'];
} else {
  $all_rsSignoffs = mysql_query($query_rsSignoffs);
  $totalRows_rsSignoffs = mysql_num_rows($all_rsSignoffs);
}
$totalPages_rsSignoffs = ceil($totalRows_rsSignoffs/$maxRows_rsSignoffs)-1;

mysql_select_db($database_PGC, $PGC);
$query_rsPilots = "SELECT pilot_name, fly_status FROM pgc_pilots ORDER BY pilot_name ASC";
$rsPilots = mysql_query($query_rsPilots, $PGC) or die(mysql_error());
$row_rsPilots = mysql_fetch_assoc($rsPilots);
$totalRows_rsPilots = mysql_num_rows($rsPilots);

$colname_rsPgcFlyStstus = "-1";
if (isset($_GET['pgc_pilot'])) {
  $colname_rsPgcFlyStstus = (get_magic_quotes_gpc()) ? $_GET['pgc_pilot'] : addslashes($_GET['pgc_pilot']);
}
mysql_select_db($database_PGC, $PGC);
$query_rsPgcFlyStstus = sprintf("SELECT pilot_name, fly_status, pgc_ratings FROM pgc_pilots WHERE pilot_name = '%s'", $colname_rsPgcFlyStstus);
$rsPgcFlyStstus = mysql_query($query_rsPgcFlyStstus, $PGC) or die(mysql_error());
$row_rsPgcFlyStstus = mysql_fetch_assoc($rsPgcFlyStstus);
$totalRows_rsPgcFlyStstus = mysql_num_rows($rsPgcFlyStstus);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - PGC Pilot Signoff Status</title>
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
-->
</style></head>

<body>
<table width="800" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="515"><table width="92%" height="527" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36"><div align="center"><span class="style11">PGC PILOT SIGNOFF STATUS </span></div></td>
      </tr>
      <tr>
        <td height="36"><table width="786" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="277" bgcolor="#525252" class="style11"><?php echo $row_rsSignoffs['pilot_name']; ?></td>
            <td width="386" bgcolor="#525252" class="style11"><?php echo $row_rsPgcFlyStstus['pgc_ratings']; ?></td>
            <td width="103" bgcolor="#525252" class="style11"><?php echo $row_rsPgcFlyStstus['fly_status']; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="418" align="center" valign="top"><table width="786" border="1" cellpadding="2" cellspacing="2" bgcolor="#0F4E55">
          <tr>
            <td bgcolor="#0C3E43"><div align="center"><em><strong>ID</strong></em></div></td>
            <td bgcolor="#0C3E43"><div align="center"><em><strong>Signoff Type </strong></em></div></td>
            <td bgcolor="#0C3E43"><div align="center"><em><strong>Signoff Date </strong></em></div></td>
            <td bgcolor="#0C3E43"><div align="center"><em><strong>Instructor</strong></em></div></td>
            <td bgcolor="#0C3E43"><div align="center"><em><strong>Expire Date </strong></em></div></td>
            <td bgcolor="#0C3E43"><div align="center"><em><strong>Status</strong></em></div></td>
          </tr>
          <?php do { ?>
            <tr>
              <td width="20"><?php echo $row_rsSignoffs['signoffID']; ?></td>
              <td width="150"><?php echo $row_rsSignoffs['signoff_type']; ?></td>
              <td width="80"><?php echo $row_rsSignoffs['signoff_date']; ?></td>
              <td width="80"><?php echo $row_rsSignoffs['instructor']; ?></td>
              <td width="80"><?php echo $row_rsSignoffs['expire_date']; ?></td>
              <td width="60"><?php echo $row_rsSignoffs['status']; ?></td>
            </tr>
            <?php } while ($row_rsSignoffs = mysql_fetch_assoc($rsSignoffs)); ?>
        </table>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <form id="form1" name="form1" method="get" action="pgc_list_signoffs_select (2-21).php">
            <label>
              <select name="pgc_pilot" type="text" id="pgc_pilot">
                <?php
do {  
?>
                <option value="<?php echo $row_rsPilots['pilot_name']?>"<?php if (!(strcmp($row_rsPilots['pilot_name'], $row_rsSignoffs['pilot_name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsPilots['pilot_name']?></option>
                <?php
} while ($row_rsPilots = mysql_fetch_assoc($rsPilots));
  $rows = mysql_num_rows($rsPilots);
  if($rows > 0) {
      mysql_data_seek($rsPilots, 0);
	  $row_rsPilots = mysql_fetch_assoc($rsPilots);
  }
?>
              </select>
              </label>
            <label>
            <input type="submit" name="Submit" value="Submit" />
            </label>
          </form>          <p>&nbsp;</p></td></tr>
      <tr>
        <td height="25" align="center" valign="top"><strong class="style11"><a href="../PGC_OPS/pgc_portal_menu.php" class="style16">BACK TO MAIN</a> </strong></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsSignoffs);

mysql_free_result($rsPilots);

mysql_free_result($rsPgcFlyStstus);
?>
