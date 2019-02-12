<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

        $data=DB::table('product')
            ->where('SKU','=',$sku)
            ->first();

        if (isset($data->SKU)  )
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
           DB::insert('insert into product(name,SKU,base_price,discount,image,description,status,sphere) values(?,?,?,?,?,?,?,?)', [$name,$sku,$price,0,$input,$description,$status,$sphere]);
                return redirect('/welcome');

        }
    }

   public function deleteProduct(request $request)
    {
        $sku=$_GET['id'];
        $dbc = database();
        DB::table('rate')->where('fk_ProductSKU', '=', $sku)->delete();
        DB::table('review')->where('fk_ProductSKU', '=', $sku)->delete();
        if(DB::table('product')->where('SKU', '=', $sku)->delete())
        {
            $_SESSION['Product_deleted']="Product was succesfully deleted";
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
   if( DB::table('product')
        ->where('SKU', $sku)
        ->update(['name' => $name,
        'base_price' => $price,
        'description' => $description,
            'status' => $status,
            'sphere' => $sphere,
            'discount' => $discount
        ])){
        $_SESSION['Productupdatet']="Product was succesfully updated";
        return redirect('/welcome');
    }


}
    public function  productrate(request $request)
    {
        $evaluation=$request->input('evaluation');
        $sku=$request->input('sku');
        $dbc = database();
        if(DB::insert('insert into rate(number,fk_ProductSKU) values(?,?)',[$evaluation,$sku])) {
            $_SESSION['succesfullrate']="Rate was succesfully added";
            return redirect("/productinfo?proid=" . "$sku");
        }
    }

    public function  writereview(request $request)
    {
        $review=$request->input('review');
        $sku=$request->input('sku');
        if (DB::insert('insert into review(text,fk_ProductSKU) values(?,?)',[$review,$sku])) {
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
        foreach($prodtodelete as $item){
            DB::table('rate')->where('fk_ProductSKU', '=', $item)->delete();
            DB::table('review')->where('fk_ProductSKU', '=', $item)->delete();
                if(DB::table('product')->where('SKU', '=', $item)->delete()){
                    $_SESSION['Product deleted'] = "Products was succesfully deleted";
                }

            else{$_SESSION['error_deleting']="error";}
        }
        return redirect('/welcome');
    }

    public function  taxchange()
    {
        $sku=$_GET['proid'];

        $data=DB::table('product')
            ->where('SKU','=',$sku)
            ->first();
        $boo=$data->tax;
        if (  $boo=='1'  ) {
            DB::table('product')
                ->where('SKU', $sku)
                ->update(['tax' => 0]);
        }else{
            DB::table('product')
                ->where('SKU', $sku)
                ->update(['tax' => 1]);
        }
            return redirect('/welcome');
    }

    public function  taxrate()
    {
        $rate=$_GET['value'];

        $data=DB::table('money')
            ->first();
        if (isset($data->taxp)||isset($data->global_discount))
        {
            DB::table('money')
                ->update(['taxp' => $rate]);
        }else {
            DB::insert('insert into money(taxp) values(?)',[$rate]);
        }
        return redirect('/welcome');
    }

    public function  discset()
    {
        $dis=$_GET['value'];

        $data=DB::table('money')
            ->first();

        if (isset($data->taxp)||isset($data->global_discount))
        {
            DB::table('money')
                ->update(['global_discount' => $dis]);
        }else {
            DB::insert('insert into money(global_discount) values(?)',[$dis]);
        }
        return redirect('/welcome');
    }

    public function revsdisplay()
    {
        $sku = $_POST['sku'];
        $review=$_POST['review'];
        if(DB::insert('insert into review(text,fk_ProductSKU) values(?,?)',[$review,$sku])) {
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

        $data=DB::table('product')
            ->where('SKU','=',$sku)
            ->first();
        if ( isset($data)){
            return response()->json([
                'status' => 'success',
                'name' => $data->name,
                'sku' => $data->SKU,
                'price' => $data->base_price,
                'description' => $data->description,
                'discount' => $data->discount,
                'show' => $data->status,
                'sphere' => $data->sphere,
            ]);

        }
    }

}
