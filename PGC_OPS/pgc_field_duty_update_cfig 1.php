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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pgc_field_duty SET cfig=%s, tp1=%s, tp2=%s WHERE `date`=%s",
                       GetSQLValueString($_POST['cfig'], "text"),
                       GetSQLValueString($_POST['tp1'], "text"),
                       GetSQLValueString($_POST['tp2'], "text"),
                       GetSQLValueString($_POST['date'], "text")  );

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

 $updateGoTo = "pgc_field_duty_list_sub.php";
 $updateGoTo = 'http://' . $_SERVER['HTTP_HOST']  .$_SESSION[last_query];
  if (isset($_SERVER['xQUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsFieldDuty = "-1";
if (isset($_GET['dutydate'])) {
  $colname_rsFieldDuty = (get_magic_quotes_gpc()) ? $_GET['dutydate'] : addslashes($_GET['dutydate']);
}
mysql_select_db($database_PGC, $PGC);
$query_rsFieldDuty = sprintf("SELECT * FROM pgc_field_duty WHERE `date` = '%s' ORDER BY `date` ASC", $colname_rsFieldDuty);
$rsFieldDuty = mysql_query($query_rsFieldDuty, $PGC) or die(mysql_error());
$row_rsFieldDuty = mysql_fetch_assoc($rsFieldDuty);
$totalRows_rsFieldDuty = mysql_num_rows($rsFieldDuty);

mysql_select_db($database_PGC, $PGC);
$query_rsMembers = "SELECT * FROM pgc_members ORDER BY NAME ASC";
$rsMembers = mysql_query($query_rsMembers, $PGC) or die(mysql_error());
$row_rsMembers = mysql_fetch_assoc($rsMembers);
$totalRows_rsMembers = mysql_num_rows($rsMembers);

mysql_select_db($database_PGC, $PGC);
$query_rsMemberRatings = "SELECT * FROM pgc_pilot_ratings";
$rsMemberRatings = mysql_query($query_rsMemberRatings, $PGC) or die(mysql_error());
$row_rsMemberRatings = mysql_fetch_assoc($rsMemberRatings);
$totalRows_rsMemberRatings = mysql_num_rows($rsMemberRatings);

mysql_select_db($database_PGC, $PGC);
$query_rsCFIG = "SELECT * FROM pgc_instructors";
$rsCFIG = mysql_query($query_rsCFIG, $PGC) or die(mysql_error());
$row_rsCFIG = mysql_fetch_assoc($rsCFIG);
$totalRows_rsCFIG = mysql_num_rows($rsCFIG);
 ?>
 <?php
mysql_select_db($database_PGC, $PGC);
$deleteSQL = "DELETE FROM pgc_field_duty WHERE delete_record='YES'";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());
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
	background-color: #333333;
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style11 {font-size: 16px; font-weight: bold; }
a:link {
	color: #CCCCCC;
}
a:visited {
	color: #CCCCCC;
}
.style16 {color: #CCCCCC; }
.style20 {color: #8CA6D8; font-style: italic; font-weight: bold; font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style></head>

<body>
<table width="800" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="446"><table width="92%" height="440" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#2D3240">
      <tr>
        <td height="36" bgcolor="#545E78"><div align="center"><span class="style11"> DUTY UPDATE - CFIG / TOW PILOTS </span></div></td>
      </tr>
      <tr>
        <td height="373" bgcolor="#666666"><p align="center">&nbsp;</p>
          
                <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
            <table width="288" align="center" cellpadding="3" cellspacing="3" bordercolor="#000000" bgcolor="#4F4F4F">
              <tr valign="baseline">
                <td width="68" align="right" nowrap bgcolor="#666666"><div align="left"><em><strong>DATE:</strong></em></div></td>
                <td width="193" bgcolor="#666666"><em><strong>
                  <label>
                 <?php echo $row_rsFieldDuty['date']; ?>                  </label>
                </strong></em></td>
              </tr>
              

              <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#2B5555"><div align="left"><em><strong>CFIG:</strong></em></div></td>
                  <td bgcolor="#2B5555"><select name="cfig" id="cfig">
                      <?php
do {  
?>
                      <option value="<?php echo $row_rsCFIG['Name']?>"<?php if (!(strcmp($row_rsCFIG['Name'], $row_rsFieldDuty['cfig']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsCFIG['Name']?></option>
                      <?php
} while ($row_rsCFIG = mysql_fetch_assoc($rsCFIG));
  $rows = mysql_num_rows($rsCFIG);
  if($rows > 0) {
      mysql_data_seek($rsCFIG, 0);
	  $row_rsCFIG = mysql_fetch_assoc($rsCFIG);
  }
?>
                  </select></td>
              </tr>
              <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#2B5555"><div align="left"><em><strong>TP AM:</strong></em></div></td>
                  <td bgcolor="#2B5555"><select name="tp1" id="tp1">
                      <?php
do {  
?>
                      <option value="<?php echo $row_rsMembers['NAME']?>"<?php if (!(strcmp($row_rsMembers['NAME'], $row_rsFieldDuty['tp1']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsMembers['NAME']?></option>
                      <?php
} while ($row_rsMembers = mysql_fetch_assoc($rsMembers));
  $rows = mysql_num_rows($rsMembers);
  if($rows > 0) {
      mysql_data_seek($rsMembers, 0);
	  $row_rsMembers = mysql_fetch_assoc($rsMembers);
  }
?>
                  </select></td>
              </tr>
              <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#2B5555"><div align="left"><em><strong>TP PM:</strong></em></div></td>
                  <td bgcolor="#2B5555"><select name="tp2" id="tp2">
                      <?php
do {  
?>
                      <option value="<?php echo $row_rsMembers['NAME']?>"<?php if (!(strcmp($row_rsMembers['NAME'], $row_rsFieldDuty['tp2']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsMembers['NAME']?></option>
                      <?php
} while ($row_rsMembers = mysql_fetch_assoc($rsMembers));
  $rows = mysql_num_rows($rsMembers);
  if($rows > 0) {
      mysql_data_seek($rsMembers, 0);
	  $row_rsMembers = mysql_fetch_assoc($rsMembers);
  }
?>
                  </select></td>
              </tr>
              
              <tr valign="baseline">
                <td colspan="2" align="right" nowrap bgcolor="#666666"><div align="left"></div>                  <div align="center">
                    <input type="submit" value="Update record">
                    </div></td>
                </tr>
            </table>
            <input type="hidden" name="MM_update" value="form1">
            <input type="hidden" name="date" value="<?php echo $row_rsFieldDuty['date']; ?>">
          </form>
          <p>&nbsp;</p></td>
      </tr>
      <tr>
          <td height="21" bgcolor="#545E78"><div align="center"><strong class="style11"><a href="pgc_portal_menu.php" class="style20">BACK TO PDP MAINTENANCE MENU</a><a href="pgc_portal_menu.php" class="style16"></a></strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsFieldDuty);

mysql_free_result($rsMembers);

mysql_free_result($rsMemberRatings);

mysql_free_result($rsCFIG);
?>