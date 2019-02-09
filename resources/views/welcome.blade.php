@include('Menu')

<html>


<body>

<?php
if (isset( $_SESSION["login_error"]))
    {
        echo $_SESSION["login_error"];
        $_SESSION["login_error"] =null;

    }
$dbc = database();
$sqladmin="select * from product";
$sqluser="select * from product where status='1'";
$data = mysqli_query($dbc, $sqladmin);
$datauser =mysqli_query($dbc, $sqluser);


$sqltax="select * from money";
$datatax = mysqli_query($dbc, $sqltax);
$rowtax = mysqli_fetch_assoc($datatax);

if (isset($_SESSION['userid']))
    {
        ?>
<a href=../public/addproduct><input type=button class="btn btn-lg" value='Add Product'></a>
<br><br>
<form class="" action="{{URL::to('/deletefew')}}" method="get">
<table class="table table-hover" id="myTable">
    <thead>
    <tr class="header">
        <th>Check</th>
        <th>Name</th>
        <th>SKU</th>
        <th>description</th>
        <th>Discount</th>
        <th>Edit</th>
        <th>Delete</th>
        <th>Tax</th>
    </tr>

    </thead>
    <tbody>
<?php
while($row = mysqli_fetch_array($data)) {
$idd =$row['SKU'];?>

<tr>
    <td> <input type="checkbox" name="prodtodelete[]" value="<?php echo "$idd" ?>"></td>
    <td><?php echo $row['name'];  ?></td>
    <td><?php echo "$idd"; ?></td>
    <td><?php echo $row['description'];?></td>
    <td><?php echo $row['discount'];?></td>
    <td> <?php echo" <a href=../public/editProduct?id=",urlencode($idd),"><input type=button class='btn btn-lg' id='$idd' value='Edit' ></a> " ?></td>
    <td> <?php echo" <a href=../public/deleteProduct?id=",urlencode($idd),"><input type=button class='btn btn-lg' id='$idd' value='Delete' ></a> " ?></td>
    <td> <input type="checkbox" onclick="Taxchange(<?php echo $idd ?>)" <?php if( $row['tax'] == '1'){echo "checked";} ?>  > </td>
</tr>
<?php }?>
    </tbody>
</table>
    <input type="submit" value="Delete">
</form>




<h2>Tax rate</h2>
    <input name="rate" type="range" onclick="Taxset()" min="0" max="100" value="<?php echo $rowtax['taxp'] ?>" id="myRange">
    <p>Value: <span id="demo"></span></p>


<h2>Global discount</h2>
<input name="disc" type="range" onclick="discset()" min="0" max="100" value="<?php echo $rowtax['global_discount'] ?>" id="my2Range">
<p>Value: <span id="demo2"></span></p>



<?php
}else{
?>

<table class="table table-hover" id="myTable">
    <tbody>
    <?php
    while($row = mysqli_fetch_array($datauser)) {
    $idd =$row['SKU'];
        ?>
    <tr onclick='trclick(<?php echo $idd ?>)' >
        <td><?php echo $row['name'];   ?></td>
        <td><?php echo $row['description'];?></td>
        <td><?php echo $row['base_price'];?></td>
    </tr>
    <?php }?>
    </tbody>
</table>


<?php }?>


<script>
    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");
    output.innerHTML = slider.value;

    slider.oninput = function() {
        output.innerHTML = this.value;
    }

    var slider2 = document.getElementById("my2Range");
    var output2 = document.getElementById("demo2");
    output2.innerHTML = slider2.value;

    slider2.oninput = function() {
        output2.innerHTML = this.value;
    }



    function trclick(x){
        window.location.href = "../public/productinfo?proid="+x;
    };

    function Taxchange(x) {
            window.location.href = "../public/taxchange?proid="+x;
    };
    function Taxset(){
        window.location.href = "../public/taxrate?value="+slider.value;
    };
    function discset(){
        window.location.href = "../public/discset?value="+slider2.value;
    };


</script>
</body>


</html>