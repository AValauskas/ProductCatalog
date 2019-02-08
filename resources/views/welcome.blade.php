@include('Menu')

<html>


<body>
<?php

$dbc = database();
$sql="select * from product";
$data = mysqli_query($dbc, $sql);

if (isset($_SESSION['userid']))
    {
        ?>
<a href=../public/addproduct><input type=button class="btn btn-lg" value='Add Product'></a>
<br><br>
<div class="journal">
<table class="table table-hover" id="myTable">
    <thead>

    </thead>
    <tbody>
<?php
while($row = mysqli_fetch_array($data)) {?>
<tr>
    <td><?php echo $row['name'];   $idd =$row['SKU'];?></td>
    <td><?php echo $row['description'];?></td>
    <td> <?php echo" <a href=../public/editProduct?id=",urlencode($idd),"><input type=button class='btn btn-lg' id='$idd' value='Edit' ></a> " ?></td>
    <td> <?php echo" <a href=../public/deleteProduct?id=",urlencode($idd),"><input type=button class='btn btn-lg' id='$idd' value='Delete' ></a> " ?></td>
</tr>
<?php }?>
    </tbody>
</table>
</div>



<?php
}
?>



</body>


</html>