<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
$maxRows_Recordset1 = 20;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}

/* Batch Updates */
mysql_select_db($database_PGC, $PGC);
$insertSQL = "TRUNCATE TABLE pgc_squawk_metrics";
$ResultA = mysql_query($insertSQL, $PGC) or die(mysql_error());

$insertSQL = "INSERT IGNORE INTO pgc_squawk_metrics (metrics_equipment, metrics_status, ship_captain) SELECT DISTINCT equip_name, ship_status, Ship_captain FROM pgc_equipment WHERE pgc_equipment.equip_type <> 'X'";
$ResultA = mysql_query($insertSQL, $PGC) or die(mysql_error());
  
$updateSQL = "UPDATE pgc_squawk_metrics SET new = (SELECT Count(*) FROM pgc_squawk WHERE pgc_squawk_metrics.metrics_equipment = pgc_squawk.sq_equipment and pgc_squawk.sq_status = 'NEW')";
$ResultB = mysql_query($updateSQL, $PGC) or die(mysql_error()); 

$updateSQL = "UPDATE pgc_squawk_metrics SET open = (SELECT Count(*) FROM pgc_squawk WHERE pgc_squawk_metrics.metrics_equipment = pgc_squawk.sq_equipment and pgc_squawk.sq_status = 'OPEN')";
$ResultB = mysql_query($updateSQL, $PGC) or die(mysql_error()); 

$updateSQL = "UPDATE pgc_squawk_metrics SET pending = (SELECT Count(*) FROM pgc_squawk WHERE pgc_squawk_metrics.metrics_equipment = pgc_squawk.sq_equipment and pgc_squawk.sq_status = 'PENDING')";
$ResultB = mysql_query($updateSQL, $PGC) or die(mysql_error()); 

$updateSQL = "UPDATE pgc_squawk_metrics SET completed = (SELECT Count(*) FROM pgc_squawk WHERE pgc_squawk_metrics.metrics_equipment = pgc_squawk.sq_equipment and pgc_squawk.sq_status = 'COMPLETED')";
$ResultC = mysql_query($updateSQL, $PGC) or die(mysql_error()); 

$updateSQL = "UPDATE pgc_squawk_metrics SET total_hrs = (SELECT SUM( pgc_squawk_work.work_hours )
FROM pgc_squawk_work, pgc_squawk
WHERE (pgc_squawk_metrics.metrics_equipment = pgc_squawk.sq_equipment)
AND (pgc_squawk.sq_key = pgc_squawk_work.sq_key) AND (pgc_squawk_work.rec_deleted = 'N'))";
$ResultC = mysql_query($updateSQL, $PGC) or die(mysql_error()); 

$updateSQL = "UPDATE pgc_squawk_metrics SET total_$ = (SELECT SUM( pgc_inventory_used.unit_cost * pgc_inventory_used.inv_used_units )
FROM pgc_inventory_used, pgc_squawk
WHERE (pgc_squawk_metrics.metrics_equipment = pgc_squawk.sq_equipment)
AND (pgc_squawk.sq_key = pgc_inventory_used.sq_key) AND (pgc_inventory_used.rec_deleted = 'N'))";
$ResultC = mysql_query($updateSQL, $PGC) or die(mysql_error()); 

$updateSQL = "UPDATE pgc_squawk_metrics SET new = NULL WHERE new = 0";  
$ResultC = mysql_query($updateSQL, $PGC) or die(mysql_error()); 


$updateSQL = "UPDATE pgc_squawk_metrics SET open = NULL WHERE open = 0";  
$ResultC = mysql_query($updateSQL, $PGC) or die(mysql_error()); 


$updateSQL = "UPDATE pgc_squawk_metrics SET pending = NULL WHERE pending = 0";  
$ResultC = mysql_query($updateSQL, $PGC) or die(mysql_error()); 


$updateSQL = "UPDATE pgc_squawk_metrics SET completed = NULL WHERE completed = 0";  
$ResultC = mysql_query($updateSQL, $PGC) or die(mysql_error()); 
$startRow_Recordset1 = 1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_squawk_metrics";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

error_reporting(0);
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
<title>PGC SQUAWK METRICS</title>
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
	color: #CCCCCC;
}
.style17 {
	color: #CCCCCC;
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
.style45 {color: #FFFFFF}
.style47 {color: #C5C2D6; font-size: 14px; font-weight: bold; font-style: italic; }
.style48 {color: #92DADA; font-size: 14px; font-weight: bold; font-style: italic; }
.style50 {color: #FFFFFF; font-weight: bold; }
.style53 {font-size: 16px}
-->
</style>
</head>
<body>
<table width="1200" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
      <tr>
            <td align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="398" bgcolor="#666666"><table width="95%" height="344" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#005B5B">
                        <tr>
                          <td width="1562" height="23" valign="top" bgcolor="#0A335C"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="14%"><a href="pgc_squawk_view.php"><img src="Graphics/SquawkList copy.png" alt="SquawkList" width="130" height="30" border="0" /></a></td>
                              <td width="11%">&nbsp;</td>
                              <td width="47%" class="style47"><div align="center" class="style53">ADMIN - SQUAWK SUMMARY METRICS </div></td>
                              <td width="16%"><div align="center"><a href="pgc_stock_used_view.php"><img src="Graphics/StockHistory.png" alt="SquawkList" width="130" height="30" border="0" /></a></div></td>
                              <td width="12%"><a href="pgc_work_view.php"><img src="Graphics/WorkHistory.png" alt="SquawkList" width="130" height="30" border="0" /></a></td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="277" align="center" valign="top" bgcolor="#0A335C"><p>&nbsp;</p>
                                  
                            <table width="95%" cellpadding="4" cellspacing="3" bgcolor="#A2B3B3">
                              <tr>
                                <td bgcolor="#35415B" class="style17 style45"><div align="center">EQUIPMENT</div></td>
                                <td width="80" bgcolor="#35415B" class="style17 style45"><div align="center">NEW</div></td>
                                <td width="80" bgcolor="#35415B" class="style17 style45"><div align="center">OPEN</div></td>
                                <td width="80" bgcolor="#35415B" class="style17 style45"><div align="center">PENDING</div></td>
                                <td width="80" bgcolor="#35415B" class="style17 style45"><div align="center">COMPLETED</div></td>
                                <td width="80" bgcolor="#35415B" class="style17 style45"><div align="center">TOTAL $ </div></td>
                                <td width="80" bgcolor="#35415B" class="style17 style45"><div align="center">TOTAL HRS </div></td>
                                <td bgcolor="#35415B" class="style17 style45"><div align="center">STATUS</div></td>
                              </tr>
                              <?php do { ?>
                                <tr>
                                  <td bgcolor="#48597B"><div align="left" class="style47"><?php echo $row_Recordset1['metrics_equipment']; ?></div></td>
                                  <td bgcolor="#48597B"><div align="center"><span class="style50"><?php echo $row_Recordset1['new']; ?></span></div></td>
                                  <td bgcolor="#48597B"><div align="center"><span class="style50"><?php echo $row_Recordset1['open']; ?></span></div></td>
                                  <td bgcolor="#48597B"><div align="center"><span class="style50"><?php echo $row_Recordset1['pending']; ?></span></div></td>
                                  <td bgcolor="#48597B"><div align="center"><span class="style50"><?php echo $row_Recordset1['completed']; ?></span></div></td>
                                  <td bgcolor="#48597B" class="style50"><div align="center"><?php echo $row_Recordset1['total_$']; ?></div></td>
                                  <td bgcolor="#48597B" class="style50"><div align="center"><?php echo $row_Recordset1['total_hrs']; ?></div></td>
                                  <td bgcolor="#48597B"><div align="center" class="style48"><?php echo $row_Recordset1['metrics_status']; ?></div></td>
                                </tr>
                                <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                            </table>
                            <p>&nbsp;</p>
                          </p></td>
                        </tr>
                        <tr>
                              <td height="30" bgcolor="#4F5359" class="style16"><div align="center"></div></td>
                        </tr>
                  </table></td>
      </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>

