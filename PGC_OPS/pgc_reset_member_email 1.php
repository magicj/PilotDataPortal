<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php');  
$session_email = $_SESSION['MM_Username'];
$session_member = $_SESSION['MM_PilotName'];
//$_SESSION[pw_message] = "Please enter new email address";
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
  $updateSQL = sprintf("UPDATE pgc_members SET new_user_id1=%s, new_user_id2=%s WHERE USER_ID=%s",
                       GetSQLValueString($_POST['new_user_id1'], "text"),
                       GetSQLValueString($_POST['new_user_id2'], "text"),
                       GetSQLValueString($_POST['USER_ID'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT USER_ID, new_user_id1, new_user_id2, old_user_id FROM pgc_members WHERE USER_ID = '%s'", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php

$error_type = "0";
if ($_POST['new_user_id1'] <> $_POST['new_user_id2']) {
    $error_type = "1";
    $_SESSION[pw_message] = "Entry and Re-entry do not match ... please correct";
}

If ($error_type == "0") {
    $email = $_POST['new_user_id1'];
 	If (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
       $error_type = "2";
       $_SESSION[pw_message] = "Enter new email address in abc@xxx.yyy format";
	}
}

// Check to see if Email Address already exists
If ($error_type == "0") {
	$updateSQL = sprintf("SELECT USER_ID FROM pgc_members WHERE USER_ID=%s",
					   GetSQLValueString($_POST['new_user_id1'], "text"));
	mysql_select_db($database_PGC, $PGC);
	$Recordset2 = mysql_query($updateSQL, $PGC) or die(mysql_error());
	$row_Recordset2 = mysql_fetch_assoc($Recordset2);
	$totalRows_Recordset2 = mysql_num_rows($Recordset2);
	IF($totalRows_Recordset2 > 0) {
       $error_type = "3";
       $_SESSION[pw_message] = "Your new email address already exists in the PGC databaase ... please correct";
	}
}	
	
If ($error_type == "0") {
	   // Change current Email Address in PGC members
	  $updateSQL = sprintf("UPDATE pgc_members SET USER_ID=%s WHERE USER_ID=%s",
						   GetSQLValueString($_POST['new_user_id1'], "text"),
						   GetSQLValueString($_POST['USER_ID'], "text"));
	
	  mysql_select_db($database_PGC, $PGC);
	  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
	  
 	   // Change current Email Address in PGC Pilots
	  $updateSQL = sprintf("UPDATE pgc_pilots SET e_mail=%s WHERE e_mail=%s",
						   GetSQLValueString($_POST['new_user_id1'], "text"),
						   GetSQLValueString($_POST['USER_ID'], "text"));
	
	  mysql_select_db($database_PGC, $PGC);
	  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
	  
	  $_SESSION['MM_Username'] = GetSQLValueString($_POST['new_user_id1'], "text");
	  $session_email = $_SESSION['MM_Username'];
	  	  	  
      $_SESSION[pw_message] = "Email Address Changed ... Sending Confirmation Emails";
	  $error_type = "99";

	  $old_id = $_POST['USER_ID'];
      // Save the OLD Email addreess to send confirmation email
	  $new_id = $_POST['new_user_id1'];
	  $updateSQL = sprintf("UPDATE pgc_members SET new_user_id1 = '', new_user_id2 = '', old_user_id = %s WHERE USER_ID=%s",
							GetSQLValueString($old_id, "text"),
							GetSQLValueString($new_id, "text"));
	  mysql_select_db($database_PGC, $PGC);
	  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
	  
	  // Send confirmation emails to old and new address
	  
		$message = "Your e-mail address was changed on the PGC site. Contact the PGC Webmaster or a PGC BOD member if you did not initiate this change.\n\n" . "Your new e-mail address is " . $new_id . "\n\n" . "Your old e-mail address is " . $old_id . "\n\n". "Have a good day - PGC Pilot Data Portal" ;

        $treasurer = "mattg123@verizon.net";
		$webmaster = "support@pgcsoaring.org";
		
    	$to = $new_id . "," . $old_id . "," . $treasurer . "," . $webmaster;				
		$subject = "PGC Email Address Change";
				
		$email = $_REQUEST['email'] ;
				
		$headers = "From: PGC Pilot Data Portal";
		$headers = "From: PGC-PDP@noreply.com";
				
		$sent = mail($to, $subject, $message, $headers) ;
				
		$MM_redirectMailSuccess = "../07_members_login.php";
		header("Location: " . $MM_redirectMailSuccess );
   
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
	color: #E5E5E5;
}
body {
	background-color: #283664;
	background-image: url(../images/Buttons/PGC%20copy.png);
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style11 {
	font-size: 14px;
	font-weight: bold;
}
a:link {
	color: #FFFFCC;
}
a:visited {
	color: #CCCCCC;
}
.style17 {
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
	color: #E1E1E1;
}
.style18 {font-family: Geneva, Arial, Helvetica, sans-serif}
.style111 {font-size: 16px;
	font-weight: bold;
	color: #EFEFEF;
}
.style112 {	font-size: 15px;
	font-weight: bold;
	color: #EFEFEF;
}
-->
</style>
</head>
<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
  <tr>
    <td><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="514"><table width="95%" height="544" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
        <tr>
          <td height="36" bgcolor="#3C435B"><div align="center"><span class="style11">EMAIL ADDRESS CHANGE </span></div></td>
        </tr>
        <tr>
          <td height="36" bgcolor="#3C435B"><div align="center" class="style17"><?php echo $_SESSION[pw_message]; ?></div></td>
        </tr>
        <tr>
          <td height="333" align="center" bgcolor="#3C435B"><p>&nbsp;</p>
              <table width="45%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                      <td width="50%" align="center"><span class="style11"><?php echo $session_member; ?></span></td>
                      </tr>
              </table>
              <p>&nbsp;</p>
            
              <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                  <table width="512" align="center" cellpadding="4" cellspacing="1" >
                      <tr valign="baseline">
                          <td width="227" height="23" align="right" valign="middle" nowrap bgcolor="#424A66"><div align="left"><span class="style11">CURRENT EMAIL ADDRESS </span></div></td>
                          <td width="264" valign="middle" bgcolor="#424A66"><span class="style11"><?php echo $row_Recordset1['USER_ID']; ?></span></td>
                      </tr>
                      <tr valign="baseline">
                          <td height="30" align="right" valign="middle" nowrap bgcolor="#424A66"><div align="left"><span class="style11">ENTER NEW EMAIL ADDRESS </span></div></td>
                          <td valign="middle" bgcolor="#424A66"><span class="style11">
                                <input type="text" name="new_user_id1" value="<?php echo $row_Recordset1['new_user_id1']; ?>" size="32">
                          </span></td>
                      </tr>
                      <tr valign="baseline">
                          <td height="30" align="right" valign="middle" nowrap bgcolor="#424A66"><div align="left"><span class="style11">RE-ENTER NEW EMAIL ADDRESS </span></div></td>
                          <td valign="middle" bgcolor="#424A66"><span class="style11">
                                <input type="text" name="new_user_id2" value="<?php echo $row_Recordset1['new_user_id2']; ?>" size="32">
                          </span></td>
                      </tr>
                      <tr valign="baseline">
                          <td height="47" colspan="2" align="right" valign="bottom" nowrap bgcolor="#424A66">
                              <div align="center">
                                  <input type="submit" value="Update Record">
                                  </div></td>
                          </tr>
                  </table>
                  <input type="hidden" name="MM_update" value="form1">
                  <input type="hidden" name="USER_ID" value="<?php echo $row_Recordset1['USER_ID']; ?>">
              </form>
              <p align="center" class="style17">&nbsp;</p>
              <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                      <td><p align="center" class="style17">You may  be directed back to the login screen when your e-mail address  has been updated on the system.. Confirmation e-mails will be sent to your old and new addresses ... and a copy of the e-mail changes will be sent to the PGC Treasurer. </p>
                          </td>
                  </tr>
              </table>
              <p align="center" class="style17">&nbsp;</p>
              <p>&nbsp;</p></td>
        </tr>
        <tr>
              <td height="23" align="center" bgcolor="#3C435B"><strong class="style112"><a href="../07_members_only_pw.php"><img src="../images/Buttons/GoMembers.jpg" width="133" height="24" alt="Members" /></a></strong></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
 
