<?php

include("mysql.php");
include_once "debug.php";

session_start();
$_SESSION['bNewUserAlert'] = false;


$sql = "SELECT * FROM `users`";

$result = mysqli_query($conn, $sql);

$UsernameError = '';
$PasswordError= '';

$UsernameBuffer ='';
$PasswordBuffer ='';

$RealUser= '';
$RealPassword= ''; 

$LoginError='';


if($_SERVER['REQUEST_METHOD'] = 'POST' && isset($_POST['button_name_aha']))
{
    header('Location: loginpage.php');
}

if (isset($_POST['submitButton']))
{
    if(empty($_POST['username']) || empty($_POST['password']))
    {
        if(empty($_POST['username']))
        {
            $UsernameError='no username entered';
            debug_to_console('username is empty');
        }
        else
        {
            $UsernameBuffer=$_POST['username'];
            $UsernameError='';
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
        }
    }
    else
    {
        $UsernameBuffer=$_POST['username'];
        $PasswordBuffer=$_POST['password'];

        $bFoundSuchUser = false;

        if (mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                if ($row['Name'] == $UsernameBuffer)
                {
                    $bFoundSuchUser = true;
                    $LoginError = 'such user already exists';
                }
            }
        }

        if(!$bFoundSuchUser)
        {
            $sql = "INSERT INTO `users` (Name, Password, PhotoRef) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $UsernameBuffer, $PasswordBuffer, $photoRef);
            $photoRef = 'avatars/defaultavatar.jpg'; // Assuming this is a default value
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            debug_to_console("new user created");
            $_SESSION['bNewUserAlert'] = true;
            header("Location: loginpage.php");
        }

        $PasswordError='';
        $UsernameError='';
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
        FakeBook<br>
    </div>
    <div>
        Create Account<br><br>
    </div>


    <div>
        Username:<br>
    </div>

    <form action='' method="post">
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
            Password:<br>
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
            ?>
            <br>
        </div>

        <button name='submitButton'>submit</button>

        <button name='button_name_aha' >already have account</button>
        <input type='reset'>

        <?php 
            if (!empty($LoginError)) {
                echo "<br><br>{$LoginError}";
            }
        ?>



    </form>
    
</body>
</html>

