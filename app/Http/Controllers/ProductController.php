<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function productadd(request $request)
    {
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
            return redirect('/addproduct');
        }
        else {


            $sql = "insert into product(name,SKU,base_price,description,status,sphere) values('$name','$sku','$price','$description','$status','$sphere')";
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


    if (   $status )
    $dbc = database();

    $sql = "update product set name='$name',base_price='$price',description='$description',status='$status',sphere='$sphere' where SKU='$sku'";
    if(mysqli_query($dbc, $sql))
    {
        $_SESSION['Productupdatet']="Product was succesfully updated";
        return redirect('/welcome');
    }


}



}
