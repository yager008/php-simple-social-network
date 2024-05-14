<?php

//Updates value in $_SESSION['rowRef'] with up-to-date info using $_SESSION['rowRef']['ID']
function UpdateRowRef($conn): void
{
    $sql = "SELECT * FROM `users` WHERE ID=?";

    $stmt = mysqli_prepare($conn, $sql);

    if (isset($_SESSION['rowRef']) && is_array($_SESSION['rowRef']))
    {
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['rowRef']['ID']);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result))
        {
            $_SESSION["rowRef"] = $row;
        }
        else
        {
            $_SESSION["rowRef"] = [];
        }
    }
    else
    {
        $_SESSION["rowRef"] = [];
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
