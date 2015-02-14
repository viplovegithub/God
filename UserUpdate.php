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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE members SET username=%s, password=%s, firstname=%s, lastname=%s, `role`=%s WHERE id=%s",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['role'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_eam, $eam);
  $Result1 = mysql_query($updateSQL, $eam) or die(mysql_error());

  $updateGoTo = "UserList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsMembers = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsMembers = $_GET['recordID'];
}
mysql_select_db($database_eam, $eam);
$query_rsMembers = sprintf("SELECT * FROM members WHERE id = %s", GetSQLValueString($colname_rsMembers, "int"));
$rsMembers = mysql_query($query_rsMembers, $eam) or die(mysql_error());
$row_rsMembers = mysql_fetch_assoc($rsMembers);
$totalRows_rsMembers = mysql_num_rows($rsMembers);

mysql_select_db($database_eam, $eam);
$query_rsMemberRoles = "SELECT `role` FROM members";
$rsMemberRoles = mysql_query($query_rsMemberRoles, $eam) or die(mysql_error());
$row_rsMemberRoles = mysql_fetch_assoc($rsMemberRoles);
$totalRows_rsMemberRoles = mysql_num_rows($rsMemberRoles);

mysql_free_result($rsMembers);

mysql_free_result($rsMemberRoles);

$pageTitle="User Update"; ?>
<?php include('includes/header.php'); ?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">

  
  
  <fieldset>
      <legend>Update User</legend>
      <p>
        <label for="Vendor ID">User ID</label>
        <?php echo $row_rsMembers['id']; ?></p>
      <p>
        <label for="First Name">First Name</label>
        <input type="text" name="firstname" value="<?php echo htmlentities($row_rsMembers['firstname'], ENT_COMPAT, ''); ?>" size="32">
      </p>
      <p>
        <label for="Last Name">Last Name</label>
        <input type="text" name="lastname" value="<?php echo htmlentities($row_rsMembers['lastname'], ENT_COMPAT, ''); ?>" size="32">
      </p>
      <p>
        <label for="Username">Username</label>
        <input type="text" name="username" value="<?php echo htmlentities($row_rsMembers['username'], ENT_COMPAT, ''); ?>" size="32">
      </p>
      <p>
        <label for="Password">Password</label>
        <input type="text" name="password" value="<?php echo htmlentities($row_rsMembers['password'], ENT_COMPAT, ''); ?>" size="32">
      </p>
      <p>
        <label for="Role">Role</label>
        <select name="role">
          <option value="admin" <?php if (!(strcmp("admin", $row_rsMembers['role']))) {echo "selected=\"selected\"";} ?>>Admin - Full Rights</option>
          <option value="editor" <?php if (!(strcmp("editor", $row_rsMembers['role']))) {echo "selected=\"selected\"";} ?>>Editor - Manage Assets, Reporting</option>
          <?php
do {  
?>
<option value="<?php echo $row_rsMembers['role']?>"<?php if (!(strcmp($row_rsMembers['role'], $row_rsMembers['role']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsMembers['role']?> &nbsp;&nbsp;<- current role</option>
          <?php
} while ($row_rsMemberRoles = mysql_fetch_assoc($rsMemberRoles));
  $rows = mysql_num_rows($rsMemberRoles);
  if($rows > 0) {
      mysql_data_seek($rsMemberRoles, 0);
	  $row_rsMemberRoles = mysql_fetch_assoc($rsMemberRoles);
  }
?>
        </select>
      </p>
   
      <p class="submit">
        <input type="submit" value="Update User">
      </p>
      </fieldset>  
  
  
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_rsMembers['id']; ?>">
</form>
    <?php include('includes/footer.php'); ?><?php
mysql_free_result($rsSoftwareVendor);
?>
