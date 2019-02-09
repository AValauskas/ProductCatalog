<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>


<nav class="navbar navbar-inverse" style="margin-bottom: 0px">
    <div class="container-fluid">
        <div class="navbar-header">

        </div>
        <ul class="nav navbar-nav">
            <li class="{{Request::is('/')?'active':null }}"><a href="{{url('/')}}">Welcome</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <?php
            if (!isset($_SESSION['userid']))
            {
            ?>
            <div class="login-container">
                <form class="" action="{{URL::to('/log')}}" method="post">
                    <input type="text" placeholder="Username" name="username">
                    <input type="password" placeholder="Password" name="password">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type=submit name="button">Submit</button>
                </form>
            </div>
            <?php }
            else{
            ?>
            <li class="{{Request::is('/logout')?'active':null}}"><a href="{{url('/logout')}}"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
       <?php }
       ?>
        </ul>
    </div>
</nav>

<body>

</body>


</html>