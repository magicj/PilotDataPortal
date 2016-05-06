<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
$session_email = $_SESSION['MM_Username'];

//require_once('pgc_check_login_admin.php'); 

// Check if copies of the fields have been saved ... if not, then save 

$updateSQL = sprintf("SELECT * FROM pgc_member_roster where customer=%s",
            GetSQLValueString($_SESSION['MM_PilotName'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result3 = mysql_query($updateSQL, $PGC) or die(mysql_error());
  $row_Recordset3 = mysql_fetch_assoc($Result3 );
    
If ($row_Recordset3['customer'] != $row_Recordset3['customer2']) {

$updateSQL = sprintf("UPDATE pgc_member_roster SET customer2=customer, phone2=phone, alt_phone2=alt_phone, street2=street, city2=city, state2=state, zip2=zip, email2=email, customer_type2=customer_type, cell_number2=cell_number, pgc_start_date2=pgc_start_date, glider_license2=glider_license WHERE customer=%s",
                        GetSQLValueString($_SESSION['MM_PilotName'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_PilotName'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION['MM_PilotName'] : addslashes($_SESSION['MM_PilotName']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_member_roster WHERE customer = '%s'", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
  $updateSQL = sprintf("UPDATE pgc_member_roster SET phone=%s, alt_phone=%s, street=%s, city=%s, `state`=%s, zip=%s, cell_number=%s WHERE customer=%s",
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['alt_phone'], "text"),
                       GetSQLValueString($_POST['street'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['state'], "text"),
                       GetSQLValueString($_POST['zip'], "text"),
                       GetSQLValueString($_POST['cell_number'], "text"),
                       GetSQLValueString($_SESSION['MM_PilotName'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
  
  
  $updateGoTo = "../pgc_ops/pgc_update_roster_sendemail.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
  
}

//mysql_select_db($database_PGC, $PGC);
//$query_Recordset1 = "SELECT * FROM pgc_member_roster";
//$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
//$row_Recordset1 = mysql_fetch_assoc($Recordset1);
//$totalRows_Recordset1 = mysql_num_rows($Recordset1);
//
////require_once('pgc_check_login_admin.php'); 
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Add Signoff Type</title>
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
.style16 {color: #CCCCCC; }
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
.style11 {	font-size: 15px;
	font-weight: bold;
	color: #EFEFEF;
}
-->
</style></head>

<body>
<div align="center"></div>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
  <tr>
    <td><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="510"><table width="97%" height="479" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#005B5B">
      <tr>
            <td height="24" bgcolor="#424A66"><div align="center" class="style2">UPDATE MEMBER ROSTER INFORMATION </div></td>
      </tr>
      <tr>
            <td height="398" bgcolor="#424A66"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                  <table width="778" align="center" cellpadding="5" cellspacing="2" bordercolor="#005B5B" bgcolor="#424A66">
                        <tr valign="baseline">
                              <td height="40" colspan="5" align="right" nowrap="nowrap" class="style17"> <div align="left"><?php echo $row_Recordset1['customer']; ?></div>                        </td>
                              </tr>
                        <tr valign="baseline">
                              <td width="66" align="right" nowrap="nowrap" class="style19"><div align="left">Home:</div></td>
                              <td width="252"><input type="text" name="phone" value="<?php echo $row_Recordset1['phone']; ?>" size="32" /></td>
                              <td width="61">&nbsp;</td>
                              <td width="74" align="right" nowrap="nowrap" class="style17"><div align="left" class="style18">Street:</div></td>
                              <td width="261"><input type="text" name="street" value="<?php echo $row_Recordset1['street']; ?>" size="32" /></td>
                              </tr>
                        <tr valign="baseline">
                              <td align="right" nowrap="nowrap" class="style19"><div align="left">Work:</div></td>
                              <td><input type="text" name="alt_phone" value="<?php echo $row_Recordset1['alt_phone']; ?>" size="32" /></td>
                              <td>&nbsp;</td>
                              <td align="right" nowrap="nowrap" class="style17"><div align="left" class="style18">City:</div></td>
                              <td><input type="text" name="city" value="<?php echo $row_Recordset1['city']; ?>" size="32" /></td>
                              </tr>
                        <tr valign="baseline">
                              <td align="right" nowrap="nowrap" class="style19"><div align="left">Cell:</div></td>
                              <td><input type="text" name="cell_number" value="<?php echo $row_Recordset1['cell_number']; ?>" size="32" /></td>
                              <td>&nbsp;</td>
                              <td align="right" nowrap="nowrap" class="style17"><div align="left" class="style18">State:</div></td>
                              <td><input type="text" name="state" value="<?php echo $row_Recordset1['state']; ?>" size="32" /></td>
                              </tr>
                        <tr valign="baseline">
                              <td nowrap="nowrap" align="right">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="right" nowrap="nowrap" class="style17"><div align="left" class="style18">Zip:</div></td>
                              <td><input type="text" name="zip" value="<?php echo $row_Recordset1['zip']; ?>" size="32" /></td>
                              </tr>
                        <tr valign="baseline">
                              <td height="31" align="right" nowrap="nowrap">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              </tr>
                        <tr valign="baseline">
                              <td colspan="5" align="right" nowrap="nowrap"><div align="center">
                                    <input name="submit" type="submit" value="Update Record" />
                                    </div></td>
                              </tr>
                        </table>
                  <input type="hidden" name="MM_update" value="form1" />
                  <input type="hidden" name="customer" value="<?php echo $row_Recordset1['customer']; ?>" />
            </form>
                  <p align="center" class="style19">The PDP will send an e-mail of entered changes to the PGC Treasurer to update billing and contact information in the accounting system. You will receive a copy of this email to verify the changed data. </p>
                  <p align="center" class="style19">No e-mail will be sent if no changes are made. </p></td>
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

function check_input($data, $problem='')
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if ($problem && strlen($data) == 0)
    {
        show_error($problem);
    }
    return $data;
}
?>
