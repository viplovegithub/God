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

mysql_select_db($database_eam, $eam);
$query_rsPlatformList = "SELECT * FROM assets_hardware_platform";
$rsPlatformList = mysql_query($query_rsPlatformList, $eam) or die(mysql_error());
$row_rsPlatformList = mysql_fetch_assoc($rsPlatformList);
$totalRows_rsPlatformList = mysql_num_rows($rsPlatformList);
?><?php $pageTitle="Platforms"; ?>
<?php include('includes/header.php'); ?>
<h3>Platform List</h3>
<table width="600" cellspacing="0" class="table1">
  <tr>
    <th>Platform</th>
    <th>Comments</th>
    <th>Update</th>
    <th>Delete</th>
  </tr>
  <?php do { ?>
  <tr>
    <td><?php echo $row_rsPlatformList['platform']; ?></td>
    <td><?php echo $row_rsPlatformList['comments']; ?></td>
    <td><a href="PlatformUpdate.php?platform_id=<?php echo $row_rsPlatformList['platform_id']; ?>">Update</a></td>
    <td>
    	<form id="delRecord" name="delRecord" method="post" action="PlatformDelete.php?recordID=<?php echo $row_rsPlatformList['platform_id']; ?>">
           <input name="Submit" type="submit" class="red" value="Delete This Record" />
        </form>
    </td>
  </tr>
  <?php } while ($row_rsPlatformList = mysql_fetch_assoc($rsPlatformList)); ?>
</table>
<table class="pagination">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table> 
<?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsPlatformList);
?>
