<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
 function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT IGNORE INTO pgc_pilot_ratings (pilot_name, pgc_rating, delete_record) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['pilot_name'], "text"),
                       GetSQLValueString($_POST['pgc_rating'], "text"),
					   GetSQLValueString('NEW', "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
}

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_pilot_ratings";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_PGC, $PGC);
$query_Pilots = "SELECT A.pilot_name FROM pgc_pilots A, pgc_members B WHERE (A.pilot_name = B.NAME) AND (B.active = 'YES') ORDER BY A.pilot_name ASC";
$Pilots = mysql_query($query_Pilots, $PGC) or die(mysql_error());
$row_Pilots = mysql_fetch_assoc($Pilots);
$totalRows_Pilots = mysql_num_rows($Pilots);

mysql_select_db($database_PGC, $PGC);
$query_RatingList = "SELECT rating_name FROM pgc_ratings_list ORDER BY rating_name ASC";
$RatingList = mysql_query($query_RatingList, $PGC) or die(mysql_error());
$row_RatingList = mysql_fetch_assoc($RatingList);
$totalRows_RatingList = mysql_num_rows($RatingList);
?>
<?php 
$runSQL =  "INSERT IGNORE INTO pgc_instructors( Name ) SELECT pilot_name FROM pgc_pilot_ratings WHERE pgc_rating = 'CFIG' OR pgc_rating = 'CFIA'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

$runSQL =  "INSERT IGNORE INTO pgc_pilot_signoffs(pilot_name, signoff_type, signoff_date, instructor, expire_date, status)
 Select A.pilot_name, B.description, '0000-00-00', 'System','0000-00-00', 'NG'
 FROM pgc_pilots A, pgc_signoff_types B, pgc_pilot_ratings C WHERE (A.pilot_name = C.pilot_name) AND (C.pgc_rating = B.target_group) AND C.delete_record = 'NEW'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

$runSQL =  "UPDATE pgc_pilot_ratings SET delete_record = 'NO' WHERE delete_record = 'NEW'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

$runSQL = "UPDATE pgc_pilots SET pgc_ratings = (SELECT GROUP_CONCAT(DISTINCT pgc_rating SEPARATOR ', ') FROM pgc_pilot_ratings WHERE pgc_pilots.pilot_name = pgc_pilot_ratings.pilot_name GROUP BY pilot_name)";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Add Pilot Rating</title>
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
-->
</style></head>

<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
  <tr>
    <td><div align="center"><span class="style1">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="514"><table width="92%" height="440" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36"><div align="center"><span class="style11">ADD PILOT RATING - SINGLE </span></div></td>
      </tr>
      <tr>
        <td height="373" bgcolor="#424A66">&nbsp;
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
            <table width="250" height="113" align="center" cellpadding="5" cellspacing="2">
              <tr valign="baseline">
                <td align="left" nowrap bgcolor="#1C3855">Pilot Name:</td>
                <td bgcolor="#1C3855"><select name="pilot_name">
                  <?php
do {  
?>
                  <option value="<?php echo $row_Pilots['pilot_name']?>"><?php echo $row_Pilots['pilot_name']?></option>
                  <?php
} while ($row_Pilots = mysql_fetch_assoc($Pilots));
  $rows = mysql_num_rows($Pilots);
  if($rows > 0) {
      mysql_data_seek($Pilots, 0);
	  $row_Pilots = mysql_fetch_assoc($Pilots);
  }
?>
                </select></td>
              </tr>
              <tr valign="baseline">
                <td align="left" nowrap bgcolor="#1C3855">PGC Rating:</td>
                <td bgcolor="#1C3855"><select name="pgc_rating">
                  <?php
do {  
?>
                  <option value="<?php echo $row_RatingList['rating_name']?>"><?php echo $row_RatingList['rating_name']?></option>
                  <?php
} while ($row_RatingList = mysql_fetch_assoc($RatingList));
  $rows = mysql_num_rows($RatingList);
  if($rows > 0) {
      mysql_data_seek($RatingList, 0);
	  $row_RatingList = mysql_fetch_assoc($RatingList);
  }
?>
                </select></td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bgcolor="#1C3855">&nbsp;</td>
                <td bgcolor="#1C3855"><input type="submit" value="Insert record"></td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form1">
          </form>
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

mysql_free_result($Recordset1);

mysql_free_result($Pilots);

mysql_free_result($RatingList);
?>