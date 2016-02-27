<?php require_once('../Connections/xxxPGC.php'); ?>
<?php
/* Disabeled so it can't run */
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Klaus Updates</title>
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
.style16 {color: #CCCCCC; }
.style17 {color: #FFFFCC}
.style18 {
	color: #FFFFCC;
	font-weight: bold;
	font-style: italic;
}
-->
</style></head>

<body>
<table width="800" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="514"><table width="92%" height="440" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36"><div align="center"><span class="style11">YEARLY RESET  </span></div></td>
      </tr>
      <tr>
        <td height="373"><p align="center" class="style18">&nbsp; </p>
          <p align="center" class="style18">THIS MODULE RESETS ALL YEARLY DATES </p>
          <p align="center" class="style18">HARD CODED VALUES </p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td height="21"><div align="center"><strong class="style11"><a href="../PGC_OPS/pgc_portal_menu.php" class="style16">BACK TO MAIN</a></strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php


/* Batch Updates */
mysql_select_db($database_PGC, $PGC);
/* Make sure all members have critical signoffs */
$insertSQL = "INSERT IGNORE INTO pgc_pilot_signoffs(pilot_name, signoff_type)Select NAME, 'PGC Ops Meeting: FM, CFI, etc.' FROM pgc_members";
$ResultA = mysql_query($insertSQL, $PGC) or die(mysql_error());

/* Batch Updates */
mysql_select_db($database_PGC, $PGC);
/* Make sure all members have critical signoffs */
$insertSQL = "INSERT IGNORE INTO pgc_pilot_signoffs(pilot_name, signoff_type)Select NAME, 'Pilot Data Forms' FROM pgc_members";
$ResultA = mysql_query($insertSQL, $PGC) or die(mysql_error());

/* Batch Updates */
mysql_select_db($database_PGC, $PGC);
/* Make sure all members have critical signoffs */
$insertSQL = "INSERT IGNORE INTO pgc_pilot_signoffs(pilot_name, signoff_type)Select NAME, 'PGC Safety Meeting' FROM pgc_members";
$ResultA = mysql_query($insertSQL, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
 
$runSQL = "UPDATE pgc_pilot_signoffs SET signoff_date = '2010-01-01', expire_date = '2011-01-01', instructor = 'Klaus System Yearly Reset', modified_by = 'KK via Yearly Reset', modified_date = curdate()
WHERE signoff_type = 'PGC Safety Meeting' OR  signoff_type = 'Pilot Data Forms' OR signoff_type = 'PGC Ops Meeting: FM, CFI, etc.'"; 
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

 
   
?>