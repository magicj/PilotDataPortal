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
  $updateSQL = sprintf("UPDATE pgc_signoff_types SET description=%s, target_group=%s, expires=%s, duration_days=%s, eom_expiry=%s, member_updates=%s, yearly_reset=%s, reset_group=%s, default_signoff_date=%s, default_expire_date=%s, calc_expire_date=%s, active=%s, last_update_date=%s, last_update_id=%s, delete_record=%s WHERE signoffID=%s",
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['target_group'], "text"),
                       GetSQLValueString($_POST['expires'], "text"),
                       GetSQLValueString($_POST['duration_days'], "int"),
                       GetSQLValueString($_POST['eom_expiry'], "text"),
                       GetSQLValueString($_POST['member_updates'], "text"),
                       GetSQLValueString($_POST['yearly_reset'], "text"),
                       GetSQLValueString($_POST['reset_group'], "text"),
                       GetSQLValueString($_POST['default_signoff_date'], "date"),
                       GetSQLValueString($_POST['default_expire_date'], "date"),
                       GetSQLValueString($_POST['calc_expire_date'], "text"),
                       GetSQLValueString($_POST['active'], "text"),
                       GetSQLValueString($_POST['last_update_date'], "date"),
                       GetSQLValueString($_POST['last_update_id'], "text"),
                       GetSQLValueString($_POST['delete_record'], "text"),
                       GetSQLValueString($_POST['signoffID'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "pgc_update_signoff_type.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_rsSignoffTypes = 10;
$pageNum_rsSignoffTypes = 0;
if (isset($_GET['pageNum_rsSignoffTypes'])) {
  $pageNum_rsSignoffTypes = $_GET['pageNum_rsSignoffTypes'];
}
$startRow_rsSignoffTypes = $pageNum_rsSignoffTypes * $maxRows_rsSignoffTypes;

mysql_select_db($database_PGC, $PGC);
$query_rsSignoffTypes = "SELECT * FROM pgc_signoff_types";
$query_limit_rsSignoffTypes = sprintf("%s LIMIT %d, %d", $query_rsSignoffTypes, $startRow_rsSignoffTypes, $maxRows_rsSignoffTypes);
$rsSignoffTypes = mysql_query($query_limit_rsSignoffTypes, $PGC) or die(mysql_error());
$row_rsSignoffTypes = mysql_fetch_assoc($rsSignoffTypes);

if (isset($_GET['totalRows_rsSignoffTypes'])) {
  $totalRows_rsSignoffTypes = $_GET['totalRows_rsSignoffTypes'];
} else {
  $all_rsSignoffTypes = mysql_query($query_rsSignoffTypes);
  $totalRows_rsSignoffTypes = mysql_num_rows($all_rsSignoffTypes);
}
$totalPages_rsSignoffTypes = ceil($totalRows_rsSignoffTypes/$maxRows_rsSignoffTypes)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Update Signoff Type</title>
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
.style13 {font-size: 14px; font-weight: bold; }
.style15 {font-size: 14px; font-weight: bold; color: #FFFFFF; }
a:link {
	color: #FFFFCC;
}
a:visited {
	color: #FF99FF;
}
-->
</style></head>

<body>
<table width="800" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="514"><table width="92%" height="417" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36"><div align="center"><span class="style11">UPDATE SIGNOFF TYPE </span></div></td>
      </tr>
      <tr>
        <td height="373">&nbsp;
          <p>&nbsp;</p>
          
            <table border="1" cellpadding="2">
            <tr>
              <td bgcolor="#0C3E43"><div align="center">ID</div></td>
              <td bgcolor="#0C3E43"><div align="center">DESC</div></td>
              <td bgcolor="#0C3E43"><div align="center">TARGET</div></td>
              <td bgcolor="#0C3E43"><div align="center">EXPIRES</div></td>
              <td bgcolor="#0C3E43"><div align="center">DAYS</div></td>
              <td bgcolor="#0C3E43"><div align="center">EXPIRY</div></td>
              <td bgcolor="#0C3E43"><div align="center">MEMBER</div></td>
              <td bgcolor="#0C3E43"><div align="center">YRLY</div></td>
              <td bgcolor="#0C3E43"><div align="center">ID</div></td>
              <td bgcolor="#0C3E43"><div align="center">DEFAULT SIGNOFF </div></td>
              <td bgcolor="#0C3E43"><div align="center">DEFAULT EXPIRE </div></td>
              <td bgcolor="#0C3E43"><div align="center">CALC EXPIRE </div></td>
              <td bgcolor="#0C3E43"><div align="center">ACTIVE</div></td>
              </tr>
            <?php do { ?>
              <tr>
                <td><?php echo $row_rsSignoffTypes['signoffID']; ?></td>
                <td><?php echo $row_rsSignoffTypes['description']; ?></td>
                <td><?php echo $row_rsSignoffTypes['target_group']; ?></td>
                <td><?php echo $row_rsSignoffTypes['expires']; ?></td>
                <td><?php echo $row_rsSignoffTypes['duration_days']; ?></td>
                <td><?php echo $row_rsSignoffTypes['eom_expiry']; ?></td>
                <td><?php echo $row_rsSignoffTypes['member_updates']; ?></td>
                <td><div align="center"><?php echo $row_rsSignoffTypes['yearly_reset']; ?></div></td>
                <td><?php echo $row_rsSignoffTypes['reset_group']; ?></td>
                <td><?php echo $row_rsSignoffTypes['default_signoff_date']; ?></td>
                <td><?php echo $row_rsSignoffTypes['default_expire_date']; ?></td>
                <td><?php echo $row_rsSignoffTypes['calc_expire_date']; ?></td>
                <td><?php echo $row_rsSignoffTypes['active']; ?></td>
              </tr>
              <?php } while ($row_rsSignoffTypes = mysql_fetch_assoc($rsSignoffTypes)); ?>
          </table>
          <p>&nbsp;</p>
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
            <table width="658" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#420000" bgcolor="#333333">
              <tr valign="baseline">
                <td width="120" align="right" nowrap bordercolor="#000000" bgcolor="#0C3E43"><div align="left">SIGNOFF ID:</div></td>
                <td width="192" bordercolor="#000000" bgcolor="#0C3E43"><?php echo $row_rsSignoffTypes['signoffID']; ?></td>
                <td width="120" bordercolor="#000000" bgcolor="#0C3E43">&nbsp;</td>
                <td width="216" bordercolor="#000000" bgcolor="#0C3E43">&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bordercolor="#000000" bgcolor="#0C3E43"><div align="left">DESCRIPTION</div></td>
                <td bordercolor="#000000" bgcolor="#0C3E43"><input type="text" name="description" value="<?php echo $row_rsSignoffTypes['description']; ?>" size="32"></td>
                <td align="right" nowrap="nowrap" bordercolor="#000000" bgcolor="#0C3E43"><div align="left"></div></td>
                <td bordercolor="#000000" bgcolor="#0C3E43">&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bordercolor="#000000" bgcolor="#0C3E43"><div align="left">TARGET GROUP</div></td>
                <td bordercolor="#000000" bgcolor="#0C3E43"><input type="text" name="target_group" value="<?php echo $row_rsSignoffTypes['target_group']; ?>" size="32"></td>
                <td align="right" nowrap="nowrap" bordercolor="#000000" bgcolor="#0C3E43"><div align="left">DEFAULT SIGNOFF DATE </div></td>
                <td bordercolor="#000000" bgcolor="#0C3E43"><input type="text" name="default_signoff_date" value="<?php echo $row_rsSignoffTypes['default_signoff_date']; ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bordercolor="#000000" bgcolor="#0C3E43"><div align="left">EXPIRES (Y/N)</div></td>
                <td bordercolor="#000000" bgcolor="#0C3E43"><input type="text" name="expires" value="<?php echo $row_rsSignoffTypes['expires']; ?>" size="32"></td>
                <td align="right" nowrap="nowrap" bordercolor="#000000" bgcolor="#0C3E43"><div align="left">DEFAULT EXPIRE DATE</div></td>
                <td bordercolor="#000000" bgcolor="#0C3E43"><input type="text" name="default_expire_date" value="<?php echo $row_rsSignoffTypes['default_expire_date']; ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bordercolor="#000000" bgcolor="#0C3E43"><div align="left">SIGNOFF DURATION (DAYS)</div></td>
                <td bordercolor="#000000" bgcolor="#0C3E43"><input type="text" name="duration_days" value="<?php echo $row_rsSignoffTypes['duration_days']; ?>" size="32"></td>
                <td align="right" nowrap="nowrap" bordercolor="#000000" bgcolor="#0C3E43"><div align="left">AUTO CALC EXPIRE DT</div></td>
                <td bordercolor="#000000" bgcolor="#0C3E43"><input type="text" name="calc_expire_date" value="<?php echo $row_rsSignoffTypes['calc_expire_date']; ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bordercolor="#000000" bgcolor="#0C3E43"><div align="left">EOM EXPIRY (Y/N)</div></td>
                <td bordercolor="#000000" bgcolor="#0C3E43"><input type="text" name="eom_expiry" value="<?php echo $row_rsSignoffTypes['eom_expiry']; ?>" size="32"></td>
                <td align="right" nowrap="nowrap" bordercolor="#000000" bgcolor="#0C3E43"><div align="left">ACTIVE (Y/N) </div></td>
                <td bordercolor="#000000" bgcolor="#0C3E43"><input type="text" name="active" value="<?php echo $row_rsSignoffTypes['active']; ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bordercolor="#000000" bgcolor="#0C3E43"><div align="left">MEMBER UPDATES (Y/N) </div></td>
                <td bordercolor="#000000" bgcolor="#0C3E43"><input type="text" name="member_updates" value="<?php echo $row_rsSignoffTypes['member_updates']; ?>" size="32"></td>
                <td align="right" nowrap="nowrap" bordercolor="#000000" bgcolor="#0C3E43">&nbsp; </td>
                <td bordercolor="#000000" bgcolor="#0C3E43">&nbsp; </td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bordercolor="#000000" bgcolor="#0C3E43"><div align="left">RESET YEARLY (Y/N):</div></td>
                <td bordercolor="#000000" bgcolor="#0C3E43"><input type="text" name="yearly_reset" value="<?php echo $row_rsSignoffTypes['yearly_reset']; ?>" size="32"></td>
                <td align="right" nowrap="nowrap" bordercolor="#000000" bgcolor="#0C3E43">&nbsp; </td>
                <td bordercolor="#000000" bgcolor="#0C3E43">&nbsp; </td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bordercolor="#000000" bgcolor="#0C3E43"><div align="left">RESET GROUP ID</div></td>
                <td bordercolor="#000000" bgcolor="#0C3E43"><input type="text" name="reset_group" value="<?php echo $row_rsSignoffTypes['reset_group']; ?>" size="32"></td>
                <td align="right" nowrap="nowrap" bordercolor="#000000" bgcolor="#0C3E43"><div align="left">DELETE RECORD (Y/N)</div></td>
                <td bordercolor="#000000" bgcolor="#0C3E43"><input type="text" name="delete_record" value="<?php echo $row_rsSignoffTypes['delete_record']; ?>" size="32" /></td>
              </tr>
              
              <tr valign="baseline">
                <td align="right" nowrap bordercolor="#000000" bgcolor="#0C3E43">&nbsp;</td>
                <td bordercolor="#000000" bgcolor="#0C3E43">&nbsp;</td>
                <td bordercolor="#000000" bgcolor="#0C3E43">&nbsp;</td>
                <td bordercolor="#000000" bgcolor="#0C3E43">&nbsp;</td>
              </tr>
              
              <tr valign="baseline">
                <td align="right" nowrap bordercolor="#000000" bgcolor="#0C3E43">&nbsp;</td>
                <td bordercolor="#000000" bgcolor="#0C3E43">&nbsp;</td>
                <td bordercolor="#000000" bgcolor="#0C3E43">&nbsp;</td>
                <td bordercolor="#000000" bgcolor="#0C3E43">&nbsp;</td>
              </tr>
              
              <tr valign="baseline">
                <td align="right" nowrap bordercolor="#000000" bgcolor="#0C3E43">&nbsp;</td>
                <td bordercolor="#000000" bgcolor="#0C3E43"><input type="submit" value="Update record"></td>
                <td bordercolor="#000000" bgcolor="#0C3E43">&nbsp;</td>
                <td bordercolor="#000000" bgcolor="#0C3E43">&nbsp;</td>
              </tr>
            </table>
            <input type="hidden" name="MM_update" value="form1">
            <input type="hidden" name="signoffID" value="<?php echo $row_rsSignoffTypes['signoffID']; ?>">
          </form>
          <p>&nbsp;</p></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsSignoffTypes);
?>