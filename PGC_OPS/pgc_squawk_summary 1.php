<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT equip_name FROM pgc_equipment";
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

error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script src="../java/javascripts.js" type="text/javascript"></script>
<script src="../java/CalendarPopup.js" type="text/javascript"></script>
<script src="../java/zxml.js" type="text/javascript"></script>
<script src="../java/workingjs.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript" ID="js1">
		var cal = new CalendarPopup();
	 </SCRIPT>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC EQUIPMENT SQUAWK</title>
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
.style16 {color: #CCCCCC; }
a:link {
	color: #CCCCCC;
}
a:visited {
	color: #CCCCCC;
}
.style17 {
	color: #CCCCCC;
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
.style42 {
	font-size: 16px;
	font-weight: bold;
	font-style: italic;
}
.style45 {color: #FFFFFF}
-->
</style>
</head>
<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
      <tr>
            <td align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="398" bgcolor="#666666"><table width="900" height="533" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#005B5B">
                        <tr>
                          <td width="1562" height="23" valign="top" bgcolor="#0A335C"><div align="center"><span class="style42">SQUAWK METRICS  </span></div></td>
                        </tr>
                        <tr>
                          <td height="277" align="center" valign="top" bgcolor="#0A335C"><p>&nbsp;</p>
                                  
                            <table cellpadding="4" cellspacing="3" bgcolor="#A2B3B3">
                              <tr>
                                <td bgcolor="#35415B" class="style17 style45"><div align="center">EQUIPMENT</div></td>
                                <td width="80" bgcolor="#35415B" class="style17 style45"><div align="center">NEW</div></td>
                                <td width="80" bgcolor="#35415B" class="style17 style45"><div align="center">OPEN</div></td>
                                <td width="80" bgcolor="#35415B" class="style17 style45"><div align="center">PENDING</div></td>
                                <td width="80" bgcolor="#35415B" class="style17 style45"><div align="center">COMPLETED</div></td>
                                <td width="80" bgcolor="#35415B" class="style17 style45"><div align="center">TOTAL $ </div></td>
                                <td width="80" bgcolor="#35415B" class="style17 style45"><div align="center">TOTAL HRS </div></td>
                                <td width="80" bgcolor="#35415B" class="style17 style45"><div align="center">STATUS</div></td>
                              </tr>
                              <?php do { ?>
                                <tr>
                                  <td bgcolor="#48597B"><div align="left" class="style17"><?php echo $row_Recordset1['equip_name']; ?></div></td>
                                  <td bgcolor="#48597B">&nbsp;</td>
                                  <td bgcolor="#48597B">&nbsp;</td>
                                  <td bgcolor="#48597B">&nbsp;</td>
                                  <td bgcolor="#48597B">&nbsp;</td>
                                  <td bgcolor="#48597B">&nbsp;</td>
                                  <td bgcolor="#48597B">&nbsp;</td>
                                  <td bgcolor="#48597B"><div align="center" class="style17">In Service </div></td>
                                </tr>
                                <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                            </table>
                          </p></td>
                        </tr>
                        <tr>
                              <td height="30" bgcolor="#4F5359" class="style16"><div align="center"><a href="pgc_squawk_view.php" class="style17">BACK TO SQUAWK VIEW PAGE</a></div></td>
                        </tr>
                  </table></td>
      </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>

