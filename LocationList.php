<?php require_once('Connections/eam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 // 
mysql_select_db($database_eam, $eam);
$query_rsLocationsList = "SELECT * FROM location ORDER BY location ASC";
$rsLocationsList = mysql_query($query_rsLocationsList, $eam) or die(mysql_error());
$row_rsLocationsList = mysql_fetch_assoc($rsLocationsList);
$totalRows_rsLocationsList = mysql_num_rows($rsLocationsList);
?>
<?php $pageTitle="Locations"; ?>
<?php include('includes/header.php'); ?>
    <h3>Location List</h3>
    <table width="600" class="table1">
      <tr>
        <th>Location</th>
        <th>Comments</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $row_rsLocationsList['location']; ?></td>
          <td><?php echo $row_rsLocationsList['comments']; ?></td>
          <td><a href="LocationUpdate.php?recordID=<?php echo $row_rsLocationsList['id']; ?>">Update</a></td>
          <td>
    	<form id="delRecord" name="delRecord" method="post" action="LocationDelete.php?recordID=<?php echo $row_rsLocationsList['id']; ?>">
           <input name="Submit" type="submit" class="red" value="Delete This Record" />
        </form>              
          </td>
        </tr>
      <?php } while ($row_rsLocationsList = mysql_fetch_assoc($rsLocationsList)); ?>
    </table>
<table class="pagination">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table> 

<?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsLocationsList);
?>
