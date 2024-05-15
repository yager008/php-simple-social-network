<?php


//editProfileButton
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editProfileButton']))
{
    $_SESSION['bEditProfile'] = !$_SESSION['bEditProfile'];
    $_SESSION['bShowTable'] = false;
}

//submitEditProfileButton
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitEditProfileButton']))
{
    $_SESSION['bEditProfile'] = !$_SESSION['bEditProfile'];
    $_SESSION['bShowTable'] = true;
}

//showTableButton.php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['showTableButton']))
{
    $_SESSION['bShowTable'] = true;
    $_SESSION['bShowChat'] = false;
}

//LogoutButton
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logoutbutton']))
{
    header('Location: login');
}
