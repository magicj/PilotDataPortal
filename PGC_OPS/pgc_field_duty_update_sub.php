<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
$_SESSION[pilotname] = 'Kochanski, Ken';
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

$colname_rsFieldDuty = "-1";
if (isset($_GET['dutydate'])) {
  $colname_rsFieldDuty = (get_magic_quotes_gpc()) ? substr($_GET[dutydate],0,10) : addslashes(substr($_GET[dutydate],0,10));
}

mysql_select_db($database_PGC, $PGC);
$query_rsFieldDuty = sprintf("SELECT * FROM pgc_field_duty WHERE `date` = '%s'", $colname_rsFieldDuty);
//$query_rsFieldDuty = "SELECT * FROM pgc_field_duty WHERE `date` = '2009-04-03'";
$rsFieldDuty = mysql_query($query_rsFieldDuty, $PGC) or die(mysql_error());
$row_rsFieldDuty = mysql_fetch_assoc($rsFieldDuty);
$totalRows_rsFieldDuty = mysql_num_rows($rsFieldDuty);

$fm_sub   = $row_rsFieldDuty['fm_sub'];
$afm1_sub = $row_rsFieldDuty['afm1_sub'];
$afm2_sub = $row_rsFieldDuty['afm2_sub'];
$afm3_sub = $row_rsFieldDuty['afm3_sub'];

$pilotname = $_SESSION[pilotname];
$namecount = 0;
$pgcdutytype = substr($_GET[dutydate],10);
$cellcontents = $row_rsFieldDuty[$pgcdutytype];

//Is this a sub or reversal 
if ($cellcontents != $pilotname) {

	if ($pilotname == $fm_sub) {
	$namecount = $namecount + 1;
	}
	if ($pilotname == $afm1_sub) {
	$namecount = $namecount + 1;
	}
	if ($pilotname == $afm2_sub) {
	$namecount = $namecount + 1;
	}
	if ($pilotname == $afm3_sub) {
	$namecount = $namecount + 1;
	}
}


if ( ($namecount > 0 )||($cellcontents != "Open" AND $cellcontents != $pilotname ) ) {
 

	If ($namecount > 0) {
	$_SESSION[page_msg] = $_SESSION[pilotname] . ' substitution not allowed ... you already have one duty assignment on this date';
	}
		If ($cellcontents != "Open") {
	$_SESSION[page_msg] = ' Cell contains ' . $cellcontents . ' - ' . ' substitution not allowed ... duty assigned to different member';
	}
	
    $updateGoTo = 'http://' . $_SERVER['HTTP_HOST']  .$_SESSION[last_query];
	header(sprintf("Location: %s", $updateGoTo));

} ELSE {

$pgcdutydate = substr($_GET[dutydate],10);
$updateSQL = sprintf("UPDATE pgc_field_duty SET afm3_sub=afm3_sub WHERE 1 = 2" );
$_SESSION[page_msg] = $_SESSION[pilotname] . ' ... do you want to substitute for AFM duty on this date?';

  switch ($pgcdutydate) {
    case "fm_sub":
	  if ($fm_sub != $_SESSION[pilotname]) {
      $updateSQL = sprintf("UPDATE pgc_field_duty SET fm_sub=%s WHERE `date`=%s",
                   GetSQLValueString($_SESSION[pilotname], "text"),
                   GetSQLValueString($_POST['date'], "text"));
				   $_SESSION[page_msg] = $_SESSION[pilotname] . ' ... do you want to substitute for FM duty on this date?';
      } ELSE {
	        $updateSQL = sprintf("UPDATE pgc_field_duty SET fm_sub=%s WHERE `date`=%s",
                   GetSQLValueString("Open", "text"),
                   GetSQLValueString($_POST['date'], "text"));
				   $_SESSION[page_msg] = $_SESSION[pilotname] . ' ... do you want to remove your name as the substitute for FM duty on this date?';
	  }
       break;    
    case "afm1_sub":
	  if ($afm1_sub != $_SESSION[pilotname]) {
      $updateSQL = sprintf("UPDATE pgc_field_duty SET afm1_sub=%s WHERE `date`=%s",
                   GetSQLValueString($_SESSION[pilotname], "text"),
                   GetSQLValueString($_POST['date'], "text"));
				   $_SESSION[page_msg] = $_SESSION[pilotname] . ' ... do you want to substitute for AFM duty on this date?';
      } ELSE {
	        $updateSQL = sprintf("UPDATE pgc_field_duty SET afm1_sub=%s WHERE `date`=%s",
                   GetSQLValueString("Open", "text"),
                   GetSQLValueString($_POST['date'], "text"));
				   $_SESSION[page_msg] = $_SESSION[pilotname] . ' ... do you want to remove your name as the substitute for FM duty on this date?';
	  }

      break;    
    case "afm2_sub":
	  if ($afm2_sub != $_SESSION[pilotname]) {
      $updateSQL = sprintf("UPDATE pgc_field_duty SET afm2_sub=%s WHERE `date`=%s",
                   GetSQLValueString($_SESSION[pilotname], "text"),
                   GetSQLValueString($_POST['date'], "text"));
				   $_SESSION[page_msg] = $_SESSION[pilotname] . ' ... do you want to substitute for AFM duty on this date?';
      } ELSE {
	        $updateSQL = sprintf("UPDATE pgc_field_duty SET afm2_sub=%s WHERE `date`=%s",
                   GetSQLValueString("Open", "text"),
                   GetSQLValueString($_POST['date'], "text"));
				   $_SESSION[page_msg] = $_SESSION[pilotname] . ' ... do you want to remove your name as the substitute for FM duty on this date?';
	  }
	
      break;    
    case "afm3_sub":
	  if ($afm3_sub != $_SESSION[pilotname]) {
      $updateSQL = sprintf("UPDATE pgc_field_duty SET afm3_sub=%s WHERE `date`=%s",
                   GetSQLValueString($_SESSION[pilotname], "text"),
                   GetSQLValueString($_POST['date'], "text"));
				   $_SESSION[page_msg] = $_SESSION[pilotname] . ' ... do you want to substitute for AFM duty on this date?';
      } ELSE {
	        $updateSQL = sprintf("UPDATE pgc_field_duty SET afm3_sub=%s WHERE `date`=%s",
                   GetSQLValueString("Open", "text"),
                   GetSQLValueString($_POST['date'], "text"));
				   $_SESSION[page_msg] = $_SESSION[pilotname] . ' ... do you want to remove your name as the substitute for FM duty on this date?';
	  }
	
      break;    
  }


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
//  $updateSQL gets value from switch
  mysql_select_db($database_PGC, $PGC);
  If ($_POST['Cancel'] ) {
  // Do Nothing
  $_SESSION[page_msg] = "No Change - Last Transaction Cancelled";
  } ELSE {
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
  $_SESSION[page_msg] = "Last transaction completed";
  }

  $updateGoTo = "pgc_field_duty_list.php";
  $updateGoTo = 'http://' . $_SERVER['HTTP_HOST']  .$_SESSION[last_query];
  if (isset($_SERVER['xQUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}}



mysql_select_db($database_PGC, $PGC);
$query_rsMembers = "SELECT * FROM pgc_members";
$rsMembers = mysql_query($query_rsMembers, $PGC) or die(mysql_error());
$row_rsMembers = mysql_fetch_assoc($rsMembers);
$totalRows_rsMembers = mysql_num_rows($rsMembers);
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
.style16 {color: #CCCCCC; }
.style18 {
	color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-style: italic;
}
.style19 {color: #FFFFCC}
-->
</style></head>

<body>
<table width="800" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="514"><table width="92%" height="478" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36"><div align="center"><span class="style11">ENTER SUB FOR FIELD DUTY</span></div></td>
      </tr>
      <tr>
        <td height="36"><div align="center" class="style19"><?php echo $_SESSION[page_msg]; ?></div>          </td>
      </tr>
      <tr>
        <td height="373">&nbsp;
          <label></label>
          <form method="post" name="form2" action="<?php echo $editFormAction; ?>">
            <table border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#000000" bgcolor="#4A4A4A">
              <tr valign="baseline">

                <td nowrap align="right"><div align="left"><em><strong>DATE:</strong></em></div></td>
                <td bgcolor="#2B5555" class="style18"><div align="center"><?php echo $row_rsFieldDuty['date']; ?></div></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right"><div align="left"><em><strong>FM:</strong></em></div></td>
                <td bgcolor="#2B5555"><?php echo $row_rsFieldDuty['fm']; ?></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right"><div align="left"><em><strong>AFM:</strong></em></div></td>
                <td bgcolor="#2B5555"><?php echo $row_rsFieldDuty['afm1']; ?></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right"><div align="left"><em><strong>AFM:</strong></em></div></td>
                <td bgcolor="#2B5555"><?php echo $row_rsFieldDuty['afm2']; ?></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right"><div align="left"><em><strong>AFM:</strong></em></div></td>
                <td bgcolor="#2B5555"><?php echo $row_rsFieldDuty['afm3']; ?></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right"><div align="left"><em><strong>FM SUB </strong></em></div></td>
                <?php if ($pgcdutydate == 'fm_sub') { ?>
                <td bgcolor="#2B5555"><div align="center" class="style18"><?php echo $_SESSION[pilotname]; ?></span></div></td>
<?php } else { ?>
                <td bgcolor="#2B5555"><?php echo $row_rsFieldDuty['fm_sub']; ?></td>
<?php } ?>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right"><div align="left"><em><strong>AFM SUB </strong></em></div></td>
<?php if ($pgcdutydate == 'afm1_sub') { ?>
                <td bgcolor="#2B5555"><div align="center"><span class="style18"><?php echo $_SESSION[pilotname]; ?></span></div></td>
<?php } else { ?>
                <td bgcolor="#2B5555"><?php echo $row_rsFieldDuty['afm1_sub']; ?></td>
<?php } ?>				 
              </tr>
              <tr valign="baseline">
              <td nowrap align="right"><div align="left"><em><strong>AFM SUB :</strong></em></div></td>
<?php if ($pgcdutydate == 'afm2_sub') { ?>
                <td bgcolor="#2B5555"><div align="center"><span class="style18"><?php echo $_SESSION[pilotname]; ?></span></div></td>
<?php } else { ?>
                <td bgcolor="#2B5555"><?php echo $row_rsFieldDuty['afm2_sub']; ?></td>
<?php } ?>				 
              </tr>
              <tr valign="baseline">
              <td nowrap align="right"><div align="left"><em><strong>AFM SUB </strong></em></div></td>
<?php if ($pgcdutydate == 'afm3_sub') { ?>
                <td bgcolor="#2B5555"><div align="center"><span class="style18"><?php echo $_SESSION[pilotname]; ?></span></div></td>
                <?php } else { ?>
                <td bgcolor="#2B5555"><?php echo $row_rsFieldDuty['afm3_sub']; ?></td>
<?php } ?>				 
              </tr>
              <tr valign="baseline">
                <td nowrap align="right"><label>
                  
                    <div align="center">
                      <input name="Cancel" type="submit" id="Cancel" value="Cancel" />
                    </div>
                </label></td>
                <td><div align="center">
                  <input type="submit" value="Update record">
                </div></td>
              </tr>
            </table>
            <input type="hidden" name="MM_update" value="form2">
            <input type="hidden" name="date" value="<?php echo $row_rsFieldDuty['date']; ?>">
          </form>
          <p align="center">&nbsp;</p></td>
      </tr>
      <tr>
        <td height="21"><div align="center"><strong class="style11"><a href="../PGC_OPS/pgc_fd_menu.php" class="style16">BACK FD MENU</a></strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsFieldDuty);

mysql_free_result($rsMembers);
?>
