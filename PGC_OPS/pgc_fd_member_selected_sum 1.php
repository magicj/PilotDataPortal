<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
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

$maxRows_Recordset1 = 25;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset3 = "TRUNCATE TABLE pgc_field_duty_selections_detail";
$Recordset3 = mysql_query($query_Recordset3, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
$query_Recordset3 = "INSERT INTO pgc_field_duty_selections_detail(member_name, fd_role, `session`, fd_date) SELECT member_name, fd_role, `session`, choice1 FROM pgc_field_duty_selections";
$Recordset3 = mysql_query($query_Recordset3, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
$query_Recordset3 = "INSERT INTO pgc_field_duty_selections_detail(member_name, fd_role, `session`, fd_date) SELECT member_name, fd_role, `session`, choice2 FROM pgc_field_duty_selections";
$Recordset3 = mysql_query($query_Recordset3, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
$query_Recordset3 = "INSERT INTO pgc_field_duty_selections_detail(member_name, fd_role, `session`, fd_date) SELECT member_name, fd_role, `session`, choice3 FROM pgc_field_duty_selections";
$Recordset3 = mysql_query($query_Recordset3, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_field_duty_selections_detail ORDER BY `session` ASC, fd_date DESC, fd_role ASC";
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
<title>PGC Data Portal</title>
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
.style16 {
	color: #FFFFFF;
	font-size: 16px;
}
a:link {
	color: #E6E3DF;
}
a:visited {
	color: #E6E3DF;
}
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
-->
</style></head>

<body>
<p>&nbsp;</p>
<table width="800" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
      <tr>
    <td width="1002"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="190" bgcolor="#3E3E5E"><table width="99%" height="171" border="0" align="center" cellpadding="5" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="25"><div align="center">
            <table width="99%" border="0" cellspacing="2" cellpadding="2">
                <tr>
                      <td bgcolor="#333366"><div align="center">
                            <p class="style24">FIELD DUTY - MEMBER SELECTED SESSION DUTY DAYS</p>
                            <p class="style24">SESSION / DATE SORT (PROTOTYPE)</p>
                      </div></td>
                </tr>
                </table>
            </div></td>
      </tr>
      
      <tr>
        <td height="93" align="center" valign="top"><table width="600" border="0" cellpadding="2" cellspacing="2">
              <tr class="style20">
                    <td align="center" valign="middle" bgcolor="#003C77">Session</td>
                    <td align="center" valign="middle" bgcolor="#003C77">Date Selected</td>
                    <td align="center" valign="middle" bgcolor="#003C77">Member</td>
                    <td align="center" valign="middle" bgcolor="#003C77">Field Duty Role</td>
                    </tr>
              <?php do { ?>
              <tr>
                    <td align="center" valign="middle" bgcolor="#003C77"><?php echo $row_Recordset1['session']; ?></td>
                    <td align="center" valign="middle" bgcolor="#003C77"><?php echo $row_Recordset1['fd_date']; ?></td>
                    <td align="center" valign="middle" bgcolor="#003C77"><?php echo $row_Recordset1['member_name']; ?></td>
                    <td align="center" valign="middle" bgcolor="#003C77"><?php echo $row_Recordset1['fd_role']; ?></td>
                    </tr>
              <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </table>
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
?>
