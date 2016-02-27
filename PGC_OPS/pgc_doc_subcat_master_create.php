<?php require_once('../Connections/PGC.php'); ?>
<?php error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
$MemberName = $_SESSION['MM_PilotName'];
require_once('pgc_check_login.php'); 
mysql_select_db($database_PGC, $PGC);
$delete_Recordset1 = "DELETE FROM pgc_doc_subcategory_master WHERE rec_deleted = 'YES'";
$RecordsetD1 = mysql_query($delete_Recordset1, $PGC) or die(mysql_error());
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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$new_cat = GetSQLValueString($_POST['doc_category'], "text");

if ((isset($_POST["MM_insert"])) && ($_POST["doc_category"] <> '') && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT IGNORE INTO pgc_doc_subcategory_master (doc_category, rec_modified_id, rec_active) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['doc_category'], "text"),
                       GetSQLValueString($MemberName, "text"),
				       GetSQLValueString('YES', "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

  $insertGoTo = "pgc_doc_subcat_master_create.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_Recordset1 = 25;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_doc_subcategory_master";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;$maxRows_Recordset1 = 15;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_doc_subcategory_master ORDER BY doc_category ASC";
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

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);


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
.DocButton {
	font-family: Verdana, Geneva, sans-serif;
	font-weight: bold;
	text-align: center;
}
-->
</style>
</head>

<body>
<table width="939" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
    <tr>
      <td width="900" height="5" align="center" bgcolor="#387272"><p class="JobBanner">PGC DOCUMENT LIBRARY -  DOCUMENT SUB-CATEGORY CREATE</p></td>
  </tr>
    <tr>
      <td height="481" align="center" valign="top"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
          <table width="468" align="center">
                <tr valign="baseline" class="JobHeader">
                    <td width="165" height="49" align="right" valign="middle" nowrap="nowrap">New Document Sub-Category Name:</td>
                    <td width="256" valign="middle"><input type="text" name="doc_category" value="" size="32" /></td>
                </tr>
                <tr valign="baseline">
                    <td height="39" colspan="2" align="center" valign="middle" nowrap="nowrap"><input type="submit" value="Create Sub-Category"  /></td>
                    
                     
                    
                    
                    </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form1" />
    </form>
          <p>&nbsp;</p>
          <table width="80%" border="0" cellpadding="2" cellspacing="2" class="JobGrid">
            <tr>
                <td colspan="4" align="center" bgcolor="#314064"><span class="JobHeader">Current Document Category  Records</span></td>
                </tr>
            <tr>
                <td align="center" bgcolor="#314064"><span class="JobHeader">Document Sub-Category</span></td>
                <td align="center" bgcolor="#314064"><span class="JobHeader">Created / Modified</span></td>
                <td align="center" bgcolor="#314064"><span class="JobHeader"> Modified By</span></td>
                <td align="center" bgcolor="#314064"><span class="JobHeader">Active</span></td>
            </tr>
            <?php do { ?>
            <tr>
                <td align="center" bgcolor="#44598A"><a href="pgc_doc_subcat_master_edit.php?rec_key=<?php echo $row_Recordset1['rec_key']; ?>"><?php echo $row_Recordset1['doc_category']; ?></a></td>
                <td align="center" bgcolor="#44598A"><?php echo $row_Recordset1['rec_posted']; ?></td>
                <td align="center" bgcolor="#44598A"><?php echo $row_Recordset1['rec_modified_id']; ?></td>
                <td align="center" bgcolor="#44598A"><?php echo $row_Recordset1['rec_active']; ?></td>
            </tr>
            <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </table>
        <p>&nbsp;        
        <table border="0">
            <tr>
                <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="First.gif" /></a>
                    <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="Previous.gif" /></a>
                    <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="Next.gif" /></a>
                    <?php } // Show if not last page ?></td>
                <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="Last.gif" /></a>
                    <?php } // Show if not last page ?></td>
            </tr>
        </table>
        <p>&nbsp;</p>
        <table width="150" border="1" cellpadding="2" cellspacing="2">
            <tr>
                <td bgcolor="#3366CC" class="DocButton"><a href="pgc_docs_menu.php" class="DocButton">ADMIN MEMU</a></td>
            </tr>
    </table></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
