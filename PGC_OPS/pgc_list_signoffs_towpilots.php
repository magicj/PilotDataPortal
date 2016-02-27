<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_Recordset1 = 37;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_pilot_signoffs A, pgc_members B WHERE A.signoff_type = 'PGC Airplane Annual Checkout' AND (A.pilot_name = B.NAME) AND (B.active = 'YES') ORDER BY A.pilot_name ASC, A.status ASC";
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

$currentPage = $_SERVER["PHP_SELF"];

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
<title>PGC Data Portal - Tow Pilot Signoff List - Expired</title>
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
.style12 {font-size: 14px}
.style13 {font-size: 14px; font-weight: bold; }
.style14 {
	color: #FFFFFF;
	font-weight: bold;
}
.style15 {color: #FFFFFF}
.style16 {color: #CCCCCC; }
-->
</style></head>

<body>
<table width="800" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="476"><table width="92%" height="456" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36"><div align="center"><span class="style11">PGC TOW PILOTS -  ANNUAL AIRPLANE CHECKOUT STATUS</span> </div></td>
      </tr>
      <tr>
        <td height="373" align="center" valign="top">&nbsp;
          <table border="1" cellpadding="2" bordercolor="#530000" bgcolor="#0F4E55">
            <tr>
              <td width="140" bgcolor="#0C3E43" class="style16 style14"><div align="center"><em>Pilot Nmae </em></div></td>
              <td width="230" bgcolor="#0C3E43" class="style16 style14"><div align="center"><em>Signoff Type </em></div></td>
              <td width="99" bgcolor="#0C3E43" class="style16 style14"><div align="center"><em>Date</em></div></td>
              <td width="129" bgcolor="#0C3E43" class="style16 style14"><div align="center"><em>Signer</em></div></td>
              <td width="118" bgcolor="#0C3E43" class="style16 style14"><div align="center"><em>Expires</em></div></td>
              <td width="112" bgcolor="#0C3E43" class="style16 style14"><div align="center"><em>Status</em></div></td>
            </tr>
            <?php do { ?>
              <tr>
                <td height="21"><?php echo $row_Recordset1['pilot_name']; ?></td>
                <td><?php echo $row_Recordset1['signoff_type']; ?></td>
                <td><?php echo $row_Recordset1['signoff_date']; ?></td>
                <td><?php echo $row_Recordset1['instructor']; ?></td>
                <td><?php echo $row_Recordset1['expire_date']; ?></td>
				
				
				
				
							  <?php
			  $color = "#0F4E55"; 
			  if ($row_Recordset1['status'] == "Expired-A") {
			  $color = "#CC0000"; 
			  }
 			  if ($row_Recordset1['status'] == "Expired-B") {
			  $color = "#FF9933"; 
			  }
			   if ($row_Recordset1['status'] == "OK") {
			  $color = "#33CC00"; 
			  }

              ?>
              <td width="60" td bgcolor="<?php echo $color; ?>"><div align="center"><span class="style19"><?php echo $row_Recordset1['status']; ?></span></div></td>
			
				
				
                
              </tr>
			  
			  
			  
			  
			  
			  
              <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
			  
          </table>
          
          <p>
          <table border="0" width="50%" align="center">
            <tr>
              <td width="23%" align="center" class="style13"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>" class="style14">First</a>
                    <?php } // Show if not first page ?>              </td>
              <td width="31%" align="center" class="style13"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>" class="style14">Previous</a>
                    <?php } // Show if not first page ?>              </td>
              <td width="23%" align="center" class="style1 style12"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>" class="style15">Next</a>
                    <?php } // Show if not last page ?>              </td>
              <td width="23%" align="center" class="style13"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>" class="style15">Last</a>
                    <?php } // Show if not last page ?>              </td>
            </tr>
          </table>
          </p></td>
      </tr>
      <tr>
        <td height="37" align="center" valign="top"><strong class="style11"><a href="../PGC_OPS/pgc_portal_menu.php" class="style16">BACK TO MAIN</a> </strong></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
