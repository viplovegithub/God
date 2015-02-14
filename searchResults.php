<?php require_once('Connections/eam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2013 // 
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
 // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2013 // 
$maxRows_rsHardwareAssets = 50;
$pageNum_rsHardwareAssets = 0;
if (isset($_GET['pageNum_rsHardwareAssets'])) {
  $pageNum_rsHardwareAssets = $_GET['pageNum_rsHardwareAssets'];
}
$startRow_rsHardwareAssets = $pageNum_rsHardwareAssets * $maxRows_rsHardwareAssets;

$varModel_rsHardwareAssets = "-1";
if (isset($_POST['model'])) {
  $varModel_rsHardwareAssets = $_POST['model'];
}
$varUser_rsHardwareAssets = "-1";
if (isset($_POST['user'])) {
  $varUser_rsHardwareAssets = $_POST['user'];
}
$varUserAccount_rsHardwareAssets = "-1";
if (isset($_POST['user_account'])) {
  $varUserAccount_rsHardwareAssets = $_POST['user_account'];
}
$varLocation_rsHardwareAssets = "-1";
if (isset($_POST['location'])) {
  $varLocation_rsHardwareAssets = $_POST['location'];
}
$varSerialnumber_rsHardwareAssets = "-1";
if (isset($_POST['serialnumber'])) {
  $varSerialnumber_rsHardwareAssets = $_POST['serialnumber'];
}
$varAssettype_rsHardwareAssets = "-1";
if (isset($_POST['asset_type'])) {
  $varAssettype_rsHardwareAssets = $_POST['asset_type'];
}
$varVendor_rsHardwareAssets = "-1";
if (isset($_POST['vendor'])) {
  $varVendor_rsHardwareAssets = $_POST['vendor'];
}
$varPlatform_rsHardwareAssets = "-1";
if (isset($_POST['platform'])) {
  $varPlatform_rsHardwareAssets = $_POST['platform'];
}
$varAssetTag_rsHardwareAssets = "-1";
if (isset($_POST['asset_tag'])) {
  $varAssetTag_rsHardwareAssets = $_POST['asset_tag'];
}
$varPurchaseOrder_rsHardwareAssets = "-1";
if (isset($_POST['purchase_order'])) {
  $varPurchaseOrder_rsHardwareAssets = $_POST['purchase_order'];
}
mysql_select_db($database_eam, $eam);
$query_rsHardwareAssets = sprintf("SELECT * FROM assets_hardware WHERE vendor = %s or platform = %s or asset_type = %s or serialnumber = %s or user = %s or user_account = %s or location = %s or model = %s or asset_tag = %s or purchase_order = %s ORDER BY assets_hardware.`user`", GetSQLValueString($varVendor_rsHardwareAssets, "text"),GetSQLValueString($varPlatform_rsHardwareAssets, "text"),GetSQLValueString($varAssettype_rsHardwareAssets, "text"),GetSQLValueString($varSerialnumber_rsHardwareAssets, "text"),GetSQLValueString($varUser_rsHardwareAssets, "text"),GetSQLValueString($varUserAccount_rsHardwareAssets, "text"),GetSQLValueString($varLocation_rsHardwareAssets, "text"),GetSQLValueString($varModel_rsHardwareAssets, "text"),GetSQLValueString($varAssetTag_rsHardwareAssets, "text"),GetSQLValueString($varPurchaseOrder_rsHardwareAssets, "text"));
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
 
$pageTitle="Search"; ?>
<?php include('includes/header.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
?>
<h3>Search Assets </h3>
<table class="table1">
  <tr>
    <th>Purchase Order</th>
    <th>Asset Tag</th>      
    <th>Serial Number</th>  
    <th>Vendor</th>
    <th>Platform </th>	
    <th>Type </th>
    <th>Model</th>
    <th>Status</th>	
    <th>Location</th>
    <th>User</th>
    <th>User Account</th>	
    <th>View </th>
    <th>Edit</th>
  </tr>
  <?php do { ?>
    <tr onmouseover="this.bgColor='#F2F7FF'" onmouseout="this.bgColor='#FFFFFF'";>
      <td><?php echo $row_rsHardwareAssets['purchase_order']; ?></td>
      <td><?php echo $row_rsHardwareAssets['asset_tag']; ?></td>          
      <td><?php echo $row_rsHardwareAssets['serialnumber']; ?></td>    
      <td><?php echo $row_rsHardwareAssets['vendor']; ?></td>	
      <td><?php echo $row_rsHardwareAssets['platform']; ?></td>
      <td><?php echo $row_rsHardwareAssets['asset_type']; ?></td>
      <td><?php echo $row_rsHardwareAssets['model']; ?></td>
	  <td><?php echo $row_rsHardwareAssets['status']; ?></td>	  
      <td><?php echo $row_rsHardwareAssets['location']; ?></td>
      <td><?php echo $row_rsHardwareAssets['user']; ?></td>
      <td><?php echo $row_rsHardwareAssets['user_account']; ?></td>
      <td><a href="HardwareDetail.php?recordID=<?php echo $row_rsHardwareAssets['asset_hardware_id']; ?>">View</a></td>
      <td><a href="HardwareUpdate.php?recordID=<?php echo $row_rsHardwareAssets['asset_hardware_id']; ?>">Edit</a></td>
    </tr>
    <?php } while ($row_rsHardwareAssets = mysql_fetch_assoc($rsHardwareAssets)); ?>
</table>
<table class="pagination">
<tr>
  <td><div style="float:left;">Records <?php echo ($startRow_rsHardwareAssets + 1) ?> to <?php echo min($startRow_rsHardwareAssets + $maxRows_rsHardwareAssets, $totalRows_rsHardwareAssets) ?> of <?php echo $totalRows_rsHardwareAssets ?></div>
  <div style="float:right;">
    <table class="pagination1">
      <tr>
        <?php if ($pageNum_rsHardwareAssets > 0) { // Show if not first page ?>
          <td> <a href="<?php printf("%s?pageNum_rsHardwareAssets=%d%s", $currentPage, 0, $queryString_rsHardwareAssets); ?>"><img src="images/First.gif" alt="First Page" title="First Page" /></a> </td>
            <?php } // Show if not first page ?>
			
        <?php if ($pageNum_rsHardwareAssets > 0) { // Show if not first page ?>	
          <td> <a href="<?php printf("%s?pageNum_rsHardwareAssets=%d%s", $currentPage, max(0, $pageNum_rsHardwareAssets - 1), $queryString_rsHardwareAssets); ?>"><img src="images/Previous.gif" alt="Previous Page" title="Previous Page" /></a> </td>
         <?php } // Show if not first page ?>
		 
        <?php if ($pageNum_rsHardwareAssets < $totalPages_rsHardwareAssets) { // Show if not last page ?>
          <td> <a href="<?php printf("%s?pageNum_rsHardwareAssets=%d%s", $currentPage, min($totalPages_rsHardwareAssets, $pageNum_rsHardwareAssets + 1), $queryString_rsHardwareAssets); ?>"><img src="images/Next.gif" alt="Next Page" title="Next Page" /></a> </td>
            <?php } // Show if not last page ?>
        <?php if ($pageNum_rsHardwareAssets < $totalPages_rsHardwareAssets) { // Show if not last page ?>
          <td> <a href="<?php printf("%s?pageNum_rsHardwareAssets=%d%s", $currentPage, $totalPages_rsHardwareAssets, $queryString_rsHardwareAssets); ?>"><img src="images/Last.gif" alt="Last Page" title="Last Page" /></a> </td>
            <?php } // Show if not last page ?>
        </tr>
    </table>
	</div>
  </td>
  </tr>
</table>	
  <?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsHardwareAssets);
?>
