<?php
//include_once "Functions/BigNumberGenerator.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['nameText']))
{
    $sql = "UPDATE `users` SET Name=? WHERE ID=?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "si", $_POST['nameText'], $_SESSION['rowRef']['ID']);

    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0)
    {
    $_SESSION['nameBuffer'] = $_POST['nameText'];
    }
    else
    {
    echo "name update failed.";
    }
    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['surnameText']))
{
    $sql = "UPDATE `users` SET Surname=? WHERE ID=?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "si", $_POST['surnameText'], $_SESSION['rowRef']['ID']);

    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0)
    {
    $_SESSION['surnameBuffer'] = $_POST['surnameText'];
    }
    else
    {
    echo "surname update failed";
    }
    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['aboutMeText']))
{
    $sql = "UPDATE `users` SET AboutMe=? WHERE ID=?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "si", $_POST['aboutMeText'], $_SESSION['rowRef']['ID']);

    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0)
    {
    $_SESSION['aboutMeBuffer'] = $_POST['aboutMeText'];
    }
    else
    {
    echo "about me update failed.";
    }
    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['fileInput']) && $_FILES['fileInput']['size'] > 0)
{
    $sql = "UPDATE `users` SET PhotoRef=? WHERE ID=?";

    $stmt = mysqli_prepare($conn, $sql);

    $fileName = $_FILES['fileInput']['name'];

    $fileTmpName = $_FILES['fileInput']['tmp_name'];

    $folder = 'avatars/avatar' . $_SESSION['rowRef']['ID'];

    echo "new file location: " . $folder . "<br>";

    //delete previous file
    unlink($folder);

    if(!move_uploaded_file($fileTmpName, $folder))
    {
    echo "file upload error";
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "si", $folder,$_SESSION['rowRef']['ID']);

        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0)
        {
            $_SESSION['aboutMeBuffer'] = $_POST['aboutMeText'];
        }
        else
        {
        echo "file update failed.";
        }
    }
    mysqli_stmt_close($stmt);
}
