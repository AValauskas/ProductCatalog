@include('Menu')


<?php
$sku=$_GET['proid'];
$dbc = database();
$data=DB::table('product')
    ->where('SKU','=',$sku)
    ->first();
        $name=$data->name;

$datareviews=DB::table('review')
    ->where('fk_ProductSKU','=',$sku)
    ->get();

$datatax = DB::table('money')
    ->first();
$name=$data->name;



if($data->tax==1 && $data->discount>0)
{
    //yra pvm
    $firstprice= $price=$data->base_price+$data->base_price*$datatax->taxp/100;
    $price=$data->base_price+$data->base_price*$datatax->taxp/100-$data->base_price * $data->discount/100;
    $withtax="the price we apply with taxes";

}else if ($data->tax==1 && $data->discount==0 )
{
    $price=$data->base_price+$data->base_price*$datatax->taxp/100-$data->base_price*$datatax->global_discount/100;
    $withtax="the price we apply with taxes";
}
else if($data->tax==0 && $data->discount>0){
    $firstprice= $price=$data->base_price+$data->base_price*$datatax->taxp/100;
    $price=$data->base_price-$data->base_price*$data->discount/100;
    $withtax="the price we apply without taxes";
}
else{
    $price=$data->base_price-$data->base_price*$datatax->global_discount/100;
    $withtax="the price we apply without taxes";
}


$ratesql="select AVG(number) as avg from rate where fk_ProductSKU='$sku'";
$ratedata = mysqli_query($dbc, $ratesql);
$rowrate = mysqli_fetch_assoc($ratedata);

?>
<html>
<body>

<div class="container" style="border-style: solid;">
    <div class="row">
        <div class="col-sm-6">
            <h2><?php echo $name ?></h2>
            <p><?php echo $data->description ?></p>
            <br><br>
            <h2>Price <?php if(isset($firstprice)){echo"<strike>$firstprice &#8364;</strike> <br> ";} $firstprice= null; echo "$price &#8364"; ?></h2>
            <br><br>
            <p><?php echo $withtax ?></p>
        </div>
        <div class="col-sm-4">
            <p><img src="../public/images/<?php echo $data->image?>" width="300" height="300"></p>
        </div>
        <div class="col-sm-2">
            <h3>Rankings</h3>
            <h3><?php echo bcdiv($rowrate['avg'],1,2);?></h3>

        </div>

    </div>
</div>


<br><br>

<div class="container">
    <div class="row">
        <div class="col-sm-6">
<h2>Rate product</h2>
<form class="" action="{{URL::to('/productrate')}}" method="get">

    <select class="btn btn-lg" name="evaluation" required>
        <option value=""></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select >
    <br><br>
    <input type="hidden" id="sku" name="sku" value="{{$sku}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <br><br>
    <button type=submit name="button" value="Register">Submit</button>
    <br>
    <br>
    <?php
    if (isset($_SESSION['succesfullrate']))
    {
        $msg=$_SESSION['succesfullrate'];
        echo "$msg";
        $_SESSION['succesfullrate']=null;
    }
    ?>
</form>
        </div>
        <div class="col-sm-6">
            <input type="hidden" id="_token"  name="_token" value="{{csrf_token()}}">
            <textarea style="width: 400px ;height: 200px"type="text" id="review" name="review" value="" required></textarea>
            <br><br>
            <button id="show-rev" class="btn-rev">Add review</button>
        </div>
    </div>
</div>
<br><br>


<center><table>
<h2>Reviews</h2>
<tbody id="list-item">
<?php
foreach($datareviews as $review) {
?>
<tr>
    <td><?php echo $review->text;?></td>
</tr>
<?php }?>
</tbody>
</table></center>


<script>
    $('#show-rev').click(function()
    {
        console.log('buttn clicked');
        showreviews();

    });
    
    function showreviews() {
        var sku = document.getElementById('sku').value
        var review = document.getElementById('review').value
        var token = document.getElementById('_token').value
        console.log(sku);

        $.ajax({
            type: "post",
            url: "<?= URL::to('/revsdisplay')?>",
            dataType: "json",
            data:{
                'sku': sku,
                'review': review,
                '_token' : token
            },

            beforesend: function () {

            },
            success: function (data) {
                if (data.status == 'success') {
                $('#list-item').before(
                    '<tr>' +
                    '<td>' + data.review + '</td>' +
                    '</tr>'
                )
            }else{alert('Error')}
            }
        });

    }


</script>

</body>
</div>
</html>
