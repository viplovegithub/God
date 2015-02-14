<?php require_once('Connections/eam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 //  // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 // 
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
$query_rsCompanyName = "SELECT company_name FROM company";
$rsCompanyName = mysql_query($query_rsCompanyName, $eam) or die(mysql_error());
$row_rsCompanyName = mysql_fetch_assoc($rsCompanyName);
$totalRows_rsCompanyName = mysql_num_rows($rsCompanyName);
 $pageTitle="Home"; ?>
<?php include('includes/header.php'); ?> 
    <h3><?php echo $row_rsCompanyName['data']; ?> - Enterprise Asset Management</h3>
    <table class="table1">
      <tr>
        <th width="25%" nowrap="nowrap">Whoops!</th>
      </tr>
      <tr>
        <td>
          <p>&nbsp;</p>
          <p align="center">You've accessed a restricted page - please contact your admin to request access!</p>
          <p align="center"><a href="index.php">Take me back to the main page!</a></p>
          <p align="center">&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
        </td>
      </tr>
    </table>
    <table class="pagination">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>    
</div>
<?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsCompanyName);
?>
