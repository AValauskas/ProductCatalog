<?php
session_start();


function database()
{
    $dbc = mysqli_connect('localhost', 'root', '', 'catalog');
    if (!$dbc) {
        die ("Can't connect to MySQL:" . mysqli_error($dbc));
    }
    return $dbc;
}
