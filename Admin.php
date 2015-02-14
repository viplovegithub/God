<?php require_once('Connections/eam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 // 
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "access.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?><?php
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
 $pageTitle="Home"; ?>
<?php include('includes/header.php'); ?>
    <h3> <?php echo $row_rsCompanyName['company_name']; ?> - Admin</h3>
    <table class="tableHome">
      <tr>
        <th width="20%" nowrap="nowrap">Add <span class="tiny">- add new </span></th>
        <th width="20%" nowrap="nowrap"> Update  <span class="tiny">- view/change</span></th>
        <th width="20%" nowrap="nowrap">Software <span class="tiny">- view/change </span></th>
        <th width="20%" nowrap="nowrap">Reports <span class="tiny">- output CSV </span></th>
        <th width="20%" nowrap="nowrap"> Manage<span class="tiny"></span></th>
      </tr>
      <tr>
        <td nowrap="nowrap" class="tableNav">
          <ul>
            <li><a href="HardwareAdd.php"> Add Hardware</a></li>
            <li><a href="VendorAdd.php">Add Hardware Vendor</a></li>
            <li><a href="HardwareTypeAdd.php">Add Hardware Type</a></li>
            <li><a href="PlatformAdd.php">Add  Hardware Platform</a></li>
            <li><a href="#">--</a></li>
            <li><a href="SoftwareAdd.php"> Add Software </a></li>
            <li><a href="SoftwareVendorAdd.php">Add Software Vendor</a></li>
            <li><a href="#">--</a></li>
            <li><a href="DivisionAdd.php">Add a Division <span class="tiny">(Business unit)</span></a></li>
            <li><a href="LocationAdd.php">Add a Location <span class="tiny">(Office)</span></a></li>
          </ul>        </td>
        <td valign="top" class="tableNav"><ul>
            <li><a href="VendorList.php">Hardware Vendors</a></li>
            <li><a href="HardwareTypeList.php">Hardware Types </a></li>
            <li><a href="PlatformList.php">Hardware Platforms</a></li>
            <li><a href="#">--</a></li>
            <li><a href="SoftwareVendorList.php">Software Vendors</a></li>
            <li><a href="#">--</a></li>
            <li><a href="DivisionList.php">Divisions</a></li>
            <li><a href="LocationList.php">Locations</a></li>
            </ul>
            <ul>
              <li><a href="#">&nbsp;</a></li>
            </ul>
            <ul>
              <li><a href="#">&nbsp;</a></li>
        </ul></td>
        <td valign="top" class="tableNav">
          <ul>
            <li><a href="SoftwareList.php">All Software</a><a href="#">Mac</a></li>
            <li><a href="#">Windows</a></li>
            <li><a href="#">Adobe</a></li>
            <li><a href="#">Microsoft</a></li>
            <li><a href="http://www.gfisk.com/eam/HardwareInventory.php">Hardware Inventory</a></li>
            <li><a href="#">&nbsp;</a></li>
          </ul>
          <ul>
            <li><a href="#">&nbsp;</a></li>
            <li><a href="#">&nbsp;</a></li>
            <li><a href="#">&nbsp;</a></li>
          </ul>        </td>
        <td valign="top" class="tableNav"><ul>
            <li><a href="ReportsAllLaptops.php">Laptops</a></li>
            <li><a href="ReportsAllDesktops.php">Desktops</a></li>
            <li><a href="ReportsAllMonitors.php">Monitors</a></li>
            <li><a href="ReportsAllPrinters.php">Printers</a></li>
            <li><a href="ReportsAllPeripherals.php">Peripherals</a></li>
            <li><a href="ReportsAllInventory.php">Desktop Inventory </a></li>
          <li><a href="#">Software</a></li>
        </ul>
            <ul>
              <li><a href="#">&nbsp;</a></li>
              <li><a href="#">&nbsp;</a></li>
            </ul>
            <ul>
              <li><a href="#">&nbsp;</a></li>
            </ul>
        </td>
        <td valign="top" class="tableNav"><ul>
            <li><a href="UserAdd.php"> Users: Add User</a></li>
          <li><a href="UserList.php"> Users: Update User </a></li>
          <li><a href="#">--</a></li>
          <li><a href="CompanyUpdate.php">Company Name - Update</a></li>
          <li><a href="#">&nbsp;</a></li>
          <li><a href="#">&nbsp;</a></li>
          <li><a href="#">&nbsp;</a></li>
          <li><a href="#">&nbsp;</a></li>
          <li><a href="#">&nbsp;</a></li>
          <li><a href="#">&nbsp;</a></li>
          <li></li>
        </ul></td>
      </tr>
    </table>
    <table class="pagination">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>     
    <?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsCompanyName);
?>
