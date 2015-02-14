<?php require_once('Connections/eam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 // 
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsHardwareAssets = 50;
$pageNum_rsHardwareAssets = 0;
if (isset($_GET['pageNum_rsHardwareAssets'])) {
  $pageNum_rsHardwareAssets = $_GET['pageNum_rsHardwareAssets'];
}
$startRow_rsHardwareAssets = $pageNum_rsHardwareAssets * $maxRows_rsHardwareAssets;

mysql_select_db($database_eam, $eam);
$query_rsHardwareAssets = "SELECT * FROM assets_hardware WHERE  assets_hardware.platform = 'MAC' ";
$query_limit_rsHardwareAssets = sprintf("%s LIMIT %d, %d", $query_rsHardwareAssets, $startRow_rsHardwareAssets, $maxRows_rsHardwareAssets);
$rsHardwareAssets = mysql_query($query_limit_rsHardwareAssets, $eam) or die(mysql_error());
$row_rsHardwareAssets = mysql_fetch_assoc($rsHardwareAssets);

if (isset($_GET['totalRows_rsHardwareAssets'])) {
  $totalRows_rsHardwareAssets = $_GET['totalRows_rsHardwareAssets'];
} else {
  $all_rsHardwareAssets = mysql_query($query_rsHardwareAssets);
  $totalRows_rsHardwareAssets = mysql_num_rows($all_rsHardwareAssets);
}
$totalPages_rsHardwareAssets = ceil($totalRows_rsHardwareAssets/$maxRows_rsHardwareAssets)-1;

mysql_select_db($database_eam, $eam);
$query_rsVendors = "SELECT * FROM vendors";
$rsVendors = mysql_query($query_rsVendors, $eam) or die(mysql_error());
$row_rsVendors = mysql_fetch_assoc($rsVendors);
$totalRows_rsVendors = mysql_num_rows($rsVendors);

mysql_select_db($database_eam, $eam);
$query_rsPlatform = "SELECT * FROM assets_hardware_platform";
$rsPlatform = mysql_query($query_rsPlatform, $eam) or die(mysql_error());
$row_rsPlatform = mysql_fetch_assoc($rsPlatform);
$totalRows_rsPlatform = mysql_num_rows($rsPlatform);

$colname_rsHardwareUpdate = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsHardwareUpdate = (get_magic_quotes_gpc()) ? $_GET['recordID'] : addslashes($_GET['recordID']);
}
mysql_select_db($database_eam, $eam);
$query_rsHardwareUpdate = sprintf("SELECT * FROM assets_hardware WHERE asset_hardware_id = %s", $colname_rsHardwareUpdate);
$rsHardwareUpdate = mysql_query($query_rsHardwareUpdate, $eam) or die(mysql_error());
$row_rsHardwareUpdate = mysql_fetch_assoc($rsHardwareUpdate);
$totalRows_rsHardwareUpdate = mysql_num_rows($rsHardwareUpdate);

mysql_select_db($database_eam, $eam);
$query_rsDivision = "SELECT * FROM division";
$rsDivision = mysql_query($query_rsDivision, $eam) or die(mysql_error());
$row_rsDivision = mysql_fetch_assoc($rsDivision);
$totalRows_rsDivision = mysql_num_rows($rsDivision);

mysql_select_db($database_eam, $eam);
$query_rsHardwareType = "SELECT * FROM assets_hardware_type";
$rsHardwareType = mysql_query($query_rsHardwareType, $eam) or die(mysql_error());
$row_rsHardwareType = mysql_fetch_assoc($rsHardwareType);
$totalRows_rsHardwareType = mysql_num_rows($rsHardwareType);

mysql_select_db($database_eam, $eam);
$query_rsLocation = "SELECT * FROM location";
$rsLocation = mysql_query($query_rsLocation, $eam) or die(mysql_error());
$row_rsLocation = mysql_fetch_assoc($rsLocation);
$totalRows_rsLocation = mysql_num_rows($rsLocation);

mysql_select_db($database_eam, $eam);
$query_rsHardwareStatus = "SELECT * FROM assets_hardware_status";
$rsHardwareStatus = mysql_query($query_rsHardwareStatus, $eam) or die(mysql_error());
$row_rsHardwareStatus = mysql_fetch_assoc($rsHardwareStatus);
$totalRows_rsHardwareStatus = mysql_num_rows($rsHardwareStatus);

$queryString_rsHardwareAssets = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsHardwareAssets") == false && 
        stristr($param, "totalRows_rsHardwareAssets") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsHardwareAssets = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsHardwareAssets = sprintf("&totalRows_rsHardwareAssets=%d%s", $totalRows_rsHardwareAssets, $queryString_rsHardwareAssets);
?>
<?php $pageTitle="Hardware Assets List"; ?>
<?php include('includes/header.php'); ?>
    <h3>Hardware Assets </h3>
    <table class="table1">
      <tr>
        <th>Asset Type </th>
        <th>Vendor</th>
        <th>Model</th>
        <th>Platform</th>
        <th>Location</th>
        <th>Status</th>
        <th>User</th>
        <th>Division</th>
        <th>View &nbsp; </th>
        <th>Edit &nbsp; </th>
      </tr>
      <?php do { ?>
        <tr onmouseover="this.bgColor='#F2F7FF'" onmouseout="this.bgColor='#FFFFFF'";>
          <td> <?php echo $row_rsHardwareAssets['asset_type']; ?>&nbsp; </td>
          <td> <?php echo $row_rsHardwareAssets['vendor']; ?>&nbsp; </td>
          <td> <?php echo $row_rsHardwareAssets['model']; ?>&nbsp; </td>
          <td> <?php echo $row_rsHardwareAssets['platform']; ?>&nbsp; </td>
          <td> <?php echo $row_rsHardwareAssets['location']; ?>&nbsp; </td>
          <td> <?php echo $row_rsHardwareAssets['status']; ?>&nbsp; </td>
          <td> <?php echo $row_rsHardwareAssets['user']; ?>&nbsp; </td>
          <td> <?php echo $row_rsHardwareAssets['division']; ?>&nbsp; </td>
          <td> <a href="HardwareDetail.php?recordID=<?php echo $row_rsHardwareAssets['asset_hardware_id']; ?>">View</a></td>
          <td> <a href="HardwareUpdate.php?recordID=<?php echo $row_rsHardwareAssets['asset_hardware_id']; ?>">Edit</a></td>
        </tr>
      <?php } while ($row_rsHardwareAssets = mysql_fetch_assoc($rsHardwareAssets)); ?>
    </table>
 <table class="pagination">
      <tr>
	  <td>Records <?php echo ($startRow_rsHardwareAssets + 1) ?> to <?php echo min($startRow_rsHardwareAssets + $maxRows_rsHardwareAssets, $totalRows_rsHardwareAssets) ?> of <?php echo $totalRows_rsHardwareAssets ?></td>
	  <td>
	  <table>
	  <tr>
	  <?php if ($pageNum_rsHardwareAssets > 0) { // Show if not first page ?>
        <td width="23%" align="center">
            <a href="<?php printf("%s?pageNum_rsHardwareAssets=%d%s", $currentPage, 0, $queryString_rsHardwareAssets); ?>">First</a>
        </td>
		<?php } // Show if not first page ?>

 		<?php if ($pageNum_rsHardwareAssets > 0) { // Show if not first page ?>		
        <td width="31%" align="center">
            <a href="<?php printf("%s?pageNum_rsHardwareAssets=%d%s", $currentPage, max(0, $pageNum_rsHardwareAssets - 1), $queryString_rsHardwareAssets); ?>">Previous</a>
         </td>
		 <?php } // Show if not first page ?>
        
		
         <?php if ($pageNum_rsHardwareAssets < $totalPages_rsHardwareAssets) { // Show if not last page ?>
        <td width="23%" align="center">
            <a href="<?php printf("%s?pageNum_rsHardwareAssets=%d%s", $currentPage, min($totalPages_rsHardwareAssets, $pageNum_rsHardwareAssets + 1), $queryString_rsHardwareAssets); ?>">Next</a>
         </td>
		 <?php } // Show if not last page ?>
        
		<?php if ($pageNum_rsHardwareAssets < $totalPages_rsHardwareAssets) { // Show if not last page ?>
        <td width="23%" align="center">
            <a href="<?php printf("%s?pageNum_rsHardwareAssets=%d%s", $currentPage, $totalPages_rsHardwareAssets, $queryString_rsHardwareAssets); ?>">Last</a> 
        </td>
		<?php } // Show if not last page ?>		
      </tr>
    </table>
	</td>
	</tr>
	</table>
    
    <?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsHardwareAssets);

mysql_free_result($rsVendors);

mysql_free_result($rsPlatform);

mysql_free_result($rsHardwareUpdate);

mysql_free_result($rsDivision);

mysql_free_result($rsHardwareType);

mysql_free_result($rsLocation);

mysql_free_result($rsHardwareStatus);
?>
