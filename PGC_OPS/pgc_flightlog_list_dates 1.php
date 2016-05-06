<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
$_SESSION['$Logdate'] = date("Y-m-d"); ?>
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

$maxRows_Flightlog = 10;
$pageNum_Flightlog = 0;
if (isset($_GET['pageNum_Flightlog'])) {
  $pageNum_Flightlog = $_GET['pageNum_Flightlog'];
}
$startRow_Flightlog = $pageNum_Flightlog * $maxRows_Flightlog;

$colname_Flightlog = "-1";
if (isset($_SESSION['$Logdate'])) {
  $colname_Flightlog = (get_magic_quotes_gpc()) ? $_SESSION['$Logdate'] : addslashes($_SESSION['$Logdate']);
}
mysql_select_db($database_PGC, $PGC);
$query_Flightlog = sprintf("SELECT * FROM pgc_flightsheet WHERE `Date` = %s ORDER BY `Key` DESC", GetSQLValueString($colname_Flightlog, "date"));
$query_limit_Flightlog = sprintf("%s LIMIT %d, %d", $query_Flightlog, $startRow_Flightlog, $maxRows_Flightlog);
$Flightlog = mysql_query($query_limit_Flightlog, $PGC) or die(mysql_error());
$row_Flightlog = mysql_fetch_assoc($Flightlog);

if (isset($_GET['totalRows_Flightlog'])) {
  $totalRows_Flightlog = $_GET['totalRows_Flightlog'];
} else {
  $all_Flightlog = mysql_query($query_Flightlog);
  $totalRows_Flightlog = mysql_num_rows($all_Flightlog);
}
$totalPages_Flightlog = ceil($totalRows_Flightlog/$maxRows_Flightlog)-1;

mysql_select_db($database_PGC, $PGC);
$query_rsDates = "SELECT DISTINCT `Date` FROM pgc_flightsheet ORDER BY `Date` ASC";
$rsDates = mysql_query($query_rsDates, $PGC) or die(mysql_error());
$row_rsDates = mysql_fetch_assoc($rsDates);
$totalRows_rsDates = mysql_num_rows($rsDates);

$queryString_Flightlog = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Flightlog") == false && 
        stristr($param, "totalRows_Flightlog") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Flightlog = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Flightlog = sprintf("&totalRows_Flightlog=%d%s", $totalRows_Flightlog, $queryString_Flightlog);
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
.style24 {color: #000000}
.style25 {font-size: 18px; font-weight: bold; color: #000000; }
.style27 {font-size: 18px; font-weight: bold; color: #FFFFFF; }
a:link {
	color: #FFFF9B;
}
a:visited {
	color: #FFFF9B;
}
.style28 {color: #339900}
-->
</style>
</head>

<body>
<table width="100%" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
    <tr>
        <td><div align="center">
            <table width="100%">
                <tr>
                    <td width="11%">
					<?php echo($_SESSION['Tow_Plane']); ?><?php echo($_SESSION['Tow_Pilot']); ?>
					
					&nbsp;</td>
                    <td width="9%" bgcolor="#FF9900"><div align="center"><span class="style25"><a href="pgc_flightlog_insert_row.php">ADD ROW </a></span></div></td>
                    <td width="56%"><div align="center"><span class="style1">PGC DATA PORTAL - FLIGHT SHEET for <?php echo $_SESSION['$Logdate'] ?></span></div></td>
                    <td width="9%" bgcolor="#0066FF" class="style25"><div align="center"><a href="pgc_flightsheet-xls.php">XLS </a></div></td>
                    <td width="15%"><label>LogDate
                        <select name="select">
                            <?php
do {  
?>
                            <option value="<?php echo $row_rsDates['Date']?>"><?php echo $row_rsDates['Date']?> <?php $_SESSION['$Logdate'] = $row_rsDates['Date'] ?></option>
                            <?php
} while ($row_rsDates = mysql_fetch_assoc($rsDates));
  $rows = mysql_num_rows($rsDates);
  if($rows > 0) {
      mysql_data_seek($rsDates, 0);
	  $row_rsDates = mysql_fetch_assoc($rsDates);
  }
?>
                        </select>
                    </label></td>
                </tr>
            </table>
            </div></td>
    </tr>
    <tr>
        <td height="481"><table width="100%" height="447" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
            
            <tr>
                <td height="373" valign="top"><table width="99%" align="center" cellpadding="2" cellspacing="2" bgcolor="#000066">
                                <tr>
                                    <td bgcolor="#66CCFF" class="style1 style24"><div align="center">Key</div></td>
                                    <td bgcolor="#66CCFF" class="style25"><div align="center">Glider</div></td>
                                    <td bgcolor="#66CCFF" class="style25"><div align="center">Type</div></td>
                                    <td bgcolor="#66CCFF" class="style25"><div align="center">Member Charged </div></td>
                                    <td bgcolor="#66CCFF" class="style25"><div align="center">Instructor</div></td>
                                    <td width="1" bgcolor="#66CCFF" class="style25"><div align="center"><a href="pgc_flightlog_update_takeoff.php?recordID=<?php echo $row_Flightlog['Key']; ?>"></a></div></td>
                                    <td bgcolor="#66CCFF" class="style25"><div align="center">Takeoff</div></td>
                                    <td width="1" bgcolor="#66CCFF" class="style25"><a href="pgc_flightlog_update_landing.php?recordID=<?php echo $row_Flightlog['Key']; ?>"></a></td>
                                    <td bgcolor="#66CCFF" class="style25"><div align="center">Landing</div></td>
                                    <td bgcolor="#66CCFF" class="style25"><div align="center">Hours</div></td>
                                    <td bgcolor="#66CCFF" class="style25"><div align="center">Tow </div></td>
                                    <td bgcolor="#66CCFF" class="style25"><div align="center">Tug</div></td>
                                    <td bgcolor="#66CCFF" class="style25"><div align="center">Tow Pilot</div></td>
                                    <td bgcolor="#66CCFF" class="style25"><div align="center">Charge</div></td>
                                    <td bgcolor="#66CCFF" class="style25"><div align="center">Notes</div></td>
                                </tr>
                                <?php do { ?>
                                <tr>
                                    <td bgcolor="#999999" class="style25"><div align="center"><a href="pgc_flightlog_update.php?recordID=<?php echo $row_Flightlog['Key']; ?>"><?php echo $row_Flightlog['Key']; ?></div></td>
                                    <td bgcolor="#FFFFFF" class="style25"><?php echo $row_Flightlog['Glider']; ?></td>
                                    <td bgcolor="#FFFFFF" class="style25"><div align="center"><?php echo $row_Flightlog['Flight_Type']; ?></div></td>
                                    <td bgcolor="#FFFFFF" class="style25"><?php echo $row_Flightlog['Pilot1']; ?></td>
                                    <td bgcolor="#FFFFFF" class="style25"><?php echo $row_Flightlog['Pilot2']; ?></td>
                                    <td bgcolor="#FFFFFF" class="style25"><div align="center"><a href="pgc_flightlog_update_takeoff.php?recordID=<?php echo $row_Flightlog['Key']; ?>"><img src="flightlog images/Takeoff.jpg" alt="Takeoff" width="25" height="24" border="0" /></a></div></td>
                                    <td bgcolor="#FFFFFF" class="style25"><div align="center"><?php echo $row_Flightlog['Takeoff']; ?></div></td>
                                    <td bgcolor="#FFFFFF" class="style25"><a href="pgc_flightlog_update_landing.php?recordID=<?php echo $row_Flightlog['Key']; ?>"><img src="flightlog images/Landing.jpg" alt="Land" width="25" height="24" border="0" /></a></td>
                                    <td bgcolor="#FFFFFF" class="style25"><div align="center"><?php echo $row_Flightlog['Landing']; ?></div></td>
                                    <td bgcolor="#FFFFFF" class="style25"><div align="center"><?php echo $row_Flightlog['Time']; ?></div></td>
                                    <td bgcolor="#FFFFFF" class="style25"><div align="center"><?php echo $row_Flightlog['Tow Altitude']; ?></div></td>
                                    <td bgcolor="#FFFFFF" class="style25"><div align="center"><?php echo $row_Flightlog['Tow Plane']; ?></div>                                    </td>
                                    <td bgcolor="#FFFFFF" class="style25"><?php echo $row_Flightlog['Tow Pilot']; ?></td>
                                    <td bgcolor="#FFFFFF" class="style25"><?php echo $row_Flightlog['Tow Charge']; ?></td>
                                    <td bgcolor="#FFFFFF" class="style25"><?php echo $row_Flightlog['Notes']; ?></td>
                                </tr>
                                <?php } while ($row_Flightlog = mysql_fetch_assoc($Flightlog)); ?>
                            </table>
                    <p>
                                <!--<form action="somewhere.php" method="post">
*/</form>

<p>&nbsp;</p>
-->
                    <table border="0" width="50%" align="center">
                        <tr>
                            <td width="23%" align="center" class="style27"><?php if ($pageNum_Flightlog > 0) { // Show if not first page ?>
                                        <span class="style1"><strong><a href="<?php printf("%s?pageNum_Flightlog=%d%s", $currentPage, 0, $queryString_Flightlog); ?>">Top</a>
                                        <?php } // Show if not first page ?></td>
                            <td width="31%" align="center" class="style27"><?php if ($pageNum_Flightlog > 0) { // Show if not first page ?>
                                        <a href="<?php printf("%s?pageNum_Flightlog=%d%s", $currentPage, max(0, $pageNum_Flightlog - 1), $queryString_Flightlog); ?>" class="style1">Previous</a>
                                        <?php } // Show if not first page ?>                            </td>
                            <td width="23%" align="center" class="style27"><?php if ($pageNum_Flightlog < $totalPages_Flightlog) { // Show if not last page ?>
                                        <a href="<?php printf("%s?pageNum_Flightlog=%d%s", $currentPage, min($totalPages_Flightlog, $pageNum_Flightlog + 1), $queryString_Flightlog); ?>">Next</a>
                                        <?php } // Show if not last page ?>                            </td>
                            <td width="23%" align="center" class="style27"><?php if ($pageNum_Flightlog < $totalPages_Flightlog) { // Show if not last page ?>
                                        <a href="<?php printf("%s?pageNum_Flightlog=%d%s", $currentPage, $totalPages_Flightlog, $queryString_Flightlog); ?>">Bottom</a>
                                        <?php } // Show if not last page ?>                            </td>
                        </tr>
                    </table>
                    </p></td>
            </tr>
            <tr>
                <td height="28"><div align="center"><strong class="style3"><a class="style16">TBD</a></strong></div></td>
            </tr>
        </table></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Flightlog);

mysql_free_result($rsDates);
?>