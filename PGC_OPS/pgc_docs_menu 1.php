<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php');
require_once('pgc_access_save_appname.php'); 
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
require_once('pgc_access_app_check.php');
/* END - PAGE ACCESS CHECKING LOGIC - END */
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
	color: #314F73;
}
a:link {
	color: #FFFF9B;
}
a:visited {
	color: #FFFFFF;
	font-style: italic;
	font-size: 16px;
	font-family: Arial, Helvetica, sans-serif;
}

.JobHeader {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
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
.style27 {	font-size: 18px;
	font-weight: bold;
	color: #F2F2FF;
	text-align: center;
}
.DocLibMenu {
	font-size: 16px;
	color: #FFFFFF;
	font-style: italic;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>
</head>

<body>
<table width="1000" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
    <tr>
      <td align="center" bgcolor="#294D8D"><p class="JobBanner">ADMIN  MENU - PGC DOCUMENT LIBRARY</p></td>
  </tr>
    <tr>
      <td height="550" align="center"><table width="96%" height="449" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
            
            <tr>
              <td height="443" colspan="5" align="center" valign="top"> 
                 
                  <p>&nbsp;</p>
                  <table width="300" cellspacing="2" cellpadding="5">
                      <tr>
                          <td width="372" height="25" align="center" bgcolor="#003399"><a href="pgc_doc_lib_admin.php" class="JobHeader"><span class="JobHeader"><span class="DocLibMenu">Doc Library - Admin View</span></span></a></td>
                      </tr>
                      <tr>
                          <td height="25" align="center" bgcolor="#003399"><a href="pgc_doc_lib_member.php" class="DocLibMenu"><span class="DocLibMenu"><span class="DocLibMenu"><span class="DocLibMenu"><span class="JobHeader"> Doc Library  - Member View</span></span></span></span></a></td>
                      </tr>
                      <tr>
                          <td height="41">&nbsp;</td>
                      </tr>
                      <tr>
                          <td height="25" align="center" bgcolor="#003399"><a href="pgc_doc_cat_master_create.php" class="JobBanner"><span class="DocLibMenu">Create Category Master</span></a></td>
                      </tr>
                      <tr>
                          <td height="25" align="center" bgcolor="#003399"><a href="pgc_doc_subcat_master_create.php" class="JobBanner"><span class="DocLibMenu">Create Sub-Category</span></a></td>
                      </tr>
                  </table>
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  <table width="300" cellspacing="0" cellpadding="5">
                      <tr>
                          <td height="25" align="center" bgcolor="#003399"><a href="pgc_doc_upload_selector.php" class="JobBanner"><span class="DocLibMenu">Upload Document</span></a><a href="pgc_doc_upload_selector.php" class="DocLibMenu"></a></td>
                      </tr>
                  </table>
                  <p>&nbsp;              
               
              </p>
                   
                  <p>&nbsp;</p>
                  <table width="214" cellspacing="0" cellpadding="0">
                      <tr>
                          <td width="143" align="center"><a href="../07_members_only_pw.php" class="JobBanner"><span class="DocLibMenu">Members Page</span></a><a href="pgc_doc_upload_selector.php" class="DocLibMenu"></a></td>
                      </tr>
              </table></td>
            </tr>
            
        </table>
        <a href="../07_members_only_pw.php" class="JobHeader"></a></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>