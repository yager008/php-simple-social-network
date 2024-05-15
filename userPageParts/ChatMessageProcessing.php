<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['chatTextArea']))
{
//    echo "<br> text from chatTextArea: {$_POST['chatTextArea']} <br><br>";

    try
    {
    $currentDate = date('Y-m-d H:i', time() + 60 *60 *2 );

    $sql = "INSERT INTO `" . "{$_SESSION['tableName']}" . "` (`Name`, `Text`, `Date`) VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "sss",$_SESSION['rowRef']['Name'], $_POST['chatTextArea'], $currentDate);

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    }
    catch (mysqli_sql_exception)
    {
    $sql = "ALTER TABLE `{$_SESSION['tableName']}` ADD `Date` VARCHAR(255) NOT NULL AFTER `Text`";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    $currentDate = date('Y-m-d H:i:s', time() + 60 *60 *2 );

    $sql = "INSERT INTO `" . "{$_SESSION['tableName']}" . "` (`Name`, `Text`, `Date`) VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "sss",$_SESSION['rowRef']['Name'], $_POST['chatTextArea'], $currentDate);

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    }
}
