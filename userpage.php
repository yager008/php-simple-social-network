<?php

include "mysql.php";
include_once "UpdateRowRefFunc.php";
include_once "GetRowFromIDFunc.php";

session_start();

UpdateRowRef($conn);

$_SESSION['nameBuffer'] = $_SESSION['rowRef']['Name'];
$_SESSION['surnameBuffer'] = $_SESSION['rowRef']['Surname'];
$_SESSION['aboutMeBuffer'] = $_SESSION['rowRef']['AboutMe'];

if (!isset($_SESSION['bShowChat']))
{
    $_SESSION['bShowChat'] = false;
}

if (!isset($_SESSION['IDofChatter']))
{
    $_SESSION['IDofChatter'] = 0;
}

if (!isset($_SESSION['tableName']))
{
    $_SESSION['tableName'] = null;
}

if (!isset($_SESSION['chatterRowRef']))
{
    $_SESSION['chatterRowRef'] = null;
}

if (!isset($_SESSION['bShowTable']))
{
    $_SESSION['bShowTable'] = true;
}

if (!isset($_SESSION['bEditProfile']))
{
    $_SESSION['bEditProfile'] = false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editProfileButton']))
{
    $_SESSION['bEditProfile'] = !$_SESSION['bEditProfile'];
    $_SESSION['bShowTable'] = false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitEditProfileButton']))
{
    $_SESSION['bEditProfile'] = !$_SESSION['bEditProfile'];
    $_SESSION['bShowTable'] = true;
}

echo "current id: {$_SESSION['rowRef']['ID']} <br>";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['switchButton']))
{
    $_SESSION['bShowTable'] = true;
    $_SESSION['bShowChat'] = false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buttonID']))
{
    $_SESSION['bEditProfile'] = false;
    $_SESSION['bShowTable'] = false;
    $_SESSION['bShowChat'] = true;
    $_SESSION['IDofChatter'] = $_POST['buttonID'];
    $_SESSION['chatterRowRef'] = GetRowFromID($conn, $_POST['buttonID']);

    $id1 = $_SESSION['chatterRowRef']['ID'];
    $id2 = $_SESSION['rowRef']['ID'];

    if ($id1 >= $id2)
    {
        $temp = $id1;
        $id1 = $id2;
        $id2 = $temp;
    }

    $_SESSION['tableName'] = 'id' . "{$id1}" . 'id' . "{$id2}";

    $sql =
        "
        CREATE TABLE IF NOT EXISTS `{$_SESSION['tableName']}` (
          `ID` int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `Name` varchar(255) NOT NULL,
          `Text` varchar(255) NOT NULL,
          `Date` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}

//отпраляем инфу по чату
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['chatTextArea']))
{

    echo "<br> text from chatTextArea: {$_POST['chatTextArea']} <br><br>";

    try
    {
        $currentDate = date('Y-m-d H:i:s', time() + 60 *60 *2 );

        $sql = "INSERT INTO `" . "{$_SESSION['tableName']}" . "` (`ID`, `Name`, `Text`, `Date`) VALUES (NULL, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "sss",$_SESSION['rowRef']['Name'], $_POST['chatTextArea'], $currentDate);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
    }
    catch (mysqli_sql_exception)
    {
        //add Date column to existing table

        $sql = "ALTER TABLE `{$_SESSION['tableName']}` ADD `Date` VARCHAR(255) NOT NULL AFTER `Text`";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $currentDate = date('Y-m-d H:i:s', time() + 60 *60 *2 );

        $sql = "INSERT INTO `" . "{$_SESSION['tableName']}" . "` (`ID`, `Name`, `Text`, `Date`) VALUES (NULL, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "sss",$_SESSION['rowRef']['Name'], $_POST['chatTextArea'], $currentDate);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

    }
}

include "userPageParts/EditProfileInputFieldsProcessing.php";

//просто вывод инфы
echo "bEditProfile:";
echo ($_SESSION['bEditProfile']) ? 'true' : 'false';
echo "<br> bShowTable:";
echo ($_SESSION['bShowTable']) ? 'true' : 'false';
echo "<br> bShowChat:";
echo ($_SESSION['bShowChat']) ? 'true' : 'false';
echo "<br><br><br>";

//при нажатии на логаут меняем страничку
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logoutbutton']))
{
    header('Location: login');
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
<div class="my div" style='margin-left: +15%;'>
    <img src="<?php echo $_SESSION['rowRef']['PhotoRef']; ?>" style="width: 100px; height: 100px;">

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