
<!DOCTYPE html>
<html>
 <head>
 <title> Fetched data</title>
 </head>
<body>

  <table>
  
  <tr>
    <td>Id</td>
    <td>Owner</td>
    <td>Category</td>
    <td>Breed</td>
    <td>Age</td>
    <td>Status</td>

  </tr>
<?php
foreach($petlist as $row) {
?>
<tr>
    <td><?php echo $row["id"]; ?></td>
    <td><?php echo $row["owner"]; ?></td>
    <td><?php echo $row["category"]; ?></td>
    <td><?php echo $row["breed"]; ?></td>
    <td><?php echo $row["age"]; ?></td>
    <td><?php echo $row["status"]; ?></td>


</tr>
<?php
}

?>
</table>


</body>
</html>