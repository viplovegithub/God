<?php require_once('Connections/eam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 // 
mysql_select_db($database_eam, $eam);
$query_rsDivisionList = "SELECT * FROM division";
$rsDivisionList = mysql_query($query_rsDivisionList, $eam) or die(mysql_error());
$row_rsDivisionList = mysql_fetch_assoc($rsDivisionList);
$totalRows_rsDivisionList = mysql_num_rows($rsDivisionList);
?>
<?php 
	$pageTitle="Divisions";
	include('includes/header.php');
?>
<h3>Division List</h3>

<table width="600" class="table1">
  <tr>
    <th>Division</th>
    <th>Comments</th>
    <th>Update</th>
    <th>Delete</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsDivisionList['division']; ?></td>
      <td><?php echo $row_rsDivisionList['comments']; ?></td>
      <td><a href="DivisionUpdate.php?recordID=<?php echo $row_rsDivisionList['id']; ?>">Update</a></td>
      <td>
    	<form id="delRecord" name="delRecord" method="post" action="DivisionDelete.php?recordID=<?php echo $row_rsDivisionList['id']; ?>">
           <input name="Submit" type="submit" class="red" value="Delete This Record" />
        </form>      
      </td>
    </tr>
    <?php } while ($row_rsDivisionList = mysql_fetch_assoc($rsDivisionList)); ?>
</table>
<table class="pagination">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table> 

<?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsDivisionList);
?>
