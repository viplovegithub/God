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

$maxRows_rsMembers = 50;
$pageNum_rsMembers = 0;
if (isset($_GET['pageNum_rsMembers'])) {
  $pageNum_rsMembers = $_GET['pageNum_rsMembers'];
}
$startRow_rsMembers = $pageNum_rsMembers * $maxRows_rsMembers;

mysql_select_db($database_eam, $eam);
$query_rsMembers = "SELECT * FROM members";
$query_limit_rsMembers = sprintf("%s LIMIT %d, %d", $query_rsMembers, $startRow_rsMembers, $maxRows_rsMembers);
$rsMembers = mysql_query($query_limit_rsMembers, $eam) or die(mysql_error());
$row_rsMembers = mysql_fetch_assoc($rsMembers);

if (isset($_GET['totalRows_rsMembers'])) {
  $totalRows_rsMembers = $_GET['totalRows_rsMembers'];
} else {
  $all_rsMembers = mysql_query($query_rsMembers);
  $totalRows_rsMembers = mysql_num_rows($all_rsMembers);
}
$totalPages_rsMembers = ceil($totalRows_rsMembers/$maxRows_rsMembers)-1;
?>
<?php include('includes/header.php'); ?>
<h3>User List</h3>
<table class="table1">
  <tr>
    <th>First Name</th>
    <th>Last Name</th>    
    <th>Username</th>
    <th>Role</th>
    <th>Update</th>    
    <th>Delete</th>    
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsMembers['firstname']; ?></td>
      <td><?php echo $row_rsMembers['lastname']; ?></td>
      <td><?php echo $row_rsMembers['username']; ?></td>
      <td><?php echo $row_rsMembers['role']; ?></td>
      <td><a href="UserUpdate.php?recordID=<?php echo $row_rsMembers['id']; ?>">Update</a></td>
      <td><a href="UserDelete.php?recordID=<?php echo $row_rsMembers['id']; ?>">Delete</a></td>
    </tr>
    <?php } while ($row_rsMembers = mysql_fetch_assoc($rsMembers)); ?>
</table>
    <table class="pagination">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
<?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsMembers);
?>
