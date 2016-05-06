<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
/* ==========================================================*/
require_once('pgc_access_save_appname.php'); 
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
require_once('pgc_access_check.php');
/* END - PAGE ACCESS CHECKING LOGIC - END */
/* ==========================================================*/
?>
<?php
// Add year and flightlog history table name to pgc_flight_tables table 
//  $_SESSION['pgc_year'] = 'pgc_flightsheet';
if (isset($_GET['pgc_year'])) {
$_SESSION['pgc_year'] = $_GET['pgc_year'];
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_flight_tables ORDER by ops_year DESC";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
if (isset($_SESSION['pgc_year'])) 
$pgc_table = $_SESSION['pgc_year'];
ELSE
$pgc_table = 'pgc_flightsheet';
$pgc_table_col = $pgc_table .'.glider';
$pgc_table_pilot = $pgc_table .'.Pilot1';
if ($pgc_tablex = 'pgc_flightsheet') {
 /*  Calculate Time  AND  YEAR( `Date`) = YEAR(CURDATE()) */
$updateHours = "UPDATE pgc_gliders SET pgc_hours = (SELECT Sum(`Time`) FROM " . $pgc_table . " WHERE pgc_gliders.glider = " . $pgc_table_col . " AND " . $pgc_table_pilot . " <> '') ";
mysql_select_db($database_PGC, $PGC);
$HoursResult = mysql_query($updateHours, $PGC) or die(mysql_error());

$updateHours = "UPDATE pgc_gliders SET total_hours = start_hours + pgc_hours";
mysql_select_db($database_PGC, $PGC);
$HoursResult = mysql_query($updateHours, $PGC) or die(mysql_error());

$updateHours = "UPDATE pgc_gliders SET total_hours = start_hours WHERE pgc_hours IS NULL";
mysql_select_db($database_PGC, $PGC);
$HoursResult = mysql_query($updateHours, $PGC) or die(mysql_error());


$updateHours = "UPDATE pgc_gliders SET delta_hours = total_hours - inspection_hours";
mysql_select_db($database_PGC, $PGC);
$HoursResult = mysql_query($updateHours, $PGC) or die(mysql_error());
}

  
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

/*$query = "SELECT type, SUM(price) FROM products GROUP BY type"; 
	 
$result = mysql_query($query) or die(mysql_error());

// Print out result
while($row = mysql_fetch_array($result)){
	echo "Total ". $row['type']. " = $". $row['SUM(price)'];
	echo "<br />";
}
*/


mysql_select_db($database_PGC, $PGC);
$query_rsGliders = "SELECT Glider, Count(Glider), Sum(`Time`) FROM " . $pgc_table . " WHERE (Pilot1 <> '' OR Pilot2 <> '') AND Glider <> '' GROUP BY Glider";
$rsGliders = mysql_query($query_rsGliders, $PGC) or die(mysql_error());
$row_rsGliders = mysql_fetch_assoc($rsGliders);
$totalRows_rsGliders = mysql_num_rows($rsGliders);


mysql_select_db($database_PGC, $PGC);
$query_rs_instructors = "SELECT Pilot2, Count(Pilot2), Sum( `Time`) FROM " . $pgc_table . " WHERE Pilot2 <> '' AND Glider <> '' GROUP BY Pilot2";
$rs_instructors = mysql_query($query_rs_instructors, $PGC) or die(mysql_error());
$row_rs_instructors = mysql_fetch_assoc($rs_instructors);
$totalRows_rs_instructors = mysql_num_rows($rs_instructors);

mysql_select_db($database_PGC, $PGC);
$query_rsTowpilot = "SELECT `Tow Pilot`, Count(`Tow Pilot`),Sum(`Tow Altitude`)  FROM " . $pgc_table . " WHERE (Pilot1 <> '' OR Pilot2 <> '') AND Glider <> '' GROUP BY `Tow Pilot`  ";
$rsTowpilot = mysql_query($query_rsTowpilot, $PGC) or die(mysql_error());
$row_rsTowpilot = mysql_fetch_assoc($rsTowpilot);
$totalRows_rsTowpilot = mysql_num_rows($rsTowpilot);

mysql_select_db($database_PGC, $PGC);
$query_rsCFIGgrandTot = "SELECT Count(Pilot2), Sum( `Time`) FROM " . $pgc_table . " WHERE Pilot2 <> '' AND Glider <> '' ";
$rsCFIGgrandTot = mysql_query($query_rsCFIGgrandTot, $PGC) or die(mysql_error());
$row_rsCFIGgrandTot = mysql_fetch_assoc($rsCFIGgrandTot);
$totalRows_rsCFIGgrandTot = mysql_num_rows($rsCFIGgrandTot);

mysql_select_db($database_PGC, $PGC);
$query_rsGLIDERGrandTot = "SELECT Count(Glider), Sum(`Time`) FROM " . $pgc_table . " WHERE (Pilot1 <> '' OR Pilot2 <> '') AND Glider <> '' ";
$rsGLIDERGrandTot = mysql_query($query_rsGLIDERGrandTot, $PGC) or die(mysql_error());
$row_rsGLIDERGrandTot = mysql_fetch_assoc($rsGLIDERGrandTot);
$totalRows_rsGLIDERGrandTot = mysql_num_rows($rsGLIDERGrandTot);

mysql_select_db($database_PGC, $PGC);
$query_rsTowPilotTotal = "SELECT  Count(`Tow Pilot`),Sum(`Tow Altitude`) FROM " . $pgc_table . " WHERE (Pilot1 <> '' OR Pilot2 <> '') AND Glider <> '' ";
$rsTowPilotTotal = mysql_query($query_rsTowPilotTotal, $PGC) or die(mysql_error());
$row_rsTowPilotTotal = mysql_fetch_assoc($rsTowPilotTotal);
$totalRows_rsTowPilotTotal = mysql_num_rows($rsTowPilotTotal);

mysql_select_db($database_PGC, $PGC);
$query_rsMembers = "SELECT Pilot1, Count(Glider), Sum(`Time`) FROM " . $pgc_table . " WHERE (Pilot1 <> '' OR Pilot2 <> '') AND Glider <> '' AND `Time` > 0 GROUP BY Pilot1";
$rsMembers = mysql_query($query_rsMembers, $PGC) or die(mysql_error());
$row_rsMembers = mysql_fetch_assoc($rsMembers);
$totalRows_rsMembers = mysql_num_rows($rsMembers);

mysql_select_db($database_PGC, $PGC);
$query_rsMemberGtotals = "SELECT Count(Glider), Sum(`Time`) FROM " . $pgc_table . " WHERE (Pilot1 <> '' OR Pilot2 <> '') AND Glider <> ''  ";
$rsMemberGtotals = mysql_query($query_rsMemberGtotals, $PGC) or die(mysql_error());
$row_rsMemberGtotals = mysql_fetch_assoc($rsMemberGtotals);
$totalRows_rsMemberGtotals = mysql_num_rows($rsMemberGtotals);

mysql_select_db($database_PGC, $PGC);
$query_Glider_log = "SELECT glider, start_hours, pgc_hours, inspection_hours, inspection_date, delta_hours, total_hours, hour_display FROM pgc_gliders WHERE hour_display = 'Y' ORDER BY glider ASC";
$Glider_log = mysql_query($query_Glider_log, $PGC) or die(mysql_error());
$row_Glider_log = mysql_fetch_assoc($Glider_log);
$totalRows_Glider_log = mysql_num_rows($Glider_log);

mysql_select_db($database_PGC, $PGC);
$query_Table_Date = "SELECT date_format(`Date`,'%Y') as flight_year FROM " . $pgc_table . " Where `Date` <> '' LIMIT 1";
$Table_Date = mysql_query($query_Table_Date, $PGC) or die(mysql_error());
$row_Table_Date = mysql_fetch_assoc($Table_Date);
$totalRows_Table_Date = mysql_num_rows($Table_Date);
$_SESSION['$flight_year'] = $row_Table_Date['flight_year'];

mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = "SELECT date_format(`Date`,'%Y') as Mstart FROM pgc_flightsheet ";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$_SESSION['$Logdate'] = date("Y-m-d"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Flightlog</title>
<style type="text/css">
<!--
.style1 {	font-size: 18px;
	font-weight: bold;
}
body {
	background-color: #333333;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
.style3 {font-size: 16px; font-weight: bold; }
.style16 {color: #CCCCCC; }
a:link {
	color: #D3D8E4;
}
a:visited {
	color: #D3D8E4;
}
.style34 {font-size: 14px; font-weight: bold; color: #E2E2E2; font-style: italic; }
.style35 {color: #DBDDE6}
.style37 {color: #C2C7E2}
.style39 {
	color: #DBDDE6;
	font-weight: bold;
	font-size: 14px;
	font-style: italic;
}
.style41 {color: #DBDDE6; font-weight: bold; font-style: italic; }
.style43 {color: #DBDDE6; font-style: italic; }
.style44 {color: #C2C7E2; font-weight: bold; }
.style45 {
	color: #6666FF;
	font-size: 14px;
}
a:hover {
	color: #D3D8E4;
}
a:active {
	color: #BFC5D9;
}
.style46 {color: #CCCCCC; font-size: 14px; }
-->
</style>
</head>

<body>
<table width="800" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
    <tr>
        <td><div align="center">
                <table width="97%" cellspacing="0" cellpadding="0">
                    <tr>
                            <td width="23%">&nbsp;</td>
                            <td width="57%"><div align="center"><span class="style1">PGC DATA PORTAL</span></div></td>
                            <td width="20%"><?php echo $_SESSION['pgc_year'] ?>&nbsp;</td>
                    </tr>
                    <tr>
                            <td><div align="center"><strong class="style3"><a href="../07_members_only_pw.php" class="style45">Members Page</a></strong></div></td>
                            <td><div align="center"><span class="style1"><?php echo $_SESSION['$flight_year']. " " ?>FLIGHT SHEET METRICS (v2) </span></div></td>
                            <td><form id="form1" name="form1" method="get" action="pgc_flightlog_metrics.php">
                                    <select name="pgc_year" id = "pgc_year">
                                <?php
do {  
?>
                                <option value="<?php echo $row_Recordset1['history_table']?>"<?php if (!(strcmp($row_Recordset1['history_table'], $row_Recordset1['ops_year']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['ops_year']?></option>
                                <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                        </select>
                        <input type="submit" name="Submit" value="Submit" />
                            </form></td>
                    </tr>
            </table>
        </div></td>
    </tr>
    <tr>
        <td height="458" valign="top"><table width="100%" height="427" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
                <tr>
                        <td height="389" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#2F334F">
                                        <tr>
                                          <td height="21" valign="middle">&nbsp;</td>
                                        </tr>
                                        <tr>
                                                <td height="114" valign="top"><table width="600" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#7C7C8F">
                                                                        <tr>
                                                                                <td colspan="3" bgcolor="#455463" class="style34"><div align="center"><?php echo $_SESSION['$flight_year']. " " ?>FLIGHT ACTIVITY </div></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td width="250" bgcolor="#455463" class="style34"><div align="center" >PGC GLIDER </div></td>
                                                                                <td width="150" bgcolor="#455463" class="style34"><div align="center" class="style35">FLIGHTS</div></td>
                                                                                <td bgcolor="#455463" class="style34"><div align="center" class="style35">TOTAL HOURS </div></td>
                                                                        </tr>
                                                                        <?php do { ?>
                                                                        <tr>
                                                                                <td bgcolor="#516375" class="style16"><div align="center" class="style37"><strong><a href="pgc_flightlog_lookup.php?recordID=<?php echo $row_rsGliders['Glider']; ?>"><?php echo $row_rsGliders['Glider']; ?></a></div></td>
                                                                                <td bgcolor="#516375" class="style16"><div align="center" class="style37"><strong><?php echo $row_rsGliders['Count(Glider)']; ?></div></td>
                                                                                <td bgcolor="#516375" class="style16"><div align="center" class="style37"><strong><?php echo $row_rsGliders['Sum(`Time`)']; ?></div></td>
                                                                        </tr>
                                                                        <?php } while ($row_rsGliders = mysql_fetch_assoc($rsGliders)); ?>
                                                                </table>
                                                                <table width="600" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#7C7C8F">
                                                                        <?php do { ?>
                                                                        <tr>
                                                                                <td width="250" bgcolor="#6B5A67"><div align="center"><strong><span class="style43">TOTALS </span></strong></div></td>
                                                                                <td width="150" bgcolor="#6B5A67"><div align="center"><strong><?php echo $row_rsGLIDERGrandTot['Count(Glider)']; ?> </strong></div>
                                                                                                <div align="center"></div></td>
                                                                                <td bgcolor="#6B5A67"><div align="center"><strong><?php echo $row_rsGLIDERGrandTot['Sum(`Time`)']; ?></strong></div></td>
                                                                        </tr>
                                                                        <?php } while ($row_rsGLIDERGrandTot = mysql_fetch_assoc($rsGLIDERGrandTot)); ?>
                                                        </table></td>
                                        </tr>
                                        <tr>
                                                <td height="100" valign="top">&nbsp;
                                                                <table width="600" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#7C7C8F">
                                                                        <tr>
                                                                                <td width="250" bgcolor="#455463" class="style34"><div align="center" class="style35">PGC INSTRUCTOR </div></td>
                                                                                <td width="150" bgcolor="#455463" class="style34"><div align="center" class="style35">FLIGHTS</div></td>
                                                                                <td bgcolor="#455463" class="style34"><div align="center" class="style35">TOTAL HOURS</div></td>
                                                                        </tr>
                                                                        <?php do { ?>
                                                                        <tr>
                                                                                <td bgcolor="#516375"><div align="center" class="style37"><strong><a href="pgc_flightlog_lookup_cfig.php?recordID=<?php echo $row_rs_instructors['Pilot2']; ?>"><?php echo $row_rs_instructors['Pilot2']; ?></a></strong></div></td>
                                                                                <td bgcolor="#516375"><div align="center" class="style37"><strong><?php echo $row_rs_instructors['Count(Pilot2)']; ?></div></td>
                                                                                <td bgcolor="#516375"><div align="center" class="style37"><strong><?php echo $row_rs_instructors['Sum( `Time`)']; ?></div></td>
                                                                        </tr>
                                                                        <?php } while ($row_rs_instructors = mysql_fetch_assoc($rs_instructors)); ?>
                                                                </table>
                                                        <table width="600" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#7C7C8F">
                                                                        <?php do { ?>
                                                                        <tr>
                                                                                <td width="250" bgcolor="#6B5A67"><div align="center"><strong><span class="style43">TOTALS </span></strong></div></td>
                                                                                <td width="150" bgcolor="#6B5A67"><div align="center"><strong><?php echo $row_rsCFIGgrandTot['Count(Pilot2)']; ?></strong></div></td>
                                                                                <td bgcolor="#6B5A67"><div align="center"><strong><?php echo $row_rsCFIGgrandTot['Sum( `Time`)']; ?></strong></div></td>
                                                                        </tr>
                                                                        <?php } while ($row_rsCFIGgrandTot = mysql_fetch_assoc($rsCFIGgrandTot)); ?>
                                                        </table></td>
                                        </tr>
                                        <tr>
                                                <td height="99" valign="top">&nbsp;
                                                                <table width="600" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#7C7C8F">
                                                                        <tr>
                                                                                <td width="250" bgcolor="#455463" class="style34"><div align="center" class="style35">TOW PILOT</div></td>
                                                                                <td width="150" bgcolor="#455463" class="style34"><div align="center" class="style35">TOWS</div></td>
                                                                                <td bgcolor="#455463" class="style34"><div align="center" class="style35">TOTAL ALTITUDE</div></td>
                                                                        </tr>
                                                                        <?php do { ?>
                                                                        <tr>
                                                                                <td bgcolor="#516375"><div align="center" class="style37"><strong><a href="pgc_flightlog_lookup_towpilot.php?recordID=<?php echo $row_rsTowpilot['Tow Pilot']; ?>"><?php echo $row_rsTowpilot['Tow Pilot']; ?></div></td>
                                                                                <td bgcolor="#516375"><div align="center" class="style37"><strong><?php echo $row_rsTowpilot['Count(`Tow Pilot`)']; ?></div></td>
                                                                                <td bgcolor="#516375"><div align="center" class="style37"><strong><?php echo $row_rsTowpilot['Sum(`Tow Altitude`)']; ?></div></td>
                                                                        </tr>
                                                                        <?php } while ($row_rsTowpilot = mysql_fetch_assoc($rsTowpilot)); ?>
                                                                </table>
                                                        <table width="600" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#7C7C8F">
                                                                        <?php do { ?>
                                                                        <tr>
                                                                                <td width="250" bgcolor="#6B5A67"><div align="center"><span class="style41">TOTALS </span></div></td>
                                                                                <td width="150" bgcolor="#6B5A67"><div align="center"><strong><?php echo $row_rsTowPilotTotal['Count(`Tow Pilot`)']; ?></strong></div></td>
                                                                                <td bgcolor="#6B5A67"><div align="center"><strong><?php echo $row_rsTowPilotTotal['Sum(`Tow Altitude`)']; ?></strong></div></td>
                                                                        </tr>
                                                                        <?php } while ($row_rsTowPilotTotal = mysql_fetch_assoc($rsTowPilotTotal)); ?>
                                                        </table></td>
                                        </tr>
                                        <tr>
                                                <td height="100" valign="top">&nbsp;
                                                                <table width="600" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#7C7C8F">
                                                                        <tr>
                                                                                <td width="250" bgcolor="#455463"><div align="center"><span class="style39">PGC MEMBER</span></div></td>
                                                                                <td width="150" bgcolor="#455463"><div align="center"><span class="style39">FLIGHTS</span></div></td>
                                                                                <td bgcolor="#455463"><div align="center"><span class="style39">TOTAL TIME</span></div></td>
                                                                        </tr>
                                                                        <?php do { ?>
                                                                        <tr>
                                                                                <td bgcolor="#516375"><div align="center" class="style44"><a href="pgc_flightlog_lookup_member.php?recordID=<?php echo $row_rsMembers['Pilot1']; ?>"><?php echo $row_rsMembers['Pilot1']; ?></a></div></td>
                                                                                <td bgcolor="#516375"><div align="center"> <strong><?php echo $row_rsMembers['Count(Glider)']; ?></div></td>
                                                                                <td bgcolor="#516375"><div align="center"><strong><?php echo $row_rsMembers['Sum(`Time`)']; ?></div></td>
                                                                        </tr>
                                                                        <?php } while ($row_rsMembers = mysql_fetch_assoc($rsMembers)); ?>
                                                                </table>
                                                        <table width="600" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#7C7C8F">
                                                                        <?php do { ?>
                                                                        <tr>
                                                                                <td width="250" bgcolor="#6B5A67"><div align="center"><span class="style41">TOTALS </span></div></td>
                                                                                <td width="150" bgcolor="#6B5A67"><div align="center"><strong><?php echo $row_rsMemberGtotals['Count(Glider)']; ?></div></td>
                                                                                <td bgcolor="#6B5A67"><div align="center"><strong><?php echo $row_rsMemberGtotals['Sum(`Time`)']; ?></div></td>
                                                                        </tr>
                                                                        <?php } while ($row_rsMemberGtotals = mysql_fetch_assoc($rsMemberGtotals)); ?>
                                                        </table></td>
                                        </tr>
                        </table></td>
                </tr>
                <tr>
                        <td height="28"><div align="center"><strong class="style3"><a href="../07_members_only_pw.php" class="style46">Back to Members Page</a></strong></div></td>
                </tr>
        </table></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsGliders);

mysql_free_result($rs_instructors);

mysql_free_result($rsTowpilot);

mysql_free_result($rsCFIGgrandTot);

mysql_free_result($rsGLIDERGrandTot);

mysql_free_result($rsTowPilotTotal);

mysql_free_result($rsMembers);

mysql_free_result($rsMemberGtotals);

mysql_free_result($Glider_log);

mysql_free_result($Table_Date);

mysql_free_result($Recordset2);
?>
 