<form method="post">
    <button name="editProfileButton">edit profile</button>
    <button name="logoutbutton">logout</button> <br>
</form>
</div>

<?php
time();
echo "<form method ='POST'>";
if (mysqli_num_rows($result) > 0)
{
    echo "<br><br>";
    echo "<div style='display: flex; flex-direction: row; justify-items: center; flex-wrap: wrap; max-width: 600px'>"; // Opening the container div here
    while ($row = mysqli_fetch_assoc($result))
    {
        ?>
        <div style='display: flex; flex-direction: row; width: 125px; align-items: center; border: 2px solid #8880ff; padding: 10px; margin-bottom: 30px; margin-left: 10px; background-color: #f0f0f0;'>
            <div style='padding-right: 10px; padding-left: 1px;'>
        <?php
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
    echo "</div>";
}
echo "</form>";
