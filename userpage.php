<?php

include "mysql.php";
include_once "UpdateRowRefFunc.php";
include_once "GetRowFromIDFunc.php";

session_start();

UpdateRowRef($conn);

$_SESSION['nameBuffer'] = $_SESSION['rowRef']['Name'];
$_SESSION['surnameBuffer'] = $_SESSION['rowRef']['Surname'];
$_SESSION['aboutMeBuffer'] = $_SESSION['rowRef']['AboutMe'];

include "userPageParts/SessionVarsSetup.php";

//DEBUG rowRef ID
//echo "current id: {$_SESSION['rowRef']['ID']} <br>";

include "userpageParts/ButtonProcessing/chatWithUserButton.php";

//editProfileButton
//submitEditProfileButton
//showTableButton.php
//logoutButton.php
include "userpageParts/ButtonProcessing/basicButtons.php";

include "userPageParts/ChatMessageProcessing.php";

include "userPageParts/EditProfileInputFieldsProcessing.php";

//DEBUG
//echo "bEditProfile:";
//echo ($_SESSION['bEditProfile']) ? 'true' : 'false';
//echo "<br> bShowTable:";
//echo ($_SESSION['bShowTable']) ? 'true' : 'false';
//echo "<br> bShowChat:";
//echo ($_SESSION['bShowChat']) ? 'true' : 'false';
//echo "<br><br><br>";

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
<div class="my div" style='margin-left: +15%;'>
    <img src="<?php echo $_SESSION['rowRef']['PhotoRef']; ?>" style="width: 100px; height: 100px;">
    <br>
    <br>

    <?php
    if($_SESSION['bEditProfile'])
    {
        include "userPageParts/EditProfile.php";
    }
    else
    {
        include "userPageParts/ViewProfile.php";
    }


    if($_SESSION['bShowTable'])
    {
        include "userPageParts/ShowTable.php";
    }

    if ($_SESSION['bShowChat'])
    {
        include "userPageParts/ShowChat.php";
    }
    ?>
</body>
</html>