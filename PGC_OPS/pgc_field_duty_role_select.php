<?php require_once('../Connections/PGC.php');?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
//require_once('pgc_check_login.php'); 
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
	
  // Update pgc_field_duty_selections
  $updateSQL = sprintf("UPDATE pgc_field_duty_selections SET fd_role=%s WHERE member_id=%s",
                       GetSQLValueString($_POST['duty_role'], "text"),
                       GetSQLValueString($_POST['USER_ID'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
  
	
  $updateSQL = sprintf("UPDATE pgc_members SET duty_role=%s WHERE USER_ID=%s",
                       GetSQLValueString($_POST['duty_role'], "text"),
                       GetSQLValueString($_POST['USER_ID'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "pgc_field_duty_role.php";
  $updateGoTo = 'http://' . $_SERVER['HTTP_HOST']  .$_SESSION[last_query];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_duty_role = "-1";
if (isset($_GET['USER_ID'])) {
  $colname_duty_role = $_GET['USER_ID'];
}
mysql_select_db($database_PGC, $PGC);
$query_duty_role = sprintf("SELECT USER_ID, NAME, duty_role FROM pgc_members WHERE USER_ID = %s", GetSQLValueString($colname_duty_role, "text"));
$duty_role = mysql_query($query_duty_role, $PGC) or die(mysql_error());
$row_duty_role = mysql_fetch_assoc($duty_role);
$totalRows_duty_role = mysql_num_rows($duty_role);

/*
// Default unassigned to AFM2 - No Longer Used
$updateRoleSQL = sprintf("UPDATE pgc_members SET duty_role='AFM2' WHERE duty_role IS NULL");
mysql_select_db($database_PGC, $PGC);
$RoleResult1 = mysql_query($updateRoleSQL, $PGC) or die(mysql_error());
*/

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
.style16 {
	color: #CCCCCC;
	font-size: 14px;
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
-->
</style></head>

<body>
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
                      <td bgcolor="#333366"><div align="center"><span class="style24">FIELD DUTY ROLE SELECT</span></div></td>
                </tr>
                </table>
            </div></td>
      </tr>
      
      <tr>
        <td height="108" align="center" valign="top">&nbsp;
              </p>
              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                    <table align="center" cellpadding="5">
                          <tr valign="baseline">
                                <td width="71" height="30" align="left" valign="middle" nowrap="nowrap" bgcolor="#00366C">MEMBER EMAIL</td>
                                <td width="208" height="30" valign="middle" bgcolor="#00366C"><?php echo $row_duty_role['USER_ID']; ?></td>
                          </tr>
                          <tr valign="baseline">
                                <td height="30" align="left" valign="middle" nowrap="nowrap" bgcolor="#00366C">MEMBER NAME</td>
                                <td height="30" valign="middle" bgcolor="#00366C"><?php echo $row_duty_role['NAME']; ?></td>
                          </tr>
                          <tr valign="baseline">
                                <td height="30" align="left" valign="middle" nowrap="nowrap" bgcolor="#00366C">FIELD DUTY ROLE:</td>
                                <td height="30" valign="middle" bgcolor="#00366C"><select name="duty_role" id="duty_role">
                                      <option value="AFM1" <?php if (!(strcmp("AFM1", $row_duty_role['duty_role']))) {echo "selected=\"selected\"";} ?>>AFM1</option>
                                      <option value="AFM2" <?php if (!(strcmp("AFM2", $row_duty_role['duty_role']))) {echo "selected=\"selected\"";} ?>>AFM2</option>
                                      <option value="FM1" <?php if (!(strcmp("FM1", $row_duty_role['duty_role']))) {echo "selected=\"selected\"";} ?>>FM1</option>
                                      <option value="FM2" <?php if (!(strcmp("FM2", $row_duty_role['duty_role']))) {echo "selected=\"selected\"";} ?>>FM2</option>
                                      <option value="CFIG" <?php if (!(strcmp("CFIG", $row_duty_role['duty_role']))) {echo "selected=\"selected\"";} ?>>CFIG</option>
                                      <option value="GRNDS" <?php if (!(strcmp("GRNDS", $row_duty_role['duty_role']))) {echo "selected=\"selected\"";} ?>>GRNDS</option>
                                      <option value="TP" <?php if (!(strcmp("TP", $row_duty_role['duty_role']))) {echo "selected=\"selected\"";} ?>>TP</option>
                                      <option value="I&T" <?php if (!(strcmp("I&T", $row_duty_role['duty_role']))) {echo "selected=\"selected\"";} ?>>I&T</option>
                                      <option value="SECY" <?php if (!(strcmp("SECY", $row_duty_role['duty_role']))) {echo "selected=\"selected\"";} ?>>SECY</option>
                                      <option value="TREAS" <?php if (!(strcmp("TREAS", $row_duty_role['duty_role']))) {echo "selected=\"selected\"";} ?>>TREAS</option>
                                      <option value="WEB" <?php if (!(strcmp("WEB", $row_duty_role['duty_role']))) {echo "selected=\"selected\"";} ?>>WEB</option>
<option value="N/A" <?php if (!(strcmp("N/A", $row_duty_role['duty_role']))) {echo "selected=\"selected\"";} ?>>N/A</option>
                                </select></td>
                          </tr>
                          <tr valign="baseline">
                                <td height="30" colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#00366C"><input type="submit" value="Update record" /></td>
                                </tr>
                    </table>
                    <input type="hidden" name="MM_update" value="form1" />
                    <input type="hidden" name="USER_ID" value="<?php echo $row_duty_role['USER_ID']; ?>" />
              </form>
              <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td height="33"><div align="center" class="style20">
            <p><a href="pgc_fd_menu.php" class="style16">BACK TO FD MENU</a><a href="../07_members_only_pw.php" class="style16"></a></p>
</div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($duty_role);
?>
