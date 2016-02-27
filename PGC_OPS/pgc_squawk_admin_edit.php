<?php require_once('../Connections/PGC.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE pgc_squawk SET   id_name=%s, sq_date=%s, sq_equipment=%s, sq_issue=%s,  rec_deleted=%s WHERE sq_key=%s",
                       
                     
                       GetSQLValueString($_POST['id_name'], "text"),
                       GetSQLValueString($_POST['sq_date'], "date"),
                       GetSQLValueString($_POST['sq_equipment'], "text"),
                       GetSQLValueString($_POST['sq_issue'], "text"),
                     
                       GetSQLValueString($_POST['rec_deleted'], "text"),
                       GetSQLValueString($_POST['sq_key'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  
  $updateGoTo = "pgc_squawk_work.php?sq_id=".$_SESSION['current_sq'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['sq_key'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['sq_key'] : addslashes($_GET['sq_key']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_squawk WHERE sq_key = %s", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = "SELECT equip_name FROM pgc_equipment ORDER BY equip_type ASC";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_PGC, $PGC);
$query_Recordset3 = "SELECT NAME FROM pgc_members WHERE NAME <> '' ORDER BY NAME ASC";
$Recordset3 = mysql_query($query_Recordset3, $PGC) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script src="../java/javascripts.js" type="text/javascript"></script>
<script src="../java/CalendarPopup.js" type="text/javascript"></script>
<script src="../java/zxml.js" type="text/javascript"></script>
<script src="../java/workingjs.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript" ID="js1">
		var cal = new CalendarPopup();
	 </SCRIPT>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC EQUIPMENT SQUAWK</title>
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
.style44 {
	color: #FF0000;
	font-weight: bold;
}
.style45 {color: #FFFFFF}
.style46 {color: #CCCCCC; font-size: 16px; font-weight: bold; font-style: italic; }
.style53 {font-size: 14px}
-->
</style>
</head>
<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
      <tr>
            <td align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="398" bgcolor="#666666"><table width="900" height="534" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#005B5B">
                        <tr>
                          <td width="1562" height="23" valign="top" bgcolor="#0A335C"><div align="center" class="style46">ADMIN - SQUAWK EDIT </div></td>
                        </tr>
                        <tr>
                          <td height="277" align="center" valign="top" bgcolor="#0A335C"><p>&nbsp;</p>
                                        
                          
                                                <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                            <table width="572" align="center" cellpadding="4" cellspacing="3" bgcolor="#A2B3B3">
                              <tr valign="baseline">
                                <td width="106" align="right" valign="middle" nowrap bgcolor="#35415B" class="style17"><div align="left" class="style53"><span class="style45">Squawk ID:</span></div></td>
                                <td width="439" valign="middle" bgcolor="#48597B"><div align="left"><?php echo $row_Recordset1['sq_key']; ?></div></td>
                              </tr>
                              
                              
                              <tr valign="baseline">
                                <td align="right" valign="middle" nowrap bgcolor="#35415B" class="style17"><div align="left" class="style53"><span class="style45">Reported By:</span></div></td>
                                <td valign="middle" bgcolor="#48597B"><div align="left">
                               
                                  <select name="id_name" id="select">
                                    <?php
do {  
?><option value="<?php echo $row_Recordset3['NAME']?>"<?php if (!(strcmp($row_Recordset3['NAME'], $row_Recordset1['id_name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset3['NAME']?></option><?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
                                                                    </select>
                                </div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" valign="middle" nowrap bgcolor="#35415B" class="style17"><div align="left" class="style53"><span class="style45">Squawk Date </span></div></td>
                                <td valign="middle" bgcolor="#48597B"><div align="left">
                                  <input name="sq_date" type="text" size="10" value="<?php echo $row_Recordset1['sq_date']?>" />
                                <a href="#"
					   name="anchor2" class="style44" id="anchor2" onclick="cal.select(document.forms['form1'].sq_date,'anchor2','yyyy-MM-dd'); return false">Select From Calendar</a></div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" valign="middle" nowrap bgcolor="#35415B" class="style17"><div align="left" class="style53"><span class="style45">Equipment:</span></div></td>
                                <td valign="middle" bgcolor="#48597B"><div align="left">
                                <select name="sq_equipment" id="sq_equipment">
                                    <?php
do {  
?><option value="<?php echo $row_Recordset2['equip_name']?>"<?php if (!(strcmp($row_Recordset2['equip_name'], $row_Recordset1['sq_equipment']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['equip_name']?></option>
                                    <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
                                  </select>
                                </div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" valign="middle" nowrap bgcolor="#35415B" class="style17"><div align="left" class="style53"><span class="style45">Problem:</span></div></td>
                                <td valign="middle" bgcolor="#48597B"><div align="left">
                                  <textarea name="sq_issue" cols="70" rows="10"><?php echo $row_Recordset1['sq_issue']; ?></textarea>
                                </div></td>
                              </tr>
                              
                              <tr valign="baseline">
                                <td align="right" valign="middle" nowrap bgcolor="#35415B" class="style17"><div align="left" class="style53"><span class="style45">Delete Record?</span></div></td>
                                <td valign="middle" bgcolor="#48597B"><div align="left">
                               
                                  <select name="rec_deleted">
                                    <option value="N" selected="selected" <?php if (!(strcmp("N", $row_Recordset1['rec_deleted']))) {echo "selected=\"selected\"";} ?>>N</option>
                                    <option value="Y" <?php if (!(strcmp("Y", $row_Recordset1['rec_deleted']))) {echo "selected=\"selected\"";} ?>>Y</option>
                                  </select>
                                </div></td>
                              </tr>
                              <tr valign="baseline">
                                <td colspan="2" align="right" valign="middle" nowrap bgcolor="#35415B" class="style17"><div align="left">
                                  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="35%"><div align="center">
                                      
										<input type="image" name="submit" value="Update record" src="Graphics/Save.png" style="border:0;" />
                                      </div></td>
                                      <td width="24%">&nbsp;</td>
                                      <td width="41%"><div align="center"><a href="pgc_squawk_work.php?sq_id=<?php echo $_SESSION['current_sq'] ?>"><img src="Graphics/Cancel copy.png" alt="Cancel" width="130" height="30" border="0" /></a></div></td>
                                    </tr>
                                  </table>
                                </div></td>
                              </tr>
                            </table>
                            <input type="hidden" name="MM_update" value="form2">
                            <input type="hidden" name="sq_key" value="<?php echo $row_Recordset1['sq_key']; ?>">
                          </form>
                          <p>&nbsp;</p></td>
                        </tr>
                        <tr>
                              <td height="30" bgcolor="#4F5359" class="style16"><div align="center"><a href="pgc_squawk_view.php" class="style17">BACK TO SQUAWK VIEW PAGE</a></div></td>
                        </tr>
                  </table></td>
      </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
 