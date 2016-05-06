<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
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

$maxRows_Recordset1 = 20;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_email_master ORDER BY email_key ASC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;
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
        <td height="36" bgcolor="#4F5359"><div align="center">
              <table width="90%" cellspacing="1" cellpadding="1">
                    <tr>
                          <td width="21%">&nbsp;</td>
                          <td width="55%" align="center"><span class="style11">EMAIL MASTER - LIST</span></td>
                          <td width="24%" align="center"><a href="pgc_email_master_create.php">ADD RECORD</a></td>
                    </tr>
        </table>
        </div></td>
      </tr>
      <tr>
        <td height="373" align="center" valign="top" bgcolor="#424A66"><p>This application is used to identify the people who should get e-mails that are created by the system .. or who are listed as club contacts.&nbsp;</p>
              <p>In most cases, the specific member creating or updating a request gets an e-mail ... in addition, the manager of that task/area also gets copied on the e-mail to advise of the request or change. This app updates the e-mail target(s) for the latter.</p>
              <p>&nbsp;</p>
              <table width="95%" border="0" cellpadding="2" cellspacing="5">
                    <tr class="style44">
                          <td width="5" align="center" bgcolor="#35415B"> Record</td>
                          <td align="center" bgcolor="#35415B">Link / Lookup Key</td>
                          <td align="center" bgcolor="#35415B"> Notes</td>
                          <td align="center" bgcolor="#35415B">Display Name(s)</td>
                          <td align="center" bgcolor="#35415B">Email Address String</td>
                          </tr>
                    <?php do { ?>
                          <tr>
                                <td align="left" bgcolor="#35415B"><a href="pgc_email_master_edit.php?email_key=<?php echo $row_Recordset1['email_key'];?>"><?php echo $row_Recordset1['email_key']; ?></a></td>
                                <td align="left" bgcolor="#35415B"><?php echo $row_Recordset1['email_purpose']; ?></td>
                                <td align="left" bgcolor="#35415B"><?php echo $row_Recordset1['email_notes']; ?></td>
                                <td align="left" bgcolor="#35415B"><?php echo $row_Recordset1['email_names']; ?></td>
                                <td align="left" bgcolor="#35415B"><?php echo $row_Recordset1['email_addresses']; ?></td>
                                </tr>
                          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
              </table></td>
      </tr>
      <tr>
        <td height="37" align="center" valign="top" bgcolor="#4F5359"><strong class="style11"><a href="../PGC_OPS/pgc_portal_menu.php" class="style16">BACK TO MAIN</a> </strong></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
