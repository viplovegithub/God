<?php require_once('Connections/eam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 // 
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
}

mysql_select_db($database_eam, $eam);
$query_rsCompanyName = "SELECT * FROM company";
$rsCompanyName = mysql_query($query_rsCompanyName, $eam) or die(mysql_error());
$row_rsCompanyName = mysql_fetch_assoc($rsCompanyName);
$totalRows_rsCompanyName = mysql_num_rows($rsCompanyName);
?><?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['myusername'])) {
  $loginUsername=$_POST['myusername'];
  $password=$_POST['mypassword'];
  $MM_fldUserAuthorization = "role";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_eam, $eam);
  	
  $LoginRS__query=sprintf("SELECT username, password, role FROM members WHERE username=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $eam) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'role');
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $row_rsCompanyName['company_name']; ?> Enterprise Asset Management - Login</title>
<!--/* EAM asset management tool: gfisk.com - 2009 */ -->
<link rel="shortcut icon" href="eam/favicon.ico" type="image/x-icon" />
<link rel="icon" href="eam/favicon.ico" type="image/x-icon" />
<link href="includes/eam_main.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div id="container">
  <div id="header"><img src="images/corp_logo1.gif" alt="" /></div>
  <div id="navcontainer">
 	<ul id="navlist">
    <li><a href="http://www.gfisk.com/it-asset-management-database-free-download/" title="">Login and application information</a></li>
    </ul>
  </div>
  <div id="mainContent">
    <div style="padding:60px 0;">
      <form ACTION="<?php echo $loginFormAction; ?>" name="eamLogin" method="POST">
        <fieldset>
        <legend> Login</legend>
        <p>
          <label for="Username">Username</label>
          <input name="myusername" type="text" id="myusername" size="24" />
        </p>
        <p>
          <label for="Username">Password</label>
          <input name="mypassword" type="password" id="mypassword" size="24" />
        </p>
        <p class="submit">
          <input type="submit" name="Submit" value="Login" />
        </p>
		<br />
        </fieldset>
      </form>
    </div>
</div>
  <div id="footer">
    <p><?php echo date("D M dS, Y - h:i a"); ?><br />
     <!-- <p> <br />-->
    <em>Enterprise Asset Management - by <a href="http://www.Bigsmallweb.com">Bigsmallweb</a></em></p>
  </div>
</div>

</body>
</html>
<?php
mysql_free_result($rsCompanyName);
?>
