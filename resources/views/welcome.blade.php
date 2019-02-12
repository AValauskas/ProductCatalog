@include('Menu')

<html>


<body>
<head>
    <style>
        .form-popup {
            display: none;
            position: fixed;
            bottom: 0;
            right: 15px;
            border: 3px solid #f1f1f1;
            z-index: 9;
            background-color: #98e1b7;
        }

        .btn2{
            background-color: green;
        }

    </style>
<?php
    if(isset($_SESSION["error"])){?>
     <style>
       #myForm{display: block;}
     </style>
<?php }?>


</head>
<?php
if (isset( $_SESSION["login_error"]))
    {
        echo $_SESSION["login_error"];
        $_SESSION["login_error"] =null;

    }
$dbc = database();

$dataadmin=DB::table('product')
    ->get();


$datauser =DB::table('product')
    ->where('status','=',1)
    ->get();


$datatax = DB::table('money')
    ->first();


if (isset($_SESSION['userid']))
    {
        ?>

<!-- add popup form -->
<button class="btn btn-success" onclick="openForm()">Add product</button>

<div class="form-popup" id="myForm">
    <form class="" action="{{URL::to('/productadd')}}" method="post" enctype="multipart/form-data">
        <div class="form-group">
        <label for="name">Name </label><br><input type="text" required name="name" id="name" value="<?php if(isset($_SESSION['name'])){echo $_SESSION["name"]; $_SESSION["name"]=null;}  ?> ">
        </div>
        <div class="form-group">
            <label for="sku">SKU </label><br> <input type="text" required name="sku" id="sku" value="<?php if(isset($_SESSION['sku'])){echo $_SESSION["sku"]; $_SESSION["sku"]=null;}  ?>">
        </div>
        <div class="form-group">
            <label for="price">Price </label><br><input type="text" required name="price" id="price" value="<?php if(isset($_SESSION['price'])){echo $_SESSION["price"]; $_SESSION["price"]=null;}  ?>">
        </div>
        <div class="form-group">
            <label for="description">Description </label><br> <textarea style="width: inherit;height: 200px"type="text" name="description" id="description" value="<?php if(isset($_SESSION['description'])){echo $_SESSION["description"]; $_SESSION["description"]=null;}  ?>" required><?php if(isset($_SESSION['description'])){echo $_SESSION["description"]; $_SESSION["description"]=null;}  ?></textarea>
        </div>
            <br><br>
        <div class="form-group">
        <select class="btn btn-lg" name="status" required>
            <option value="">Choose status</option>
            <option value="1">enabled</option>
            <option value="2">disabled</option>
        </select >
        </div>
        <br><br>
        <div class="form-group">
        <select class="btn btn-lg" name="sphere" required>
            <option value="">choose sphere</option>
            <option value="1">sport</option>
            <option value="2">studies</option>
            <option value="3">freetime</option>
        </select >
        </div>
        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
        <div class="form-group">
            <label for="photo">Photo </label><br><input type="file" name="image" id="image" required/><br>
        </div>
        <br>
        <button  type=submit class="btn2">Submit</button>
        <br><br>
        <button type="button" class="btn btn-danger" onclick="closeForm()">Close</button>
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

<!-- edit popup form -->
<div class="form-popup" id="myForm2">
    <form class="" action="{{URL::to('/productedit')}}" method="get" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name </label><br><input type="text" required name="name" id="name2" value="">
        </div>
        <div class="form-group">
            <label for="sku">SKU </label><br> <input type="text" required name="sku" id="sku2" value="">
        </div>
        <div class="form-group">
            <label for="price">Price </label><br><input type="text" required name="price" id="price2" value="">
        </div>
        <div class="form-group">
            <label for="discount">Discount </label><br> <input name="discount" type="range" min="0" max="100" value="" id="myRange3">
            <p>Value: <span id="demo3"></span></p>
        </div>

        <div class="form-group">
            <label for="description">Description </label><br> <textarea style="width: inherit;height: 200px"type="text" name="description" id="description2" value="" required></textarea>
        </div>
        <br>
        <div class="form-group">
            <select class="btn btn-lg" name="status" id="toshow" required>
                <option value="">Choose status</option>
                <option value="1">enabled</option>
                <option value="2">disabled</option>
            </select >
        </div>
        <br>
        <div class="form-group">
            <select class="btn btn-lg" name="sphere" id="sphere2" required>
                <option value="">choose sphere</option>
                <option value="1">sport</option>
                <option value="2">studies</option>
                <option value="3">freetime</option>
            </select >
        </div>
        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
        <button  type=submit class="btn2">Submit</button>
        <br><br>
        <button type="button" class="btn btn-danger" onclick="closeForm2()">Close</button>
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
foreach ($dataadmin as $datas) {
$idd =$datas->SKU;?>

<tr>
    <td> <input type="checkbox" name="prodtodelete[]" value="<?php echo "$idd" ?>"></td>
    <td><img src="../public/images/<?php echo $datas->image?>" width="100" height="100"></td>
    <td><?php echo $datas->name;  ?></td>
    <td><?php echo "$idd"; ?></td>
    <td><?php echo $datas->description;?></td>
    <td><?php echo $datas->base_price;?></td>
    <td><?php echo $datas->discount;?></td>
    <td><input type=button class='btn btn-primar' id='<?php echo $idd ?>' value='Edit' onclick="EditPop(<?php echo $idd ?>)" ></td>
    <td> <?php echo" <a href=../public/deleteProduct?id=",urlencode($idd),"><input type=button class='btn btn-danger' id='$idd' value='Delete' ></a> " ?></td>
    <td> <input type="checkbox" onclick="Taxchange(<?php echo $idd ?>)" <?php if( $datas->tax == '1'){echo "checked";} ?>  > </td>
</tr>
<?php }?>
    </tbody>
</table>
    </div>
    <input type="submit" value="Delete" class="btn btn-danger">
    <br>
    <?php if(isset( $_SESSION['Product_deleted']))
    {
     echo  $_SESSION['Product_deleted'];
      $_SESSION['Product_deleted']=null;
    }
    ?>

</form>


<div class="container">
    <div class="row">
<h2>Tax rate</h2>
    <input name="rate" type="range" onclick="Taxset()" min="0" max="100" value="<?php echo $datatax->taxp ?>" id="myRange">
    <p>Value: <span id="demo"></span></p>
    </div>
    <div class="row">
<h2>Global discount</h2>
<input name="disc" type="range" onclick="discset()" min="0" max="100" value="<?php echo $datatax->global_discount?>" id="my2Range">
        <p>Value: <span id="demo2"></span></p></div>
</div>


<?php
}else{
?>
<div class="container" style="top:1000px">
    <div class="row">


        <?php
        foreach (@$datauser as $datas) {
        $idd =$datas->SKU;

        $ratesql="select AVG(number) as avg from rate where fk_ProductSKU='$idd'";
        $ratedata = mysqli_query($dbc, $ratesql);
        $rowrate = mysqli_fetch_assoc($ratedata);


        $revsql="select count(text) as txt from review where fk_ProductSKU='$idd'";
        $revdata = mysqli_query($dbc, $revsql);
        $rowrev = mysqli_fetch_assoc($revdata);


        if($datas->tax==1 && $datas->discount>0)
        {
            //yra pvm
            $firstprice= $price=$datas->base_price+$datas->base_price*$datatax->taxp/100;
            $price=$datas->base_price+$datas->base_price*$datatax->taxp/100-$datas->base_price*$datas->discount/100;

        }else if ($datas->tax==1 && $datas->discount==0 )
        {
            $price=$datas->base_price+$datas->base_price*$datatax->taxp/100-$datas->base_price*$datatax->global_discount/100;
        }
        else if($datas->tax==0 && $datas->discount>0){
            $firstprice= $price=$datas->base_price+$datas->base_price*$datatax->taxp/100;
            $price=$datas->base_price-$datas->base_price*$datas->discount/100;
        }
        else{
            $price=$datas->base_price-$datas->base_price*$datatax->global_discount/100;
        }
        ?>
        <div class="col-md-4 col-sm-6 col-xs-12" style="border-style: solid; border-width: 1px; height: 200px " onclick='divclick(<?php echo $idd ?>)'>
            <div class="col-sm-6">
            <p><?php echo $datas->name;?></p>
            <img src="../public/images/<?php echo $datas->image?>" width="150" height="150">
            </div>
            <div class="col-sm-6">
                <p>SKU: <?php echo $datas->SKU;?></p>
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


    function Taxchange(x) {
            window.location.href = "../public/taxchange?proid="+x;
    };
    function Taxset(){
        window.location.href = "../public/taxrate?value="+slider.value;
    };
    function discset(){
        window.location.href = "../public/discset?value="+slider2.value;
    };


    function openForm() {
        closeForm2();
        document.getElementById("myForm").style.display = "block";
    }

    function closeForm() {
        document.getElementById("myForm").style.display = "none";
    }
    function openForm2() {
        document.getElementById("myForm2").style.display = "block";
    }

    function closeForm2() {
        document.getElementById("myForm2").style.display = "none";
    }


    function EditPop(x) {
        closeForm();
        var token = document.getElementById('_token').value
        console.log(x);
        $.ajax({
            type: "post",
            url: "<?= URL::to('/prodinfo')?>",
            dataType: "json",
            data:{
                'sku': x,
                '_token' : token
            },
            beforesend: function () {
            },
            success: function (data) {
                if (data.status == 'success') {
                    console.log(data.name);
                    $('#name2').val(data.name);
                    $('#sku2').val(data.sku);
                    $('#price2').val(data.price);
                    $('#description2').val(data.description);
                    $('#myRange3').val(data.discount);
                    $('#sphere2').val(data.sphere);
                    $("#toshow").val(data.show);
                    var slider3 = document.getElementById("myRange3");
                    var output3 = document.getElementById("demo3");
                    output3.innerHTML = slider3.value;
                    console.log(slider3.value);
                    slider3.oninput = function() {
                        output3.innerHTML = this.value;
                    }
                    openForm2();
                }else{alert('Error')}
            }

        });
    }
</script>
</body>


</html>