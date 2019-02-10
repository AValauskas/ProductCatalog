@include('Menu')

<html>


<body>

<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <h3>Product add</h3><br>




        <form class="" action="{{URL::to('/productadd')}}" method="post" enctype="multipart/form-data">
            <h2>name</h2> <input type="text" required name="name" value="<?php if(isset($_SESSION['name'])){echo $_SESSION["name"]; $_SESSION["name"]=null;}  ?> ">
            <h2>SKU</h2> <input type="text" required name="sku" value="<?php if(isset($_SESSION['sku'])){echo $_SESSION["sku"]; $_SESSION["sku"]=null;}  ?>">
            <h2>price</h2> <input type="text" required name="price" value="<?php if(isset($_SESSION['price'])){echo $_SESSION["price"]; $_SESSION["price"]=null;}  ?>">
            <h2>Description</h2> <textarea style="width: inherit;height: 200px"type="text" name="description" value="<?php if(isset($_SESSION['description'])){echo $_SESSION["description"]; $_SESSION["description"]=null;}  ?>" required></textarea>
            <br><br>
            <select class="btn btn-lg" name="status" required>
                <option value="">Choose status</option>
                <option value="1">enabled</option>
                <option value="2">disabled</option>
            </select >
            <br><br>
            <select class="btn btn-lg" name="sphere" required>
                <option value="">choose sphere</option>
                <option value="1">sport</option>
                <option value="2">studies</option>
                <option value="3">freetime</option>
            </select >
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <h2>Photo</h2> <input type="file" name="image" id="image" required/><br>
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
</body>


</html>