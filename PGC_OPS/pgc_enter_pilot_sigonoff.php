<?php virtual('../Connections/PGC.php'); ?>
<?php error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
?>
require_once('pgc_check_login.php'); 
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
  $insertSQL = sprintf("INSERT INTO pgc_pilot_signoffs (typeID, pilot_ID, pilot_name, type, `date`, instructor, expires, status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['typeID'], "int"),
                       GetSQLValueString($_POST['pilot_ID'], "int"),
                       GetSQLValueString($_POST['pilot_name'], "text"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['instructor'], "text"),
                       GetSQLValueString($_POST['expires'], "date"),
                       GetSQLValueString($_POST['status'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
}

mysql_select_db($database_PGC, $PGC);
$query_rsPilotSignoffs = "SELECT * FROM pgc_pilot_signoffs";
$rsPilotSignoffs = mysql_query($query_rsPilotSignoffs, $PGC) or die(mysql_error());
$row_rsPilotSignoffs = mysql_fetch_assoc($rsPilotSignoffs);
$totalRows_rsPilotSignoffs = mysql_num_rows($rsPilotSignoffs);

mysql_select_db($database_PGC, $PGC);
$query_rsPgcPilots = "SELECT * FROM pgc_pilots";
$rsPgcPilots = mysql_query($query_rsPgcPilots, $PGC) or die(mysql_error());
$row_rsPgcPilots = mysql_fetch_assoc($rsPgcPilots);
$totalRows_rsPgcPilots = mysql_num_rows($rsPgcPilots);

mysql_select_db($database_PGC, $PGC);
$query_rsSignoffTypes = "SELECT * FROM pgc_signoff_types";
$rsSignoffTypes = mysql_query($query_rsSignoffTypes, $PGC) or die(mysql_error());
$row_rsSignoffTypes = mysql_fetch_assoc($rsSignoffTypes);
$totalRows_rsSignoffTypes = mysql_num_rows($rsSignoffTypes);

mysql_select_db($database_PGC, $PGC);
$query_rsInstructors = "SELECT * FROM pgc_instructors";
$rsInstructors = mysql_query($query_rsInstructors, $PGC) or die(mysql_error());
$row_rsInstructors = mysql_fetch_assoc($rsInstructors);
$totalRows_rsInstructors = mysql_num_rows($rsInstructors);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {	font-size: 18px;
	font-weight: bold;
}
body {
	background-color: #333333;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
.style3 {font-size: 16px; font-weight: bold; }
-->
</style>
</head>

<body>
<p>&nbsp;</p>
<table width="800" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="514"><table width="92%" height="417" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36"><div align="center"><span class="style3">ENTER PILOT SIGNOFF </span></div></td>
      </tr>
      <tr>
        <td height="373"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
          <table align="center">
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Pilot_name:</td>
              <td><select name="pilot_name">
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsPgcPilots['pilot_name']?>"><?php echo $row_rsPgcPilots['pilot_name']?></option>
                  <?php
} while ($row_rsPgcPilots = mysql_fetch_assoc($rsPgcPilots));
  $rows = mysql_num_rows($rsPgcPilots);
  if($rows > 0) {
      mysql_data_seek($rsPgcPilots, 0);
	  $row_rsPgcPilots = mysql_fetch_assoc($rsPgcPilots);
  }
?>
              </select></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Type:</td>
              <td><select name="type">
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsSignoffTypes['description']?>"><?php echo $row_rsSignoffTypes['description']?></option>
                  <?php
} while ($row_rsSignoffTypes = mysql_fetch_assoc($rsSignoffTypes));
  $rows = mysql_num_rows($rsSignoffTypes);
  if($rows > 0) {
      mysql_data_seek($rsSignoffTypes, 0);
	  $row_rsSignoffTypes = mysql_fetch_assoc($rsSignoffTypes);
  }
?>
              </select></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Signoff Date:</td>
              <td><input type="text" name="date" value="" size="10" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Instructor:</td>
              <td><select name="instructor">
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsInstructors['Name']?>"><?php echo $row_rsInstructors['Name']?></option>
                  <?php
} while ($row_rsInstructors = mysql_fetch_assoc($rsInstructors));
  $rows = mysql_num_rows($rsInstructors);
  if($rows > 0) {
      mysql_data_seek($rsInstructors, 0);
	  $row_rsInstructors = mysql_fetch_assoc($rsInstructors);
  }
?>
              </select></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Expire Date:</td>
              <td><input type="text" name="expires" value="" size="10" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Status:</td>
              <td><input type="text" name="status" value="" size="3" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td><input name="submit" type="submit" value="Insert record" /></td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1" />
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsPilotSignoffs);

mysql_free_result($rsPgcPilots);

mysql_free_result($rsSignoffTypes);

mysql_free_result($rsInstructors);
?>
