<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['PW_Username'] = $_POST['e_address'];

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

// See if email is valid ... and member is active 

$colname_Recordset1 = "-1";
if (isset($_SESSION['PW_Username'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION['PW_Username'] : addslashes($_SESSION['PW_Username']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_members WHERE USER_ID = '%s'", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$pw = $row_Recordset1[USER_PW];

If ($totalRows_Recordset1 > 0) {
	  
	  // Send confirmation emails to old and new address
	  
		$message = "You requested the PDP to send a forgotten PW. (" . $pw . ") Contact the PGC Webmaster or a PGC BOD member if you did not initiate this action." ."\n\n". "Have a good day - PGC Pilot Data Portal" ;

 
		$webmaster = "support@pgcsoaring.org";
		$to = $_POST['e_address'] . ",". $webmaster ;
		    
		$subject = "PGC Send PW Request";
				
		$email = $_REQUEST['email'] ;
				
		$headers = "From: PGC Pilot Data Portal";
		$headers = "From: PGC-PDP@noreply.com";
				
		$sent = mail($to, $subject, $message, $headers) ;
				
		$MM_redirectMailSuccess = "../07_members_login.php";
		header("Location: " . $MM_redirectMailSuccess );
		
}
   

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Change PW</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFFF;
}
body {
	background-color: #333333;
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style11 {font-size: 16px; font-weight: bold; }
a:link {
	color: #FFFFCC;
}
a:visited {
	color: #FF99FF;
}
.style17 {
	font-size: 12px;
	font-weight: bold;
	font-style: italic;
	color: #E1E1E1;
}
.style18 {font-family: Geneva, Arial, Helvetica, sans-serif}
-->
</style>
</head>
<body>
<table width="800" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="514"><table width="92%" height="415" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
        <tr>
          <td height="36"><div align="center"><span class="style11">SEND PASSWORD</span></div></td>
        </tr>
        
        <tr>
            <td height="333" align="center" valign="middle"><form id="form1" name="form1" method="post" action="">
                <label>
                <div align="center"><span class="style17">PGC E-MAIL ADDRESS: 
                    </span>
                    <input name="e_address" type="text" id="e_address" size="40" maxlength="40" />
                </div>
                </label>
                                    <p>
                                        <label>
                                        <input type="submit" name="Submit" value="Submit" />
                                        </label>
                            </p>
            </form>            
                <p>&nbsp;</p>
                <table width="80%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="style17"><div align="center">Your PW will be sent to the entered email address ... if it is a valid and active member e-mail. No success/failure message will be provided. </div></td>
                    </tr>
                </table>                <p>&nbsp;</p></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
 
