<?php require_once('Connections/eam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 // 
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsSoftware = 10;
$pageNum_rsSoftware = 0;
if (isset($_GET['pageNum_rsSoftware'])) {
  $pageNum_rsSoftware = $_GET['pageNum_rsSoftware'];
}
$startRow_rsSoftware = $pageNum_rsSoftware * $maxRows_rsSoftware;

mysql_select_db($database_eam, $eam);
$query_rsSoftware = "SELECT * FROM assets_software";
$query_limit_rsSoftware = sprintf("%s LIMIT %d, %d", $query_rsSoftware, $startRow_rsSoftware, $maxRows_rsSoftware);
$rsSoftware = mysql_query($query_limit_rsSoftware, $eam) or die(mysql_error());
$row_rsSoftware = mysql_fetch_assoc($rsSoftware);

if (isset($_GET['totalRows_rsSoftware'])) {
  $totalRows_rsSoftware = $_GET['totalRows_rsSoftware'];
} else {
  $all_rsSoftware = mysql_query($query_rsSoftware);
  $totalRows_rsSoftware = mysql_num_rows($all_rsSoftware);
}
$totalPages_rsSoftware = ceil($totalRows_rsSoftware/$maxRows_rsSoftware)-1;

$queryString_rsSoftware = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsSoftware") == false && 
        stristr($param, "totalRows_rsSoftware") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsSoftware = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsSoftware = sprintf("&totalRows_rsSoftware=%d%s", $totalRows_rsSoftware, $queryString_rsSoftware);
 
$pageTitle="Software Assets List"; ?>
<?php include('includes/header.php'); ?>
    <h3>Software Assets </h3>
    <table border="1" class="table1">
      <tr>
        <th>Software Asset </th>
        <th>Vendor</th>
        <th>Version</th>
        <th>License type</th>
        <th>platform</th>
        <th>location</th>
        <th>View</th>
        <th>Edit</th>
      </tr>
      <?php do { ?>
        <tr onmouseover="this.bgColor='#F2F7FF'" onmouseout="this.bgColor='#FFFFFF'";>
          <td> <?php echo $row_rsSoftware['asset']; ?>&nbsp; </td>
          <td> <?php echo $row_rsSoftware['vendor']; ?>&nbsp; </td>
          <td> <?php echo $row_rsSoftware['version']; ?>&nbsp; </td>
          <td> <?php echo $row_rsSoftware['license_type']; ?>&nbsp; </td>
          <td> <?php echo $row_rsSoftware['platform']; ?>&nbsp; </td>
          <td> <?php echo $row_rsSoftware['location']; ?>&nbsp; </td>
          <td> <a href="SoftwareDetail.php?recordID=<?php echo $row_rsSoftware['asset_software_id']; ?>">View</a></td>
          <td><a href="SoftwareUpdate.php?recordID=<?php echo $row_rsSoftware['asset_software_id']; ?>">Edit</a></td>
        </tr>
        <?php } while ($row_rsSoftware = mysql_fetch_assoc($rsSoftware)); ?>
    </table>
    <table class="pagination">
      <tr>
        <td>Records <?php echo ($startRow_rsSoftware + 1) ?> to <?php echo min($startRow_rsSoftware + $maxRows_rsSoftware, $totalRows_rsSoftware) ?> of <?php echo $totalRows_rsSoftware ?></td>
        <td>
          <table>
            <tr>
              <?php if ($pageNum_rsSoftware > 0) { // Show if not first page ?>
                <td width="23%" align="center"> <a href="<?php printf("%s?pageNum_rsSoftware=%d%s", $currentPage, 0, $queryString_rsSoftware); ?>">First</a> </td>
                <?php } // Show if not first page ?>
              <?php if ($pageNum_rsSoftware > 0) { // Show if not first page ?>
                <td width="31%" align="center"> <a href="<?php printf("%s?pageNum_rsSoftware=%d%s", $currentPage, max(0, $pageNum_rsSoftware - 1), $queryString_rsSoftware); ?>">Previous</a> </td>
                <?php } // Show if not first page ?>
              <?php if ($pageNum_rsSoftware < $totalPages_rsSoftware) { // Show if not last page ?>
                <td width="23%" align="center"> <a href="<?php printf("%s?pageNum_rsSoftware=%d%s", $currentPage, min($totalPages_rsSoftware, $pageNum_rsSoftware + 1), $queryString_rsSoftware); ?>">Next</a> </td>
                <?php } // Show if not last page ?>
              <?php if ($pageNum_rsSoftware < $totalPages_rsSoftware) { // Show if not last page ?>
                <td width="23%" align="center"> <a href="<?php printf("%s?pageNum_rsSoftware=%d%s", $currentPage, $totalPages_rsSoftware, $queryString_rsSoftware); ?>">Last</a> </td>
                <?php } // Show if not last page ?>
            </tr>
          </table>
        </td>
      </tr>
    </table>

<?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsSoftware);
?>
