<br> <br>
<form method="POST">
    <button name="showTableButton">show table of users</button>
</form>

<!--<p>ID of chatter: --><?php //echo $_SESSION['chatterRowRef']['ID']?><!--</p>-->

<p>Name of chatter: <?php echo $_SESSION['chatterRowRef']['Name']?></p>
<img src=<?php echo $_SESSION['chatterRowRef']['PhotoRef'] ?> style="width: 100px">
<br><br>

<?php
    try
    {

        // echo "<br><br> tableName: {$_SESSION['tableName']}<br><br>";

        $sql = "SELECT * FROM `{$_SESSION['tableName']}`";
        $result = mysqli_query($conn, $sql);
?>

<form method ='POST'>
    <?php
        if (mysqli_num_rows($result) > 0)
        {
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
</form>
