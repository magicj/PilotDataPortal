<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
$MemberName = $_SESSION['MM_PilotName'];
date_default_timezone_set('America/New_York');
$date = date('Y-m-d H:i:s');

require_once('pgc_check_login.php'); 
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
  $updateSQL = sprintf("UPDATE pgc_doc_subcategory_master SET rec_posted=%s, rec_modified_id=%s, rec_active=%s, rec_deleted=%s WHERE rec_key=%s",
                       GetSQLValueString($date, "date"),
                       GetSQLValueString($MemberName, "text"),
                       GetSQLValueString($_POST['rec_active'], "text"),
                       GetSQLValueString($_POST['rec_deleted'], "text"),
                       GetSQLValueString($_POST['rec_key'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "pgc_doc_subcat_master_create.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['rec_key'])) {
  $colname_Recordset1 = $_GET['rec_key'];
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_doc_subcategory_master WHERE rec_key = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Document Library</title>
<style type="text/css">
<!--
body {
	background-color: #333333;
}
a:link {
	color: #FFFF9B;
}
a:visited {
	color: #FFFF9B;
}

.JobHeader {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bolder;
	color: #FFF;
	font-style: italic;
	text-align: center;
}
.JobBanner {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-weight: bold;
	color: #FFF;
}
.JobGrid {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #FFF;
	background-color: #666666;
	text-align: left;
	text-transform: capitalize;
}
.JobLine {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #FFF;
}
.navbox {
	background-color: #525874;
	border-top-style: outset;
	border-right-style: outset;
	border-bottom-style: outset;
	border-left-style: outset;
	border-top-color: #999;
	border-right-color: #999;
	border-bottom-color: #999;
	border-left-color: #999;
}
.FormText {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #FFF;
}
-->
</style>
</head>

<body>
<table width="939" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
    <tr>
      <td width="900" height="5" align="center" bgcolor="#387272"><p class="JobBanner">PGC SUBCAT MASTER - EDIT</p></td>
  </tr>
    <tr>
      <td height="481" align="center">&nbsp;
        <p>&nbsp;</p>
        <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
            <table width="447" align="center" cellpadding="5" cellspacing="1">
                <tr valign="baseline">
                    <td width="168" align="left" nowrap="nowrap" bgcolor="#004566"><span class="FormText">Record</span></td>
                    <td width="216" align="left" bgcolor="#004566"><span class="FormText"><?php echo $row_Recordset1['rec_key']; ?></span></td>
                </tr>
                <tr valign="baseline">
                    <td align="left" nowrap="nowrap" bgcolor="#004566"><span class="FormText">Doc Category</span></td>
                    <td align="left" bgcolor="#004566"><span class="FormText"><?php echo $row_Recordset1['doc_category']?></span></td>
                </tr>
                <tr valign="baseline">
                    <td align="left" nowrap="nowrap" bgcolor="#004566"><span class="FormText">Active (YES/NO)</span></td>
                    <td align="left" bgcolor="#004566" class="FormText"><span class="FormText">
                        <select name="rec_active" id="rec_active">
                            <option value="YES" <?php if (!(strcmp("YES", $row_Recordset1['rec_active']))) {echo "selected=\"selected\"";} ?>>YES</option>
                            <option value="NO" <?php if (!(strcmp("NO", $row_Recordset1['rec_active']))) {echo "selected=\"selected\"";} ?>>NO</option>
                    </select>
                    </span></td>
                </tr>
                <tr valign="baseline">
                    <td align="left" nowrap="nowrap" bgcolor="#004566"><span class="FormText">Delete Record (YES/NO)</span></td>
                    <td align="left" bgcolor="#004566"><span class="FormText">
                        <select name="rec_deleted" id="rec_deleted">
                            <option value="NO" <?php if (!(strcmp("NO", $row_Recordset1['rec_deleted']))) {echo "selected=\"selected\"";} ?>>NO</option>
                            <option value="YES" <?php if (!(strcmp("YES", $row_Recordset1['rec_deleted']))) {echo "selected=\"selected\"";} ?>>YES</option>
                    </select>
                    </span></td>
                </tr>
                <tr valign="baseline">
                    <td colspan="2" align="center" nowrap="nowrap" bgcolor="#004566"><input type="submit" value="Update record" /></td>
                    </tr>
            </table>
            <input type="hidden" name="MM_update" value="form1" />
            <input type="hidden" name="rec_key" value="<?php echo $row_Recordset1['rec_key']; ?>" />
        </form>
        <p>&nbsp;</p></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
