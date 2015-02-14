<?php require_once('Connections/eam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 // 
mysql_select_db($database_eam, $eam);
$query_rsHardwareTypes = "SELECT * FROM assets_hardware_type";
$rsHardwareTypes = mysql_query($query_rsHardwareTypes, $eam) or die(mysql_error());
$row_rsHardwareTypes = mysql_fetch_assoc($rsHardwareTypes);
$totalRows_rsHardwareTypes = mysql_num_rows($rsHardwareTypes);
 ?>
<?php $pageTitle="List Hardware Types"; ?>
<?php include('includes/header.php'); ?>
<h3>List Hardware Types </h3>
<table width="600" class="table1">
  <tr>
    <th>Hardware Types </th>
    <th>Comments</th>
    <th>Update</th>
    <th>Delete</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsHardwareTypes['assets_hardware_type']; ?></td>
      <td><?php echo $row_rsHardwareTypes['comments']; ?></td>
      <td><a href="HardwareTypeUpdate.php?recordID=<?php echo $row_rsHardwareTypes['id']; ?>">Update</a></td>
      <td>
    	<form id="delRecord" name="delRecord" method="post" action="HardwareTypeDelete.php?recordID=<?php echo $row_rsHardwareTypes['id']; ?>">
           <input name="Submit" type="submit" class="red" value="Delete This Record" />
        </form>      
      </td>
    </tr>
    <?php } while ($row_rsHardwareTypes = mysql_fetch_assoc($rsHardwareTypes)); ?>
</table>
<table class="pagination">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>  
<?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsHardwareTypes);
?>
