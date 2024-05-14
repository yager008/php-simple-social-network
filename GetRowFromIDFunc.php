<?php

//Updates $_SESSION['rowRef'] with ID
function GetRowFromID ($conn , $rowID) : array | null
{
    $sql = "SELECT * FROM `users` WHERE ID= ? ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $rowID);

    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the row as an associative array
    $row = mysqli_fetch_assoc($result);
    if ($row !== false) {
        $_SESSION["rowRef"] = $row;
    } else {
        // Handle error if no row found
        $_SESSION["rowRef"] = [];
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    // Return the row
    return $row;
}
