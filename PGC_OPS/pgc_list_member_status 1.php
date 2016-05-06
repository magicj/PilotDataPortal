<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
$_SESSION['last_query'] = $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'];
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 20;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_members ORDER BY NAME ASC";
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
	background-color: #283664;
	background-image: url(../images/Buttons/PGC%20copy.png);
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
	color: #FFFFFF;
	font-weight: bold;
}
.style18 {
	color: #00FF00;
	font-style: italic;
	font-weight: bold;
}
.style351 {color: #8CA6D8; font-style: italic; font-weight: bold; font-family: Arial, Helvetica, sans-serif; }
.style20 {color: #8CA6D8; font-style: italic; font-weight: bold; font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.style21 {color: #FF0000}
.style22 {color: #00FF00}
-->
</style></head>

<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
  <tr>
    <td><div align="center"><span class="style1">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="514"><table width="92%" height="448" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#464E62">
      <tr>
        <td height="44"><div align="center">
              <p><span class="style11">MODIFY MEMBER ACTIVE STATUS</span><span class="style22"></span></p>
              <p>Select E-mail address to edit record</p>
        </div></td>
      </tr>
      <tr>
        <td height="373"><table align="center" cellpadding="2" cellspacing="2" bgcolor="#7D8A89">
            <tr>
              <td width="196" align="center" bgcolor="#3D4461"><span class="style351">E-MAIL</span></td>
              <td width="146" align="center" bgcolor="#3D4461"><em class="style351"><strong>NAME</strong></em></td>
              <td width="165" align="center" bgcolor="#3D4461"><em class="style351"><strong>ACTIVE</strong></em></td>
            </tr>
            <?php do { ?>
              <tr>
                <td bgcolor="#3D4461"><a href="pgc_list_member_status_detail.php?USER_ID=<?php echo $row_Recordset1['USER_ID']; ?>"> <span class="style16"><?php echo $row_Recordset1['USER_ID']; ?></span>&nbsp; </a> </td>
                <td bgcolor="#3D4461"><span class="style17"><span class="style16"><?php echo $row_Recordset1['NAME']; ?></span>&nbsp; </span></td>
<?php
			  $color = "#3D4461"; 
			  if ($row_Recordset1['active'] == "NO") {
			  $color = "style22"; 
			  }
			   if ($row_Recordset1['active'] == "YES") {
			  $color = "style21"; 
			  }
 ?>

				
                <td bgcolor="#3D4461"><div align="center"><span class="style17"><?php echo $row_Recordset1['active']; ?></span>&nbsp; </div></td>
              </tr>
              <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
          </table>
          <br>
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
          </td>
      </tr>
      <tr>
        <td height="21"><div align="center"><strong class="style11"><a href="pgc_portal_menu.php" class="style20"><span class="style20">BACK TO PDP MAINTENANCE MENU</span></a></strong> </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
