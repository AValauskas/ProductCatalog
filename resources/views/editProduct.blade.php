@include('Menu')


<?php
$sku=$_GET['id'];
$dbc = database();
$sql = "select * from product where SKU='$sku'";
$data = mysqli_query($dbc, $sql);
$row = mysqli_fetch_assoc($data);

$statusnum=$row["status"];
$spherenum=$row["sphere"];

$sqlstat = "select * from status where id_Status='$statusnum'";
$sqlsphere = "select * from sphere where id_Sphere='$spherenum'";

$datastat = mysqli_query($dbc, $sqlstat);
$rowstat = mysqli_fetch_assoc($datastat);
$rowname=$rowstat['name'];

$datasphere = mysqli_query($dbc, $sqlsphere);
$rowsphere = mysqli_fetch_assoc($datasphere);
$rowsp=$rowsphere['name'];

?>

<html>
<body>

<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <h3>Product Edit</h3><br>
        <form class="" action="{{URL::to('/productedit')}}" method="get">
            <h2>name</h2> <input type="text" name="name" value="<?php {echo $row["name"];}  ?>">
            <h2>SKU</h2> <input type="text" name="sku" value="<?php {echo $row["SKU"];} ?>" readonly="readonly">
            <h2>price</h2> <input type="text" name="price" value="<?php {echo $row["base_price"];}  ?>">
            <h2>discount</h2>
                <input name="discount" type="range" min="0" max="100" value="<?php {echo $row["discount"];}  ?>" id="myRange">
            <p>Value: <span id="demo"></span></p>

            <h2>Description</h2> <textarea style="width: inherit;height: 200px"type="text" name="description" value="" required><?php {echo $row["description"];}  ?></textarea>
            <br><br>
            <select class="btn btn-lg" name="status">
                <option value="<?php echo"$statusnum" ?>" selected><?php echo"$rowname";?></option>
                <option value="1">enabled</option>
                <option value="2">disabled</option>
            </select >
            <br><br>
            <select class="btn btn-lg" name="sphere">
                <option value="<?php echo"$spherenum" ?>"selected><?php echo"$rowsp";?></option>
                <option value="1">sport</option>
                <option value="2">studies</option>
                <option value="3">freetime</option>
            </select >

            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <br><br>
            <button type=submit name="button">Submit</button>
            <br>
            <br>
            <?php
            if (isset($_SESSION['error']))
            {
                $msg=$_SESSION['error'];
                echo "$msg";
                $_SESSION['error']=null;
            }
            ?>


        </form>
    </div>
</div>
<br>
<script>
    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");
    output.innerHTML = slider.value;

    slider.oninput = function() {
        output.innerHTML = this.value;
    }
</script>
</body>


</html>