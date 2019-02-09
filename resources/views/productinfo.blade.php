@include('Menu')


<?php
$sku=$_GET['proid'];
$dbc = database();
      $sql="select * from product where SKU ='$sku'";
      $data = mysqli_query($dbc, $sql);
      $row = mysqli_fetch_assoc($data);
        $name=$row['name'];


?>
<html>





<body>
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
    <input type="hidden" name="sku" value="{{$sku}}">
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
<h2>Add review</h2>
<form class="" action="{{URL::to('/writereview')}}" method="get">

    <textarea style="width: inherit;height: 200px"type="text" name="review" value="" required></textarea>
    <br><br>
    <input type="hidden" name="sku" value="{{$sku}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <br><br>
    <button type=submit name="button">Submit</button>
    <br>
    <br>
    <?php
    if (isset($_SESSION['succesfullrev']))
    {
        $msg=$_SESSION['succesfullrev'];
        echo "$msg";
        $_SESSION['succesfullrev']=null;
    }
    ?>
</form>

</body>

</html>
