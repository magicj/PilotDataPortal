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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pgc_inventory_used (inv_used_key, sq_key, inv_category, inv_desc, inv_units_initial, inv_units_current, unit_cost, inv_vendor, last_restock_date, stock_status, updated_by, update_date, rec_deleted) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['inv_used_key'], "int"),
                       GetSQLValueString($_POST['sq_key'], "int"),
                       GetSQLValueString($_POST['inv_category'], "text"),
                       GetSQLValueString($_POST['inv_desc'], "text"),
                       GetSQLValueString($_POST['inv_units_initial'], "int"),
                       GetSQLValueString($_POST['inv_units_current'], "int"),
                       GetSQLValueString($_POST['unit_cost'], "double"),
                       GetSQLValueString($_POST['inv_vendor'], "text"),
                       GetSQLValueString($_POST['last_restock_date'], "date"),
                       GetSQLValueString($_POST['stock_status'], "text"),
                       GetSQLValueString($_POST['updated_by'], "text"),
                       GetSQLValueString($_POST['update_date'], "date"),
                       GetSQLValueString($_POST['rec_deleted'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

  $insertGoTo = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_inventory_used";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Inv_used_key:</td>
      <td><input type="text" name="inv_used_key" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Sq_key:</td>
      <td><input type="text" name="sq_key" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Inv_category:</td>
      <td><input type="text" name="inv_category" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Inv_desc:</td>
      <td><input type="text" name="inv_desc" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Inv_units_initial:</td>
      <td><input type="text" name="inv_units_initial" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Inv_units_current:</td>
      <td><input type="text" name="inv_units_current" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Unit_cost:</td>
      <td><input type="text" name="unit_cost" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Inv_vendor:</td>
      <td><input type="text" name="inv_vendor" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Last_restock_date:</td>
      <td><input type="text" name="last_restock_date" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Stock_status:</td>
      <td><input type="text" name="stock_status" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Updated_by:</td>
      <td><input type="text" name="updated_by" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Update_date:</td>
      <td><input type="text" name="update_date" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Rec_deleted:</td>
      <td><input type="text" name="rec_deleted" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
