<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
INSERT INTO pgc_pilot_signoffs(pilot_name, signoff_type, signoff_date, instructor, expire_date, status)
 Select A.pilot_name, B.description, "0000-00-00", "System","0000-00-00", "NG" FROM pgc_pilots A, pgc_signoff_types B WHERE Trim(B.description) <> "";
<body>
</body>
</html>
