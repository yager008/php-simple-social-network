<?php

include("mysql.php");

ob_start();

session_start();

$sql = "SELECT * FROM `users`";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<br><br>";

    echo "<div style='display: flex; flex-direction: row; justify-items: center; flex-wrap: wrap; max-width: 600px'>"; // Opening the container div here

    while ($row = mysqli_fetch_assoc($result)) {
        //div для фото и надписей
        echo "<div style='display: flex; flex-direction: row; width: 125px; align-items: center; border: 2px solid #cd1919; padding: 10px; margin-bottom: 30px; margin-left: 10px; background-color: #f0f0f0;'>";

        echo "<div style='padding-right: 10px; padding-left: 1px;'>";
        echo "<img src='" . $row['PhotoRef'] . "' style='width: 50px; height: 50px;'>";
        echo "</div>";

        echo "<div style='margin-top: 10px;'>"; // Adjust margin as needed
        echo "<p>{$row['Name']}</p>";
        echo "<p>{$row['Password']}</p>";
        echo "</div>";
        echo "</div>";
    }

    echo "</div>"; // Closing the container div here
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['indexPageButton'])) {
    header('Location: loginpage.php');
    exit();
}

ob_end_flush();
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

<form method="post">
    <button name="indexPageButton">go to index page</button>
</form>

</body>
</html>
