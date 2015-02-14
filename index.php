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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsAssets = 10;
$pageNum_rsAssets = 0;
if (isset($_GET['pageNum_rsAssets'])) {
  $pageNum_rsAssets = $_GET['pageNum_rsAssets'];
}
$startRow_rsAssets = $pageNum_rsAssets * $maxRows_rsAssets;

mysql_select_db($database_eam, $eam);
$query_rsAssets = "SELECT COUNT(*) FROM assets_hardware";
$query_limit_rsAssets = sprintf("%s LIMIT %d, %d", $query_rsAssets, $startRow_rsAssets, $maxRows_rsAssets);
$rsAssets = mysql_query($query_limit_rsAssets, $eam) or die(mysql_error());
$row_rsAssets = mysql_fetch_assoc($rsAssets);

if (isset($_GET['totalRows_rsAssets'])) {
  $totalRows_rsAssets = $_GET['totalRows_rsAssets'];
} else {
  $all_rsAssets = mysql_query($query_rsAssets);
  $totalRows_rsAssets = mysql_num_rows($all_rsAssets);
}
$totalPages_rsAssets = ceil($totalRows_rsAssets/$maxRows_rsAssets)-1;

$maxRows_rsHardwareCount = 10;
$pageNum_rsHardwareCount = 0;
if (isset($_GET['pageNum_rsHardwareCount'])) {
  $pageNum_rsHardwareCount = $_GET['pageNum_rsHardwareCount'];
}
$startRow_rsHardwareCount = $pageNum_rsHardwareCount * $maxRows_rsHardwareCount;

mysql_select_db($database_eam, $eam);
$query_rsHardwareCount = "SELECT assets_hardware.asset_type, COUNT(*) FROM assets_hardware GROUP BY assets_hardware.asset_type";
$query_limit_rsHardwareCount = sprintf("%s LIMIT %d, %d", $query_rsHardwareCount, $startRow_rsHardwareCount, $maxRows_rsHardwareCount);
$rsHardwareCount = mysql_query($query_limit_rsHardwareCount, $eam) or die(mysql_error());
$row_rsHardwareCount = mysql_fetch_assoc($rsHardwareCount);

if (isset($_GET['totalRows_rsHardwareCount'])) {
  $totalRows_rsHardwareCount = $_GET['totalRows_rsHardwareCount'];
} else {
  $all_rsHardwareCount = mysql_query($query_rsHardwareCount);
  $totalRows_rsHardwareCount = mysql_num_rows($all_rsHardwareCount);
}
$totalPages_rsHardwareCount = ceil($totalRows_rsHardwareCount/$maxRows_rsHardwareCount)-1;

mysql_select_db($database_eam, $eam);
$query_rsCompanyName = "SELECT company_name FROM company";
$rsCompanyName = mysql_query($query_rsCompanyName, $eam) or die(mysql_error());
$row_rsCompanyName = mysql_fetch_assoc($rsCompanyName);
$totalRows_rsCompanyName = mysql_num_rows($rsCompanyName);

$queryString_rsHardwareCount = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsHardwareCount") == false && 
        stristr($param, "totalRows_rsHardwareCount") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsHardwareCount = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsHardwareCount = sprintf("&totalRows_rsHardwareCount=%d%s", $totalRows_rsHardwareCount, $queryString_rsHardwareCount);
 $pageTitle="Home"; ?>
<?php include('includes/header.php'); ?> 
    <h3> <?php echo $row_rsCompanyName['company_name']; ?> - Home</h3>
    <table class="tableHome">
      <tr>
        <th width="25%" nowrap="nowrap">Current Status</th>
        <th width="25%" nowrap="nowrap"> Hardware <span class="tiny">- search/view/change </span></th>
        <th width="25%" nowrap="nowrap">Software</th>
        <th width="25%" nowrap="nowrap">Reports <span class="tiny">- output CSV </span></th>
      </tr>
      <tr>
        <td valign="top" nowrap="nowrap" class="tableNav">
        <ul>
        <li><a href="search.php">Total Assets: <?php echo trim($row_rsAssets['COUNT(*)']); ?></a></li>
          <?php do { ?>
            <li><a href="search.php"><?php echo $row_rsHardwareCount['asset_type']; ?>s: <?php echo $row_rsHardwareCount['COUNT(*)']; ?></a></li>
            <?php } while ($row_rsHardwareCount = mysql_fetch_assoc($rsHardwareCount)); ?>
          </ul>
        

</td>
        <td valign="top" class="tableNav"><ul>
          <li><a href="search.php">Search by specific values</a> </li>
          <form action="searchResults.php" method="post" name="supportform" id="supportform">
            <script language="JavaScript" type="text/javascript">
			<!--
			function getsupport ( selectedtype )
			{
			  document.supportform.asset_type.value = selectedtype ;
			  document.supportform.submit() ;
			}
			-->
			</script>
            <input type="hidden" name="asset_type" />
            <li><a href="javascript:getsupport('Laptop')">View all Laptops</a> </li>
            <li><a href="javascript:getsupport('Desktop')">View all Desktops</a></li>
            <li><a href="javascript:getsupport('Monitor')">View all Monitors</a></li>
            <li><a href="javascript:getsupport('Printer')">View all Printers</a></li>
            <li><a href="javascript:getsupport('Peripheral')">View all Peripherals</a></li>
            <li><a href="javascript:getsupport('Other')">View Other Desktop </a></li>
            <ul>
              <li><a href="javascript:getsupport('Other')">View all Servers</a></li>
              <li><a href="javascript:getsupport('Other')">View Other Server </a></li>
            </ul>
            </li>
          </form>
        </ul></td>
        <td valign="top" class="tableNav"><ul>
          <li><a href="SoftwareAdd.php">Add Software </a></li>
          <li><a href="#">Search Software </a></li>
          <li><a href="SoftwareList.php">View All Software</a></li>
          <li><a href="#">View Mac</a></li>
          <li><a href="#"> View Adobe</a></li>
          <li><a href="#">View Microsoft</a></li>
        </ul></td>
        <td valign="top" class="tableNav">
          <ul>
            <li><a href="ReportsAllLaptops.php">All Laptops</a></li>
            <li><a href="ReportsAllDesktops.php">All Desktops</a></li>
            <li><a href="ReportsAllMonitors.php">All Monitors</a></li>
            <li><a href="ReportsAllPrinters.php">All Printers</a></li>
            <li><a href="ReportsAllPeripherals.php">All Peripherals</a></li>
            <li><a href="ReportsAllInventory.php">All Desktop Hardware </a></li>
            <li><a href="ReportsAllInventory.php">All Server Hardware </a></li>
            li><a href="ReportsAllInventory.php">Alls Servers Hardwares </a></li>
          </ul>
        </td>
      </tr>
    </table>
    <table class="pagination">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>    
</div>
<?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsAssets);

mysql_free_result($rsHardwareCount);

mysql_free_result($rsCompanyName);
?>
