<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
//error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
$session_pilotname = $_SESSION['MM_PilotName'];
$session_email = $_SESSION['MM_Username']; 
$session_duty_role = $_SESSION['MM_duty_role'];
 
If ($_SESSION['MM_duty_role'] == 'AFM1' || $_SESSION['MM_duty_role'] == 'AFM2' || $_SESSION['MM_duty_role'] == 'FM1' || $_SESSION['MM_duty_role'] == 'FM2' ) {
} ELSE {
    $updateGoTo = "pgc_field_duty_not_AFM_msg.php";
    header(sprintf("Location: %s", $updateGoTo));
}
require_once('pgc_check_login.php'); 
?>
<?php

mysql_select_db($database_PGC, $PGC);
$query_ActiveSession = "SELECT fd_session, session_active, session_start_date, session_end_date FROM pgc_field_duty_control WHERE session_active = 'Y'";
$ActiveSession = mysql_query($query_ActiveSession, $PGC) or die(mysql_error());
$row_ActiveSession = mysql_fetch_assoc($ActiveSession);
$totalRows_ActiveSession = mysql_num_rows($ActiveSession);
$_SESSION['fd_active_session'] = $row_ActiveSession['fd_session'];
$session_start = $row_ActiveSession['session_start_date'];
$session_end = $row_ActiveSession['session_end_date'];
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
// Save Update
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pgc_field_duty_selections SET modified_date = now(), modified_by = %s, choice1=%s, choice2=%s, choice3=%s WHERE session=%s AND member_id=%s",
                       GetSQLValueString($session_pilotname, "text"),
			     GetSQLValueString($_POST['choice1'], "date"),
                       GetSQLValueString($_POST['choice2'], "date"),
                       GetSQLValueString($_POST['choice3'], "date"),
			     GetSQLValueString($_SESSION['fd_active_session'], "text"),
                       GetSQLValueString($_SESSION['MM_Username'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

      //Save Audit Record
	$updateSQL = sprintf("INSERT INTO pgc_field_duty_selections_audit (key_check, member_id, member_name, fd_role, `session`, choice1, choice2, choice3, choice_status, date_selected, modified_by,      modified_date, modify_ip, delete_record, selected_count) SELECT key_check, member_id, member_name, fd_role, `session`, choice1, choice2, choice3, choice_status, date_selected, modified_by,      modified_date, modify_ip, delete_record, selected_count from pgc_field_duty_selections WHERE session=%s AND member_id=%s",
				     GetSQLValueString($_SESSION['fd_active_session'], "text"),
				     GetSQLValueString($_SESSION['MM_Username'], "text"));
	
	mysql_select_db($database_PGC, $PGC);
	$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());


  $updateGoTo = "pgc_fd_menu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_MemberSelections = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_MemberSelections = $_SESSION['MM_Username'];
}
mysql_select_db($database_PGC, $PGC);
$query_MemberSelections = sprintf("SELECT * FROM pgc_field_duty_selections WHERE member_id = %s AND session = %s", GetSQLValueString($colname_MemberSelections, "text"),GetSQLValueString($_SESSION['fd_active_session'], "text"));
$MemberSelections = mysql_query($query_MemberSelections, $PGC) or die(mysql_error());
$row_MemberSelections = mysql_fetch_assoc($MemberSelections);
$totalRows_MemberSelections = mysql_num_rows($MemberSelections);

mysql_select_db($database_PGC, $PGC);
$query_fd_datesforsession = sprintf("SELECT `date` FROM pgc_field_duty WHERE `session` = %s ORDER BY `date` ASC", GetSQLValueString($_SESSION['fd_active_session'], "text"));
$fd_datesforsession = mysql_query($query_fd_datesforsession, $PGC) or die(mysql_error());
$row_fd_datesforsession = mysql_fetch_assoc($fd_datesforsession);
$totalRows_fd_datesforsession = mysql_num_rows($fd_datesforsession);


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
.style16 {
	color: #FFFFFF;
	font-size: 16px;
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
.style19 {color: #CCCCCC; font-style: italic; font-weight: bold; }
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
.style32 {font-weight: bold; color: #000000; }
.style43 {font-size: 16px; }
#form1 table tr .style20
{
	color: #FFF;
}
-->
</style></head>

<body>
<p>&nbsp;</p>
<table width="800" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td width="1002"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="190" bgcolor="#3E3E5E"><table width="99%" height="186" border="0" align="center" cellpadding="5" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="25"><div align="center">
            <table width="99%" border="0" cellspacing="2" cellpadding="2">
                <tr>
                      <td bgcolor="#333366"><div align="center"><span class="style24">FIELD DUTY - SELECT SESSION DUTY DAY</span></div></td>
                </tr>
                </table>
            </div></td>
      </tr>
      
      <tr>
        <td height="108" align="center" valign="top"><p>&nbsp;</p>
              <table width="600" border="1" align="center" cellpadding="2" cellspacing="2" bgcolor="#6666FF">
                    <tr>
                          <td width="214" height="30" align="center" valign="middle" bgcolor="#6666FF" class="style32"><div align="center" class="style43"><?php echo $_SESSION['MM_PilotName']; ?></div></td>
                          <td width="50" align="center" valign="middle" bgcolor="#6666FF" class="style32"><span class="style43"><?php echo $_SESSION['MM_duty_role']; ?></span>&nbsp;</td>
                          <td width="214" align="center" valign="middle" bgcolor="#6666FF" class="style32"><div align="center" class="style43"><?php echo $_SESSION['MM_Username']; ?></div></td>
                    </tr>
              </table>
              <table width="600" border="1" align="center" cellpadding="2" cellspacing="2" bgcolor="#6666FF">
                    <tr>
                          <td width="381" height="30" valign="middle" bgcolor="#6666FF" class="style32"><div align="center" class="style43">
                               
                                <?php If ($_SESSION['fd_active_session'] >= 1 ){ ?>
                                <p class="style20"><span class="style16">Please select three dates we can use to assign PGC field duty for the upcoming session ... only one date will be used.</span></p>
                                                               
                                <p>SESSION: <?php echo $_SESSION['fd_active_session'] ?></p><p><?php echo '  Starts: '?><?php echo $session_start ?><?php echo '  Ends: '?><?php echo $session_end ?></p>
                                <p class="style16">Member choices are assigned on a first come basis ... please make your selections asap to get your desired date.</p>
                                <?php } else {  ?>
                                 <p class="style16">Session Field Duty Date Selection is not open.</p>
                                <?php } ?>
                          </div></td>
                    </tr>
              </table>
              <p class="style16">&nbsp;</p>
              <p>&nbsp;</p>
               <?php If ($_SESSION['fd_active_session'] >= 1 ){ ?>
              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                    <table align="center" cellpadding="3">
                          <tr valign="baseline">
                                <td width="134" align="left" valign="middle" nowrap="nowrap" bgcolor="#6666FF" class="style20"><span class="style16">Choice 1:</span></td>
                                <td width="317" align="left" valign="middle" bgcolor="#6666FF"><span class="style16">
                                      <select name="choice1" id="choice1">
                                            <?php
do {  
?>
                                            <option value="<?php echo $row_fd_datesforsession['date']?>"<?php if (!(strcmp($row_fd_datesforsession['date'], $row_MemberSelections['choice1']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fd_datesforsession['date']?><?php echo '   ' ?><?php echo date('l', strtotime( $row_fd_datesforsession['date']));   ?></option>
                                            <?php
} while ($row_fd_datesforsession = mysql_fetch_assoc($fd_datesforsession));
  $rows = mysql_num_rows($fd_datesforsession);
  if($rows > 0) {
      mysql_data_seek($fd_datesforsession, 0);
	  $row_fd_datesforsession = mysql_fetch_assoc($fd_datesforsession);
  }
?>
                                      </select>
                                </span></td>
                          </tr>
                          <tr valign="baseline">
                                <td align="left" valign="middle" nowrap="nowrap" bgcolor="#6666FF" class="style20"><span class="style16">Choice 2:</span></td>
                                <td align="left" valign="middle" bgcolor="#6666FF"><span class="style16">
                                      <select name="choice2" id="choice2">
                                            <?php
do {  
?>
                                            <option value="<?php echo $row_fd_datesforsession['date']?>"<?php if (!(strcmp($row_fd_datesforsession['date'], $row_MemberSelections['choice2']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fd_datesforsession['date']?><?php echo '   ' ?><?php echo date('l', strtotime( $row_fd_datesforsession['date']));   ?></option>
                                            <?php
} while ($row_fd_datesforsession = mysql_fetch_assoc($fd_datesforsession));
  $rows = mysql_num_rows($fd_datesforsession);
  if($rows > 0) {
      mysql_data_seek($fd_datesforsession, 0);
	  $row_fd_datesforsession = mysql_fetch_assoc($fd_datesforsession);
  }
?>
                                      </select>
                                </span></td>
                          </tr>
                          <tr valign="baseline">
                                <td align="left" valign="middle" nowrap="nowrap" bgcolor="#6666FF" class="style20"><span class="style16">Choice 3:</span></td>
                                <td align="left" valign="middle" bgcolor="#6666FF"><span class="style16">
                                      <select name="choice3" id="choice3">
                                            <?php
do {  
?>
                                            <option value="<?php echo $row_fd_datesforsession['date']?>"<?php if (!(strcmp($row_fd_datesforsession['date'], $row_MemberSelections['choice3']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fd_datesforsession['date']?><?php echo '   ' ?><?php echo date('l', strtotime( $row_fd_datesforsession['date']));   ?></option>
                                            <?php
} while ($row_fd_datesforsession = mysql_fetch_assoc($fd_datesforsession));
  $rows = mysql_num_rows($fd_datesforsession);
  if($rows > 0) {
      mysql_data_seek($fd_datesforsession, 0);
	  $row_fd_datesforsession = mysql_fetch_assoc($fd_datesforsession);
  }
?>
                                      </select>
                                </span></td>
                          </tr>
                          <tr valign="baseline">
                                <td height="50" colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#6666FF"><input type="submit" value="Save Choices" /></td>
                                </tr>
                    </table>
                    <input type="hidden" name="MM_update" value="form1" />
                    <input type="hidden" name="member_id" value="<?php echo $row_MemberSelections['member_id']; ?>" />
        </form>
        
        <?php }?>
            
              <p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p></td>
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
mysql_free_result($MemberSelections);

mysql_free_result($ActiveSession);
?>
