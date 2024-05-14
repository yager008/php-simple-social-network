<?php

include_once("mysql.php");
include_once("debug.php");

session_abort();
session_start();

//require_once('Router.php');
//Router::handle("GET", "/table", "mysqltable.php");

$_SESSION['bEditProfile'] = false;
$_SESSION['bShowTable'] = true;
//$_SESSION['rowRef'];

if (!isset($_SESSION['bNewUserAlert']))
{
    $_SESSION['bNewUserAlert'] = false;
}

if ($_SESSION['bNewUserAlert'])
{
    echo "<script>window.alert('new user created');</script>";
    $_SESSION['bNewUserAlert'] = false; 
}

$sql = "SELECT * FROM `users`";
$result = mysqli_query($conn, $sql);

$UsernameError = '';
$PasswordError= '';

$UsernameBuffer ='';
$PasswordBuffer ='';

$RealUser= '';
$RealPassword= ''; 

$LoginError='';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tableButton']))
{
    header('Location: table');

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ca'])) {
    header('Location: createacc.php');
}

if (isset($_POST['submitbutton'])) {
    debug_to_console('submitbutton pressed');


    if(empty($_POST['username']) || empty($_POST['password']))
    {
        debug_to_console('smt is wrong');

        if(empty($_POST['username']))
        {
            $UsernameError='no username entered';
            debug_to_console('username is emptry');

        }
        else
        {
            $UsernameBuffer=$_POST['username'];
            $UsernameError='';
            debug_to_console('username is not empty');

        }

        if(empty($_POST['password']))
        {
            $PasswordError='no password entered';
            debug_to_console('password is empty');

        }
        else
        {
            $PasswordBuffer=$_POST['password'];
            $PasswordError='';
            debug_to_console('password is not empty');

        }
    }

    else 
    {
        $UsernameBuffer=$_POST['username'];
        $PasswordBuffer=$_POST['password'];

        $bFoundSuchUser = false;
        $rowRef = null;

        if (mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                if ($row['Name'] == $UsernameBuffer)
                {
                    $bFoundSuchUser = true;
                    $RealUser = $row['Name'];
                    $RealPassword = $row['Password'];
                    $rowRef = $row;
                }
            }
        }

        if($bFoundSuchUser)
        {
            debug_to_console("there is such user");

            if($PasswordBuffer == $RealPassword)
            {
                debug_to_console("welcome");
                $_SESSION['photoRef'] = 'avatars/avatar1.jpg';
                $_SESSION['rowRef'] = $rowRef;
                header("Location: userpage");
            }
            else {
                debug_to_console("password is wrong");
                $LoginError = 'password is wrong';
            }
        }

        else {

            debug_to_console("there is no such user");
            $LoginError = 'there is no such user';
        }


        $PasswordError='';
        $UsernameError='';
        //header('Location: userpage.php');
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FakeBook</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <div>
        FakeBook <br>
    </div>
    <div>
        Login:<br><br>
    </div>


    <div>
        Username:<br>
    </div>

    <form method="post">
        <input type="text" name='username' placeholder="username" value=
                                                                        <?php
                                                                            if (!empty($UsernameBuffer))
                                                                            {
                                                                                echo $UsernameBuffer;
                                                                            }
                                                                            else 
                                                                            {
                                                                                echo '';
                                                                            }
                                                                        ?>>
        <div>
            <!-- Usernameworning: -->
            <?php 
                if(isset($UsernameError))
                {
                    echo $UsernameError; 
                }
                else 
                {
                    echo '<br>';
                }
            ?> <br>
        </div>

        <div>
            Password: <br>
        </div>

        <input type="password" name='password' placeholder="password" value=
                                                                            <?php 
                                                                                if(!empty($PasswordBuffer))
                                                                                {
                                                                                    echo $PasswordBuffer; 
                                                                                }
                                                                                else 
                                                                                {
                                                                                    echo '';
                                                                                }
                                                                            ?>>
        <div>
            <!-- PasswordWarning: --> 
            <?php 
                if(isset($PasswordError))
                {
                    echo $PasswordError; 
                }
                else 
                {
                    echo '<br>';
                }
            ?> <br>
        </div>

        <button name='submitbutton'>submit</button>

        <button name='ca' >create account</button>

        <input type='reset'>

        <?php 
        if (!empty($LoginError))
        {
            echo "<br><br>{$LoginError}";
        }
        ?>

        <br><br>

        <button name="tableButton">listOfUsers</button>

    </form>
    
</body>
</html>
