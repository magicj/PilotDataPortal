<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
if (!isset($_SESSION['event_year'])) {
  $_SESSION['event_year'] = '2011';
}
if (isset($_POST[select])) {
  $_SESSION['event_year'] = $_POST[select];
}
?>
<?php 
mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = "SELECT DISTINCT YEAR (event_date) FROM pgc_class WHERE event_date <> '' Order By event_date DESC";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset1 = "-1";
if (isset($_SESSION['event_year'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION['event_year'] : addslashes($_SESSION['event_year']);
}

// "DELETE FROM MyGuests WHERE id=3

mysql_select_db($database_PGC, $PGC);
$query_Recordset3 = "DELETE FROM pgc_class WHERE member_name = ''";
$Recordset3 = mysql_query($query_Recordset3, $PGC) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$query_Recordset1 = sprintf("SELECT rec_index, member_name, event_date, event_name, primary_instructor, event_notes FROM pgc_class WHERE YEAR(event_date) = '%s' ORDER BY event_date ASC", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>EDIT - Member Soaring Achievements</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	background-color: #283664;
	background-image: url(../images/Buttons/PGC%20copy.png);
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #CCCCCC;
}
.style155 {color: #FFFFFF; font-size: 9pt; font-family: Arial, Helvetica, sans-serif; font-weight: bold; }
.style158 {color: #EBF5FC; font-size: 12pt; font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-style: italic; }
.style161 {color: #CCCCCC; font-size: 14px; }
.style164 {
	color: #FFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style165 {color: #EBEBEB; font-size: 9pt; font-family: Arial, Helvetica, sans-serif; font-weight: bold; }
a:link {
	color: #CCCCCC;
}
a:visited {
	color: #CCCCCC;
}
.style1 {
	font-size: 18px;
	font-weight: bold;
	color: #CCCCCC;
}
.style17 {
	color: #CCCCCC;
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
.style257 {font-size: 14pt}
.style47 {font-size: 18pt; font-family: Geneva, Arial, Helvetica, sans-serif; color: #CCCCCC; font-weight: bold; }
.style11 {font-size: 16px; font-weight: bold; }
.style20 {color: #8CA6D8; font-style: italic; font-weight: bold; font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
</head>
<body>
<table width="1000" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80"> 
   
  <tr>
    <td height="42" valign="middle" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr> 
    <td height="253" valign="top"><table width="95%" height="81" border="0" align="center" cellpadding="10" cellspacing="2" bordercolor="#666666">
      <tr>
        <td height="77" align="left" valign="top" bgcolor="#495665"><form name="form1" method="post" action="">
            <table width="98%" align="center" cellpadding="4" cellspacing="2" bgcolor="#999999">
              <tr>
                <td colspan="5" bgcolor="#373D68" class="style155"><div align="center" class="style158">
                  <table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="24%" height="29" class="style17"><div align="left"><a href="pgc_class_enter.php">ADD RECORD</a> </div></td>
                      <td width="52%" class="style47 style257"><div align="center" class="style257">ADD or EDIT  Member Soaring Achievements </div></td>
                      <td width="24%"><div align="right">
                          <select name="select">
                            <?php
do {  
?>
                            <option value="<?php echo $row_Recordset2['YEAR (event_date)']?>"<?php if (!(strcmp($row_Recordset2['YEAR (event_date)'], $_SESSION['event_year']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['YEAR (event_date)']?></option>
                            <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
                          </select>
                          <input name="Submit" type="submit" id="Submit" value="Submit">
                      </div></td>
                    </tr>
                    <tr>
                          <td colspan="3" align="center" class="style17">Adding a new record for a year - automatically sets up a new year in the DD List.</td>
                          </tr>
                  </table>
                </div></td>
                </tr>
              <tr>
                <td bgcolor="#373D68" class="style155"><div align="center" class="style161">Member</div></td>
                <td bgcolor="#373D68" class="style155"><div align="center" class="style161">Date</div></td>
                <td bgcolor="#373D68" class="style155"><div align="center" class="style161">Achievement</div></td>
                <td bgcolor="#373D68" class="style155"><div align="center" class="style161">Instructor(s)</div></td>
                <td bgcolor="#373D68" class="style155"><div align="center" class="style161">Notes</div></td>
              </tr>
              <?php do { ?>
              <tr>
                <td bgcolor="#3D4F63" class="style164"><a href="pgc_class_edit.php?rec_index=<?php echo $row_Recordset1['rec_index'];?>" class="style164"><?php echo $row_Recordset1['member_name']; ?></a></td>
                <td bgcolor="#3D4F63" class="style164"><div align="center" class="style164"><?php echo $row_Recordset1['event_date']; ?></div></td>
                <td bgcolor="#3D4F63" class="style164"><div align="center" class="style164"><?php echo $row_Recordset1['event_name']; ?></div></td>
                <td bgcolor="#3D4F63" class="style164"><?php echo $row_Recordset1['primary_instructor']; ?></td>
                <td bgcolor="#3D4F63" class="style164"><?php echo $row_Recordset1['event_notes']; ?></td>
              </tr>
              <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
            </table>
        </form></td>
      </tr>
    </table>      </td>
  </tr>
  <tr>
    <td height="20" valign="top" bgcolor="#666666"><div align="center"><a href="../07_members_only_pw.php" class="style17"><strong class="style11"><a href="pgc_portal_menu.php" class="style20">BACK TO PDP MAINTENANCE MENU</a></strong></a></div></td>
  </tr> 
</table> 
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
