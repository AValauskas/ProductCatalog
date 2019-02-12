<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function log(request $request)
    {
        $username=$request->input('username');
        $pass=$request->input('password');

        $dbc = database();

        //$sql="select * from person where username='$username' and password='$pass'";
      //  $data = mysqli_query($dbc, $sql);

        $data=DB::table('person')
            ->where('username','=','admin')
            ->orWhere('password','=','admin')
            ->get();


        foreach($data as $one){

            if (isset($one->username)  )
            {

                $_SESSION["username"] = $username;
                $id = $one->id;
                $_SESSION["userid"] = $one->id;;
                return redirect('/welcome');
            }
            else{
                $_SESSION["login_error"]="username or password was incorrect";
                return redirect('/welcome');

            }
        }
    }

    public function logout(request $request)
    {
        $_SESSION["username"]=null;
        $_SESSION["userid"]=null;
        return redirect('/welcome');
    }

}
