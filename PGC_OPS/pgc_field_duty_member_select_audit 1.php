<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php');
if (isset($_POST['member_name'])) {
$_SESSION['member_name'] = $_POST['member_name'];
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 15;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_SESSION['member_name'])) {
  $colname_Recordset1 = $_SESSION['member_name'];
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_field_duty_selections_audit WHERE member_name = %s ORDER BY modified_date DESC", GetSQLValueString($colname_Recordset1, "text"));
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

mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = "SELECT DISTINCT member_name FROM pgc_field_duty_selections_audit ORDER BY member_name ASC";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

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
<title>PGC Data Portal</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
body {
	background-color: #283664;
	background-image: url(../images/Buttons/PGC%20copy.png);
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style16 {
	color: #F5F5F5;
	font-size: 16px;
}
a:link {	color: #E6E3DF;
}
a:visited {
	color: #E6E3DF;}
a:active {
	color: #FFFFCC;
}
.style19 {color: #CCCCCC; font-style: italic; font-weight: bold; }
.style20 {	font-size: 16px;
	font-weight: bold;
	color: #FFCCCC;
}
.style24 {font-size: 16px; font-weight: bold; color: #CCCCCC; }
.style28 {font-size: 12px}
.style23 {font-size: 16px; font-weight: bold; color: #FFCCCC; font-style: italic; }
.style44 {color: #999999;
	font-weight: bold;
}
.style32 {font-weight: bold; color: #000000; }
.style43 {font-size: 16px; }
#form1 table tr .style20
{
	color: #FFF;
}
.SessionTitles
{
	color: #000000;
	font-size: 16px;
}
.FDtext
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #000;
}
-->
</style></head>

<body>
<p>&nbsp;</p>
<table width="1000" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td width="968"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="190" bgcolor="#3E3E5E"><table width="99%" height="186" border="0" align="center" cellpadding="5" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="25"><div align="center">
            <table width="99%" border="0" cellspacing="2" cellpadding="2">
                <tr>
                      <td bgcolor="#333366"><div align="center"><span class="style24">FIELD DUTY - MEMBER SELECT AUDIT REPORT</span></div></td>
                </tr>
                </table>
            </div></td>
      </tr>
      
      <tr>
        <td height="108" align="center" valign="top">&nbsp;
              <form id="form1" name="form1" method="post" action="">
                    <label for="member_name"></label>
                    <select name="member_name" id="member_name">
                          <?php
do {  
?>
                          <option value="<?php echo $row_Recordset2['member_name']?>"<?php if (!(strcmp($row_Recordset2['member_name'], $_SESSION['member_name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['member_name']?></option>
                          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
                    </select>
                    <input type="submit" name="button" id="button" value="Submit" />
              </form>
              <p>&nbsp;</p>
              <table width="98%" border="0" cellpadding="3" cellspacing="3">
                    <tr class="style19">
                          <td height="22" align="center" bgcolor="#00274F">audit_key</td>
                          <td align="center" bgcolor="#00274F">member_id</td>
                          <td align="center" bgcolor="#00274F">member_name</td>
                          <td align="center" bgcolor="#00274F">fd_role</td>
                          <td align="center" bgcolor="#00274F">session</td>
                          <td align="center" bgcolor="#00274F">choice1</td>
                          <td align="center" bgcolor="#00274F">choice2</td>
                          <td align="center" bgcolor="#00274F">choice3</td>
                          <td align="center" bgcolor="#00274F">modified_by</td>
                          <td align="center" bgcolor="#00274F">modified_date</td>
                    </tr>
                    <?php do { ?>
                    <tr>
                          <td align="center" bgcolor="#003162"><?php echo $row_Recordset1['audit_key']; ?></td>
                          <td align="center" bgcolor="#003162"><a href="mailto:<?php echo $row_Recordset1['member_id']; ?>"><?php echo $row_Recordset1['member_id']; ?></a></td>
                          <td align="center" bgcolor="#003162"><?php echo $row_Recordset1['member_name']; ?></td>
                          <td align="center" bgcolor="#003162"><?php echo $row_Recordset1['fd_role']; ?></td>
                          <td align="center" bgcolor="#003162"><?php echo $row_Recordset1['session']; ?></td>
                          <td align="center" bgcolor="#003162"><?php echo $row_Recordset1['choice1']; ?></td>
                          <td align="center" bgcolor="#003162"><?php echo $row_Recordset1['choice2']; ?></td>
                          <td align="center" bgcolor="#003162"><?php echo $row_Recordset1['choice3']; ?></td>
                          <td align="center" bgcolor="#003162"><?php echo $row_Recordset1['modified_by']; ?></td>
                          <td align="center" bgcolor="#003162"><?php echo $row_Recordset1['modified_date']; ?></td>
                    </tr>
                    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
              </table>
              <p>&nbsp;              
              
              <table border="0">
                    <tr>
                          <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="First.gif" /></a>
                                      <?php } // Show if not first page ?></td>
                          <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="Previous.gif" /></a>
                                      <?php } // Show if not first page ?></td>
                          <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="Next.gif" /></a>
                                      <?php } // Show if not last page ?></td>
                          <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="Last.gif" /></a>
                                      <?php } // Show if not last page ?></td>
                    </tr>
              </table>
              </p></td>
      </tr>
      <tr>
        <td height="33"><div align="center" class="style20">
            <p><a href="pgc_fd_menu.php" class="style16">BACK TO FD MENU</a></p>
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
