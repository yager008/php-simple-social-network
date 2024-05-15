<?php

//chatWithUserButton
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['chatWithUserButton']))
{
    $_SESSION['bEditProfile'] = false;
    $_SESSION['bShowTable'] = false;
    $_SESSION['bShowChat'] = true;
    $_SESSION['IDofChatter'] = $_POST['chatWithUserButton'];
    $_SESSION['chatterRowRef'] = GetRowFromID($conn, $_POST['chatWithUserButton']);

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
