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
  $updateSQL = sprintf("UPDATE pgc_members SET pw1=%s, pw2=%s WHERE NAME=%s",
                       GetSQLValueString($_POST['pw1'], "text"),
                       GetSQLValueString($_POST['pw2'], "text"),
                       GetSQLValueString($_POST['NAME'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
}


$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_PilotName'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION['MM_PilotName'] : addslashes($_SESSION['MM_PilotName']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_members WHERE NAME = '%s'", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php

  $pw1 = GetSQLValueString($_POST['pw1'], "text");
  $pw2 = GetSQLValueString($_POST['pw2'], "text");
  $name = $_SESSION['MM_PilotName'];
  $name = GetSQLValueString($_SESSION['MM_PilotName'], "text");
  
  $pw1check = preg_replace("#[^A-Za-z0-9\s]#", "", $pw1);
  $pw2check = preg_replace("#[^A-Za-z0-9\s]#", "", $pw1);

  $good_chars = "yes";
//  if ($pw1 != $pw1check OR $pw2 != $pw2check) {
//  $good_chars = "no";
//  }
   
  
 
if (strlen($pw1) > 9 and $pw1 == $pw2 and $good_chars == "yes") {
  $updateSQL = "UPDATE pgc_members SET USER_PW = $pw1, pw1 = NULL, pw2 = NULL, update_date = curdate() WHERE NAME = $name";
  mysql_select_db($database_PGC, $PGC);
  $Result2 = mysql_query($updateSQL, $PGC) or die(mysql_error());

//  $updateGoTo = "..kk_pw.php";
//  $updateGoTo = "hello.php";
    $updateGoTo = "pgc_update_pw_email.php";
	$updateGoTo = "pgc_email_pw_change.php";
	//	$updateGoTo = "../index.html";
	//	$updateGoTo = "../07_members_only_pw.php";

  $good_update ="yes";

  $_SESSION[pw_message] = "Password updated - sending confirmation email";
  

  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
   header(sprintf("Location: %s", $updateGoTo));
  
} else {
	$good_update == "no";
	if ($pw1 <> $pw2) {
	$_SESSION[pw_message] =  "Passwords do not match - please correct";
	} 
	if (strlen($pw1) < 10) {
	$_SESSION[pw_message] =  "Password length incorrect - please correct";
	} 
	if ($pw1 == 'NULL') {
	$_SESSION[pw_message] = "Enter new password - 8 alphanumeric characters minimum";  
	}
	if ($good_chars == "no") {
	$_SESSION[pw_message] = "Invalid Characters - enter new password - 8 alphanumeric characters minimum";  
	}

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Change PW</title>
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
	color: #FFFFCC;
}
a:visited {
	color: #FF99FF;
}
.style16 {color: #FFFFCC}
-->
</style>
</head>
<body>
<table width="800" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="514"><table width="92%" height="415" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
        <tr>
          <td height="36"><div align="center"><span class="style11">EMAIL ADDRESS CHANGE </span></div></td>
        </tr>
        <tr>
          <td height="36"><div align="center"><?php echo $_SESSION[pw_message]; ?></div></td>
        </tr>
        <tr>
          <td height="333">&nbsp;
            <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
              <table width="322" height="121" align="center">
                <tr valign="baseline">
                  <td width="79" align="right" nowrap><div align="left">NAME:</div></td>
                  <td width="227"><?php echo $row_Recordset1['NAME']; ?></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right"><div align="left">New PW 1:</div></td>
                  <td><input name="email1" type="text" id="email1" value="<?php echo $row_Recordset1['new_user_id1']; ?>" size="40" /></td>
                </tr>
                <tr valign="baseline">
                  <td height="45" align="right" nowrap><div align="left">New PW 2: </div></td>
                  <td><p>
                      <input name="email2" type="text" id="email2" value="<?php echo $row_Recordset1['new_user_id2']; ?>" size="40" />
                    </p></td>
                </tr>
              </table>
              <p>&nbsp; </p>
              <p align="center">
                <input name="submit" type="submit" value="Update PW" />
              </p>
              <p align="center">&nbsp;</p>
              <p align="center">System will return to the members page and send a confirmation  e-mail.</p>
              <p align="center">
                <input type="hidden" name="MM_update" value="form1">
                <input type="hidden" name="NAME" value="<?php echo $row_Recordset1['NAME']; ?>">
              </p>
            </form>
            <p>&nbsp;</p></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
//mysql_free_result($Result2);
?>
