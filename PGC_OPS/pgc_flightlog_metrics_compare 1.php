<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php  
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
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

mysql_select_db($database_PGC, $PGC);
$totalRows_FlightsCurrent = mysql_num_rows($FlightsCurrent);mysql_select_db($database_PGC, $PGC);
$query_FlightsCurrent = "SELECT '2014' ,Count(Glider), Sum(`Time`) FROM pgc_flightsheet WHERE (Pilot1 <> '' OR Pilot2 <> '') AND Glider <> ''";
$FlightsCurrent = mysql_query($query_FlightsCurrent, $PGC) or die(mysql_error());
$row_FlightsCurrent = mysql_fetch_assoc($FlightsCurrent);
$totalRows_FlightsCurrent = mysql_num_rows($FlightsCurrent);


mysql_select_db($database_PGC, $PGC);
$query_Flights2013 = "SELECT '2013', Count(Glider), Sum(`Time`) FROM pgc_flightsheet_2013 WHERE (Pilot1 <> '' OR Pilot2 <> '') AND Glider <> '' AND `Date` <=  DATE_SUB(CURDATE(),INTERVAL 1 YEAR)";
$Flights2013 = mysql_query($query_Flights2013, $PGC) or die(mysql_error());
$row_Flights2013 = mysql_fetch_assoc($Flights2013);
$totalRows_Flights2013 = mysql_num_rows($Flights2013);

mysql_select_db($database_PGC, $PGC);
$query_Flights2012 = "SELECT '2012', Count(Glider), Sum(`Time`) FROM pgc_flightsheet_2012 WHERE (Pilot1 <> '' OR Pilot2 <> '') AND Glider <> '' AND `Date` <=  DATE_SUB(CURDATE(),INTERVAL 2 YEAR)";
$Flights2012 = mysql_query($query_Flights2012, $PGC) or die(mysql_error());
$row_Flights2012 = mysql_fetch_assoc($Flights2012);
$totalRows_Flights2012 = mysql_num_rows($Flights2012);

mysql_select_db($database_PGC, $PGC);
$query_Flights2011 = "SELECT '2011', Count(Glider), Sum(`Time`) FROM pgc_flightsheet_2011 WHERE (Pilot1 <> '' OR Pilot2 <> '') AND Glider <> '' AND `Date` <=  DATE_SUB(CURDATE(),INTERVAL 3 YEAR)";
$Flights2011 = mysql_query($query_Flights2011, $PGC) or die(mysql_error());
$row_Flights2011 = mysql_fetch_assoc($Flights2011);
$totalRows_Flights2011 = mysql_num_rows($Flights2011);

?>
 
 
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
                            <td width="20%">&nbsp; </td>
                    </tr>
                    <tr>
                            <td><div align="center"><strong class="style3"><a href="../07_members_only_pw.php" class="style45">Members Page</a></strong></div></td>
                            <td><div align="center"><span class="style1"><?php echo $_SESSION['$flight_year']. " " ?>FLIGHT SHEET METRICS (v2) </span></div></td>
                            <td><form id="form1" name="form1" method="get" action="pgc_flightlog_metrics.php">
                                     
                             
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
                                                <td height="188" valign="top">&nbsp;
                                                      <p>&nbsp;</p>
                                                      <table border="0" align="center" cellpadding="2" cellspacing="2">
                                                            <tr>
                                                                  <td colspan="3">Flights To Date - Realtime Seasonal Comparison</td>
                                                            </tr>
                                                            <tr>
                                                                  <td width="117">Season</td>
                                                                  <td width="113">Total Flights To Date</td>
                                                                  <td width="93">Total Time </td>
                                                            </tr>
                                                            <?php do { ?>
                                                                  <tr>
                                                                        <td><?php echo $row_FlightsCurrent['2014']; ?></td>
                                                                        <td><?php echo $row_FlightsCurrent['Count(Glider)']; ?></td>
                                                                        <td><?php echo $row_FlightsCurrent['Sum(`Time`)']; ?></td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td height="22"><?php echo $row_Flights2013['2013']; ?></td>
                                                                        <td><?php echo $row_Flights2013['Count(Glider)']; ?></td>
                                                                        <td><?php echo $row_Flights2013['Sum(`Time`)']; ?></td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td><?php echo $row_Flights2012['2012']; ?></td>
                                                                        <td><?php echo $row_Flights2012['Count(Glider)']; ?></td>
                                                                        <td><?php echo $row_Flights2012['Sum(`Time`)']; ?></td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td><?php echo $row_Flights2011['2011']; ?></td>
                                                                        <td><?php echo $row_Flights2011['Count(Glider)']; ?></td>
                                                                        <td><?php echo $row_Flights2011['Sum(`Time`)']; ?></td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td>&nbsp;</td>
                                                                        <td>&nbsp;</td>
                                                                        <td>&nbsp;</td>
                                                                  </tr>
                                                                  <?php } while ($row_FlightsCurrent = mysql_fetch_assoc($FlightsCurrent)); ?>
                                                </table></td>
                                        </tr>
                                        <tr>
                                                <td height="100" valign="top">&nbsp;
                                                      <table border="0" cellpadding="2" cellspacing="2">
                                                            <tr>
                                                                  <td>2013</td>
                                                                  <td>Count(Glider)</td>
                                                                  <td>Sum(`Time`)</td>
                                                            </tr>
                                                            <?php do { ?>
                                                                  <tr>
                                                                        <td height="22"><?php echo $row_Flights2013['2013']; ?></td>
                                                                        <td><?php echo $row_Flights2013['Count(Glider)']; ?></td>
                                                                        <td><?php echo $row_Flights2013['Sum(`Time`)']; ?></td>
                                                                  </tr>
                                                                  <?php } while ($row_Flights2013 = mysql_fetch_assoc($Flights2013)); ?>
                                                      </table></td>
                                        </tr>
                                        <tr>
                                                <td height="99" valign="top">&nbsp;
                                                      <table border="0" cellpadding="2" cellspacing="2">
                                                            <tr>
                                                                  <td>2012</td>
                                                                  <td>Count(Glider)</td>
                                                                  <td>Sum(`Time`)</td>
                                                            </tr>
                                                            <?php do { ?>
                                                                  <tr>
                                                                        <td><?php echo $row_Flights2012['2012']; ?></td>
                                                                        <td><?php echo $row_Flights2012['Count(Glider)']; ?></td>
                                                                        <td><?php echo $row_Flights2012['Sum(`Time`)']; ?></td>
                                                                  </tr>
                                                                  <?php } while ($row_Flights2012 = mysql_fetch_assoc($Flights2012)); ?>
                                                      </table></td>
                                        </tr>
                                        <tr>
                                                <td height="100" valign="top">&nbsp;
                                                      <table border="0" cellpadding="2" cellspacing="2">
                                                            <tr>
                                                                  <td>2011</td>
                                                                  <td>Count(Glider)</td>
                                                                  <td>Sum(`Time`)</td>
                                                            </tr>
                                                            <?php do { ?>
                                                                  <tr>
                                                                        <td><?php echo $row_Flights2011['2011']; ?></td>
                                                                        <td><?php echo $row_Flights2011['Count(Glider)']; ?></td>
                                                                        <td><?php echo $row_Flights2011['Sum(`Time`)']; ?></td>
                                                                  </tr>
                                                                  <?php } while ($row_Flights2011 = mysql_fetch_assoc($Flights2011)); ?>
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
mysql_free_result($FlightsCurrent);

mysql_free_result($Flights2013);

mysql_free_result($Flights2012);

mysql_free_result($Flights2011);
?>
