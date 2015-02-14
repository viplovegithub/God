<?php require_once('Connections/eam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 // 
mysql_select_db($database_eam, $eam);
$query_rsSoftwareVendors = "SELECT * FROM vendors_software";
$rsSoftwareVendors = mysql_query($query_rsSoftwareVendors, $eam) or die(mysql_error());
$row_rsSoftwareVendors = mysql_fetch_assoc($rsSoftwareVendors);
$totalRows_rsSoftwareVendors = mysql_num_rows($rsSoftwareVendors);
 
$pageTitle="Software Vendor List"; ?>
<?php include('includes/header.php'); ?>
    <h3>Software Vendor List </h3>
  
    <table width="600" class="table1">
      <tr>
        <th>vendor</th>
        <th>comments</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $row_rsSoftwareVendors['vendor']; ?></td>
          <td><?php echo $row_rsSoftwareVendors['comments']; ?></td>
          <td><a href="SoftwareVendorUpdate.php?recordID=<?php echo $row_rsSoftwareVendors['vendor_id']; ?>">Update</a></td>
          <td>
          		<form id="delRecord" name="delRecord" method="post" action="SoftwareVendorDelete.php?recordID=<?php echo $row_rsSoftwareVendors['vendor_id']; ?>">
                  <input name="Submit" type="submit" class="red" value="Delete This Record" />
                </form>
          </td>
        </tr>
        <?php } while ($row_rsSoftwareVendors = mysql_fetch_assoc($rsSoftwareVendors)); ?>
    </table>
    <table class="pagination">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>      
<?php include('includes/footer.php'); ?><?php
mysql_free_result($rsSoftwareVendors);
?>
