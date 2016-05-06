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

$maxRows_Flightlog = 20;
$pageNum_Flightlog = 0;
if (isset($_GET['pageNum_Flightlog'])) {
  $pageNum_Flightlog = $_GET['pageNum_Flightlog'];
}
$startRow_Flightlog = $pageNum_Flightlog * $maxRows_Flightlog;

$colname_Flightlog = "-1";
if (isset($_GET['recordID'])) {
  $colname_Flightlog = (get_magic_quotes_gpc()) ? $_GET['recordID'] : addslashes($_GET['recordID']);
}
mysql_select_db($database_PGC, $PGC);
$query_Flightlog = sprintf("SELECT * FROM pgc_flightsheet WHERE Pilot1 = %s AND Time > 0 ORDER BY `Date` DESC", GetSQLValueString($colname_Flightlog, "text"));
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
.style27 {font-size: 18px; font-weight: bold; color: #FFFFFF; }
a:link {
	color: #FFFF9B;
}
a:visited {
	color: #FFFF9B;
}
.style31 {font-size: 16px; font-weight: bold; color: #000000; }
.style35 {font-size: 14px; color: #A7B5CE; }
.style39 {font-size: 12px; color: #CCCCCC; }
.style40 {font-size: 12px; font-weight: bold; color: #CCCCCC; }
.style41 {font-size: 14px; font-weight: bold; color: #FFFFFF; }
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
                    <td width="59%"><div align="center"><span class="style3">PGC Flight History for ...  <?php echo $_GET['recordID'] ?></span></div></td>
                  <td width="9%" class="style25"><div align="center"></div></td>
                    <td width="12%">&nbsp;</td>
                </tr>
            </table>
            </div></td>
    </tr>
    <tr>
        <td height="196" valign="top"><table width="800" height="192" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
            
            <tr>
                <td height="153" valign="top"><table width="647" align="center" cellpadding="2" cellspacing="2" bgcolor="#36373A">
                                <tr>
                                    <td bgcolor="#35415B" class="style27"><div align="center" class="style35">Date</div></td>
                                    <td bgcolor="#35415B" class="style27"><div align="center" class="style35">Type</div></td>
                                    <td bgcolor="#35415B" class="style27"><div align="center" class="style35">Glider</div></td>
                                    <td bgcolor="#35415B" class="style27"><div align="center" class="style35">Instructor</div></td>
                                    <td bgcolor="#35415B" class="style27"><div align="center"><span class="style35">Notes</span></div></td>
                                </tr>
                                <?php do { ?>
                                <tr>
                                  <td bgcolor="#35415B" class="style31"><div align="center" class="style39"><?php echo $row_Flightlog['Date']; ?></div></td>
                                    <td bgcolor="#35415B" class="style40"><div align="center"><?php echo $row_Flightlog['Flight_Type']; ?></div></td>
                                    <td bgcolor="#35415B" class="style40"><div align="center"><?php echo $row_Flightlog['Glider']; ?></div></td>
                                    <td bgcolor="#35415B" class="style40"><?php echo $row_Flightlog['Pilot2']; ?></td>
                                    <td bgcolor="#35415B" class="style40"><?php echo $row_Flightlog['Notes']; ?></td>
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
                            <td width="23%" align="center" class="style41"><?php if ($pageNum_Flightlog > 0) { // Show if not first page ?>
                                        <span class="style1"><strong><a href="<?php printf("%s?pageNum_Flightlog=%d%s", $currentPage, 0, $queryString_Flightlog); ?>">First</a>
                                <?php } // Show if not first page ?></td>
                            <td width="31%" align="center" class="style41"><?php if ($pageNum_Flightlog > 0) { // Show if not first page ?>
                                        <a href="<?php printf("%s?pageNum_Flightlog=%d%s", $currentPage, max(0, $pageNum_Flightlog - 1), $queryString_Flightlog); ?>"><strong>Previous</strong></a>
                                        <?php } // Show if not first page ?>                            </td>
                            <td width="23%" align="center" class="style41"><?php if ($pageNum_Flightlog < $totalPages_Flightlog) { // Show if not last page ?>
                                        <a href="<?php printf("%s?pageNum_Flightlog=%d%s", $currentPage, min($totalPages_Flightlog, $pageNum_Flightlog + 1), $queryString_Flightlog); ?>">Next</a>
                                        <?php } // Show if not last page ?>                            </td>
                            <td width="23%" align="center" class="style41"><?php if ($pageNum_Flightlog < $totalPages_Flightlog) { // Show if not last page ?>
                                        <a href="<?php printf("%s?pageNum_Flightlog=%d%s", $currentPage, $totalPages_Flightlog, $queryString_Flightlog); ?>">Last</a>
                                        <?php } // Show if not last page ?>                            </td>
                        </tr>
                    </table>
              </p></td>
            </tr>
            <tr>
                <td height="28"><div align="center"><strong class="style3"><a href="pgc_request_list_cfig.php" class="style16">Back to CFIG Request Page</a><a href="../Index.php" class="style16"></a><a href="../Index.php" class="style16"></a></strong></div></td>
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
?>