<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{

    public function productadd(request $request)
    {
        $image=$request->file('image');

        $input=$image->getClientOriginalName();
        $destinationPath=public_path('/images');
        $image->move($destinationPath, $input);

        $name=$request->input('name');
        $sku=$request->input('sku');
        $price=$request->input('price');
        $description=$request->input('description');
        $status=$request->input('status');
        $sphere=$request->input('sphere');

        $dbc = database();

        $sqlcheck = "select * from product where SKU='$sku'";

        $data = mysqli_query($dbc, $sqlcheck);
        $row = mysqli_fetch_assoc($data);

        if (isset($row['SKU'])  )
        {
            $_SESSION["name"]=$name;
            $_SESSION["sku"]=$sku;
            $_SESSION["price"]=$price;
            $_SESSION["description"]=$description;
            $_SESSION["status"]=$status;
            $_SESSION["sphere"]=$sphere;

            $_SESSION["error"]="SKU already exist";
            return redirect('/welcome');
        }
        else {


            $sql = "insert into product(name,SKU,base_price,discount,image,description,status,sphere) values('$name','$sku','$price','0','$input','$description','$status','$sphere')";
            if (mysqli_query($dbc, $sql)) {
                return redirect('/welcome');
            }
        }
    }

   public function deleteProduct(request $request)
    {
        $sku=$_GET['id'];
        $dbc = database();
        $sql = "DELETE product from product where SKU='$sku'";
        if(mysqli_query($dbc, $sql)) {
            $_SESSION['Product deleted']="Product was succesfully deleted";
            return redirect('/welcome');

        }

    }
public function  productedit(request $request)
{
    $name=$request->input('name');
    $sku=$request->input('sku');
    $price=$request->input('price');
    $description=$request->input('description');
    $status=$request->input('status');
    $sphere=$request->input('sphere');
    $discount=$request->input('discount');

    if (   $status )
    $dbc = database();

    $sql = "update product set name='$name',base_price='$price',description='$description',status='$status',sphere='$sphere',discount ='$discount' where SKU='$sku'";
    if(mysqli_query($dbc, $sql))
    {
        $_SESSION['Productupdatet']="Product was succesfully updated";
        return redirect('/welcome');
    }


}
    public function  productrate(request $request)
    {
        $evaluation=$request->input('evaluation');
        $sku=$request->input('sku');
        $dbc = database();
        $sql ="insert into rate (number,fk_ProductSKU) values('$evaluation','$sku')";
        if (mysqli_query($dbc, $sql)) {
            $_SESSION['succesfullrate']="Rate was succesfully added";
            return redirect("/productinfo?proid=" . "$sku");
        }
    }

    public function  writereview(request $request)
    {
        $review=$request->input('review');
        $sku=$request->input('sku');
        $dbc = database();
        $sql ="insert into review (text,fk_ProductSKU) values('$review','$sku')";
        if (mysqli_query($dbc, $sql)) {
            $_SESSION['succesfullrev']="Review was succesfully added";
            return redirect("/productinfo?proid=" . "$sku");
        }
    }

    public function  deletefew(request $request)
    {
        $prodtodelete=$request->input('prodtodelete');
        if($prodtodelete==null)
        {
            return redirect('/welcome');
        }
        $dbc = database();

        foreach($prodtodelete as $item){

            $sqldeleterates = "DELETE rate from rate where fk_ProductSKU='$item'";
            $sqldeletereviews = "DELETE review from review where fk_ProductSKU='$item'";
            if(mysqli_query($dbc, $sqldeleterates)&&mysqli_query($dbc, $sqldeletereviews)) {
                $sql = "DELETE product from product where SKU='$item'";
                if (mysqli_query($dbc, $sql)) {
                    $_SESSION['Product deleted'] = "Products was succesfully deleted";
                }
            }
            else{$_SESSION['error_deleting']="error";}
        }
        return redirect('/welcome');
    }

    public function  taxchange()
    {
        $sku=$_GET['proid'];
        $dbc = database();
        $sqlfindbool="select tax from product where SKU ='$sku'";
        $data = mysqli_query($dbc, $sqlfindbool);
        $row = mysqli_fetch_assoc($data);
        $boo=$row['tax'];

        if (  $boo=='1'  ) {
            $sqltaxt = "update product set tax='0' where SKU='$sku'";
        }else{
            $sqltaxt = "update product set tax='1' where SKU='$sku'";
        }

        if (mysqli_query($dbc, $sqltaxt)) {
            return redirect('/welcome');
        }
    }


    public function  taxrate()
    {
        $rate=$_GET['value'];
        $dbc = database();
        $sqlfind ="select * from money";
        $data = mysqli_query($dbc, $sqlfind);
        $row = mysqli_fetch_assoc($data);

        if (isset($row['taxp'])||isset($row['global_discount']))
        {
            $sql="update money set taxp='$rate'";

        }else {
            $sql = "insert into money(taxp) values('$rate')";
        }
        mysqli_query($dbc, $sql);
        return redirect('/welcome');
    }

    public function  discset()
    {
        $dis=$_GET['value'];
        $dbc = database();
        $sqlfind ="select * from money";
        $data = mysqli_query($dbc, $sqlfind);
        $row = mysqli_fetch_assoc($data);

        if (isset($row['taxp'])||isset($row['global_discount']))
        {
            $sql="update money set global_discount='$dis'";

        }else {
            $sql = "insert into money(global_discount) values('$dis')";
        }
        mysqli_query($dbc, $sql);
        return redirect('/welcome');
    }

    public function revsdisplay()
    {
        $sku = $_POST['sku'];
        $review=$_POST['review'];
        $dbc = database();
        $sql ="insert into review (text,fk_ProductSKU) values('$review','$sku')";

        if(mysqli_query($dbc, $sql)) {
            return response()->json([
                'status' => 'success',
                'sku' => $sku,
                'review' => $review
            ]);
        }
    }

    public function prodinfo()
    {
        $sku = $_POST['sku'];



        $dbc = database();
        $sql="select * from product where SKU='$sku'";
        $data=mysqli_query($dbc, $sql);
        if ( isset($data)){
            $row = mysqli_fetch_assoc($data);
            return response()->json([
                'status' => 'success',
                'name' => $row['name'],
                'sku' => $row['SKU'],
                'price' => $row['base_price'],
                'description' => $row['description'],
                'discount' => $row['discount'],
                'show' => $row['status'],
                'sphere' => $row['sphere'],
            ]);

        }





    }





}
