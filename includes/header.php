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
$query_rsCompanyName = "SELECT company_name FROM company";
$rsCompanyName = mysql_query($query_rsCompanyName, $eam) or die(mysql_error());
$row_rsCompanyName = mysql_fetch_assoc($rsCompanyName);
$totalRows_rsCompanyName = mysql_num_rows($rsCompanyName);
?>
<?php 
session_start();
if(!isset($_SESSION['MM_Username'])){ 
header("location:login.php");
} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<!-- Page titles are set per page with pageTitle variable -->
<title><?php echo $row_rsCompanyName['company_name']; ?> - Enterprise Asset Management - <?php echo $pageTitle; ?> </title>

<!-- Fav icon silliness brought to use by Internut Exploder where it never seems to work -->
<link rel="shortcut icon" href="http://www.gfisk.com/eam/favicon.ico" type="image/x-icon" />
<link rel="icon" href="http://www.gfisk.com/eam/favicon.ico" type="image/x-icon" />

<!-- Global style sheet -->
<link href="includes/eam_main.css" rel="stylesheet" type="text/css" media="all" />

<!-- Enable to use SCW Calendar widget - http://www.garrett.nildram.co.uk/calendar/scw.htm
<script type='text/JavaScript' src='includes/scw.js'></script> 
-->

<!-- Calendar pop up - http://www.mattkruse.com/javascript/calendarpopup/source.html  -->
<script language="JavaScript" src="includes/CalendarPopup.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
	var cal = new CalendarPopup();
</script>

</head>
<body>

<!-- Main container box - change via width and padding via eam_main.css -->
<div id="container">

<!-- Header bar and logo -->
<div id="header"><a href="index.php" title=""><img src="images/corp_logo1.gif" alt="" /></a>  </div>

<!-- Navigation bar - change via eam_main.css -->
<div id="navcontainer">
  <ul id="navlist">
    <li><a href="index.php" title="">Home</a></li>
    <li><a href="HardwareAdd.php" title="">Add Hardware</a></li>
    <li><a href="SoftwareAdd.php">Add Software</a></li>
    <li><a href="search.php" title=""> - Search -</a></li>         
    <li><a href="HardwareList.php" title="">View All Hardware</a></li>
    <li><a href="SoftwareList.php">View All Software</a></li>
    <li><a href="Admin.php" title="">Admin</a></li>        
    <li><a href="logout.php" title="">Logout</a></li>   
  </ul>
</div>

<!-- Main content box - change via /includes/eam_main.css -->
<div id="mainContent">
<?php
mysql_free_result($rsCompanyName);
?>
