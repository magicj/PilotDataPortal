<?php require_once('../Connections/PGC.php');?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
$currentPage = $_SERVER["PHP_SELF"];
$_SESSION[last_query] = $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'];
?>

<?php
if (isset($_GET['pageNum_rsFieldDuty'])) {
  $pageNum_rsFieldDuty = $_GET['pageNum_rsFieldDuty'];
}
$startRow_rsFieldDuty = $pageNum_rsFieldDuty * $maxRows_rsFieldDuty;
$maxRows_rsFieldDuty = 22;
$pageNum_rsFieldDuty = 0;
if (isset($_GET['pageNum_rsFieldDuty'])) {
  $pageNum_rsFieldDuty = $_GET['pageNum_rsFieldDuty'];
}
$startRow_rsFieldDuty = $pageNum_rsFieldDuty * $maxRows_rsFieldDuty;

/* Refresh FM Email Adresses */
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "UPDATE pgc_field_duty t1 INNER JOIN pgc_members t2 ON t1.fm = t2.name SET t1.fm_email = t2.user_id";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());

/* Refresh AFM Email Adresses */
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "UPDATE pgc_field_duty t1 INNER JOIN pgc_members t2 ON t1.afm1 = t2.name SET t1.afm1_email = t2.user_id";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());

/* Refresh AFM Email Adresses */
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "UPDATE pgc_field_duty t1 INNER JOIN pgc_members t2 ON t1.afm2 = t2.name SET t1.afm2_email = t2.user_id";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());

/* Refresh AFM Email Adresses */
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "UPDATE pgc_field_duty t1 INNER JOIN pgc_members t2 ON t1.afm3 = t2.name SET t1.afm3_email = t2.user_id";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());


mysql_select_db($database_PGC, $PGC);
$query_rsFieldDuty = "SELECT date, date_format(date,'%m/%d/%y') as mydate, date_format(date,'%W') as daydate, fm, fm_email, afm1, afm1_email, afm2, afm2_email,  afm3, afm3_email, cfig, tp1, tp2, `session` FROM pgc_field_duty WHERE fd_type <> 'midweek' ORDER BY `date` ASC";
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
//$updateSQL = "UPDATE pgc_field_duty SET fm_sub='Open' WHERE fm_sub IS NULL";
//$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
//$updateSQL = "UPDATE pgc_field_duty SET afm1_sub='Open' WHERE afm1_sub IS NULL";
//$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
//$updateSQL = "UPDATE pgc_field_duty SET afm2_sub='Open' WHERE afm2_sub IS NULL";
//$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
//$updateSQL = "UPDATE pgc_field_duty SET afm3_sub='Open' WHERE afm3_sub IS NULL";
//$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

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
	color: #CCCCCC;
	font-size: 14px;
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
.style20 {
	font-size: 16px;
	font-weight: bold;
	color: #FFFFFF;
}
.style24 {
	font-size: 16px;
	font-weight: bold;
	color: #FFFFFF;
}
.style28 {font-size: 12px}
.style23 {
	font-size: 16px;
	font-weight: bold;
	color: #000000;
	font-style: italic;
}
.FDdate
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFF;
	font-weight: bold;
}
-->
</style></head>

<body>
<table width="1200" border="0" align="center" cellpadding="3" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td width="1002"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="359" bgcolor="#3E3E5E"><table width="99%" height="334" border="0" align="center" cellpadding="5" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="25"><div align="center">
            <table width="99%" border="0" cellspacing="2" cellpadding="2">
                <tr>
                      <td bgcolor="#274987"><div align="center"><span class="style24">ADMIN - MAKE FIELD DUTY ASSIGNMENTS</span></div></td>
                </tr>
                </table>
            </div></td>
      </tr>
      
      <tr>
        <td height="186" align="center" valign="top"><form id="form1" name="form1" method="post" action="">
            <p>
            <label></label>
            <table width="98%" border="0" cellpadding="1" cellspacing="2" bgcolor="#666666">
                <tr>
                    <td width="70" bgcolor="#004080"><div align="center"><em><strong>DATE</strong></em></div></td>
                    <td width="70" align="center" bgcolor="#004080"><em><strong>DAY</strong></em></td>
                    <td width="40" bgcolor="#004080"><div align="center"><em><strong>SESSION</strong></em></div></td>
                    <td bgcolor="#00486A"><div align="center"><em><strong>Field Manager</strong></em></div></td>
                    <td bgcolor="#1B1B69"><div align="center"><em><strong>Assistant FM</strong></em></div></td>
                    <td bgcolor="#1B1B69"><div align="center"><em><strong>Assistant FM</strong></em></div></td>
                    <td bgcolor="#1B1B69"><div align="center"><em><strong>Assistant FM</strong></em></div></td>
                    <td bgcolor="#222286"><div align="center" class="style19">Flight Instructor</div></td>
                    <td bgcolor="#363E61"><div align="center" class="style19">Tow Pilot - AM </div></td>
                    <td bgcolor="#363E61"><div align="center" class="style19">Tow Pilot - PM </div></td>
                    </tr>
                <?php do { ?>
                    <tr>
                        <td bgcolor="#004080"><div align="center" class="FDdate"> <a href="pgc_field_duty_update_basic.php?dutydate=<?php echo $row_rsFieldDuty['date'] ; ?>"><?php echo $row_rsFieldDuty['mydate']; ?></a></div></td>
                        <td align="center" bgcolor="#004080"><span class="FDdate"><?php echo $row_rsFieldDuty['daydate']; ?></span></td>
                        <td bgcolor="#004080"><div align="center" class="FDdate"><?php echo $row_rsFieldDuty['session']; ?></div></td>
                        
                        <td bgcolor="#00486A"><div align="center"><a href="mailto:<?php echo $row_rsFieldDuty['fm_email']; ?>"><?php echo $row_rsFieldDuty['fm']; ?></a></div></td>
                                     
                        <td bgcolor="#1B1B69"><div align="center"><a href="mailto:<?php echo $row_rsFieldDuty['afm1_email']; ?>"><?php echo $row_rsFieldDuty['afm1']; ?></a></div></td>
                        <td bgcolor="#1B1B69"><div align="center"><a href="mailto:<?php echo $row_rsFieldDuty['afm2_email']; ?>"><?php echo $row_rsFieldDuty['afm2']; ?></a></div></td>
                        <td bgcolor="#1B1B69"><div align="center"><a href="mailto:<?php echo $row_rsFieldDuty['afm3_email']; ?>"><?php echo $row_rsFieldDuty['afm3']; ?></a></div></td>
                        
                        
                        <td bgcolor="#222286"><div align="center"><?php echo $row_rsFieldDuty['cfig']; ?></div></td>
                        <td bgcolor="#363E61"><div align="center"><?php echo $row_rsFieldDuty['tp1']; ?></div></td>
                        <td bgcolor="#363E61"><div align="center"><?php echo $row_rsFieldDuty['tp2']; ?></div></td>
                        </tr>
                    <?php } while ($row_rsFieldDuty = mysql_fetch_assoc($rsFieldDuty)); ?>
            </table>
            <p>
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
        </form></td>
      </tr>
      <tr>
        <td height="33" bgcolor="#1C3462"><div align="center" class="style20">
            <p><a href="pgc_fd_member_selected_view.php" class="style16">BACK TO FD ADMIN</a></p>
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsFieldDuty);
?>
