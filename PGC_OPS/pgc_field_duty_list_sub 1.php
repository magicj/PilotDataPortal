<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
$currentPage = $_SERVER["PHP_SELF"];
$_SESSION[last_query] = $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'];

if ( empty($_SESSION[page_msg]) ) {
$_SESSION[page_msg] = "Click on <em><strong><u>Open</u></strong></em> sub positions to volunteer - emails will be sent to all duty members for that day.";
}
?>
<?php
$maxRows_rsFieldDuty = 15;
$pageNum_rsFieldDuty = 0;
if (isset($_GET['pageNum_rsFieldDuty'])) {
  $pageNum_rsFieldDuty = $_GET['pageNum_rsFieldDuty'];
}
$startRow_rsFieldDuty = $pageNum_rsFieldDuty * $maxRows_rsFieldDuty;
mysql_select_db($database_PGC, $PGC);
$query_rsFieldDuty = "SELECT * FROM pgc_field_duty ORDER BY `date` ASC";
$query_limit_rsFieldDuty = sprintf("%s LIMIT %d, %d", $query_rsFieldDuty, $startRow_rsFieldDuty, $maxRows_rsFieldDuty);
$rsFieldDuty = mysql_query($query_limit_rsFieldDuty, $PGC) or die(mysql_error());
$row_rsFieldDuty = mysql_fetch_assoc($rsFieldDuty);

if (isset($_GET['totalRows_rsFieldDuty'])) {
  $totalRows_rsFieldDuty = $_GET['totalRows_rsFieldDuty'];
} else {
  $all_rsFieldDuty = mysql_query($query_rsFieldDuty);
  $totalRows_rsFieldDuty = mysql_num_rows($all_rsFieldDuty);
}
$totalPages_rsFieldDuty = ceil($totalRows_rsFieldDuty/$maxRows_rsFieldDuty)-1;

$queryString_rsFieldDuty = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsFieldDuty") == false && 
        stristr($param, "totalRows_rsFieldDuty") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsFieldDuty = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsFieldDuty = sprintf("&totalRows_rsFieldDuty=%d%s", $totalRows_rsFieldDuty, $queryString_rsFieldDuty);
?>
<?php
// Add Opens where NULL
mysql_select_db($database_PGC, $PGC);
$updateSQL = "UPDATE pgc_field_duty SET fm_sub='Open' WHERE fm_sub IS NULL";
$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
$updateSQL = "UPDATE pgc_field_duty SET afm1_sub='Open' WHERE afm1_sub IS NULL";
$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
$updateSQL = "UPDATE pgc_field_duty SET afm2_sub='Open' WHERE afm2_sub IS NULL";
$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
$updateSQL = "UPDATE pgc_field_duty SET afm3_sub='Open' WHERE afm3_sub IS NULL";
$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

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
	color: #FFFFFF;
}
body {
	background-color: #333333;
}
.style1 {
	font-size: 18px;
	font-weight: bold;
	color: #CCCCCC;
}
.style11 {font-size: 16px; font-weight: bold; }
.style16 {color: #CCCCCC; }
a:link {
	color: #E6E3DF;
}
a:visited {
	color: #E6E3DF;
}
a:active {
	color: #FFFFCC;
}
.style18 {color: #00CCFF; font-style: italic; font-weight: bold; }
.style21 {color: #66FFCC; font-style: italic; font-weight: bold; }
.style24 {font-size: 16px; font-weight: bold; color: #CCCCCC; }
.style26 {font-size: 12px}
-->
</style></head>

<body>
<table width="1100" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td width="1234"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="257"><table width="98%" height="251" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="25"><div align="center">
            <p class="style24"><span class="style11">ADMIN - FIELD DUTY AND SUB ASSIGNMENTS</span></p>
            <p class="style24 style26">(Click on duty date to change assignments) </p>
        </div></td>
      </tr>
      
      <tr>
        <td height="165" align="center" valign="top"><form id="form1" name="form1" method="post" action="">
          <p>&nbsp;</p>
          <table width="98%" cellpadding="3" cellspacing="3" bordercolor="#000000" bgcolor="#666666">
            <tr>
                <td colspan="2" rowspan="2" bgcolor="#4F0000"><div align="center" class="style16"><em><strong>DATE AND SESSION </strong></em></div></td>
                <td colspan="4" bgcolor="#1B1B69"><div align="center" class="style18">CURRENT ASSIGNED FIELD DUTY</div></td>
                <td colspan="4" bgcolor="#254949"><div align="center" class="style21"> MEMBER SELECTED SUB ASSIGNMENTS</div></td>
                </tr>
            <tr>
              <td width="100" bgcolor="#1E1E77"><div align="center" class="style18">FM</div></td>
              <td width="100" bgcolor="#1E1E77"><div align="center" class="style18">AFM</div></td>
              <td width="100" bgcolor="#1E1E77"><div align="center" class="style18">AFM</div></td>
              <td width="100" bgcolor="#1E1E77"><div align="center" class="style18">AFM</div></td>
              <td width="100" bgcolor="#2B5555"><div align="center" class="style21">FM SUB </div></td>
              <td width="100" bgcolor="#2B5555"><div align="center" class="style21">AFM SUB </div></td>
              <td width="100" bgcolor="#2B5555"><div align="center" class="style21">AFM SUB </div></td>
              <td width="100" bgcolor="#2B5555"><div align="center" class="style21">AFM SUB </div></td>
            </tr>
            <?php do { ?>
            <tr>
              <td width="75" bgcolor="#4F0000"><span class="style16"><a href="pgc_field_duty_update_detail.php?dutydate=<?php echo $row_rsFieldDuty['date'] ; ?>"><?php echo $row_rsFieldDuty['date']; ?></a></span></td>
              <td width="10" bgcolor="#4F0000"><span class="style16"><?php echo $row_rsFieldDuty['session']; ?></span></td>
              <td bgcolor="#1E1E77"><div align="center" class="style16"><?php echo $row_rsFieldDuty['fm']; ?></div></td>
              <td bgcolor="#1E1E77"><div align="center" class="style16"><?php echo $row_rsFieldDuty['afm1']; ?></div></td>
              <td bgcolor="#1E1E77"><div align="center" class="style16"><?php echo $row_rsFieldDuty['afm2']; ?></div></td>
              <td bgcolor="#1E1E77"><div align="center" class="style16"><?php echo $row_rsFieldDuty['afm3']; ?></div></td>
              <td bgcolor="#2B5555"><div align="center" class="style16"><?php echo $row_rsFieldDuty['fm_sub']; ?></div></td>
              <td bgcolor="#2B5555"><div align="center" class="style16"><?php echo $row_rsFieldDuty['afm1_sub']; ?></div></td>
              <td bgcolor="#2B5555"><div align="center" class="style16"><?php echo $row_rsFieldDuty['afm2_sub']; ?></div></td>

              <td bgcolor="#2B5555"><div align="center" class="style16"><?php echo $row_rsFieldDuty['afm3_sub']; ?></div></td>
            </tr>
            <?php } while ($row_rsFieldDuty = mysql_fetch_assoc($rsFieldDuty)); ?>
          </table>
          <p>
            <label></label>
          <table border="0" width="40%" align="center">
            <tr>
              <td width="23%" align="center"><?php if ($pageNum_rsFieldDuty > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsFieldDuty=%d%s", $currentPage, 0, $queryString_rsFieldDuty); ?>"><em><strong>First</strong></em></a>
                    <?php } // Show if not first page ?>              </td>
              <td width="31%" align="center"><?php if ($pageNum_rsFieldDuty > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsFieldDuty=%d%s", $currentPage, max(0, $pageNum_rsFieldDuty - 1), $queryString_rsFieldDuty); ?>"><em><strong>Previous</strong></em></a>
                    <?php } // Show if not first page ?>              </td>
              <td width="23%" align="center"><?php if ($pageNum_rsFieldDuty < $totalPages_rsFieldDuty) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsFieldDuty=%d%s", $currentPage, min($totalPages_rsFieldDuty, $pageNum_rsFieldDuty + 1), $queryString_rsFieldDuty); ?>"><em><strong>Next</strong></em></a>
                    <?php } // Show if not last page ?>              </td>
              <td width="23%" align="center"><?php if ($pageNum_rsFieldDuty < $totalPages_rsFieldDuty) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsFieldDuty=%d%s", $currentPage, $totalPages_rsFieldDuty, $queryString_rsFieldDuty); ?>"><em><strong>Last</strong></em></a>
                    <?php } // Show if not last page ?>              </td>
            </tr>
          </table>
          </p>
        </form>        </td>
      </tr>
      <tr>
        <td height="21"><div align="center"><strong class="style11"><a href="../PGC_OPS/pgc_fd_menu.php" class="style16">BACK TO FD MENU</a></strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsFieldDuty);
?>
