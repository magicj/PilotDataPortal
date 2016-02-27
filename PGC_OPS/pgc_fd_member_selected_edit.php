<?php require_once('../Connections/PGC.php'); ?>
<?php 
if (!isset($_SESSION)) {
  session_start();
}
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
if ($_POST['date_selected'] <> '') {
  $updateSQL = sprintf("UPDATE pgc_field_duty_selections SET date_selected=%s WHERE key_check=%s",
                       GetSQLValueString($_POST['date_selected'], "date"),
                       GetSQLValueString($_POST['key_check'], "text"));
  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
}

  $updateGoTo = "pgc_fd_member_selected_view.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['key_check'])) {
  $colname_Recordset1 = $_GET['key_check'];
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT key_check, member_id, member_name, fd_role, `session`, choice1, choice2, choice3, choice_status, date_selected, modified_by, modified_date, modify_ip, delete_record FROM pgc_field_duty_selections WHERE key_check = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['key_check'])) {
  $colname_Recordset2 = $_GET['key_check'];
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = sprintf("SELECT choice1 FROM pgc_field_duty_selections WHERE key_check = %s UNION SELECT choice2 FROM pgc_field_duty_selections WHERE key_check = %s UNION SELECT choice3 FROM pgc_field_duty_selections WHERE key_check = %s", GetSQLValueString($colname_Recordset2, "text"),GetSQLValueString($colname_Recordset2, "text"),GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

 
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
.style20 {
	font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.style24 {font-size: 16px; font-weight: bold; color: #CCCCCC; }
.style28 {font-size: 12px}
.style23 {font-size: 16px; font-weight: bold; color: #FFCCCC; font-style: italic; }
.style44 {color: #999999;
	font-weight: bold;
}
.style32 {font-weight: bold; color: #000000; }
.style43 {
	font-size: 18px;
	font-weight: bold;
	color: #FFF;
}
#form1 table tr .style20
{
	color: #FFF;
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
                      <td bgcolor="#333366"><div align="center">
                            <p class="style24">AFM FIELD DUTY - MEMBER REQUESTED SESSION DUTY DAYS</p>
                            <p class="style24">(Add / Edit Selected Date)</p>
                      </div></td>
                </tr>
                </table>
            </div></td>
      </tr>
      
      <tr>
        <td height="93" align="center" valign="top">&nbsp;
              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                    <table width="700" cellspacing="0" cellpadding="2">
                          <tr class="style20">
                                <td align="center" valign="middle" bgcolor="#002C40">Member ID</td>
                                <td align="center" valign="middle" bgcolor="#002C40">Member Name</td>
                                <td align="center" valign="middle" bgcolor="#002C40">Session</td>
                                <td align="center" valign="middle" bgcolor="#002C40">Choice 1</td>
                                <td align="center" valign="middle" bgcolor="#002C40">Choice 2</td>
                                <td align="center" valign="middle" bgcolor="#002C40">Choice 3</td>
                          </tr>
                          <tr class="style16">
                                <td align="center" valign="middle" bgcolor="#003F5E"><?php echo $row_Recordset1['member_id']; ?></td>
                                <td align="center" valign="middle" bgcolor="#003F5E"><?php echo $row_Recordset1['member_name']; ?></td>
                                 <td align="center" valign="middle" bgcolor="#003F5E"><?php echo $row_Recordset1['session']; ?></td>
                                <td align="center" valign="middle" bgcolor="#003F5E"><?php echo $row_Recordset1['choice1']; ?></td>
                                <td align="center" valign="middle" bgcolor="#003F5E"><?php echo $row_Recordset1['choice2']; ?></td>
                                <td align="center" valign="middle" bgcolor="#003F5E"><?php echo $row_Recordset1['choice3']; ?></td>
                          </tr>
                    </table>
                    <p>&nbsp;</p>
                    <table width="400" align="center" cellpadding="4" cellspacing="2">
                          <tr valign="baseline">
                                <td width="198" height="40" align="left" valign="middle" nowrap="nowrap" bgcolor="#1C2F5B">CHOICE SELECTED:</td>
                                <td width="299" valign="middle" bgcolor="#1C2F5B"><label for="date_selected"></label>
                                      <select name="date_selected" id="date_selected">
                                            <?php
do {  
?>
                                            <option value="<?php echo $row_Recordset2['choice1']?>"<?php if (!(strcmp($row_Recordset2['choice1'], $row_Recordset1['date_selected']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['choice1']?></option>
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
                                <td height="41" colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#1C2F5B"><input type="submit" value="Save Choice" /></td>
                                </tr>
              </table>
                    <input type="hidden" name="MM_update" value="form1" />
                    <input type="hidden" name="key_check" value="<?php echo $row_Recordset1['key_check']; ?>" />
              </form>
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
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
