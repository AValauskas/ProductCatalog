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
<a href=../public/addproduct><input type=button class="btn btn-success" value='Add Product'></a>
<br><br>
<form class="" action="{{URL::to('/deletefew')}}" method="get">
    <div style="overflow: auto; max-height: 60vh;" class="col-md-12">
<table class="table table-hover" id="myTable">
    <thead>
    <tr class="header">
        <th>mark to delete</th>
        <th>photo</th>
        <th>Name</th>
        <th>SKU</th>
        <th>description</th>
        <th>base price</th>
        <th>Discount</th>
        <th>Edit</th>
        <th>Delete</th>
        <th>Tax</th>
    </tr>

    </thead>
    <tbody >
<?php
while($row = mysqli_fetch_array($data)) {
$idd =$row['SKU'];?>

<tr>
    <td> <input type="checkbox" name="prodtodelete[]" value="<?php echo "$idd" ?>"></td>
    <td><img src="../public/images/<?php echo $row['image']?>" width="100" height="100"></td>
    <td><?php echo $row['name'];  ?></td>
    <td><?php echo "$idd"; ?></td>
    <td><?php echo $row['description'];?></td>
    <td><?php echo $row['base_price'];?></td>
    <td><?php echo $row['discount'];?></td>
    <td> <?php echo" <a href=../public/editProduct?id=",urlencode($idd),"><input type=button class='btn btn-lg' id='$idd' value='Edit' ></a> " ?></td>
    <td> <?php echo" <a href=../public/deleteProduct?id=",urlencode($idd),"><input type=button class='btn btn-lg' id='$idd' value='Delete' ></a> " ?></td>
    <td> <input type="checkbox" onclick="Taxchange(<?php echo $idd ?>)" <?php if( $row['tax'] == '1'){echo "checked";} ?>  > </td>
</tr>
<?php }?>
    </tbody>
</table>
    </div>
    <input type="submit" value="Delete">
</form>



<div class="container">
    <div class="row">
<h2>Tax rate</h2>
    <input name="rate" type="range" onclick="Taxset()" min="0" max="100" value="<?php echo $rowtax['taxp'] ?>" id="myRange">
    <p>Value: <span id="demo"></span></p>
    </div>
    <div class="row">
<h2>Global discount</h2>
<input name="disc" type="range" onclick="discset()" min="0" max="100" value="<?php echo $rowtax['global_discount'] ?>" id="my2Range">
        <p>Value: <span id="demo2"></span></p>\</div>
</div>


<?php
}else{
?>



<div class="container" style="top:1000px">
    <div class="row">


        <?php
        while($row = mysqli_fetch_array($datauser)) {
        $idd =$row['SKU'];

        $ratesql="select AVG(number) as avg from rate where fk_ProductSKU='$idd'";
        $ratedata = mysqli_query($dbc, $ratesql);
        $rowrate = mysqli_fetch_assoc($ratedata);


        $revsql="select count(text) as txt from review where fk_ProductSKU='$idd'";
        $revdata = mysqli_query($dbc, $revsql);
        $rowrev = mysqli_fetch_assoc($revdata);


        if($row['tax']==1 && $row['discount']>0)
        {
            //yra pvm
            $firstprice= $price=$row['base_price']+$row['base_price']*$rowtax['taxp']/100;
            $price=$row['base_price']+$row['base_price']*$rowtax['taxp']/100-$row['base_price']*$row['discount']/100;

        }else if ($row['tax']==1 && $row['discount']==0 )
        {
            $price=$row['base_price']+$row['base_price']*$rowtax['taxp']/100-$row['base_price']*$rowtax['global_discount']/100;
        }
        else if($row['tax']==0 && $row['discount']>0){
            $firstprice= $price=$row['base_price']+$row['base_price']*$rowtax['taxp']/100;
            $price=$row['base_price']-$row['base_price']*$row['discount']/100;
        }
        else{
            $price=$row['base_price']-$row['base_price']*$rowtax['global_discount']/100;
        }
        ?>
        <div class="col-md-4 col-sm-6 col-xs-12" style="border-style: solid; border-width: 1px; height: 200px " onclick='divclick(<?php echo $idd ?>)'>
            <div class="col-sm-6">
            <p><?php echo $row['name'];?></p>
            <img src="../public/images/<?php echo $row['image']?>" width="150" height="150">
            </div>
            <div class="col-sm-6">
                <p>SKU: <?php echo $row['SKU'];?></p>
                <p>Price <?php if(isset($firstprice)){echo"<strike>$firstprice</strike> &#8364;<br> ";} $firstprice= null; echo "$price &#8364"; ?></p>
                <p>Rate <?php echo bcdiv($rowrate['avg'],1,2);?></p>
                <p>number of reviews <?php echo  $rowrev['txt'];?></p>
            </div>

        </div>
            <?php }?>


    </div>
</div>
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



    function divclick(x){
        window.location.href = "../public/productinfo?proid="+x;
    };
    function trclick(x){
        window.location.href = "../public/editProduct?id="+x;
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