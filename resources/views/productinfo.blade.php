@include('Menu')


<?php
$sku=$_GET['proid'];
$dbc = database();
      $sql="select * from product where SKU ='$sku'";
      $data = mysqli_query($dbc, $sql);
      $row = mysqli_fetch_assoc($data);
        $name=$row['name'];

$reviewssql="select * from review where fk_ProductSKU=$sku ";
$datareviews = mysqli_query($dbc, $reviewssql);
?>
<html>





<body>

<td><img src="../public/images/<?php echo $row['image']?>" width="200" height="200"></td>
<br><br>
<h2><?php echo "$name" ?></h2>
<br><br>
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
    <button type=submit name="button">Submit</button>
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

<br><br>

<div>
    <input type="hidden" id="_token"  name="_token" value="{{csrf_token()}}">
    <textarea style="width: inherit;height: 200px"type="text" id="review" name="review" value="" required></textarea>
    <br><br>
    <button id="show-rev" class="btn-rev">Add review</button>
</div>

<table>

<h2>Reviews</h2>
<tbody id="list-item">
<?php
while($rowrevs = mysqli_fetch_array($datareviews)) {
?>
<tr>
    <td><?php echo $rowrevs['text'];?></td>
</tr>
<?php }?>
</tbody>
</table>


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

</html>
