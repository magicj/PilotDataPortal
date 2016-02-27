<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
$_SESSION[alias_msg] = "Enter New Member Alias";
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
  
  
  $checkSQL = sprintf("SELECT * FROM pgc_members  WHERE USER_ALIAS=%s",
                       GetSQLValueString($_POST['USER_ALIAS'], "text"));
  mysql_select_db($database_PGC, $PGC);
  $Check1 = mysql_query($checkSQL, $PGC) or die(mysql_error());
  $totalRows_Check1 = mysql_num_rows($Check1);  
  $_SESSION[alias_msg] = "Member Alias must be 3 - 30 characters ... select another or exit.";
  
  if (strlen($_POST['USER_ALIAS']) > 2 ) {
	  
	   $_SESSION[alias_msg] = "Selected Member Alias already in use ... select another or exit.";
  
	  if ($totalRows_Check1 < 1) {
	  $updateSQL = sprintf("UPDATE pgc_members SET USER_ALIAS=%s WHERE USER_ID=%s",
						   GetSQLValueString($_POST['USER_ALIAS'], "text"),
						   GetSQLValueString($_POST['USER_ID'], "text"));
	
	  mysql_select_db($database_PGC, $PGC);
	  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
	
	  $updateGoTo = "../07_members_only_pw.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  header(sprintf("Location: %s", $updateGoTo));
	  }
  } 
}

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_members";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_members WHERE USER_ID = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Update Alias</title>
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
.style2 {
	font-size: 14px;
	font-weight: bold;
}
.style16 {
	color: #CCCCCC;
	text-align: center;
	font-weight: bold;
}
a:link {
	color: #CCCCCC;
}
a:visited {
	color: #CCCCCC;
}
.style17 {
	color: #CCCCCC;
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
.style18 {font-family: Geneva, Arial, Helvetica, sans-serif}
.style19 {color: #CCCCCC; font-size: 14px; font-weight: bold; font-style: italic; font-family: Geneva, Arial, Helvetica, sans-serif; }
.AliasTable {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: normal;
	color: #2B376A;
	background-color: #666;
}
.style16 {
	font-size: 18px;
}
.style16 {
	font-size: 16px;
}
.alias_msg {
	text-align: center;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
	color: #FFC;
}
.aliasheader {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #E8E8E8;
}
.table-font
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #E8E8E8;
}
.style11 {	font-size: 15px;
	font-weight: bold;
	color: #EFEFEF;
}
-->
</style></head>

<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
  <tr>
    <td><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="510"><table width="97%" height="479" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#005B5B">
      <tr>
        <td height="24" align="center" bgcolor="#424A66"><div align="center" class="style2">CREATE or UPDATE MEMBER ALIAS</div></td>
      </tr>
      <tr>
        <td height="398" bgcolor="#424A66"><table width="99%" cellpadding="5" cellspacing="0">
          <tr>
            <td bgcolor="#394057"><p class="style16"><span class="aliasheader">&nbsp;Member Alias can be used as your Login  ID for the PGC member section.</span></p>
              <p class="style16"><span class="aliasheader">Must be 3 - 30 characters</span></p>
              <p class="style16"><span class="aliasheader">Ths screen will return to members section when your Alias is accepted.</span></p>
              <p class="style16"><span class="aliasheader">You can then login to the PGC Members section using your ALIAS or your E-MAIL ID.</span></p>
              <p class="style16"><span class="aliasheader">Thanks to Phil Klauder for suggesting this feature.</span></p></td>
            </tr>
  </table>
  <p class="style16">&nbsp; </p>
          <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
            <table width="455" align="center" cellpadding="4" cellspacing="1" class="AliasTable">
              <tr valign="baseline">
                <td width="130" height="29" align="left" valign="middle" nowrap="nowrap" bgcolor="#3C496A" class="table-font">MEMBER NAME</td>
                <td width="304" valign="middle" bgcolor="#3C496A" class="table-font"><?php echo $row_Recordset1['NAME'] ?></td>
                </tr>
              <tr valign="baseline">
                <td height="27" align="left" valign="middle" nowrap="nowrap" bgcolor="#3C496A" class="table-font">MEMBER  EMAIL ID</td>
                <td valign="middle" bgcolor="#3C496A" class="table-font"><?php echo $row_Recordset1['USER_ID']; ?></td>
                </tr>
              <tr valign="baseline">
                <td height="54" align="left" valign="middle" nowrap="nowrap" bgcolor="#3C496A" class="table-font">MEMBER  ALIAS:</td>
                <td valign="middle" bgcolor="#3C496A"><input type="text" name="USER_ALIAS" value="<?php echo htmlentities($row_Recordset1['USER_ALIAS'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                </tr>
              <tr valign="baseline">
                <td height="32" colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#3C496A"><input type="submit" value="Update record" /></td>
                </tr>
              </table>
            <input type="hidden" name="MM_update" value="form1" />
            <input type="hidden" name="USER_ID" value="<?php echo $row_Recordset1['USER_ID']; ?>" />
            </form>
          <p class="alias_msg"><?php echo $_SESSION[alias_msg] ?>&nbsp;</p></td>
      </tr>
      <tr>
        <td height="21" bgcolor="#424A66" class="style16"><div align="center"><a href="../07_members_only_pw.php" class="style17"><strong class="style11"><a href="../07_members_only_pw.php"><img src="../images/Buttons/GoMembers.jpg" width="133" height="24" alt="Members" /></a></strong></a></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
