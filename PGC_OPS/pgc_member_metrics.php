<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
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
$query_rsGliders = "SELECT Glider, Count(Glider), Sum(`Time`) FROM pgc_flightsheet WHERE Pilot1 <> '' AND Glider <> '' GROUP BY Glider";
$rsGliders = mysql_query($query_rsGliders, $PGC) or die(mysql_error());
$row_rsGliders = mysql_fetch_assoc($rsGliders);
$totalRows_rsGliders = mysql_num_rows($rsGliders);

mysql_select_db($database_PGC, $PGC);
$query_rs_instructors = "SELECT Pilot2, Count(Pilot2), Sum( `Time`) FROM pgc_flightsheet WHERE Pilot2 <> '' AND Glider <> '' GROUP BY Pilot2";
$rs_instructors = mysql_query($query_rs_instructors, $PGC) or die(mysql_error());
$row_rs_instructors = mysql_fetch_assoc($rs_instructors);
$totalRows_rs_instructors = mysql_num_rows($rs_instructors);

mysql_select_db($database_PGC, $PGC);
$query_rsTowpilot = "SELECT `Tow Pilot`, Count(`Tow Pilot`),Sum(`Tow Altitude`)  FROM pgc_flightsheet WHERE Pilot1 <> '' AND Glider <> '' GROUP BY `Tow Pilot`  ";
$rsTowpilot = mysql_query($query_rsTowpilot, $PGC) or die(mysql_error());
$row_rsTowpilot = mysql_fetch_assoc($rsTowpilot);
$totalRows_rsTowpilot = mysql_num_rows($rsTowpilot);

mysql_select_db($database_PGC, $PGC);
$query_rsCFIGgrandTot = "SELECT Count(Pilot2), Sum( `Time`) FROM pgc_flightsheet WHERE Pilot2 <> '' AND Glider <> '' ";
$rsCFIGgrandTot = mysql_query($query_rsCFIGgrandTot, $PGC) or die(mysql_error());
$row_rsCFIGgrandTot = mysql_fetch_assoc($rsCFIGgrandTot);
$totalRows_rsCFIGgrandTot = mysql_num_rows($rsCFIGgrandTot);

mysql_select_db($database_PGC, $PGC);
$query_rsGLIDERGrandTot = "SELECT Count(Glider), Sum(`Time`) FROM pgc_flightsheet WHERE Pilot1 <> '' AND Glider <> '' ";
$rsGLIDERGrandTot = mysql_query($query_rsGLIDERGrandTot, $PGC) or die(mysql_error());
$row_rsGLIDERGrandTot = mysql_fetch_assoc($rsGLIDERGrandTot);
$totalRows_rsGLIDERGrandTot = mysql_num_rows($rsGLIDERGrandTot);

mysql_select_db($database_PGC, $PGC);
$query_rsTowPilotTotal = "SELECT  Count(`Tow Pilot`),Sum(`Tow Altitude`) FROM pgc_flightsheet WHERE Pilot1 <> '' AND Glider <> '' ";
$rsTowPilotTotal = mysql_query($query_rsTowPilotTotal, $PGC) or die(mysql_error());
$row_rsTowPilotTotal = mysql_fetch_assoc($rsTowPilotTotal);
$totalRows_rsTowPilotTotal = mysql_num_rows($rsTowPilotTotal);

mysql_select_db($database_PGC, $PGC);
$query_rsMembers = "SELECT Pilot1, Count(Glider), Sum(`Time`) FROM pgc_flightsheet WHERE Pilot1 <> '' AND Glider <> '' GROUP BY Pilot1";
$rsMembers = mysql_query($query_rsMembers, $PGC) or die(mysql_error());
$row_rsMembers = mysql_fetch_assoc($rsMembers);
$totalRows_rsMembers = mysql_num_rows($rsMembers);
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
.style25 {font-size: 18px; font-weight: bold; color: #000000; }
a:link {
	color: #FFFF9B;
}
a:visited {
	color: #FFFF9B;
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
-->
</style>
</head>

<body>
<table width="800" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
    <tr>
        <td><div align="center">
            <table width="100%">
                <tr>
                    <td width="11%">&nbsp;</td>
                  <td width="9%"><div align="center"></div></td>
                    <td width="59%"><div align="center"><span class="style1">PGC DATA PORTAL - 2010 FLIGHT SHEET METRICS </span></div></td>
                  <td width="9%" class="style25"><div align="center"></div></td>
                    <td width="12%">&nbsp;</td>
                </tr>
            </table>
            </div></td>
    </tr>
    <tr>
        <td height="481"><table width="100%" height="427" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
            
            <tr>
                <td height="389" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top"><table width="600" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#7C7C8F">
                            <tr>
                                <td width="250" bgcolor="#455463" class="style34"><div align="center" >PGC GLIDER </div></td>
                                <td width="150" bgcolor="#455463" class="style34"><div align="center" class="style35">FLIGHTS</div></td>
                                <td bgcolor="#455463" class="style34"><div align="center" class="style35">TOTAL HOURS </div></td>
                            </tr>
                            <?php do { ?>
                            <tr>
                                <td bgcolor="#516375" class="style16"><div align="center" class="style37"><strong><?php echo $row_rsGliders['Glider']; ?></div></td>
                                <td bgcolor="#516375" class="style16"><div align="center" class="style37"><strong><?php echo $row_rsGliders['Count(Glider)']; ?></div></td>
                                <td bgcolor="#516375" class="style16"><div align="center" class="style37"><strong><?php echo $row_rsGliders['Sum(`Time`)']; ?></div></td>
                            </tr>
                            <?php } while ($row_rsGliders = mysql_fetch_assoc($rsGliders)); ?>
                        </table>
                            <table width="600" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#7C7C8F">
                                
                                <?php do { ?>
                                    <tr>
                                        <td width="250" bgcolor="#6B5A67"><div align="center"><strong><span class="style43">TOTALS </span></strong></div></td>
                                        <td width="150" bgcolor="#6B5A67"><div align="center"><strong><?php echo $row_rsGLIDERGrandTot['Count(Glider)']; ?>
                                        </strong></div>
                                            <div align="center"></div></td>
                                        <td bgcolor="#6B5A67"><div align="center"><strong><?php echo $row_rsGLIDERGrandTot['Sum(`Time`)']; ?></strong></div>                                            </td>
                                    </tr>
                                    <?php } while ($row_rsGLIDERGrandTot = mysql_fetch_assoc($rsGLIDERGrandTot)); ?>
                            </table>                            </td>
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
                                        <td bgcolor="#516375"><div align="center" class="style37"><strong><?php echo $row_rs_instructors['Pilot2']; ?></strong></div></td>
                                        <td bgcolor="#516375"><div align="center" class="style37"><strong><?php echo $row_rs_instructors['Count(Pilot2)']; ?></div></td>
                                        <td bgcolor="#516375"><div align="center" class="style37"><strong><?php echo $row_rs_instructors['Sum( `Time`)']; ?></div></td>
                                    </tr>
                                    <?php } while ($row_rs_instructors = mysql_fetch_assoc($rs_instructors)); ?>
                            </table>
                            <table width="600" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#7C7C8F">
                                
                                <?php do { ?>
                                <tr>
                                    <td width="250" bgcolor="#6B5A67"><div align="center"><strong><span class="style43">TOTALS </span></strong></div></td>
                                    <td width="150" bgcolor="#6B5A67"><div align="center"><strong><?php echo $row_rsCFIGgrandTot['Count(Pilot2)']; ?></strong></div>                                        </td>
                                    <td bgcolor="#6B5A67"><div align="center"><strong><?php echo $row_rsCFIGgrandTot['Sum( `Time`)']; ?></strong></div>                                        </td>
                                </tr>
                                <?php } while ($row_rsCFIGgrandTot = mysql_fetch_assoc($rsCFIGgrandTot)); ?>
                            </table>                            </td>
                    </tr>
                    <tr>
                        <td height="99">&nbsp;
                            <table width="600" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#7C7C8F">
                                <tr>
								<td width="250" bgcolor="#455463" class="style34"><div align="center" class="style35">TOW PILOT</div></td>
                                <td width="150" bgcolor="#455463" class="style34"><div align="center" class="style35">TOWS</div></td>
								<td bgcolor="#455463" class="style34"><div align="center" class="style35">TOTAL ALTITUDE</div></td>
                                </tr>
                                <?php do { ?>
                                    <tr>
                                        <td bgcolor="#516375"><div align="center" class="style37"><strong><?php echo $row_rsTowpilot['Tow Pilot']; ?></div></td>
                                        <td bgcolor="#516375"><div align="center" class="style37"><strong><?php echo $row_rsTowpilot['Count(`Tow Pilot`)']; ?></div></td>
                                        <td bgcolor="#516375"><div align="center" class="style37"><strong><?php echo $row_rsTowpilot['Sum(`Tow Altitude`)']; ?></div></td>
                                    </tr>
                                    <?php } while ($row_rsTowpilot = mysql_fetch_assoc($rsTowpilot)); ?>
                            </table>
                            
                            <table width="600" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#7C7C8F">
                                
                                <?php do { ?>
                                    <tr>
                                        <td width="250" bgcolor="#6B5A67"><div align="center"><span class="style41">TOTALS </span></div></td>
                                        <td width="150" bgcolor="#6B5A67"><div align="center"><strong><?php echo $row_rsTowPilotTotal['Count(`Tow Pilot`)']; ?></strong></div>                                            </td>
                                        <td bgcolor="#6B5A67"><div align="center"><strong><?php echo $row_rsTowPilotTotal['Sum(`Tow Altitude`)']; ?></strong></div>                                            </td>
                                    </tr>
                                    <?php } while ($row_rsTowPilotTotal = mysql_fetch_assoc($rsTowPilotTotal)); ?>
                            </table>                            </td>
                    </tr>
                    <tr>
                        <td height="99" valign="top">&nbsp;
                            <table width="600" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#7C7C8F">
                                <tr>
                                    <td bgcolor="#455463"><div align="center"><span class="style39">PGC MEMBER</span></div></td>
                                    <td bgcolor="#455463"><div align="center"><span class="style39">FLIGHTS</span></div></td>
                                    <td bgcolor="#455463"><div align="center"><span class="style39">TOTAL TIME</span></div></td>
                                </tr>
                                <?php do { ?>
                                    <tr>
                                        <td bgcolor="#516375"><div align="center" class="style44"><?php echo $row_rsMembers['Pilot1']; ?></div></td>
                                        <td bgcolor="#516375"><div align="center"> <?php echo $row_rsMembers['Count(Glider)']; ?></div>                                            </td>
                                        <td bgcolor="#516375"><div align="center"><?php echo $row_rsMembers['Sum(`Time`)']; ?></div>                                            </td>
                                    </tr>
                                    <?php } while ($row_rsMembers = mysql_fetch_assoc($rsMembers)); ?>
                            </table></td>
                    </tr>
                    
                </table>                
                <p>
                                <!--<form action="somewhere.php" method="post">
*/</form>

<p>&nbsp;</p>
-->
                    </p></td>
            </tr>
            <tr>
                <td height="28"><div align="center"><strong class="style3"><a href="../07_members_only_pw.php" class="style16">Back to Members Page</a></strong></div></td>
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
?>
 