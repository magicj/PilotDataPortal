<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_members WHERE USER_ID = '%s'", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php
echo $_SESSION['MM_Username'];
?>;


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC PW Reset</title>
<style type="text/css">
<!--
body {
	background-color: #8CA6D8;
}
.style108 {color: #8CA6D8;
	font-size: 17pt;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style256 {font-family: Arial, Helvetica, sans-serif; font-size: 9px; color: #FFFFCC; font-weight: bold; }
.style28 {color: #FFFFFF;
	font-size: 10pt;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style29 {color: #FFFFFF}
.style31 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000066; }
.style109 {font-family: Arial, Helvetica, sans-serif}
.style111 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; }
-->
</style></head>

<body>

<table width="800" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#570F24" bgcolor="#333333">
  <tr>
    <td height="101"><img name="PGCprodHDR_r1_c1" src="../PGCprodHdr/PGCprodHDR_r1_c1.gif" width="800" height="97" border="0" id="PGCprodHDR_r1_c1" alt="Header 1" /></td>
  </tr>
  <tr>
    <td height="74"><table width="97%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%"><div align="center"><span class="style108">Change PW </span></div></td>
        <td width="80%"><div align="left"><img src="../bkgrd_Tiltle.png" alt="Title Bar" width="584" height="23" /></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="74"><div align="center"><span class="style108">~~~ Change PGC Password ~~~</span></div></td>
  </tr>
  <tr>
    <td height="369"><form id="ChangePW" name="ChangePW" method="POST" action="pgc_change_pw_check.php">
  <label>
  <div align="center">
    <table width="384" border="2" align="center" cellpadding="5" cellspacing="0" bordercolor="#999999" bgcolor="#666666">
      <tr>
        <td width="201"><div align="left"><span class="style109"><strong>Enter New </strong></span><span class="style111">Password</span></div></td>
        <td width="166"><input name="pw1" type="password" id="pw1" size="20" maxlength="20" /></td>
      </tr>
      <tr>
        <td><div align="left"><span class="style111">          Re-enter New Password:</span> </div></td>
        <td><input name="pw2" type="password" id="pw2" size="20" maxlength="20" /></td>
      </tr>
      <tr>
        <td colspan="2"><div align="center">
          <input type="submit" name="Submit" value="Submit" />
        </div></td>
        </tr>
    </table>
    <p><br />
          <br />
      </p>
    </div>
  </label>
</form>
     <?php $_SESSION[pw_msg]; ?></td>
  </tr>
  <tr>
    <td height="55"><table width="700" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#666666">
      <tr>
        <td width="58" height="26"><div align="center" class="style256"><a href="http://www.pgcsoaring.org/Index.html" class="style256">Home</a> </div></td>
        <td width="59"><div align="center"> <span class="style28 style29  style113 style252"><a href="../07_Aircraft.html" class="style256">Aircraft</a></span></div></td>
        <td width="55"><div align="center" class="style256"><a href="../07_Training.html" class="style256">Training</a> </div></td>
        <td width="50"><div align="center" class="style31"><a href="../07_Safety.html" class="style256">Safety</a></div></td>
        <td width="61" class="style256"><div align="center" class="style31"><a href="../07_Location.html" class="style256">Location</a></div></td>
        <td width="68" class="style256"><div align="center" class="style31"> <a href="../07_Weather.html" class="style256">Weather</a></div></td>
        <td width="70" class="style256"><div align="center" class="style31"><a href="../07_Members_Login.php" class="style256">Members</a></div></td>
        <td width="66" class="style256"><div align="center" class="style31"><a href="../07_Join.html" class="style256">Join PGC</a></div></td>
        <td width="90" class="style256"><div align="center" class="style31"><a href="../07_Learn.html" class="style256">Learn to Fly</a> </div></td>
        <td width="70" class="style256"><div align="center" class="style31"><a href="../07_Album_Menu.html" class="style256">Photos</a></div></td>
      </tr>
    </table></td>
  </tr>
</table>






</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
