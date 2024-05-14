<?php

include_once("debug.php");
$db_server = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'mydb';
$conn = '';

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

try
{
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name); 
}
catch(mysqli_sql_exception)
{
    echo "amogus";
}


if($conn)
{
    debug_to_console("you are connected");
}

else
{
    debug_to_console("you are not connected");
}
