<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php 
/*require_once('pgc_check_login_admin.php');  */
//$_SESSION[last_pilot] = $_POST['pilot_name'];
//$_SESSION[last_pilot] = $_SESSION[last_signoff_pilot];
$_SESSION[last_instructor] = $_POST['instructor'];
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
$date = date("Y-m-d H:i:s");
$current_date = date("m-d-Y");
$add_years = date("2099-01-01"); 
$_POST['pilot_name'] = $_SESSION[last_pilot];
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT IGNORE INTO pgc_pilot_signoffs (signoffID, pilot_ID, pilot_name, signoff_type, signoff_date, instructor, expire_date, status, modified_by, modified_date, 30_day_email) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['typeID'], "int"),
                       GetSQLValueString($_POST['pilot_ID'], "int"),
                       GetSQLValueString($_POST['pilot_name'], "text"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['instructor'], "text"),
                       GetSQLValueString($_POST['expires'], "date"),
                       GetSQLValueString($_POST['status'], "text"),
  					   GetSQLValueString($_SESSION['MM_PilotName'], "text"),
					   GetSQLValueString($date, "date"),
					   GetSQLValueString($add_years,"date")	
					   		   
					   );

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
  // New Link back
  $updateGoTo = 'http://' . $_SERVER['HTTP_HOST']  .$_SESSION[last_query];
  if (isset($_SERVER['xQUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_PGC, $PGC);
$query_rsPilotSignoffs = "SELECT * FROM pgc_pilot_signoffs";
$rsPilotSignoffs = mysql_query($query_rsPilotSignoffs, $PGC) or die(mysql_error());
$row_rsPilotSignoffs = mysql_fetch_assoc($rsPilotSignoffs);
$totalRows_rsPilotSignoffs = mysql_num_rows($rsPilotSignoffs);

mysql_select_db($database_PGC, $PGC);
$query_rsPgcPilots = "SELECT A.pilot_name, A.fly_status FROM pgc_pilots A, pgc_members B WHERE (A.pilot_name = B.NAME) AND (B.active = 'YES') ORDER BY A.pilot_name ASC";
$rsPgcPilots = mysql_query($query_rsPgcPilots, $PGC) or die(mysql_error());
$row_rsPgcPilots = mysql_fetch_assoc($rsPgcPilots);
$totalRows_rsPgcPilots = mysql_num_rows($rsPgcPilots);

mysql_select_db($database_PGC, $PGC);
$query_rsSignoffTypes = "SELECT * FROM pgc_signoff_types ORDER BY sort_order ASC";
$rsSignoffTypes = mysql_query($query_rsSignoffTypes, $PGC) or die(mysql_error());
$row_rsSignoffTypes = mysql_fetch_assoc($rsSignoffTypes);
$totalRows_rsSignoffTypes = mysql_num_rows($rsSignoffTypes);

mysql_select_db($database_PGC, $PGC);
$query_rsInstructors = "SELECT * FROM pgc_instructors WHERE rec_active = 'Y'  ORDER BY Name ASC";
$rsInstructors = mysql_query($query_rsInstructors, $PGC) or die(mysql_error());
$row_rsInstructors = mysql_fetch_assoc($rsInstructors);
$totalRows_rsInstructors = mysql_num_rows($rsInstructors);
?>
<?php
require_once('pgc_signoff_table_updates.php')
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
<title>PGC Data Portal - Enter Pilot Signoff</title>
<style type="text/css">
<!--
.style1 {	font-size: 18px;
	font-weight: bold;
}
body {
	background-color: #283664;
	background-image: url(../images/Buttons/PGC%20copy.png);
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
.style3 {
	font-size: 16px;
	font-weight: bold;
	text-align: center;
}
.style16 {color: #CCCCCC; }
.style44 {	color: #999999;
	font-weight: bold;
}
a:link {
	color: #999999;
}
a:visited {
	color: #999999;
}
a:hover {
	color: #999999;
}
a:active {
	color: #999999;
}
-->
</style>
</head>

<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
      <tr>
    <td><div align="center"><span class="style1">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="481" bgcolor="#3C3E6F"><table width="96%" height="447" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36"><div align="center"><span class="style3">ADD  PILOT SIGNOFF - SINGLE </span></div></td>
      </tr>
      <tr>
        <td height="373" align="center" bgcolor="#424A66"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
          <table width="456" height="189" align="center" cellpadding="2" cellspacing="3">
            <tr valign="baseline">
                    <td width="91" align="right" valign="middle" nowrap="nowrap" bgcolor="#0F4E55"><div align="left"><em><strong>PILOT NAME </strong></em></div></td>
              <td width="248" valign="middle" bgcolor="#0F4E55">
		  <?php echo $_SESSION[last_signoff_pilot]; ?>
             
<?php /*?>              <select name="pilot_name">
                    <?php
do {  
?><option value="<?php echo $row_rsPgcPilots['pilot_name']?>"<?php if (!(strcmp($row_rsPgcPilots['pilot_name'], $_SESSION[last_signoff_pilot]))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsPgcPilots['pilot_name']?></option>
                    <?php
} while ($row_rsPgcPilots = mysql_fetch_assoc($rsPgcPilots));
  $rows = mysql_num_rows($rsPgcPilots);
  if($rows > 0) {
      mysql_data_seek($rsPgcPilots, 0);
	  $row_rsPgcPilots = mysql_fetch_assoc($rsPgcPilots);
  }
?>
              </select><?php */?>
              
              </td>
            </tr>
            <tr valign="baseline">
                    <td align="right" valign="middle" nowrap="nowrap" bgcolor="#0F4E55"><div align="left"><em><strong>SIGNOFF TYPE </strong></em></div></td>
              <td valign="middle" bgcolor="#0F4E55"><select name="type">
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
  $currentDate = date("m-d-Y");
?>
              </select></td>
            </tr>
            <tr valign="baseline">
                    <td align="right" valign="middle" nowrap="nowrap" bgcolor="#0F4E55"><div align="left"><em><strong>SIGNOFF DATE </strong></em></div></td>
              <td valign="middle" bgcolor="#0F4E55"><input name="date" type="text" value="<?php echo date("Y-m-d")?>" size="10" />
                      <a href="#"
					   name="anchor2" class="style44" id="anchor2" onclick="cal.select(document.forms['form1'].date,'anchor2','yyyy-MM-dd'); return false">Select From Calendar</a></td>
            </tr>
            <tr valign="baseline">
                    <td align="right" valign="middle" nowrap="nowrap" bgcolor="#0F4E55"><div align="left"><em><strong>INSTRUCTOR</strong></em></div></td>
              <td valign="middle" bgcolor="#0F4E55"><select name="instructor">
                  <?php
do {  
?><option value="<?php echo $row_rsInstructors['Name']?>"<?php if (!(strcmp($row_rsInstructors['Name'], $_SESSION[last_instructor]))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsInstructors['Name']?></option>
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
              <td height="61" colspan="2" align="right" valign="middle" nowrap="nowrap" bgcolor="#0F4E55"><div align="center">
                      <table width="98%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                      <td width="51%"><div align="center">
                                              <input name="submit" type="submit" value="Insert record" />
                                      </div></td>
                                      <td width="49%"> <div align="center" class="style44"><strong><a href=" <?php echo$_SESSION['last_signoff_select'];?>">CANCEL UPDATE</a><a href="pgc_list_signoffs_select_v2.php"></a> </strong></div></td>
                              </tr>
                      </table>
              </div></td>
              </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1" />
        </form>
          <p class="style16"><span class="style3">This function will only add this signoff - if the member does not already have a signoff of this type. Use the modify fuction to change the signoff information in existing signoffs.</span></p></td>
      </tr>
      <tr>
        <td height="28"><div align="center"><strong class="style3"><a href="../PGC_OPS/pgc_portal_menu.php" class="style16">BACK TO MAIN</a></strong></div></td>
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

