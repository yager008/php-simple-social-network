<?php
include "mysql.php";
include_once "UpdateRowRefFunc.php";
include_once "GetRowFromIDFunc.php";

session_start();

UpdateRowRef($conn);

$_SESSION['nameBuffer'] = $_SESSION['rowRef']['Name'];
$_SESSION['surnameBuffer'] = $_SESSION['rowRef']['Surname'];
$_SESSION['aboutMeBuffer'] = $_SESSION['rowRef']['AboutMe'];

if (!isset($_SESSION['bShowChat'])) {
    $_SESSION['bShowChat'] = false;
}

if (!isset($_SESSION['IDofChatter'])) {
    $_SESSION['IDofChatter'] = 0;
}

if (!isset($_SESSION['tableName'])) {
    $_SESSION['tableName'] = null;
}

if (!isset($_SESSION['chatterRowRef'])) {
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editButton']))
{
    $_SESSION['bEditProfile'] = !$_SESSION['bEditProfile'];
    $_SESSION['bShowTable'] = false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitButton']))
{
    $_SESSION['bEditProfile'] = !$_SESSION['bEditProfile'];
    $_SESSION['bShowTable'] = true;
}
echo "current id: {$_SESSION['rowRef']['ID']} <br>";

//если нажимаем на switchButton то bShowTable = true
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['switchButton'])) {
    $_SESSION['bShowTable'] = true;
    $_SESSION['bShowChat'] = false;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buttonID'])) {
//    echo "<script>window.alert('" . $_POST['buttonID'] . "');</script>";
    $_SESSION['bEditProfile'] = false;
    $_SESSION['bShowTable'] = false;
    $_SESSION['bShowChat'] = true;
    $_SESSION['IDofChatter'] = $_POST['buttonID'];
    $_SESSION['chatterRowRef'] = GetRowFromID($conn, $_POST['buttonID']);

    $id1 = $_SESSION['chatterRowRef']['ID'];
    $id2 = $_SESSION['rowRef']['ID'];

    if ($id1 >= $id2) {
        $temp = $id1;
        $id1 = $id2;
        $id2 = $temp;
    }

    $_SESSION['tableName'] = 'id' . "{$id1}" . 'id' . "{$id2}";

    $sql = "
        CREATE TABLE IF NOT EXISTS `{$_SESSION['tableName']}` (
          `ID` int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `Name` varchar(255) NOT NULL,
          `Text` varchar(255) NOT NULL,
          `Date` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ";

    $stmt = mysqli_prepare($conn, $sql);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['chatTextArea'])) {

    echo "<br> text from chatTextArea: {$_POST['chatTextArea']} <br><br>";

    try
    {
        $currentDate = date('Y-m-d H:i:s', time() + 60 *60 *2 );

        $sql = "INSERT INTO `" . "{$_SESSION['tableName']}" . "` (`ID`, `Name`, `Text`, `Date`) VALUES (NULL, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "sss",$_SESSION['rowRef']['Name'], $_POST['chatTextArea'], $currentDate);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
    }
    catch (mysqli_sql_exception)
    {
        //add Date column to existing table
        $sql = "ALTER TABLE `{$_SESSION['tableName']}` ADD `Date` VARCHAR(255) NOT NULL AFTER `Text`";
        $stmt = mysqli_prepare($conn, $sql);
        // Execute the statement
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $currentDate = date('Y-m-d H:i:s', time() + 60 *60 *2 );

        $sql = "INSERT INTO `" . "{$_SESSION['tableName']}" . "` (`ID`, `Name`, `Text`, `Date`) VALUES (NULL, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "sss",$_SESSION['rowRef']['Name'], $_POST['chatTextArea'], $currentDate);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['nameText'])) {
    // Prepare the SQL statement
    $sql = "UPDATE `users` SET Name=? WHERE ID=?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "si", $_POST['nameText'], $_SESSION['rowRef']['ID']);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $_SESSION['nameBuffer'] = $_POST['nameText'];
    } else {
        // Handle error if the update failed
        echo "name update failed.";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['surnameText'])) {
    // Prepare the SQL statement
    $sql = "UPDATE `users` SET Surname=? WHERE ID=?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "si", $_POST['surnameText'], $_SESSION['rowRef']['ID']);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if (mysqli_stmt_affected_rows($stmt) > 0)
    {
        $_SESSION['surnameBuffer'] = $_POST['surnameText'];
    }
    else
    {
        // Handle error if the update failed
        echo "surname update failed";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['aboutMeText'])) {
    // Prepare the SQL statement
    $sql = "UPDATE `users` SET AboutMe=? WHERE ID=?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "si", $_POST['aboutMeText'], $_SESSION['rowRef']['ID']);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $_SESSION['aboutMeBuffer'] = $_POST['aboutMeText'];
    } else {
        // Handle error if the update failed
        echo "Update failed.";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['aboutMeText'])) {
    // Prepare the SQL statement
    $sql = "UPDATE `users` SET AboutMe=? WHERE ID=?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "si", $_POST['aboutMeText'], $_SESSION['rowRef']['ID']);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $_SESSION['aboutMeBuffer'] = $_POST['aboutMeText'];
    } else {
        // Handle error if the update failed
        echo "about me update failed.";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['fileInput']) && $_FILES['fileInput']['size'] > 0)
{
    // Prepare the SQL statement
    $sql = "UPDATE `users` SET PhotoRef=? WHERE ID=?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    $fileName = $_FILES['fileInput']['name'];
    $fileTmpName = $_FILES['fileInput']['tmp_name'];

    $folder = 'avatars/' . $fileName;
    echo "new file location: " . $folder . "<br>";

    if(!move_uploaded_file($fileTmpName, $folder))
    {
        echo "file upload error";
    }
    else {
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "si", $folder,$_SESSION['rowRef']['ID']);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Check if the update was successful
        if (mysqli_stmt_affected_rows($stmt) > 0)
        {
            $_SESSION['aboutMeBuffer'] = $_POST['aboutMeText'];
        }
        else
        {
            // Handle error if the update failed
            echo "file update failed.";
        }
    }
    mysqli_stmt_close($stmt);
}



echo "bEditProfile:";
echo ($_SESSION['bEditProfile']) ? 'true' : 'false';
echo "<br> bShowTable:";
echo ($_SESSION['bShowTable']) ? 'true' : 'false';
echo "<br> bShowChat:";
echo ($_SESSION['bShowChat']) ? 'true' : 'false';
echo "<br><br><br>";

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

    <?php if($_SESSION['bEditProfile']) { ?>
    <form method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>NameText:</td>
                <td><input type="text" name="nameText" id="nameText" placeholder="<?php echo $_SESSION['nameBuffer']?>"></td>
            </tr>
            <tr>
                <td>SurnameText: </td>
                <td><input type="text" name="surnameText" id="surnameText" placeholder="<?php echo $_SESSION['surnameBuffer']?>" ></td>
            </tr>
            <tr>
                <td>About me text: </td>
                <td><textarea  style="resize: none" name="aboutMeText" id="aboutMeText" placeholder="<?php echo $_SESSION['aboutMeBuffer']?>"></textarea></td>
            </tr>
            <tr>
                <td>File input: </td>
                <td><input type="file" name="fileInput" id="fileInput"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submitButton"></td>
            </tr>
        </table>
    </form>

    <?php } else { ?>
    <div>
        name: <?php echo $_SESSION['nameBuffer']; ?>
    </div>
    <div>
        surname: <?php echo $_SESSION['surnameBuffer']; ?>
    </div>
    <div>
        about me: <?php echo $_SESSION['aboutMeBuffer']; ?>
    </div>
    <?php } ?>



<?php
$sql = "SELECT * FROM `users`";
$result = mysqli_query($conn, $sql);

if($_SESSION['bShowTable']) {
    ?>
    <form method="post">
        <button name="editButton">edit profile</button>
        <button name="logoutbutton">logout</button> <br>
    </form>
</div>

    <?php
    time();
    echo "<form method ='POST'>";
    if (mysqli_num_rows($result) > 0) {
        echo "<br><br>";

        echo "<div style='display: flex; flex-direction: row; justify-items: center; flex-wrap: wrap; max-width: 600px'>"; // Opening the container div here


        while ($row = mysqli_fetch_assoc($result)) {
                //div для фото и надписей
                echo "<div style='display: flex; flex-direction: row; width: 125px; align-items: center; border: 2px solid #8880ff; padding: 10px; margin-bottom: 30px; margin-left: 10px; background-color: #f0f0f0;'>";

                echo "<div style='padding-right: 10px; padding-left: 1px;'>";
                echo "<img src='" . $row['PhotoRef'] . "' style='width: 50px; height: 50px;'>";
                echo "</div>";
                echo "<div style='margin-top: 10px;'>"; // Adjust margin as needed
                echo "<p>{$row['Name']}</p>";
                echo "<p>{$row['AboutMe']}</p>";
                echo "<p>ID: {$row['ID']}</p>";
                echo
                "
                <button name='buttonID' value='{$row['ID']}'> press me </button>
                ";
                echo "<br>";
                echo "</div>";
                echo "</div>";
            }
        echo "</div>"; // Closing the container div here
    }
    echo "</form>";
}
//else //bShowTable = false start
if ($_SESSION['bShowChat'])
{
    ?>

    <form method="POST">
    <button name="switchButton">show table of users</button>
    </form>

    <p>ID of chatter: <?php echo $_SESSION['chatterRowRef']['ID']?></p>
    <p>Name of chatter: <?php echo $_SESSION['chatterRowRef']['Name']?></p>
    <img src=<?php echo $_SESSION['chatterRowRef']['PhotoRef'] ?> style="width: 100px">
    <br><br>
    <?php

    try
    {
        echo "<br><br> tableName: {$_SESSION['tableName']}<br><br>";
        $sql = "SELECT * FROM `{$_SESSION['tableName']}`";

        $result = mysqli_query($conn, $sql);

        echo "<form method ='POST'>";
        if (mysqli_num_rows($result) > 0) {

            $currentUserName = null;
            $prevUserName = null;
            $bSameUser = false;

            ?>
            <table style="margin-left: -60%">
            <?php
            while ($row = mysqli_fetch_assoc($result))
            {
                $currentUserName= $row['Name'];

                if (isset($prevUserName) && $currentUserName == $prevUserName)
                {
                    $bSameUser = true;
                }
                else
                {
                    $bSameUser = false;
                }

            ?>
                        <?php
                        if (!$bSameUser)
                        {
                        ?>
                            <tr>
                            <td>
                        <?php
                            if(isset($row['Date']))
                            {
                                echo "{$row['Date']} ";
                            }
                        ?>
                            <?php echo "{$row['Name']}:"?>
                            </td>
                            <td>
                            <?php echo " {$row['Text']}"?>
                            </td>
                            </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                            <tr>
                                <td></td>
                                <td>
                                    <?php echo "{$row['Text']}"?>
                                </td>
                            </tr>
                        <?php
                        }
                $prevUserName=$currentUserName;
            }
            ?>
            </table>
                <?php
                    }
                }
                catch(mysqli_sql_exception)
                {
                    echo "table does not exist yet";
                }
                ?>
    <br>
    <textarea name="chatTextArea" style="resize: none" ></textarea><br><br>
    <input type="submit">
    <?php
    echo "</form>";
    }
    ?>
</body>
</html>