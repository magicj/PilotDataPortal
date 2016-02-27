<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
$MemberName = $_SESSION['MM_PilotName'];
date_default_timezone_set('America/New_York');
$date = date('Y-m-d H:i:s');
//$_SESSION['pgc_category'] = $_POST['doc_category'];
//$_SESSION['pgc_sub_category'] = $_POST['doc_sub_category'];
require_once('pgc_check_login.php');
require_once('pgc_access_save_appname.php'); 
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
require_once('pgc_access_app_check.php');
/* END - PAGE ACCESS CHECKING LOGIC - END */
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

 	// App to identify library folders
	mysql_select_db($database_PGC, $PGC);
    $insertSQL = "TRUNCATE TABLE pgc_doc_lib_folders";    
    $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
	
    // Define the full path to your folder from root 
    $path = "../doc_library/"; 

    // Open the folder 
    $dir_handle = @opendir($path) or die("Unable to open $path"); 

    // Loop through the files 
    while ($file = readdir($dir_handle)) { 

    if($file == "." || $file == ".." || $file == "index.php" ) 

        continue; 
/*        echo "<a href=\"$file\">$file</a><br />";  */
//		echo $file ."<br />"; 
		
   $insertSQL = sprintf("INSERT IGNORE INTO pgc_doc_lib_folders (folder_name) VALUES (%s)",
	GetSQLValueString($file, "text"	));
    $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

    } 
    // Close 
    closedir($dir_handle); 

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_doc_lib_folders ORDER BY folder_name ASC";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = "SELECT * FROM pgc_doc_category_master WHERE rec_active = 'YES' ORDER BY doc_category ASC";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_PGC, $PGC);
$query_Recordset3 = "SELECT * FROM pgc_doc_subcategory_master WHERE rec_active = 'YES' ORDER BY doc_category ASC";
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
	background-color: #262E4A;
	text-align: center;
	color: #314F73;
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
	text-align: left;
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
.docupload {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: italic;
	font-weight: bold;
	color: #000;
}
.docupload .JobBanner tr td {
	font-size: 10px;
}
.docupload .JobBanner tr td {
	font-size: 12px;
	text-align: left;
}
.uploadDesc {
	color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	font-style: normal;
	text-align: center;
}
.DocButton {	font-family: Verdana, Geneva, sans-serif;
	font-weight: bold;
	text-align: center;
}
-->
</style>
</head>

<body>
<table width="939" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
    <tr>
      <td width="900" height="5" align="center" bgcolor="#294D8D"><p class="JobBanner">PGC DOC LIBRARY UPLOAD</p></td>
  </tr>
    <tr>
      <td height="481" align="center" bgcolor="#1F3F5F">&nbsp;
          <table width="872" height="371" cellpadding="3" cellspacing="3">
              <tr>
                  <td width="763" bgcolor="#3C7591"><table width="860" height="380" align="center" cellpadding="3" cellspacing="3">
                      <tr>
                          <td height="171" align="center" bgcolor="#294D8D"><form action="pgc_doc_upload_selector_msg.php" method="post"
enctype="multipart/form-data">
                              <table width="95%" cellspacing="0" cellpadding="5">
                                  <tr>
                                      <td height="57" colspan="2" align="left"><table width="888" height="26" align="left" cellpadding="2" cellspacing="2">
                                          <tr>
                                              <td width="189" height="26" align="left" bgcolor="#2D58B3"><span class="JobHeader"> 1. Document To Upload</span></td>
                                              <td width="683" align="left" bgcolor="#2D58B3"><span class="JobBanner">
                                                  <input name="file" type="file" class="docupload" id="file" size="97" />
                                                  </span></td>
                                              </tr>
                                          </table></td>
                                  </tr>
                                  <tr>
                                      <td height="57" colspan="2" align="left" class="docupload"><table width="98%" height="32" align="left" cellpadding="2" cellspacing="2" class="JobBanner">
                                          <tr>
                                              <td width="193" height="26" align="left" bgcolor="#2D58B3"><span class="JobHeader">2.  Library Storage Folder</span></td>
                                              <td width="114" align="right" bgcolor="#2D58B3"><select name="pgc_folders" class="docupload" id="pgc_folders">
                                                  <?php
do {  

?>
                                                  <option value="<?php echo $row_Recordset1['folder_name']?>"<?php if (!(strcmp($row_Recordset1['folder_name'], $row_Recordset1['']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['folder_name']?></option>
                                                  <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                                                  </select></td>
                                              <td width="555" align="right" bgcolor="#2D58B3"><span class="uploadDesc">This is the folder where the document will be stored in the library.</span></td>
                                              </tr>
                                          </table></td>
                                  </tr>
                                  <tr>
                                      <td width="50%" height="57" align="left"><table width="95%" cellspacing="0" cellpadding="0">
                                          <tr>
                                              <td width="47%" height="32"><table width="347" height="26" align="left" cellpadding="2" cellspacing="2">
                                                  <tr>
                                                      <td width="221" height="26" align="left" bgcolor="#2D58B3"><span class="JobHeader">3.  Document Category</span></td>
                                                      <td width="110" align="right" bgcolor="#2D58B3"><select name="pgc_category" class="docupload" id="pgc_category">
                                                          <?php
do {  
?>
                                                          <option value="<?php echo $row_Recordset2['doc_category']?>"<?php if (!(strcmp($row_Recordset2['doc_category'], $row_Recordset2['']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['doc_category']?></option>
                                                          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
  //$_SESSION['pgc_category'] = $_POST['doc_category'];
?>
                                                          </select></td>
                                                      </tr>
                                              </table></td>
                                              </tr>
                                      </table></td>
                                      <td width="50%" align="right"><table width="97%" cellspacing="0" cellpadding="0">
                                          <tr>
                                              <td width="47%" height="32"><table width="400" height="26" align="left" cellpadding="2" cellspacing="2">
                                                  <tr>
                                                      <td width="331" height="26" align="left" bgcolor="#2D58B3"><span class="JobHeader">4.  Document Sub-Category</span></td>
                                                      <td width="53" align="right" bgcolor="#2D58B3"><select name="pgc_sub_category" class="docupload" id="pgc_sub_category">
                                                          <?php
do {  
?>
                                                          <option value="<?php echo $row_Recordset3['doc_category']?>"<?php if (!(strcmp($row_Recordset3['doc_category'], $row_Recordset3['']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset3['doc_category']?></option>
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
                                              </table></td>
                                          </tr>
                                      </table></td>
                                  </tr>
                                  <tr>
                                      <td height="57" colspan="2" align="left"><table width="98%" cellspacing="2" cellpadding="2">
                                          <tr>
                                              <td width="203" height="26" bgcolor="#2D58B3"><span class="JobHeader">5.  Display Name</span></td>
                                              <td width="402" bgcolor="#2D58B3"><input name="displayName" type="text" class="docupload" id="displayName" size="60" maxlength="60" /></td>
                                              <td width="253" bgcolor="#2D58B3" class="uploadDesc">Defaults to upload file name if empty.</td>
                                          </tr>
                                      </table></td>
                                      </tr>
                                  <tr>
                                      <td height="57" colspan="2" align="left"><table width="95%" cellspacing="2" cellpadding="2">
                                          <tr>
                                              <td width="192" height="26" bgcolor="#2D58B3"><span class="JobHeader">7.  Active (YES / NO)</span></td>
                                              <td width="645" bgcolor="#2D58B3" class="docupload"><select name="active-yes-no" id="active-yes-no">
                                                  <option value="YES" selected="selected">YES</option>
                                                  <option value="NO">NO</option>
                                              </select></td>
                                          </tr>
                                      </table></td>
                                  </tr>
                              </table>
                              <p class="JobBanner">&nbsp;</p>
                              <p>
                                  <label for="pgc_folders"></label>
                          </p>
                              <p>
                                  <label for="pgc_category"></label>
                              </p>
                              <p class="docupload">&nbsp;</p>
                              <p><br />
                                  <br />
                                  <input type="submit" name="submit" value="UPLOAD TO LIBRARY" />
                              </p>
                                                </form>
                              &nbsp;
                              <table width="150" border="1" cellpadding="2" cellspacing="2">
                                  <tr>
                                      <td bgcolor="#3366CC" class="DocButton"><a href="pgc_docs_menu.php" class="DocButton">ADMIN MEMU</a></td>
                                  </tr>
                              </table></td>
                      </tr>
                  </table></td>
              </tr>
      </table>
        <p>&nbsp;</p></td>
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
