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

$maxRows_Recordset1 =  20;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_POST['afm1'])) {
  $colname_Recordset1 = $_POST['afm1'];
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_field_duty_check WHERE fd_role = 'afm1' OR fd_role = 'afm2' OR fd_role = 'fm1' OR fd_role = 'fm2' ORDER BY fd_role, member_name ASC");
$query_Recordset1 = sprintf("SELECT * FROM pgc_field_duty_check WHERE fd_role = 'afm1' OR fd_role = 'afm2' ORDER BY fd_role, member_name ASC");
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

error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}

mysql_select_db($database_PGC, $PGC);
$query_fd_holidays = "SELECT holiday_name, holiday_date, holiday_active FROM pgc_field_duty_holidays";
$fd_holidays = mysql_query($query_fd_holidays, $PGC) or die(mysql_error());
$row_fd_holidays = mysql_fetch_assoc($fd_holidays);
$totalRows_fd_holidays = mysql_num_rows($fd_holidays);

// Get all the entries in PGC FIELD DUTY ... and make into individual records ...

mysql_select_db($database_PGC, $PGC);
$query_fd_selections = "TRUNCATE pgc_field_duty_explode";
$fd_current_selections1 = mysql_query($query_fd_selections, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
$query_fd_selections = "INSERT INTO pgc_field_duty_explode (member_name, fd_date, session) SELECT `afm1`,`date`, `session` FROM pgc_field_duty WHERE `afm1` <> '' ORDER by `session` ASC";
$fd_current_selections1 = mysql_query($query_fd_selections, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
$query_fd_selections = "INSERT INTO pgc_field_duty_explode (member_name, fd_date, session) SELECT `afm2`,`date`, `session` FROM pgc_field_duty WHERE `afm2` <> '' ORDER by `session` ASC";
$fd_current_selections1 = mysql_query($query_fd_selections, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
$query_fd_selections = "INSERT INTO pgc_field_duty_explode (member_name, fd_date, session) SELECT `afm3`,`date`, `session` FROM pgc_field_duty WHERE `afm3` <> '' ORDER by `session` ASC";
$fd_current_selections1 = mysql_query($query_fd_selections, $PGC) or die(mysql_error());

//  

mysql_select_db($database_PGC, $PGC);
$query_fd_selections = "TRUNCATE pgc_field_duty_check";
$fd_current_selections1 = mysql_query($query_fd_selections, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
$query_fd_selections = "INSERT IGNORE INTO pgc_field_duty_check (member_id, member_name, fd_role, pgc_active)  
SELECT user_id, name, duty_role, active FROM pgc_members WHERE active = 'YES'";
$fd_current_selections1 = mysql_query($query_fd_selections, $PGC) or die(mysql_error());

//
mysql_select_db($database_PGC, $PGC);
$query_Recordset33 = "UPDATE pgc_field_duty_check p1 INNER JOIN
(
    SELECT `date`, afm1, afm2, afm3, fm, session
    FROM pgc_field_duty

)p2 
SET p1.session1 = p2.date
WHERE (p1.member_name = p2.afm1 OR p1.member_name = p2.afm2 OR p1.member_name = p2.afm3 OR p1.member_name = p2.fm) AND p2.session = '1'";
$Recordset33 = mysql_query($query_Recordset33, $PGC) or die(mysql_error());
$row_Recordset33 = mysql_fetch_assoc($Recordset33);
$totalRows_Recordset33 = mysql_num_rows($Recordset33);

/////  Update Field Duty Table with Counts
mysql_select_db($database_PGC, $PGC);
$query_Recordset33 = "UPDATE pgc_field_duty_check p1 INNER JOIN
(
   SELECT `date`, afm1, afm2, afm3, fm, session
    FROM pgc_field_duty

)p2 
SET p1.session2 = p2.date
WHERE (p1.member_name = p2.afm1 OR p1.member_name = p2.afm2 OR p1.member_name = p2.afm3 OR p1.member_name = p2.fm) AND p2.session = '2'";
$Recordset33 = mysql_query($query_Recordset33, $PGC) or die(mysql_error());
$row_Recordset33 = mysql_fetch_assoc($Recordset33);
$totalRows_Recordset33 = mysql_num_rows($Recordset33);

/////  Update Field Duty Table with Counts
mysql_select_db($database_PGC, $PGC);
$query_Recordset33 = "UPDATE pgc_field_duty_check p1 INNER JOIN
(
   SELECT `date`, afm1, afm2, afm3, fm, session
    FROM pgc_field_duty

)p2 
SET p1.session3 = p2.date
WHERE (p1.member_name = p2.afm1 OR p1.member_name = p2.afm2 OR p1.member_name = p2.afm3 OR p1.member_name = p2.fm) AND p2.session = '3'";
$Recordset33 = mysql_query($query_Recordset33, $PGC) or die(mysql_error());
$row_Recordset33 = mysql_fetch_assoc($Recordset33);
$totalRows_Recordset33 = mysql_num_rows($Recordset33);


/////  Update Field Duty Table with Explode Dates

mysql_select_db($database_PGC, $PGC);
$query_Recordset34 = "UPDATE pgc_field_duty_check as C
                      INNER JOIN (
			    SELECT member_name, GROUP_CONCAT( fd_date
                      SEPARATOR ' ~ ~ ' ) AS fd_text
                      FROM pgc_field_duty_explode
			    GROUP BY member_name
			    ) as E on C.member_name = E.member_name
			    SET C.date_list = E.fd_text";
 
$Recordset34 = mysql_query($query_Recordset34, $PGC) or die(mysql_error());
$row_Recordset34 = mysql_fetch_assoc($Recordset34);
$totalRows_Recordset34 = mysql_num_rows($Recordset34);
 
// UPDAATE Credits
$updateHours = "UPDATE pgc_field_duty_check SET fd_credits = (SELECT Count(`date`) FROM pgc_field_duty WHERE pgc_field_duty_check.member_name = pgc_field_duty.afm1 OR pgc_field_duty_check.member_name = pgc_field_duty.afm2 OR pgc_field_duty_check.member_name = pgc_field_duty.afm3)";
mysql_select_db($database_PGC, $PGC);
$HoursResult = mysql_query($updateHours, $PGC) or die(mysql_error());

 
 // UPDAATE Holidays
 
$updateHours = "UPDATE pgc_field_duty_check SET fd_holiday = ''";
mysql_select_db($database_PGC, $PGC);
$HoursResult = mysql_query($updateHours, $PGC) or die(mysql_error());
 
 
$updateHours = "UPDATE pgc_field_duty_check p1 INNER JOIN
(
   SELECT `holiday_date`, `holiday_active`
    FROM pgc_field_duty_holidays

)p2 
SET p1.fd_holiday = 'Y'
WHERE (p1.session1 = p2.holiday_date OR p1.session2 = p2.holiday_date OR p1.session3 = p2.holiday_date) AND (p2.holiday_active = 'Y')";
mysql_select_db($database_PGC, $PGC);
$HoursResult = mysql_query($updateHours, $PGC) or die(mysql_error());
 
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
	color: #FFFFFF;
	font-size: 16px;
	font-weight: bold;
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
.style19 {
	color: #CCCCCC;
	font-style: italic;
	font-weight: bold;
	text-align: center;
}
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
.style32 {
	font-weight: bold;
	color: #FFFFFF;
	font-size: 14px;
}
.style43 {
	font-size: 18px;
	font-weight: bold;
	color: #FFF;
}
#form1 table tr .style20
{
	color: #FFF;
}
.tablecolor
{
	color: #CCCCCC;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 14px;
}
.tablerows
{
	font-family: Arial, Helvetica, sans-serif;
	color: #F4F4F4;
	font-size: 12px;
}
-->
</style></head>

<body>
<p>&nbsp;</p>
<table width="1000" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
      <tr>
    <td width="1002"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="190" bgcolor="#3E3E5E"><table width="99%" height="171" border="0" align="center" cellpadding="5" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="25"><div align="center">
              <table width="99%" border="0" cellspacing="2" cellpadding="2">
                    <tr>
                          <td height="95" bgcolor="#333366"><div align="center">
                                <table width="90%" cellspacing="0" cellpadding="0">
                                      <tr>
                                            <td width="23%" height="35">&nbsp;</td>
                                            <td width="51%" align="center"><span class="style24">VALIDATE MASTER FD SCHEDULE</span></td>
                                            <td width="26%">&nbsp;</td>
                                      </tr>
                          </table>
                                <table border="0" cellpadding="2" cellspacing="2">
                                      <tr class="tablecolor">
                                            <td align="center" valign="middle" bgcolor="#6F7AE3" class="tablecolor">Holiday Name</td>
                                            <td align="center" valign="middle" bgcolor="#6F7AE3" class="tablecolor">Holiday Date</td>
                                            <td align="center" valign="middle" bgcolor="#6F7AE3" class="tablecolor">Holiday Active</td>
                                      </tr>
                                      <?php do { ?>
                                      <tr class="tablerows">
                                            <td align="left" valign="middle" bgcolor="#6F7AE3"><a href="pgc_field_duty_holiday_edit.php?holiday_name=<?php echo $row_fd_holidays['holiday_name']; ?>"><?php echo $row_fd_holidays['holiday_name']; ?></a></td>
                                            <td align="center" valign="middle" bgcolor="#6F7AE3"><?php echo $row_fd_holidays['holiday_date']; ?></td>
                                            <td align="center" valign="middle" bgcolor="#6F7AE3"><?php echo $row_fd_holidays['holiday_active']; ?></td>
                                      </tr>
                                      <?php } while ($row_fd_holidays = mysql_fetch_assoc($fd_holidays)); ?>
                          </table>
                                <table width="74%" cellspacing="1" cellpadding="5">
                                      <tr>
                                            <td height="60" class="style19">This app reads the pgc_field_duty table  and shows the actual duty dates that have been assigned for all active members. It can be used to  identify members who are assigned too few ... or too  many duty days for the season.</td>
                                      </tr>
                                </table>
                          </div></td>
                    </tr>
              </table>
        </div></td>
      </tr>
      
      <tr>
        <td height="93" align="center" valign="top"></p>
              <table width="99%" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                          <td align="center" bgcolor="#6F7AE3"><span class="tablecolor">Member Name</span></td>
                          <td align="center" bgcolor="#6F7AE3"><span class="tablecolor">Active</span></td>
                          <td align="center" bgcolor="#6F7AE3"><span class="tablecolor">Role</span></td>
                          <td align="center" bgcolor="#6F7AE3"><span class="tablecolor">Days</span></td>
                          <td align="center" bgcolor="#6F7AE3"><span class="tablecolor">Hol</span></td>
                          <td align="center" bgcolor="#6F7AE3"><span class="tablecolor">Session 1</span></td>
                          <td align="center" bgcolor="#6F7AE3"><span class="tablecolor">Session 2</span></td>
                          <td align="center" bgcolor="#6F7AE3"><span class="tablecolor">Session 3</span></td>
                          <td align="center" bgcolor="#6F7AE3"><span class="tablecolor">All FD Dates</span></td>
                          </tr>
                    <?php do { ?>
                          <tr  >
                                <td bgcolor="#4453DB" class="tablerows"><?php echo $row_Recordset1['member_name']; ?></td>
                                <td align="center" bgcolor="#4453DB" class="tablerows"><?php echo $row_Recordset1['pgc_active']; ?></td>
                                <td align="center" bgcolor="#4453DB" class="tablerows"><?php echo $row_Recordset1['fd_role']; ?></td>
                                <td align="center" bgcolor="#4453DB" class="tablerows"><?php echo $row_Recordset1['fd_credits']; ?></td>
                                <td align="center" bgcolor="#4453DB" class="tablerows"><?php echo $row_Recordset1['fd_holiday']; ?></td>
                                <td align="center" bgcolor="#4453DB" class="tablerows"><?php echo $row_Recordset1['session1']; ?></td>
                                <td align="center" bgcolor="#4453DB" class="tablerows"><?php echo $row_Recordset1['session2']; ?></td>
                                <td align="center" bgcolor="#4453DB" class="tablerows"><?php echo $row_Recordset1['session3']; ?></td>
                                <td bgcolor="#4453DB" class="tablerows"><?php echo $row_Recordset1['date_list']; ?></td>
                                </tr>
                          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
              </table>
              <p>&nbsp;              
              <table border="0">
                    <tr>
                          <td width="40"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="First.gif" /></a>
                                      <?php } // Show if not first page ?></td>
                          <td width="40"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="Previous.gif" /></a>
                                      <?php } // Show if not first page ?></td>
                          <td width="40"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="Next.gif" /></a>
                                      <?php } // Show if not last page ?></td>
                          <td width="40"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
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
