<?php require_once('../Connections/PGC.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE IGNORE pgc_pilot_ratings SET pgc_rating=%s, `delete_record`=%s WHERE rating_id=%s",
                       GetSQLValueString($_POST['pgc_rating'], "text"),
                       GetSQLValueString($_POST['delete_record'], "text"),
                       GetSQLValueString($_POST['rating_id'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
  $updateGoTo = "pgc_list_pilot_rating_select.php"; 

  $updateGoTo = 'http://' . $_SERVER['HTTP_HOST']  .$_SESSION[last_rating_query];
   if (isset($_SERVER['xQUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['ratingID'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['ratingID'] : addslashes($_GET['ratingID']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_pilot_ratings WHERE rating_id = %s", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = "SELECT rating_name FROM pgc_ratings_list";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<?php
/* Purge Deletions */
$deleteSQL = "DELETE FROM pgc_pilot_ratings WHERE delete_record = 'YES'";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());

/* Set Expired to Blank for Non-Expires */
$runSQL =  "INSERT IGNORE INTO pgc_instructors( Name ) SELECT pilot_name FROM pgc_pilot_ratings WHERE pgc_rating = 'CFIG' OR pgc_rating = 'CFIA'";
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
.pilot-grid
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #CCC;
}
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
        <td height="36"><div align="center"><span class="style11">UPDATE  PILOT RATING </span></div></td>
      </tr>
      <tr>
        <td height="373" bgcolor="#424A66">&nbsp;
          <form method="post" name="form1" >
            <table width="350" height="184" align="center" cellpadding="8" cellspacing="2">
              <tr valign="baseline">
                <td width="103" height="26" align="left" valign="middle" nowrap bgcolor="#1C3855" class="pilot-grid">Rating Key</td>
                <td width="181" align="left" valign="middle" bgcolor="#1C3855" class="pilot-grid"><?php echo $row_Recordset1['rating_id']; ?></td>
              </tr>
              <tr valign="baseline">
                <td height="26" align="left" valign="middle" nowrap bgcolor="#1C3855" class="pilot-grid">Pilot Name</td>
                <td align="left" valign="middle" bgcolor="#1C3855" class="pilot-grid"><?php echo $row_Recordset1['pilot_name']; ?></td>
				<?php $_SESSION['pilot_name'] = $row_Recordset1['pilot_name']; ?>
				 
              </tr>
              <tr valign="baseline">
                <td height="32" align="left" valign="middle" nowrap bgcolor="#1C3855" class="pilot-grid">PGC Rating</td>
                <td align="left" valign="middle" bgcolor="#1C3855" class="pilot-grid"><select name="pgc_rating">
                  <?php
do {  
?>
                  <option value="<?php echo $row_Recordset2['rating_name']?>"<?php if (!(strcmp($row_Recordset2['rating_name'], $row_Recordset1['pgc_rating']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['rating_name']?></option>
                  <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
                </select></td>
              </tr>
              <tr valign="baseline">
                <td height="32" align="left" valign="middle" nowrap bgcolor="#1C3855" class="pilot-grid">Delete Record</td>
                <td align="left" valign="middle" bgcolor="#1C3855" class="pilot-grid"><select name="delete_record">
                  <option value="NO" <?php if (!(strcmp("NO", $row_Recordset1['delete_record']))) {echo "selected=\"selected\"";} ?>>NO</option>
                  <option value="YES" <?php if (!(strcmp("YES", $row_Recordset1['delete_record']))) {echo "selected=\"selected\"";} ?>>YES</option>
                </select></td>
              </tr>
              <tr valign="baseline">
                <td height="54" colspan="2" align="center" valign="middle" nowrap bgcolor="#1C3855"><input type="submit" value="Update record"></td>
                </tr>
            </table>
            <input type="hidden" name="MM_update" value="form1">
            <input type="hidden" name="rating_id" value="<?php echo $row_Recordset1['rating_id']; ?>">
		  </form>
          <p>
            <label></label>
            <label></label>
          </p></td>
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

mysql_free_result($Recordset2);
?>