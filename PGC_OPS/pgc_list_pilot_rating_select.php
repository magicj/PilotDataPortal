<?php require_once('../Connections/PGC.php');?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
/* require_once('pgc_check_login_admin.php'); */
$_SESSION[last_rating_query] = $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'];
$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_GET['pgc_pilot'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['pgc_pilot'] : addslashes($_GET['pgc_pilot']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_pilot_ratings WHERE pilot_name = '%s'", $colname_Recordset1);
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
$query_Recordset2 = "SELECT A.pilot_name FROM pgc_pilots A, pgc_members B WHERE (A.pilot_name = B.NAME) AND (B.active = 'YES') ORDER BY A.pilot_name ASC";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pilot Data Portal - Add Pilot Rating</title>
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
.style18 {color: #FFFFCC}
a:link {
	color: #FFFFCC;
}
a:visited {
	color: #FFCCFF;
}
.style19 {
	color: #CCCCCC;
	font-style: italic;
	font-weight: bold;
}
-->
</style></head>

<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
  <tr>
    <td><div align="center"><span class="style1">PILOT DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="474" valign="top"><table width="92%" height="440" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36" bgcolor="#2C364E"><div align="center"><span class="style11">LIST PILOT RATINGS - SELECT</span></div></td>
      </tr>
      <tr>
        <td height="373" bgcolor="#424A66">&nbsp;
          <label>
          <table align="center" cellpadding="2" cellspacing="1" bgcolor="#666666">
            <tr>
              <td width="123" bgcolor="#0C3E43" class="style16"><div align="center"><em><strong>ID</strong></em></div></td>
              <td width="193" bgcolor="#0C3E43" class="style19"><div align="center">PILOT NAME</div></td>
              <td width="192" bgcolor="#0C3E43" class="style16"><div align="center"><em><strong>PGC RATING / GROUP </strong></em></div></td>
              </tr>
            <?php do { ?>
              <tr>
                <td bgcolor="#0C3E43"><div align="center"><a href="pgc_update_pilot_rating.php?ratingID=<?php echo $row_Recordset1['rating_id']; ?>" class="style18"><?php echo $row_Recordset1['rating_id']; ?></a></div></td>
                <td bgcolor="#0C3E43"><?php echo $row_Recordset1['pilot_name']; ?></td>
                <td bgcolor="#0C3E43"><?php echo $row_Recordset1['pgc_rating']; ?></td>
                </tr>
              <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
          </table>
          </label>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <form id="form1" name="form1" method="get" action="pgc_list_pilot_rating_select.php">
            <p>
            <label>
            <div align="center">
            <div align="center"> <br />
                <br />
                    <br />
                        <br />
                            <br />
                                <br />
                                  <select name="pgc_pilot" type="text" id="pgc_pilot" >
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset2['pilot_name']?>"<?php if (!(strcmp($row_Recordset2['pilot_name'], $row_Recordset1['pilot_name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['pilot_name']?></option>
                <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
              </select>
              <input type="submit" name="Submit" value="Submit" />
              <br />
              <br />
            </div>
            </label>
          </form>
          <p align="center">
            <label></label>
          </p>
          </td>
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

/* Set Expired to Blank for Non-Expires */
$runSQL =  "INSERT IGNORE INTO pgc_instructors( Name ) SELECT pilot_name FROM pgc_pilot_ratings WHERE pgc_rating = 'CFIG' OR pgc_rating = 'CFIA'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

$runSQL = "UPDATE pgc_pilots SET pgc_ratings = (SELECT GROUP_CONCAT(DISTINCT pgc_rating SEPARATOR ', ') FROM pgc_pilot_ratings WHERE pgc_pilots.pilot_name = pgc_pilot_ratings.pilot_name GROUP BY pilot_name)";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

$runSQL =  "INSERT IGNORE INTO pgc_pilot_signoffs(pilot_name, signoff_type, signoff_date, instructor, expire_date, status)
 Select A.pilot_name, B.description, '0000-00-00', 'System','0000-00-00', 'NG'
 FROM pgc_pilots A, pgc_signoff_types B, pgc_pilot_ratings C WHERE (A.pilot_name = C.pilot_name) AND (C.pgc_rating = B.target_group) AND C.delete_record = 'NEW'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

$runSQL =  "UPDATE pgc_pilot_ratings SET delete_record = 'NO' WHERE delete_record = 'NEW'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

 
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
