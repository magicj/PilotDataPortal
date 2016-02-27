<?php require_once('../Connections/PGC.php'); ?>
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
  $updateSQL = sprintf("UPDATE pgc_doc_lib_list SET doc_display_name=%s, doc_category=%s, doc_sub_category=%s, doc_display=%s WHERE rec_id=%s",
                        
                       GetSQLValueString($_POST['doc_display_name'], "text"),
                       GetSQLValueString($_POST['doc_category'], "text"),
                       GetSQLValueString($_POST['doc_sub_category'], "text"),
                       GetSQLValueString($_POST['doc_display'], "text"),
                       GetSQLValueString($_POST['rec_id'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "pgc_doc_lib_admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['rec_id'])) {
  $colname_Recordset1 = $_GET['rec_id'];
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT rec_id, doc_file_name, doc_display_name, doc_category, doc_sub_category, doc_display FROM pgc_doc_lib_list WHERE rec_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = "SELECT doc_category FROM pgc_doc_category_master WHERE rec_active = 'YES' ORDER BY doc_category ASC";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_PGC, $PGC);
$query_Recordset3 = "SELECT doc_category FROM pgc_doc_subcategory_master WHERE rec_active = 'YES' ORDER BY doc_category ASC";
$Recordset3 = mysql_query($query_Recordset3, $PGC) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
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
	font-size: 14px;
	font-weight: bold;
	color: #FFF;
	text-align: left;
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
-->
</style>
</head>

<body>
<table width="1200" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
    <tr>
      <td align="center" bgcolor="#387272"><p class="JobBanner">ADMIN EDIT - PGC DOCUMENT LIBRARY - PROTOTYPE</p></td>
  </tr>
    <tr>
      <td height="481" align="center"><table width="96%" height="447" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
            
            <tr>
              <td height="373" colspan="5" align="center" valign="top"> 
                 
                  <p>&nbsp;              
               
              </p>
                  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                      <table width="493" align="center" cellpadding="5" cellspacing="1" class="JobLine">
                          <tr valign="baseline">
                              <td width="150" height="25" align="left" valign="middle" nowrap="nowrap" bgcolor="#004566">Record ID</td>
                              <td width="318" align="left" valign="middle" bgcolor="#004566"><?php echo $row_Recordset1['rec_id']; ?></td>
                          </tr>
                          <tr valign="baseline">
                              <td height="25" align="left" valign="middle" nowrap="nowrap" bgcolor="#004566">Uploaded File Name</td>
                              <td align="left" valign="middle" bgcolor="#004566"><?php echo  $row_Recordset1['doc_file_name']; ?></td>
                          </tr>
                          <tr valign="baseline">
                              <td height="25" align="left" valign="middle" nowrap="nowrap" bgcolor="#004566">Display Name</td>
                              <td align="left" valign="middle" bgcolor="#004566"><input name="doc_display_name" type="text" value="<?php echo htmlentities($row_Recordset1['doc_display_name'], ENT_COMPAT, 'iso-8859-1'); ?>" size="50" maxlength="50" /></td>
                          </tr>
                          <tr valign="baseline">
                              <td height="25" align="left" valign="middle" nowrap="nowrap" bgcolor="#004566">Category</td>
                              <td align="left" valign="middle" bgcolor="#004566"><select name="doc_category" id="doc_category">
                                  <?php
do {  
?>
                                  <option value="<?php echo $row_Recordset2['doc_category']?>"<?php if (!(strcmp($row_Recordset2['doc_category'], $row_Recordset1['doc_category']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['doc_category']?></option>
                                      <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
                              </select></td>
                          </tr>
                          <tr valign="baseline">
                              <td height="25" align="left" valign="middle" nowrap="nowrap" bgcolor="#004566">Sub Category</td>
                              <td align="left" valign="middle" bgcolor="#004566"><select name="doc_sub_category" id="doc_sub_category">
                                  <?php
do {  
?>
                                  <option value="<?php echo $row_Recordset3['doc_category']?>"<?php if (!(strcmp($row_Recordset3['doc_category'], $row_Recordset1['doc_sub_category']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset3['doc_category']?></option>
                                  <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
                              </select></td>
                          </tr>
                          <tr valign="baseline">
                              <td height="25" align="left" valign="middle" nowrap="nowrap" bgcolor="#004566">Display (Yes/No)</td>
                              <td align="left" valign="middle" bgcolor="#004566"><select name="doc_display" id="doc_display">
                                  <option value="YES" <?php if (!(strcmp("YES", $row_Recordset1['doc_display']))) {echo "selected=\"selected\"";} ?>>YES</option>
                                      <option value="NO" <?php if (!(strcmp("NO", $row_Recordset1['doc_display']))) {echo "selected=\"selected\"";} ?>>NO</option>
                              </select></td>
                          </tr>
                          <tr valign="baseline">
                              <td height="38" colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#004566"><input type="submit" value="Update record" /></td>
                              </tr>
                      </table>
                      <input type="hidden" name="MM_update" value="form1" />
                      <input type="hidden" name="rec_id" value="<?php echo $row_Recordset1['rec_id']; ?>" />
                  </form>
                  <p>&nbsp;</p></td>
            </tr>
            
        </table>
          <table width="150" border="1" cellpadding="2" cellspacing="2">
              <tr>
                  <td bgcolor="#3366CC" class="DocButton"><a href="pgc_docs_menu.php" class="DocButton">ADMIN MEMU</a></td>
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

mysql_free_result($Recordset3);
?>
