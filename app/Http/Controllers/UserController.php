<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function log(request $request)      //paima prisijungimo duomenis is db
    {
        $username=$request->input('username');
        $pass=$request->input('password');

        $dbc = database();

        $sql="select * from person where username='$username' and password='$pass'";
        $data = mysqli_query($dbc, $sql);
        $row = mysqli_fetch_assoc($data);

        if (isset($row['username'])  )
        {

            $_SESSION["username"] = $username;
            $id = $row['id'];
            $_SESSION["userid"] = $row['id'];
            return redirect('/welcome');
        }
        else{
            $_SESSION["login_error"]="username or password was incorrect";
            return redirect('/welcome');

        }
    }

    public function logout(request $request)
    {
        $_SESSION["username"]=null;
        $_SESSION["userid"]=null;
        return redirect('/welcome');
    }

    public function continueas(request $request)
    {
        $_SESSION["username"]=null;
        $_SESSION["userid"]=null;
        return redirect('/welcome');
    }


}
