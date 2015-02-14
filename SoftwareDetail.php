<?php require_once('Connections/eam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 // 
$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

mysql_select_db($database_eam, $eam);
$recordID = $_GET['recordID'];
$query_DetailRS1 = "SELECT * FROM assets_software WHERE asset_software_id = $recordID";
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $eam) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
?>
<?php $pageTitle="Software Detail"; ?>
<?php include('includes/header.php'); ?>
    <table class="tableDetails1">
      <tr>
        <td style="font-size:100%">
          <fieldset>
          <legend>Software Detail</legend>
          <p>
            <label for="Asset Id">Asset Id</label>
            <?php echo $row_DetailRS1['asset_software_id']; ?> &nbsp; </p>
          <p>
            <label for="Software">Software</label>
            <?php echo $row_DetailRS1['asset']; ?> &nbsp; </p>
          <p>
            <label for="Platform">Platform</label>
            <?php echo $row_DetailRS1['platform']; ?> &nbsp; </p>
          <p>
            <label for="Seats">Seats</label>
            <?php echo $row_DetailRS1['seats']; ?> &nbsp; </p>
          <p>
            <label for="Model">Vendor</label>
            <?php echo $row_DetailRS1['vendor']; ?> &nbsp; </p>
          <p>
            <label for="Version">Version</label>
            <?php echo $row_DetailRS1['version']; ?> &nbsp; </p>
          <p>
            <label for="License type">License type</label>
            <?php echo $row_DetailRS1['license_type']; ?> &nbsp; </p>
          <hr />
          <p>
            <label for="Status">Status</label>
            <?php echo $row_DetailRS1['status']; ?> &nbsp; </p>
          <p>
            <label for="Model">Date purchased</label>
            <?php echo $row_DetailRS1['date_purchase']; ?> &nbsp; </p>
          <hr />
          <p>
            <label for="User">User</label>
            <?php echo $row_DetailRS1['user']; ?> &nbsp; </p>
          <p>
            <label for="Division">Division</label>
            <?php echo $row_DetailRS1['division']; ?> &nbsp; </p>
          <p>
            <label for="Location">Location</label>
            <?php echo $row_DetailRS1['location']; ?> &nbsp; </p>
          <p>
            <label for="Comments">Comments</label>
            <?php echo $row_DetailRS1['comments']; ?> &nbsp; </p>
          </fieldset>
        </td>
        <td valign="top" style="font-size:90%;">
          <p>&nbsp;</p>
          <fieldset style="width:180px;">
          <legend>Manage Record</legend>
          <table class="table1">
            <tr>
              <td class="green">
                <form id="upRecord" name="upRecord" method="post" action="SoftwareUpdate.php?recordID=<?php echo $row_DetailRS1['asset_software_id']; ?>">
                  <input type="submit" name="Submit2" value="Edit This Record" />
                </form>
              </td>
            </tr>
          </table>
          <br />
          <table class="table1">
            <tr>
              <td class="red">
                <form id="delRecord" name="delRecord" method="post" action="SoftwareDelete.php?recordID=<?php echo $row_DetailRS1['asset_software_id']; ?>">
                  <input type="submit" name="Submit" value="Delete This Record" />
                </form>
              </td>
            </tr>
          </table>
          </fieldset>
        </td>
      </tr>
    </table>
    <?php include('includes/footer.php'); ?>
<?php
mysql_free_result($DetailRS1);
?>
