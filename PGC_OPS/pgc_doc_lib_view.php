<?php require_once('../Connections/PGC.php'); ?>
<?php error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php');
if (!isset($_GET['doc_combo_key'])) {
  $_GET['doc_combo_key'] = 'ALL';
}
/* Update Path addresses - remove first*/
mysql_select_db($database_PGC, $PGC);
//$runSQL = "UPDATE pgc_doc_lib_list SET doc_path = (SELECT doc_path FROM pgc_doc_category WHERE pgc_doc_lib_list.doc_category = pgc_doc_category.doc_category AND pgc_doc_lib_list.doc_sub_category = pgc_doc_category.doc_sub_category)";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//$runSQL = "UPDATE pgc_doc_lib_list SET doc_upload_link = CONCAT(doc_path, '/' , doc_file_name)";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
$runSQL = "UPDATE pgc_doc_lib_list SET combo_key = CONCAT(doc_category, ' ~ ' , doc_sub_category)";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
$runSQL = "UPDATE pgc_doc_lib_list SET date_posted = date_format(doc_posted,'%M %e, %Y')";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
/* Update Combos */
$runSQL2 = "INSERT IGNORE INTO pgc_doc_combos (doc_category, doc_sub_category, doc_combo) SELECT doc_category, doc_sub_category, CONCAT(doc_category, ' ~ ' , doc_sub_category) FROM pgc_doc_lib_list  WHERE doc_display = 'YES'";
$Result2 = mysql_query($runSQL2, $PGC) or die(mysql_error());
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

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;


if ($_GET['doc_combo_key'] == 'ALL' ) {
$colname_Recordset1 = "-1";
if (isset($_GET['doc_combo_key'])) {
  $colname_Recordset1 = $_GET['doc_combo_key'];
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT rec_id, doc_file_name, doc_display_name, doc_category, doc_sub_category, doc_source, date_format(doc_posted,'%M %e, %Y') as docdate, date_posted, doc_display, doc_modified_id, doc_path, doc_upload_link, combo_key FROM pgc_doc_lib_list WHERE doc_display = 'YES' ORDER BY doc_category, doc_sub_category, doc_display_name";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

} else {

$colname_Recordset1 = "-1";
if (isset($_GET['doc_combo_key'])) {
  $colname_Recordset1 = $_GET['doc_combo_key'];
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT rec_id, doc_file_name, doc_display_name, doc_category, doc_sub_category, doc_source, doc_posted, date_posted, doc_modified_id, doc_reader, doc_display, doc_path, doc_upload_link, combo_key FROM pgc_doc_lib_list WHERE doc_display = 'YES' AND combo_key = %s ORDER BY doc_category, doc_sub_category, doc_display_name", GetSQLValueString($colname_Recordset1, "text"));

// Reverse Sort Minutes - Make this a flag with the next release 
if ($_GET['doc_combo_key'] == 'Governance ~ BOD Minutes' ) {
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT rec_id, doc_file_name, doc_display_name, doc_category, doc_sub_category, doc_source, doc_posted, date_posted, doc_modified_id, doc_reader, doc_display, doc_path, doc_upload_link, combo_key FROM pgc_doc_lib_list WHERE doc_display = 'YES' AND combo_key = %s ORDER BY doc_category, doc_sub_category, doc_display_name DESC", GetSQLValueString($colname_Recordset1, "text"));
}

$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

	
}

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = "SELECT DISTINCT combo_key FROM pgc_doc_lib_list ORDER BY combo_key ASC";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

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
	background-color: #283664;
	background-image: url(../images/Buttons/PGC%20copy.png);
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
.DocButton {	font-family: Verdana, Geneva, sans-serif;
	font-weight: bold;
	text-align: center;
}
.SmallWhite {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #FFF;
}
.style11 {	font-size: 15px;
	font-weight: bold;
	color: #EFEFEF;
}
-->
</style>
</head>

<body>
<table width="1200" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
    <tr>
      <td height="20" align="center" bgcolor="#152B55"><table width="80%" cellspacing="0" cellpadding="0">
          <tr>
              <td height="34" align="center"><span class="JobBanner">MEMBER VIEW - PGC DOCUMENT LIBRARY</span></td>
          </tr>
        </table></td>
  </tr>
    <tr>
      <td height="481" align="center"><table width="98%" height="447" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
            
            <tr>
              <td height="373" colspan="5" align="center" valign="top" bgcolor="#424A66"><table width="95%" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="52%" height="36"><strong class="style11"><a href="../07_members_only_pw.php"><img src="../images/Buttons/GoMembers.jpg" width="133" height="24" alt="Members" /></a></strong></td>
                    <td width="0%" align="right" valign="top" class="JobHeader">&nbsp;</td>
                    <td width="48%" align="left"><label for="select"></label>
                      <form id="form1" name="form1" method="get" action="pgc_doc_lib_view.php">
                        <select name="doc_combo_key" id="select">
                          <option value="ALL"   <?php if ($_SESSION['doc_combo_key'] == 'ALL') {echo "selected=\"selected\"";} ?> <?php if (!(strcmp("ALL", $_GET['doc_combo_key']))) {echo "selected=\"selected\"";} ?>>ALL</option>
                          <?php
do {  
?>
                          <option value="<?php echo $row_Recordset2['combo_key']?>"<?php if (!(strcmp($row_Recordset2['combo_key'], $_GET['doc_combo_key']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['combo_key']?></option>
                          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
                        </select>
                        <input type="submit" name="button" id="button" value="FILTER" />
                      </form></td>
                  </tr>
                </table>
                <table width="95%" border="0" cellpadding="3" cellspacing="3" class="JobGrid">
                        <tr>
                      <td align="center" bgcolor="#003559"><span class="JobHeader">READ</span></td>
                      <td align="center" bgcolor="#003559"><span class="JobHeader">DOCUMENT</span></span></td>
                      <td align="center" bgcolor="#003559"><span class="JobHeader">CATEGORY</span></td>
                      <td align="center" bgcolor="#003559"><span class="JobHeader">SUB CATEGORY</span></td>
                      <td align="center" bgcolor="#003559"><span class="JobHeader">SOURCE</span></td>
                      <td align="center" bgcolor="#003559"><span class="JobHeader">UPDATED</span></td>
                </tr>
                <?php do { ?>
              
            
                  <tr>
                    <td width="54" align="center" bgcolor="#004879"><a href="<?php echo $row_Recordset1['doc_upload_link'] ?>" . " target='_blank' "><img src="Graphics/GreenCircle copy.png" alt="Green" width="19" height="21" border="0" align="middle" /></a></td>
                    <td width="247" bgcolor="#004879"><?php echo $row_Recordset1['doc_display_name']; ?></a></a></td>
                    <td align="center" bgcolor="#004879"><?php echo $row_Recordset1['doc_category']; ?></td>
                    <td align="center" bgcolor="#004879"><?php echo $row_Recordset1['doc_sub_category']; ?></td>
                    <td width="161" align="center" bgcolor="#004879"><?php echo $row_Recordset1['doc_source']; ?></td>
                    <td width="144" align="center" bgcolor="#004879"><?php echo $row_Recordset1['date_posted']; ?></td>
                  </tr>
                  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
              </table>
              <p>&nbsp;              
              <table border="0" class="navbox">
                <tr>
                  <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="First.gif" border="0" /></a>
                  <?php } // Show if not first page ?></td>
                  <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="Previous.gif" border="0" /></a>
                  <?php } // Show if not first page ?></td>
                  <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="Next.gif" border="0" /></a>
                  <?php } // Show if not last page ?></td>
                  <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="Last.gif" border="0" /></a>
                  <?php } // Show if not last page ?></td>
                </tr>
              </table>
              </p></td>
            </tr>
            
        </table>
        <a href="../07_members_only_pw.php" class="JobHeader"></a></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
