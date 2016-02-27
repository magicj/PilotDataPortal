<?php require_once('../Connections/PGC.php'); ?>
<?php error_reporting(0); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
  $insertSQL = sprintf("INSERT IGNORE INTO pgc_email_master (email_purpose, email_notes, email_names, email_addresses) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['email_purpose'], "text"),
                       GetSQLValueString($_POST['email_notes'], "text"),
                       GetSQLValueString($_POST['email_names'], "text"),
                       GetSQLValueString($_POST['email_addresses'], "text"));

IF ($_POST['email_purpose'] <> '') {
  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
}

  $insertGoTo = "pgc_email_master_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
    header(sprintf("Location: %s", $insertGoTo));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - EMAIL MASTER CREATE </title>
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
a:link {
	color: #999999;
}
.style44 {color: #999999;
	font-weight: bold;
}
.style47 {color: #FF0000; font-weight: bold; }
a:visited {
	color: #999999;
}
a:hover {
	color: #999999;
}
a:active {
	color: #999999;
}
#form1 table
{
	font-weight: bold;
	font-size: 14px;
}
-->
</style></head>

<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
  <tr>
    <td bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="476"><table width="92%" height="456" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36" bgcolor="#4F5359"><div align="center"><span class="style11">EMAIL MASTER - CREATE</span></div></td>
      </tr>
      <tr>
        <td height="373" align="center" valign="top" bgcolor="#424A66"><p>This application is used to identify the people who should get e-mails that are created by the system .. or who are listed as club contacts.&nbsp;</p>
              <p>In most cases, the specific member creating or updating a request gets an e-mail ... in addition, the manager of that task/area also gets copied on the e-mail to advise of the request or change. This app updates the e-mail target(s) for the latter.</p>
              <p>&nbsp;</p>
              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                    <table align="center">
                          <tr valign="baseline">
                                <td align="left" valign="top" nowrap="nowrap" class="style16">Lookup Key:</td>
                                <td><input name="email_purpose" type="text" value="" size="50" maxlength="50" /></td>
                          </tr>
                          <tr valign="baseline">
                                <td align="left" valign="top" nowrap="nowrap" class="style16">Usage Notes:</td>
                                <td><textarea name="email_notes" cols="50" rows="4"></textarea></td>
                          </tr>
                          <tr valign="baseline">
                                <td align="left" valign="top" nowrap="nowrap" class="style16">Display Name(s):</td>
                                <td><textarea name="email_names" cols="50" rows="4"></textarea></td>
                          </tr>
                          <tr valign="baseline">
                                <td align="left" valign="top" nowrap="nowrap" class="style16">Email Addresses:</td>
                                <td><textarea name="email_addresses" cols="50" rows="6"></textarea></td>
                          </tr>
                          <tr valign="baseline">
                                <td nowrap="nowrap" align="right">&nbsp;</td>
                                <td><input type="submit" value="Insert record" /></td>
                          </tr>
                    </table>
                    <input type="hidden" name="MM_insert" value="form1" />
              </form>
              <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td height="37" align="center" valign="top" bgcolor="#4F5359"><strong class="style11"><a href="../PGC_OPS/pgc_portal_menu.php" class="style16">BACK TO MAIN</a> </strong></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

